<?php /* Smarty version 2.6.25-dev, created on 2015-12-25 18:07:31
         compiled from site/index.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<nav class="navbar navbar-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">wavephp</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->_tpl_vars['homeUrl']; ?>
">Wavephp框架</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php $_from = $this->_tpl_vars['categorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['cate']):
?>
                    <li <?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['cate']['id']): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site?cid=<?php echo $this->_tpl_vars['cate']['id']; ?>
">
                        <?php echo $this->_tpl_vars['cate']['name']; ?>

                        </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
            <?php if ($this->_tpl_vars['isLogin']): ?>
            <form class="navbar-form navbar-right">
                <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site/add" class="btn btn-info">添加</a>
                <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site/logout" class="btn btn-warning">退出</a>
            </form>
            <?php else: ?>
            <form class="navbar-form navbar-right" method="POST" action="<?php echo $this->_tpl_vars['homeUrl']; ?>
site/loging">
                <div class="form-group">
                    <input type="text" placeholder="邮箱" class="form-control" name="user_login">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="密码" class="form-control" name="user_pass">
                </div>
                <button type="submit" class="btn btn-success">登录</button>
            </form>
            <?php endif; ?>
        </div><!-- /.nav-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->

<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <?php $_from = $this->_tpl_vars['blogList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['blog']):
?>
                <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site?cid=<?php echo $this->_tpl_vars['blog']['category'][0]['id']; ?>
&blogId=<?php echo $this->_tpl_vars['blog']['blogId']; ?>
" class="list-group-item <?php if ($this->_tpl_vars['blogId'] == $this->_tpl_vars['blog']['blogId']): ?>active<?php endif; ?>">
                    <?php echo $this->_tpl_vars['blog']['title']; ?>

                </a>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div><!--/.sidebar-offcanvas-->
        <div class="col-xs-12 col-sm-9">
            <div class="row r-main">
                <header class="post-header">
                    <div class="post-title"><?php echo $this->_tpl_vars['nowblog']['title']; ?>
</div>
                    <p class="post-meta">
                        <?php echo $this->_tpl_vars['nowblog']['date']; ?>
 • <?php echo $this->_tpl_vars['nowblog']['author']; ?>
 
                    </p>
                    <?php if ($this->_tpl_vars['isLogin']): ?>
                    <p class="post-meta">
                        <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site/modify?blogId=<?php echo $this->_tpl_vars['nowblog']['blogId']; ?>
" class="btn btn-xs btn-success">编辑</a> | 
                        <a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
site/delete?blogId=<?php echo $this->_tpl_vars['nowblog']['blogId']; ?>
" onclick="return confirm('请确认是否删除')"  class="btn btn-xs btn-danger">删除</a>
                    </p>
                    <?php endif; ?>
                </header>
                <article class="post-content">
                    <?php echo $this->_tpl_vars['nowblog']['content']; ?>

                </article>
            </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->
    </div><!--/row-->
    <hr>
    <footer>
        <p>&copy; Copyright 2015</p>
    </footer>
</div><!--/.container-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>