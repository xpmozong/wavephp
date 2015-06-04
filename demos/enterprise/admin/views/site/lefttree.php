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
    <ul class="nav nav-sidebar list-group">
    <?php foreach ($list as $key => $value):?>
        <?php foreach ($value as $k => $v):?>
            <li class="list-group-item">
                <a href="<?php echo $homeUrl.''.$v['permission_url'];?>" target="right_frame">
                    <?php echo $v['permission_name'];?>
                </a>
            </li>
        <?php endforeach;?>
    <?php endforeach;?>
    </ul>
</div>