<div class="clearfix">
    <div class="pull-right">
        Total: <?php echo $total; ?>
    </div>
    <div class="pull-left">
        <ul class="pagination">
            <?php if($page > 1){?>
                <li class="prev">
                    <a href="#" onclick="sodon_list.paginate(<?php echo ($page-1);?>); return false;">Previous</a>
                </li>
            <?php }?>

                <?php if($total > $pageSize){
                    $start = $page>4?$page-3:1;
                    if(($page+3)*$pageSize > $total){
                        $end = $total%$pageSize==0?$total/$pageSize:$total/$pageSize+1;
                    } else {
                        $end = $pageSize + 3;
                    }

                    for($i = $start; $i <= $end; $i++){

                        if($i==$page){
                ?>
                        <li class="active"><a href="#" onclick="return false;"><?php echo $i;?></a></li>
                <?php
                        } else {
                ?>
                        <li><a href="#" onclick="sodon_list.paginate(<?php echo $i;?>); return false;"><?php echo $i;?></a></li>
                <?php
                        }
                    }
            }?>
            <?php if($page*$pageSize < $total){?>
                <li class="next">
                    <a href="#" onclick="sodon_list.paginate(<?php echo ($page+1);?>); return false;">Next</a>
                </li>
            <?php }?>
        </ul>
    </div>
</div>