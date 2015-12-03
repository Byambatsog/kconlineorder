<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/order_db.php');
    require_once('../../model/payment_db.php');
    require_once('../../model/customer_db.php');

    $success_notification = '';
    $error_notification = '';

    try {

//        $order = array();
//        $order['customerID'] = 1;
//        $order['locationID'] = 1;
//        $order['pickupType'] = 'D';
//        $order['orderComment'] = 'Salty';
//        $order['shippingStreet'] = '1246 W PRATT BLVD APT 212';
//        $order['shippingCity'] = 'Chicago';
//        $order['shippingState'] = 'IL';
//        $order['shippingZipCode'] = '60626';
//
//        $orderLines = array();
//
//        $orderLine1 = array();
//        $orderLine1['itemID'] = 1;
//        $orderLine1['unitPrice'] = 7.50;
//        $orderLine1['quantity'] = 2;
//        $orderLines[0] = $orderLine1;
//
//        $orderLine2 = array();
//        $orderLine2['itemID'] = 6;
//        $orderLine2['unitPrice'] = 4.00;
//        $orderLine2['quantity'] = 2;
//        $orderLines[1] = $orderLine2;
//
//        $orderLine3 = array();
//        $orderLine3['itemID'] = 16;
//        $orderLine3['unitPrice'] = 2.00;
//        $orderLine3['quantity'] = 2;
//        $orderLines[2] = $orderLine3;
//
//        $orderID = add_order($order, $orderLines);
//
//        $payment = array();
//        $payment['orderID'] = $orderID;
//        $payment['amount'] = 27.00;
//        $payment['cardTypeID'] = 1;
//        $payment['cardNumber'] = '5370463888813020';
//        $payment['cardExpMonth'] = '01';
//        $payment['cardExpYear'] = '2018';
//        add_payment($payment);


//        $customer = array();
//        $customer['userName'] = 'John';
//        $customer['password'] = password_hash('hello',PASSWORD_DEFAULT);;
//        $customer['firstName'] = 'John';
//        $customer['lastName'] = 'Nesh';
//        $customer['emailAddress'] = 'jnesh@gmail.com';
//
//        $userID = add_customerUser($customer);
//
//        $customer['customerID'] = $userID;
//        $customer['billingStreet'] = '1246';
//        $customer['billingCity'] = 'Chicago';
//        $customer['billingState'] = 'IL';
//        $customer['billingZipCode'] = '60626';
//        $customer['shippingStreet'] = '1101';
//        $customer['shippingCity'] = 'New York';
//        $customer['shippingState'] = 'NY';
//        $customer['shippingZipCode'] = '60627';
//        $customer['cardTypeID'] = 1;
//        $customer['cardNumber'] = '4444555566667777';
//        $customer['cardExpMonth'] = '02';
//        $customer['cardExpYear'] = '2018';
//
//        add_customer($customer);

        $success_notification = 'Test data successfully inserted'.$userID ;
    } catch (Exception $e) {
        $error_notification = $e->getMessage();
    }
    require_once('../../util/notification.php');
?>