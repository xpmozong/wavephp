<?php /* Smarty version 2.6.25-dev, created on 2015-12-11 17:58:28
         compiled from site/login.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
var checkForm = function(){
    var user_login = $("#user_login").val();
    var user_pass = $("#user_pass").val();
    if(!user_login){
        alert("请输入邮箱！");
        return false;
    }
    if(!user_pass){
        alert("请输入密码！");
        return false;
    }
}
</script>
<div class="container">
    <div class="con-login">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $this->_tpl_vars['title']; ?>
登录</h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-signin" role="form" id="login-form" action="<?php echo $this->_tpl_vars['app']->homeUrl; ?>
site/loging" onsubmit="return checkForm()">
                    <div class="form-group" id="login-form">
                        <label for="user_login">邮箱</label>
                        <input id="user_login" type="text" name="user_login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input id="user_pass" type="password" name="user_pass" class="form-control">
                    </div>
                    <button class="btn btn-success btn-block" id="submit" type="submit">
                        登录
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>