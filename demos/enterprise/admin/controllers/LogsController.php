<?php
/**
 * 日志控制层
 */
class LogsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->title = '招聘管理后台-日志管理';
    }

    /**
     * 日志列表
     */
    public function actionIndex()
    {
        
    }

    /**
     * 日志列表JSON
     */
    public function actionJsonlist()
    {
        $start = (int)$_GET['iDisplayStart'];
        $pagesize = (int)$_GET['iDisplayLength'];
        $list = $this->Log->limit($start, $pagesize)->order('id', 'desc')->getAll();
        $iTotal = $this->Log->getCount('*');
        $output = array(
            "sEcho" => $_GET['sEcho'],
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        $homeUrl = Wave::app()->homeUrl.'articles/modify/';
        foreach ($list as $key => $value) {
            $list[$key]['parameters'] = '<textarea class="form-control" rows="1">';
            $list[$key]['parameters'] .= $value['parameters'].'</textarea>';
            $list[$key]['time'] = date('Y-m-d H:i:s');
            if ($value['remark']) {
                $list[$key]['remark'] = '<font color="green">成功</font>';
            }else{
                $list[$key]['remark'] = '<font color="red">失败</font>';
            }    
        }
        $output['aaData'] = $list;
        echo json_encode($output);die;
    }

}

?>