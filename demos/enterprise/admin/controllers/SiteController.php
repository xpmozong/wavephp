<?php
/**
 * 网站默认入口控制层
 */
class SiteController extends Controller
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 后台首页
     */
    public function actionIndex()
    {
        if(Wave::app()->session->getState('userid')){
            $this->render('site/index');
        }else{
            $this->redirect(Wave::app()->homeUrl.'site/login');
        }
    }
    
    /**
     * 登录界面
     */
    public function actionLogin()
    {
        if(Wave::app()->session->getState('userid')){
            $this->redirect(Wave::app()->homeUrl);
        }else{
            $this->render('layout/header');
            $this->render('site/login');
            $this->render('layout/footer');
        }
    }

    /**
     * 登录
     */
    public function actionLoging()
    {
        $Common = new Common();
        $data = $Common->getFilter($_POST);
        if(empty($data['user_login']))
            $Common->exportResult(false, '请输入用户名！');

        if(empty($data['user_pass']))
            $Common->exportResult(false, '请输入密码！');
        
        if($data['user_login'] != 'xuping'){
            $Common->exportResult(false, '用户名不存在！');
        }elseif($data['user_pass'] === '123456'){
            Wave::app()->session->setState('userid', 1);
            Wave::app()->session->setState('username', $data['user_login']);
            $Common->exportResult(true, '登录成功！');
        }else{
            $Common->exportResult(false, '密码错误！');
        }
    }

    /**
     * 退出
     */
    public function actionLogout()
    {
        Wave::app()->session->logout();
        $this->redirect(Wave::app()->homeUrl);
    }

    /**
     * 头部
     */
    public function actionHeader()
    {
        $this->render('layout/header');
        $this->render('site/header');
        $this->render('layout/footer');
    }

    /**
     * 右侧
     */
    public function actionRight()
    {
        $Common = new Common();
        $render = array('username' => Wave::app()->session->getState('username'));
        $this->render('layout/header');
        $this->render('site/right', $render);
        $this->render('layout/footer');
    }

    /**
     * 返回目录
     */
    public function actionLeftTree()
    {
        $Common = new Common();
        $list = array();
        $list[][] = array('permission_name'=>'文章列表', 'permission_url'=>'articles');
        $list[][] = array('permission_name'=>'分类列表', 'permission_url'=>'categories');
        $list[][] = array('permission_name'=>'内容列表', 'permission_url'=>'substance');
        $list[][] = array('permission_name'=>'友情链接', 'permission_url'=>'links');
        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('site/lefttree', $render);
        $this->render('layout/footer');
    }

}

?>