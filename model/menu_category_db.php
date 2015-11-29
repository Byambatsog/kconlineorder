<?php
function get_categories() {
    global $db;
    $query = 'SELECT categoryID, name, picture, ranking, status FROM menucategories WHERE status="E" ORDER BY ranking ASC';
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

function get_categories_by_filters($status) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($status)){
        $where = $where.$conn."status=?";
        $params[$counter++] = $status;
    }

    $query = 'SELECT categoryID, name, picture, ranking, status FROM menucategories '.$where.' ORDER BY ranking ASC';
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

function get_category($category_id) {
    global $db;
    $query = 'SELECT *
              FROM menucategories
              WHERE categoryID = :category_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_category($category) {
    global $db;
    $query = 'INSERT INTO menucategories
                 (name, ranking, status, created, createdBy)
              VALUES
                 (:name, :ranking, :status, sysdate(), :created_by)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $category['name']);
        $statement->bindValue(':ranking', $category['ranking']);
        $statement->bindValue(':status', $category['status']);
        $statement->bindValue(':created_by', $category['createdBy']);
        $statement->execute();
        $statement->closeCursor();

        // Get the last product ID that was automatically generated
        $category_id = $db->lastInsertId();
        return $category_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_category($category) {
    global $db;
    $query = 'UPDATE menucategories
              SET name = :name,
                  ranking = :ranking,
                  status = :status
              WHERE categoryID = :category_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $category['name']);
        $statement->bindValue(':ranking', $category['ranking']);
        $statement->bindValue(':status', $category['status']);
        $statement->bindValue(':category_id', $category['categoryID']);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_category($categoryID) {
    global $db;
    $query = 'DELETE FROM menucategories WHERE categoryID = :category_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $categoryID);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>