<?php /* Smarty version 2.6.25-dev, created on 2015-12-25 18:06:25
         compiled from layout/debuger.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'print_r', 'layout/debuger.html', 9, false),array('modifier', 'date_format', 'layout/debuger.html', 27, false),)), $this); ?>
<?php if ($this->_tpl_vars['debuger']): ?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Debug messages</h3>
        </div>
        <div class="panel-body" style="word-break: break-all; word-wrap:break-word;">
            <p>Session:</p>
            <?php echo print_r($this->_tpl_vars['debug']['session']); ?>

            <br><br><p>Loaded Class:</p>
            <?php $_from = $this->_tpl_vars['debug']['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['value']):
?>
                <p><?php echo $this->_tpl_vars['value']; ?>
</p>
            <?php endforeach; endif; unset($_from); ?>
            <br><p>Database:</p>
            <?php $_from = $this->_tpl_vars['debug']['database']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a'] => $this->_tpl_vars['value']):
?>
                <p>
                    [ Log time: <?php echo $this->_tpl_vars['value']['log_time']; ?>
 ]
                    [ Expend time: <?php echo $this->_tpl_vars['value']['expend_time']; ?>
 ]
                    <?php echo $this->_tpl_vars['value']['message']; ?>

                </p>
            <?php endforeach; endif; unset($_from); ?>
            <br>
            <p>
                Escape time: <?php echo $this->_tpl_vars['escapetime']; ?>
, 
                4 queries, 
                PHP Memory usage: <?php echo $this->_tpl_vars['memuse']; ?>
 KB, 
                Server time: <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>

            </p>
        </div>
    </div>
</div>
<?php endif; ?>