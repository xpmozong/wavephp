<?php
/**
 * 内容列表控制层
 */
class SubstanceController extends Controller
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
     * 内容页
     */
    public function actionIndex()
    {
        $Common = new Common();
        $data = $Common->getFilter($_GET);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($page - 1) * $pagesize;

        $list = $Common->getFieldDataList('substance', '*', null, 
                    $start, $pagesize, 'sid');
        $count = $Common->getCount('substance');

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $pagebar = $Common->getPageBar($url, $count, $pagesize, $page);

        $render = array('list'      => $list,
                        'page'      => $page,
                        'pagebar'   => $pagebar);
        $this->render('layout/header');
        $this->render('substance/index', $render);
        $this->render('layout/footer');
        $this->debuger();
    }

    /**
     * 添加、修改内容
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $Common = new Common();
        $data = $Common->getOneData('substance', '*', 'sid', $id);
        
        $render = array('substance' => $data);
        $this->render('layout/header');
        $this->render('substance/modify', $render);
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
        $sid = (int)$data['sid'];
        unset($data['sid']);
        if ($sid == 0) {
            $Common->getInsert('substance', $data);
        }else{
            $Common->getUpdate('substance', $data, 'sid', $sid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'substance', 1);
    }

    /**
     * 上传图片
     */
    public function actionUpload()
    {
        $Common = new Common();
        $fn = $_GET['CKEditorFuncNum'];
        $url = $Common->getCompleteUrl();
        $imgTypeArr = $Common->getImageTypes();
        if(!in_array($_FILES['upload']['type'], $imgTypeArr)){
            echo '<script type="text/javascript">
                window.parent.CKEDITOR.tools.callFunction("'.$fn.'","","图片格式错误！");
                </script>';
        }else{
            $projectPath = Wave::app()->projectPath;
            $uploadPath = $projectPath.'uploadfile/substance';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = $Common->getYearMonth();
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

        $Common = new Common();
        $Common->getDelete('substance', 'sid', $id);

        $Common->exportResult(true, '成功！');
    }
}

?>