<?php $this->load->view('admin/table_head');?>
<div class="row">
    <div class="col-md-12">
        <div class='portlet box light-grey'>
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i>列表</div>
                <div class="tools">
                    <a class="collapse" href="javascript:;"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">                    
                        <form id="search" class="form-inline">
                            <div class="form-group">                               
                                <input name="q" type="text" value="<?=$q?>" class="form-control" placeholder="备注搜索">
                            </div>
                            <input type="button" value="搜索" class="btn btn-default" onclick="infoQuery()" >
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </form>
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class='table table-striped table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>操作人</th>
                                <th>备注</th>
                                <th>操作时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($result as $key => $row):?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td><?=$operators[$row['operator']]?></td>
                                <td><?=$row['remarks']?></td>
                                <td><?=$row['datetime']?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="bootpag pagination">
                            <li class="prev <?=$current_page==1 ? 'disabled' : '' ?>" data-lp="<?=$current_page?>">
                                <a class="ajaxify" href="<?=site_url($prev_link)?>">
                                    <icon class="icon-angle-left"></icon>
                                </a>
                            </li>
                            <?php foreach($page_links as $key => $lnk){ ?>    
                            <li data-lp="<?=$key?>" class="<?=$key == $current_page ? 'disabled' : '' ?>">
                                <a class="ajaxify" href="<?=site_url($lnk)?>"><?=$key?></a>
                            </li>
                            <? } ?>
                            <li class="next <?=$current_page==$page ? 'disabled' : '' ?>" data-lp="<?=$current_page?>">
                                <a class="ajaxify" href="<?=site_url($next_link)?>">
                                <icon class="icon-angle-right"></icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=base_url()?>js/page.js"></script>
<script type="text/javascript">
function infoQuery() {
    var formData = $('#search').serialize();
    LoadPageContentBody('<?=site_url($controller_url)?>', formData);
}
function stock_log(id) {
    LoadPageContentBody("<?php echo site_url('admin/product/stock_log/?id=') ?>"+id);
}
jQuery(document).ready(function() {       
    TableAdvanced.init();
});
</script>