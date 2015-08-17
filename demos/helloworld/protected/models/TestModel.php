<?php
/**
 * 测试模型
 */
class TestModel
{
    public function __construct()
    {
        if (empty(self::$db)) {
            self::$db = Wave::app()->database->db;
        }
        $this->_tableName = 't_sys_mod_relation';

        $this->cache = Wave::app()->redis;
    }

    public function getList()
    {
        $like = array();
        $like['content'] = '是';
        $array = $this  ->select('*')
                        ->from('articles')
                        ->like($like)
                        ->limit(0, 2)
                        ->group('aid')
                        ->order('aid')
                        ->getAll();

        $where = array('aid'=>2);
        $array = $this  ->select('*')
                        ->from('articles')
                        ->where($where)
                        ->getAll();

        $in = array('aid' => '2,3,4');
        $array = $this  ->select('*')
                        ->from('articles')
                        ->in($in)
                        ->getAll();

        $array = $this  ->select('*')
                        ->from('articles a')
                        ->join('category c', 'a.cid=c.cid')
                        ->getAll();

        $array = $this  ->getAll();
        // 数据缓存
        $array = $this ->getAll('*', null, 'parent_code', 60);

        $data = array('c_name'=>'测试4');
        var_dump($this->insert($data));
        $where = array('cid'=>4);
        $updateCount = $this->update($data, $where);
        echo $updateCount;die;
        
        return $array;
    }
}
?>