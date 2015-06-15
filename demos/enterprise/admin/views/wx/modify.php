<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
var checkForm = function(){
    var gh_id = $("#gh_id").val();
    if (!gh_id) {
        alert("请输入原始ID！");
        return false;
    }
    var gh_name = $("#gh_name").val();
    if (!gh_name) {
        alert("请输入公众号名称！");
        return false;
    }
    var gh_appid = $("#gh_appid").val();
    if (!gh_appid) {
        alert("请输入应用ID！");
        return false;
    }
    var gh_appsecret = $("#gh_appsecret").val();
    if (!gh_appsecret) {
        alert("请输入应用密钥！");
        return false;
    }
    $("#save").html("提交中...");

    return true;
}
</script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <form id="form-modify" class="form-horizontal" action="<?=$homeUrl?>wx/modified" method="POST" onsubmit="return checkForm()" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php if(!empty($wx['gid'])){ echo "修改";}else{ echo "添加";}?>公众号
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="gh_id" class="col-sm-2 control-label">原始ID</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="gh_id" id="gh_id" type="text" value="<?=$wx['gh_id']?>" placeholder="请输入原始ID">
                        <input type="hidden" name="gid" value="<?=$wx['gid']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gh_name" class="col-sm-2 control-label">公众号名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="gh_name" id="gh_name" type="text" value="<?=$wx['gh_name']?>" placeholder="请输入公众号名称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gh_type" class="col-sm-2 control-label">账号类型</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="gh_type" id="gh_type" value="1" checked>
                            订阅号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gh_type" value="2" <?php if($wx['gh_type'] == 2) echo "checked";?>>
                            认证订阅号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gh_type" value="3" <?php if($wx['gh_type'] == 3) echo "checked";?>>
                            服务号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gh_type" value="4" <?php if($wx['gh_type'] == 4) echo "checked";?>>
                            认证服务号
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gh_appid" class="col-sm-2 control-label">AppID</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="gh_appid" id="gh_appid" type="text" value="<?=$wx['gh_appid']?>" placeholder="请输入应用ID">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gh_appsecret" class="col-sm-2 control-label">AppSecret</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="gh_appsecret" id="gh_appsecret" type="text" value="<?=$wx['gh_appsecret']?>" placeholder="请输入应用密钥">
                    </div>
                </div>
                <?php if($wx['gh_key']):?>
                <div class="form-group">
                    <label for="gh_appsecret" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div id="callout-input-needs-type" class="bs-callout bs-callout-info">
                            <h4 id="接口配置信息（请注意保密!!）">接口配置信息（请注意保密!!）</h4>
                            <p>URL：<?=$wx['gh_key']?></p>
                            <p>Token：<?=$wx['gh_token']?></p>
                            <p>EncodingAESKey：<?=$wx['gh_enaeskey']?></p>
                        </div>
                    </div>
                </div>
                <?php endif;?>
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