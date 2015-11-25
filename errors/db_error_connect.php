<?php require_once('../view/headerForAdmin.php'); ?>
    <div id="content">
        <h1>Database Error</h1>
        <p>An error occurred connecting to the database.</p>
        <p>Error message: <?php echo $error_message; ?></p>
        <p>&nbsp;</p>
    </div><!-- end content -->
<?php require_once('../view/footerForAdmin.php'); ?>