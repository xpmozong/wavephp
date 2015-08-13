<?php
/**
 * 文章分类控制层
 */
class CategoriesController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '分类管理';
    }

    /**
     * 分类页
     */
    public function actionIndex()
    {
        $this->list = $this->Common->getFieldList('category', '*');   
    }

    /**
     * 添加、修改分类
     */
    public function actionModify($cid)
    {
        $cid = (int)$cid;
        $this->data = $this->Common->getOneData('category', '*', 'cid', $cid);
    }

    /**
     * 添加、修改分类结果
     */
    public function actionModified()
    {
        $data = $this->Common->getFilter($_POST);
        $cid = (int)$data['cid'];
        unset($data['cid']);
        if ($cid == 0) {
            $this->Common->getInsert('category', $data);
        }else{
            $this->Common->getUpdate('category', $data, 'cid', $cid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'categories', 1);
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;
        $this->Common->getDelete('category', 'cid', $id);
        $this->Common->exportResult(true, '成功！');
    }

}

?>