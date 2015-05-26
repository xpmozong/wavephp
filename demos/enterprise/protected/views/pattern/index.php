<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar">
            <li class="<?php if($data['sid'] == 12) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/12">紧急服务</a>
            </li>
            <li class="<?php if($data['sid'] == 13) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/13">例行巡检</a>
            </li>
            <li class="<?php if($data['sid'] == 14) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/14">场地驻场</a>
            </li>
            <li class="<?php if($data['sid'] == 15) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/15">远程服务</a>
            </li>
            <li class="<?php if($data['sid'] == 16) echo 'active';?>">
                <a href="<?=$homeUrl?>pattern/index/16">咨询服务</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-10 blog-main">
        <div class="info alert alert-info" role="alert">
            您当前位置： 主页 > 服务模式 > <?=$data['title']?>
        </div>
        <div class="blog-content">
            <?=$data['content']?>
        </div>
    </div>
</div>