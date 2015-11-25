<?php
    require_once('../../util/main.php');
    require_once('../authenticate.php');
    require_once('../../view/headerForAdmin.php');
    require_once('../../model/database.php');
    require_once('../../model/menu_category_db.php');

    $categories = get_categories();

?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Menu items</h3>
        </div>
        <div class="pull-right">
            <button class="btn btn-default btn-xs" type="button" onclick="sodon_main.create('');">
                <i class="glyphicon glyphicon-file text-primary"></i> Add New Item
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Search Menu Items</h6>
            </div>
            <div class="panel-body">
                <form id="searchForm" role="form">
                    <div class="form-group">
                        <label class="control-label" for="name">Name</label>
                        <input id="searchName" name="name" class="form-control input-sm" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="category">Category</label>
                        <select name="category" id="searchCategory" class="form-control input-sm">
                            <option value="">...</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['categoryID']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="simpleStatus">Status</label>
                        <select name="status" id="searchStatus" class="form-control input-sm">
                            <option value="">...</option>
                            <option value="E">Enabled</option>
                            <option value="D">Disabled</option>
                        </select>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="reset" class="btn btn-default btn-sm">Clear</button>
                        <button class="btn btn-primary btn btn-sm" type="submit">Search</button>
                    </div>

                </form>
                <script>
                    $('#searchForm').on('submit', function(){
                        sodon_main.simpleSearch();
                        return false;
                    })
                </script>
            </div>
        </div>
    </div>
    <div class="col-xs-9">
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
            sodon_common.ajax('post','#list-target','item_list.php','','');
            $('#searchParams').val('');
        },
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','item_list.php',$("#searchForm").serialize(),'');
            $('#searchParams').val('&'+$("#searchForm").serialize());
        },
        create: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','item_create.php','itemID='+id,'');
        },
        delete: function(){
            if($("input[name=id]:checked").val() !== undefined){
                smoke.confirm('Do you really want to delete?',function(e){
                    if (e){
                        sodon_common.ajax('post','#alert-notification','item_delete.php',$("#listForm").serialize(),'sodon_main.refresh();');
                    }
                }, {ok:"Delete", cancel:"Cancel"});
            }
            else{
                $.sticky("Please select the items to delete!", {autoclose : 5000, position: "top-right", type: "st-info" });
            }
        }
    };
    sodon_main.list();
</script>


<?php include '../../view/footerForAdmin.php'; ?>
