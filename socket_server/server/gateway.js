/***
 * Server Side using NodeJS and Socket.io
 * Author: Nguyen Hoang Viet
 * Datecreate 17-05-2016
 */
var net = require('net');
var server = net.createServer();
server.listen(3000); // Khởi tạo NET Server. Port 3000
console.log("Gateway listening on 3000"); // Thông báo gateway khởi tạo thành công

var io = require('socket.io-client');
var serverUrl = 'http://localhost:2999';
var conn = io.connect(serverUrl);

var moment = require("moment");
//lets require/import the mongodb native drivers.
var mongodb = require('mongodb');
var MongoClient = mongodb.MongoClient;
var url = 'mongodb://healthcare:123456$@127.0.0.1:27017/healthcare';
var collection = null;
// Use connect method to connect to the Server
MongoClient.connect(url, function (err, db) {
    if (err) {
        console.log('Unable to connect to the mongoDB server. Error:', err);
    } else {

        collection = db.collection('log');
    }
});


server.on('connection', function(client) { // Lắng nghe sự kiện từ các client kết nối
    client.on("data",function (data) { // Nếu client có gửi dữ liệu lên
        var str = data.toString();
        //str =getDateTime()+","+str;
        str = str.replace('\r\n','');
        var arr = str.split(',');
        var object = null;
        if(arr[1].toUpperCase()=="BP"){
            var highpressure = arr[2];
            var lowpressure = arr[3];
            var heartrate  = arr[4];
            object = {deviceid:arr[0],type:arr[1],highpressure:highpressure,lowpressure:lowpressure,heartrate:heartrate,datetime:getDateTime()};
        }
        else if(arr[1].toUpperCase()=="TEMP"){
            var temp = arr[2];
            object = {deviceid:arr[0],type:arr[1],temp:temp,datetime:getDateTime()};
        }
        else if(arr[1].toUpperCase()=="SPO2"){
            var heartrate = arr[2];
            var oxygen = arr[3];
            object = {deviceid:arr[0],type:arr[1],heartrate:heartrate,oxygen:oxygen,datetime:getDateTime()};
        }
        else if(arr[1].toUpperCase()=="POS"){
            var lat = arr[2];
            var lo = arr[3];
            object = {deviceid:arr[0],type:arr[1],lat:lat,lo:lo,datetime:getDateTime()};
        }
        collection.insert([object], function (err, result) {
            if (err)  console.log(err);
            else console.log('Inserted %d documents into the "log" collection. The documents inserted with "_id" are:', result.length, result);
        });
        conn.emit('gateway_send', object, function(resp, d) {});
    });

    client.on('end',function(){ // Nếu client ngắt kết nối. thông báo ra console
        console.log("Reading end");
    });

    client.on('error', function(err){ // nếu phát sinh lỗi. Thông báo ra Console
        console.log("Error: "+err.message);
    })
});

function getDateTime() {
    return Math.floor(Date.now() / 1000);
    /*var date = new Date();
    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;
    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;
    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;
    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;
    return day + '-' + month + '-' + year + " " + hour + ":" + min + ":" + sec;*/
}
