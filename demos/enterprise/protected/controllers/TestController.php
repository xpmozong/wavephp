<?php

class TestController extends Controller
{

    public function __construct() {
        parent::__construct();
    }

    public function actionIndex()  {
        $Articles = new Articles();
        $list = $Articles->getList();
        echo "<pre>";
        print_r($list);die;
    }

}

?>