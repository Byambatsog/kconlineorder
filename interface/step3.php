<?php
    require_once('../util/main.php');
    require_once('header.php');
    require_once('../model/database.php');
    require_once('../model/customer_db.php');
    require_once('../model/user_db.php');

    session_start();

    $login_error = '';
    $signup_error = '';

    if (!isset($_SESSION['order'])) {
        header("Location:step1.php");
    }

    if (!isset($_SESSION['orderLines'])) {
        header("Location:step2.php");
    }

    if(isset($_SESSION['customer'])){
        header("Location:step4.php");
    }

    if(isset($_POST['formType'])&&$_POST['formType']=='login'){
        if(empty($_POST['username'])||empty($_POST['password'])) {
            $login_error = 'You must enter your username or password';
        } else {
            try
            {
                $sql = 'SELECT userID, userName, status, cFlag, password FROM users WHERE userName = :uname LIMIT 1';
                $prestmt = $db->prepare($sql);
                $prestmt->bindValue(':uname', $_POST['username']);
                $prestmt->execute();
                $user = $prestmt->fetch();

                $userlogin = $_POST['username'];
                $userpwd = $_POST['password'];

                if (password_verify($userpwd,$user['password'])&&$user['status']=='E'&&$user['cFlag']=='1'){
                    $customer = get_customer($user['userID']);
                    $_SESSION['customer'] = $customer;
                    header("Location: step4.php");
                } else {
                    $login_error = 'Your username or password was incorrect';
                }

            }
            catch (PDOException $e)
            {
                display_db_error($e->getMessage());
            }
        }
    }

    $user = array();

    if(isset($_POST['formType'])&&$_POST['formType']=='signup'){

        $user['username'] = $_POST['username'];
        $user['email'] = $_POST['email'];
        $user['password'] = $_POST['password'];

        if(empty($_POST['username'])) {
            $signup_error = 'You must enter your username';
        } else if (empty($_POST['email'])){
            $signup_error = 'You must enter your e-mail';
        } else if (empty($_POST['password'])){
            $signup_error = 'You must enter your password';
        } else {
            try
            {
                if(!empty(get_user($user['username']))){
                    $signup_error = 'User name is chosen by another user';
                } else {

                    $customer = array();
                    $customer['userName'] = $user['username'];
                    $customer['password'] = password_hash($user['password'],PASSWORD_DEFAULT);;
                    $customer['firstName'] = $user['username'];
                    $customer['lastName'] = '';
                    $customer['emailAddress'] = $user['email'];

                    $userID = add_customerUser($customer);

                    $customer['customerID'] = $userID;
                    $customer['billingStreet'] = '';
                    $customer['billingCity'] = '';
                    $customer['billingState'] = '';
                    $customer['billingZipCode'] = '';
                    $customer['shippingStreet'] = '';
                    $customer['shippingCity'] = '';
                    $customer['shippingState'] = '';
                    $customer['shippingZipCode'] = '';
                    $customer['cardTypeID'] = 1;
                    $customer['cardNumber'] = '';
                    $customer['cardExpMonth'] = '';
                    $customer['cardExpYear'] = '';

                    add_customer($customer);

                    $_SESSION['customer'] = $customer;
                    header("Location: step4.php");
                }
            }
            catch (PDOException $e)
            {
                display_db_error($e->getMessage());
            }
        }
    }
?>
<div class="container">
<!-- /.row -->
<div class="back">
    <!-- Section Header -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 >User</h2>
        </div>
    </div>
    <!-- /.row -->

    <!-- Items Row -->
    <div class="row">
        <div class="col-md-offset-2 col-md-4 portfolio-item">
            <div class="choiceOuter orderMethod" id="Existinguser">
                <div class="choiceContainer">
                    <div class="choice step3">
                        <div class="form2">
                            <h3 >Existing User</h3><br>
                            <div style="color: red;"><?php echo $login_error;?></div>
                            <form action="step3.php" method="post" id="loginForm">
                                <input type="text" name="username" placeholder="username" size="20"><br>
                                <input type="password" name="password" placeholder="password" size="20">
                                <input type="hidden" name="formType" value="login">
                                <button type="submit" class="confirm">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 portfolio-item">
            <div class="choiceOuter orderMethod" id="Newuser">
                <div class="choiceContainer">
                    <div class="choice step3">
                        <div class="form2">
                            <h3 >New User</h3><br>
                            <div style="color: red;"><?php echo $signup_error;?></div>
                            <form action="step3.php" method="post" id="signupForm">
                                <input type="text" name="username"  placeholder="username" size="20" value="<?php if(isset($user['username'])) echo $user['username'];?>"><br>
                                <input type="text" name="email" placeholder="email" size="20" value="<?php if(isset($user['email'])) echo $user['email'];?>"><br>
                                <input type="password" name="password" placeholder="password" size="20" value="<?php if(isset($user['password'])) echo $user['password'];?>">
                                <input type="hidden" name="formType" value="signup">
                                <button type="submit" class="confirm">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
