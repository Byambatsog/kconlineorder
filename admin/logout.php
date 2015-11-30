<?php
    session_start();
    unset($_SESSION['userId']);
    unset($_SESSION['userName']);
    unset($_SESSION['employeeTitle']);
    session_destroy();
    header('Location: '.$app_path.'login.php');
?>