var io = require('socket.io')(3000); // Create 
var redis = require('socket.io-redis');
io.adapter(redis({ host: 'localhost', port: 6379 }));
console.log("Server listening on 3000");

io.sockets.on('connection', function (socket) {
    var deviceid = "123";
    socket.join(deviceid);

    io.sockets.in(deviceid).emit('heartbeat', 'what is going on, party people?');

    socket.on('alertfromdevice', function (data) {
        console.log(data);
    });


});