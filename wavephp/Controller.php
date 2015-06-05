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
    private $app            = '';       //项目信息
    private $frameworkPath  = '';       //框架路径
    private $projectPath    = '';       //项目路径
    private $projectName    = '';       //项目名称
    public  $layout         = 'main';   //视图层    

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->app              = Wave::app();
        $this->frameworkPath    = $this->app->frameworkPath;
        $this->projectPath      = $this->app->projectPath;
        $this->projectName      = $this->app->projectName;
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
        $classname = get_class($this);
        $folder = strtolower(str_replace('Controller', '', $classname));
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        //数组变量转换
        extract($variables, EXTR_SKIP);
        ob_start();
        require $this->projectPath.$this->projectName.'/views/'.$folder.'/'.$filename.'.php';
        $content = ob_get_contents();
        ob_end_clean();
        require $this->projectPath.$this->projectName.'/views/layout/'.$this->layout.'.php';
    }

    /**
     * 验证码
     *
     * @param int $num          验证码个数
     * @param int $width        验证码宽度
     * @param int $height       验证码高度
     * 
     * @return string
     *
     */
    public function verifyCode($num = 4, $width = 130, $height = 50)
    {
        require $this->frameworkPath.'Library/VerifyCode.class.php';
        $VerifyCode = new VerifyCode($this->frameworkPath);
        $VerifyCode->codelen = $num;
        $VerifyCode->width = $width;
        $VerifyCode->height = $height;
        $VerifyCode->doimg();
        $this->app->user->setState('verifycode', $VerifyCode->getCode(), 300);
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
     * @param int $jumpTime     跳转时间，默认3秒
     *
     */
    public function jumpBox($msg, $url, $jumpTime = 3)
    {
        $str = '<html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                setTimeout(jump, '.($jumpTime*1000).');
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

}


?>