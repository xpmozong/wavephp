<?php
$config = array(
    'projectName'   =>  'protected',
    'modelName'     =>  'protected',

    'import'=>array(
        'models.*'
    ),

    'defaultController'=>'site',

    'debuger'=>true,
    
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
    )
);
?>