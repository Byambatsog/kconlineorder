<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/order_db.php');

    $success_notification = '';
    $error_notification = '';

    try {

        $order = array();
        $order['customerID'] = 1;
        $order['locationID'] = 1;
        $order['pickupType'] = 'D';
        $order['orderComment'] = 'Salty';
        $order['shippingStreet'] = '1246 W PRATT BLVD APT 212';
        $order['shippingCity'] = 'Chicago';
        $order['shippingState'] = 'IL';
        $order['shippingZipCode'] = '60626';

        $orderLines = array();

        $orderLine1 = array();
        $orderLine1['itemID'] = 1;
        $orderLine1['unitPrice'] = 7.50;
        $orderLine1['quantity'] = 2;
        $orderLines[0] = $orderLine1;

        $orderLine2 = array();
        $orderLine2['itemID'] = 6;
        $orderLine2['unitPrice'] = 4.00;
        $orderLine2['quantity'] = 2;
        $orderLines[1] = $orderLine2;

        $orderLine3 = array();
        $orderLine3['itemID'] = 16;
        $orderLine3['unitPrice'] = 2.00;
        $orderLine3['quantity'] = 2;
        $orderLines[2] = $orderLine3;

        add_order($order, $orderLines);

        $success_notification = 'Test data successfully inserted';
    } catch (Exception $e) {
        $error_notification = $e->getMessage();
    }
    require_once('../../util/notification.php');
?>