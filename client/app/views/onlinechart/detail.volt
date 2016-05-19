<a href="index">Back</a>
<div class="panel">
    <div class="panel-heading">
        <h4>Temporary Statics</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div id="real-time">
                <div id="temporary_chart" class="f-c-space">
                </div>
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
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h4>Oxygen</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-6">
                <div id="real-time">
                    <div id="oxygen_heartrate_chart" class="f-c-space">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="real-time">
                    <div id="oxygen_oxy_chart" class="f-c-space">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--flot chart -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://10.0.0.254:2999/socket.io/socket.io.js"></script>

<script>

    $(function () {
        $(document).ready(function () {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            var socket = io('http://10.0.0.254:2999',{query:"device={{ deviceid }}"});

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
                                var x = (new Date()).getTime(); // current time
                                series.addPoint([x, parseInt(msg)], true, true);
                            });
                        }
                    }
                },
                title: {
                    text: 'Temporary'
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
                                var x = (new Date()).getTime(); // current time
                                series_hight.addPoint([x, parseInt(msg.highpressure)], true, true);
                                series_low.addPoint([x, parseInt(msg.lowpressure)], true, true);
                            });
                        }
                    }
                },
                title: {
                    text: 'highpressure'
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
                    name: 'Hight',
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
                },
                    {
                        name: 'Low',
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
                                var x = (new Date()).getTime(); // current time
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
                    name: 'Hight',
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
            });

            $('#oxygen_heartrate_chart').highcharts({
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
            });
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
                                var x = (new Date()).getTime(); // current time
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
            });
        });
    });
</script>