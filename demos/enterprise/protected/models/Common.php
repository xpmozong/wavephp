<?php
/**
 * 公共类
 */
class Common extends Model
{
    public function __construct()
    {
        if (empty(self::$db)) {
            self::$db = Wave::app()->database->db;
        }
    }

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

    /**
     * 执行sql获得数据
     * @param string $sql   sql语句
     * @return array        结果数组
     */
    public function getSqlList($sql)
    {
        return $this->queryAll($sql);
    }

    /**
     * 执行sql获得单个数据
     * @param string $sql   sql语句
     * @return array        结果数组
     */
    public function getSqlOne($sql)
    {
        return $this->queryOne($sql);
    }

    /**
     * 根据字段获得所有数据
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param string $order     排序
     * @return array            结果数组
     */
    public function getFieldList($table, $allfield, $order = null, $orderBy = 'desc')
    {
        return $this->select($allfield)
                    ->from($table)
                    ->order($order, $orderBy)
                    ->getAll();
    }

    /**
     * 获得单个数据
     * @param string $table     表名
     * @param string $allField  查询字段
     * @param string $field     条件字段
     * @param string $id        条件
     * @return array            数组
     */
    public function getOneData($table, $allField, $field, $id)
    {
        $where = array($field=>$id);
        $array = $this  ->select($allField)
                        ->from($table)
                        ->where($where)
                        ->getOne();

        return $array;
    }

    public function getFieldOneData($table, $allField, $where = null)
    {
        return $this->select($allField)
                    ->from($table)
                    ->where($where)
                    ->getOne();
    }

    /**
     * 有条件的获得所有数据
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param string $field     条件字段名
     * @param string $id        条件
     * @param bool $in          是否用IN
     * @return array            结果数组
     */
    public function getAllData($table, $allField, 
                                $field, $id, $in = null,
                                $order = null, $orderBy = 'desc')
    {
        $array = array($field=>$id);
        return $this->select($allField)
                    ->from($table)
                    ->in($in)
                    ->where($array)
                    ->order($order, $orderBy)
                    ->getAll();
    }

    /**
     * 有条件的获得所有数据
     * @param string $table     表名
     * @param string $allfield  字段名
     * @return array            结果数组
     */
    public function getAllData2($table, $allField, 
                                $where, $in = null,
                                $order = null, $orderBy = 'desc')
    {
        return $this->select($allField)
                    ->from($table)
                    ->in($in)
                    ->where($where)
                    ->order($order, $orderBy)
                    ->getAll();
    }

    public function getGroupData($table, $allField, $where, $group = '')
    {
        return $this->select($allField)
                    ->from($table)
                    ->where($where)
                    ->group($group)
                    ->getAll();
    }

    public function getAllDataByLike($table, $allField, 
                                $where, $like = null, $in = null,
                                $order = null, $orderBy = 'desc')
    {
        return $this->select($allField)
                    ->from($table)
                    ->in($in)
                    ->where($where)
                    ->like($like)
                    ->order($order, $orderBy)
                    ->getAll();
    }

    /**
     * 有条件获得分页数据列表
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param array $where      条件
     * @param int $start        从第几条开始查询
     * @param int $limit        限制几条
     * @param string $order     排序
     * @return array            结果数组
     */
    public function getFieldDataList($table, $allfield, $where, $like = null,
                    $start, $limit, $order = null)
    {
        return $this->select($allfield)
                    ->from($table)
                    ->where($where)
                    ->order($order)
                    ->limit($start, $limit)
                    ->getAll();
    }

    /**
     * 获得连接条件查询
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param int $start        从第几条开始查询
     * @param int $limit        限制几条
     * @param string $jsonTable 连接表
     * @param string $joinOn    连接字段
     * @param array $where      条件数组
     * @param array $in         条件数组
     * @param string $order     排序
     * @param string $group     group by
     * @return array            结果数组
     */
    public function getJoinDataList($table, 
                    $allfield, $start, $limit, $jsonTable, $joinOn, 
                    $where = null, $in = null, $like = null,
                    $order = '', $orderBy = 'desc', $group = '')
    {
        return $this->select($allfield)
                    ->from($table)
                    ->join($jsonTable, $joinOn)
                    ->where($where)
                    ->in($in)
                    ->like($like)
                    ->order($order, $orderBy)
                    ->limit($start, $limit)
                    ->getAll();
    }

    /**
     * 获得连接条件查询
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param string $jsonTable 连接表
     * @param string $joinOn    连接字段
     * @param string $where     条件数组
     * @return array            结果数组
     */
    public function getJoinData($table, $allfield, $jsonTable, 
                                $joinOn, $where = null)
    {
        return $this->select($allfield)
                    ->from($table)
                    ->join($jsonTable, $joinOn)
                    ->where($where)
                    ->getOne();
    }

    /**
     * 根据字段统计数量
     * @param string $table     表名
     * @param string $field     条件字段名
     * @param string $id        条件
     * @return int              数量
     */
    public function getFieldCount($table, $field, $id)
    {
        $where = array($field=>$id);
        $countArr = $this   ->select('count(*) count')
                            ->from($table)
                            ->where($where)
                            ->getOne();
        $count = $countArr['count'];

        return $count;
    }

    /**
     * 根据条件字段统计数量
     * @param string $table     表名
     * @param array $where      条件数组
     * @return int              数量
     */
    public function getFieldWhereCount($table, $where = null, $like = null)
    {
        $countArr = $this   ->select('count(*) count')
                            ->from($table)
                            ->where($where)
                            ->getOne();
        $count = $countArr['count'];
        
        return $count;
    }

    /**
     * 插入数据
     * @param string $table 表名
     * @param array $data   数据数组
     */
    public function getInsert($table, $data)
    {
        $this->_tableName = $table;
        return $this->insert($data);
    }

    /**
     * 获得刚插入的id
     * @return int 刚插入的id
     */
    public function getLastId()
    {
        return $this->insertId();
    }

    /**
     * 更新数据
     * @param string $table 表名
     * @param array $data   更新数据数组
     * @param string $field 条件字段名
     * @param string $id    条件
     * @param bool $in    是否用IN
     * @return boolean
     *
     */
    public function getUpdate($table, $data, $field, $id, $in = false)
    {
        $this->_tableName = $table;
        $where = array($field=>$id);

        return $this->update($data, $where);
    }

    /**
     * 删除数据
     * @param string $table 表名
     * @param string $field 条件字段名
     * @param string $id    条件
     * @param string $in    是否用IN
     * @return boolean
     */
    public function getDelete($table, $field, $id, $in = false)
    {
        $this->_tableName = $table;
        $where = array($field=>$id);

        return $this->delete($where);
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