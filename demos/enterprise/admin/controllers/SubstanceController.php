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
        $data = WaveCommon::getFilter($_GET);
        $this->page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($this->page - 1) * $pagesize;
        $Substance = new Substance();
        $this->list = $Substance->limit($start, $pagesize)->order('sid', 'desc')->getAll();
        $count = $Substance->getCount('*');
        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $this->pagebar = WaveCommon::getPageBar($url, $count, $pagesize, $this->page);
    }

    /**
     * 添加、修改内容
     */
    public function actionModify($id)
    {
        $Substance = new Substance();
        $id = (int)$id;
        $this->data = $Substance->getOne('*', array('sid'=>$id));
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $Substance = new Substance();
        $data = WaveCommon::getFilter($_POST);
        $sid = (int)$data['sid'];
        unset($data['sid']);
        if ($sid == 0) {
            $Substance->insert($data);
        }else{
            $Substance->update($data, array('sid'=>$sid));
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'substance', 1);
    }

    /**
     * 上传图片
     */
    public function actionUpload()
    {
        $fn = $_GET['CKEditorFuncNum'];
        $url = WaveCommon::getCompleteUrl();
        $imgTypeArr = WaveCommon::getImageTypes();
        if(!in_array($_FILES['upload']['type'], $imgTypeArr)){
            echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$fn.'","","图片格式错误！");
                </script>';
        }else{
            $projectPath = Wave::app()->projectPath;
            $uploadPath = $projectPath.'data/uploadfile/substance';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = WaveCommon::getYearMonth();
            $uploadPath .= '/'.$ym;
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);

            $imgType = strtolower(substr(strrchr($_FILES['upload']['name'],'.'),1));
            $imageName = time().'_'.rand().'.'.$imgType;

            $file_abso = $url.'/data/uploadfile/substance/'.$ym.'/'.$imageName;
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

        $Substance = new Substance();
        $Substance->delete(array('sid'=>$id));

        WaveCommon::exportResult(true, '成功！');
    }
}

?>