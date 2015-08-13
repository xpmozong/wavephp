<?php
/**
 * 案例入口控制层
 */
class ExampleController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 客户案例
     */
    public function actionIndex()
    {
        $this->data = $this->Common->getOneData('substance', '*', 'sid', 5);
    }

}

?>