<?php

class TestModel extends Model {

    public function __construct()
    {
        if (empty(self::$db)) {
            self::$db = Wave::app()->database->db;
        }
    }

    public function getList()
    {
        // $like = array();
        // $like['content'] = '是';
        // $array = $this  ->select('*')
        //                 ->from('articles')
        //                 ->like($like)
        //                 ->limit(0, 2)
        //                 ->group('aid')
        //                 ->order('aid')
        //                 ->getAll();

        // $where = array('aid'=>2);
        // $array = $this  ->select('*')
        //                 ->from('articles')
        //                 ->where($where)
        //                 ->getAll();

        // $in = array('aid' => '2,3,4');
        // $array = $this  ->select('*')
        //                 ->from('articles')
        //                 ->in($in)
        //                 ->getAll();

        // $array = $this  ->select('*')
        //                 ->from('articles a')
        //                 ->join('category c', 'a.cid=c.cid')
        //                 ->getAll();

        // $array = $this  ->select('*')
        //                 ->from('category')
        //                 ->getAll();

        // $data = array('c_name'=>'测试4');
        // var_dump($this->insert('category', $data));
        // var_dump($this->insertId());die;
        // $where = array('cid'=>4);
        // $updateCount = $this->update('category', $data, $where);
        // echo $updateCount;die;

        return $array;
    }

} 

?>