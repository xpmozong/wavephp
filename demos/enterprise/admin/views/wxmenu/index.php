<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
// 删除
var mdelete = function(id){
    if(window.confirm('确定删除？')){
        $.getJSON("<?php echo $homeUrl.'wxmenu/delete/';?>"+id, function(data){
            if(data.success == true){
                window.location.href = "<?php echo $homeUrl.'wxmenu';?>";
            }else{
                alert(data.msg);
            }
        })
    }
}

</script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">自定义菜单列表
                <button type="button" class="btn btn-success btn-xs pull-right" onclick="javascript:location.href='<?php echo $homeUrl.'wxmenu/modify/0';?>'">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加菜单
                </button>
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="8%">ID</th>
                        <th width="40%">公众号</th>
                        <th width="32%">自定义菜单</th>
                        <th width="20%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $key => $value):?>
                    <tr>
                        <td><?php echo $value['mid'];?></td>
                        <td><?php echo $value['gh_name'];?></td>
                        <td><?php echo $value['content'];?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'wxmenu/modify/'.$value['mid'];?>'">修改</button>
                            |
                            <button type="button" class="btn btn-danger btn-xs" onclick="mdelete(<?php echo $value['mid'];?>)">删除</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>