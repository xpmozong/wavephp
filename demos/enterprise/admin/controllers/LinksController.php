<?php
/**
 * 友情链接控制层
 */
class LinksController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '友情链接';
    }

    /**
     * 友情链接页
     */
    public function actionIndex()
    {
        $this->list = $this->Common->getFieldList('links', '*');   
    }

    /**
     * 添加、修改链接
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $this->data = $this->Common->getOneData('links', '*', 'lid', $id);
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = $this->Common->getFilter($_POST);
        $id = (int)$data['lid'];
        unset($data['lid']);
        if ($id == 0) {
            $this->Common->getInsert('links', $data);
        }else{
            $this->Common->getUpdate('links', $data, 'lid', $id);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'links', 1);
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;
        
        $this->Common->getDelete('links', 'lid', $id);

        $this->Common->exportResult(true, '成功！');
    }

}

?>