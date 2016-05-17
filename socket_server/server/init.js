/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 17-05-2016
 */
var io = require('socket.io')(3000); // import socket.io with listen port at 3000
var redis = require('socket.io-redis'); // import socket.io-redis to save socket into redis server for Loadbalancing Request
io.adapter(redis({ host: 'localhost', port: 6379 })); // Config socket.io connect to redis port
console.log("Server listening on 3000"); // print welcome message

io.sockets.on('connection', function (socket) { // Listen action from client
    var deviceid = "123";
    socket.join(deviceid);

    io.sockets.in(deviceid).emit('heartbeat', 'what is going on, party people?');

    socket.on('alertfromdevice', function (data) {
        console.log(data);
    });


});