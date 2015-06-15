<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
var checkForm = function(){
    var gid = $("#gid").val();
    if (!gid) {
        alert("请选择公众号！");
        return false;
    }
    var content = $("#content").val();
    if (!content) {
        alert("请输入JSON格式的菜单！");
        return false;
    }
    $("#save").html("提交中...");

    return true;
}
</script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <form id="form-modify" class="form-horizontal" action="<?=$homeUrl?>wxmenu/modified" method="POST" onsubmit="return checkForm()" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php if(!empty($wxmenu['mid'])){ echo "修改";}else{ echo "添加";}?>菜单
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">公众号</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="mid" value="<?=$wxmenu['mid']?>">
                        <?php if($wxmenu['mid']):?>
                        <input class="form-control" type="text" readOnly value="<?=$wxmenu['gh_name']?>">
                        <input type="hidden" name="gid" id="gid" value="<?=$wxmenu['gid']?>">
                        <?php else:?>
                        <select class="form-control f-select" name="gid" id="gid">
                            <?php foreach ($wxdata as $key => $value):?>
                                <option value="<?=$value['gid']?>"><?=$value['gh_name']?></option>
                            <?php endforeach;?>
                        </select>
                        <?php endif;?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="url" class="col-sm-2 control-label">菜单</label>
                    <div class="col-sm-10">
                        <textarea name="content" id="content" class="form-control" rows="18"><?=$wxmenu['content']?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">
                                返回
                        </button>
                        <button type="submit" class="btn btn-primary" id="save">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>