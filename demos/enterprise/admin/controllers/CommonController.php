<?php

class CommonController extends Controller
{
    protected $Common;
    protected $userid;
    public $username;

    public function __construct()
    {
        parent::__construct();

        $this->Common = new Common();
        $this->userid = Wave::app()->session->getState('userid');
        if(empty($this->userid)){
            $this->redirect(Wave::app()->homeUrl.'site/login');
        }
        $this->username = Wave::app()->session->getState('username');
    }

}

?>