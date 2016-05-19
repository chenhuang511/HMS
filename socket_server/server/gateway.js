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

server.on('connection', function(client) { // Lắng nghe sự kiện từ các client kết nối
    client.on("data",function (data) { // Nếu client có gửi dữ liệu lên
        rsmq.sendMessage({qname:"healthcare_gateway_queue", message: data.toString()}, function (err, resp) {  // Set dữ liệu vào queue và thông báo thành công
            if (resp) console.log("Message sent Data > ", data.toString());
        });
    });

    client.on('end',function(){ // Nếu client ngắt kết nối. thông báo ra console
        console.log("Reading end");
    });

    client.on('error', function(err){ // nếu phát sinh lỗi. Thông báo ra Console
        console.log("Error: "+err.message);
    })
});

