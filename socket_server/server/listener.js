/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 18-05-2016
 */
var io = require('socket.io')(2999); // import socket.io with listen port at 3000
var redis = require('socket.io-redis'); // import socket.io-redis to save socket into redis server for Loadbalancing Request
io.adapter(redis({ host: 'localhost', port: 6379 })); // Config socket.io connect to redis port
console.log("Socket listening on 2999"); // print welcome message

var RedisSMQ = require("rsmq");
var rsmq = new RedisSMQ( {host: "127.0.0.1", port: 6379, ns: "rsmq"} );

io.sockets.on('connection', function (socket) { // Listen action from client
    // Monitor
    setInterval(function () {
        rsmq.popMessage({qname:'healthcare_gateway'},function (err,res) {
            if(res.id != undefined){
                console.log("Received Data > ",res.message);
                io.sockets.emit('respone_from_server', res);
            }
        });
    },1);

});


