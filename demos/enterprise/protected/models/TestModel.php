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
        $like = array();
        $like['content'] = '是';
        $array = $this  ->select('*')
                        ->from('articles')
                        ->like($like)
                        ->limit(0, 2)
                        ->groupBy('aid')
                        ->orderBy('aid')
                        ->getAll();

        $array = $this  ->select('*')
                        ->from('articles')
                        ->in("aid IN(2,3,4)")
                        ->getAll();

        $array = $this  ->select('*')
                        ->from('articles a')
                        ->join('category c', 'a.cid=c.cid')
                        ->getAll();

        $array = $this  ->select('*')
                        ->from('category')
                        ->getAll();

        // $data = array('c_name'=>'测试测试update');
        // var_dump($this->insert('category', $data));die;
        // var_dump($this->update('category', $data, "cid=4"));die;

        return $array;
    }

} 

?>