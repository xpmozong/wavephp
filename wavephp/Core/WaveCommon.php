<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2013
 * @link            https://github.com/xpmozong/wavephp
 * @since           Version 1.0
 *
 */

/**
 * Wavephp Application WaveCommon Class
 *
 * 框架公共类
 *
 * @package         Wavephp
 * @author          许萍
 *
 */
class WaveCommon
{
    /**
     * curl
     * @param string    $url        地址
     * @param string    $method     方法
     * @param array     $data       提交数组
     * @param int       $timeout    超时时间
     *
     * @return string or false
     *
     */
    public static function curl($url = '', $method = "GET", $data = array(), $timeout = 60) 
    {
        $postdata = http_build_query($data, '', '&');
        $ch = curl_init();
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

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $response = false;
        }

        curl_close($ch);

        return $response;
    }

    /**
     * 获得日期
     * @return string 日期
     */
    public static function getDate()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 获得年月
     * @return string 日期
     */
    public static function getYearMonth()
    {
        return date('Ym');
    }

    /**
     * 获得图片格式数组
     * @return array
     */
    public static function getImageTypes()
    {
        return array(
                    'image/jpeg','image/jpg',
                    'image/gif','image/png',
                    'image/bmp','image/pjepg'
                );
    }

    /**
     * 过滤
     * @param array $data   需过滤的数组
     * @return array        过滤数组
     */
    public static function getFilter($data)
    {
        foreach ($data as $key => $value) {
            if(!empty($value)){
                if(is_array($value)){
                    foreach ($value as $k => $v) {
                        if (is_array($v)) {
                            $data[$key][$k] = $this->getFilter($v);
                        }else{
                            $data[$key][$k] = addslashes($v);
                        }
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
     * @param bool $code        错误码
     * @param string $msg       信息
     */
    public static function exportResult($code, $msg, $data = array())
    {
        $json_array = array();
        $json_array['code'] = $code;
        $json_array['msg'] = $msg;
        $json_array['data'] = $data;
        echo json_encode($json_array);
        unset($json_array);die;
    }
}
?>