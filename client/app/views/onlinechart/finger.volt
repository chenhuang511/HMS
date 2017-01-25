<div class="panel">
    <div class="panel-heading">
        <h4>Online chart</h4>
    </div>
    <div class="panel-body">

        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    List Finger ID
                </header>
                <div class="panel-body">
                    <ul>
                        {% for item in object.fingers %}
                        <li><a href="detail?id={{ object.deviceid }}&finger={{ item }}">Finger: {{ item }}</a></li>
                        {% endfor %}
                    </ul>
                </div>
            </section>
        </div>

    </div>

</div>