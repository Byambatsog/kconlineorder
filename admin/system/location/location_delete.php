<?php
    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');

    $success_notification = '';
    $error_notification = '';

    if(isset($_POST['id'])){
        try {
            delete_location($_POST['id']);
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
        $success_notification = 'Successfully deleted';
        require_once('../../../util/notification.php');
    }
?>