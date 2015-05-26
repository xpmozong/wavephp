<?php
$config = array(
    'projectName'=>'protected',
    'modelName'=>'protected',

    'import'=>array(
        'models.*'
    ),

    'defaultController'=>'site',
    
    // 'database'=>array(
    //     'db'=>array(
    //         'dbhost'        => 'localhost',
    //         'dbport'        => '3306',
    //         'dbuser'        => 'root',
    //         'dbpasswd'      => '',
    //         'dbname'        => 'wordpress',
    //         'dbpconnect'    => 0,
    //         'dbchart'       => 'utf8'
    //     ),
    //     'db2'=>array(
    //         'dbhost'        => 'localhost',
    //         'dbport'        => '3306',
    //         'dbuser'        => 'root',
    //         'dbpasswd'      => '',
    //         'dbname'        => 'joke',
    //         'dbpconnect'    => 0,
    //         'dbchart'       => 'utf8'
    //     )
    // ),
    'session'=>array(
        'prefix'               => 'hw',
        'timeout'           => 86400
    ),
    // 'memcache'=>array(
    //     'cache1' => array(
    //         'host'              => 'localhost',
    //         'port'              => '11211'
    //     )
    // )
);
?>