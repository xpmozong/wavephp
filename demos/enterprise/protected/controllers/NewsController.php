<?php
/**
 * 网站默认入口控制层
 */
class NewsController extends CommonController
{
       
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 默认函数
     */
    public function actionIndex($cid)
    {
        $this->data = $this->Common->getFilter($_GET);
        $this->cid = (int)$cid;
        $where = array();
        $this->category = array();
        $Category = new Category();
        if ($cid != 0) {
            $where['cid'] = $cid;
            $this->category = $Category->getOne('*', $where);
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($page - 1) * $pagesize;
        $Articles = new Articles();
        $this->list = $Articles ->select('a.aid,a.title,a.add_date,c.c_name')
                                ->from('articles a')
                                ->join('category c', 'a.cid=c.cid')
                                ->where($where)
                                ->limit($start, $pagesize)
                                ->order('a.aid', 'desc')
                                ->getAll();
        $count = $Articles->getCount('*', $where);

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $this->pagebar = $this->Common->getPageBar($url, $count, 
                        $pagesize, $page);
    }

    /**
     * 文章详情
     */
    public function actionArticle($aid)
    {
        $aid = (int)$aid;
        $Articles = new Articles();
        $Category = new Category();
        $this->data = $Articles->getOne('*', array('aid'=>$aid));
        $this->category = $Category->getOne('*', array('cid'=>$this->data['cid']));
        $this->cid = $this->data['cid'];
    }

}

?>