<div class="panel">
    <div class="panel-heading">
        <h4>Online chart</h4>
    </div>
    <div class="panel-body">

        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    Realtime Statistics
                                <span class="tools pull-right">
                                    <a class="fa fa-repeat box-refresh" href="javascript:;"></a>
                                    <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                    <a class="t-close fa fa-times" href="javascript:;"></a>
                                </span>
                </header>
                <div class="panel-body">
                    <div id="real-time">
                        <div id="real-time-container" class="f-c-space">
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</div>
<!--flot chart -->
<script src="/js/flot-chart/jquery.flot.js"></script>
<script src="/js/flot-chart/jquery.flot.resize.js"></script>
<script src="/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="/js/flot-chart/jquery.flot.pie.js"></script>
<script src="/js/flot-chart/jquery.flot.selection.js"></script>
<script src="/js/flot-chart/jquery.flot.stack.js"></script>
<script src="/js/flot-chart/jquery.flot.crosshair.js"></script>
<!--flot initialization-->
<script>
    var data7_1 = [
        [1000000, 53],
        [2000000, 125],
        [3000000, 98],
        [4000000, 283],
        [5000000, 320],
        [6000000, 420],
        [7000000, 236]
    ];
    var data7_2 = [
        [1000000, 43],
        [2000000, 150],
        [3000000, 80],
        [4000000, 283],
        [5000000, 98],
        [6000000, 125],
        [7000000, 50]
    ];

    $(function () {
        var data1 = [];
        var totalPoints = 300;
        function GetData() {
            var result = [10,10,10];
            return result;
        }

        var updateInterval = 100;
        var plot = $.plot($("#real-time #real-time-container"), [
            GetData()], {
            series: {
                lines: {
                    show: true,
                    fill: true
                },
                shadowSize: 0
            },
            yaxis: {
                min: 0,
                max: 100,
                ticks: 10
            },
            xaxis: {
                show: false
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#f9f9f9",
                borderWidth: 1,
                borderColor: "#eeeeee"
            },
            colors: ["#d7d7d7"],
            tooltip: true,
            tooltipOpts: {
                defaultTheme: false
            }
        });

        function update() {
            plot.setData([GetData()]);
            plot.draw();
            setTimeout(update, updateInterval);
        }

        update();
    });
</script>
