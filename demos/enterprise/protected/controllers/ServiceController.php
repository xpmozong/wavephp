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

        $links = $Common->getFieldList('links', '*', 'lid desc');
        $this->render('layout/header');
        $this->render('service/index', $render);
        $this->render('layout/footer', array('links'=>$links));
    }

}

?>