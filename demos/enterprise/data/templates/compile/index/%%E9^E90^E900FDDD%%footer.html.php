<?php /* Smarty version 2.6.25-dev, created on 2015-12-25 18:06:25
         compiled from layout/footer.html */ ?>
<div class="container links">
    <div class="panel panel-default clearfix">
        <div class="panel-heading">
            <h3 class="panel-title">友情链接</h3>
        </div>
        <div class="panel-body">
            <ul id="link-urls">
                <?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['value']):
?>
                    <li>
                        <a href="<?php echo $this->_tpl_vars['value']['url']; ?>
" target="_blank">
                            <?php echo $this->_tpl_vars['value']['title']; ?>

                        </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/debuger.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>