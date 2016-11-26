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
        // Tính toán và push notify realtime về client
        console.log(data);
        if(data.deviceid.length>0){
            var type = data.type;
            if(type==null || type==undefined){}
            else if(type.toUpperCase()=="BP") io.sockets.in(data.deviceid).emit("BP",{highpressure:data.highpressure,lowpressure:data.lowpressure,heartrate:data.heartrate});
            else if(type.toUpperCase()=="TEMP") io.sockets.in(data.deviceid).emit("TEMP",data.temp);
            else if(type.toUpperCase()=="SPO2") io.sockets.in(data.deviceid).emit("SPO2",{heartrate:data.heartrate,oxygen:data.oxygen});
            else if(type.toUpperCase()=="POS") io.sockets.in(data.deviceid).emit("POS",{la:data.lat,lo:data.lo});
        }
        io.sockets.emit("monitor",data);
    });
});