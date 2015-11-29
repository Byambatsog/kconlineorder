<?php
function get_customerSize_by_filters($filterValue) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($filterValue['userName'])){
        $where = $where.$conn."userName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['userName'].'%';
    }

    if(!empty($filterValue['firstName'])){
        $where = $where.$conn."firstName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['firstName'].'%';
    }

    if(!empty($filterValue['lastName'])){
        $where = $where.$conn."lastName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['lastName'].'%';
    }

    if(!empty($filterValue['street'])){
        $where = $where.$conn."billingStreet like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['street'].'%';
    }

    if(!empty($filterValue['zipCode'])){
        $where = $where.$conn."billingZipCode=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['zipCode'];
    }

    if(!empty($filterValue['phone'])){
        $where = $where.$conn."phone=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['phone'];
    }

    if(!empty($filterValue['eFlag'])){
        $where = $where.$conn."eFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['eFlag'];
    }

    if(!empty($filterValue['cFlag'])){
        $where = $where.$conn."cFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['cFlag'];
    }

    if(!empty($filterValue['status'])){
        $where = $where.$conn."status=?";
        $params[$counter++] = $filterValue['status'];
    }

    $query = 'SELECT count(*) FROM customers LEFT JOIN users ON customers.customerID=users.userID'.$where;

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


function get_customers_by_filters($filterValue, $page, $pageSize, $orderField, $orderDirection) {
    global $db;

    $orderBy = ' ORDER BY firstName ASC ';
    if(!empty($orderField)&&!empty($orderDirection))
        $orderBy = ' ORDER BY '.$orderField.' '.$orderDirection.' ';

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($filterValue['userName'])){
        $where = $where.$conn."userName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['userName'].'%';
    }

    if(!empty($filterValue['firstName'])){
        $where = $where.$conn."firstName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['firstName'].'%';
    }

    if(!empty($filterValue['lastName'])){
        $where = $where.$conn."lastName like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['lastName'].'%';
    }

    if(!empty($filterValue['street'])){
        $where = $where.$conn."billingStreet like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['street'].'%';
    }

    if(!empty($filterValue['zipCode'])){
        $where = $where.$conn."billingZipCode=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['zipCode'];
    }

    if(!empty($filterValue['phone'])){
        $where = $where.$conn."phone=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['phone'];
    }

    if(!empty($filterValue['eFlag'])){
        $where = $where.$conn."eFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['eFlag'];
    }

    if(!empty($filterValue['cFlag'])){
        $where = $where.$conn."cFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['cFlag'];
    }

    if(!empty($filterValue['status'])){
        $where = $where.$conn."status=?";
        $params[$counter++] = $filterValue['status'];
    }

    $query = 'SELECT customerID, userName, firstName, lastName, emailAddress, phone, billingStreet,
              billingCity, billingState, billingZipCode, status, discountPercentage
              FROM customers
              LEFT JOIN users ON customers.customerID=users.userID'
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

function get_customer($customer_id) {
    global $db;
    $query = 'SELECT * FROM
              (SELECT * FROM customers WHERE customerID = :customer_id) AS customer,
              (SELECT * FROM users WHERE userID = :user_id) AS user';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->bindValue(':user_id', $customer_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function change_status($customer_id, $status) {
    global $db;
    $query = 'UPDATE users SET status=:status WHERE userID = :user_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':user_id', $customer_id);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

?>