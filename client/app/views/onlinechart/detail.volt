<a href="index">Back</a>

<div class="panel">
    <div class="panel-heading">
        <h4>GEO + Temperature</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-6">
                <style>
                    #map {
                        height: 400px;
                    }
                </style>

                <div id="map"></div>
            </div>
            <div class="col-sm-6">
                <div id="real-time">
                    <div id="temporary_chart" class="f-c-space">
                    </div>
                </div>
                <a onclick="return confirm('Are you sure ?')" href="delete?type=temp&deviceid={{ deviceid }}" class="btn btn-danger">Reset</a>
            </div>

        </div>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        <h4>Pressure</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-6">
                <div id="real-time">
                    <div id="pressure_hight_chart" class="f-c-space">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="real-time">
                    <div id="pressure_heartbeat_chart" class="f-c-space">
                    </div>
                </div>
            </div>
            <a onclick="return confirm('Are you sure ?')" href="delete?type=bp&deviceid={{ deviceid }}" class="btn btn-danger">Reset</a>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h4>Oxygen</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            {#<div class="col-sm-6">
                <div id="real-time">
                    <div id="oxygen_heartrate_chart" class="f-c-space">
                    </div>
                </div>
            </div>#}
            <div class="col-sm-12">
                <div id="real-time">
                    <div id="oxygen_oxy_chart" class="f-c-space">
                    </div>
                </div>
            </div>
            <a onclick="return confirm('Are you sure ?')" href="delete?type=spo2&deviceid={{ deviceid }}" class="btn btn-danger">Reset</a>
        </div>
    </div>
</div>

<!--flot chart -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="{{ config.socket_path }}/socket.io/socket.io.js"></script>

<script>
    var myLatLng = {lat: 21.030474, lng:105.782922};
    var marker = map = null;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
        });

        marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Your Position'
        });
    }

    $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        var socket = io('{{ config.socket_path }}',{query:"device={{ deviceid }}"});
        socket.on("POS", function (res) {
            marker.setPosition(new google.maps.LatLng(res.la, res.lo));
            map.setCenter(marker.getPosition());
        });
        $('#temporary_chart').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        socket.on('TEMP', function (msg) {
                            var x = Date.now(); // current time
                            series.addPoint([x, parseFloat(msg)], true, true);
                            console.log(parseFloat(msg));
                        });
                    }
                }
            },
            title: {
                text: 'Temperature'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 100,
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +  new Date(this.x)+ '<br/>'+
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Temperature Data',
                data: (function () {
                    // generate an array of random data
                    var data = [];
                    {% for index,item in temp %}
                    data.push({
                        x: new Date({{ item["dint"]*1000 }}),
                        y: {{ item["value"] }}
                    });
                    {% endfor %}
                    return data;
                }())
            }]
        });

        $('#pressure_hight_chart').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        // set up the updating of the chart each second
                        var series_hight = this.series[0];
                        var series_low = this.series[1];
                        socket.on('BP', function (msg) {
                            var x = Date.now(); // current time
                            series_hight.addPoint([x, parseInt(msg.highpressure)], true, true);
                            series_low.addPoint([x, parseInt(msg.lowpressure)], true, true);
                        });
                    }
                }
            },
            title: {
                text: 'Pressure'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            new Date(this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Hight',
                color:"#F70F0F",
                data: (function () {
                    // generate an array of random data
                    var data = [];
                    {% for index,item in bp %}
                    data.push({
                        x: new Date({{ item["dint"]*1000 }}),
                        y: {{ item["value_hight"] }}
                    });
                    {% endfor %}
                    return data;
                }())
            },
                {
                    name: 'Low',
                    color:"#43CC63",
                    data: (function () {
                        // generate an array of random data
                        var data = [];
                        {% for index,item in bp %}
                        data.push({
                            x: new Date({{ item["dint"]*1000 }}),
                            y: {{ item["value_low"] }}
                        });
                        {% endfor %}
                        return data;
                    }())
                }
            ]
        });
        $('#pressure_heartbeat_chart').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        socket.on('BP', function (msg) {
                            var x = Date.now(); // current time
                            series.addPoint([x, parseInt(msg.heartrate)], true, true);
                        });
                    }
                }
            },
            title: {
                text: 'HeartBeat'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            new Date(this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Hight',
                color:"#F70F0F",
                data: (function () {
                    // generate an array of random data
                    var data = [];
                    {% for index,item in bp %}
                    data.push({
                        x: new Date({{ item["dint"]*1000 }}),
                        y: {{ item["value_heart"] }}
                    });
                    {% endfor %}
                    return data;
                }())
            }]
        });

       /* $('#oxygen_heartrate_chart').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        socket.on('SPO2', function (msg) {
                            var x = (new Date()).getTime(); // current time
                            series.addPoint([x, parseInt(msg.heartrate)], true, true);
                        });
                    }
                }
            },
            title: {
                text: 'Heart Beat'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Random data',
                color:"#F70F0F",
                data: (function () {
                    // generate an array of random data
                    var data = [],
                            time = (new Date()).getTime(),
                            i;

                    for (i = -19; i <= 0; i += 1) {
                        data.push({
                            x: time + i * 1000,
                            y: 0
                        });
                    }
                    return data;
                }())
            }]
        });*/
        $('#oxygen_oxy_chart').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        socket.on('SPO2', function (msg) {
                            var x = Date.now(); // current time
                            series.addPoint([x, parseInt(msg.oxygen)], true, true);
                        });
                    }
                }
            },
            title: {
                text: 'Oxygen'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            new Date(this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Oxygen Data',
                color:"#165FFA",
                data: (function () {
                    // generate an array of random data
                    var data = [];
                    {% for index,item in oxygen %}
                    data.push({
                        x: new Date({{ item["dint"]*1000 }}),
                        y: {{ item["value"] }}
                    });
                    {% endfor %}
                    return data;
                }())
            }]
        });
    });
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZoB9-U5PQwS2we5vf_95S1McDaxNLSlE&callback=initMap">
</script>