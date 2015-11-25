<?php
require_once('../../util/main.php');
require_once('../../model/database.php');
require_once('../../model/order_db.php');

$orders = get_orders();

?>

<script type="text/javascript">
    sodon_list = {
        refresh: function(){
            sodon_common.ajax('post','#list-target','${pageContext.request.contextPath}/item/book/list', $('#orderForm').serialize()+'&page=${list.pageNumber}'+$('#searchParams').val(),'');
        },
        paginate: function(page){
            sodon_common.ajax('post','#list-target','${pageContext.request.contextPath}/item/book/list',$('#orderForm').serialize()+'&page='+page+$('#searchParams').val(),'');
        },
        order: function(){
            sodon_common.ajax('post','#list-target','${pageContext.request.contextPath}/item/book/list',$('#orderForm').serialize() + $('#searchParams').val(),'');
        },
        print: function(){
            window.open('${pageContext.request.contextPath}/item/book/list?view=print&page=${param.page}&' + $('#orderForm').serialize() + $('#searchParams').val(), '_blank');
        },
        barcode: function(){
            window.open('${pageContext.request.contextPath}/item/book/list?view=barcode&page=${param.page}&' + $('#listForm').serialize() + '&' + $('#orderForm').serialize() + $('#searchParams').val(), '_blank');
        },
        category: function(){
            window.open('${pageContext.request.contextPath}/item/book/list?view=category&page=${param.page}&' + $('#listForm').serialize() + '&' + $('#orderForm').serialize() + $('#searchParams').val(), '_blank');
        },
        subcategory: function(){
            window.open('${pageContext.request.contextPath}/item/book/list?view=subcategory&page=${param.page}&' + $('#listForm').serialize() + '&' + $('#orderForm').serialize() + $('#searchParams').val(), '_blank');
        },
        excelSuccess: function(){
            $('#excel-loader').css('visibility','hidden');
            $('#excel-button').prop('disabled',false);
            window.location = "<spring:eval expression="@environment.getProperty('resource.url')"/>report/books.xls";
        },
        excel: function(){
            $('#excel-loader').css('visibility','visible');
            $('#excel-button').prop('disabled',true);
            sodon_common.ajax('get','#alert-notification','${pageContext.request.contextPath}/item/book/list?view=excel&page=${param.page}',$('#orderForm').serialize() + $('#searchParams').val(),'sodon_list.excelSuccess();');
        }
    }
</script>

<!--<%@include file="/WEB-INF/views/common/pagination.jsp"%>-->

<!--<c:if test="${!empty list.elements}">-->
<!--    <div class="clearfix btSep">-->
<!--        <div class="pull-left">-->
<!--            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.delete();">-->
<!--                <span class="text-danger">-->
<!--                    <i class="glyphicon glyphicon-remove"></i> Delete-->
<!--                </span>-->
<!--            </button>-->
<!---->
<!--            <button id="barcode-button" class="btn btn-default btn-xs" type="button" onclick="sodon_list.barcode();">-->
<!--                <i class="glyphicon glyphicon-barcode"></i> Barcode-->
<!--            </button>-->
<!---->
<!--            <button id="category-button" class="btn btn-default btn-xs" type="button" onclick="sodon_list.category();">-->
<!--                <i class="glyphicon glyphicon-tag text-warning"></i> Category-->
<!--            </button>-->
<!---->
<!--            <button id="subcategory-button" class="btn btn-default btn-xs" type="button" onclick="sodon_list.subcategory();">-->
<!--                <i class="glyphicon glyphicon-tag"></i> Subcategory-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="pull-right">-->
<!---->
<!--            <form class="form-inline" id="orderForm" role="form">-->
<!---->
<!--                <div class="form-group">-->
<!--                    Page size-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <select class="form-control input-sm" id="pageSize" name="pageSize">-->
<!--                        <option>30</option>-->
<!--                        <option>60</option>-->
<!--                        <option>90</option>-->
<!--                        <option>120</option>-->
<!--                        <option>150</option>-->
<!--                        <option>300</option>-->
<!--                        <option>600</option>-->
<!--                        <option>1200</option>-->
<!--                        <option value="0">All</option>-->
<!--                    </select>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group">-->
<!--                    Order by-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <select class="form-control input-sm" id="orderField" name="orderField">-->
<!--                        <option value="created">Created</option>-->
<!--                        <option value="title">Title</option>-->
<!--                        <option value="title_alias">Title alias</option>-->
<!--                        <option value="published_date">Published date</option>-->
<!--                        <option value="isbn">ISBN</option>-->
<!--                        <option value="donor">Donor</option>-->
<!--                        <option value="category_number">Category number</option>-->
<!--                        <option value="subcategory_number">Subcategory number</option>-->
<!--                        <option value="authors">Authors</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <select class="form-control input-sm" id="orderDirection" name="orderDirection">-->
<!--                        <option value="desc">&darr;</option>-->
<!--                        <option value="asc">&uarr;</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</c:if>-->


<form action="#" method="post" id="listForm">
    <div class="table-responsive">
        <table class="table table-striped table-bordered sodon-table-middle">
            <thead>
            <tr>
                <th style="width: 1px;"><input type="checkbox" onclick="return sodon_common.checkAll(this);"/></th>
                <th style="width: 1px;">ID</th>
                <th style="width: 160px;">Customer</th>
                <th>Order Time</th>
                <th>Total price</th>
                <th>Number of Items</th>
                <th>Pickup Type</th>
                <th>Phone</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>


            <?php if (count($orders) == 0) : ?>
                <tr><td style="text-align: center;" colspan="8">There are no orders.</td></tr>

                <p></p>
            <?php else : ?>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $order['orderID']; ?>" name="id"/></td>
                        <td><?php echo $order['orderID']; ?></td>
                        <td><?php echo $order['customerName']; ?></td>
                        <td><?php echo $order['orderDateTime']; ?></td>
                        <td><?php echo $order['totalPayment']; ?></td>
                        <td><?php echo $order['totalQuantity']; ?></td>
                        <td><?php echo $order['pickupType']; ?></td>
                        <td><?php echo $order['phone']; ?></td>
                        <td>
                            <button class="btn btn-default btn-sm" type="button" onclick="sodon_main.delete();">
                                <span class="text-danger">
                                    <i class="glyphicon glyphicon-remove"></i> Delete
                                </span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

<!--<%@include file="/WEB-INF/views/common/pagination.jsp"%>-->

<!--<c:if test="${!empty list.elements}">-->
<!--    <div class="text-right">-->
<!---->
<!--        <img id="excel-loader" style="visibility: hidden;" src="<spring:eval expression="@environment.getProperty('static.url')"/>sodon/img/loader.gif" width="16" height="16"/>-->
<!---->
<!--        <button id="excel-button" class="btn btn-default btn-xs" type="button" onclick="sodon_list.excel();">-->
<!--            <i class="glyphicon glyphicon-th-list text-success"></i> Download excel-->
<!--        </button>-->
<!---->
<!--        <button class="btn btn-default btn-xs" type="button" onclick="sodon_list.print();">-->
<!--            <i class="glyphicon glyphicon-print text-info"></i> Print-->
<!--        </button>-->
<!---->
<!--    </div>-->
<!--</c:if>-->

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

    <c:if test="${!empty param.pageSize}">
        $("#pageSize").val('${param.pageSize}');
    </c:if>
    <c:if test="${!empty param.orderField}">
        $("#orderField").val('${param.orderField}');
    </c:if>
    <c:if test="${!empty param.orderDirection}">
        $("#orderDirection").val('${param.orderDirection}');
    </c:if>

</script>
