<?php
/**
 * 案例入口控制层
 */
class ExampleController extends Controller
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
        $Common = new Common();
        $data = $Common->getOneData('substance', '*', 'sid', 5);
        $render = array('data' => $data);

        $this->render('index', $render);
    }

}

?>