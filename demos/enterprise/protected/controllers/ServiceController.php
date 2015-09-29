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
        $Substance = new Substance();
        $this->data = $Substance->getOne('*', array('sid'=>$sid));
    }

}

?>