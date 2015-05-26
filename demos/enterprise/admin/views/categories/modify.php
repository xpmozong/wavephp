<?php $homeUrl = Wave::app()->homeUrl;?>
<form  id="form-modify" class="form-horizontal" action="<?php echo $homeUrl.'categories/modified';?>" method="POST" onsubmit="return checkForm()">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
            <button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">返回</button>
            <?php if(!empty($data['cid'])){ echo "修改";}else{ echo "添加";}?>分类
        </h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="c_name" class="col-sm-2 control-label">分类名</label>
            <div class="col-sm-10">
                <input class="form-control" name="c_name" id="c_name" type="text" value="<?=$data['c_name']?>" placeholder="请输入分类名">
                <input type="hidden" name="cid" value="<?=$data['cid']?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save">提交</button>
    </div>
</form>
<script type="text/javascript">
var checkForm = function(){
    var c_name = $("#c_name").val();
    if (!c_name) {
        alert("请输入分类名！");
        return false;
    }

    return true;
}
</script>