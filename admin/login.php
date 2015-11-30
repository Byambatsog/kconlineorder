<?php
require_once('../util/main.php');
require_once('../model/database.php');
require_once('../model/employee_db.php');

$error_message = '';

if (!empty($_POST['username'])&&!empty($_POST['password']))
{
    try
    {
        $sql = 'SELECT userID, userName, status, eFlag, password FROM users WHERE userName = :uname LIMIT 1';
        $prestmt = $db->prepare($sql);
        $prestmt->bindValue(':uname', $_POST['username']);
        $prestmt->execute();
        $user = $prestmt->fetch();

        $userlogin = $_POST['username'];
        $userpwd = $_POST['password'];

        if (password_verify($userpwd,$user['password'])&&$user['status']=='E'&&$user['eFlag']=='1'){
            $employee = get_employee($user['userID']);
            session_start();
            $_SESSION['userId'] = $user['userID'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['employeeTitle'] = $employee['title'];

            header("Location: index.php");
        } else {
            $error_message = 'Your username or password was incorrect';
        }

    }
    catch (PDOException $e)
    {
        display_db_error($e->getMessage());
    }
}

?>


<!DOCTYPE html>
<html lang="en" class="login_page">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KC online ordering system</title>
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/css/blue.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/qtip2/jquery.qtip.min.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/css/style.css" />
</head>
<body>
<div class="login_box">
    <form action="" method="post" id="loginForm">
        <div class="top_b">KC online ordering system</div>
        <?php
            if (!empty($error_message)) {
                echo '<div class="alert alert-info alert-login">'.$error_message.'</div>';
            }
        ?>
        <div class="cnt_b">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
                    <input class="form-control input-sm" type="text" id="username" name="username" placeholder="Username" autofocus="autofocus"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
                    <input class="form-control input-sm" type="password" id="password" name="password" placeholder="Password"/>
                </div>
            </div>
        </div>
        <div class="btm_b clearfix">
            <button class="btn btn-default btn-sm pull-right" type="submit">Login</button>
        </div>
    </form>

</div>

<script src="<?php echo $app_path ?>gebo/js/jquery.min.js"></script>
<script src="<?php echo $app_path ?>gebo/js/jquery.actual.min.js"></script>
<script src="<?php echo $app_path ?>gebo/lib/validation/jquery.validate.js"></script>
<script src="<?php echo $app_path ?>gebo/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){

        form_wrapper = $('.login_box');
        function boxHeight() {
            form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);
        };
        form_wrapper.css({ marginTop : ( - ( form_wrapper.height() / 2) - 24) });
        $('.linkform a,.link_reg a').on('click',function(e){
            var target	= $(this).attr('href'),
                target_height = $(target).actual('height');
            $(form_wrapper).css({
                'height'		: form_wrapper.height()
            });
            $(form_wrapper.find('form:visible')).fadeOut(400,function(){
                form_wrapper.stop().animate({
                    height	 : target_height,
                    marginTop: ( - (target_height/2) - 24)
                },500,function(){
                    $(target).fadeIn(400);
                    $('.links_btm .linkform').toggle();
                    $(form_wrapper).css({
                        'height'		: ''
                    });
                });
            });
            e.preventDefault();
        });

        $('#login_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                username: { required: true, minlength: 3 },
                password: { required: true, minlength: 3 }
            },
            highlight: function(element) {
                $(element).closest('div').addClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            unhighlight: function(element) {
                $(element).closest('div').removeClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            errorPlacement: function(error, element) {
                $(element).closest('div').append(error);
            }
        });
    });
</script>

</body>
</html>
