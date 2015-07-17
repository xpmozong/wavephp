<?php
/**
 * 文章分类控制层
 */
class CategoriesController extends Controller
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
     * 分类页
     */
    public function actionIndex()
    {
        $Common = new Common();
        $list = $Common->getFieldList('category', '*');
        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('categories/index', $render);
        $this->render('layout/footer');
        
    }

    /**
     * 添加、修改分类
     */
    public function actionModify($cid)
    {
        $cid = (int)$cid;
        $Common = new Common();
        $data = $Common->getOneData('category', '*', 'cid', $cid);
        $render = array('data' => $data);
        $this->render('layout/header');
        $this->render('categories/modify', $render);
        $this->render('layout/footer');
        
    }

    /**
     * 添加、修改分类结果
     */
    public function actionModified()
    {
        $Common = new Common();
        $data = $Common->getFilter($_POST);
        $cid = (int)$data['cid'];
        unset($data['cid']);
        if ($cid == 0) {
            $Common->getInsert('category', $data);
        }else{
            $Common->getUpdate('category', $data, 'cid', $cid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'categories', 1);
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;

        $Common = new Common();
        $Common->getDelete('category', 'cid', $id);

        $Common->exportResult(true, '成功！');
    }

}

?>