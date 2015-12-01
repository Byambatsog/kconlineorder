<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/order_db.php');

    $locationID = '';
    $date = '';
    $status = '';
    $pickupType = '';
    $customer = '';
    $street = '';
    $zipCode = '';
    $page = 1;
    $pageSize = 10;
    $orderField = '';
    $orderDirection = '';

    if(isset($_POST['locationID'])) $locationID = $_POST['locationID'];
    if(isset($_POST['filterDate'])) $date = $_POST['filterDate'];
    if(isset($_POST['status'])) $status = $_POST['status'];
    if(isset($_POST['pickupType'])) $pickupType = $_POST['pickupType'];
    if(isset($_POST['customer'])) $customer = $_POST['customer'];
    if(isset($_POST['street'])) $street = $_POST['street'];
    if(isset($_POST['zipCode'])) $zipCode = $_POST['zipCode'];
    if(isset($_POST['page'])) $page = $_POST['page'];
    if(isset($_POST['pageSize'])) $pageSize = $_POST['pageSize'];
    if(isset($_POST['orderField'])) $orderField = $_POST['orderField'];
    if(isset($_POST['orderDirection'])) $orderDirection = $_POST['orderDirection'];

    $orders = get_orders_by_filters($locationID, $date, $status, $pickupType, $customer, $street, $zipCode, $page, $pageSize, $orderField, $orderDirection);
    $total = get_orderSize_by_filters($locationID, $date, $status, $pickupType, $customer, $street, $zipCode);


?>


<script type="text/javascript">
    sodon_list = {
        refresh: function(){
            sodon_common.ajax('post','#list-target','order_list.php', $('#orderForm').serialize() + '&page=<?php echo $page?>'+$('#searchParams').val(),'');
        },
        paginate: function(page){
            sodon_common.ajax('post','#list-target','order_list.php', $('#orderForm').serialize() + '&page='+page+$('#searchParams').val(),'');
        },
        order: function(){
            sodon_common.ajax('post','#list-target','order_list.php', $('#orderForm').serialize() + $('#searchParams').val(),'');
        }
    }
</script>

<?php if (count($orders) != 0) { ?>
    <div class="clearfix btSep">
        <div class="pull-left">
            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.delete();">
                <span class="text-danger">
                    <i class="glyphicon glyphicon-remove"></i> Delete
                </span>
            </button>
            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.create();">
                <span class="text-success">
                    <i class="glyphicon glyphicon-info-sign"></i> Create
                </span>
            </button>
        </div>
        <div class="pull-right">

            <form class="form-inline" id="orderForm" role="form">

                <div class="form-group">
                    Page size
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="pageSize" name="pageSize">
                        <option>10</option>
                        <option>20</option>
                        <option>30</option>
                        <option>40</option>
                        <option>50</option>
                    </select>
                </div>

                <div class="form-group">
                    Order by
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="orderField" name="orderField">
                        <option value="orders.orderDateTime">Order time</option>
                        <option value="orders.fulfillmentDateTime">Fulfillment Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="orderDirection" name="orderDirection">
                        <option value="DESC">&darr;</option>
                        <option value="ASC">&uarr;</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
<?php } ?>


<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th style="width: 1px;"><input type="checkbox" onclick="return sodon_common.checkAll(this);"/></th>
                <th class="text-center" style="width: 1px;">ID</th>
                <th class="text-center" style="width: 160px;">Customer</th>
                <th class="text-center">Order Time</th>
                <th class="text-center">Total price</th>
                <th class="text-center"># of Items</th>
                <th class="text-center">Pickup Type</th>
                <th class="text-center">Phone</th>
                <th class="text-center">Status</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($orders) == 0) : ?>
                <tr><td style="text-align: center;" colspan="9">There are no orders.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $order['orderID']; ?>" name="id[]" id="id"/></td>
                        <td><?php echo $order['orderID']; ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="sodon_main.detail(<?php echo $order['orderID']; ?>);"><?php echo $order['customerName']; ?></a>
                        </td>
                        <td class="text-center"><?php echo $order['orderDateTime']; ?></td>
                        <td class="text-center"><?php echo $order['totalPayment']; ?>$</td>
                        <td class="text-center"><?php echo $order['totalQuantity']; ?></td>
                        <td class="text-center">
                            <?php if($order['pickupType']=='D'){ ?>
                                <span class="text-success">Delivery</span>
                            <?php } else {?>
                                <span class="text-primary">Pick up</span>
                            <?php }?>
                        </td>
                        <td class="text-center"><?php echo $order['phone']; ?></td>
                        <td class="text-center">
                            <?php if($order['status']=='P'){ ?>
                                <span class="text-danger">Pending</span>
                            <?php } else if($order['status']=='S') {?>
                                <span class="text-danger">Processing</span>
                            <?php } else if($order['status']=='R') {?>
                                <span class="text-info">Ready</span>
                            <?php } else if($order['status']=='C') {?>
                                <span class="text-success">Completed</span>
                            <?php }?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

<?php require('../../util/pagination.php');?>

<script type="text/javascript">

    $('body,html').animate({scrollTop: 0}, 0);

    $( "#pageSize" ).change(function() {
        sodon_list.order();
    });
    $( "#orderField" ).change(function() {
        sodon_list.order();
    });
    $( "#orderDirection" ).change(function() {
        sodon_list.order();
    });

    <?php if(!empty($pageSize)){?>
    $("#pageSize").val('<?php echo $pageSize;?>');
    <?php } ?>

    <?php if(!empty($orderField)){?>
    $("#orderField").val('<?php echo $orderField;?>');
    <?php } ?>
    <?php if(!empty($orderDirection)){ ?>
    $("#orderDirection").val('<?php echo $orderDirection;?>');
    <?php } ?>
</script>
