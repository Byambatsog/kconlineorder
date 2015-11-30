<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- the head section -->
<head>
    <title>KC online ordering system</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Management System</title>
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>sodon/js/datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/jquery-ui/css/Aristo/Aristo.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/sticky/sticky.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/tag_handler/css/jquery.taghandler.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/bootstrap-switch/static/stylesheets/bootstrap-switch.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/img/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/lib/smoke/themes/gebo.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/css/style.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>gebo/css/blue.css" />
    <link rel="stylesheet" href="<?php echo $app_path ?>sodon/css/style.css?v=1" />

    <script src="<?php echo $app_path ?>gebo/js/jquery.min.js"></script>
    <script src="<?php echo $app_path ?>gebo/js/jquery.form.min.js"></script>

    <script type="text/javascript">
        sodon_common = {
            ajax: function(method,container,url,param,complete) {
                $.ajax({
                    url: url,
                    data: param,
                    type: method,
                    dataType: "html",
                    beforeSend : function(){
                        $(container).html('' +
                            '<div style="text-align: center; margin: 50px 0;">'+
                            '<img src="<?php echo $app_path ?>sodon/img/loader.gif" width="16" height="16"/>'+
                        '</div>'+
                        '');
                    },
                    success : function(data){
                        $(container).html(data);
                        if(complete != ''){
                            eval(complete);
                        }
                    },
                    complete:function(){

                    }
                });
            },
            ajaxSimple: function(method,container,url,param,complete) {
                $.ajax({
                    url: url,
                    data: param,
                    type: method,
                    dataType: "html",
                    success : function(data){
                        $(container).html(data);
                        if(complete != ''){
                            eval(complete);
                        }
                    },
                    complete:function(){

                    }
                });
            },
            checkAll: function(object){
                if(object.checked){
                    $("input[name=id]").each(function(p,q){
                        $(q).attr("checked","checked");
                    });
                }
                else{
                    $("input[name=id]").each(function(p,q){
                        $(q).removeAttr("checked");
                    });
                }
            },
            getFileName: function(path){
                var slash = path.lastIndexOf('/');
                var bslash = path.lastIndexOf('\\');
                var fileName;
                if (slash == -1 && bslash == -1) {
                    fileName = path.substr(0,path.lastIndexOf("."));
                } else if (slash > bslash) {
                    fileName = path.substring(slash+1, path.lastIndexOf("."));
                } else {
                    fileName = path.substring(bslash+1, path.lastIndexOf("."));
                }
                return fileName;
            },
            validateInteger: function(self){
                var strValue;
                var intValue;
                strValue = $(self).val();
                if (strValue==null||strValue=="") {
                    $(self).val(strValue);
                    return;
                }
                if (isNaN(parseInt(strValue))){
                    intValue = "";
                }
                else{
                    intValue = parseInt(strValue);
                }
                $(self).val(intValue);
            },
            validateFloat: function(self){
                var strValue;
                var floatValue;
                strValue = $(self).val();
                if (strValue==null||strValue=="") {
                    $(self).val(strValue);
                    return;
                }
                if (isNaN(parseFloat(strValue))){
                    floatValue = "";
                }
                else{
                    floatValue = parseFloat(strValue);
                }
                $(self).val(floatValue);
            }
        };

        $(document).ready(function(){
            $('#createModal').on('shown.bs.modal', function () {
                $('#createModal').animate({ scrollTop: 0 }, 'slow');
            });
        });

    </script>
</head>

<!-- the body section -->
<body class="full_width sidebar_hidden">
    <div id="maincontainer" class="clearfix">
        <header>
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand pull-left" href="">King's crown</a>
                        <?php

                            if(isset($_SESSION['employeeTitle'])&&($_SESSION['employeeTitle']=='Manager'||$_SESSION['employeeTitle']=='Executive')) {

                        ?>

                            <ul class="nav navbar-nav" id="mobile-nav">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo $app_path.'admin/order/index.php';?>">Orders </a>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Users <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo $app_path.'admin/user/employee/index.php';?>">Employees</a></li>
                                        <li><a href="<?php echo $app_path.'admin/user/customer/index.php';?>">Customers</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Menu <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo $app_path.'admin/menu/index.php';?>">Menu items</a></li>
                                        <li><a href="<?php echo $app_path.'admin/menu/category/index.php';?>">Menu item categories</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Reports <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo $app_path.'admin/report/dailySalesReport.php';?>">Daily Sales Report</a></li>
                                        <li><a href="<?php echo $app_path.'admin/report/bestByCustomer.php';?>">Best By Customer</a></li>
                                        <li><a href="<?php echo $app_path.'admin/report/bestByFrontDesk.php';?>">Best By Front Desk</a></li>
                                        <li><a href="<?php echo $app_path.'admin/report/bestCustomers.php';?>">Best Customers</a></li>

<!--                                        <li><a href="--><?php //echo $app_path.'admin/menu/category/index.php';?><!--">Menu item categories</a></li>-->
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">System <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo $app_path.'admin/system/giftcard/index.php';?>">Gift cards</a></li>
                                        <li><a href="<?php echo $app_path.'admin/system/cardtype/index.php';?>">Card types</a></li>
                                        <li><a href="<?php echo $app_path.'admin/system/location/index.php';?>">Locations</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>
                        <ul class="nav navbar-nav user_menu pull-right">
                            <li class="divider-vertical hidden-sm hidden-xs"></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--                                    <security:authentication property="principal.user.loginname"/> -->
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
<!--                                    <li><a href="">Change password</a></li>-->
<!--                                    <li class="divider"></li>-->
                                    <li><a href="<?php echo $app_path.'admin/logout.php';?>">Log out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div id="contentwrapper">
            <div class="main_content">

