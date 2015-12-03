<?php
    require_once('../util/main.php');
    require_once('header.php');
    require_once('../model/database.php');
    require_once('../model/menu_category_db.php');
    require_once('../model/menu_item_db.php');

    session_start();

    if (!isset($_SESSION['order'])) {
        header("Location:step1.php");
    }


    if(isset($_POST['qty'])){

        $orderLines = array();

        $ids = $_POST['id'];
        $qtys = $_POST['qty'];

        $total = 0;
        for($count = 0 ; $count < count($ids) ; $count++){
            $itemID = $ids[$count];
            $quantity = $qtys[$count];

            if(!empty($quantity)){
                $item = get_item($itemID);
                $orderLine = array();
                $orderLine['itemID'] = $itemID;
                $orderLine['quantity'] = $quantity;
                $orderLine['unitPrice'] = $item['unitPrice'];
                $orderLine['picture'] = $item['picture'];
                $orderLine['name'] = $item['name'];

                $total += $item['unitPrice']*$quantity;

                $orderLines['item'.$itemID] = $orderLine;
            }
        }

        if(count($orderLines)>0) {
            $_SESSION['orderLines'] = $orderLines;
            $_SESSION['totalPrice'] = $total;
            header("Location:step3.php");
            exit();
        }

    }

    $categories = get_categories();
    $menuItems = get_items_by_filters('','','E',1,40,'menuitems.ranking','ASC');

?>

<div class="container">
    <form id="menuForm" action="step2.php" method="post">
        <?php foreach ($categories as $category) : ?>
            <div class="back step2">
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                        <h1 ><?php echo $category['name'];?></h1>
                    </div>
                </div>
                <div class="row">
                    <?php $counter = 0; ?>
                    <?php foreach ($menuItems as $item) : ?>
                        <?php if($category['categoryID']==$item['categoryID']) {?>


                            <div class="<?php if($counter==0) echo 'col-md-offset-1';?> col-md-2 portfolio-item">
                                <div class="choiceOuter" >
                                    <div class="choice <?php if(!empty($_SESSION['orderLines']['item'.$item['itemID']])) echo 'hasBorder';?>" id="item<?php echo $item['itemID'];?>" style="border-radius: 25px; background-image: url(<?php echo $item['picture'];?>); background-size: 100% 100%;">
                                    </div>
                                    <div class="tag">
                                        <h4><?php echo $item['name'];?></h4>
                                        <h5>$<?php echo $item['unitPrice'];?></h5>
                                        Qty:
                                        <input type="number" name="qty[]" id="itemQty<?php echo $item['itemID'];?>" min="0" max="10" value="<?php if(!empty($_SESSION['orderLines']['item'.$item['itemID']])) echo $_SESSION['orderLines']['item'.$item['itemID']]['quantity']; else echo 0;?>">
                                        <input type="hidden" name="id[]" id="id<?php echo $item['itemID'];?>" value="<?php echo $item['itemID'];?>">
                                        <button type="button" class="confirm" onclick="sodon_main.confirm(<?php echo $item['itemID'];?>);">Ok</button>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $counter++;
                        }
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <ul class="pager">
            <div class="text-right">
                <li><a href="step1.php">Previous</a></li>
                <li><a href="javascript:void(0);" onclick="$('#menuForm').submit(); return false;">Next</a></li>
            </div>
        </ul>
    </div>
</div>
<?php include 'footer.php'; ?>

<script>

    sodon_main = {
        confirm: function(id) {

            var chosed=false;

            if($('#itemQty'+id).val() < 0) $('#itemQty'+id).val(0);
            if($('#itemQty'+id).val() > 10) $('#itemQty'+id).val(10);
            if($('#itemQty'+id).val() > 0) chosed = true;

            if(!chosed){
                $('#item' + id).parents(".choiceOuter").children(".choice").removeClass("hasBorder");
            } else {
                $('#item' + id).parents(".choiceOuter").children(".choice").addClass("hasBorder");
            }
        }
    };

    $(".choiceOuter").mouseover(function(){
        $(this).find(".form").fadeIn(300);
    });


    $(".choiceOuter").mouseleave(function(){
            $(this).find(".form").fadeOut(300);
        }
    );

</script>
