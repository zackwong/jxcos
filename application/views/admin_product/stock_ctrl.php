<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption"><i class="icon-reorder"></i></div>
    </div>
    <div class="portlet-body form">
        <form id='addForm' class="form-horizontal" action="<?php echo site_url($controller_url."stock_save")?>">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">产品名</label>
                    <div class="col-md-8">
                        <p class="form-control-static"><?php echo $name ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">当前库存</label>
                    <div class="col-md-8">
                        <p class="form-control-static"><?php echo $stock ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">操作人</label>
                    <div class="col-md-8">
                        <select name="operator" class="form-control">
                            <?php foreach ($operators as $key => $value): ?>
                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">数量</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input class="form-control" type='text' name="stock" value='' datatype="stock" nullmsg="请输入数量！"/>
                            <span class="input-group-addon">支</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">备注</label>
                    <div class="col-md-8">
                        <textarea name="remarks" class="form-control"></textarea>
                        <div class="help-block">
                            如不填写,备注会自动填充"{产品名}出库{数量}"或"{产品名}入库{数量}"
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9"><div id="errormsg"></div></div>
                </div>
            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-9">
                    <input type='button' id="btn_sub" class="btn blue btn-lg" value='保存'/>
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                    <input type="hidden" value="<?php echo $name ?>" name="name">
                </div>
            </div>
        </form>
    </div>
</div>
<link type="text/css" href="<?=base_url()?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet"/>
<link type="text/css" href="<?=base_url()?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
<script type="text/javascript">
$(function () {
    var form = $("#addForm").Validform({
        btnSubmit: '#btn_sub',
        tiptype:function(msg,o,cssctl){
            var objtip=$("#errormsg");
            cssctl(objtip,o.type);
            objtip.text(msg);
        },
        datatype:{
            "stock" : /^-{0,1}\d+$/
        },
        ajaxPost:true,
        callback:function(response){
            if(response.status == "y"){         
                form.resetForm();
                $('#myModal').modal('hide');
                $('#product_view').click();
            }
        }
    });    

    $('#upload').fileupload({
        url: '<?=site_url("files/imgUpload/?dir=news")?>',
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        done: function (e, data) {
            if(data.result.file){
                $('.thumbnail img').attr('src', data.result.file.url);
                $("#uploadstatus").html('上传成功');
                $("#picurl").val(data.result.file.url);
            }
            else if(data.result.error){            
                $("#uploadstatus").html(data.result.error);
                $("#uploadstatus").show();
            }
        }
    });
})
</script>