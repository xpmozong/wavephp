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
        $this->list = $this->Common->getJoinDataList('gh_menu m', 
                    'm.*,a.gh_name', 0, 0, 'gh_manage a', 'm.gid=a.gid', 
                    null, 'm.mid');
    }

    /**
     * 添加、修改公众号
     */
    public function actionModify($id)
    {
        $id = (int)$id;
        $this->data = $this->Common->getJoinData('gh_menu m', 'm.*,a.gh_name', 
                        'gh_manage a', 'm.gid=a.gid', array('m.mid'=>$id));
        $this->wxdata = $this->Common->select('gid,gh_name')
                        ->from('gh_manage')
                        ->where('userid='.$this->userid)
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
        if ($id == 0) {
            $this->Common->getInsert('gh_menu', $data);
        }else{
            $this->Common->getUpdate('gh_menu', $data, 'mid', $id);
        }

        $this->jumpBox('成功！', Wave::app()->homeUrl.'wxmenu', 1);
    }

}