<?php
/**
 * 内容列表控制层
 */
class SubstanceController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '内容管理';
    }

    /**
     * 内容页
     */
    public function actionIndex()
    {
        $data = $this->Common->getFilter($_GET);
        $this->page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($this->page - 1) * $pagesize;

        $this->list = $this->Common->getFieldDataList('substance', '*', null, null, 
                    $start, $pagesize, 'sid');
        $count = $this->Common->getFieldWhereCount('substance');

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $this->pagebar = $this->Common->getPageBar($url, $count, $pagesize, $this->page);
    }

    /**
     * 添加、修改内容
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $this->data = $this->Common->getOneData('substance', '*', 'sid', $id);
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $this->Common = new Common();
        $data = $this->Common->getFilter($_POST);
        $sid = (int)$data['sid'];
        unset($data['sid']);
        if ($sid == 0) {
            $this->Common->getInsert('substance', $data);
        }else{
            $this->Common->getUpdate('substance', $data, 'sid', $sid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'substance', 1);
    }

    /**
     * 上传图片
     */
    public function actionUpload()
    {
        $this->Common = new Common();
        $fn = $_GET['CKEditorFuncNum'];
        $url = $this->Common->getCompleteUrl();
        $imgTypeArr = $this->Common->getImageTypes();
        if(!in_array($_FILES['upload']['type'], $imgTypeArr)){
            echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$fn.'","","图片格式错误！");
                </script>';
        }else{
            $projectPath = Wave::app()->projectPath;
            $uploadPath = $projectPath.'uploadfile/substance';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = $this->Common->getYearMonth();
            $uploadPath .= '/'.$ym;
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);

            $imgType = strtolower(substr(strrchr($_FILES['upload']['name'],'.'),1));
            $imageName = time().'_'.rand().'.'.$imgType;

            $file_abso = $url.'/uploadfile/substance/'.$ym.'/'.$imageName;
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

        $this->Common = new Common();
        $this->Common->getDelete('substance', 'sid', $id);

        $this->Common->exportResult(true, '成功！');
    }
}

?>