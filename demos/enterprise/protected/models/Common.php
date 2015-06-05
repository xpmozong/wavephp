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
        return $this->getAll($sql);
    }

    /**
     * 执行sql获得单个数据
     * @param string $sql   sql语句
     * @return array        结果数组
     */
    public function getSqlOne($sql)
    {
        return $this->getOne($sql);
    }

    /**
     * 根据字段获得所有数据
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param string $order     排序
     * @return array            结果数组
     */
    public function getFieldList($table, $allfield, $order = null)
    {
        return $this->select($allfield)
                    ->from($table)
                    ->order($order)
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
        $array = $this  ->select($allField)
                        ->from($table)
                        ->where("$field='$id'")
                        ->getOne();

        return $array;
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
    public function getAllData($table, $allField, $field, $id, $in = false)
    {
        if ($in) {
            return $this->select($allField)
                        ->from($table)
                        ->in("$field IN ($id)")
                        ->getAll();
        }else{
            return $this->select($allField)
                        ->from($table)
                        ->where("$field='$id'")
                        ->getAll();
        }
    }

    /**
     * 有条件获得分页数据列表
     * @param string $table     表名
     * @param string $allfield  字段名
     * @param string $wherestr  条件
     * @param int $start        从第几条开始查询
     * @param int $limit        限制几条
     * @param string $order     排序
     * @return array            结果数组
     */
    public function getFieldDataList($table, $allfield, $wherestr, 
                    $start, $limit, $order = null)
    {
        return $this->select($allfield)
                    ->from($table)
                    ->where($wherestr)
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
     * @param string $wherestr  条件
     * @param string $order     排序
     * @return array            结果数组
     */
    public function getJoinDataList($table, 
                    $allfield, $start, $limit, $jsonTable, $joinOn, 
                    $wherestr = null, $order = null)
    {
        return $this->select($allfield)
                    ->from($table)
                    ->join($jsonTable, $joinOn)
                    ->where($wherestr)
                    ->order($order)
                    ->limit($start, $limit)
                    ->getAll();
    }

    /**
     * 根据字段统计数量
     * @param string $table     表名
     * @return int              数量
     */
    public function getCount($table)
    {
        $count = $this  ->select('count(*) count')
                        ->from($table)
                        ->getOne();
        
        return $count['count'];
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
        $countArr = $this   ->select('count(*) count')
                            ->from($table)
                            ->where("$field='$id'")
                            ->getOne();
        $count = $countArr['count'];

        return $count;
    }

    /**
     * 根据条件字段统计数量
     * @param string $table     表名
     * @param string $wherestr  条件
     * @return int              数量
     */
    public function getFieldWhereCount($table, $wherestr)
    {
        $countArr = $this   ->select('count(*) count')
                            ->from($table)
                            ->where($wherestr)
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
        return $this->insert($table, $data);
    }

    /**
     * 获得刚插入的id
     * @return int 刚插入的id
     */
    public function getLastId()
    {
        return $this->getInsertLastId();
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
        if (!$in) {
            return $this->update($table, $data, "$field='$id'");
        }else{
            return $this->update($table, $data, "$field in ($id)");
        }
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
        if(!$in) {
            return $this->delete($table, "$field='$id'");
        }else{
            return $this->delete($table, "$field in ($id)");
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
        $list .= '<li><a href="'.
                preg_replace('/page\=(\d+)/', 'page=1', $url).'">首页'."</a></li>";
        for ($i = $begin; $i <= $end; $i++) {
            if ($i == $page) {
                $list .= '<li class="active"><a href="javascript:;">'.$i."</a></li>";
            }else{
                $list .= '<li><a href="'.
                preg_replace('/page\=(\d+)/', 'page='.$i, $url).'">'.$i."</a></li>";
            }
        }
        $list .= '<li><a href="'.
                preg_replace('/page\=(\d+)/', 'page='.$pagenum, $url).'">尾页'."</a></li>";
        $list .= '</ul>';
        $bar = '<div class="pagebar">'.$list.'</div>';

        return $bar;
    }

   

}

?>