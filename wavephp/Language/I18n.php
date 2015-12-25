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
 * 多语言类
 *
 * @package         Wavephp
 * @subpackage      I18n
 * @author          许萍
 *
 */

class I18n
{
    public static $lang         = 'zh-cn';
    protected static $_cache    = array();

    /**
     * I18n::get('许萍')
     * @return string
     *
     */
    public static function get($string, $lang = NULL)
    {
        if (!$lang) {
            $lang = I18n::$lang;
        }
        $table = I18n::load($lang);

        return isset($table[$string]) ? $table[$string] : $string;
    }

    /**
     * 对应语言数组
     */
    public static function load($lang)
    {
        if (isset(I18n::$_cache[$lang])) {
            return I18n::$_cache[$lang];
        }
        
        $model = new I18nModel();
        $I18n = $model->getLanguage($lang);

        return I18n::$_cache[$lang] = $I18n;
    }
}

if (!function_exists('__')) {
    function __($string, array $values = NULL) {
        $string = I18n::get($string);
        
        return empty($values) ? $string : strtr($string, $values);
    }
}
?>