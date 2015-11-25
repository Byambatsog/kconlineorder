<?php
function get_itemSize_by_filters($name, $categoryID, $status) {
    global $db;

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($name)){
        $where = $where.$conn."menuitems.name like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$name.'%';
    }

    if(!empty($categoryID)){
        $where = $where.$conn."menuitems.categoryID=?";
        $conn = " AND ";
        $params[$counter++] = $categoryID;
    }

    if(!empty($status)){
        $where = $where.$conn."menuitems.status=?";
        $params[$counter++] = $status;
    }

    $query = 'SELECT count(*) FROM menuitems'.$where;

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


function get_items_by_filters($name, $categoryID, $status, $page, $pageSize, $orderField, $orderDirection) {
    global $db;

    $orderBy = ' ORDER BY menuitems.name ASC ';
    if(!empty($orderField)&&!empty($orderDirection))
        $orderBy = ' ORDER BY '.$orderField.' '.$orderDirection.' ';

    $counter = 0;
    $where = '';
    $params = array();
    $conn = ' WHERE ';

    if(!empty($name)){
        $where = $where.$conn."menuitems.name like ?";
        $conn = " AND ";
        $params[$counter++] = '%'.$name.'%';
    }

    if(!empty($categoryID)){
        $where = $where.$conn."menuitems.categoryID=?";
        $conn = " AND ";
        $params[$counter++] = $categoryID;
    }

    if(!empty($status)){
        $where = $where.$conn."menuitems.status=?";
        $params[$counter++] = $status;
    }

    $query = 'SELECT itemID, menuitems.name, menucategories.name AS category, description, menuitems.picture,
              unitPrice, calories, menuitems.status
              FROM menuitems
              LEFT JOIN menucategories ON menuitems.categoryID=menucategories.categoryID'
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

function get_item($item_id) {
    global $db;
    $query = 'SELECT *
              FROM menuitems
              WHERE itemID = :item_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_item($item) {
    global $db;
    $query = 'INSERT INTO menuitems
                 (categoryID, name, picture, description,
                  unitPrice, calories, ranking, status, created, createdBy)
              VALUES
                 (:category_id, :name, :picture, :description,
                  :unit_price, :calories, :ranking, :status, sysdate(), :created_by)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $item['categoryID']);
        $statement->bindValue(':name', $item['name']);
        $statement->bindValue(':picture', $item['picture']);
        $statement->bindValue(':description', $item['description']);
        $statement->bindValue(':unit_price', $item['unitPrice']);
        $statement->bindValue(':calories', $item['calories']);
        $statement->bindValue(':ranking', $item['ranking']);
        $statement->bindValue(':status', $item['status']);
        $statement->bindValue(':created_by', $item['createdBy']);
        $statement->execute();
        $statement->closeCursor();

        // Get the last product ID that was automatically generated
        $item_id = $db->lastInsertId();
        return $item_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_item($item) {
    global $db;
    $query = 'UPDATE menuitems
              SET categoryID = :category_id,
                  name = :name,
                  picture = :picture,
                  description = :description,
                  unitPrice = :unit_price,
                  calories = :calories,
                  ranking = :ranking,
                  status = :status
              WHERE itemID = :item_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $item['categoryID']);
        $statement->bindValue(':name', $item['name']);
        $statement->bindValue(':picture', $item['picture']);
        $statement->bindValue(':description', $item['description']);
        $statement->bindValue(':unit_price', $item['unitPrice']);
        $statement->bindValue(':calories', $item['calories']);
        $statement->bindValue(':ranking', $item['ranking']);
        $statement->bindValue(':status', $item['status']);
        $statement->bindValue(':item_id', $item['itemID']);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_item($itemID) {
    global $db;
    $query = 'DELETE FROM menuitems WHERE itemID = :item_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $itemID);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>