<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Thông tin thiết bị
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="imei">Số IMEI</label>
                        <div class="col-md-10"><input type="text" name="imei" value="{{ object.Device.deviceid }}" class="form-control" id="imei" ></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="simid">Số SIM</label>
                        <div class="col-md-10"><input type="text" name="simid" value="{{ object.Device.sim }}" class="form-control" id="simid"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">Tên</label>
                        <div class="col-md-10"><input type="text" name="name" value="{{ object.name }}" class="form-control" id="name"></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
    </form>
</div>