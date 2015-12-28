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
        $this->data = WaveCommon::getFilter($_GET);
        $this->cid = (int)$cid;
        $where = array();
        $this->category = array();
        $Category = new Category();
        if ($cid != 0) {
            $where['a.cid'] = $cid;
            $this->category = $Category->from('category a')->getOne('*', $where);
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
        $count = $Articles->from('articles a')->getCount('*', $where);

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $Common = new Common();
        $this->pagebar = $Common->getPageBar($url, $count, 
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
        $where = array('a.aid'=>$aid);
        $this->data = $Articles ->select('c.*,a.*')
                                ->from('articles a')
                                ->join('articles_content c', 'a.aid=c.aid')
                                ->where($where)
                                ->getOne();
        $this->data['content'] = stripslashes($this->data['content']);
        $this->title = $this->data['title'];
        $this->category = $Category->getOne('*', array('cid'=>$this->data['cid']));
        $this->cid = $this->data['cid'];
    }

}

?>