<a href="index">Back</a>

<div class="panel">
    <div class="panel-heading">
        <h4>Temporature Statics</h4>
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
            <div class="col-sm-12">
                <div id="real-time">
                    <div id="pressure_hight_chart" class="f-c-space">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--flot chart -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    $(function () {
        $(document).ready(function () {
            var speed = 1000;
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            // pressure
            var hight = [
                {% for index,item in bp %}
                {% if index >15 %}
                {x: getTime('{{ item[0] }}'), y:{{ item[1] }}},
                {% endif %}
                {% endfor %}
            ];
            var low = [
                {% for index,item in bp %}
                {% if index >15 %}
                {x: getTime('{{ item[0] }}'), y:{{ item[2] }}},
                {% endif %}
                {% endfor %}
            ];
            var heartbeat_bp = [
                {% for index,item in bp %}
                {% if index >15 %}
                {x: getTime('{{ item[0] }}'), y:{{ item[3] }}},
                {% endif %}
                {% endfor %}
            ];
            // temp
            var temp = [
                {% for index,item in temp %}
                {% if index >15 %}
                {x: getTime('{{ item[0] }}'), y:{{ item[3] }}},
                {% endif %}
                {% endfor %}
            ];

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
                            var series_heartbeat = this.series[2];
                            var i = 0;
                            setInterval(function () {
                                //console.log([new Date().getTime(), hight[i].y]);
                                if (hight[i] != undefined) {
                                    series_hight.addPoint([hight[i].x, hight[i].y], true, true);
                                    series_low.addPoint([low[i].x, low[i].y], true, true);
                                    series_heartbeat.addPoint([heartbeat_bp[i].x, heartbeat_bp[i].y], true, true);
                                    ++i;
                                }
                            }, speed);
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
                                Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                series: [
                    {
                        name: 'Hight',
                        color: "#F70F0F",
                        data: (function () {
                            var data = [];
                            {% for index,item in bp %}
                            {% if index<=15 %}
                            data.push({
                                x: getTime('{{ item['0'] }}'),
                                y: {{ item['1'] }}
                            });
                            {% endif %}
                            {% endfor %}
                            return data;
                        }())
                    },
                    {
                        name: 'Low',
                        color: "#43CC63",
                        data: (function () {
                            // generate an array of random data
                            var data = [];
                            {% for index,item in bp %}
                            {% if index<=15 %}
                            data.push({
                                x: getTime('{{ item['0'] }}'),
                                y: {{ item['2'] }}
                            });
                            {% endif %}
                            {% endfor %}
                            return data;
                        }())
                    },
                    {
                        name: 'Hearbeat',
                        color: "blue",
                        data: (function () {
                            // generate an array of random data
                            var data = [];
                            {% for index,item in bp %}
                            {% if index<=15 %}
                            data.push({
                                x: getTime('{{ item['0'] }}'),
                                y: {{ item['3'] }}
                            });
                            {% endif %}
                            {% endfor %}
                            return data;
                        }())
                    }
                ]
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
                            var i = 0;
                            setInterval(function () {
                                //console.log([new Date().getTime(), hight[i].y]);
                                if (temp[i] != undefined) {
                                    series.addPoint([temp[i].x, temp[i].y], true, true);
                                    ++i;
                                }
                            }, speed);
                        }
                    }
                },
                title: {
                    text: 'Temporature'
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
                                Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                series: [
                    {
                        name: 'TEMP',
                        color: "#F70F0F",
                        data: (function () {
                            var data = [];
                            {% for index,item in temp %}
                            {% if index<=15 %}
                            data.push({
                                x: getTime('{{ item['0'] }}'),
                                y: {{ item['1'] }}
                            });
                            {% endif %}
                            {% endfor %}
                            return data;
                        }())
                    }]
            });
        });
        function getTime(strDate) {
            var datum = Date.parse(strDate);
            return datum / 1000;
        }
    });
</script>


