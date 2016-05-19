/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 18-05-2016
 */
var RedisSMQ = require("rsmq");
var rsmq = new RedisSMQ( {host: "127.0.0.1", port: 6379, ns: "rsmq"} );

setInterval(function () {
    rsmq.popMessage({qname:'healthcare_gateway_queue'},function (err,res) {
        if(res!=undefined && res.id != undefined){
            console.log("Received Data > ",res.message);
            var str = res.message;
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
                    }
                    else if(type.toUpperCase()=="TEMP"){
                        var temp = arr[2];
                    }
                    else if(type.toUpperCase()=="SPO2"){
                        var heartrate = arr[2];
                        var oxygen = arr[3];
                    }
                }
            }

        }
        
    });
},100);
