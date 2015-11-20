<?php
header('Content-Type:text/html;charset=utf-8');
// error_reporting(0);

define('ROOT_PATH', dirname(__FILE__));

require ROOT_PATH.'/define.php';
require ROOT_PATH.'/../../wavephp/Wave.php';
$config = dirname(__FILE__).'/protected/config/main.php';

$wave = new Wave($config);
$wave->run();

?>