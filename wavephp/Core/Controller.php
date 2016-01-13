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
 * Wavephp Application Controller Class
 *
 * 控制层类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class Controller
{
    private $isSmarty       = false;    // 是否用Smarty模板

    public $view;
    public $hostInfo;           // 当前域名
    public $pathInfo;           // 除域名外以及index.php
    public $homeUrl;            // 除域名外的地址
    public $baseUrl;            // 除域名外的根目录地址

    /**
     * 初始化
     */
    public function __construct()
    {
        $app = Wave::app();
        if (isset($app->config['smarty'])) {
            if (isset($app->config['smarty']['is_on'])) {
                $this->isSmarty = $app->config['smarty']['is_on'];
            }
        }
        if ($this->isSmarty) {
            $this->view = $this->initView();
        }

        $this->hostInfo = $app->request->hostInfo;
        $this->pathInfo = $app->request->pathInfo;
        $this->homeUrl = $app->homeUrl;
        $this->baseUrl = $app->request->baseUrl;
    }

    /**
     * 模板变量赋值
     * @param string name
     * @param string value
     *
     */
    public function assign($name, $value)
    {
        $this->view->assign($name, $value);
    }

    public function fetch($resource_name = '', 
                        $cache_id = null, 
                        $compile_id = null, 
                        $display = false)
    {
        if ($this->isSmarty) {
            $this->_assignVars();
            return $this->view->fetch($resource_name,
                                    $cache_id, 
                                    $compile_id, 
                                    $display);
        }
    }

    public function display($resource_name = '', 
                            $cache_id = null, 
                            $compile_id = null)
    {
        echo $this->fetch($resource_name, 
                        $cache_id = null, 
                        $compile_id = null, 
                        true);
    }

    /**
     * 初始化view对象
     */
    public function initView(){
        if($this->view == null){
            $this->view = new View();
        }

        return $this->view;
    }

    /**
     * 将控制器的类成员赋值给模板
     */
    protected function _assignVars(){
        $vars = get_object_vars($this);
        if(is_array($vars)){
            $this->view->assign($vars);
        }
    }

    /**
     * 加载模版
     * 
     * @param string $filename      文件名
     * @param array  $variables     数据
     *
     */
    public function render($filename, $variables = array())
    {
        error_reporting(0);
        //数组变量转换
        extract($variables, EXTR_SKIP);

        require Wave::app()->projectPath.
                Wave::app()->projectName.'/views/'.
                $filename.'.php';
    }

    /**
     * 验证码
     *
     * @param string $key       验证码key
     * @param int $num          验证码个数
     * @param int $width        验证码宽度
     * @param int $height       验证码高度
     * @param int $expire       过期时间
     * 
     * @return string
     *
     */
    public function verifyCode($key = 'verifycode', $num = 4, $width = 130, $height = 40, $expire = 600)
    {
        require Wave::app()->frameworkPath.'Library/Captcha/VerifyCode.class.php';
        $VerifyCode = new VerifyCode();
        $VerifyCode->codelen = $num;
        $VerifyCode->width = $width;
        $VerifyCode->height = $height;
        $VerifyCode->doimg();
        Wave::app()->session->setState($key, $VerifyCode->getCode(), $expire);
    }

    /**
     * URL跳转
     * 
     * @param string $url       跳转URL
     *
     */
    public function redirect($url)
    {
        header('Location:'.$url);die;
    }

    /**
     * 弹窗 跳转
     *
     * @param string $msg       弹窗内容
     * @param string $url       跳转URL
     * @param int $time         跳转时间，默认3秒
     *
     */
    public function jumpBox($msg, $url, $time = 3)
    {
        $str = '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" 
                content="text/html; charset=utf-8" />
                <title>信息弹窗</title>
                <style type="text/css">
                *,body{ padding: 0; margin: 0;}
                .box{ margin: 0 auto; padding: 30px; 
                    border-radius:3px; border: 5px solid #000; 
                    width: 400px; margin-top: 15%;}
                </style>
                <script type="text/javascript">
                var jump = function(){
                    window.location.href="'.$url.'";
                }
                setTimeout(jump, '.($time*1000).');
                </script>
                </head>
                <body>
                <div class="box">
                    '.$msg.'
                </div>
                </body>
                </html>';
        exit($str);
    }

    /**
     * 跳转页面
     *
     * @param string $msg       弹窗内容
     * @param string $url       跳转URL
     * @param bool $state       状态
     * @param int $time         跳转时间，默认3秒
     * @param string $tpl       模板，默认report
     *
     */
    public function report($msg, $url, $state = true, 
                        $time = 3, $tpl = 'layout/report')
    {
        $this->assign('msg', $msg);
        $this->assign('url', $url);
        $this->assign('state', $state);
        $this->assign('time', $time);
        $this->display($tpl);
        exit;
    }

    /**
     * 加载调试信息
     */
    public function debuger() 
    {
        $config = Wave::app()->config;
        if ($this->isSmarty) {
            $this->debuger = $config['debuger'];
            if ($config['debuger']) {
                if(!isset($_SESSION)) {
                    @session_start(); 
                }
                Wave::$_debug['session'] = $_SESSION;
                Wave::$_debug['files'] = get_included_files();
                $this->debug = Wave::$_debug;
                $this->escapetime = microtime(TRUE) - START_TIME;
                $this->memuse = (memory_get_usage() - MEMORY_USAGE_START) / 1024;
            }
        }else{
            if ($config['debuger']) {
                if(!isset($_SESSION)) {
                    session_start(); 
                }
                Wave::$_debug['session'] = $_SESSION;
                Wave::$_debug['files'] = get_included_files();
                $render = array('debug' => Wave::$_debug);
                $this->render('layout/debuger', $render);
            }
        }
    }

    /**
     * 获得表单信息
     */
    public function getRequest()
    {
        return Request::getInstance();
    }

}


?>