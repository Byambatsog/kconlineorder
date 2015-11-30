<?php
    require_once('../../util/main.php');
    require_once('../../util/tags.php');
    require_once('../../model/database.php');
    require_once('../../model/report_db.php');

    $startDate = '';
    $endDate = '';
    $pageSize = '';

    if(isset($_POST['startDate'])) $startDate = $_POST['startDate'];
    if(isset($_POST['endDate'])) $endDate = $_POST['endDate'];
    if(isset($_POST['pageSize'])) $pageSize = $_POST['pageSize'];

    $report = get_bestCustomer($startDate, $endDate, $pageSize);
?>

<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th class="text-center" style="width: 40px;">ID</th>
                <th class="text-center" style="width: 160px;">Customer name</th>
                <th class="text-center" style="width: 100px;">Total Buy</th>
                <th class="text-center" style="width: 110px;">Phone</th>
                <th class="text-center">Address</th>
                <th class="text-center" style="width: 160px;">Location</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($report) == 0) : ?>
                <tr><td style="text-align: center;" colspan="7">There are no records.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($report as $row) : ?>
                    <tr>
                        <td class="text-center"><?php echo $row['customerID']; ?></td>
                        <td><?php echo $row['firstName'].' '.$row['lastName']; ?></td>
                        <td class="text-center"><?php echo $row['customerTotalOrder']; ?>$</td>
                        <td class="text-center"><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['shippingStreet'].', '.$row['shippingCity'].', '.$row['shippingState'].' '.$row['shippingZipCode']; ?></td>
                        <td class="text-center"><?php echo $row['locationName']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
<div class="clearfix">
    <div class="pull-right">
        Total: <?php echo count($report); ?>
    </div>
</div>