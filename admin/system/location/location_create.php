<?php
    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');
    require_once('../../../model/employee_db.php');

    $success_notification = '';
    $error_notification = '';

    $error_name = '';
    $error_street = '';
    $error_city = '';
    $error_state = '';
    $error_zipCode = '';
    $error_phone = '';
    $error_fax = '';
    $error_emailAddress = '';
    $error_manager = '';

    $states = array('AL', 'AK', 'AZ','AR', 'CA','CO', 'CT', 'DE','FL', 'GA',
                    'HI', 'ID', 'IL','IN', 'IA','KS', 'KY', 'LA','ME', 'MD',
                    'MA', 'MI', 'MN','MS', 'MO','MT', 'NE', 'NV','NH', 'NJ',
                    'NM', 'NY', 'NC','ND', 'OH','OK', 'OR', 'PA','RI', 'SC',
                    'SD', 'TN', 'TX','UT', 'VT','VA', 'WA', 'WV','WI', 'WY');

    $formValidation = true;

    $managers = get_managers();
    $locationID = '';

    if(isset($_POST['locationID'])){

        $locationID = $_POST['locationID'];

        try {

            $location = array();
            $location['locationID'] = $_POST['locationID'];
            $location['name'] = $_POST['name'];
            $location['street'] = $_POST['street'];
            $location['city'] = $_POST['city'];
            $location['state'] = $_POST['state'];
            $location['zipCode'] = $_POST['zipCode'];
            $location['phone'] = $_POST['phone'];
            $location['fax'] = $_POST['fax'];
            $location['emailAddress'] = $_POST['emailAddress'];
            $location['timeTable'] = $_POST['timeTable'];
            $location['managerID'] = $_POST['managerID'];

            if(empty($location['name'])) {
                $error_name = 'Name must be filled out';
                $formValidation = false;
            }

            if(empty($location['managerID'])) {
                $error_manager = 'Manager must be selected';
                $formValidation = false;
            }

            if(empty($location['street'])) {
                $error_street = 'Street must be filled out';
                $formValidation = false;
            }

            if(empty($location['city'])) {
                $error_city = 'City must be filled out';
                $formValidation = false;
            }

            if(empty($location['state'])) {
                $error_state = 'State must be selected';
                $formValidation = false;
            }

            if(empty($location['zipCode'])) {
                $error_zipCode = 'Zip code must be filled out';
                $formValidation = false;
            } else if(!is_numeric($location['zipCode'])) {
                $error_zipCode = 'Zip code price must be valid number';
                $formValidation = false;
            }

            if(empty($location['phone'])) {
                $error_phone = 'Phone must be filled out';
                $formValidation = false;
            } if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $location['phone'])) {
                $error_phone = 'Phone must be valid phone number';
                $formValidation = false;
            }

            if(!empty($location['fax'])&&!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $location['fax'])) {
                $error_fax = 'Fax must be valid fax number';
                $formValidation = false;
            }

            if($formValidation){
                if(empty($location['locationID'])){
                    session_start();
                    $location['createdBy'] = $_SESSION['userId'];
                    add_location($location);
                } else {
                    update_location($location);
                }
                $success_notification = 'Successfully saved';
            }
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
    } else {
        if(isset($_GET['locationID'])) $locationID = $_GET['locationID'];
        if(!empty($locationID)) $location = get_location($locationID);
    }

?>

<script type="text/javascript">
    sodon_create = {
        init: function() {
            $('#createForm').ajaxForm({
                target:'#edit-target',
                url:'location_create.php'
            });
        },
        success: function() {
            $('#createModal').modal('hide');
            sodon_main.list();
        },
        submit: function() {
            $('#createForm').submit();
        }
    };
</script>

<div class="modal-header">
    <h3 class="modal-title">
        <?php
        if(empty($locationID))
            echo 'Add new location';
        else
            echo 'Update location';
        ?>
    </h3>
