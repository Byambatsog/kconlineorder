<?php

function get_orderSize_by_filters($locationID, $date, $status, $pickupType, $customer, $street, $zipCode) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($locationID)){
        $where = $where.$conn."orders.locationID=?";
        $conn = " AND ";
        $params[$counter++] = $locationID;
    }

    if(!empty($date)){
        $where = $where.$conn."cast(orderDateTime as date)=?";
        $conn = " AND ";
        $params[$counter++] = $date;
    }

    if(!empty($pickupType)){
        $where = $where.$conn."pickupType=?";
        $conn = " AND ";
        $params[$counter++] = $pickupType;
    }

    if(!empty($street)){
        $where = $where.$conn."orders.shippingStreet like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$street.'%';
    }

    if(!empty($zipCode)){
        $where = $where.$conn."orders.shippingZipCode=?";
        $conn = " AND ";
        $params[$counter++] = $zipCode;
    }

    if(!empty($customer)){
        $where = $where.$conn."users.firstName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$customer.'%';
    }

    if(!empty($status)){
        $where = $where.$conn."orders.status=?";
        $params[$counter++] = $status;
    }

    $query = 'SELECT count(*) FROM orders
              LEFT JOIN users ON orders.customerID=users.userID
              LEFT JOIN customers ON orders.customerID=customers.customerID
              LEFT JOIN
                  (SELECT orderID, SUM(unitprice*quantity) AS totalPayment, SUM(quantity) AS totalQuantity
	               FROM orderlines GROUP BY orderID) AS orderline ON orders.orderID=orderline.orderID'
            .$where;

    try {
        $statement = $db->prepare($query);

        for ($count = 1; $count <= $counter; ++$count){
            $statement->bindValue($count, $params[$count-1]);
        }
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        return $row[0];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_orders_by_filters($locationID, $date, $status, $pickupType, $customer, $street, $zipCode, $page, $pageSize, $orderField, $orderDirection) {
    //P - Pending
    //S - Processing
    //R - Ready
    //C - Completed

    global $db;

    $orderBy = ' ORDER BY orders.orderDateTime DESC ';
    if(!empty($orderField)&&!empty($orderDirection))
        $orderBy = ' ORDER BY '.$orderField.' '.$orderDirection.' ';

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($locationID)){
        $where = $where.$conn."orders.locationID=?";
        $conn = " AND ";
        $params[$counter++] = $locationID;
    }

    if(!empty($date)){
        $where = $where.$conn."cast(orderDateTime as date)=?";
        $conn = " AND ";
        $params[$counter++] = $date;
    }

    if(!empty($pickupType)){
        $where = $where.$conn."pickupType=?";
        $conn = " AND ";
        $params[$counter++] = $pickupType;
    }

    if(!empty($street)){
        $where = $where.$conn."orders.shippingStreet like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$street.'%';
    }

    if(!empty($zipCode)){
        $where = $where.$conn."orders.shippingZipCode=?";
        $conn = " AND ";
        $params[$counter++] = $zipCode;
    }

    if(!empty($customer)){
        $where = $where.$conn."users.firstName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$customer.'%';
    }

    if(!empty($status)){
        $where = $where.$conn."orders.status=?";
        $params[$counter++] = $status;
    }

    $query = 'SELECT orders.orderID, CONCAT(firstName,\' \', lastName) AS customerName, totalPayment, totalQuantity, orders.status,
              orderDateTime, pickupType, phone, orders.shippingStreet AS shippingAddress, billingStreet AS billingAddress
              FROM orders
              LEFT JOIN users ON orders.customerID=users.userID
              LEFT JOIN customers ON orders.customerID=customers.customerID
              LEFT JOIN
                  (SELECT orderID, SUM(unitprice*quantity) AS totalPayment, SUM(quantity) AS totalQuantity
	               FROM orderlines GROUP BY orderID) AS orderline ON orders.orderID=orderline.orderID'
            .$where
            .$orderBy.'LIMIT '.($pageSize*($page-1)).', '.$pageSize;

    try {
        $statement = $db->prepare($query);

        for ($count = 1; $count <= $counter; ++$count){
            $statement->bindValue($count, $params[$count-1]);
        }
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_order($order_id) {
    global $db;
    $query =   'SELECT orders.orderID, locations.name AS locationName, orderDateTime, pickupType,
                fulfillmentDateTime, orderComment, orders.shippingStreet, orders.shippingCity,
                orders.shippingState, orders.shippingZipCode, orders.status, CONCAT(firstName,\' \', lastName) AS customerName,
                users.phone, billingStreet, billingCity, billingState, billingZipCode
                FROM orders
                LEFT JOIN users ON orders.customerID=users.userID
                LEFT JOIN locations ON orders.locationID=locations.locationID
                LEFT JOIN customers ON orders.customerID=customers.customerID
                WHERE orderID = :order_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':order_id',$order_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_orderlines($order_id) {
    global $db;
    $query =   'SELECT orderLineID, items.itemID, unitPrice, quantity, unitPrice*Quantity AS totalPrice, status, name, picture, category, calories
                FROM orderlines JOIN
                        (SELECT itemID, menuitems.name, menuitems.picture, menucategories.name as category, calories
                        FROM menuitems JOIN menucategories USING(categoryID)) AS items
                        ON orderlines.itemID=items.itemID
                WHERE orderID = :order_id
                ORDER BY itemID;';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':order_id',$order_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function change_orderLine_status($orderLineId) {
    global $db;
    $query = 'UPDATE orderlines SET status= not status WHERE orderLineID = :orderLineId';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':orderLineId', $orderLineId);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_order($orderID) {
    global $db;
    $query = 'DELETE FROM orders WHERE orderID = :order_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':order_id', $orderID);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_order($order, $orderLines) {
    global $db;
    try {
        $db->beginTransaction();
        $orderQuery = 'INSERT INTO orders
                 (customerID, locationID, orderDateTime, pickupType, fulfillmentDateTime, orderComment,
                 shippingStreet, shippingCity, shippingState, shippingZipCode, status, created)
              VALUES
                 (:customerID, :locationID, sysdate(), :pickupType, sysdate(), :orderComment,
                  :shippingStreet, :shippingCity, :shippingState, :shippingZipCode, :status, sysdate())';

        $statement = $db->prepare($orderQuery);
        $statement->bindValue(':customerID', $order['customerID']);
        $statement->bindValue(':locationID', $order['locationID']);
        $statement->bindValue(':pickupType', $order['pickupType']);
        $statement->bindValue(':orderComment', $order['orderComment']);
        $statement->bindValue(':shippingStreet', $order['shippingStreet']);
        $statement->bindValue(':shippingCity', $order['shippingCity']);
        $statement->bindValue(':shippingState', $order['shippingState']);
        $statement->bindValue(':shippingZipCode', $order['shippingZipCode']);
        $statement->bindValue(':status', 'P');
        $statement->execute();
        $statement->closeCursor();
        $orderID = $db->lastInsertId();

        $orderLineQuery = 'INSERT INTO orderlines
                 (orderID, itemID, unitPrice, quantity, status) VALUES (:orderID, :itemID, :unitPrice, :quantity, 0)';

        foreach($orderLines as $orderLine) :
            $statement = $db->prepare($orderLineQuery);
            $statement->bindValue(':orderID', $orderID);
            $statement->bindValue(':itemID', $orderLine['itemID']);
            $statement->bindValue(':unitPrice', $orderLine['unitPrice']);
            $statement->bindValue(':quantity', $orderLine['quantity']);
            $statement->execute();
            $statement->closeCursor();
        endforeach;
        $db->commit();
        return $orderID;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $db->rollBack();
        display_db_error($error_message);
    }

}

?>