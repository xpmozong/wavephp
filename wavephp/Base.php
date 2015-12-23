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
 * Wavephp Application Base Class
 *
 * 基础类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class Base
{
    private static $frameworkPath;      // 框架路径
    private static $projectPath;        // 项目路径
    private static $projectName;        // 项目名称
    private static $modelName;          // 需要加载的模型文件夹名
    private static $hostInfo;           // 当前域名
    private static $pathInfo;           // 除域名外以及index.php
    private static $homeUrl;            // 除域名外的地址
    private static $baseUrl;            // 除域名外的根目录地址
    private static $import;             // 需要加载的文件夹
    private static $config;             // 配置项目
    private static $defaultControl;     // 默认控制层
    

    /**
     * 初始化
     */
    public function __construct($config = null)
    {
        if(empty(self::$config)) {
            if(!empty($config)) {
                if (!isset($config['debuger'])) {
                    $config['debuger'] = false;
                }
                self::$config = $config;
            }
        }

        if(empty(self::$projectName)) {
            self::$projectName = !empty($config['projectName']) 
            ? $config['projectName'] : 'protected';
        }

        if(empty(self::$modelName)) {
            self::$modelName = !empty($config['modelName']) 
            ? $config['modelName'] : 'protected';
        }

        if(empty(self::$import)){
            self::$import = !empty($config['import']) ? $config['import'] : '';
        }

        if(empty(self::$defaultControl)) {
            self::$defaultControl = !empty($config['defaultController']) 
            ? $config['defaultController'] : 'site';
        }

        $this->loadBase();
    }

    /**
     * 基础设置
     */
    private function loadBase()
    {
        $scriptArr = explode('/', $_SERVER['SCRIPT_NAME']);
        $enterFile = end($scriptArr);
        array_pop($scriptArr);
        $scriptName = implode('/', $scriptArr);
        unset($scriptArr);

        if(empty(self::$projectPath)) {
            self::$projectPath = $_SERVER['DOCUMENT_ROOT'].$scriptName.'/';
        }

        if(empty(self::$frameworkPath)) {
            self::$frameworkPath = dirname(__FILE__).'/';
        }

        if(empty(self::$hostInfo)) {
            self::$hostInfo = 
            isset($_SERVER['HTTP_HOST']) 
            ? strtolower($_SERVER['HTTP_HOST']) : '';
        }

        if ($enterFile == 'index.php') {
            if(empty(self::$pathInfo)) {
                $pathUrl = str_replace($scriptName, '', $_SERVER['REQUEST_URI']);
                self::$pathInfo = str_replace($enterFile, '', $pathUrl);
            }
            if(empty(self::$homeUrl)) {
                self::$homeUrl = $scriptName.'/';
            }
        }else{
            if(empty(self::$pathInfo)) {
                self::$pathInfo = 
                isset($_SERVER['PATH_INFO']) 
                ? strtolower($_SERVER['PATH_INFO']) : '/site/index';
            }

            if(empty(self::$homeUrl)) {
                self::$homeUrl = 
                isset($_SERVER['SCRIPT_NAME']) 
                ? strtolower($_SERVER['SCRIPT_NAME']).'/' : '/';
            }
        }

        if(empty(self::$baseUrl)) {
            self::$baseUrl = $scriptName;
        }
    }

    /**
     * 一些公共参数，供项目调用的
     *
     * 例如在项目中输出除域名外的根目录地址 Wave::app()->homeUrl;
     *
     * @return object array
     *
     */
    public static function app()
    {
        $parameter = $request = array();
        $parameter['frameworkPath']     = self::$frameworkPath;
        $parameter['projectPath']       = self::$projectPath;
        $parameter['projectName']       = self::$projectName;
        $parameter['modelName']         = self::$modelName;
        $parameter['homeUrl']           = self::$homeUrl;
        $parameter['defaultControl']    = self::$defaultControl;
        $parameter['config']            = self::$config;
        $parameter['import']            = self::$import;
        $request['hostInfo']            = self::$hostInfo;
        $request['pathInfo']            = self::$pathInfo;
        $request['baseUrl']             = self::$baseUrl;
        $parameter['request']           = (object) $request;
        unset($request);

        return (object) $parameter;
    }

    /**
     * 清理
     */
    public function clear()
    {
        self::$frameworkPath    = '';
        self::$projectPath      = '';
        self::$projectName      = '';
        self::$config           = '';
        self::$import           = '';
        self::$hostInfo         = '';
        self::$pathInfo         = '';
        self::$homeUrl          = '';
        self::$baseUrl          = '';
        self::$defaultControl   = '';
    }

    /**
     * 框架内加载文件
     *
     * @param string $file      文件名
     *
     */
    public function requireFrameworkFile($file=null)
    {
        if (!empty($file)) {
            require self::$frameworkPath.$file.'.php';
        }else{
            exit('no file');
        }
    }

    /**
     * 项目内加载文件
     *
     * @param string $file      文件名
     *
     */
    public function requireProjectFile($file=null)
    {
        if (!empty($file)) {
            require self::$projectPath.$file.'.php';
        }else{
            exit('no file');
        }
    }

}
?>