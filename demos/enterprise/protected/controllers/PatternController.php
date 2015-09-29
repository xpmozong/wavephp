<?php
/**
 * 服务模式入口控制层
 */
class PatternController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 服务模式
     */
    public function actionIndex($sid)
    {
        $Substance = new Substance();
        $this->data = $Substance->getOne('*', array('sid'=>$sid));
    }

}

?>