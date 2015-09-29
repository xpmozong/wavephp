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
        $Category = new Category();
        $this->list = $Category->getAll();
    }

    /**
     * 添加、修改分类
     */
    public function actionModify($cid)
    {
        $cid = (int)$cid;
        $Category = new Category();
        $this->data = $Category->getOne('*', array('cid'=>$cid));
    }

    /**
     * 添加、修改分类结果
     */
    public function actionModified()
    {
        $Category = new Category();
        $data = $this->Common->getFilter($_POST);
        $cid = (int)$data['cid'];
        unset($data['cid']);
        if ($cid == 0) {
            $Category->insert($data);
        }else{
            $Category->update($data, array('cid'=>$cid));
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'categories', 1);
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;
        $Category = new Category();
        $Category->delete(array('cid'=>$id));
        $this->Common->exportResult(true, '成功！');
    }

}

?>