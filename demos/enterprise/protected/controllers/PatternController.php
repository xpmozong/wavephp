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
        $data = $this->Common->getOneData('substance', '*', 'sid', $sid);
        $render = array('data' => $data);
        $this->render('layout/header');
        $this->render('pattern/index', $render);
        $this->render('layout/footer', array('links'=>$this->links));
        
    }

}

?>