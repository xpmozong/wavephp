<?php
/**
 * 用户管理控制层
 */
class UsersController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '招聘管理后台-用户管理';
    }

    /**
     * 用户列表
     */
    public function actionIndex()
    {
        $data = WaveCommon::getFilter($_GET);
        $this->page = isset($data['page']) ? (int)$data['page'] : 1;
        $pagesize = 12;
        $start = ($this->page - 1) * $pagesize;
        $Users = new Users();
        $this->list = $Users->order('userid', 'desc')->limit($start, $pagesize)->getAll();
        $count = $Users->getCount('*');
        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $Common = new Common();
        $this->pagebar = $Common->getPageBar($url, $count, $pagesize, $this->page);
    }

    /**
     * 添加、修改
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $Users = new Users();
        $this->data = $Users->getOne('*', array('userid'=>$id));
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = WaveCommon::getFilter($_POST);
        $userid = (int)$data['userid'];
        unset($data['userid']);
        $Users = new Users();
        if ($userid == 0) {
            unset($data['oldemail']);
            $count = $Users->getCount('*', array('email'=>$data['email']));
            if ($count > 0) {
                $this->jumpBox('邮箱不能重复！', Wave::app()->homeUrl.'users', 1);
            }
            $data['password'] = md5($data['password']);
            $data['add_date'] = date('Y-m-d H:i:s');
            $userid = $Users->insert($data);
            $data['userid'] = $userid;
            $this->Log->saveLogs('添加用户', 1, $data);
        }else{
            if ($data['oldemail'] != $data['email']) {
                $count = $Users->getCount('*', array('email'=>$data['email']));
                if ($count > 0) {
                    $this->jumpBox('邮箱不能重复！', Wave::app()->homeUrl.'users', 1);
                }
            }
            unset($data['oldemail']);
            if (!empty($data['password'])) {
                $data['password'] = md5($data['password']);
            }else{
                unset($data['password']);
            }
            $Users->update($data, array('userid'=>$userid));
            $data['userid'] = $userid;
            $this->Log->saveLogs('更新用户', 1, $data);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'users', 1);
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
        $Users = new Users();
        $Users->delete(array('userid'=>$id));
        $this->Log->saveLogs('删除用户', 1, array('userid'=>$id));
        WaveCommon::exportResult(true, '成功！');
    }
}

?>