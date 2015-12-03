<?php

function get_best_by_customer($startDate, $endDate) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime>?";
        $conn = " AND ";
        $params[$counter++] = $startDate.' 00:00:00';
    }

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime<?";
        $params[$counter++] = $endDate.' 23:59:59';
    }

    $query =   'SELECT CustomerTotal.itemID, menuitems.name AS itemName, menucategories.name as category,
                customerTotal.customerID, users.firstName, users.lastName, users.phone, totOrder
                FROM
                    (SELECT itemID, SUM(quantity) AS totOrder, customerID
                     FROM orderlines JOIN (SELECT * FROM orders'.$where.') as orders USING(orderID)
                     GROUP BY customerID, itemID) AS customerTotal
                JOIN menuitems USING(itemID)
                JOIN menucategories USING(categoryID)
                JOIN users ON customerTotal.customerID=users.userID
                WHERE (itemID, totOrder) IN
                    (SELECT itemID, MAX(totOrder) AS TotOrder FROM
                        (SELECT itemID, SUM(quantity) AS totOrder, customerID
                         FROM orderlines JOIN (SELECT * FROM orders'.$where.') as orders USING(orderID)
                         GROUP BY customerID, itemID HAVING totOrder>1) AS customerTotal
                    GROUP BY itemID)
                ORDER BY totOrder DESC';

    try {
        $statement = $db->prepare($query);

        for ($count = 1; $count <= $counter; ++$count){
            $statement->bindValue($count, $params[$count-1]);
            $statement->bindValue($count+2, $params[$count-1]);
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

function get_best_by_frontDesk($startDate, $endDate) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime>?";
        $conn = " AND ";
        $params[$counter++] = $startDate.' 00:00:00';
    }

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime<?";
        $params[$counter++] = $endDate.' 23:59:59';
    }

    $query =   'SELECT employeeTotal.referby as employeeID, users.firstName, users.lastName, locations.name AS locationName,
                menuitems.name AS itemName, menucategories.name as category, itemID, totalOrder
                FROM
                    (SELECT referBy, itemID, SUM(quantity) as totalOrder
                     FROM (SELECT * FROM orders'.$where.') as orders JOIN orderlines USING(orderID)
                     GROUP BY referBy, orderlines.itemID) AS employeeTotal
                JOIN menuitems USING(itemID)
                JOIN menucategories USING(categoryID)
                JOIN employees ON employeeTotal.referBy=employees.employeeID
                JOIN locations ON locations.locationID=employees.locationID
                JOIN users ON employeeTotal.referBy=users.userID
                WHERE (referBy, totalOrder) IN
                    (SELECT referBy, MAX(totalOrder) AS totalOrder FROM
                        (SELECT referBy, itemID, SUM(quantity) as totalOrder
                         FROM (SELECT * FROM orders'.$where.') as orders JOIN orderlines USING(orderID)
                         GROUP BY referBy, orderlines.itemID) AS employeeTotal
                    GROUP BY referBy)
                ORDER BY totalOrder DESC';

    try {
        $statement = $db->prepare($query);

        for ($count = 1; $count <= $counter; ++$count){
            $statement->bindValue($count, $params[$count-1]);
            $statement->bindValue($count+2, $params[$count-1]);
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

function get_bestCustomer($startDate, $endDate, $pageSize) {
    global $db;
    $pageLimit = 10;
    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime>?";
        $conn = " AND ";
        $params[$counter++] = $startDate.' 00:00:00';
    }

    if(!empty($startDate)){
        $where = $where.$conn."orderDateTime<?";
        $params[$counter++] = $endDate.' 23:59:59';
    }

    if(!empty($pageSize)){
        $pageLimit = $pageSize;
    }

    $query =   'SELECT customerID, firstName, lastName, users.phone, customers.shippingStreet, customers.shippingCity,
                customers.shippingState, customers.shippingZipCode, SUM(totalOrder) as customerTotalOrder,
                locations.name as locationName
                FROM orders JOIN
                    (SELECT orderID, SUM(unitprice*quantity) AS totalOrder
                     FROM orderlines GROUP BY orderID) AS totOrder
                    USING(orderID)
                JOIN locations USING(locationID)
                JOIN customers USING(customerID)
                JOIN users ON orders.customerID=users.userID
                '.$where.'
                GROUP BY locationID, customerID
                ORDER BY customerTotalOrder DESC
                LIMIT 0, '.$pageLimit;

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

function get_DailySalesReport($date, $location) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($date)){
        $where = $where.$conn."cast(orderDateTime AS DATE)=?";
        $conn = " AND ";
        $params[$counter++] = $date;
    }

    if(!empty($location)){
        $where = $where.$conn."locationID=?";
        $params[$counter++] = $location;
    }

    $query =   'SELECT itemID, menuitems.name as itemName, menucategories.name AS category, SUM(quantity) AS totalQuantity,
                menuitems.unitPrice, SUM(orderlines.unitprice*orderlines.quantity) totalPrice
                FROM orderlines
                JOIN menuitems USING(itemID)
                JOIN menucategories ON menuitems.categoryID=menucategories.categoryID
                WHERE orderID IN
                    (SELECT orderID
                     FROM orders
                     '.$where.')
                GROUP BY itemID';

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
?>