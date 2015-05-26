<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar">
            <li class="<?php if($cid == 1) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/1">行业资讯</a>
            </li>
            <li class="<?php if($cid == 2) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/2">企业动态</a>
            </li>
            <li class="<?php if($cid == 3) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/3">技术文章</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-10 blog-main">
        <div class="info alert alert-info" role="alert">
            您当前位置： 主页 > 新闻中心 > <?=$category['c_name']?>
        </div>
        <div class="blog-content">
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($list as $key => $value):?>
                    <tr>
                        <td width="85%">【<?=$value['c_name']?>】
                            <a href="<?=$homeUrl?>news/article/<?=$value['aid']?>"><?=$value['title']?></a>
                        </td width="15%">
                        <td><?php echo date('Y-m-d', strtotime($value['add_date']));?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?=$pagebar?>
        </div>
    </div>
</div>

