<?php
/**
 * 静态化类
 */
class StaticHtml
{
    /**
     * 有更改要删除要缓存文件夹 这样就会重新生成
     */
    public function deleteCacheDir($dir)
    {
        // 删除目录下的文件
        $dh = opendir($dir);

        while ($file = readdir($dh)) {
            if($file != '.' && $file != '..') {
                $fullpath = $dir.'/'.$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                }else {
                    $this->deleteCacheDir($fullpath);
                }
            }
        }

        return closedir($dh);
    }

    /** 
     * 循环创建目录
     * 
     * @param string $dir 文件夹
     * @param $mode 文件夹权限
     * @return bool
     * 
     */ 
    public function mk_dir($dir, $mode = 0777) 
    { 
        if($dir == '') return true;
        if (is_dir($dir) || @mkdir($dir,$mode)) return true; 
        if (!$this->mk_dir(dirname($dir),$mode)) return false;

        return @mkdir($dir,$mode); 
    } 

    /**
     * 页面静态化
     * 
     * @param string $file_name  
     * @param string $content
     * @return bool
     * 
     */
    public function makeHtmlFile($filedir = 'html', $file_name, $content)
    {
        $dir = Wave::app()->projectPath;
        $filedir = $dir.$filedir.'/';
        //目录不存在就创建
        if (!file_exists($filedir.$file_name)){
            $this->mk_dir($filedir);
        }
        if(!$fp = fopen($filedir.$file_name, "w+", true)){
            echo '文件打开失败！';
            return false;
        }
        if(!fwrite($fp, $content)){
            echo '文件写入失败！';
            return false;
        }
        fclose($fp);
        if(chmod($filedir.$file_name,0777)){
            return true;
        }else{
            echo '改变文件权限失败！';
            return false;
        }   
    }

    /**
     * 是否有这个文件
     * 
     * @param string $file_name
     * @return bool
     *
     */
    public function isHtmlFile($filedir, $file_name) {
        $dir = Wave::app()->projectPath;
        $filedir = $dir.$filedir.'/';
        $filepath = $filedir.$file_name;
        if (file_exists($filepath)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除静态文件
     * 
     * @param string $file_name
     * @return bool
     *
     */
    public function delHtmlFile($filedir, $file_name)
    {
        $dir = Wave::app()->projectPath;
        $filedir = $dir.$filedir.'/';
        $filepath = $filedir.$file_name;
        if (file_exists($filepath)) {
            return unlink($filepath);
        }

        return false;
    }
}
?>