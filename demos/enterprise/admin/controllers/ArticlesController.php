<?php
/**
 * 文章列表控制层
 */
class ArticlesController extends Controller
{
    public $defaultAction = 'Index';
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
     * 文章页
     */
    public function actionIndex()
    {
        $Common = new Common();
        $data = $Common->getFilter($_GET);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 1;
        $pagesize = 15;
        $start = ($page - 1) * $pagesize;
        $where = '';
        $where .= " AND cid='$cid'";

        $sql = "SELECT aid,title FROM articles a WHERE 1=1 $where ORDER BY aid DESC LIMIT $start,$pagesize";
        $list = $Common->getSqlList($sql);
        
        $countArr = $Common->getSqlOne("SELECT count(*) count FROM articles WHERE 1=1 $where");
        $count = $countArr['count'];

        $category = $Common->getSqlList('SELECT * FROM category');

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['cid'])){
            $url .= '?cid=1';
        }
        if(empty($data['page'])){
            $url .= '&page=1';
        }
        $pagebar = $Common->getPageBar($url, $count, $pagesize, $page);

        $render = array('list'      => $list,
                        'page'      => $page,
                        'category'  => $category,
                        'cid'       => $cid,
                        'pagebar'   => $pagebar);
        $this->render('index', $render);
    }

    /**
     * 添加、修改文章
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $Common = new Common();
        $data = $Common->getOneData('articles', '*', 'aid', $id);
        $category = $Common->getSqlList('SELECT * FROM category');
        
        $render = array('article'   => $data,
                        'category'  => $category);
        $this->render('modify', $render);
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $Common = new Common();
        $data = $Common->getFilter($_POST);
        $aid = (int)$data['aid'];
        unset($data['aid']);
        if ($aid == 0) {
            $data['add_date'] = $Common->getDate();
            $Common->getInsert('articles', $data);
        }else{
            $Common->getUpdate('articles', $data, 'aid', $aid);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'articles', 1);
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
            $uploadPath = $projectPath.'uploadfile/articles';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = $Common->getYearMonth();
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

        $Common = new Common();
        $Common->getDelete('articles', 'aid', $id);

        $Common->exportResult(true, '成功！');
    }
}

?>