<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>King's Crown Online Ordering</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/3-col-portfolio.css" rel="stylesheet">

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="../gebo/js/jquery.form.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="line-height: 50px;" href="#">King's Crown</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav nav-pills nav-justified" style="line-height: 50px;">

                    <li <?php if(strpos($_SERVER['REQUEST_URI'], 'step1.php')!==false) echo 'class="active"'; ?>>
                        <a href="<?php echo $app_path.'interface/step1.php';?>">Order Now</a>
                    </li>
                    <li <?php if(strpos($_SERVER['REQUEST_URI'], 'step2.php')!==false) echo 'class="active"'; ?>>
                        <a href="<?php echo $app_path.'interface/step2.php';?>">Menu</a>
                    </li>
                    <li <?php if(strpos($_SERVER['REQUEST_URI'], 'step4.php')!==false) echo 'class="active"'; ?>>
                        <a href="<?php echo $app_path.'interface/step4.php';?>">Payment</a>
                    </li>
                    <li <?php if(strpos($_SERVER['REQUEST_URI'], 'step5.php')!==false) echo 'class="active"'; ?>>
                        <a href="<?php echo $app_path.'interface/step5.php';?>">Done!</a>
                    </li>
                    <li>
                        <?php if(!empty($_SESSION['customer'])) { ?>
                            <a href="logout.php">Log out</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <div>

            </div>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>