<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/menu_item_db.php');
    require_once('../../model/menu_category_db.php');

    $success_notification = '';
    $error_notification = '';

    $categories = get_categories();
    $itemID = '';

    if(isset($_POST['itemID'])){

        $itemID = $_POST['itemID'];

        try {
            $item = array();
            $item['itemID'] = $_POST['itemID'];
            $item['categoryID'] = $_POST['categoryID'];
            $item['name'] = $_POST['name'];
            $item['picture'] = $_POST['picture'];
            $item['description'] = $_POST['description'];
            $item['unitPrice'] = $_POST['unitPrice'];
            $item['calories'] = $_POST['calories'];
            $item['ranking'] = $_POST['ranking'];
            if(isset($_POST['status'])) $item['status'] = 'E';
            else $item['status'] = 'D';
            $item['ranking'] = $_POST['ranking'];


            if(empty($item['itemID'])){
                session_start();
                $item['createdBy'] = $_SESSION['userId'];
                add_item($item);
            } else {
                update_item($item);
            }
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }

        $success_notification = 'Successfully saved';



//        // Validate inputs
//        if (empty($code) || empty($name) || empty($description) ||
//            empty($price) ) {
//            $error = 'Invalid product data.
//                      Check all fields and try again.';
//            include('../../errors/error.php');
//        } else {
//            $categories = get_categories();
//            $product_id = add_product($category_id, $code, $name,
//                $description, $price, $discount_percent);
//            $product = get_product($product_id);
//            include('product_view.php');
//        }
    } else {
        if(isset($_GET['itemID'])) $itemID = $_GET['itemID'];
        if(!empty($itemID)) $item = get_item($itemID);
    }

?>

<script type="text/javascript">
    sodon_create = {
        init: function() {
            $('#createForm').ajaxForm({
                target:'#edit-target',
                url:'item_create.php'
            });
        },
        success: function() {
            $('#createModal').modal('hide');
            sodon_list.refresh();
        },
        submit: function() {
            $('#createForm').submit();
        }
    };
</script>

<div class="modal-header">
    <h3 class="modal-title">
        <?php
            if(empty($itemID))
                echo 'Add new menu item';
            else
                echo 'Update menu item';
        ?>
    </h3>
</div>
<div class="modal-body">
    <form action="item_create.php" method="post" id="createForm">

        <input type="hidden" id="itemID" name="itemID" value="<?php echo $itemID;?>"/>

        <div class="row">
            <div class="col-xs-6">
<!--                <div class="form-group has-error">-->
                <div class="form-group">
                    <label class="control-label strong" for="name">Name</label>
                    <input id="name" name="name" class="form-control input-sm" value="<?php if(!empty($itemID)) echo $item['name'];?>"/>
    <!--                <c:if test="${!empty titleError}">-->
    <!--                    <span class="help-block">${titleError}</span>-->
    <!--                </c:if>-->
                </div>
            </div>
            <div class="col-xs-6">
    <!--            <c:set var="titleAliasError"><form:errors path="titleAlias"/></c:set>-->
    <!--            <div class="form-group <c:if test="${!empty titleAliasError}">has-error</c:if>">-->
                <div class="form-group">
                    <label class="control-label strong" for="category">Category</label>
                    <select id="categoryID" name="categoryID" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['categoryID']; ?>" <?php if(!empty($itemID)&&$category['categoryID']==$item['categoryID']) echo 'selected="selected"';?>><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
        <!--            <c:if test="${!empty titleAliasError}">-->
        <!--                <span class="help-block">${titleAliasError}</span>-->
        <!--            </c:if>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label strong" for="picture">Picture (URL)</label>
                    <input id="picture" name="picture" class="form-control input-sm" value="<?php if(!empty($itemID)) echo $item['picture'];?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label strong" for="unitPrice">Unit Price ($)</label>
                    <input id="unitPrice" name="unitPrice" class="form-control input-sm" value="<?php if(!empty($itemID)) echo $item['unitPrice'];?>"/>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label strong" for="calories">Calories (K)</label>
                    <input id="calories" name="calories" class="form-control input-sm" value="<?php if(!empty($itemID)) echo $item['calories'];?>"/>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label strong" for="ranking">Ranking</label>
                    <input id="ranking" name="ranking" class="form-control input-sm" value="<?php if(!empty($itemID)) echo $item['ranking'];?>"/>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label strong">Enabled</label>
                    <div class="status-switch" id="status-switch" data-on="info">
                        <input type="checkbox" name="status" id="status" <?php if(empty($itemID)||$item['status']=='E') echo 'checked="checked';?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label strong" for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control"><?php if(!empty($itemID)) echo $item['description'];?></textarea>
<!--        <c:if test="${!empty noteError}">-->
<!--            <span class="help-block">${noteError}</span>-->
<!--        </c:if>-->
        </div>

        <div class="formSep"></div>

        <div class="clearfix">
            <div class="pull-right">
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" onclick="sodon_create.submit()">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>

    </form>
</div>

<div style="display: none;">
    <div id="success_notification"><?php echo $success_notification;?></div>
    <div id="error_notification"><?php echo $error_notification;?></div>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php if(!empty($success_notification)) { ?>
                $.sticky($('#success_notification').text(), {autoclose : 5000, position: "top-right", type: "st-success" });
                sodon_create.success();
            <?php } ?>
            <?php if(!empty($error_notification)) { ?>
                $.sticky($('#error_notification').text(), {autoclose : 5000, position: "top-right", type: "st-error" });
                $('#createModal').animate({scrollTop: 0}, 800);
            <?php } ?>
        });
    </script>
</div>



<script type="text/javascript">

    sodon_create.init();

    $(document).ready(function(){

        $('#status-switch').bootstrapSwitch();
        $('#status-switch').bootstrapSwitch('setSizeClass', 'switch-small');
        $('#status-switch').bootstrapSwitch('setOnLabel', 'Yes');
        $('#status-switch').bootstrapSwitch('setOffLabel', 'No');
    });
</script>