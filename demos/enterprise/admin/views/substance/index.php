<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
// 删除
var mdelete = function(id){
    if(window.confirm('确定删除？')){
        $.getJSON("<?php echo $homeUrl.'substance/delete/';?>"+id, function(data){
            if(data.success == true){
                window.location.href = "<?php echo $homeUrl.'substance';?>";
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
            <h3 class="panel-title">内容列表
                <button type="button" class="btn btn-success btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'substance/modify/0';?>'">
                    添加内容
                </button>
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">内容ID</th>
                        <th width="60%">内容标题</th>
                        <th width="30%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $key => $value):?>
                    <tr>
                        <td><?php echo $value['sid'];?></td>
                        <td><?php echo $value['title'];?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" onclick="javascript:location.href='<?php echo $homeUrl.'substance/modify/'.$value['sid'];?>'">修改</button>
                            |
                            <button type="button" class="btn btn-danger btn-xs" onclick="mdelete(<?php echo $value['sid'];?>)">删除</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?=$pagebar?>
        </div> 
    </div>
</div>