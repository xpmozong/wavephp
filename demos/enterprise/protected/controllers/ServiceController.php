<?php
/**
 * 服务项目入口控制层
 */
class ServiceController extends Controller
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 服务项目
     */
    public function actionIndex($sid)
    {
        $Common = new Common();
        $data = $Common->getOneData('substance', '*', 'sid', $sid);
        $render = array('data' => $data);

        $this->render('index', $render);
    }

}

?>