<?php /* Smarty version 2.6.25-dev, created on 2015-07-08 16:59:43
         compiled from site/index.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="myCarousel" class="container carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/img1.jpg" alt="First slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>图片1</h1>
                    <p>图片1</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/img2.jpg" alt="Second slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>图片2</h1>
                    <p>图片2</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?php echo $this->_tpl_vars['app']->request->baseUrl; ?>
/resouce/img3.jpg" alt="Third slide">
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
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">服务项目</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/6">桌面服务</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/7">网络服务</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/8">系统服务</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/9">办公设备服务</a></li class="list-group-item">
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/10">数据安全</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
service/index/11">IT设备迁移</a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">服务模式</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/12">紧急服务</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/13">例行巡检</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/14">场地驻场</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/15">远程服务</a></li>
                <li class="list-group-item"><a href="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
pattern/index/16">咨询服务</a></li>
            </ul>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">新闻中心</h3>
            </div>
            <ul class="list-group">
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['value']):
?>
                    <li class="list-group-item">
                        【<?php echo $this->_tpl_vars['value']['c_name']; ?>
】
                        <a href="news/article/<?php echo $this->_tpl_vars['value']['aid']; ?>
">
                            <?php echo $this->_tpl_vars['value']['title']; ?>

                        </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>