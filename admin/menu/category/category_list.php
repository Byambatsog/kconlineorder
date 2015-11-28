<?php
    require_once('../../../util/main.php');
    require_once('../../../util/tags.php');
    require_once('../../../model/database.php');
    require_once('../../../model/menu_category_db.php');

    $categories = get_categories();
?>

<?php if (count($categories) != 0) { ?>
    <div class="clearfix btSep">
        <div class="pull-left">
            <button class="btn btn-danger btn-xs" type="button" onclick="sodon_main.delete();">
            <i class="glyphicon glyphicon-remove"></i> Delete
            </button>
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
                <th class="text-center" style="width: 250px;">Name</th>
                <th class="text-center" style="width: 80px;">Rank</th>
                <th class="text-center">Status</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($categories) == 0) : ?>
                <tr><td style="text-align: center;" colspan="5">There are no menu categories.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $category['categoryID']; ?>" name="id[]" id="id"/></td>
                        <td class="text-center"><?php echo $category['categoryID']; ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="sodon_main.create(<?php echo $category['categoryID']; ?>);"><?php echo $category['name']; ?></a>
                        </td>
                        <td class="text-center"><?php echo $category['ranking']; ?></td>
                        <td class="text-center">
                            <?php if($category['status']=='E'){ ?>
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

