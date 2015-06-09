<?php
/**
 * 网站默认入口控制层
 */
class NewsController extends Controller
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
        $Common = new Common();
        $data = $Common->getFilter($_GET);
        $cid = (int)$cid;
        $where = '';
        $category = array();
        if ($cid != 0) {
            $where .= " AND a.cid='$cid'";
            $category = $Common->getOneData('category', '*', 'cid', $cid);
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pagesize = 15;
        $start = ($page - 1) * $pagesize;

        $list = $Common->getJoinDataList('articles a', 
        'a.aid,a.title,a.add_date,c.c_name', $start, $pagesize, 'category c', 'a.cid=c.cid', 
        "1=1 $where", 'a.aid DESC');
    
        $count = $Common->getFieldWhereCount('articles a', "1=1 $where");

        $url = 'http://'.Wave::app()->request->hostInfo.$_SERVER['REQUEST_URI'];
        if(empty($data['page'])){
            $url .= '?page=1';
        }
        $pagebar = $Common->getPageBar($url, $count, $pagesize, $page);

        $render = array('list'      => $list,
                        'page'      => $page,
                        'category'  => $category,
                        'pagebar'   => $pagebar, 
                        'cid'       => $cid);
        $links = $Common->getFieldList('links', '*', 'lid desc');
        $this->render('layout/header');
        $this->render('news/index', $render);
        $this->render('layout/footer', array('links'=>$links));
    }

    /**
     * 文章详情
     */
    public function actionArticle($aid)
    {
        $aid = (int)$aid;
        $Common = new Common();
        $data = $Common->getOneData('articles', '*', 'aid', $aid);
        $category = $Common->getOneData('category', '*', 'cid', $data['cid']);
        $render = array('data' => $data,'category' => $category, 'cid' => $data['cid']);
        $links = $Common->getFieldList('links', '*', 'lid desc');
        $this->render('layout/header');
        $this->render('news/article', $render);
        $this->render('layout/footer', array('links'=>$links));
    }

}

?>