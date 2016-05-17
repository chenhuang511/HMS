<a href="<?= $backurl ?>" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> <?= $labelkey['general.lbl_back'] ?></a>
<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    <?= $labelkey['device.info'] ?>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name"><?= $labelkey['device.name'] ?></label>
                        <div class="col-md-10"><input type="text" name="name" value="<?= $object->name ?>" class="form-control" id="name" placeholder="<?= $labelkey['device.name'] ?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="deviceid"><?= $labelkey['device.deviceid'] ?></label>
                        <div class="col-md-10"><input type="text" name="deviceid" value="<?= $object->deviceid ?>" class="form-control" id="deviceid" placeholder="<?= $labelkey['device.deviceid'] ?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="sim"><?= $labelkey['device.sim'] ?></label>
                        <div class="col-md-10"><input type="text" name="sim" value="<?= $object->deviceid ?>" class="form-control" id="sim" placeholder="<?= $labelkey['device.sim'] ?>"></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
    </form>
</div>