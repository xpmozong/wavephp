<?php
// error_reporting(0);

define('ROOT_PATH', dirname(__FILE__));

require ROOT_PATH.'/init.php';
require ROOT_PATH.'/../../wavephp/Wave.php';
$config = ROOT_PATH.'/admin/config/main.php';

$wave = new Wave($config);
$wave->run();

?>