<div class="row">
    <div class="col-lg-12">
        <a href="index" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <!--tab nav start-->
        <section class="isolate-tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#skilltest">Import Device By Excel</a>
                </li>
            </ul>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="skilltest" class="tab-pane active">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label>1. <a href="/data/device.xlsx">Download file mẫu</a></label>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-2 control-label">2. Upload File</label>
                                    <div class="col-md-10">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" name="action" value="accept" class="btn btn-info">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!--tab nav start-->

    </div>
</div>
