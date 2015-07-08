<?php /* Smarty version 2.6.25-dev, created on 2015-07-08 16:59:43
         compiled from layout/header.html */ ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试</title>
<link type="text/css" rel="stylesheet" href="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/bootstrap/css/bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/css/index.css"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/js/common.js"></script>
<script type="text/javascript">
$(function(){
    $('.carousel').carousel({
        interval: 2000
    });
    $("#login-exit").hide();
    $.getJSON("<?php echo $this->_tpl_vars['app']->homeUrl; ?>
site/userinfo", function(json){
        var txt = '';
        if (json.success == true) {
            txt += json.username;
            txt += ' <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
site/logout" class="btn btn-danger btn-xs">退出</a>';
            $("#login-in").html(txt);
            $("#login-in").show();
            $("#login-exit").hide();
        }else{
            $("#login-in").html(txt);
            $("#login-in").hide();
            $("#login-exit").show();
        }
    });
})
</script>
</head>
<body>
<div class="container clearfix">
    <div class="pull-left head-left">
        <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
">
            测试
        </a>
    </div>
    <div class="pull-right head-right clearfix">
        <div class="up-space pull-left" id="login-exit">
            <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
site/login" class="btn btn-success btn-xs">登录</a>
            <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
site/regist" class="btn btn-info btn-xs">注册</a>
        </div>
        <div class="up-space pull-left" id="login-in">
            
        </div>
    </div>
</div>
<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
">首页</a></li>
                        <li class="dropdown">
                            <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/6" id="service-items-id">服务项目</a>
                            <ul role="menu" class="dropdown-menu" id="service-items">
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/6">桌面服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/7">网络服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/8">系统服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/9">办公设备服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/10">数据安全</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/11">IT设备迁移</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/12" id="service-mode-id">服务模式</a>
                            <ul role="menu" class="dropdown-menu" id="service-mode">
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/12">紧急服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/13">例行巡检</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/14">场地驻场</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/15">远程服务</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/16">咨询服务</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
example">客户案例</a></li>
                        <li class="dropdown">
                            <a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
news/index/0" id="news-center-id">新闻中心</a>
                            <ul role="menu" class="dropdown-menu" id="news-center">
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
news/index/1">行业资讯</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
news/index/2">企业动态</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
news/index/3">技术文章</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a id="about-us-id" href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
about/index/1">关于我们</a>
                            <ul role="menu" class="dropdown-menu" id="about-us">
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
about/index/1">公司简介</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
about/index/2">加入我们</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
about/index/3">联系我们</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>