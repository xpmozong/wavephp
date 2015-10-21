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
        $Category = new Category();
        $this->category = $Category->getAll();
    }

    /**
     * 文章列表JSON
     */
    public function actionJsonlist()
    {
        $Articles = new Articles();
        $start = (int)$_GET['iDisplayStart'];
        $pagesize = (int)$_GET['iDisplayLength'];
        $where = array();
        $this->cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 1;
        if ($this->cid) {
            $where['cid'] = $this->cid;
        }
        $list = $Articles->where($where)->limit($start, $pagesize)->order('aid')->getAll();
        $iTotal = $Articles->getCount('*', $where);
        $output = array(
            "sEcho" => $_GET['sEcho'],
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        $homeUrl = Wave::app()->homeUrl.'articles/modify/';
        foreach ($list as $key => $value) {
            $list[$key]['operation'] = '<button type="button" class="btn btn-info btn-xs m-right20" onclick="javascript:location.href=\''.$homeUrl.$value['aid'].'\'">修改</button>';
            $list[$key]['operation'] .= '<button type="button" class="btn btn-danger btn-xs" onclick="mdelete('.$value['aid'].')">删除</button>';
        }
        $output['aaData'] = $list;
        echo json_encode($output);die;
    }

    /**
     * 添加、修改文章
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $where = array('a.aid'=>$id);
        $Articles = new Articles();
        $Category = new Category();
        $this->data = $Articles ->select('c.*,a.*')
                                ->from('articles a')
                                ->join('articles_content c', 'a.aid=c.aid')
                                ->where($where)
                                ->getOne();
        $this->data['content'] = stripslashes($this->data['content']);
        $this->category = $Category->getAll();
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = $this->Common->getFilter($_POST);
        $aid = (int)$data['aid'];
        $article = $data['aritcle'];
        $content = $data['a_content'];
        $Articles = new Articles();
        $ArticlesContent = new ArticlesContent();
        if ($aid == 0) {
            $article['add_date'] = $this->Common->getDate();
            $content['aid'] = $Articles->insert($article);
            $ArticlesContent->insert($content);
            $article['aid'] = $content['aid'];
        }else{
            $where = array('aid'=>$aid);
            $Articles->update($article, $where);
            $count = $ArticlesContent->getCount('*', $where);
            if ($count > 0) {
                $ArticlesContent->update($content, $where);
            }else{
                $content['aid'] = $aid;
                $ArticlesContent->insert($content);
            }
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
            $uploadPath = $projectPath.'data/uploadfile/articles';
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);
            $ym = $Common->getYearMonth();
            $uploadPath .= '/'.$ym;
            if(!is_dir($uploadPath)) mkdir($uploadPath, 0777);

            $imgType = strtolower(substr(strrchr($_FILES['upload']['name'],'.'),1));
            $imageName = time().'_'.rand().'.'.$imgType;

            $file_abso = $url.'/data/uploadfile/articles/'.$ym.'/'.$imageName;
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
        $where = array('aid'=>$id);
        $Articles = new Articles();
        $Articles->delete($where);
        $ArticlesContent = new ArticlesContent();
        $ArticlesContent->delete($where);
        $this->Common->exportResult(true, '成功！');
    }
}

?>