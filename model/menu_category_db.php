<?php
function get_categories() {
    global $db;
    $query = 'SELECT categoryID, name, picture, ranking, status FROM menucategories';
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