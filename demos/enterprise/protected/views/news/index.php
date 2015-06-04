<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container marketing content">
    <div class="col-sm-2 blog-sidebar">
        <ul class="nav nav-sidebar list-group">
            <li class="list-group-item <?php if($cid == 1) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/1">行业资讯</a>
            </li>
            <li class="list-group-item <?php if($cid == 2) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/2">企业动态</a>
            </li>
            <li class="list-group-item <?php if($cid == 3) echo 'active';?>">
                <a href="<?=$homeUrl?>news/index/3">技术文章</a>
            </li>
        </ul>
    </div>
    <div class="col-sm-10 blog-main">
        <div class="panel panel-default">
            <div class="panel-heading">
                您当前位置：
                <a href="<?=$homeUrl?>">首页</a> &gt;
                <a href="<?=$homeUrl?>news/index/0">新闻中心</a> &gt;
                <?=$category['c_name']?>
            </div>
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
        </div>
        <?=$pagebar?>
    </div>
</div>

