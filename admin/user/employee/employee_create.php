<?php
    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');
    require_once('../../../model/employee_db.php');
    require_once('../../../model/user_db.php');

    $success_notification = '';
    $error_notification = '';

    $error_userName = '';
    $error_firstName = '';
    $error_lastName = '';
    $error_password = '';
    $error_passwordConfirm = '';
    $error_title = '';
    $error_location = '';
    $error_phone = '';
    $error_emailAddress = '';
    $error_street = '';
    $error_city = '';
    $error_state = '';
    $error_zipCode = '';

    $states = array('AL', 'AK', 'AZ','AR', 'CA','CO', 'CT', 'DE','FL', 'GA',
        'HI', 'ID', 'IL','IN', 'IA','KS', 'KY', 'LA','ME', 'MD',
        'MA', 'MI', 'MN','MS', 'MO','MT', 'NE', 'NV','NH', 'NJ',
        'NM', 'NY', 'NC','ND', 'OH','OK', 'OR', 'PA','RI', 'SC',
        'SD', 'TN', 'TX','UT', 'VT','VA', 'WA', 'WV','WI', 'WY');

    $supervisors = get_managers();
    $locations = get_locations();
    $titles = array('Executive', 'Manager', 'Front desc clerk');
    $employeeID = '';

    $formValidation = true;

    if(isset($_POST['employeeID'])){

        $employeeID = $_POST['employeeID'];

        try {

            $employee = array();
            $employee['employeeID'] = $_POST['employeeID'];
            $employee['password'] = $_POST['password'];
            $employee['userName'] = $_POST['userName'];
            $employee['firstName'] = $_POST['firstName'];
            $employee['lastName'] = $_POST['lastName'];
            $employee['street'] = $_POST['street'];
            $employee['city'] = $_POST['city'];
            $employee['state'] = $_POST['state'];
            $employee['zipCode'] = $_POST['zipCode'];
            $employee['emailAddress'] = $_POST['emailAddress'];
            $employee['phone'] = $_POST['phone'];
            $employee['title'] = $_POST['title'];
            $employee['birthDate'] = $_POST['birthDate'];
            $employee['dateHired'] = $_POST['dateHired'];
            $employee['supervisorID'] = $_POST['supervisorID'];
            $employee['locationID'] = $_POST['locationID'];
            if(isset($_POST['status'])) $employee['status'] = 'E';
            else $employee['status'] = 'D';


            if(empty($employee['userName'])) {
                $error_userName = 'User name must be filled out';
                $formValidation = false;
            } else if(!empty(get_user($employee['userName']))&&get_user($employee['userName'])['userID']!=$employee['employeeID']){
                $error_userName = 'User name is chosen by another user';
                $formValidation = false;
            }

            if(empty($employee['firstName'])) {
                $error_firstName = 'First name must be filled out';
                $formValidation = false;
            }

            if(empty($employee['lastName'])) {
                $error_lastName = 'Last name must be filled out';
                $formValidation = false;
            }

            if(empty($employee['employeeID'])&&empty($_POST['password'])){
                $error_password = 'Password must be filled out';
                $formValidation = false;
            }

            if(empty($employee['employeeID'])&&empty($_POST['confirmPassword'])){
                $error_passwordConfirm = 'Confirm password must be filled out';
                $formValidation = false;
            }

            if((!empty($_POST['password'])||!empty($_POST['confirmPassword']))&&$_POST['password']!=$_POST['confirmPassword']){
                $error_passwordConfirm = 'Password doesn\'t match';
                $formValidation = false;
            }

            if(empty($employee['title'])) {
                $error_title = 'Title must be selected';
                $formValidation = false;
            }

            if(empty($employee['locationID'])) {
                $error_location = 'Location must be selected';
                $formValidation = false;
            }

            if(empty($employee['street'])) {
                $error_street = 'Street must be filled out';
                $formValidation = false;
            }

            if(empty($employee['city'])) {
                $error_city = 'City must be filled out';
                $formValidation = false;
            }

            if(empty($employee['state'])) {
                $error_state = 'State must be selected';
                $formValidation = false;
            }

            if(empty($employee['zipCode'])) {
                $error_zipCode = 'Zip code must be filled out';
                $formValidation = false;
            } else if(!is_numeric($employee['zipCode'])) {
                $error_zipCode = 'Zip code price must be valid number';
                $formValidation = false;
            }

            if(empty($employee['phone'])) {
                $error_phone = 'Phone must be filled out';
                $formValidation = false;
            } if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $employee['phone'])) {
                $error_phone = 'Phone must be valid phone number';
                $formValidation = false;
            }

            if(!empty($employee['fax'])&&!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $employee['fax'])) {
                $error_fax = 'Fax must be valid fax number';
                $formValidation = false;
            }

            if($formValidation){
                if(empty($employee['employeeID'])){
                    $employee['password'] = password_hash($employee['password'],PASSWORD_DEFAULT);
                    add_employee($employee);
                } else {
                    if(!empty($employee['password'])&&!empty($_POST['confirmPassword'])&&$employee['password']==$_POST['confirmPassword'])
                        $employee['password'] = password_hash($employee['password'],PASSWORD_DEFAULT);
                    else
                        $employee['password'] = get_employee($employee['employeeID'])['password'];
                    update_employee($employee);
                }
                $success_notification = 'Successfully saved';
            }
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
    } else {
        if(isset($_GET['employeeID'])) $employeeID = $_GET['employeeID'];
        if(!empty($employeeID)) $employee = get_employee($employeeID);
    }

