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
 * Wavephp Application Route Class
 *
 * route类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class Route
{
    private $projectPath        = '';   //项目路径
    private $projectName        = '';   //项目名称
    private $defaultControl     = '';   //默认控制层

    private $Core = '';                 //核心类

    /**
     * 初始化
     */
    function __construct($app, $Core)
    {
        $this->projectPath      = $app->projectPath;
        $this->projectName      = $app->projectName;
        $this->pathInfo         = $app->request->pathInfo;
        $this->defaultControl   = $app->defaultControl;

        $this->Core = $Core;
    }

    /**
     * 过滤危险字符
     *
     * @return String
     *
     */
    private function filterStr($str)
    {
        $preg = '/(\~)|(\!)|(\@)|(\#)|(\$)|(\%)|(\^)|(\&)|(\*)|(\()|(\))|(\-)|(\+)|(\[)|(\])|(\')|(\")|(\<)|(\>)|(\?)|(\.)|(\|)/';
        return preg_replace($preg, '', $str);
    }

    /**
     * route 处理
     *
     * 例如 index.php/site/index 会使用SiteController.php这个文件，调用actionIndex这个方法
     * 例如 index.php/site/index/a/b 会使用SiteController.php这个文件，调用actionIndex($a, $b)这个方法
     *
     * 默认使用SiteController.php这个文件，调用actionIndex这个方法
     *
     */
    public function route()
    {
        $callarray = array();
        $rpathInfo = $this->pathInfo;
        if(!empty($rpathInfo) && $rpathInfo !== '/'){
            $pos = strpos($rpathInfo, '?');
            if( $pos !== false){
                 $rpathInfo = substr($rpathInfo, 0, $pos);
            }
            $rpathInfo = trim($rpathInfo, '/');
            $rpathInfo = $this->filterStr($rpathInfo);
            $pathInfoArr = explode('/', $rpathInfo);
            $c = ucfirst($pathInfoArr[0]).'Controller';
            $f = !empty($pathInfoArr[1]) ? 'action'.ucfirst($pathInfoArr[1]) : 'actionIndex';
            if(count($pathInfoArr) > 2){
                array_shift($pathInfoArr);
                array_shift($pathInfoArr);
                $callarray = $pathInfoArr;
            }
        }else{
            $c = ucfirst($this->defaultControl).'Controller';
            $f = 'actionIndex';
        }
        $controller = $this->projectPath.$this->projectName.'/controllers/'.$c.'.php';
        if(file_exists($controller)){
            $this->Core->requireProjectFile($this->projectName.'/controllers/'.$c);
            if(class_exists($c)){
                $cc = new $c;
                if(method_exists($cc, $f)){
                    if(!empty($callarray)){
                        call_user_func_array(array($cc,$f), $callarray);
                    }else{
                        $cc->$f();
                    }
                }else{
                   $this->error404(); 
                }
            }else{
                $this->error404(); 
            }
        }else{
            $this->error404();
        }
    }

    /**
     * url错误返回404
     */
    public function error404()
    {
        echo '<h2>Error 404</h2>';
        echo 'Unable to resolve the request "'.$this->pathInfo.'".';
    }

}

?>
