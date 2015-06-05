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
        $Common = new Common();
        $list = $Common->getJoinDataList('articles a', 
        'a.aid,a.title,a.add_date,c.c_name', 0, 12, 'category c', 'a.cid=c.cid', 
        null, 'a.aid DESC');
        $render = array('list' => $list);

        $links = $Common->getFieldList('links', '*', 'lid desc');
        $this->render('layout/header');
        $this->render('site/index', $render);
        $this->render('layout/footer', array('links'=>$links));
    }

    public function actionTestDb()
    {
        $TestModel = new TestModel();
        $list = $TestModel->getList();
        echo "<pre>";
        print_r($list);die;
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
        // Wave::app()->session->setState('username', 'Ellen Xu');
        echo Wave::app()->session->getState('username');
    }

    public function actionLogout()
    {
        Wave::app()->session->logout();
    }

}

?>