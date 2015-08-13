<?php
$config = array(
    'projectName'           =>  'protected',
    'modelName'             =>'protected',

    'import'=>array(
        'controllers.*'
    ),

    'defaultController'     =>'site',

    'smarty'=>array(
        'isOn'              => true,    // 是否使用smarty模板 参考demo下的enterprise2项目
        'left_delimiter'    => '{%',
        'right_delimiter'   => '%}',
        'debugging'         => false,
        'caching'           => false,
        'cache_lifetime'    => 120,
        'compile_check'     => true,
        'template_dir'      => 'templates',
        'cache_dir'         => 'templates/cache',
        'config_dir'        => 'templates/config',
        'compile_dir'       => 'templates_c'
    ),
    
    'debuger'=>false,       // 显示debug信息
    
    'database'=>array(
        'db'=>array(
            'dbhost'        => '127.0.0.1',
            'dbport'        => '3306',
            'dbuser'        => 'root',
            'dbpasswd'      => '',
            'dbname'        => 'enterprise',
            'dbpconnect'    => 0,
            'dbchart'       => 'utf8',
            'table_prefix'  => ''
        )
    ),
    'session'=>array(
        'prefix'            => '',
        'timeout'           => 86400
    ),
    
    'memcache'=>array(
        'cache1' => array(
            'host'          => 'localhost',
            'port'          => 11211
        )
    ),

    'redis'=>array(
        'cache1' => array(
            'host'          => '127.0.0.1',
            'port'          => 6379
        )
    )

);
?>