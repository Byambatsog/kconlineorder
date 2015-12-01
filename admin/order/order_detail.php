<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/order_db.php');

    $orderID = '';

    if(isset($_GET['orderID'])) {
        $orderID = $_GET['orderID'];
        $order = get_order($orderID);
        $orderLines = get_orderlines($orderID);
        $total = 0;
    } else {
        exit();
    }


?>
<div class="modal-header">
    <h3 class="modal-title">
        Order detail #<?php echo $orderID;?> - <?php echo $order['locationName'];?>
    </h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Name</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $order['customerName'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Order time</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $order['orderDateTime'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Phone</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $order['phone'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Billing address</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $order['billingStreet'].', '.$order['billingCity'].', '.$order['billingState'].' '.$order['billingZipCode']; ?>
                            </p>
                        </div>
                    </div>
                    <?php if($order['pickupType'] == 'D') { ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4"><strong>Shipping address</strong></label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <?php echo $order['shippingStreet'].', '.$order['shippingCity'].', '.$order['shippingState'].' '.$order['shippingZipCode']; ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="control-label col-sm-4"><strong>Comment</strong></label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $order['orderComment']; ?>
                            </p>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th class="text-center" style="width: 140px;">name</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Unit price</th>
                <th class="text-center">Total price</th>
                <th class="text-center">Ready ?</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($orderLines) == 0) : ?>
                <tr><td style="text-align: center;" colspan="5">There are no items.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($orderLines as $line) : ?>
                    <tr>
                        <td><?php echo $line['name'];?></td>
                        <td class="text-center"><?php echo $line['quantity']; ?></td>
                        <td class="text-center"><?php echo $line['unitPrice']; ?>$</td>
                        <td class="text-center"><?php echo $line['totalPrice']; ?>$</td>
                        <td class="text-center">
                            <div id="status-switch-<?php echo $line['orderLineID']; ?>" class="status-switch" data-on="info">
                                <input <?php if($line['status']){ ?>checked<?php }?> type="checkbox" >
                            </div>
                        </td>
                    </tr>
                    <?php $total = $total + $line['totalPrice'];?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td class="text-center"><strong><?php echo $total;?>$</strong></td>
                    <td class="text-center">&nbsp;</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        <?php foreach ($orderLines as $line) : ?>
            $('#status-switch-<?php echo $line['orderLineID']; ?>').bootstrapSwitch();
        <?php endforeach; ?>

        $('.status-switch').bootstrapSwitch('setSizeClass', 'switch-small');
        $('.status-switch').bootstrapSwitch('setOnLabel', 'Yes');
        $('.status-switch').bootstrapSwitch('setOffLabel', 'No');

        <?php foreach ($orderLines as $line) : ?>
            $('#status-switch-<?php echo $line['orderLineID']; ?>').on('switch-change', function () {
                sodon_main.changeStatus(<?php echo $line['orderLineID']; ?>);
            });
        <?php endforeach; ?>
    });
</script>