<?php
    require_once('../../util/main.php');
    require_once('../../model/database.php');
    require_once('../../model/menu_item_db.php');
    require_once('../../model/menu_category_db.php');

    $success_notification = '';
    $error_notification = '';

    $error_name = '';
    $error_category = '';
    $error_unitPrice = '';
    $error_calories = '';
    $error_ranking = '';

    $formValidation = true;

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

            if(empty($item['name'])) {
                $error_name = 'Name must be filled out';
                $formValidation = false;
            }

            if(empty($item['categoryID'])) {
                $error_category = 'Category must be selected';
                $formValidation = false;
            }

            if(empty($item['unitPrice'])) {
                $error_unitPrice = 'Unit price must be filled out';
                $formValidation = false;
            } else if(!is_numeric($item['unitPrice'])) {
                $error_unitPrice = 'Unit price must be valid number';
                $formValidation = false;
            }

            if(empty($item['calories'])) {
                $error_calories = 'Calories must be filled out';
                $formValidation = false;
            } else if(!is_numeric($item['calories'])) {
                $error_calories = 'Calories must be valid number';
                $formValidation = false;
            }

            if(empty($item['ranking'])) {
                $error_ranking = 'Ranking must be filled out';
                $formValidation = false;
            } else if(!is_numeric($item['ranking'])) {
                $error_ranking = 'Ranking must be valid number';
                $formValidation = false;
            }

            if($formValidation){
                if(empty($item['itemID'])){
                    session_start();
                    $item['createdBy'] = $_SESSION['userId'];
                    add_item($item);
                } else {
                    update_item($item);
                }
                $success_notification = 'Successfully saved';
            }
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
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
                <div class="form-group <?php if(!empty($error_name)) echo 'has-error';?>">
                    <label class="control-label strong" for="name">Name <span class="f_req">*</span></label>
                    <input id="name" name="name" class="form-control input-sm" value="<?php if(!empty($item)) echo $item['name'];?>"/>
                    <?php if(!empty($error_name)) { ?>
                        <span class="help-block"><?php echo $error_name;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_category)) echo 'has-error';?>">
                    <label class="control-label strong" for="category">Category <span class="f_req">*</span></label>
                    <select id="categoryID" name="categoryID" class="form-control input-sm">
                        <option value="">...</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['categoryID']; ?>" <?php if(!empty($item)&&$category['categoryID']==$item['categoryID']) echo 'selected="selected"';?>><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($error_category)) { ?>
                        <span class="help-block"><?php echo $error_category;?></span>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label strong" for="picture">Picture (URL)</label>
                    <input id="picture" name="picture" class="form-control input-sm" value="<?php if(!empty($item)) echo $item['picture'];?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_unitPrice)) echo 'has-error';?>">
                    <label class="control-label strong" for="unitPrice">Unit Price ($) <span class="f_req">*</span></label>
                    <input readonly="readonly" id="unitPrice" name="unitPrice" class="form-control input-sm" value="<?php if(!empty($item)) echo $item['unitPrice']; else echo '0';?>"/>
                    <div class="sepH_b" style="margin-top: 5px;">
                        <div class="unitprice_slider"></div>
                    </div>
                    <?php if(!empty($error_unitPrice)) { ?>
                        <span class="help-block"><?php echo $error_unitPrice;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_calories)) echo 'has-error';?>">
                    <label class="control-label strong" for="calories">Calories (K) <span class="f_req">*</span></label>
                    <input id="calories" name="calories" class="form-control input-sm" value="<?php if(!empty($item)) echo $item['calories'];  else echo '0';?>"/>
                    <div class="sepH_b" style="margin-top: 5px;">
                        <div class="calories_slider"></div>
                    </div>
                    <?php if(!empty($error_calories)) { ?>
                        <span class="help-block"><?php echo $error_calories;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_ranking)) echo 'has-error';?>">
                    <label class="control-label strong" for="ranking">Ranking <span class="f_req">*</span></label>
                    <input id="ranking" name="ranking" class="form-control input-sm" value="<?php if(!empty($item)) echo $item['ranking'];  else echo '1';?>"/>
                    <div class="sepH_b" style="margin-top: 5px;">
                        <div class="ranking_slider"></div>
                    </div>
                    <?php if(!empty($error_ranking)) { ?>
                        <span class="help-block"><?php echo $error_ranking;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="control-label strong">Enabled</label>
                    <div class="status-switch" id="status-switch" data-on="info">
                        <input type="checkbox" name="status" id="status" <?php if(empty($item)||$item['status']=='E') echo 'checked="checked';?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label strong" for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control"><?php if(!empty($item)) echo $item['description'];?></textarea>
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

        $( ".unitprice_slider" ).slider({
            value:<?php if(!empty($item)) echo $item['unitPrice']; else echo '0';?>,
            min: 0,
            max: 50,
            step: 0.05,
            slide: function( event, ui ) {
                $( "#unitPrice" ).val(ui.value );
            }
        });

        $( ".calories_slider" ).slider({
            value:<?php if(!empty($item)) echo $item['calories']; else echo '0';?>,
            min: 0,
            max: 2000,
            step: 10,
            slide: function( event, ui ) {
                $( "#calories" ).val(ui.value );
            }
        });

        $( ".ranking_slider" ).slider({
            value:<?php if(!empty($item)) echo $item['ranking']; else echo '1';?>,
            min: 1,
            max: 10,
            step: 1,
            slide: function( event, ui ) {
                $( "#ranking" ).val(ui.value );
            }
        });
    });
</script>