<?php
    session_start();
    unset($_SESSION['order']);
    unset($_SESSION['orderLines']);
    unset($_SESSION['customer']);
    session_destroy();
    header('Location: '.$app_path.'step1.php');
?>