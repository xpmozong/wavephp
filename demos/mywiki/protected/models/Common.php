<?php
/**
 * 公共类
 */
class Common extends Model
{
    public function crc($u, $n = 36)
    {
        $u = strtolower($u);
        $id = sprintf("%u", crc32($u));
        $m = base_convert( intval(fmod($id, $n)), 10, $n);
        return $m{0};
    }

    /**
     * curl
     */
    public function curl($url = '', $method = "GET", $data = array()) 
    {
        $postdata = http_build_query($data, '', '&');
        $ch   = curl_init();
        if(strtoupper($method) == 'GET' && $data){
            $url .= '?'.$postdata;
        } elseif (strtoupper($method) == 'POST' && $data){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        } elseif(strtoupper($method) == 'JSON' && $data) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            exit(curl_errno($ch).' : '.curl_error($ch).$url);
        } else {
            curl_close($ch);
        }

        return $response;
    }

    /**
     * 获得日期
     * @return string 日期
     */
    public function getDate()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 获得年月
     * @return string 日期
     */
    public function getYearMonth()
    {
        return date('Ym');
    }

    /**
     * 获得图片格式数组
     * @return array
     */
    public function getImageTypes()
    {
        return array(
                    'image/jpeg','image/jpg',
                    'image/gif','image/png',
                    'image/bmp','image/pjepg'
                );
    }

    /**
     * 获得完整url地址
     */
    public function getCompleteUrl()
    {
        $baseUrl = Wave::app()->request->baseUrl;
        $hostInfo = Wave::app()->request->hostInfo;
        
        return 'http://'.$hostInfo.$baseUrl;
    }

    /**
     * 过滤
     * @param array $data   需过滤的数组
     * @return array        过滤数组
     */
    public function getFilter($data)
    {
        foreach ($data as $key => $value) {
            if(!empty($value)){
                if(is_array($value)){
                    foreach ($value as $k => $v) {
                        $data[$key][$k] = addslashes($v);
                    }
                }else{
                    $data[$key] = addslashes($value);
                }
            }
        }

        return $data;
    }

    /**
     * 输出结果
     * @param bool $status      状态
     * @param string $msg       信息
     */
    public function exportResult($status, $msg)
    {
        $json_array = array();
        $json_array['success'] = $status;
        $json_array['msg'] = $msg;
        echo json_encode($json_array);
        unset($json_array);die;
    }

    public function rmdirs($dir){
        //error_reporting(0);    函数会返回一个状态,我用error_reporting(0)屏蔽掉输出
        //rmdir函数会返回一个状态,我用@屏蔽掉输出
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key => $val){
            if($val == '.' || $val == '..'){

            }else {
                if(is_dir($dir.'/'.$val)){                            
                    if(@rmdir($dir.'/'.$val) == 'true'){

                    }else{
                        rmdirs($dir.'/'.$val);
                    }                   
                }else{               
                    unlink($dir.'/'.$val);
                }
            }
        }
    }    

    /**
     * 分页
     * @param string $url       地址
     * @param int $allcount     总数
     * @param int $pagesize     页显示数量
     * @param int $page         当前页
     * @return string           分页
     */
    public function getPageBar($url, $allcount, $pagesize, $page)
    {
        $pagenum = ceil($allcount/$pagesize);
        $list = '<ul class="pagination">';
        $begin = 1;
        $end = 7;
        if ($page > 3) {
            $begin = $page - 3;
            $end = $page + 3;
        }
        if ($page > 3 && $page >= ($pagenum - 3)) {
            $begin = $pagenum - 7;
            $end = $pagenum;
        }
        if ($pagenum <= 7) {
            $begin = 1;
            $end = $pagenum;
        }
        $prevpage = $page - 1;
        if ($prevpage <= 0) {
            $prevpage = 1;
        }
        $list .= '<li>';
        $list .= '<a href="'. preg_replace('/page\=(\d+)/', 'page=1', $url).'">';
        $list .= '首页</a></li>';
        $list .= '<li>';
        $list .= '<a href="'. preg_replace('/page\=(\d+)/', 'page='.$prevpage, $url).'">';
        $list .= '上一页</a></li>';        
        for ($i = $begin; $i <= $end; $i++) {
            if ($i == $page) {
                $list .= '<li class="active"><a href="javascript:;">'.$i."</a></li>";
            }else{
                $list .= '<li><a href="'.
                preg_replace('/page\=(\d+)/', 'page='.$i, $url).'">'.$i."</a></li>";
            }
        }
        $nextpage = $page + 1;
        if ($nextpage > $pagenum) {
            $nextpage = $pagenum;
        }
        $list .= '<li>';
        $list .= '<a href="'. preg_replace('/page\=(\d+)/', 'page='.$nextpage, $url).'">';
        $list .= '下一页</a></li>'; 
        $list .= '<li>';
        $list .= '<a href="'. preg_replace('/page\=(\d+)/', 'page='.$pagenum, $url).'">';
        $list .= '尾页</a></li>';
        $list .= '</ul>';
        $bar = '<div class="pagebar">'.$list.'</div>';

        return $bar;
    }
    
}

?>