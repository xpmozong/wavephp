<?php
$config = array(
    'projectName'           => 'protected',
    'modelName'             => 'protected',

    'import'                => array(
        'controllers.*'
    ),

    'defaultController'     => 'site',

    'smarty'                => array(
        'isOn'              => true,    // 是否使用smarty模板 参考demo下的enterprise2项目
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
    
    'debuger'               =>false ,       // 显示debug信息
    
    'database'              => array(
        'driver'            => 'mysql',
        'master'            => array(
            'dbhost'        => '127.0.0.1',
            'username'      => 'root',
            'password'      => '',
            'dbname'        => 'enterprise',
            'charset'       => 'utf8',
            'table_prefix'  => '',
            'pconnect'      => false
        ),
        'slave'            => array(
            'dbhost'        => '127.0.0.1',
            'username'      => 'root',
            'password'      => '',
            'dbname'        => 'enterprise',
            'charset'       => 'utf8',
            'table_prefix'  => '',
            'pconnect'      => false
        )
    ),
    'session'=>array(
        // 'cache'             => 'memcache',
        'prefix'            => '',
        'timeout'           => 86400
    ),
    'memcache'=>array(
        array(
            'host'          => 'localhost',
            'port'          => 11211
        ),
    ),
    // 'redis'=>array(
    //     'master' => array(
    //         'host'          => '127.0.0.1',
    //         'port'          => 6379
    //     ),
    //     'slave' => array(
    //         array(
    //             'host'          => '127.0.0.1',
    //             'port'          => 63791
    //         ),
    //         array(
    //             'host'          => '127.0.0.1',
    //             'port'          => 63792
    //         )
    //     )
    // )
);
?>