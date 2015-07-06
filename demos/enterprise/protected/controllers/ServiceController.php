<?php
/**
 * 服务项目入口控制层
 */
class ServiceController extends CommonController
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
        $data = $this->Common->getOneData('substance', '*', 'sid', $sid);
        $render = array('data' => $data);
        $this->render('layout/header');
        $this->render('service/index', $render);
        $this->render('layout/footer', array('links'=>$this->links));
        $this->debuger();
    }

}

?>