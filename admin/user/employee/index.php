<?php
    require_once('../../../util/main.php');
    require_once('../../authenticate.php');
    require_once('../../../view/headerForAdmin.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');
    require_once('../../../model/employee_db.php');

    $managers = get_managers();
    $locations = get_locations();

?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Employees</h3>
        </div>
        <div class="pull-right">
            <button class="btn btn-default btn-xs" type="button" onclick="sodon_main.create('');">
                <i class="glyphicon glyphicon-file text-primary"></i> Add New Employee
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Search employees</h6>
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
                    <div class="form-group">
                        <label class="control-label" for="location">Location</label>
                        <select name="locationID" id="searchLocationID" class="form-control input-sm">
                            <option value="">...</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo $location['locationID']; ?>"><?php echo $location['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="supervisorID">Supervisor</label>
                        <select name="supervisorID" id="searchSupervisorID" class="form-control input-sm">
                            <option value="">...</option>
                            <?php foreach ($managers as $manager) : ?>
                                <option value="<?php echo $manager['employeeID']; ?>"><?php echo $manager['firstName'].' '.$manager['lastName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">Title</label>
                        <select name="title" id="searchTitle" class="form-control input-sm">
                            <option value="">...</option>
                            <option value="Executive">Executive</option>
                            <option value="Manager">Manager</option>
                            <option value="Front desc clerk">Front desc clerk</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="street">Address</label>
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
            sodon_common.ajax('post','#list-target','employee_list.php','','');
            $('#searchParams').val('');
        },
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','employee_list.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        },
        create: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','employee_create.php','employeeID='+id,'');
        },
        delete: function(){
            if($("input[id=id]:checked").val() !== undefined){
                smoke.confirm('Do you really want to delete?',function(e){
                    if (e){
                        sodon_common.ajax('post','#alert-notification','employee_delete.php',$("#listForm").serialize(),'sodon_list.refresh();');
                    }
                }, {ok:"Delete", cancel:"Cancel"});
            }
            else{
                $.sticky("Please select the items to delete!", {autoclose : 5000, position: "top-right", type: "st-info" });
            }
        }

    };
    sodon_main.list();
</script>


<?php include '../../../view/footerForAdmin.php'; ?>
