/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 18-05-2016
 */
var io = require('socket.io')(2999); // import socket.io with listen port at 3000
var redis = require('socket.io-redis'); // import socket.io-redis to save socket into redis server for Loadbalancing Request
io.adapter(redis({ host: 'localhost', port: 6379 })); // Config socket.io connect to redis port
console.log("Socket listening on 2999"); // print welcome message
io.sockets.on('connection', function (socket) { // Listen action from client
    var handshakeData = socket.request;
    var query = handshakeData._query;
    if(query.device!=null && query.device != undefined) socket.join(query.device);
});

io.on('connection', function (socket) {
    socket.on('gateway_send', function (data, fn) {
        var str = data.toString();
        var arr = str.split(",");
        var time = arr[0];
        var deviceid = arr[1];
        // Tính toán và push notify realtime về client
        if(deviceid.length>0){
            var type = arr[2];
            if(type==null || type==undefined){}
            else{
                if(type.toUpperCase()=="BP"){
                    var highpressure = arr[3];
                    var lowpressure = arr[4];
                    var heartrate  = arr[5];
                    io.sockets.in(deviceid).emit("BP",{highpressure:highpressure,lowpressure:lowpressure,heartrate:heartrate});
                }
                else if(type.toUpperCase()=="TEMP"){
                    var temp = arr[3];
                    io.sockets.in(deviceid).emit("TEMP",temp);
                }
                else if(type.toUpperCase()=="SPO2"){
                    var heartrate = arr[3];
                    var oxygen = arr[4];
                    io.sockets.in(deviceid).emit("SPO2",{heartrate:heartrate,oxygen:oxygen});
                }
                else if(type.toUpperCase()=="POS"){
                    var lat = arr[3];
                    var lo = arr[4];
                    io.sockets.in(deviceid).emit("POS",{la:lat,lo:lo});
                }
            }
        }

        io.sockets.emit("monitor",str);
    });
});