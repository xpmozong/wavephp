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
        echo 'Hello world !';
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

        // // $this->layout='index';
        // $this->render('index', array('username'=>$username));

        // $tmp_object = new stdClass;
        // $tmp_object->str_attr = 'test';
        // $tmp_object->int_attr = 123;
        // Wave::app()->memcache->cache1->set('key', $tmp_object, false, 30) or die ("Failed to save data at the server");
        // echo "Store data in the cache (data will expire in 30 seconds)<br/>\n";
        // $get_result = Wave::app()->memcache->cache1->get('key');
        // echo "Data from the cache:<br/>\n";
        // echo "<pre>";
        // print_r($get_result);

        // echo "<pre>";
        // print_r(get_included_files());

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
        Wave::app()->user->setState('username', 'Ellen Xu');
    }

    public function actionLogout()
    {
        Wave::app()->user->logout();
    }

    public function actionExportCode()
    {
        echo Wave::app()->user->getState('verifycode');
    }

}

?>