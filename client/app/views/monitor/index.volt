<style>
    #listdata{background: #474747;color: #fff;max-height: 400px;overflow-y: auto}
</style>
<div class="panel">
    <div class="panel-heading">
        <h4>System Monitor</h4>
        <small>Heartbeat from all device</small>
    </div>
    <div class="panel-body">
        <pre id="listdata">

        </pre>
    </div>

</div>
<script src="http://10.0.0.254:2999/socket.io/socket.io.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script>
    $('#listdata').prepend("Gateway incoming connection !");
    var socket = io('http://10.0.0.254:2999');
    socket.on('monitor', function (msg) {
        var currentdate = new Date();
        var datetime = currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getFullYear() + " "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();
        $('#listdata').prepend("<p>Received "+(datetime)+" > " + msg+"</p>");
    });
</script>