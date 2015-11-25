<?php
    require_once('../../util/main.php');
    require_once('../../util/tags.php');
    require_once('../../model/database.php');
    require_once('../../model/menu_item_db.php');

    $name = '';
    $categoryID = '';
    $status = '';
    $page = 1;
    $pageSize = 10;
    $orderField = '';
    $orderDirection = '';

    if(isset($_POST['name'])) $name = $_POST['name'];
    if(isset($_POST['category'])) $categoryID = $_POST['category'];
    if(isset($_POST['status'])) $status = $_POST['status'];
    if(isset($_POST['page'])) $page = $_POST['page'];
    if(isset($_POST['pageSize'])) $pageSize = $_POST['pageSize'];
    if(isset($_POST['orderField'])) $orderField = $_POST['orderField'];
    if(isset($_POST['orderDirection'])) $orderDirection = $_POST['orderDirection'];

    $items = get_items_by_filters($name, $categoryID, $status, $page, $pageSize, $orderField, $orderDirection);
    $total = get_itemSize_by_filters($name, $categoryID, $status);
?>

<script type="text/javascript">
    sodon_list = {
        refresh: function(){
            sodon_common.ajax('post','#list-target','item_list.php', $('#orderForm').serialize() + '&page=<?php echo $page?>'+$('#searchParams').val(),'');
        },
        paginate: function(page){
            sodon_common.ajax('post','#list-target','item_list.php', $('#orderForm').serialize() + '&page='+page+$('#searchParams').val(),'');
        },
        order: function(){
            sodon_common.ajax('post','#list-target','item_list.php', $('#orderForm').serialize() + $('#searchParams').val(),'');
        }
    }
</script>

<?php if (count($items) != 0) { ?>
    <div class="clearfix btSep">
        <div class="pull-left">
            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.delete();">
                <span class="text-danger">
                    <i class="glyphicon glyphicon-remove"></i> Delete
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
                        <option value="menuitems.name">Name</option>
                        <option value="menuitems.created">Created</option>
                        <option value="menucategories.ranking">Category</option>
                        <option value="menuitems.calories">Calories</option>
                        <option value="menuitems.unitPrice">Unit Price</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="orderDirection" name="orderDirection">
                        <option value="ASC">&uarr;</option>
                        <option value="DESC">&darr;</option>
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
                <th class="text-center" style="width: 40px;">ID</th>
                <th class="text-center" style="width: 110px;">Picture</th>
                <th class="text-center" style="width: 160px;">Name</th>
                <th class="text-center" style="width: 120px;">Category</th>
                <th class="text-center">Description</th>
                <th class="text-center" style="width: 80px;">Unit Price</th>
                <th class="text-center" style="width: 80px;">Calories</th>
                <th class="text-center" style="width: 80px;">Status</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($items) == 0) : ?>
                <tr><td style="text-align: center;" colspan="10">There are no menu items.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $item['itemID']; ?>" name="id"/></td>
                        <td class="text-center"><?php echo $item['itemID']; ?></td>
                        <td>
                            <img src="<?php echo $item['picture']; ?>" style="width: 100px; height: 60px;"/>
                        </td>
                        <td>
                            <a href="javascript:void(0)" onclick="sodon_main.create(<?php echo $item['itemID']; ?>);"><?php echo $item['name']; ?></a>
                        </td>
                        <td class="text-center"><?php echo $item['category']; ?></td>
                        <td><?php echo substring($item['description'], 0, 75); ?></td>
                        <td class="text-center"><?php echo $item['unitPrice']; ?>$</td>
                        <td class="text-center"><?php echo $item['calories']; ?>K</td>
                        <td class="text-center">
                            <?php if($item['status']=='E'){ ?>
                                <span class="text-success">Enabled</span>
                            <?php } else {?>
                                <span class="text-danger">Disabled</span>
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
