<?php
require_once('../../util/main.php');
require_once('../authenticate.php');
require_once('../../view/headerForAdmin.php');
?>

<div class="heading">
    <div class="clearfix">
        <div class="pull-left">
            <h3>Current Orders</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">

        <input id="searchParams" type="hidden" value="">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6>Search orders</h6>
            </div>
            <div class="panel-body">
                <div id="simple-search">
                    <form id="simpleForm" role="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label" for="simpleStatus">Status</label>
                                    <select name="status" id="simpleStatus" class="form-control input-sm">
                                        <option value="P">Pending</option>
                                        <option value="R">Ready</option>
                                        <option value="C">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label" for="simpleStatus">Lendable</label>
                                    <select name="lendable" id="simpleLendable" class="form-control input-sm">
                                        <option value="">...</option>
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="simpleTitle">Title</label>
                            <input id="simpleTitle" name="title" class="form-control input-sm" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="simpleTitleAlias">Title alias</label>
                            <input id="simpleTitleAlias" name="titleAlias" class="form-control input-sm" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="simplePublishedDateFrom">Published date</label>
                            <div class="input-group input-group-sm">
                                <input id="simplePublishedDateFrom" name="publishedDateFrom" readonly="readonly" class="form-control input-sm"  placeholder="From"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="$('#simplePublishedDateFrom').val('');"><i class="glyphicon glyphicon-remove text-muted"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                <input id="simplePublishedDateTo" name="publishedDateTo" readonly="readonly" class="form-control"  placeholder="To"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="$('#simplePublishedDateTo').val('');"><i class="glyphicon glyphicon-remove text-muted"></i></button>
                                </span>
                            </div>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label class="control-label" for="simplePublishedCountry">Published country</label>-->
<!--                            <select id="simplePublishedCountry" name="publishedCountryId" class="form-control input-sm">-->
<!--                                <option value="">...</option>-->
<!--                                <c:forEach var="country" items="${publishedCountries}">-->
<!--                                    <option value="${country.id}">${country.name}</option>-->
<!--                                </c:forEach>-->
<!--                            </select>-->
<!--                        </div>-->

                        <hr>

                        <div class="text-right">
                            <button type="reset" class="btn btn-default btn-sm">Clear</button>
                            <button class="btn btn-primary btn btn-sm" type="submit">Search</button>
                        </div>

                    </form>
                    <script>
                        $('#simpleForm').on('submit', function(){
                            sodon_main.simpleSearch();
                            return false;
                        })
                    </script>
                </div>
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
    $(document).ready(function(){

        /*simple search*/
        var spdf = $('#simplePublishedDateFrom').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            spdf.hide();
        }).data('datepicker');

        var spdt = $('#simplePublishedDateTo').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            spdt.hide();
        }).data('datepicker');

        /*advanced search*/
        var apdf = $('#advancedPublishedDateFrom').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            apdf.hide();
        }).data('datepicker');

        var apdt = $('#advancedPublishedDateTo').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1
        }).on('changeDate', function(ev) {
            apdt.hide();
        }).data('datepicker');


    });

    sodon_main = {
        list: function() {
            sodon_common.ajax('get','#list-target','order_list.php','','');
            $('#searchParams').val('');
        },
        simpleSearch: function() {
            sodon_common.ajax('post','#list-target','${pageContext.request.contextPath}/item/book/list',$("#simpleForm").serialize(),'');
            $('#searchParams').val('&'+$("#simpleForm").serialize());
        },
        load: function(){
            sodon_common.ajax('get','#item-load','${pageContext.request.contextPath}/item/book/load?barcode='+$('#itemBarcode').val(),'','$("#itemBarcode").val("")');
        },
        create: function(id){
            $('#edit-target').html('');
            $('#createModal').modal({
                backdrop: false
            });
            sodon_common.ajax('get','#edit-target','${pageContext.request.contextPath}/item/book/create','id='+id,'');
        },
        delete: function(){
            if($("input[name=id]:checked").val() !== undefined){
                smoke.confirm('Do you really want to delete?',function(e){
                    if (e){
                        sodon_common.ajax('post','#alert-notification','${pageContext.request.contextPath}/item/delete',$("#listForm").serialize(),'sodon_main.list();');
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
