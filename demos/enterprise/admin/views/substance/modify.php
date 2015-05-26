<?php $homeUrl = Wave::app()->homeUrl;?>
<?php $baseUrl = Wave::app()->request->baseUrl;?>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
$(function(){
    CKEDITOR.replace( 'content', {
        uiColor : '#9AB8F3',
        language: 'zh-cn',
        height: 300,
        filebrowserUploadUrl : "<?=$homeUrl?>substance/upload?type=files",
        filebrowserImageUploadUrl : "<?=$homeUrl?>substance/upload?type=images",
        filebrowserFlashUploadUrl : "<?=$homeUrl?>substance/upload?type=flashs"
    });
})

var checkForm = function(){
    var title = $("#title").val();
    if (!title) {
        alert("请输入文章标题！");
        return false;
    }
    $("#save").html("提交中...");

    return true;
}
</script>
<form id="form-modify" class="form-horizontal" action="<?=$homeUrl?>substance/modified" method="POST" onsubmit="return checkForm()" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
            <button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">返回</button>
            <?php if(!empty($substance['sid'])){ echo "修改";}else{ echo "添加";}?>内容
        </h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">内容标题</label>
            <div class="col-sm-10">
                <input class="form-control" name="title" id="title" type="text" value="<?=$substance['title']?>" placeholder="请输入内容标题">
                <input type="hidden" name="sid" value="<?=$substance['sid']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="describe" class="col-sm-2 control-label">文章内容</label>
            <div class="col-sm-10">
                <textarea name="content" id="describe"><?=$substance['content']?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save">提交</button>
    </div>
</form>