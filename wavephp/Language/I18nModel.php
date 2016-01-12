<?php
/**
 * PHP 5.0 以上
 * 
 * @package         Wavephp
 * @author          许萍
 * @copyright       Copyright (c) 2013
 * @link            https://github.com/xpmozong/wavephp
 * @since           Version 1.0
 *
 */

/**
 * Wavephp Application I18n Class
 *
 * 多语言模型类
 *
 * @package         Wavephp
 * @subpackage      I18n
 * @author          许萍
 *
 */
class I18nModel extends Model
{
    protected function init() 
    {
        $this->_tableName = 'w_language';
    }

    /**
     * 创建表
     */
    public function table()
    {
        $dbName = Wave::app()->config['database']['master']['dbname'];
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='$dbName' and TABLE_NAME='".$this->_tableName."'";
        $res = $this->queryOne($sql);
        if (empty($res['TABLE_NAME'])) {
            $sql = "CREATE TABLE `w_language` (
              `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '语言id',
              `lang_code` varchar(50) NOT NULL DEFAULT '' COMMENT '语言编码',
              `lang_key` int(11) NOT NULL COMMENT '翻译项',
              `lang_value` varchar(255) NOT NULL DEFAULT '' COMMENT '翻译内容',
              PRIMARY KEY (`id`),
              UNIQUE KEY `lang_index` (`lang_value`,`lang_code`,`lang_key`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 
            DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT 
            COMMENT='多语言翻译项';";
            $this->sqlQuery($sql);
        }
    }

    /**
     * 获得对应多语言数组
     * @param string $lang 语言类型
     * @return array
     *
     */
    public function getLanguage($lang)
    {
        $i18n = array();
        $dir = Wave::app()->projectPath.'data/caches/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $filepath = $dir.'language_'.$lang.'.php';
        if (!is_file($filepath)) {
            $zhnew = array();
            $zh = $this ->where(array('lang_code'=>'zh-cn'))
                        ->getAll('lang_key,lang_value');
            
            foreach ($zh as $key => $val) {
                $zhnew[$val['lang_key']] = $val['lang_value'];
            }

            $foreign = $this->where(array('lang_code'=>$lang))
                            ->getAll('lang_key,lang_value');
            foreach ($foreign as $key => $val ) {
                $zhcn = $zhnew[$val['lang_key']];
                $i18n[$zhcn] = $val['lang_value'];
            }

            $cache = var_export($i18n, true);
            $content = "<?php defined('Application')";
            $content .= "or die('No direct script access.');\n";
            $content .= "return $cache ?>";
            Wave::writeCache($filepath, $content);

        }else{
            $i18n = require $filepath;
        }

        return $i18n;
    }
}
?>