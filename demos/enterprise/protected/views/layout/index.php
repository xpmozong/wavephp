<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>博客</title>
<?php $baseUrl = Wave::app()->request->baseUrl;?>
<?php $homeurl = Wave::app()->homeUrl;?>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/resouce/css/pure-min.css"/>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/resouce/css/public.css"/>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/resouce/css/blog.css"/>
<script type="text/javascript" src="<?=$baseUrl?>/resouce/js/jquery-1.4.3.min.js"></script>
</head>
<body class="single single-post postid-20 single-format-standard">
<div id="wrap" class="clearfix">
    <div id="header-wrap">
        <div id="pre-header" class="clearfix">
            <ul id="header-social" class="clearfix"> </ul>
        </div>
        <header id="header" class="clearfix">
            <div id="logo">
                <h2>
                    <a rel="home" title="" href="<?=$homeUrl?>">WAVEPHP框架博客</a>
                </h2>
            </div>
        </header>
    </div>
    <div id="main-content" class="clearfix">
        <?php echo $content; ?>
    </div>
    <div id="copyright">
        © Copyright 2013 ·
        <a title="寞踪的技术博客" href="<?=$homeUrl?>">寞踪的技术博客</a>
        - Theme by
        <a rel="nofollow" target="_blank" title="寞踪" href="http://xpmyblog.sinaapp.com/">寞踪</a>
    </div>
</div>
</body>
</html>

