<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar">
            <li class="<?php if($data['sid'] == 1) echo 'active';?>">
                <a href="<?=$homeUrl?>about/index/1">公司简介</a>
            </li>
            <li class="<?php if($data['sid'] == 2) echo 'active';?>">
                <a href="<?=$homeUrl?>about/index/2">加入我们</a>
            </li>
            <li class="<?php if($data['sid'] == 3) echo 'active';?>">
                <a href="<?=$homeUrl?>about/index/3">联系我们</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-9 blog-main">
        <div class="info alert alert-info" role="alert">
            您当前位置： 主页 > 关于我们 > <?=$data['title']?>
        </div>
        <div class="blog-content">
            <?=$data['content']?>
        </div>
    </div>
</div>