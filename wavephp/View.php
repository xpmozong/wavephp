<?php

class View 
{
    private $app            = '';       //项目信息
    private $frameworkPath  = '';       //框架路径
    private $projectPath    = '';       //项目路径
    private $projectName    = '';       //项目名称

    public $engin;
    private $scriptPackage;

    /**
     * 初始化smarty模板引擎
     */
    public function __construct(){
        $this->app              = Wave::app();
        $this->frameworkPath    = $this->app->frameworkPath;
        $this->projectPath      = $this->app->projectPath;
        $this->projectName      = $this->app->projectName;
        require $this->frameworkPath.'Library/Smarty/Smarty.class.php';
        $dir = $this->projectPath.$this->projectName;

        $smarty = new Smarty();
        $smarty->left_delimiter     = '{%';
        $smarty->right_delimiter    = '%}';
        $smarty->debugging          = false;
        $smarty->caching            = false;
        $smarty->cache_lifetime     = 120;
        $smarty->compile_check      = true;
        $smarty->template_dir       = $dir.'/templates';
        $smarty->cache_dir          = $dir.'/templates/cache';
        $smarty->config_dir         = $dir.'/templates/config';
        $smarty->compile_dir        = $dir.'/templates_c';

        if (!is_dir($smarty->template_dir)) {
            mkdir($smarty->template_dir);
            if (!is_dir($smarty->cache_dir)) {
                mkdir($smarty->cache_dir);
            }
            if (!is_dir($smarty->config_dir)) {
                mkdir($smarty->config_dir);
            }
        }
        if (!is_dir($smarty->compile_dir)) {
            mkdir($smarty->compile_dir);
        }

        $this->engin = $smarty;
    }

    /**
     * 设置模板引擎参数
     * @param array options
     * @return View
     */
    public function setOptions(array $options){
        foreach($options as $param => $value){
            $this->engin->$param = $value;
        }
    }

    public function setDefaultScriptPackage($package)
    {
        $this->scriptPackage = $package;

        return $this;
    }

    /**
     * 获取默认的模板文件名
     * @return string
     *
     */
    private function getDefaultScript(){
        $classname = strtolower(str_replace('Controller', '', 
                    Wave::getClassName()));
        $actionname = strtolower(str_replace('action', '', 
                    Wave::getActionName()));

        return $classname.'/'.$actionname;
    }

    public function display($resource_name = '', 
                            $cache_id = null, 
                            $compile_id = null){
        echo $this->fetch($resource_name, $cache_id, $compile_id, true);
    }

    public function fetch($resource_name,
                        $cache_id = null, 
                        $compile_id = null, 
                        $display = false)
    {
        if($resource_name == ''){
            $resource_name = $this->getDefaultScript();
        }
        $resource_name = str_replace('.html', '', $resource_name).'.html';
        $fileName = $this->engin->template_dir.'/'.$resource_name;
        if (!file_exists($fileName)) {
            echo 'no have file '.$fileName;die;
        }
        return $this->engin->fetch($resource_name, 
                                    $cache_id, 
                                    $compile_id, 
                                    $display);
    }

    public function assign($name, $val = null){
        if(empty($name)){
            return false;
        }
        $this->engin->assign($name, $val);

        return $this;
    }

    public function __set($name, $val){
        $this->$name = $val;
    }

    public function __get($name){
        return $this->$name;
    }
}

?>