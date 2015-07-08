<?php
/**
 * 公众账号管理控制层
 */
class WxController extends Controller
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
     * 公众账号列表
     */
    public function actionIndex()
    {
        $Common = new Common();
        $list = $Common->getFieldList('gh_manage', '*');
        foreach ($list as $key => $value) {
            switch ((int)$value['gh_type']) {
                case 1:
                    $list[$key]['gh_type'] = '订阅号';
                    break;
                case 2:
                    $list[$key]['gh_type'] = '认证订阅号';
                    break;
                case 3:
                    $list[$key]['gh_type'] = '服务号';
                    break;
                case 4:
                    $list[$key]['gh_type'] = '认证服务号';
                    break;
                default:
                    break;
            }
        }

        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('wx/index', $render);
        $this->render('layout/footer');
        $this->debuger();
    }

    /**
     * 添加、修改公众号
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $Common = new Common();
        $data = $Common->getOneData('gh_manage', '*', 'gid', $id);
        if ($data['gh_key']) {
            $data['gh_key'] = $Common->getWxApiUri().$data['gh_key'];
        }

        $render = array('wx' => $data);
        $this->render('layout/header');
        $this->render('wx/modify', $render);
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
        $id = (int)$data['gid'];
        unset($data['gid']);

        $md5 = md5($data['gh_id']);
        $data['gh_key'] = substr($md5, 16);
        $data['gh_token'] = substr($md5, 8, 8);
        $data['gh_enaeskey'] = $md5.substr($md5, 21);

        if ($id == 0) {
            $data['userid'] = $this->userid;
            $Common->getInsert('gh_manage', $data);
        }else{
            $Common->getUpdate('gh_manage', $data, 'gid', $id);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'wx', 1);
    }
}