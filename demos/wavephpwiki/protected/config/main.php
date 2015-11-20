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
    'session'=>array(
        'driver'            => 'file',
        'timeout'           => 86400
    )
);
?>