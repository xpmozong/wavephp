<?php
/**
 * 个人设置控制层
 */
class MemberController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
        $this->title = '招聘管理后台-个人设置';
    }

    /**
     * 个人设置
     */
    public function actionIndex()
    {
        
    }

    /**
     * 设置密码
     */
    public function actionSetpwd()
    {
        $Users = new Users();
        $data = $this->Common->getFilter($_POST);
        if (empty($data['pwd']) || 
            empty($data['newpwd']) || 
            empty($data['confirmpwd'])) {
            $this->jumpBox('参数错误！', Wave::app()->homeUrl.'member', 1);
        }
        if ($data['newpwd'] != $data['confirmpwd']) {
            $this->jumpBox('两次密码不一样！', Wave::app()->homeUrl.'member', 1);
        }
        $updateData = array('password'=>md5($data['newpwd']));
        $Users->update($updateData, array('userid'=>$this->userinfo['userid']));

        $this->jumpBox('修改成功！', Wave::app()->homeUrl.'member', 1);
    }

}
?>