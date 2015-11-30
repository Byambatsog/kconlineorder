<?php
    require_once('../../util/main.php');
    require_once('../authenticate.php');
    require_once('../../view/headerForAdmin.php');
    require_once('../../model/database.php');
    require_once('../../model/location_db.php');

    $locations = get_locations();

?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Daily Sales report</h3>
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
                        <label class="control-label" for="StartDate">Date</label>
                        <input readonly="readonly" id="searchDate" name="date" class="form-control input-sm" value="2015-11-17" />
                    </div>
                    <label class="control-label" for="location">Location</label>
                    <select name="locationID" id="searchLocationID" class="form-control input-sm">
                        <?php foreach ($locations as $location) : ?>
                            <option value="<?php echo $location['locationID']; ?>"><?php echo $location['name']; ?></option>
                        <?php endforeach; ?>
                    </select>

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

        var sd = $('#searchDate').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            sd.hide();
        }).data('datepicker');

    });

    sodon_main = {
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','dailySalesReportList.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        }
    };
    sodon_main.simpleSearch();
</script>


<?php include '../../view/footerForAdmin.php'; ?>
