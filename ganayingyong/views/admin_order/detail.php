<?php $this->load->view('admin/table_head');?>
<div class="row">
    <div class="col-md-12">
        <div class='portlet box light-grey'>
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i><?=$order['order_sn']?> 订单明细</div>
                <div class="tools">
                    <a class="collapse" href="javascript:;"></a>
                </div>
                <div class="actions">
                    <a class="btn red"  href="javascript:LoadPageContentBody('<?=site_url("admin/report")?>');">返回</a>
                </div>
            </div>
            <div class="portlet-body">            
                <div class="table-scrollable">
                    <table class='table table-striped table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>产品名</th>
                                <th>单价 (元)</th>
                                <th>购买数量</th>
                                <th>小计 (元)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($result as $key => $row):?>
                            <tr>
                                <td><?=$row['pname']?></td>
                                <td><?=$row['price']?></td>
                                <td><?=$row['qty']?></td>
                                <td><?=$row['price']*$row['qty']?></td>
                            </tr>
                        <?php endforeach;?>
                        <tr>
                            <td>合计</td>
                            <td colspan="100"><?=$order['total_price']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($page_links)): ?>
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
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=base_url()?>js/page.js"></script>
<script type="text/javascript">
function product_select(){
    LoadPageContentBody('<?=site_url($controller_url."product_select")?>');
}
function detail(id){
    LoadPageContentBody('<?=site_url($controller_url."detail")?>');
}
function del(id){
    common_del('<?=site_url($controller_url."del")?>', id, "", "#order_view");
}
function infoQuery() {
    var formData = $('#search').serialize();
    LoadPageContentBody('<?=site_url($controller_url)?>', formData);
}
jQuery(document).ready(function() {       
    TableAdvanced.init();
});
</script>
