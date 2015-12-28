<?php

class CommonController extends Controller
{
    protected $Common;
    protected $Log;
    public $userinfo;

    public function __construct()
    {
        parent::__construct();
        
        $this->Log = new Log();
        $this->userinfo = Wave::app()->session->getState('userinfo');
        if(empty($this->userinfo)){
            $this->redirect(Wave::app()->homeUrl.'site/login');
        }
    }

}

?>