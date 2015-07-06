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
        $data = $this->Common->getOneData('substance', '*', 'sid', 5);
        $render = array('data' => $data);
        $this->render('layout/header');
        $this->render('example/index', $render);
        $this->render('layout/footer', array('links'=>$this->links));
        $this->debuger();
    }

}

?>