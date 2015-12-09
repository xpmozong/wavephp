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
                                            'password'=>'5d9e5edd8a4d08fac2b4d29139a8cbfb')

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