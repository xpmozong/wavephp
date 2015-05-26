<?php $baseUrl = Wave::app()->request->baseUrl;?>
<?php $homeUrl = Wave::app()->homeUrl;?>
<div id="myCarousel" class="container carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="<?=$baseUrl?>/resouce/img1.jpg" alt="First slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>图片1</h1>
                    <p>图片1</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?=$baseUrl?>/resouce/img2.jpg" alt="Second slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>图片2</h1>
                    <p>图片2</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?=$baseUrl?>/resouce/img3.jpg" alt="Third slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>图片3</h1>
                    <p>图片3</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="container marketing index-menu">
    <div class="col-lg-4 blog-sidebar">
        <div class="sidebar-module menues">
            <h4>服务项目</h4>
            <ol class="list-unstyled">
                <li><a href="<?=$homeUrl?>service/index/6">桌面服务</a></li>
                <li><a href="<?=$homeUrl?>service/index/7">网络服务</a></li>
                <li><a href="<?=$homeUrl?>service/index/8">系统服务</a></li>
                <li><a href="<?=$homeUrl?>service/index/9">办公设备服务</a></li>
                <li><a href="<?=$homeUrl?>service/index/10">数据安全</a></li>
                <li><a href="<?=$homeUrl?>service/index/11">IT设备迁移</a></li>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 blog-sidebar">
        <div class="sidebar-module menues">
            <h4>服务模式</h4>
            <ol class="list-unstyled">
                <li><a href="<?=$homeUrl?>pattern/index/12">紧急服务</a></li>
                <li><a href="<?=$homeUrl?>pattern/index/13">例行巡检</a></li>
                <li><a href="<?=$homeUrl?>pattern/index/14">场地驻场</a></li>
                <li><a href="<?=$homeUrl?>pattern/index/15">远程服务</a></li>
                <li><a href="<?=$homeUrl?>pattern/index/16">咨询服务</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-4 blog-sidebar">
        <div class="sidebar-module menues">
            <h4>新闻中心</h4>
            <ol class="list-unstyled">
                 <?php foreach ($list as $key => $value):?>
                    <li>
                        【<?=$value['c_name']?>】
                        <a href="<?=$homeUrl?>news/article/<?=$value['aid']?>"><?=$value['title']?></a>
                    </li>
                <?php endforeach;?>
            </ol>
        </div>
    </div>
</div>