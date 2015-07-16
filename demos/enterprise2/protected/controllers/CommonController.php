<?php

class CommonController extends Controller
{
    public $Common;
    public $links = array();

    public function __construct()
    {
        parent::__construct();

        $this->Common = new Common();
        $this->links = $this->Common->getFieldList('links', '*', 'lid');
    }

}

?>