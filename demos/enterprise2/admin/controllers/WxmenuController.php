<?php
/**
 * 公众账号菜单管理控制层
 */
class WxmenuController extends Controller
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
     * 自定义菜单列表
     */
    public function actionIndex()
    {
        $Common = new Common();
        $list = $Common->getJoinDataList('gh_menu m', 
                    'm.*,a.gh_name', 0, 0, 'gh_manage a', 'm.gid=a.gid', 
                    null, 'm.mid');
        $render = array('list' => $list);
        $this->render('layout/header');
        $this->render('wxmenu/index', $render);
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
        $data = $Common->getJoinOneData('gh_menu m', 'm.*,a.gh_name', 
                        'gh_manage a', 'm.gid=a.gid', "m.mid='$id'");
        $wxdata = $Common->select('gid,gh_name')
                        ->from('gh_manage')
                        ->where('userid='.$this->userid)
                        ->notin('gid NOT IN(SELECT gid FROM gh_menu)')
                        ->getAll();
        $render = array('wxmenu' => $data, 'wxdata'=>$wxdata);
        $this->render('layout/header');
        $this->render('wxmenu/modify', $render);
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
        $id = (int)$data['mid'];
        unset($data['mid']);
        if ($id == 0) {
            $Common->getInsert('gh_menu', $data);
        }else{
            $Common->getUpdate('gh_menu', $data, 'mid', $id);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'wxmenu', 1);
    }

}