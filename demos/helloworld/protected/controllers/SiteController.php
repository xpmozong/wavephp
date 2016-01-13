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
        // 多语言使用，要连数据库，表为w_language，参看enterprise数据库
        // 按规定填入数据
        // 使用方式
        // I18n::$lang = 'vi-vn';
        // echo I18n::get('平台管理');
        // smarty模板使用方式
        // {%I18n var=平台管理%}

        // // 项目路径
        // echo Wave::app()->projectPath;
        // //当前域名
        // echo Wave::app()->request->hostInfo;
        // //除域名外以及index.php
        // echo Wave::app()->request->pathInfo;
        // //除域名外的地址
        // echo Wave::app()->homeUrl;
        // //除域名外的根目录地址
        // echo Wave::app()->request->baseUrl;

        // 关闭自动加载
        // spl_autoload_unregister(array('WaveLoader','loader'));
        // 开启自动加载
        // spl_autoload_register(array('WaveLoader','loader'));

        // $User = new User();
        // echo "User model 加载成功！";
        // $TestModel = new TestModel();
        // $list = $TestModel->getList();
        // echo "<pre>";
        // print_r($list);die;

        // $this->username = 'Ellen';
        // 然后查看 templates/site/index.html 文件
        // 输出 {%$username%}

        // mecache使用
        // Wave::app()->memcache->set('key', '11111', 30);
        // echo "Store data in the cache (data will expire in 30 seconds)";
        // $get_result = Wave::app()->memcache->get('key');
        // echo " Memcache Data from the cache:$get_result";

        // redis使用
        // Wave::app()->redis->set('key', '11111', 30);
        // echo "Store data in the cache (data will expire in 30 seconds)";
        // $get_result = Wave::app()->redis->get('key');
        // echo " Redis Data from the cache:$get_result";

    }

    /**
     * 验证码
     */
    public function actionVerifyCode()
    {
        echo $this->verifyCode('login_code');die;
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
        echo Wave::app()->session->getState('login_code');die;
    }

}

?>