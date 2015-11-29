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

?>