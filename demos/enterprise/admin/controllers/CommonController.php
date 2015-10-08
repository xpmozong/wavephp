<?php

class CommonController extends Controller
{
    protected $Common;
    public $userinfo;

    public function __construct()
    {
        parent::__construct();

        $this->Common = new Common();
        $this->userinfo = Wave::app()->session->getState('userinfo');
        if(empty($this->userinfo)){
            $this->redirect(Wave::app()->homeUrl.'site/login');
        }
    }

}

?>