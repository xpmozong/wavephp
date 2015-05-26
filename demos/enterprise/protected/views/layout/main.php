<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>企业网站</title>
<?php $baseUrl = Wave::app()->request->baseUrl;?>
<?php $homeUrl = Wave::app()->homeUrl;?>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/resouce/bootstrap/css/bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/resouce/css/index.css"/>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/js/common.js"></script>
<script type="text/javascript">
$(function(){
    $('.carousel').carousel({
        interval: 2000
    });

    $.getJSON("<?php echo $homeUrl.'site/links';?>", function(data){
        var txt = '';
        for (var i = 0; i < data.length; i++) {
            txt += '<li><a href="'+data[i].url+'">'+data[i].title+'</a></li>';
        };
        $("#link-urls").html(txt);
    });
})
</script>
</head>
<body>
<div class="container clearfix">
    <div class="pull-left head-left">
        <a href="<?=$homeUrl?>">
            企业网站
        </a>
    </div>
    <div class="pull-right head-right clearfix">
        <div class="up-space pull-left">
            <a href="http://www.it-team.cn/" onclick="window.external.addFavorite(this.href,this.title);return false;" title='IT外包服务公司' rel="sidebar">加入收藏</a>
        </div>
        <!-- <div class="qq pull-left">
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=136626441&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:136626441:41" alt="点击这里给我发消息" title="点击这里给我发消息"></a>
        </div>
        <div class="share pull-left">
            <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"></a><a href="#" class="bds_tsina" data-cmd="tsina"></a><a href="#" class="bds_tqq" data-cmd="tqq"></a><a href="#" class="bds_renren" data-cmd="renren"></a><a href="#" class="bds_weixin" data-cmd="weixin"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
        </div> -->
    </div>
</div>
<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?=$homeUrl?>">首页</a></li>
                        <li class="dropdown">
                            <a href="javascript:;" id="service-items-id">服务项目</a>
                            <ul role="menu" class="dropdown-menu" id="service-items">
                                <li><a href="<?=$homeUrl?>service/index/6">桌面服务</a></li>
                                <li><a href="<?=$homeUrl?>service/index/7">网络服务</a></li>
                                <li><a href="<?=$homeUrl?>service/index/8">系统服务</a></li>
                                <li><a href="<?=$homeUrl?>service/index/9">办公设备服务</a></li>
                                <li><a href="<?=$homeUrl?>service/index/10">数据安全</a></li>
                                <li><a href="<?=$homeUrl?>service/index/11">IT设备迁移</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" id="service-mode-id">服务模式</a>
                            <ul role="menu" class="dropdown-menu" id="service-mode">
                                <li><a href="<?=$homeUrl?>pattern/index/12">紧急服务</a></li>
                                <li><a href="<?=$homeUrl?>pattern/index/13">例行巡检</a></li>
                                <li><a href="<?=$homeUrl?>pattern/index/14">场地驻场</a></li>
                                <li><a href="<?=$homeUrl?>pattern/index/15">远程服务</a></li>
                                <li><a href="<?=$homeUrl?>pattern/index/16">咨询服务</a></li>
                            </ul>
                        </li>
                        <li><a href="<?=$homeUrl?>example">客户案例</a></li>
                        <li class="dropdown">
                            <a href="<?=$homeUrl?>news/index/0" id="news-center-id">新闻中心</a>
                            <ul role="menu" class="dropdown-menu" id="news-center">
                                <li><a href="<?=$homeUrl?>news/index/1">行业资讯</a></li>
                                <li><a href="<?=$homeUrl?>news/index/2">企业动态</a></li>
                                <li><a href="<?=$homeUrl?>news/index/3">技术文章</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a id="about-us-id" href="<?=$homeUrl?>about/index/4">关于我们</a>
                            <ul role="menu" class="dropdown-menu" id="about-us">
                                <li><a href="<?=$homeUrl?>about/index/1">公司简介</a></li>
                                <li><a href="<?=$homeUrl?>about/index/2">加入我们</a></li>
                                <li><a href="<?=$homeUrl?>about/index/3">联系我们</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<?php echo $content;?>
<div class="container links clearfix">
    <h3>友情链接</h3>
    <ul id="link-urls">

    </ul>
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

