<?php /* Smarty version 2.6.25-dev, created on 2015-12-25 17:56:29
         compiled from site/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'I18n', 'site/index.html', 2, false),)), $this); ?>
测试多语言
<?php echo smarty_function_I18n(array('var' => "平台管理"), $this);?>

<br>
hostInfo=<?php echo $this->_tpl_vars['hostInfo']; ?>

<br>
pathInfo=<?php echo $this->_tpl_vars['pathInfo']; ?>

<br>
homeUrl=<?php echo $this->_tpl_vars['homeUrl']; ?>

<br>
baseUrl=<?php echo $this->_tpl_vars['baseUrl']; ?>