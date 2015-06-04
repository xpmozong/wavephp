<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
// 删除
var mdelete = function(id){
    if(window.confirm('确定删除？')){
        $.getJSON("<?php echo $homeUrl.'categories/delete/';?>"+id, function(data){
            if(data.success == true){
                window.location.href = "<?php echo $homeUrl.'categories';?>"
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
            <h3 class="panel-title">分类列表
                <button type="button" class="btn btn-success btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'categories/modify/0';?>'">
                    添加分类
                </button>
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="40%">分类ID</th>
                        <th width="30%">分类名</th>
                        <th width="30%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $key => $value):?>
                    <tr>
                        <td><?php echo $value['cid'];?></td>
                        <td><?php echo $value['c_name'];?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'categories/modify/'.$value['cid'];?>'">修改</button>
                            |
                            <button type="button" class="btn btn-danger btn-xs" onclick="mdelete(<?php echo $value['cid'];?>)">删除</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
