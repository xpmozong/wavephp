<?php
/**
 * 网站默认入口控制层
 */
class SiteController extends Controller
{
       
    public function __construct()
    {
        parent::__construct();
        $this->title = '后台管理';
    }

    /**
     * 后台首页
     */
    public function actionIndex()
    {
        $userinfo = Wave::app()->session->getState('userinfo');
        // echo "<pre>";
        // print_r($userinfo);die;
        if(empty($userinfo)){
            $this->redirect(Wave::app()->homeUrl.'site/login');
        }else{
            
        }
    }
    
    /**
     * 登录界面
     */
    public function actionLogin()
    {
        $userinfo = Wave::app()->session->getState('userinfo');
        if(!empty($userinfo)){
            $this->redirect(Wave::app()->homeUrl);
        }
    }

    /**
     * 登录
     */
    public function actionLoging()
    {
        $data = WaveCommon::getFilter($_POST);
        $Users = new Users();
        $array = $Users->getOne('*', array('email'=>$data['user_login']));
        $Log = new Log();
        if(!empty($array)){
            if ($array['password'] == md5($data['user_pass'])) {
                Wave::app()->session->setState('userinfo', $array);
                $Log->saveLogs('用户登录', 1, $data);
                $this->jumpBox('登录成功！', Wave::app()->homeUrl, 1);
            }else{
                $Log->saveLogs('用户登录', 0, $data);
                $this->jumpBox('用户名或密码错误！', Wave::app()->homeUrl, 1);
            }
        }else{
            $Log->saveLogs('用户登录', 0, $data);
            $this->jumpBox('没有该用户！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 退出
     */
    public function actionLogout()
    {
        Wave::app()->session->logout('userinfo');
        $this->redirect(Wave::app()->homeUrl);
    }

    /**
     * 头部
     */
    public function actionHeader()
    {
    }

    /**
     * 右侧
     */
    public function actionRight()
    {
        $Common = new Common();
        $userinfo = Wave::app()->session->getState('userinfo');
        $this->username = $userinfo['username'];
    }

    /**
     * 返回目录
     */
    public function actionLeftTree()
    {
        $Common = new Common();
        $this->list = array();
        $this->list[0]['title'] = '后台管理';
        $this->list[0]['list'][] = array('permission_name'=>'用户列表', 
                                    'permission_url'=>'users');
        $this->list[0]['list'][] = array('permission_name'=>'文章列表', 
                                    'permission_url'=>'articles');
        $this->list[0]['list'][] = array('permission_name'=>'分类列表', 
                                    'permission_url'=>'categories');
        $this->list[0]['list'][] = array('permission_name'=>'友情链接', 
                                    'permission_url'=>'links');

        $this->list[1]['title'] = '微信公众号';
        $this->list[1]['list'][] = array('permission_name'=>'公众账号管理', 
                                    'permission_url'=>'wx');
        $this->list[1]['list'][] = array('permission_name'=>'粉丝列表', 
                                    'permission_url'=>'links');
        $this->list[1]['list'][] = array('permission_name'=>'消息群发', 
                                    'permission_url'=>'links');
        $this->list[1]['list'][] = array('permission_name'=>'自定义菜单', 
                                    'permission_url'=>'wxmenu');
        $this->list[1]['list'][] = array('permission_name'=>'自动回复', 
                                    'permission_url'=>'links');
        
        $this->list[3]['title'] = '操作日志';
        $this->list[3]['list'][] = array('permission_name'=>'日志列表', 
                                    'permission_url'=>'logs');
    }

}

?>