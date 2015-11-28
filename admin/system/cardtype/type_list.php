<?php
    require_once('../../../util/main.php');
    require_once('../../../util/tags.php');
    require_once('../../../model/database.php');
    require_once('../../../model/card_type_db.php');

    $types = get_card_types();
?>

<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th style="width: 1px;"><input type="checkbox" onclick="return sodon_common.checkAll(this);"/></th>
                <th class="text-center" style="width: 40px;">ID</th>
                <th class="text-center">Description</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($types) == 0) : ?>
                <tr><td style="text-align: center;" colspan="5">There are no card types.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($types as $type) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $type['cardTypeID']; ?>" name="id[]" id="id"/></td>
                        <td class="text-center"><?php echo $type['cardTypeID']; ?></td>
                        <td class="text-center"><?php echo $type['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

