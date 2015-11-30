<?php
require_once('../../util/main.php');
require_once('../authenticate.php');
require_once('../../view/headerForAdmin.php');


?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Best customers who bought the most</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Report Filter</h6>
            </div>
            <div class="panel-body">
                <form id="searchForm" role="form">
                    <div class="form-group">
                        <label class="control-label" for="StartDate">Start date</label>
                        <input readonly="readonly" id="searchStartDate" name="startDate" class="form-control input-sm" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="endDate">End date</label>
                        <input readonly="readonly" id="searchEndDate" name="endDate" class="form-control input-sm" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="endDate">Page Limit</label>
                        <select class="form-control input-sm" id="pageSize" name="pageSize">
                            <option>10</option>
                            <option>20</option>
                            <option>30</option>
                            <option>40</option>
                            <option>50</option>
                        </select>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="reset" class="btn btn-default btn-sm">Clear</button>
                        <button class="btn btn-primary btn btn-sm" type="submit">Filter</button>
                    </div>

                </form>
                <script>
                    $('#searchForm').on('submit', function(){
                        sodon_main.simpleSearch();
                        return false;
                    })
                </script>
            </div>
        </div>
    </div>
    <div class="col-xs-9">
        <div id="list-target">
            <!--            list-->
        </div>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){

        var sd = $('#searchStartDate').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            sd.hide();
        }).data('datepicker');

        var ed = $('#searchEndDate').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            ed.hide();
        }).data('datepicker');

    });

    sodon_main = {
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','bestCustomerList.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        }
    };
    sodon_main.simpleSearch();
</script>


<?php include '../../view/footerForAdmin.php'; ?>
