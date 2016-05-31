<a href="index">Back</a>
<div class="panel">
    <div class="panel-heading">
        <h4>Choose date</h4>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <form action="{{ url('log/detail') }}" method="get">
                <div class="col-sm-12">
                    <div class="form-group col-sm-3">
                        <label class="col-md-2 control-label" for="date">Device</label>
                        <div class="col-md-10">
                            <select name="device" id="" class="form-control">
                                <option value="D001">D001</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="col-md-3 control-label" for="date">Date</label>
                        <div class="col-md-9"><input type="text" class="form-control form-control-inline input-medium default-date-picker" value="" name="date"/></div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="col-md-3 control-label" for="date">Start hour</label>
                        <div class="col-md-9"><input type="text" class="form-control form-control-inline input-medium"  name="starthour" placeholder="HH:MM" /></div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="col-md-2 control-label" for="date">End hour</label>
                        <div class="col-md-10"><input type="text" class="form-control form-control-inline input-medium" name="endhour" placeholder="HH:MM"/></div>
                    </div>
                    <div class="form-group col-sm-3">
                        <div class="col-md-10"><input type="submit" class="btn btn-success" value="Accept"/></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--bootstrap picker-->
<script type="text/javascript" src="/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/js/picker-init.js"></script>
