<?php
    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/customer_db.php');

    $success_notification = '';
    $error_notification = '';

    if(isset($_POST['id'])){
        try {
            change_status($_POST['id'],$_POST['status']);
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
        $success_notification = 'Successfully changed';
        require_once('../../../util/notification.php');
}
?>