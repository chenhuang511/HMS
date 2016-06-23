<div class="panel">
    <div class="panel-heading">
        <h4>Device</h4>
        <small>List of your device</small>
    </div>
    <div class="panel-body">
        <a href="{{ url("device/form") }}">Add new</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên thiết bị</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            {% for item in listdevice %}
                <tr>
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td><a href="form?id={{ item.id }}">Sửa</a></td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>

</div>