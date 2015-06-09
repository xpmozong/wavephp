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
        
        $array = $Common->getOneData('users', '*', 'user_login', $data['user_login']);
        if(!empty($array)){
            if ($array['user_pass'] == md5($data['user_pass'])) {
                Wave::app()->session->setState('userid', $array['userid']);
                Wave::app()->session->setState('username', $array['user_login']);
                $Common->exportResult(true, '登录成功！');
            }else{
                $Common->exportResult(false, '用户名或密码错误！');
            }
        }else{
            $Common->exportResult(false, '用户名或密码错误！');
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
        $list[0]['title'] = '后台管理';
        $list[0]['list'][] = array('permission_name'=>'文章列表', 
                                    'permission_url'=>'articles');
        $list[0]['list'][] = array('permission_name'=>'分类列表', 
                                    'permission_url'=>'categories');
        $list[0]['list'][] = array('permission_name'=>'内容列表', 
                                    'permission_url'=>'substance');
        $list[0]['list'][] = array('permission_name'=>'友情链接', 
                                    'permission_url'=>'links');

        $list[1]['title'] = '微信公众号';
        $list[1]['list'][] = array('permission_name'=>'公众账号管理', 
                                    'permission_url'=>'wx');
        $list[1]['list'][] = array('permission_name'=>'粉丝列表', 
                                    'permission_url'=>'links');
        $list[1]['list'][] = array('permission_name'=>'消息群发', 
                                    'permission_url'=>'links');
        $list[1]['list'][] = array('permission_name'=>'自定义菜单', 
                                    'permission_url'=>'links');
        $list[1]['list'][] = array('permission_name'=>'自动回复', 
                                    'permission_url'=>'links');

        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('site/lefttree', $render);
        $this->render('layout/footer');
    }

}

?>