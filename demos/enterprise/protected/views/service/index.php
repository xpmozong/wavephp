<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar list-group">
            <li class="list-group-item <?php if($data['sid'] == 6) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/6">桌面服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 7) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/7">网络服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 8) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/8">系统服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 9) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/9">办公设备服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 10) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/10">数据安全</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 11) echo 'active';?>">
                <a href="<?=$homeUrl?>service/index/11">IT设备迁移</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-10 blog-main">
        <div class="panel panel-default">
            <div class="panel-heading">
                您当前位置：
                <a href="<?=$homeUrl?>">首页</a> &gt;
                服务项目 &gt;
                <?=$data['title']?>
            </div>
            <div class="panel-body">
                <?=$data['content']?>
            </div>
        </div>
    </div>
</div>