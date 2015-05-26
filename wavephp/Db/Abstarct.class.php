<?php

abstract class Abstarct{
    
    /**
     * 解析过滤
     *
     * @param string $str   : 条件数组
     *
     * @return bool
     *
     */
    function _parse($str) {
        $str = trim($str);
        if (!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
            return false;
        }

        return true;
    }

    /**
     * 查询条数
     *
     * @param int $offset   : 第几条
     * @param int $limit    : 多少条数据
     * 
     * @return $this
     *
     */
    public function limit($offset, $limit) {
        return $this->_limit($offset, $limit);
    }

    /**
     * 字符串转义
     *
     * @param string $str   : 字符串
     *
     */
    public function escape($str) {
        switch (gettype($str)) {
            case 'string'   :   $str = "'".$this->escape_str($str)."'";
                break;
            case 'boolean'  :   $str = ($str === FALSE) ? 0 : 1;
                break;
            default         :   $str = ($str === NULL) ? 'NULL' : $str;
                break;
        }

        return $str;
    }


}


?>