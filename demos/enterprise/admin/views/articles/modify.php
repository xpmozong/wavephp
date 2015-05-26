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
        filebrowserUploadUrl : "<?=$homeUrl?>articles/upload?type=files",
        filebrowserImageUploadUrl : "<?=$homeUrl?>articles/upload?type=images",
        filebrowserFlashUploadUrl : "<?=$homeUrl?>articles/upload?type=flashs"
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
<form id="form-modify" class="form-horizontal" action="<?=$homeUrl?>articles/modified" method="POST" onsubmit="return checkForm()" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
            <button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">返回</button>
            <?php if(!empty($article['aid'])){ echo "修改";}else{ echo "添加";}?>文章
        </h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="cid" class="col-sm-2 control-label">文章分类</label>
            <div class="col-sm-10">
                <select name="cid" id="cid" class="form-control">
                    <?php foreach ($category as $key => $value):?>
                        <option <?php if($article['cid'] == $value['cid']) echo "selected"; ?> value="<?=$value['cid']?>"><?=$value['c_name']?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">文章标题</label>
            <div class="col-sm-10">
                <input class="form-control" name="title" id="title" type="text" value="<?=$article['title']?>" placeholder="请输入文章标题">
                <input type="hidden" name="aid" value="<?=$article['aid']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="describe" class="col-sm-2 control-label">文章内容</label>
            <div class="col-sm-10">
                <textarea name="content" id="describe"><?=$article['content']?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save">提交</button>
    </div>
</form>