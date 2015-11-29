<?php
    require_once('../../../util/main.php');
    require_once('../../authenticate.php');
    require_once('../../../view/headerForAdmin.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');

?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Locations</h3>
        </div>
        <div class="pull-right">
            <button class="btn btn-default btn-xs" type="button" onclick="sodon_main.create('');">
                <i class="glyphicon glyphicon-file text-primary"></i> Add New Location
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div id="list-target">
            <!--            list-->
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

<div id="item-load" style="display: none;">
    <!--    ajax-->
</div>

<script type="text/javascript">
    sodon_main = {
        list: function() {
            sodon_common.ajax('post','#list-target','location_list.php','','');
            $('#searchParams').val('');
        },
        create: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','location_create.php','locationID='+id,'');
        },
        delete: function(id){
            smoke.confirm('Do you really want to delete?',function(e){
                if (e){
                    sodon_common.ajax('post','#alert-notification','location_delete.php','id=' + id,'sodon_main.list();');
                }
            }, {ok:"Delete", cancel:"Cancel"});
        }
    };
    sodon_main.list();
</script>


<?php include '../../../view/footerForAdmin.php'; ?>
