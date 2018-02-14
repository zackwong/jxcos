<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption"><i class="icon-reorder"></i></div>
    </div>
    <div class="portlet-body form">
        <form id='user_edit' class="form-horizontal" action="<?php echo site_url('user_admin/user_edit_save')?>">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 col-md-3 control-label">用户名</label>
                    <div class="col-md-4">
                        <span class="help-block"><?=$user->username?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">用户角色</label>
                    <div class="col-md-4">
                        <select name='role_id' id='role'>
                            <?php foreach($roles as $key => $row):?>
                                <option value='<?=$row->id?>' <?php if($user->role_id ==$row->id){echo "selected='true'";}?>><?=$row->cnname?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">姓名</label>
                    <div class="col-md-4">
                        <input class="form-control" type='text' name='profile[name]' value='<?=$profile->name?>' />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">联系电话</label>
                    <div class="col-md-4">
                        <input class="form-control" type='text' name='profile[mobile]' value='<?=$profile->mobile?>' datatype="n" nullmsg="请输入联系电话！"/>
                    </div>
                </div>
            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-9">
                    <input type='button' class="btn blue btn-lg" value='保存' onclick='edit_user_save()'/>
                    <input type='hidden' name='user_id' value='<?=$user_id?>'/>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function edit_user_save()
{
    var data = $('#user_edit').serialize()
    $.ajax({
        type: "POST",
        url: siteUrl('admin/user_admin/user_edit_save'),
        dataType: 'json',
        data: data,
        success: function(respone){
            alert( respone.info );
            $('#myModal').modal('hide');
            $('#users_view').click();
        }
    });
}
</script>
