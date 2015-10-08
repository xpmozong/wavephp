<?php
/**
 * 网站默认入口控制层
 */
class SiteController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 默认函数
     */
    public function actionIndex()
    {
        $Articles = new Articles();
        $this->list = $Articles ->select('a.aid,a.title,a.add_date,c.c_name')
                                ->from('articles a')
                                ->join('category c', 'a.cid=c.cid')
                                ->limit(0, 12)
                                ->order('a.aid', 'desc')
                                ->getAll();
    }

    public function actionTestLang()
    {
        i18n::$lang = 'vi-vn';
        echo i18n::get('平台管理')."<br>";
    }

    public function actionTestReport()
    {
        $this->report('测试弹窗', Wave::app()->homeUrl.'site/testlang', true);
    }

    /**
     * 验证码
     */
    public function actionVerifyCode()
    {
        echo $this->verifyCode(4);
    }
    
    public function actionLogin()
    {
        $userinfo = Wave::app()->session->getState('userinfo');
        if(!empty($userinfo)){
            $this->redirect(Wave::app()->homeUrl);
        }else{
            
        }
    }

    public function actionLoging()
    {
        $data = $this->Common->getFilter($_POST);
        if(empty($data['user_login']))
            $this->Common->exportResult(false, '请输入用户名！');

        if(empty($data['user_pass']))
            $this->Common->exportResult(false, '请输入密码！');
        
        $Users = new Users();
        $array = $Users->getOne('*', array('user_login'=>$data['user_login']));
        if(!empty($array)){
            if ($array['user_pass'] == md5($data['user_pass'])) {
                Wave::app()->session->setState('userinfo', $array);
                $this->Common->exportResult(true, '登录成功！');
            }else{
                $this->Common->exportResult(false, '用户名或密码错误！');
            }
        }else{
            $this->Common->exportResult(false, '用户名或密码错误！');
        }
    }

    public function actionRegist()
    {
        
    }

    public function actionRegisting()
    {
        $Users = new Users();
        $data = $this->Common->getFilter($_POST);
        if(empty($data['user_login']))
            $this->Common->exportResult(false, '请输入用户名！');

        if(empty($data['user_pass']))
            $this->Common->exportResult(false, '请输入密码！');
        
        $data['user_pass'] = md5($data['user_pass']);
        if ($Users->insert($data)) {
            $this->Common->exportResult(true, '注册成功！');
        }else{
            $this->Common->exportResult(false, '注册失败！');
        }
    }

    public function actionLogout()
    {
        Wave::app()->session->logout('userinfo');
        $this->jumpBox('退出成功！', Wave::app()->homeUrl.'site', 1);
    }


    public function actionUserinfo()
    {
        $array = array();
        $userinfo = Wave::app()->session->getState('userinfo');
        if (!empty($userinfo)) {
            $array['success'] = true;
            $array['userid'] = $userinfo['userid'];
            $array['username'] = $userinfo['user_login'];
        }else{
            $array['success'] = false;
        }
        
        echo json_encode($array);die;
    }
}

?>