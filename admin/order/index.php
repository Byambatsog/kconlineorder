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
            <h3>Current Orders</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Search orders</h6>
            </div>
            <div class="panel-body">
                <div id="simple-search">
                    <form id="searchForm" role="form">
                        <div class="form-group">
                            <label class="control-label" for="location">Location</label>
                            <select name="locationID" id="searchLocationID" class="form-control input-sm">
                                <?php foreach ($locations as $location) : ?>
                                    <option value="<?php echo $location['locationID']; ?>"><?php echo $location['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label" for="filterDate">Date</label>
                                    <input readonly="readonly" id="searchDate" name="filterDate" class="form-control input-sm" value="2015-11-18"/>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label" for="simpleStatus">Status</label>
                                    <select name="status" id="searchStatus" class="form-control input-sm">
                                        <option value="">....</option>
                                        <option value="P">Pending</option>
                                        <option value="S">Processing</option>
                                        <option value="R">Ready</option>
                                        <option value="C">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pickupType">Pick up type</label>
                            <select name="pickupType" id="searchPickupType" class="form-control input-sm">
                                <option value="">....</option>
                                <option value="P">Pick up</option>
                                <option value="D">Delivery</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="customer">Customer</label>
                            <input id="searchCustomer" name="customer" class="form-control input-sm"/>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label class="control-label" for="street">Shipping street</label>
                                    <input id="searchStreet" name="street" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="control-label" for="zipCode">Zip code</label>
                                        <input id="searchZipCode" name="zipCode" class="form-control input-sm"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="text-right">
                            <button type="reset" class="btn btn-default btn-sm">Clear</button>
                            <button class="btn btn-primary btn btn-sm" type="submit">Search</button>
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
    </div>
    <div class="col-xs-9">
        <div id="list-target">
<!--            list-->
        </div>
    </div>

</div>

<div class="modal" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 10px; margin-top: 5px;">&times;</button>
            <div id="edit-target">
<!--                create-->
            </div>
        </div>
    </div>
</div>

<div id="item-load" style="display: none;">
<!--    ajax-->
</div>

<script type="text/javascript">

    $(document).ready(function(){

        var sd = $('#searchDate').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            sd.hide();
        }).data('datepicker');

        $("#searchZipCode").inputmask("99999");

    });

    sodon_main = {
        list: function() {
            sodon_common.ajax('get','#list-target','order_list.php','','');
            $('#searchParams').val('');
        },
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','order_list.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        },
        detail: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','order_detail.php','orderID='+id,'');
        },
        changeStatus: function(id){
            sodon_common.ajax('post','#alert-notification','order_status.php','id=' + id,'sodon_list.refresh();');
        },
        delete: function(){
            if($("input[id=id]:checked").val() !== undefined){
                smoke.confirm('Do you really want to delete?',function(e){
                    if (e){
                        sodon_common.ajax('post','#alert-notification','order_delete.php',$("#listForm").serialize(),'sodon_list.refresh();');
                    }
                }, {ok:"Delete", cancel:"Cancel"});
            }
            else{
                $.sticky("Please select the items to delete!", {autoclose : 5000, position: "top-right", type: "st-info" });
            }
        },
        create: function(){
            sodon_common.ajax('post','#alert-notification','order_create.php','','sodon_list.refresh();');
        }
    };
    sodon_main.simpleSearch();
</script>


<?php include '../../view/footerForAdmin.php'; ?>
