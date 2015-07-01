<?php
/**
 * 友情链接控制层
 */
class LinksController extends Controller
{
    public $userid;
    public $username;
       
    public function __construct()
    {
        parent::__construct();
        if(Wave::app()->session->getState('userid')) {
            $this->userid = Wave::app()->session->getState('userid');
            $this->username = Wave::app()->session->getState('username');
        }else{
            $this->redirect(Wave::app()->homeUrl);
        }
    }

    /**
     * 友情链接页
     */
    public function actionIndex()
    {
        $Common = new Common();
        $list = $Common->getFieldList('links', '*');
        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('links/index', $render);
        $this->render('layout/footer');
        $this->debuger();
    }

    /**
     * 添加、修改链接
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $Common = new Common();
        $data = $Common->getOneData('links', '*', 'lid', $id);
        
        $render = array('links' => $data);
        $this->render('layout/header');
        $this->render('links/modify', $render);
        $this->render('layout/footer');
        $this->debuger();
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $Common = new Common();
        $data = $Common->getFilter($_POST);
        $id = (int)$data['lid'];
        unset($data['lid']);
        if ($id == 0) {
            $Common->getInsert('links', $data);
        }else{
            $Common->getUpdate('links', $data, 'lid', $id);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'links', 1);
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;

        $Common = new Common();
        $Common->getDelete('links', 'lid', $id);

        $Common->exportResult(true, '成功！');
    }

}

?>