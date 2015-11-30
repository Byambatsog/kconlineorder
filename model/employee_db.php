<?php

function get_managers() {
    global $db;

    $query = 'SELECT employeeID, firstName, lastName, title
              FROM employees,
              (SELECT * FROM users WHERE eFlag=1) AS employeeUser
              WHERE (title=\'Manager\' OR title=\'Executive\')
              AND employees.employeeID=employeeUser.userID
              ORDER BY firstName';

    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function get_employeeSize_by_filters($filterValue) {
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
        $where = $where.$conn."users.street like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['street'].'%';
    }

    if(!empty($filterValue['zipCode'])){
        $where = $where.$conn."users.zipCode=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['zipCode'];
    }

    if(!empty($filterValue['phone'])){
        $where = $where.$conn."users.phone=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['phone'];
    }

    if(!empty($filterValue['eFlag'])){
        $where = $where.$conn."eFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['eFlag'];
    }

    if(!empty($filterValue['title'])){
        $where = $where.$conn."title=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['title'];
    }

    if(!empty($filterValue['supervisorID'])){
        $where = $where.$conn."supervisorID=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['supervisorID'];
    }

    if(!empty($filterValue['locationID'])){
        $where = $where.$conn."employees.locationID=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['locationID'];
    }

    if(!empty($filterValue['status'])){
        $where = $where.$conn."users.status=?";
        $params[$counter++] = $filterValue['status'];
    }  else {
        $where = $where.$conn."users.status!=?";
        $params[$counter++] = 'R';
    }

    $query = 'SELECT count(*) FROM employees
              LEFT JOIN users ON employees.employeeID=users.userID
              LEFT JOIN locations ON employees.locationID=locations.locationID'
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


function get_employees_by_filters($filterValue, $page, $pageSize, $orderField, $orderDirection) {
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
        $where = $where.$conn."users.street like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$filterValue['street'].'%';
    }

    if(!empty($filterValue['zipCode'])){
        $where = $where.$conn."users.zipCode=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['zipCode'];
    }

    if(!empty($filterValue['phone'])){
        $where = $where.$conn."users.phone=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['phone'];
    }

    if(!empty($filterValue['eFlag'])){
        $where = $where.$conn."eFlag=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['eFlag'];
    }

    if(!empty($filterValue['title'])){
        $where = $where.$conn."title=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['title'];
    }

    if(!empty($filterValue['supervisorID'])){
        $where = $where.$conn."supervisorID=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['supervisorID'];
    }

    if(!empty($filterValue['locationID'])){
        $where = $where.$conn."employees.locationID=?";
        $conn = " AND ";
        $params[$counter++] = $filterValue['locationID'];
    }

    if(!empty($filterValue['status'])){
        $where = $where.$conn."users.status=?";
        $params[$counter++] = $filterValue['status'];
    } else {
        $where = $where.$conn."users.status!=?";
        $params[$counter++] = 'R';
    }

    $query = 'SELECT employeeID, userName, firstName, lastName, users.emailAddress, users.phone, users.street,
              users.city, users.state, users.zipCode, users.status, title, birthDate, dateHired, locations.name AS locationName
              FROM employees
              LEFT JOIN users ON employees.employeeID=users.userID
              LEFT JOIN locations ON employees.locationID=locations.locationID'
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

function get_employee($employee_id) {
    global $db;
    $query = 'SELECT * FROM
              (SELECT * FROM employees WHERE employeeID = :employee_id) AS employee,
              (SELECT * FROM users WHERE userID = :user_id) AS user';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':employee_id', $employee_id);
        $statement->bindValue(':user_id', $employee_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_employee($employee) {
    global $db;
    $user_id = '';
    $userQuery = 'INSERT INTO users
                 (userName, password, firstName, lastName, street, city, state, zipCode,
                  emailAddress, phone, status, eFlag, cFlag, created)
              VALUES
                 (:userName, :password, :firstName, :lastName, :street, :city, :state, :zipCode,
                 :emailAddress, :phone, :status, :eFlag, :cFlag, sysdate())';
    try {
        $statement = $db->prepare($userQuery);
        $statement->bindValue(':userName', $employee['userName']);
        $statement->bindValue(':password', $employee['password']);
        $statement->bindValue(':firstName', $employee['firstName']);
        $statement->bindValue(':lastName', $employee['lastName']);
        $statement->bindValue(':street', $employee['street']);
        $statement->bindValue(':city', $employee['city']);
        $statement->bindValue(':state', $employee['state']);
        $statement->bindValue(':zipCode', $employee['zipCode']);
        $statement->bindValue(':emailAddress', $employee['emailAddress']);
        $statement->bindValue(':phone', $employee['phone']);
        $statement->bindValue(':eFlag', '1');
        $statement->bindValue(':cFlag', '0');
        $statement->bindValue(':status', $employee['status']);
        $statement->execute();
        $statement->closeCursor();
        $user_id = $db->lastInsertId();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }

    $employeeQuery = 'INSERT INTO employees
                 (employeeID, title, birthDate, dateHired, supervisorID, locationID)
              VALUES
                 (:employeeID, :title, :birthDate, :dateHired, :supervisorID, :locationID)';

    try {
        $statement = $db->prepare($employeeQuery);
        $statement->bindValue(':employeeID', $user_id);
        $statement->bindValue(':title', $employee['title']);
        $statement->bindValue(':birthDate', $employee['birthDate']);
        $statement->bindValue(':dateHired', $employee['dateHired']);
        $statement->bindValue(':supervisorID', $employee['supervisorID']);
        $statement->bindValue(':locationID', $employee['locationID']);
        $statement->execute();
        $statement->closeCursor();
        return $user_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_employee($employee) {
    global $db;
    $userQuery = 'UPDATE users
              SET userName = :userName,
                  password = :password,
                  firstName = :firstName,
                  lastName = :lastName,
                  street = :street,
                  city = :city,
                  state = :state,
                  zipCode = :zipCode,
                  phone = :phone,
                  status = :status,
                  emailAddress = :emailAddress
              WHERE userID = :userID';
    try {
        $statement = $db->prepare($userQuery);
        $statement->bindValue(':userName', $employee['userName']);
        $statement->bindValue(':password', $employee['password']);
        $statement->bindValue(':firstName', $employee['firstName']);
        $statement->bindValue(':lastName', $employee['lastName']);
        $statement->bindValue(':street', $employee['street']);
        $statement->bindValue(':city', $employee['city']);
        $statement->bindValue(':state', $employee['state']);
        $statement->bindValue(':zipCode', $employee['zipCode']);
        $statement->bindValue(':emailAddress', $employee['emailAddress']);
        $statement->bindValue(':phone', $employee['phone']);
        $statement->bindValue(':status', $employee['status']);
        $statement->bindValue(':userID', $employee['employeeID']);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }

    $employeeQuery = 'UPDATE employees
              SET title = :title,
                  birthDate = :birthDate,
                  dateHired = :dateHired,
                  supervisorID = :supervisorID,
                  locationID = :locationID
              WHERE employeeID = :employeeID';
    try {
        $statement = $db->prepare($employeeQuery);
        $statement->bindValue(':title', $employee['title']);
        $statement->bindValue(':birthDate', $employee['birthDate']);
        $statement->bindValue(':dateHired', $employee['dateHired']);
        $statement->bindValue(':supervisorID', $employee['supervisorID']);
        $statement->bindValue(':locationID', $employee['locationID']);
        $statement->bindValue(':employeeID', $employee['employeeID']);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_employee($employeeID) {
    global $db;
    $query = 'UPDATE users SET status=\'R\' WHERE userID = :user_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $employeeID);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>