<?php
    require_once('../../../util/main.php');
    require_once('../../../model/database.php');
    require_once('../../../model/menu_category_db.php');

    $success_notification = '';
    $error_notification = '';

    $error_name = '';
    $error_ranking = '';

    $formValidation = true;

    $categoryID = '';

    if(isset($_POST['categoryID'])){

        $categoryID = $_POST['categoryID'];

        try {

            $category = array();
            $category['categoryID'] = $_POST['categoryID'];
            $category['name'] = $_POST['name'];
            $category['ranking'] = $_POST['ranking'];
            if(isset($_POST['status'])) $category['status'] = 'E';
            else $category['status'] = 'D';

            if(empty($category['name'])) {
                $error_name = 'Name must be filled out';
                $formValidation = false;
            }

            if(empty($category['ranking'])) {
                $error_ranking = 'Ranking must be filled out';
                $formValidation = false;
            } else if(!is_numeric($category['ranking'])) {
                $error_ranking = 'Ranking must be valid number';
                $formValidation = false;
            }

            if($formValidation){
                if(empty($category['categoryID'])){
                    session_start();
                    $category['createdBy'] = $_SESSION['userId'];
                    add_category($category);
                } else {
                    update_category($category);
                }
                $success_notification = 'Successfully saved';
            }
        } catch (Exception $e) {
            $error_notification = $e->getMessage();
        }
    } else {
        if(isset($_GET['categoryID'])) $categoryID = $_GET['categoryID'];
        if(!empty($categoryID)) $category = get_category($categoryID);
    }

?>

<script type="text/javascript">
    sodon_create = {
        init: function() {
            $('#createForm').ajaxForm({
                target:'#edit-target',
                url:'category_create.php'
            });
        },
        success: function() {
            $('#createModal').modal('hide');
            sodon_main.list();
        },
        submit: function() {
            $('#createForm').submit();
        }
    };
</script>

<div class="modal-header">
    <h3 class="modal-title">
        <?php
        if(empty($categoryID))
            echo 'Add new menu category';
        else
            echo 'Update menu category';
        ?>
    </h3>
</div>
<div class="modal-body">
    <form action="category_create.php" method="post" id="createForm">

        <input type="hidden" id="categoryID" name="categoryID" value="<?php echo $categoryID;?>"/>

        <div class="row">
            <div class="col-xs-6">
                <div class="form-group <?php if(!empty($error_name)) echo 'has-error';?>">
                    <label class="control-label strong" for="name">Name <span class="f_req">*</span></label>
                    <input id="name" name="name" class="form-control input-sm" value="<?php if(!empty($category)) echo $category['name'];?>"/>
                    <?php if(!empty($error_name)) { ?>
                        <span class="help-block"><?php echo $error_name;?></span>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group <?php if(!empty($error_ranking)) echo 'has-error';?>">
                    <label class="control-label strong" for="ranking">Ranking <span class="f_req">*</span></label>
                    <input id="ranking" name="ranking" class="form-control input-sm" value="<?php if(!empty($category)) echo $category['ranking'];  else echo '1';?>"/>
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
                        <input type="checkbox" name="status" id="status" <?php if(empty($category)||$category['status']=='E') echo 'checked="checked';?>"/>
                    </div>
                </div>
            </div>
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

        $( ".ranking_slider" ).slider({
            value:<?php if(!empty($category)) echo $category['ranking']; else echo '1';?>,
            min: 1,
            max: 10,
            step: 1,
            slide: function( event, ui ) {
                $( "#ranking" ).val(ui.value );
            }
        });
    });
</script>