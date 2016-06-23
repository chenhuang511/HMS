<div class="panel">
    <div class="panel-heading">
        <h4>Online chart</h4>
    </div>
    <div class="panel-body">

        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    List Device
                </header>
                <div class="panel-body">
                    <ul>
                        {% for item in listdevice %}
                        <li><a href="detail?id={{ item.Device.deviceid }}">{{ item.name }}</a></li>
                        {% endfor %}
                    </ul>
                </div>
            </section>
        </div>

    </div>

</div>