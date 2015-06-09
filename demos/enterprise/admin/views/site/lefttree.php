<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
$(function(){
    $(".nav li").click(function(){
        $(".nav li").removeClass('active');
        $(this).addClass('active');
    })
})
</script>
<div class="sidebar" id="sidebar">
    <?php foreach ($list as $key => $value):?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><h3 class="panel-title"><?=$value['title']?></h3></h3>
        </div>
        <ul class="nav nav-sidebar list-group">
            <?php foreach ($value['list'] as $k => $v):?>
                <li class="list-group-item">
                    <a href="<?php echo $homeUrl.''.$v['permission_url'];?>" target="right_frame">
                        <?php echo $v['permission_name'];?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endforeach;?>
</div>