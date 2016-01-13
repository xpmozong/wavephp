<?php
$config = array(
    'projectName'           => 'protected',
    'modelName'             => 'protected',

    'import'                => array(
        'controllers.*'
    ),

    'defaultController'     => 'site',

    'smarty'                => array(
        'is_on'             => true,    // 是否使用smarty模板 参考demo下的enterprise2项目
        'left_delimiter'    => '{%',
        'right_delimiter'   => '%}',
        'debugging'         => false,
        'caching'           => false,
        'cache_lifetime'    => 120,
        'compile_check'     => true,
        'template_dir'      => 'templates',
        'config_dir'        => 'templates/config',
        'cache_dir'         => 'data/templates/cache/index',
        'compile_dir'       => 'data/templates/compile/index'
    ),
    'debuger'               => false,       // 显示debug信息
    'ini_set'               => array(
        'session.cookie_domain'     => '.37study.com',
        'memory_limit'              => '256M',
        'session.cache_expire'      => '',
        'session.use_cookies'       => 1,
        'session.auto_start'        => 0,
        'session.cookie_lifetime'   => 86400,
        'session.gc_maxlifetime'    => 86400,
        'display_errors'            => 1,
        'date.timezone'             => 'Asia/Shanghai'
    ),
    'session'=>array(
        'driver'            => 'file',
        'timeout'           => 86400
    )
);
?>