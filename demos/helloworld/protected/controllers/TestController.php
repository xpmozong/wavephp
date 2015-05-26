<?php
/**
 * 测试控制层
 */
class TestController extends Controller
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 默认函数
     */
    public function actionIndex()
    {
        echo 'Hello test !';
    }
}
