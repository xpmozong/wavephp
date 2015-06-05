<?php $homeUrl = Wave::app()->homeUrl;?>
<div class="container links">
    <div class="panel panel-default clearfix">
        <div class="panel-heading">
            <h3 class="panel-title">友情链接</h3>
        </div>
        <div class="panel-body">
            <ul id="link-urls">
                <?php foreach ($links as $key => $value):?>
                    <li>
                        <a href="<?=$value['url']?>" target="_blank"><?=$value['title']?></a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<div class="container marketing footer">
    <!-- FOOTER -->
    <footer>
        <p class="pull-right"><a href="#">返回顶部</a></p>
        <p>&copy; 2014 企业网站</p>
    </footer>
</div>
</body>
</html>