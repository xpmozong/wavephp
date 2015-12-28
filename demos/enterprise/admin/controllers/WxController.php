<?php
/**
 * 公众账号管理控制层
 */
class WxController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '公众账号管理';
    }

    /**
     * 公众账号列表
     */
    public function actionIndex()
    {
        $GhManage = new GhManage();
        $this->list = $GhManage->getAll();
        foreach ($this->list as $key => $value) {
            switch ((int)$value['gh_type']) {
                case 1:
                    $this->list[$key]['gh_type'] = '订阅号';
                    break;
                case 2:
                    $this->list[$key]['gh_type'] = '认证订阅号';
                    break;
                case 3:
                    $this->list[$key]['gh_type'] = '服务号';
                    break;
                case 4:
                    $this->list[$key]['gh_type'] = '认证服务号';
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * 添加、修改公众号
     */
    public function actionModify($id)
    {
        $GhManage = new GhManage();
        $id = (int)$id;
        $this->data = $GhManage->getOne('*', array('gid'=>$id));
        if ($this->data['gh_key']) {
            $this->data['gh_key'] = $this->data['gh_key'];
        }
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = WaveCommon::getFilter($_POST);
        $id = (int)$data['gid'];
        unset($data['gid']);

        $md5 = md5($data['gh_id']);
        $data['gh_key'] = substr($md5, 16);
        $data['gh_token'] = substr($md5, 8, 8);
        $data['gh_enaeskey'] = $md5.substr($md5, 21);
        $GhManage = new GhManage();
        if ($id == 0) {
            $data['userid'] = $this->userinfo['userid'];
            $GhManage->insert('gh_manage', $data);
        }else{
            $GhManage->update($data, array('gid'=>$id));
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'wx', 1);
    }
}