</div>
<div class="modal-body">
    <form action="location_create.php" method="post" id="createForm">

        <input type="hidden" id="locationID" name="locationID" value="<?php echo $locationID;?>"/>

        <div class="row">
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_name)) echo 'has-error';?>">
                    <label class="control-label strong" for="name">Name <span class="f_req">*</span></label>
                    <input id="name" name="name" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['name'];?>"/>
                    <?php if(!empty($error_name)) { ?>
                        <span class="help-block"><?php echo $error_name;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_manager)) echo 'has-error';?>">
                    <label class="control-label strong" for="managerID">Manager <span class="f_req">*</span></label>
                    <select id="managerID" name="managerID" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($managers as $manager) : ?>
                            <option value="<?php echo $manager['employeeID']; ?>" <?php if(!empty($location)&&$manager['employeeID']==$location['managerID']) echo 'selected="selected"';?>><?php echo $manager['firstName'].' '.$manager['lastName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_manager)) { ?>
                        <span class="help-block"><?php echo $error_manager;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5">
                <div class="form-group <?php if(!empty($error_street)) echo 'has-error';?>">
                    <label class="control-label strong" for="street">Address <span class="f_req">*</span></label>
                    <input id="street" name="street" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['street'];?>"/>
                    <?php if(!empty($error_street)) { ?>
                        <span class="help-block"><?php echo $error_street;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_city)) echo 'has-error';?>">
                    <label class="control-label strong" for="city">City <span class="f_req">*</span></label>
                    <input id="city" name="city" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['city'];?>"/>
                    <?php if(!empty($error_city)) { ?>
                        <span class="help-block"><?php echo $error_city;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="form-group <?php if(!empty($error_state)) echo 'has-error';?>">
                    <label class="control-label strong" for="state">State <span class="f_req">*</span></label>
                    <select id="state" name="state" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($states as $state) : ?>
                            <option value="<?php echo $state; ?>" <?php if(!empty($location)&&$state==$location['state']) echo 'selected="selected"';?>><?php echo $state; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_state)) { ?>
                        <span class="help-block"><?php echo $error_state;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="form-group <?php if(!empty($error_zipCode)) echo 'has-error';?>">
                    <label class="control-label strong" for="zipCode">Zip Code<span class="f_req">*</span></label>
                    <input id="zipCode" name="zipCode" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['zipCode'];?>"/>
                    <span class="help-block">60660</span>
                    <?php if(!empty($error_zipCode)) { ?>
                        <span class="help-block"><?php echo $error_zipCode;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_phone)) echo 'has-error';?>">
                    <label class="control-label strong" for="street">Phone <span class="f_req">*</span></label>
                    <input id="phone" name="phone" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['phone'];?>"/>
                    <span class="help-block">312-875-0937</span>
                    <?php if(!empty($error_phone)) { ?>
                        <span class="help-block"><?php echo $error_phone;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_fax)) echo 'has-error';?>">
                    <label class="control-label strong" for="city">Fax </label>
                    <input id="fax" name="fax" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['fax'];?>"/>
                    <span class="help-block">773-843-2123</span>
                    <?php if(!empty($error_fax)) { ?>
                        <span class="help-block"><?php echo $error_fax;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_emailAddress)) echo 'has-error';?>">
                    <label class="control-label strong" for="state">E-mail address</label>
                    <input id="emailAddress" name="emailAddress" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['emailAddress'];?>"/>
                    <?php if(!empty($error_emailAddress)) { ?>
                        <span class="help-block"><?php echo $error_emailAddress;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label strong" for="timeTable">Time table <span class="f_req">*</span></label>
            <input id="timeTable" name="timeTable" class="form-control input-sm" value="<?php if(!empty($location)) echo $location['timeTable'];?>"/>
        </div>

        <div class="formSep"></div>

        <div class="clearfix">
            <div class="pull-right">
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" onclick="sodon_create.submit()">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>

    </form>
</div>

<div style="display: none;">
    <div id="success_notification"><?php echo $success_notification;?></div>
    <div id="error_notification"><?php echo $error_notification;?></div>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php if(!empty($success_notification)) { ?>
                $.sticky($('#success_notification').text(), {autoclose : 5000, position: "top-right", type: "st-success" });
                sodon_create.success();
            <?php } ?>
            <?php if(!empty($error_notification)) { ?>
                $.sticky($('#error_notification').text(), {autoclose : 5000, position: "top-right", type: "st-error" });
                $('#createModal').animate({scrollTop: 0}, 800);
            <?php } ?>
        });
    </script>
</div>



<script type="text/javascript">

    sodon_create.init();

    $(document).ready(function(){

        $("#phone").inputmask("999-999-9999");
        $("#fax").inputmask("999-999-9999");
        $("#zipCode").inputmask("99999");

    });
</script>