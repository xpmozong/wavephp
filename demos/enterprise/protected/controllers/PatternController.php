<?php
/**
 * 服务模式入口控制层
 */
class PatternController extends Controller
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
        $Common = new Common();
        $data = $Common->getOneData('substance', '*', 'sid', $sid);
        $render = array('data' => $data);

        $this->render('index', $render);
    }

}

?>