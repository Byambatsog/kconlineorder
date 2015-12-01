<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/order_db.php');

    $success_notification = '';
    $error_notification = '';

    if(isset($_POST['id'])){
        $ids = $_POST['id'];
        try {
            for($count = 0 ; $count < count($ids) ; $count++){
                $orderID = $ids[$count];
                delete_order($orderID);
            }

        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }

        $success_notification = 'Successfully deleted';
        require_once('../../util/notification.php');
    }
?>