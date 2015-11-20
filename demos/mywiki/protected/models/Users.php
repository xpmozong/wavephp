<?php
/**
 * 用户类
 */
class Users
{
    public $manages;

    public function __construct() {
        $this->manages = array('361131953@qq.com'=>
                                    array(  'email'=>'361131953@qq.com', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'),
                                'zhangjingyun@quakegame.cn'=>
                                    array(  'email'=>'zhangjingyun@quakegame.cn', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'),
                                'yujie@quakegame.cn'=>
                                    array(  'email'=>'yujie@quakegame.cn', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'),
                                'linlin@quakegame.cn'=>
                                    array(  'email'=>'linlin@quakegame.cn', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'),
                                'fengyaru@quakegame.cn'=>
                                    array(  'email'=>'fengyaru@quakegame.cn', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'),
                                'tangchangfu@quakegame.cn'=>
                                    array(  'email'=>'tangchangfu@quakegame.cn', 
                                            'password'=>'e10adc3949ba59abbe56e057f20f883e'), 

                            );
    }

    public function getOne($field = '*', $array = array()) {
        $user = array();
        if (!empty($array)) {
            $user = $this->manages[$array['email']];
        }

        return $user;
    }

    protected function init() {
        $this->_tableName = 'users';
    }

    public function isLogin() {
        $userinfo = Wave::app()->session->getState('userinfo');
        if(!empty($userinfo)){
            return true;
        }

        return false;
    }
}
?>