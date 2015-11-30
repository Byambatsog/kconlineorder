<?php
    require_once('../../../util/main.php');
    require_once('../../../util/tags.php');
    require_once('../../../model/database.php');
    require_once('../../../model/employee_db.php');

    $filterValue = array();
    $page = 1;
    $pageSize = 10;
    $orderField = '';
    $orderDirection = '';

    if(isset($_POST['userName'])) $filterValue['userName'] = $_POST['userName'];
    if(isset($_POST['firstName'])) $filterValue['firstName'] = $_POST['firstName'];
    if(isset($_POST['lastName'])) $filterValue['lastName'] = $_POST['lastName'];
    if(isset($_POST['street'])) $filterValue['street'] = $_POST['street'];
    if(isset($_POST['zipCode'])) $filterValue['zipCode'] = $_POST['zipCode'];
    if(isset($_POST['phone'])) $filterValue['phone'] = $_POST['phone'];
    if(isset($_POST['status'])) $filterValue['status'] = $_POST['status'];
    if(isset($_POST['title'])) $filterValue['title'] = $_POST['title'];
    if(isset($_POST['supervisorID'])) $filterValue['supervisorID'] = $_POST['supervisorID'];
    if(isset($_POST['locationID'])) $filterValue['locationID'] = $_POST['locationID'];
    if(isset($_POST['page'])) $page = $_POST['page'];
    if(isset($_POST['pageSize'])) $pageSize = $_POST['pageSize'];
    if(isset($_POST['orderField'])) $orderField = $_POST['orderField'];
    if(isset($_POST['orderDirection'])) $orderDirection = $_POST['orderDirection'];
    $filterValue['eFlag'] = '1';

    $employees = get_employees_by_filters($filterValue, $page, $pageSize, $orderField, $orderDirection);
    $total = get_employeeSize_by_filters($filterValue);

?>

<script type="text/javascript">
    sodon_list = {
        refresh: function(){
            sodon_common.ajax('post','#list-target','employee_list.php', $('#orderForm').serialize() + '&page=<?php echo $page?>'+$('#searchParams').val(),'');
        },
        paginate: function(page){
            sodon_common.ajax('post','#list-target','employee_list.php', $('#orderForm').serialize() + '&page='+page+$('#searchParams').val(),'');
        },
        order: function(){
            sodon_common.ajax('post','#list-target','employee_list.php', $('#orderForm').serialize() + $('#searchParams').val(),'');
        }
    }
</script>

<?php if (count($employees) != 0) { ?>
    <div class="clearfix btSep">
        <div class="pull-left">
            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.delete();">
                <span class="text-danger">
                    <i class="glyphicon glyphicon-remove"></i> Delete
                </span>
            </button>
        </div>
        <div class="pull-right">

            <form class="form-inline" id="orderForm" role="form">

                <div class="form-group">
                    Page size
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="pageSize" name="pageSize">
                        <option>10</option>
                        <option>20</option>
                        <option>30</option>
                        <option>40</option>
                        <option>50</option>
                    </select>
                </div>

                <div class="form-group">
                    Order by
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="orderField" name="orderField">
                        <option value="firstName">First name</option>
                        <option value="created">Created</option>
                        <option value="userName">Username</option>
                        <option value="lastName">Last name</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" id="orderDirection" name="orderDirection">
                        <option value="ASC">&uarr;</option>
                        <option value="DESC">&darr;</option>
                    </select>
                </div>
            </form>
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
                <th class="text-center" style="width: 120px;">User name</th>
                <th class="text-center" style="width: 160px;">Name</th>
                <th class="text-center" style="width: 135px;">Title</th>
                <th class="text-center" style="width: 100px;">DateHired</th>
                <th class="text-center" style="width: 160px;">Location</th>
                <th class="text-center" style="width: 120px;">Phone</th>
                <th class="text-center">Status</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($employees) == 0) : ?>
                <tr><td style="text-align: center;" colspan="10">There are no employees.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($employees as $employee) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $employee['employeeID']; ?>" name="id[]" id="id"/></td>
                        <td class="text-center"><?php echo $employee['employeeID']; ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="sodon_main.create(<?php echo $employee['employeeID']; ?>);"><?php echo $employee['userName']; ?></a>
                        </td>
                        <td>
                            <?php echo $employee['firstName'].' '.$employee['lastName']; ?>
                        </td>
                        <td class="text-center"><?php echo $employee['title']; ?></td>
                        <td class="text-center"><?php echo $employee['dateHired']; ?></td>
                        <td class="text-center"><?php echo $employee['locationName']; ?></td>
                        <td class="text-center"><?php echo $employee['phone']; ?></td>
                        <td class="text-center">
                            <?php if($employee['status']=='E'){ ?>
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

<?php require('../../../util/pagination.php');?>

<script type="text/javascript">

    $('body,html').animate({scrollTop: 0}, 0);

    $( "#pageSize" ).change(function() {
        sodon_list.order();
    });
    $( "#orderField" ).change(function() {
        sodon_list.order();
    });
    $( "#orderDirection" ).change(function() {
        sodon_list.order();
    });

    <?php if(!empty($pageSize)){?>
    $("#pageSize").val('<?php echo $pageSize;?>');
    <?php } ?>

    <?php if(!empty($orderField)){?>
    $("#orderField").val('<?php echo $orderField;?>');
    <?php } ?>
    <?php if(!empty($orderDirection)){ ?>
    $("#orderDirection").val('<?php echo $orderDirection;?>');
    <?php } ?>
</script>
