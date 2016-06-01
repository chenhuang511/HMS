var RedisSMQ = require("rsmq");
var rsmq = new RedisSMQ( {host: "127.0.0.1", port: 6379, ns: "rsmq"} );

var mkdirp = require('mkdirp');
var fs = require('fs');
var log_dir = "D:\\Project\\Teca_pro\\Healthcare\\HMS\\socket_server\\server\\data\\";
setInterval(function () {
    rsmq.popMessage({qname:'healthcare_gateway_queue'},function (err,res) {
        if(res!=undefined && res.id != undefined){
            var str = res.message;
            var arr = str.split(",");
            var time = arr[0];
            var deviceid = arr[1];
            if(deviceid!=null && deviceid != undefined){
                var split_time = time.split(" ");
                var dmy = split_time[0];
                var folderfile = log_dir+dmy+"\\"+deviceid;

                if(deviceid.length>0){
                    var type = arr[2];
                    if(type==null || type==undefined){}
                    else{
                        if(type.toUpperCase()=="BP") writefile(folderfile,"BP.txt",str);
                        else if(type.toUpperCase()=="TEMP") writefile(folderfile,"TEMP.txt",str);
                        else if(type.toUpperCase()=="SPO2") writefile(folderfile,"SPO2.txt",str);
                    }
                }
            }
        }

    });
},200);
function writefile(folderfile,filename,data) {
    var fullpath = folderfile+"\\"+filename;
    mkdirp(folderfile, function (err) {
        fs.exists(fullpath, function (exists) {
            if(!exists) fs.writeFile(fullpath, data+"\r\n", function (err, data){});
            else{
                fs.open(fullpath, 'a', 666, function( e, id ) {
                    fs.write( id, data+"\r\n", null, 'utf8', function(){
                        fs.close(id, function(){
                            console.log('Log > '+data+" has been writed");
                        });
                    });
                });
            }
        });
    });
}