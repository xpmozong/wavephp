<?php
/**
 * 网站默认入口控制层
 */
class SiteController extends Controller
{
    public $markdown;

    public function __construct()
    {
        parent::__construct();
        $this->markdown = new Markdown();
        $this->markdown->initAllBlogData(ROOT_PATH.'/data/md/', true);
    }

    /**
     * 默认函数
     */
    public function actionIndex()
    {
        $Users = new Users();
        $this->isLogin = $Users->isLogin();

        $this->cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $this->categorys = $this->markdown->getAllCategorys();
        if ($this->cid == 0) {
            $this->cid = $this->categorys[0]['id'];
        }
        $this->blogList = $this->markdown->getBlogListByCategory($this->cid);
        $this->blogId = isset($_GET['blogId']) ? $_GET['blogId'] : 0;
        if ($this->blogId === 0) {
            $this->blogId = $this->blogList[0]['blogId'];
        }
        $this->nowblog = $this->markdown->getBlogById($this->blogId);
    }

    /**
     * 添加
     */
    public function actionAdd()
    {
        if (isset($_POST['submit'])) {
            $filePath = ROOT_PATH.'/data/md/'.time().'.md';
            $markText = $_POST["test-editormd-markdown-doc"];
            Wave::writeCache($filePath, $markText);
            $FileClass = new FileClass();
            $FileClass->rmdirs(ROOT_PATH.'/data/caches');
            $this->jumpBox('添加成功！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 编辑页
     */
    public function actionModify()
    {
        $this->blogId = isset($_GET['blogId']) ? $_GET['blogId'] : 0;
        if ($this->blogId) {
            $nowblog = $this->markdown->getBlogById($this->blogId);
            if (empty($nowblog)) {
                $this->jumpBox('没有此文档！', Wave::app()->homeUrl, 1);
            }
            $this->fileName = $nowblog['fileName'];
            $filePath = ROOT_PATH.'/data/md/'.$nowblog['fileName'];
            $this->fileContent = file_get_contents($filePath);
        }else{
            $this->jumpBox('请选择编辑文档！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 编辑结果
     */
    public function actionModified()
    {
        if (isset($_POST['submit'])) {
            $filePath = ROOT_PATH.'/data/md/'.$_POST['fileName'];
            $markText = $_POST["test-editormd-markdown-doc"];
            Wave::writeCache($filePath, $markText);
            $FileClass = new FileClass();
            $FileClass->rmdirs(ROOT_PATH.'/data/caches');
            $this->jumpBox('编辑成功！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 删除
     */
    public function actionDelete()
    {
        $this->blogId = isset($_GET['blogId']) ? $_GET['blogId'] : 0;
        if ($this->blogId) {
            $nowblog = $this->markdown->getBlogById($this->blogId);
            if (empty($nowblog)) {
                $this->jumpBox('没有此文档！', Wave::app()->homeUrl, 1);
            }
            $filePath = ROOT_PATH.'/data/md/'.$nowblog['fileName'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $FileClass = new FileClass();
            $FileClass->rmdirs(ROOT_PATH.'/data/caches');
            $this->jumpBox('删除成功！', Wave::app()->homeUrl, 1);
        }else{
            $this->jumpBox('请选择文档！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 登录
     */
    public function actionLoging()
    {
        $data = $_POST;
        $Users = new Users();
        $array = $Users->getOne('*', array('email'=>$data['user_login']));
        if(!empty($array)){
            if ($array['password'] == md5($data['user_pass'])) {
                Wave::app()->session->setState('userinfo', $array);
                $this->jumpBox('登录成功！', Wave::app()->homeUrl, 1);
            }else{
                $this->jumpBox('用户名或密码错误！', Wave::app()->homeUrl, 1);
            }
        }else{
            $this->jumpBox('没有该用户！', Wave::app()->homeUrl, 1);
        }
    }

    /**
     * 退出
     */
    public function actionLogout()
    {
        Wave::app()->session->logout('userinfo');
        $this->jumpBox('退出成功！', Wave::app()->homeUrl.'site', 1);
    }

}

?>