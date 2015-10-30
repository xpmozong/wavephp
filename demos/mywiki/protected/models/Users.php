<?php
/**
 * 用户类
 */
class Users extends Model
{
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