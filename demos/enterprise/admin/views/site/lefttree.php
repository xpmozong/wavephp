<?php $homeUrl = Wave::app()->homeUrl;?>
<script type="text/javascript">
$(function(){
    $(".nav li").click(function(){
        $(".nav li").removeClass('active');
        $(this).addClass('active');
    })
})
</script>
<div class="col-sm-3 col-md-2 sidebar" id="sidebar">
    <?php foreach ($list as $key => $value):?>
        <ul class="nav nav-sidebar">
            <?php foreach ($value as $k => $v):?>
                <li><a href="<?php echo $homeUrl.''.$v['permission_url'];?>" target="right_frame"><?php echo $v['permission_name'];?></a></li>
            <?php endforeach;?>
        </ul>
    <?php endforeach;?>
</div>