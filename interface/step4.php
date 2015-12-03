<?php

    session_start();
    require_once('../util/main.php');
    require_once('header.php');
    require_once('../model/database.php');
    require_once('../model/customer_db.php');
    require_once('../model/card_type_db.php');
    require_once('../model/order_db.php');
    require_once('../model/payment_db.php');

    if (!isset($_SESSION['order'])) {
        header("Location:step1.php");
    }

    if (!isset($_SESSION['orderLines'])) {
        header("Location:step2.php");
    }

    if(!isset($_SESSION['customer'])){
        header("Location:step3.php");
    }

    $cardTypes = get_card_types();

    $states = array('AL', 'AK', 'AZ','AR', 'CA','CO', 'CT', 'DE','FL', 'GA',
                    'HI', 'ID', 'IL','IN', 'IA','KS', 'KY', 'LA','ME', 'MD',
                    'MA', 'MI', 'MN','MS', 'MO','MT', 'NE', 'NV','NH', 'NJ',
                    'NM', 'NY', 'NC','ND', 'OH','OK', 'OR', 'PA','RI', 'SC',
                    'SD', 'TN', 'TX','UT', 'VT','VA', 'WA', 'WV','WI', 'WY');
    $months = array('01', '02', '03','04', '05','06', '07', '08','09', '10','11','12');
    $years = array('2015', '2016', '2017','2018', '2019','2020', '2021', '2022','2023', '2024','2025','2026');

    $order = $_SESSION['order'];
    $customer = $_SESSION['customer'];

    $error_cardTypeID = '';
    $error_cardNumber = '';
    $error_cardSecurityCode = '';

    $error_billingStreet = '';
    $error_billingCity = '';
    $error_billingState = '';
    $error_billingZipCode = '';

    $error_shippingStreet = '';
    $error_shippingCity = '';
    $error_shippingState = '';
    $error_shippingZipCode = '';


    if(isset($_POST['placeOrder'])){

        $formValidation = true;

        if(empty($_POST['cardTypeID'])) {
            $error_cardTypeID = 'Card type must be selected';
            $formValidation = false;
        }

        if(empty($_POST['cardNumber'])) {
            $error_cardNumber = 'Card number must be filled out';
            $formValidation = false;
        } if(!preg_match("/^[0-9]{16}$/", $_POST['cardNumber'])) {
            $error_cardNumber = 'Card number must be valid';
            $formValidation = false;
        }

        if(empty($_POST['securityCode'])) {
            $error_cardSecurityCode = 'Security code must be filled out';
            $formValidation = false;
        } else if(!preg_match("/^[0-9]{3}$/", $_POST['securityCode'])) {
            $error_cardSecurityCode = 'Security code must be valid';
            $formValidation = false;
        }

        if(empty($_POST['billingStreet'])) {
            $error_billingStreet = 'Billing address must be filled out';
            $formValidation = false;
        }

        if(empty($_POST['billingCity'])) {
            $error_billingCity = 'Billing city must be filled out';
            $formValidation = false;
        }

        if(empty($_POST['billingState'])) {
            $error_billingState = 'Billing state must be selected';
            $formValidation = false;
        }

        if(empty($_POST['billingZipCode'])) {
            $error_billingZipCode = 'Billing zip code must be filled out';
            $formValidation = false;
        } else if(!preg_match("/^[0-9]{5}$/", $_POST['billingZipCode'])) {
            $error_billingZipCode = 'Billing zip code must be valid';
            $formValidation = false;
        }

        if(empty($_POST['shippingStreet'])) {
            $error_shippingStreet = 'Shipping address must be filled out';
            $formValidation = false;
        }

        if(empty($_POST['shippingCity'])) {
            $error_shippingCity = 'Shipping city must be filled out';
            $formValidation = false;
        }

        if(empty($_POST['shippingState'])) {
            $error_shippingState = 'Shipping state must be selected';
            $formValidation = false;
        }

        if(empty($_POST['shippingZipCode'])) {
            $error_shippingZipCode = 'Shipping zip code must be filled out';
            $formValidation = false;
        }  else if(!preg_match("/^[0-9]{5}$/", $_POST['shippingZipCode'])) {
            $error_shippingZipCode = 'Shipping zip code must be valid';
            $formValidation = false;
        }

        $order['customerID'] = $_SESSION['customer']['customerID'];
        $order['orderComment'] = '';

        if($order['pickupType']=='D'){
            $order['shippingStreet'] = $_POST['shippingStreet'];
            $order['shippingCity'] = $_POST['shippingCity'];
            $order['shippingState'] = $_POST['shippingState'];
            $order['shippingZipCode'] = $_POST['shippingZipCode'];
        }

        if($formValidation){
            $orderID = add_order($order, $_SESSION['orderLines']);
            $payment = array();
            $payment['orderID'] = $orderID;
            $payment['amount'] = $_SESSION['totalPrice'];
            $payment['cardTypeID'] = $_POST['cardTypeID'];
            $payment['cardNumber'] = $_POST['cardNumber'];
            $payment['cardExpMonth'] = $_POST['cardExpMonth'];
            $payment['cardExpYear'] = $_POST['cardExpYear'];
            add_payment($payment);
        }

        $customer['billingStreet'] = $_POST['billingStreet'];
        $customer['billingCity'] = $_POST['billingCity'];
        $customer['billingState'] = $_POST['billingState'];
        $customer['billingZipCode'] = $_POST['billingZipCode'];
        if($order['pickupType']=='D'){
            $customer['shippingStreet'] = $_POST['shippingStreet'];
            $customer['shippingCity'] = $_POST['shippingCity'];
            $customer['shippingState'] = $_POST['shippingState'];
            $customer['shippingZipCode'] = $_POST['shippingZipCode'];
        }
        $customer['cardTypeID'] = $_POST['cardTypeID'];
        $customer['cardNumber'] = $_POST['cardNumber'];
        $customer['cardExpMonth'] = $_POST['cardExpMonth'];
        $customer['cardExpYear'] = $_POST['cardExpYear'];

        if($formValidation){
            update_customer($customer);
            header("Location:step5.php");
        }
    }
