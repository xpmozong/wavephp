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
        $where = '';
        $this->category = array();
        if ($cid != 0) {
            $where .= " AND a.cid='$cid'";
            $this->category = $this->Common->getOneData('category',
                            '*', 'cid', $cid);
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($page - 1) * $pagesize;

        $this->list = $this->Common->getJoinDataList('articles a', 
        'a.aid,a.title,a.add_date,c.c_name', $start, 
        $pagesize, 'category c', 'a.cid=c.cid', 
        "1=1 $where", 'a.aid DESC');
    
        $count = $this->Common->getFieldWhereCount('articles a', "1=1 $where");

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
        $this->data = $this->Common->getOneData('articles', '*', 'aid', $aid);
        $this->category = $this->Common->getOneData('category', '*', 
                                    'cid', $this->data['cid']);
        $this->cid = $this->data['cid'];
    }

}

?>