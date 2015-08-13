<?php
/**
 * 文章列表控制层
 */
class ArticlesController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '文章管理';
    }
    /**
     * 文章页
     */
    public function actionIndex()
    {
        $data = $this->Common->getFilter($_GET);
        $this->page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $this->cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 1;
        $pagesize = 15;
        $start = ($this->page - 1) * $pagesize;

        $where = array('cid'=>$this->cid);
        $this->list = $this->Common->getFieldDataList('articles', 'aid,title', $where, null,
                    $start, $pagesize, 'aid');
        $count = $this->Common->getFieldCount('articles', 'cid', $this->cid);

        $this->category = $this->Common->getFieldList('category', '*');

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['cid'])){
            $url .= '?cid=1';
        }
        if(empty($data['page'])){
            $url .= '&page=1';
        }
        $this->pagebar = $this->Common->getPageBar($url, $count, $pagesize, $this->page);
    }

    /**
     * 添加、修改文章
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $this->data = $this->Common->getOneData('articles', '*', 'aid', $id);
        $this->category = $this->Common->getFieldList('category', '*');
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = $this->Common->getFilter($_POST);
        $aid = (int)$data['aid'];
        unset($data['aid']);
        if ($aid == 0) {
            $data['add_date'] = $this->Common->getDate();
            $this->Common->getInsert('articles', $data);
        }else{
            $this->Common->getUpdate('articles', $data, 'aid', $aid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'articles', 1);
    }

    /**
     * 上传图片
     */
    public function actionUpload()
    {
        $fn = $_GET['CKEditorFuncNum'];
        $url = $this->Common->getCompleteUrl();
        $imgTypeArr = $this->Common->getImageTypes();
        if(!in_array($_FILES['upload']['type'], $imgTypeArr)){
            echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$fn.'","","图片格式错误！");
                </script>';
        }else{
            $projectPath = Wave::app()->projectPath;
            $uploadPath = $projectPath.'uploadfile/articles';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = $this->Common->getYearMonth();
            $uploadPath .= '/'.$ym;
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);

            $imgType = strtolower(substr(strrchr($_FILES['upload']['name'],'.'),1));
            $imageName = time().'_'.rand().'.'.$imgType;

            $file_abso = $url.'/uploadfile/articles/'.$ym.'/'.$imageName;
            $SimpleImage = new SimpleImage();
            $SimpleImage->load($_FILES['upload']['tmp_name']);
            $SimpleImage->resizeToWidth(800);
            $SimpleImage->save($uploadPath.'/'.$imageName);

            echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$fn.'","'.$file_abso.'","上传成功");
                </script>';
        }
    }

    /**
     * 删除
     */
    public function actionDelete($id)
    {
        $id = (int)$id;
        $this->Common->getDelete('articles', 'aid', $id);
        $this->Common->exportResult(true, '成功！');
    }
}

?>