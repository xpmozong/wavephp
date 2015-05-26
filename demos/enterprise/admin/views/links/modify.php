<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
var checkForm = function(){
    var title = $("#title").val();
    if (!title) {
        alert("请输入链接标题！");
        return false;
    }
    $("#save").html("提交中...");

    return true;
}
</script>
<form id="form-modify" class="form-horizontal" action="<?=$homeUrl?>links/modified" method="POST" onsubmit="return checkForm()" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
            <button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">返回</button>
            <?php if(!empty($links['lid'])){ echo "修改";}else{ echo "添加";}?>链接
        </h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">链接标题</label>
            <div class="col-sm-10">
                <input class="form-control" name="title" id="title" type="text" value="<?=$links['title']?>" placeholder="请输入链接标题">
                <input type="hidden" name="lid" value="<?=$links['lid']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">链接URL</label>
            <div class="col-sm-10">
                <input class="form-control" name="url" id="url" type="text" value="<?=$links['url']?>" placeholder="请输入链接URL">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save">提交</button>
    </div>
</form>