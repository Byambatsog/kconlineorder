<?php
    require_once('../../../util/main.php');
    require_once('../../authenticate.php');
    require_once('../../../view/headerForAdmin.php');

?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Customers</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Search customers</h6>
            </div>
            <div class="panel-body">
                <form id="searchForm" role="form">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="firstName">First name</label>
                                <input id="searchFirstName" name="firstName" class="form-control input-sm" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="lastName">Last name</label>
                                <input id="searchLastName" name="lastName" class="form-control input-sm" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="userName">Username</label>
                                <input id="searchUserName" name="userName" class="form-control input-sm" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="phone">Phone</label>
                                <input id="searchPhone" name="phone" class="form-control input-sm" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="street">Billing address</label>
                                <input id="searchStreet" name="street" class="form-control input-sm" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="zipCode">Zip Code</label>
                                <input id="searchZipCode" name="zipCode" class="form-control input-sm" />
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


        $("#searchPhone").inputmask("999-999-9999");
        $("#searchZipCode").inputmask("99999");

    });

    sodon_main = {
        list: function() {
            sodon_common.ajax('post','#list-target','customer_list.php','','');
            $('#searchParams').val('');
        },
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','customer_list.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        },
        info: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','customer_view.php','customerID='+id,'');
        },
        changeStatus: function(id, status){
            sodon_common.ajax('post','#alert-notification','customer_status.php','id=' + id + '&status='+status,'sodon_main.simpleSearch();');
        }
    };
    sodon_main.list();
</script>


<?php include '../../../view/footerForAdmin.php'; ?>
