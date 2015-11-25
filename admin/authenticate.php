<?php
    session_start();
    if(!isset($_SESSION['userId'])) {
        header('Location: '.$app_path.'admin/login.php');
    }
?>