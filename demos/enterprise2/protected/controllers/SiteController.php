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
        $this->list = $this->Common->getJoinDataList('articles a', 
        'a.aid,a.title,a.add_date,c.c_name', 0, 12, 
        'category c', 'a.cid=c.cid', null, 'a.aid DESC');
    }

    public function actionTestLang()
    {
        i18n::$lang = 'vi-vn';
        echo i18n::get('平台管理')."<br>";
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
        if(Wave::app()->session->getState('userid')){
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
        
        $array = $this->Common->getOneData('users', '*', 
                                'user_login', $data['user_login']);
        if(!empty($array)){
            if ($array['user_pass'] == md5($data['user_pass'])) {
                Wave::app()->session->setState('userid', $array['userid']);
                Wave::app()->session->setState('username', $array['user_login']);
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
        $data = $this->Common->getFilter($_POST);
        if(empty($data['user_login']))
            $this->Common->exportResult(false, '请输入用户名！');

        if(empty($data['user_pass']))
            $this->Common->exportResult(false, '请输入密码！');
        
        $data['user_pass'] = md5($data['user_pass']);
        if ($this->Common->getInsert('users', $data)) {
            $this->Common->exportResult(true, '注册成功！');
        }else{
            $this->Common->exportResult(false, '注册失败！');
        }
    }

    public function actionLogout()
    {
        Wave::app()->session->logout();
        $this->jumpBox('退出成功！', Wave::app()->homeUrl.'site', 1);
    }


    public function actionUserinfo()
    {
        $array = array();
        if (Wave::app()->session->getState('userid')) {
            $array['success'] = true;
            $array['userid'] = Wave::app()->session->getState('userid');
            $array['username'] = Wave::app()->session->getState('username');
        }else{
            $array['success'] = false;
        }
        
        echo json_encode($array);die;
    }
}

?>