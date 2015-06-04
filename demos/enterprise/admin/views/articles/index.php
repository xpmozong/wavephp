<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
// 删除
var mdelete = function(id){
    if(window.confirm('确定删除？')){
        $.getJSON("<?php echo $homeUrl.'articles/delete/';?>"+id, function(data){
            if(data.success == true){
                window.location.href = "<?php echo $homeUrl.'articles';?>";
            }else{
                alert(data.msg);
            }
        })
    }
}

var changecid = function(){
    var cid = $("#cid").val();
    window.location.href = "<?php echo $homeUrl.'articles?cid=';?>" + cid;
}

</script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">文章列表
                <button type="button" class="btn btn-success btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'articles/modify/0';?>'">
                    添加文章
                </button>
            </h3>
        </div>
        <div class="panel-body">
            <div class="info">
                <form class="form-inline">
                    <div class="form-group">
                        <p class="form-control-static">文章分类：</p>
                    </div>
                    <div class="form-group">
                        <select name="cid" id="cid" class="form-control f-select" onchange="changecid()">
                            <?php foreach ($category as $key => $value):?>
                                <option <?php if($cid == $value['cid']) echo "selected"; ?> value="<?=$value['cid']?>"><?=$value['c_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </form>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="70%">文章标题</th>
                        <th width="30%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $key => $value):?>
                    <tr>
                        <td><?php echo $value['title'];?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'articles/modify/'.$value['aid'];?>'">修改</button>
                            |
                            <button type="button" class="btn btn-danger btn-xs" onclick="mdelete(<?php echo $value['aid'];?>)">删除</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?=$pagebar?>
        </div>
    </div>
</div>