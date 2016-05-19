/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 17-05-2016
 */
var net = require('net');
var server = net.createServer();
server.listen(3000);
var RedisSMQ = require("rsmq");
var rsmq = new RedisSMQ( {host: "127.0.0.1", port: 6379, ns: "rsmq"} );
rsmq.createQueue({qname:"healthcare_gateway_queue"}, function (err, resp) {
    if (resp===1) {
        console.log("queue created")
    }
});
console.log("Gateway listening on 3000");
server.on('connection', function(client) {
    client.on("data",function (data) {
        rsmq.sendMessage({qname:"healthcare_gateway_queue", message: data.toString()}, function (err, resp) {
            if (resp) {
                console.log("Message sent Data > ", data.toString());
            }
        });
    });

    client.on('end',function(){
        console.log("Reading end");
    });

    client.on('error', function(err){
        console.log("Error: "+err.message);
    })
});

