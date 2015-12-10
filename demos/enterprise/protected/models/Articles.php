<?php
/**
 * 文章类
 */
class Articles extends Model
{
    protected function init() {
        $this->_tableName = $this->getTablePrefix().'articles';
        // $this->cache = Wave::app()->memcache;
    }

    public function getList() {
        $like = array();
        $like['content'] = '是';
        $array = $this  ->select('*')
                        ->like($like)
                        ->limit(0, 2)
                        ->group('aid')
                        ->order('aid')
                        ->getAll();

        // $where = array('aid'=>2);
        // $array = $this  ->select('*')
        //                 ->where($where)
        //                 ->getAll();

        // $in = array('aid' => '2,3,4');
        // $array = $this  ->select('*')
        //                 ->in($in)
        //                 ->getAll();

        // $array = $this  ->select('*')
        //                 ->from('articles a')
        //                 ->join('category c', 'a.cid=c.cid')
        //                 ->getAll();

        // $array = $this ->getAll();

        // // 数据缓存
        // $array = $this->getAll('*', null, 'articles', 60);


        // $data = array('c_name'=>'测试4');
        // var_dump($this->insert($data));
        // $where = array('cid'=>4);
        // $updateCount = $this->update($data, $where);
        // echo $updateCount;die;
        
        return $array;
    }
}


?>