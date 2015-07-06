<?php
header('Content-Type:text/html;charset=utf-8');
// error_reporting(0);

define('STATIC_URL', 'http://42.51.161.193:8888/');

require dirname(__FILE__).'/../../wavephp/Wave.php';
$config = dirname(__FILE__).'/protected/config/main.php';

$wave = new Wave($config);
$wave->run();

?>