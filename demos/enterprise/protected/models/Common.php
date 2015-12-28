<?php
/**
 * 公共类
 */
class Common extends Model
{
    public function crc($u, $n = 36)
    {
        $u = strtolower($u);
        $id = sprintf("%u", crc32($u));
        $m = base_convert( intval(fmod($id, $n)), 10, $n);
        return $m{0};
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