<?php

class CommonController extends Controller
{
    public $Common;
    public $links = array();

    public function __construct()
    {
        parent::__construct();

        $this->Common = new Common();
        $Links = new Links();
        $this->links = $Links->order('lid', 'desc')->getAll();
    }

}

?>