<?php

function get_locations() {
    global $db;

    $query = 'SELECT locationID, name, locations.street, locations.city, locations.state, locations.zipCode,
              locations.coordinate, locations.phone, locations.fax, locations.emailAddress, timeTable, firstName as Manager
              FROM locations
              LEFT JOIN users ON locations.managerID=users.userID
              WHERE locations.status!=\'R\'
              ORDER BY name ASC';

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

function get_location($location_id) {
    global $db;
    $query = 'SELECT *
              FROM locations
              WHERE locationID = :location_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':location_id', $location_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_location($location) {
    global $db;
    $query = 'INSERT INTO locations
                 (name, street, city, state, zipCode, coordinate, phone, fax, emailAddress,
                  timeTable, managerID, status, created, createdBy)
              VALUES
                 (:name, :street, :city, :state, :zipCode, :coordinate, :phone, :fax,
                 :email_address, :time_table, :manager_id, :status, sysdate(), :created_by)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $location['name']);
        $statement->bindValue(':street', $location['street']);
        $statement->bindValue(':city', $location['city']);
        $statement->bindValue(':state', $location['state']);
        $statement->bindValue(':zipCode', $location['zipCode']);
        $statement->bindValue(':coordinate', '');
        $statement->bindValue(':phone', $location['phone']);
        $statement->bindValue(':fax', $location['fax']);
        $statement->bindValue(':email_address', $location['emailAddress']);
        $statement->bindValue(':time_table', $location['timeTable']);
        $statement->bindValue(':manager_id', $location['managerID']);
        $statement->bindValue(':status', 'E');
        $statement->bindValue(':created_by', $location['createdBy']);
        $statement->execute();
        $statement->closeCursor();

        $location_id = $db->lastInsertId();
        return $location_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_location($location) {
    global $db;
    $query = 'UPDATE locations
              SET name = :name,
                  street = :street,
                  city = :city,
                  state = :state,
                  zipCode = :zipCode,
                  phone = :phone,
                  fax = :fax,
                  emailAddress = :email_address,
                  timeTable = :time_table,
                  managerID = :manager_id
              WHERE locationID = :location_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $location['name']);
        $statement->bindValue(':street', $location['street']);
        $statement->bindValue(':city', $location['city']);
        $statement->bindValue(':state', $location['state']);
        $statement->bindValue(':zipCode', $location['zipCode']);
        $statement->bindValue(':phone', $location['phone']);
        $statement->bindValue(':fax', $location['fax']);
        $statement->bindValue(':email_address', $location['emailAddress']);
        $statement->bindValue(':time_table', $location['timeTable']);
        $statement->bindValue(':manager_id', $location['managerID']);
        $statement->bindValue(':location_id', $location['locationID']);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_location($locationID) {
    global $db;
    $query = 'UPDATE locations SET status=\'R\' WHERE locationID = :location_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':location_id', $locationID);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>