<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar list-group">
            <li class="list-group-item <?php if($data['sid'] == 12) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/12">紧急服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 13) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/13">例行巡检</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 14) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/14">场地驻场</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 15) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/15">远程服务</a>
            </li>
            <li class="list-group-item <?php if($data['sid'] == 16) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/16">咨询服务</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-10 blog-main">
        <div class="panel panel-default">
            <div class="panel-heading">
                您当前位置：
                <a href="<?=$homeUrl?>">首页</a> &gt;
                服务模式 &gt;
                <?=$data['title']?>
            </div>
            <div class="panel-body">
                <?=$data['content']?>
            </div>
        </div>
    </div>
</div>