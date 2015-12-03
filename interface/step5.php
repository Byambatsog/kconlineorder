<?php

    session_start();

    require_once('../util/main.php');
    require_once('header.php');


    if (!isset($_SESSION['order'])) {
        header("Location:step1.php");
    }

    if (!isset($_SESSION['orderLines'])) {
        header("Location:step2.php");
    }

    if(!isset($_SESSION['customer'])){
        header("Location:step3.php");
    }
?>

<div class="container">

    <div class="jumbotron" style="margin-top: 30px;">
        <h1>Thank you for your order!</h1>
        <p>Your order will be ready for pick up in 30 minutes.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Print Receipt</a></p>
    </div>

<?php

    include 'footer.php';
    unset($_SESSION['order']);
    unset($_SESSION['orderLines']);

?>

