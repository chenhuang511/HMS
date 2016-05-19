/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 17-05-2016
 */
var net = require('net');
var server = net.createServer();
server.listen(3000); // Khởi tạo NET Server. Port 3000
var RedisSMQ = require("rsmq"); // Khởi tạo module redis queue
var rsmq = new RedisSMQ( {host: "127.0.0.1", port: 6379, ns: "rsmq"} ); // Kết nối module redisqueue đến redis
rsmq.createQueue({qname:"healthcare_gateway_queue"}, function (err, resp) { // Khởi tạo queue
    if (resp===1) console.log("queue created")
});
console.log("Gateway listening on 3000"); // Thông báo gateway khởi tạo thành công

var io = require('socket.io')(2999); // import socket.io with listen port at 3000
var redis = require('socket.io-redis'); // import socket.io-redis to save socket into redis server for Loadbalancing Request
io.adapter(redis({ host: 'localhost', port: 6379 })); // Config socket.io connect to redis port
console.log("Socket listening on 2999"); // print welcome message
io.sockets.on('connection', function (socket) { // Listen action from client
    var handshakeData = socket.request;
    var query = handshakeData._query;
    if(query.device!=null && query.device != undefined) socket.join(query.device);
});




server.on('connection', function(client) { // Lắng nghe sự kiện từ các client kết nối
    client.on("data",function (data) { // Nếu client có gửi dữ liệu lên
        rsmq.sendMessage({qname:"healthcare_gateway_queue", message: data.toString()}, function (err, resp) {  // Set dữ liệu vào queue và thông báo thành công
            var str = data.toString();
            var arr = str.split(",");
            var deviceid = arr[0];
            if(deviceid.length>0){
                var type = arr[1];
                if(type==null || type==undefined){}
                else{
                    if(type.toUpperCase()=="BP"){
                        var highpressure = arr[2];
                        var lowpressure = arr[3];
                        var heartrate  = arr[4];
                        console.log(heartrate);
                        io.sockets.in(deviceid).emit("BP",{highpressure:highpressure,lowpressure:lowpressure,heartrate:heartrate});
                    }
                    else if(type.toUpperCase()=="TEMP"){
                        var temp = arr[2];
                        io.sockets.in(deviceid).emit("TEMP",temp);
                    }
                    else if(type.toUpperCase()=="SPO2"){
                        var heartrate = arr[2];
                        var oxygen = arr[3];
                        io.sockets.in(deviceid).emit("SPO2",{heartrate:heartrate,oxygen:oxygen});
                    }
                    io.sockets.emit("monitor",str);
                }
            }

        });
    });

    client.on('end',function(){ // Nếu client ngắt kết nối. thông báo ra console
        console.log("Reading end");
    });

    client.on('error', function(err){ // nếu phát sinh lỗi. Thông báo ra Console
        console.log("Error: "+err.message);
    })
});