?>

<script type="text/javascript">
    sodon_create = {
        init: function() {
            $('#createForm').ajaxForm({
                target:'#edit-target',
                url:'employee_create.php'
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
        if(empty($employeeID))
            echo 'Add new employee';
        else
            echo 'Update employee';
        ?>
    </h3>
</div>
<div class="modal-body">
    <form action="employee_create.php" method="post" id="createForm">

        <input type="hidden" id="employeeID" name="employeeID" value="<?php echo $employeeID;?>"/>

        <div class="row">

            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_userName)) echo 'has-error';?>">
                    <label class="control-label strong" for="userName">Username <span class="f_req">*</span></label>
                    <input id="userName" name="userName" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['userName'];?>"/>
                    <?php if(!empty($error_userName)) { ?>
                        <span class="help-block"><?php echo $error_userName;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_firstName)) echo 'has-error';?>">
                    <label class="control-label strong" for="firstName">First name <span class="f_req">*</span></label>
                    <input id="firstName" name="firstName" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['firstName'];?>"/>
                    <?php if(!empty($error_firstName)) { ?>
                        <span class="help-block"><?php echo $error_firstName;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_lastName)) echo 'has-error';?>">
                    <label class="control-label strong" for="lastName">Last name <span class="f_req">*</span></label>
                    <input id="lastName" name="lastName" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['lastName'];?>"/>
                    <?php if(!empty($error_lastName)) { ?>
                        <span class="help-block"><?php echo $error_lastName;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_password)) echo 'has-error';?>">
                    <label class="control-label strong" for="password">Password <?php if(empty($employeeID)) { ?> <span class="f_req">*</span><?php } ?></label>
                    <input type="password" id="password" name="password" class="form-control input-sm"/>
                    <?php if(!empty($error_password)) { ?>
                        <span class="help-block"><?php echo $error_password;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_passwordConfirm)) echo 'has-error';?>">
                    <label class="control-label strong" for="confirmPassword">Confirm password <?php if(empty($employeeID)) { ?> <span class="f_req">*</span><?php } ?></label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control input-sm"/>
                    <?php if(!empty($error_passwordConfirm)) { ?>
                        <span class="help-block"><?php echo $error_passwordConfirm;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">
                    <label class="control-label strong">Enabled</label>
                    <div class="status-switch" id="status-switch" data-on="info">
                        <input type="checkbox" name="status" id="status" <?php if(empty($employee)||$employee['status']=='E') echo 'checked="checked';?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_title)) echo 'has-error';?>">
                    <label class="control-label strong" for="title">Title <span class="f_req">*</span></label>
                    <select id="title" name="title" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($titles as $title) : ?>
                            <option value="<?php echo $title; ?>" <?php if(!empty($employee)&&$employee['title']==$title) echo 'selected="selected"';?>><?php echo $title; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_title)) { ?>
                        <span class="help-block"><?php echo $error_title;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_location)) echo 'has-error';?>">
                    <label class="control-label strong" for="locationID">Location <span class="f_req">*</span></label>
                    <select id="locationID" name="locationID" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($locations as $location) : ?>
                            <option value="<?php echo $location['locationID']; ?>" <?php if(!empty($employee)&&$location['locationID']==$employee['locationID']) echo 'selected="selected"';?>><?php echo $location['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_location)) { ?>
                        <span class="help-block"><?php echo $error_location;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group <?php if(!empty($error_supervisor)) echo 'has-error';?>">
                    <label class="control-label strong" for="supervisorID">Supervisor </label>
                    <select id="supervisorID" name="supervisorID" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($supervisors as $supervisor) : ?>
                            <option value="<?php echo $supervisor['employeeID']; ?>" <?php if(!empty($employee)&&$supervisor['employeeID']==$employee['supervisorID']) echo 'selected="selected"';?>><?php echo $supervisor['firstName'].' '.$supervisor['lastName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_supervisor)) { ?>
                        <span class="help-block"><?php echo $error_supervisor;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_phone)) echo 'has-error';?>">
                    <label class="control-label strong" for="phone">Phone <span class="f_req">*</span></label>
                    <input id="phone" name="phone" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['phone'];?>"/>
                    <?php if(!empty($error_phone)) { ?>
                        <span class="help-block"><?php echo $error_phone;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_emailAddress)) echo 'has-error';?>">
                    <label class="control-label strong" for="emailAddress">E-mail </label>
                    <input id="emailAddress" name="emailAddress" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['emailAddress'];?>"/>
                    <?php if(!empty($error_emailAddress)) { ?>
                        <span class="help-block"><?php echo $error_emailAddress;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_birthDate)) echo 'has-error';?>">
                    <label class="control-label strong" for="birthDate">Birth date </label>
                    <div class="input-group input-group-sm">
                        <input readonly="readonly" id="birthDate" name="birthDate" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['birthDate'];?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="$('#birthDate').val('');"><i class="glyphicon glyphicon-remove text-muted"></i></button>
                        </span>
                    </div>
                    <?php if(!empty($error_birthDate)) { ?>
                        <span class="help-block"><?php echo $error_birthDate;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_dateHired)) echo 'has-error';?>">
                    <label class="control-label strong" for="dateHired">Date hired</label>
                    <div class="input-group input-group-sm">
                        <input readonly="readonly" id="dateHired" name="dateHired" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['dateHired'];?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="$('#dateHired').val('');"><i class="glyphicon glyphicon-remove text-muted"></i></button>
                        </span>
                    </div>


                    <?php if(!empty($error_dateHired)) { ?>
                        <span class="help-block"><?php echo $error_dateHired;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5">
                <div class="form-group <?php if(!empty($error_street)) echo 'has-error';?>">
                    <label class="control-label strong" for="street">Address <span class="f_req">*</span></label>
                    <input id="street" name="street" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['street'];?>"/>
                    <?php if(!empty($error_street)) { ?>
                        <span class="help-block"><?php echo $error_street;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_city)) echo 'has-error';?>">
                    <label class="control-label strong" for="city">City <span class="f_req">*</span></label>
                    <input id="city" name="city" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['city'];?>"/>
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
                            <option value="<?php echo $state; ?>" <?php if(!empty($employee)&&$state==$employee['state']) echo 'selected="selected"';?>><?php echo $state; ?></option>
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
                    <input id="zipCode" name="zipCode" class="form-control input-sm" value="<?php if(!empty($employee)) echo $employee['zipCode'];?>"/>
                    <span class="help-block">60660</span>
                    <?php if(!empty($error_zipCode)) { ?>
                        <span class="help-block"><?php echo $error_zipCode;?></span>
                    <?php }?>
                </div>
            </div>
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

        $('#status-switch').bootstrapSwitch();
        $('#status-switch').bootstrapSwitch('setSizeClass', 'switch-small');
        $('#status-switch').bootstrapSwitch('setOnLabel', 'Yes');
        $('#status-switch').bootstrapSwitch('setOffLabel', 'No');

        $("#phone").inputmask("999-999-9999");
        $("#zipCode").inputmask("99999");

        var bd = $('#birthDate').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            bd.hide();
        }).data('datepicker');

        var dh = $('#dateHired').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            dh.hide();
        }).data('datepicker');

    });
</script>