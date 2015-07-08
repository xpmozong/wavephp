<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo $homeUrl;?>" target="_top">企业管理后台</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo $homeUrl.'site/logout';?>" target="_top">退出</a></li>
            </ul>
        </div>
    </div>
</div>