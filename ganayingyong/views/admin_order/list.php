<?php //$this->load->view('admin/table_head');?>
<div class="row">
    <div class="col-md-12">
        <div class='portlet box light-grey'>
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i>列表</div>
                <div class="tools">
                    <a class="collapse" href="javascript:;"></a>
                </div>
                <div class="actions">
                    <button onclick="product_select()" class="btn blue"><i class="icon-plus"></i> 添加</button>
                </div>
            </div>
            <div class="portlet-body">            
                <div class="row hidden">
                    <div class="col-md-12">                    
                        <form id="search_order" class="form-inline">
                            <div class="form-group">
                                <input type="text" placeholder="订单号搜索" class="form-control" value="" name="q">
                            </div>
                            <input type="button" value="搜索" class="btn btn-default" onclick="order_search()" >
                        </form>
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class='table table-striped table-bordered table-hover'>
                        <thead>
                            <tr>
                                <!-- <th>订单号</th> -->
                                <th>订单类型</th>
                                <th>订单总价</th>
                                <th>开单人</th>
                                <th>开单时间</th>
                                <th>状态</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($result as $key => $row):?>
                            <tr <?=$row['is_paid'] ? '' : 'class="danger"' ?>>
                                <!-- <td><?=$row['order_sn']?></td> -->
                                <td><?=$order_type[$row['type']]?></td>
                                <td><?=$row['type'] == 1 ? $row['total_price'] : ""?></td>
                                <td><?=$operators[$row['biller']]?></td>
                                <td><?= trans_date_format($row['datetime'], "Y-m-d H:i")?></td>
                                <td><button class="btn yellow" onclick='paid(<?=$row['id']?>, <?=$row['is_paid'] ? 0 : 1 ?>)'> <?=$row['is_paid'] ? '已发货' : '未发货' ?></button></td>
                                <td><?=$row['remarks']?></td>
                                <td>
                                    <button class="btn blue" onclick="LoadPageContentBody('<?=site_url($controller_url."detail/".$row['id'])?>')"><i class="icon-list icon-white"></i> 明细</button>
                                    <button class="btn btn-danger" onclick='del(<?=$row['id']?>)'><i class="icon-remove icon-white"></i> 删除</button>                                    
                                </td>
                            </tr>
                        <?php endforeach;?>
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
<!-- <script type="text/javascript" src="<?=base_url()?>js/page.js"></script> -->
<script type="text/javascript">
function product_select(){
    LoadPageContentBody('<?=site_url($controller_url."product_select")?>');
}
function detail(id){
    LoadPageContentBody('<?=site_url($controller_url."detail")?>');
}
function paid(id, ispaid){
    $.ajax({
        url: '<?=site_url($controller_url."edit_save")?>',
        type: 'POST',
        data: {is_paid: ispaid,id: id},
        dataType: 'json'
    })
    .done(function(response) {
        alert(response.info);
        $('#report_view').click();
    })
}
function del(id){
    common_del('<?=site_url($controller_url."del")?>', id, "", "#report_view");
}
function order_search() {
    var formData = $('#search_order').serialize();
    console.log(formData);
    load_order_list(formData);
}
jQuery(document).ready(function() {       
    TableAdvanced.init();
});
</script>