?>

<div class="container">
    <div class="back">
        <div class="resultContainer">

            <h1 class="text-center">Order Summary</h1>
            <form action="step4.php" method="post" id="placeOrderForm">
                <input type="hidden" name="placeOrder" value="true"/>
                <div id="orderedItems" class="resultItem">
                    <h4 class="title">Ordered Items:</h4>
                    <table class="ordertable">
                        <thead>
                            <tr>
                                <th class="text-center">Item name</th>
                                <th class="text-center">Picture</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total Price</th>
                            </tr>
                        </thead>
                        <?php $total = 0;?>
                        <tbody>
                            <?php foreach ($_SESSION['orderLines'] as $orderline) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $orderline['name']; ?></td>
                                    <td class="text-center">
                                        <img src="<?php echo $orderline['picture']; ?>" style="width: 100px; height: 60px;"/>
                                    </td>
                                    <td class="text-center"><?php echo $orderline['unitPrice']; ?>$</td>
                                    <td class="text-center"><?php echo $orderline['quantity']; ?></td>
                                    <td class="text-center"><?php echo $orderline['quantity']*$orderline['unitPrice']; ?>$</td>
                                </tr>
                                <?php $total += $orderline['quantity']*$orderline['unitPrice'];?>
                            <?php endforeach; ?>
                            <tr>
                                <td class="text-center" colspan="4">Total payment</td>
                                <td class="text-center"><?php echo $total; ?>$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="resultItem"><h4  class="title">Card information: </h4>
                    <table>
                        <tr>
                            <td><h5>Card Type: <span class="f_req">*</span></h5></td>
                            <td>
                                <select name="cardTypeID" id="cardTypeID" class="form-control input-sm" style="width: 150px;">
                                    <option value="">...</option>
                                    <?php foreach ($cardTypes as $type) : ?>
                                        <option value="<?php echo $type['cardTypeID']; ?>" <?php if($type['cardTypeID']==$customer['cardTypeID']) echo 'selected="selected"';?> ><?php echo $type['description']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="has-error"><?php echo $error_cardTypeID;?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Card Number: <span class="f_req">*</span></h5></td>
                            <td>
                                <input id="cardNumber" name="cardNumber" type="text" maxlength="16" size="20" value="<?php echo $customer['cardNumber'];?>">
                                <span class="has-error"><?php echo $error_cardNumber;?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Security Code: <span class="f_req">*</span></h5></td>
                            <td>
                                <input id="securityCode" name="securityCode" type="text" maxlength="3" size="3" >
                                <span class="has-error"><?php echo $error_cardSecurityCode;?>
                            </td>

                        </tr>
                        <tr>
                            <td><h5>Expiration Date: <span class="f_req">*</span></h5></td>
                            <td>
                                <select id="cardExpMonth" name="cardExpMonth" class="form-control input-sm" style="width: 50px; float: left;">
                                    <?php foreach ($months as $month) : ?>
                                        <option value="<?php echo $month; ?>" <?php if($month==$customer['cardExpMonth']) echo 'selected="selected"';?>><?php echo $month; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select id="cardExpYear" name="cardExpYear" class="form-control input-sm" style="width: 70px; float: left;  ">
                                    <?php foreach ($years as $year) : ?>
                                        <option value="<?php echo $year; ?>" <?php if($year==$customer['cardExpYear']) echo 'selected="selected"';?>><?php echo $year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="resultItem"> <h4 class="title">Billing Address:</h4>
                    <table>
                        <tr>
                            <td><h5>Address: <span class="f_req">*</span></h5></td>
                            <td>
                                <input id="billingStreet" name="billingStreet" type="text" size="20" value="<?php echo $customer['billingStreet'];?>">
                                <span class="has-error"><?php echo $error_billingStreet;?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>City: <span class="f_req">*</span></h5></td>
                            <td>
                                <input id="billingCity" name="billingCity" type="text" size="20" value="<?php echo $customer['billingCity'];?>">
                                <span class="has-error"><?php echo $error_billingCity;?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>State: <span class="f_req">*</span></h5></td>
                            <td>
                                <select id="billingState" name="billingState" class="form-control input-sm"  style="width: 50px;">
                                    <option value="">...</option>
                                    <?php foreach ($states as $state) : ?>
                                        <option value="<?php echo $state; ?>" <?php if($state==$customer['billingState']) echo 'selected="selected"';?>><?php echo $state; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="has-error"><?php echo $error_billingState;?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Zip Code: <span class="f_req">*</span></h5></td>
                            <td>
                                <input id="billingZipCode" name="billingZipCode" type="text" size="5" value="<?php echo $customer['billingZipCode'];?>">
                                <span class="has-error"><?php echo $error_billingZipCode;?>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php if($order['pickupType']=='D'){?>

                    <div class="resultItem"> <h4 class="title">Delivery Address:</h4>
                        <table>
                            <tr>
                                <td><h5>Address: <span class="f_req">*</span></h5></td>
                                <td>
                                    <input id="shippingStreet" name="shippingStreet" type="text" size="20" value="<?php echo $customer['shippingStreet'];?>">
                                    <span class="has-error"><?php echo $error_shippingStreet;?>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>City: <span class="f_req">*</span></h5></td>
                                <td>
                                    <input id="shippingCity" name="shippingCity" type="text" size="20" value="<?php echo $customer['shippingCity'];?>">
                                    <span class="has-error"><?php echo $error_shippingCity;?>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>State: <span class="f_req">*</span></h5></td>
                                <td>
                                    <select id="shippingState" name="shippingState" class="form-control input-sm"  style="width: 50px;">
                                        <option value="">...</option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?php echo $state; ?>" <?php if($state==$customer['shippingState']) echo 'selected="selected"';?>><?php echo $state; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="has-error"><?php echo $error_shippingState;?>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Zip Code: <span class="f_req">*</span></h5></td>
                                <td>
                                    <input id="shippingZipCode" name="shippingZipCode" type="text" size="5" value="<?php echo $customer['shippingZipCode'];?>">
                                    <span class="has-error"><?php echo $error_shippingZipCode;?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php }?>
            </form>
        </div>
    </div>
    <!-- /.row -->

    <!-- Pagination -->
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            <ul class="pager">
                <div class="text-right">
                    <li><a href="step2.php">Previous</a></li>
                    <li><a href="javascript:void(0);" onclick="$('#placeOrderForm').submit(); return false;">Place Order</a></li>
                </div>
            </ul>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">

    $(document).ready(function(){

        $("#cardNumber").inputmask("9999999999999999");
        $("#securityCode").inputmask("999");
        $("#billingZipCode").inputmask("99999");
        $("#shippingZipCode").inputmask("99999");

    });
</script>
