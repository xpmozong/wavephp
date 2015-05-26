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
        $sql = "SELECT a.aid,a.title,a.add_date,c.c_name FROM articles a 
                LEFT JOIN category c
                ON a.cid=c.cid
                ORDER BY a.aid DESC 
                LIMIT 0,12";
        $list = $Common->getSqlList($sql);
        $render = array('list' => $list);

        $this->render('index', $render);
    }

    /**
     * 友情链接
     */
    public function actionLinks()
    {
        $Common = new Common();
        $sql = "SELECT * FROM links";
        $list = $Common->getSqlList($sql);
        echo json_encode($list);
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