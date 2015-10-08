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
     * 默认函数
     */
    public function actionIndex()
    {
        i18n::$lang = 'vi-vn';
        echo i18n::get('平台管理')."<br>";

        // echo 'Hello world !';
        // $arr = Wave::app()->database->db->getOne("select user_login from wp_users");
        // print_r($arr);

        // echo "<br>";

        // $arr2 = Wave::app()->database->db2->getOne("select username from joke_user");
        // print_r($arr2);

        // echo "<br>";

        // echo Wave::app()->projectPath."<br>";

        // echo Wave::app()->request->hostInfo."<br>";

        // echo Wave::app()->request->pathInfo."<br>";

        // echo Wave::app()->homeUrl."<br>";

        // echo Wave::app()->request->baseUrl."<br>";

        // // spl_autoload_unregister(array('WaveBase','loader'));
        // // spl_autoload_register(array('WaveBase','loader'));

        // $User = new User();

        // echo "User model 加载成功！<br>";

        // $username = Wave::app()->user->getState('username');

        // $this->render('layout/header');
        // $this->render('site/index', array('username'=>$username));
        // $this->footer();
        // 也可以选择使用smarty模板

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
        $data = array('username'=>'Ellen Xu');
        Wave::app()->session->setState('userinfo', $data);
    }

    public function actionLogout()
    {
        Wave::app()->session->logout('userinfo');
    }

    public function actionExportCode()
    {
        echo Wave::app()->session->getState('verifycode');
    }

}

?>