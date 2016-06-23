<div class="panel">
    <div class="panel-heading">
        <h4>Oxygen</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-12">
                <div id="real-time">
                    <div id="oxygen_oxy_chart" class="f-c-space">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(document).ready(function () {
            var speed = 1000;
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            // spo2
            var spo2 = [
                {% for index,item in spo2 %}
                {% if index >15 %}
                {
                    x: new Date({{ item["dint"]*1000 }}),
                    y: {{ item["value"] }}
                },
                {% endif %}
                {% endfor %}
            ];
            $('#oxygen_oxy_chart').highcharts({
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
                                if (spo2[i] != undefined) {
                                    series.addPoint([temp[i].x, temp[i].y], true, true);
                                    ++i;
                                }
                            }, speed);
                        }
                    }
                },
                title: {
                    text: 'Oxygent'
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
                        name: 'Oxygen',
                        color: "#F70F0F",
                        data: (function () {
                            var data = [];
                            {% for index,item in spo2 %}
                            {% if index<=15 %}
                            data.push({
                                x: new Date({{ item["dint"]*1000 }}),
                                y: {{ item["value"] }}
                            });
                            {% endif %}
                            {% endfor %}
                            return data;
                        }())
                    }]
            });
        });
    });
</script>
