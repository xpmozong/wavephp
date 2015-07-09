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
 * Wavephp Application i18n Class
 *
 * 多语言类
 *
 * @package         Wavephp
 * @subpackage      Web
 * @author          许萍
 *
 */

class i18n
{
    public static $lang         = 'zh-cn';
    protected static $_cache    = array();

    /**
     * i18n::get('许萍')
     * @return string
     *
     */
    public static function get($string, $lang = NULL)
    {
        if (!$lang) {
            $lang = i18n::$lang;
        }
        $table = i18n::load($lang);

        return isset($table[$string]) ? $table[$string] : $string;
    }

    /**
     * 对应语言数组
     */
    public static function load($lang)
    {
        if (isset(i18n::$_cache[$lang])) {
            return i18n::$_cache[$lang];
        }

        require Wave::app()->frameworkPath.'i18nModel.php';
        $model = new i18nModel();
        $i18n = $model->getLanguage($lang);

        return i18n::$_cache[$lang] = $i18n;
    }
}

if (!function_exists('__')) {
    function __($string, array $values = NULL) {
        $string = i18n::get($string);
        
        return empty($values) ? $string : strtr($string, $values);
    }
}