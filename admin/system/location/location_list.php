<?php
    require_once('../../../util/main.php');
    require_once('../../../util/tags.php');
    require_once('../../../model/database.php');
    require_once('../../../model/location_db.php');

    $locations = get_locations();
?>

<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th class="text-center" style="width: 30px;">ID</th>
                <th class="text-center" style="width: 155px;">Name</th>
                <th class="text-center" style="width: 100px;">Manager</th>
                <th class="text-center">Address</th>
                <th class="text-center" style="width: 100px;">Phone</th>
                <th class="text-center" style="width: 100px;">Fax</th>
                <th class="text-center" style="width: 150px;">E-mail</th>
                <th class="text-center" style="width: 145px;">Time table</th>
                <th class="text-center"></th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($locations) == 0) : ?>
                <tr><td style="text-align: center;" colspan="10">There are no locations.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($locations as $location) : ?>
                    <tr>
                        <td class="text-center"><?php echo $location['locationID']; ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="sodon_main.create(<?php echo $location['locationID']; ?>);"><?php echo $location['name']; ?></a>
                        </td>
                        <td class="text-center"><?php echo $location['Manager']; ?></td>
                        <td><?php echo $location['street'].', '.$location['city'].', '.$location['state'].' '.$location['zipCode']; ?></td>
                        <td class="text-center"><?php echo $location['phone']; ?></td>
                        <td class="text-center"><?php echo $location['fax']; ?></td>
                        <td class="text-center"><?php echo $location['emailAddress']; ?></td>
                        <td class="text-center"><?php echo $location['timeTable']; ?></td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-xs" type="button" onclick="sodon_main.delete(<?php echo $location['locationID']; ?>);">
                                <i class="glyphicon glyphicon-remove"></i> Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
