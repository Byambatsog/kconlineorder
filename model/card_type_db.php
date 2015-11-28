<?php
function get_card_types() {
    global $db;
    $query = 'SELECT cardTypeID, description FROM cardtypes ORDER BY cardTypeID ASC';
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

function get_card_type($type_id) {
    global $db;
    $query = 'SELECT *
              FROM cardtypes
              WHERE cardTypeID = :type_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':type_id', $type_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_card_type($type) {
    global $db;
    $query = 'INSERT INTO cardtypes
                 (cardTypeId, description)
              VALUES
                 (:type_id, :description)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':type_id', $type['cardTypeID']);
        $statement->bindValue(':description', $type['description']);
        $statement->execute();
        $statement->closeCursor();

        // Get the last product ID that was automatically generated
        $type_id = $db->lastInsertId();
        return $type_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_card_type($type) {
    global $db;
    $query = 'UPDATE cardtypes
              SET description = :description
              WHERE cardTypeId = :type_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':type_id', $type['cardTypeID']);
        $statement->bindValue(':description', $type['description']);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>