<?php
/**
 * 网站默认入口控制层
 */
class AboutController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 公司简介
     */
    public function actionIndex($sid)
    {
        $this->data = $this->Common->getOneData('substance', '*', 'sid', $sid);
    }

}

?>