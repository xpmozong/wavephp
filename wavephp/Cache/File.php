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
 * Wavephp Application File Class
 *
 * File类
 *
 * @package         Wavephp
 * @subpackage      Cache
 * @author          许萍
 *
 */
class File 
{
    /**
     * 写入文件
     * @param string file    文件全路径
     * @param string content 文件内容
     * @param string mod     文件打开模式
     * @return void
     */
    public static function write($file, $contents, $mod = 'w') 
    {
        $fp = fopen($file, $mod);
        flock($fp, LOCK_EX);
        fwrite($fp, $contents);
        flock($fp, LOCK_UN);
        fclose($fp);
    }
    
    /**
     * 递归创建文件目录
     * @param string dir 文件目录
     * @param int    mod 目录权限
     * @return bool
     */
    public static function mkdirs($dir, $mod = 0755) 
    {
        if (!is_dir($dir)) {
            self::mkdirs(dirname($dir), $mod);
            return mkdir($dir, $mod);
        }
    }
    
    /**
     * 读取文件内容
     * @param string file 文件路径
     * @return bool/string
     */
    public static function read($file) 
    {
        return @file_get_contents($file);
    }
    
    /**
     * 下载文件
     * @param string file 文件目录
     * @param string filename 文件名称
     * @return void
     */
    public static function download($file, $filename = '') 
    {
        if (!is_file($file)) {
            exit('the '.$file.' is not found.');
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $filename = $filename == '' ? basename($file) : $filename;
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename='.urlencode($filename));
        } elseif (preg_match("/Firefox/", $ua)) {
            header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename='.$filename);
        }
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
    }

    /**
     * 获取附件类型
     */
    public static function getType($type) 
    {
        if (is_numeric($type)) {
            $typeid = $type;
        } else {
            if (preg_match("/\.(jpg|jpeg|gif|png|bmp)$/", $type)) {
                $typeid = 1;
            } elseif (preg_match("/\.(swf|fla|flv|swi)$/", $type)) {
                $typeid = 2;
            } elseif (preg_match("/\.(html|js|css)$/", $type)) {
                $typeid = 3;
            } elseif (preg_match("/\.(txt|chm|doc|docx)$/", $type)) {
                $typeid = 4;
            } elseif (preg_match("/\.(zip|tar|gz)$/", $type)) {
                $typeid = 5;
            } else {
                $typeid = 0;
            }
        }
        return $typeid;
    }

    /**
     * 友好格式显示文件大小
     */
    public static function getSize($filesize) 
    {
        if (is_file($filesize)) {
            $filesize = filesize($filesize);
        }
        if ($filesize >= 1073741824) {
            $filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
        } elseif ($filesize >= 1048576) {
            $filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
        } elseif ($filesize >= 1024) {
            $filesize = round($filesize / 1024 * 100) / 100 . ' KB';
        } else {
            $filesize = $filesize . ' Bytes';
        }
        return $filesize;
    }
}
?>