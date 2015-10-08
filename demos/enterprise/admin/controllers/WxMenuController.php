<?php
/**
 * 公众账号菜单管理控制层
 */
class WxmenuController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '公众账号菜单管理';
    }

    /**
     * 自定义菜单列表
     */
    public function actionIndex()
    {
        $GhMenu = new GhMenu();
        $this->list = $GhMenu   ->select('m.*,a.gh_name')
                                ->from('gh_menu m')
                                ->join('gh_manage a', 'm.gid=a.gid')
                                ->order('m.mid', 'desc')
                                ->getAll();
    }

    /**
     * 添加、修改公众号
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $GhMenu = new GhMenu();
        $this->data = $GhMenu   ->select('m.*,a.gh_name')
                                ->from('gh_menu m')
                                ->join('gh_manage a', 'm.gid=a.gid')
                                ->where(array('m.mid'=>$id))
                                ->getAll();
        $GhManage = new GhManage();
        $this->wxdata = $GhManage   ->select('gid,gh_name')
                                    ->where('userid='.$this->userinfo['userid'])
                                    ->notin('gid NOT IN(SELECT gid FROM gh_menu)')
                                    ->getAll();
    }

    /**
     * 提交信息
     */
    public function actionModified()
    {
        $data = $this->Common->getFilter($_POST);
        $id = (int)$data['mid'];
        unset($data['mid']);
        $GhMenu = new GhMenu();
        if ($id == 0) {
            $GhMenu->insert($data);
        }else{
            $GhMenu->update($data, array('mid'=>$id));
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'wxmenu', 1);
    }

}