<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption"><i class="icon-reorder"></i></div>
    </div>
    <div class="portlet-body form">
        <form id='addForm' class="form-horizontal" action="<?php echo site_url($controller_url."add")?>">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                    <select name="pid[]" multiple id="products_select">
                        <?php foreach ($products as $key => $item): ?>
                            <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    </div>
                </div>              
            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-9">
                    <a class="btn red btn-lg"  href="javascript:LoadPageContentBody('<?=site_url("admin/report")?>');">返回</a>
                    <input type='button' id="next" class="btn blue btn-lg" value='下一步 '/>
                </div>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/jquery-multi-select/css/multi-select.css" />

<script type="text/javascript" src="<?=base_url()?>assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>

<script type="text/javascript">
$(function () {
    $('#products_select').multiSelect({
        selectableHeader: "<h4>产品</h4>",
        selectionHeader: "<h4>选中产品</h4>"
    });
    $('#next').on('click', function () {     
        LoadPageContentBody('<?=site_url($controller_url."add")?>', $("#addForm").serialize());
    });   
})
</script>