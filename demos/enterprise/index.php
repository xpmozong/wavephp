<?php
require dirname(__FILE__).'/init.php';
require ROOT_DIR.'/../../wavephp/Wave.php';
$config = ROOT_DIR.'/protected/config/main.php';

$wave = new Wave($config);
$wave->run();

?>