<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2013
 * @link            https://github.com/xpmozong/wavephp
 * @since           Version 1.0
 *
 */

/**
 * Wavephp Application WaveLoader Class
 *
 * 自定加载类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class WaveLoader
{
    /**
     * 自动加载函数
     *
     * 例如 $User = new User();
     * 会自动加载  项目路径/models/User.php 这个文件
     * 例如 extends CommonController
     * 会自动加载 项目路径/controllers/CommonController.php 这个文件
     * 
     */
    public static function loader($class)
    {
        $app = Wave::app();
        $filename = $app->projectPath.$app->modelName.
                    '/models/'.$class.'.php';
        if(file_exists($filename)){
            require $filename;
            if(!class_exists($class)){
                exit('no '.$class);
            }
        }
        if(!empty($app->import)){
            $import = $app->import;
            foreach ($import as $key => $value) {
                $path = '';
                $file_array = explode('.', $value);
                foreach ($file_array as $k => $v) {
                    $path .= $v.'/';
                }
                $filename = $app->projectPath.$app->projectName.
                            '/'.str_replace('*/', '', $path).$class.'.php';
                if(file_exists($filename)){
                    require $filename;
                    if(!class_exists($class)){
                        exit('no '.$class);
                    }
                    break;
                }
            }
        }

        $dirArr = array('Cache', 'Core', 'Db', 'Language', 'Session', 'Web');
        $filename = $app->frameworkPath.$class.'.php';
        if(file_exists($filename)){
            require $filename;
            if(!class_exists($class)){
                exit('no '.$class);
            }
        }
        foreach ($dirArr as $key => $dir) {
            $filename = $app->frameworkPath.$dir.'/'.$class.'.php';
            if(file_exists($filename)){
                require $filename;
                if(!class_exists($class)){
                    exit('no '.$class);
                }
                break;
            }
        }
    }
}
?>