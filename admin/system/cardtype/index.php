<?php
require_once('../../../util/main.php');
require_once('../../authenticate.php');
require_once('../../../view/headerForAdmin.php');
require_once('../../../model/database.php');

?>

<div class="row">
    <div class="col-lg-3 col-sm-4">
        <div class="heading">
            <div class="clearfix">
                <div class="pull-left">
                    <h3>Card Type</h3>
                </div>
<!--                <div class="pull-right">-->
<!--                    <button class="btn btn-primary btn-xs" type="button" onclick="sodon_main.create(0);">-->
<!--                        <i class="glyphicon glyphicon-file"></i> New-->
<!--                    </button>-->
<!--                </div>-->
            </div>
        </div>
        <div id="list-target">
        </div>
    </div>
</div>



<div class="modal" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 10px; margin-top: 5px;">&times;</button>
            <div id="edit-target">
                <!--                create-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    sodon_main = {
        list: function() {
            sodon_common.ajax('get','#list-target','type_list.php','','');
        },
        create: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','type_create.php','categoryID='+id,'');
        }
    };
    sodon_main.list();
</script>


<?php include '../../../view/footerForAdmin.php'; ?>
