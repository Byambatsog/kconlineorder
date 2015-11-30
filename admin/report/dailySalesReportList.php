<?php
    require_once('../../util/main.php');
    require_once('../../util/tags.php');
    require_once('../../model/database.php');
    require_once('../../model/report_db.php');

    $date = '';
    $location = '';
    $totalRevenue = 0;

    if(isset($_POST['date'])) $date = $_POST['date'];
    if(isset($_POST['locationID'])) $location = $_POST['locationID'];

    $report = get_DailySalesReport($date, $location);
?>

<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th class="text-center" style="width: 40px;">ID</th>
                <th class="text-center">Item name</th>
                <th class="text-center" style="width: 160px;">Category</th>
                <th class="text-center" style="width: 140px;">Total quantity</th>
                <th class="text-center" style="width: 120px;">Unit price</th>
                <th class="text-center" style="width: 120px;">Total price</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($report) == 0) : ?>
                <tr><td style="text-align: center;" colspan="7">There are no records.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($report as $row) : ?>
                    <tr>
                        <td class="text-center"><?php echo $row['itemID']; ?></td>
                        <td><?php echo $row['itemName']; ?></td>
                        <td class="text-center"><?php echo $row['category']; ?></td>
                        <td class="text-center"><?php echo $row['totalQuantity']; ?></td>
                        <td class="text-center"><?php echo $row['unitPrice']; ?>$</td>
                        <td class="text-center"><?php echo $row['totalPrice']; ?>$</td>
                    </tr>
                    <?php $totalRevenue = $totalRevenue + $row['totalPrice'];?>
                <?php endforeach; ?>
                <tr>
                    <td class="text-center">&nbsp;</td>
                    <td colspan="4"><strong>Total revenue</strong></td>
                    <td class="text-center"><strong><?php echo $totalRevenue; ?>$</strong></td>
                </tr>

            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>