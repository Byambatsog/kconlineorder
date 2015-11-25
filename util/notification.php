<div id="success_alert"><?php echo $success_notification;?></div>
<div id="error_alert"><?php echo $error_notification;?></div>
<script type="text/javascript">
    $(document).ready(function(){
        <?php if(!empty($success_notification)) { ?>
            $.sticky($('#success_alert').text(), {autoclose : 5000, position: "top-right", type: "st-success" });
        <?php } ?>
        <?php if(!empty($error_notification)) { ?>
            $.sticky($('#error_alert').text(), {autoclose : 5000, position: "top-right", type: "st-error" });
        <?php } ?>
    });
</script>


