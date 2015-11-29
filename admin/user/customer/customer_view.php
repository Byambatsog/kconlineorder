<?php

    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/customer_db.php');


    if(isset($_GET['customerID'])){
        $customer = get_customer($_GET['customerID']);
    } else {
        exit();
    }
?>

<div class="modal-header">
    <h3 class="modal-title">
        Customer Information
    </h3>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Username</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <strong><?php echo $customer['userName'];?></strong>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Name</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['firstName'].' '.$customer['lastName'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Contact</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['phone'].', '.$customer['emailAddress'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Billing address</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['billingStreet'].', '.$customer['billingCity'].', '.$customer['billingState'].' '.$customer['billingZipCode']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Shipping address</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['shippingStreet'].', '.$customer['shippingCity'].', '.$customer['shippingState'].' '.$customer['shippingZipCode']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Discount percentage</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['discountPercentage']; ?>%
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Registered</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $customer['created']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Status</strong></label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input value="E" id="status_e" name="status" type="radio" <?php if($customer['status']=='E') echo 'checked="checked"';?> onclick="sodon_main.changeStatus(<?php echo $customer['customerID']; ?>,'E');">
                                Enabled
                            </label>
                            <label class="radio-inline">
                                <input value="D" id="status_d" name="status" type="radio" <?php if($customer['status']=='D') echo 'checked="checked"';?> onclick="sodon_main.changeStatus(<?php echo $customer['customerID']; ?>,'D');">
                                Disabled
                            </label>
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <div class="col-sm-8 col-sm-offset-2">-->
<!--                            <button class="btn btn-default" type="submit">Save changes</button>-->
<!--                            <button class="btn btn-link">Cancel</button>-->
<!--                        </div>-->
<!--                    </div>-->
                </fieldset>
            </form>
        </div>
    </div>
</div>

