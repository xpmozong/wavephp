<?php
/**
 * 文件类
 */
class FileClass
{
    
    public function rmdirs($dir){
        //error_reporting(0);    函数会返回一个状态,我用error_reporting(0)屏蔽掉输出
        //rmdir函数会返回一个状态,我用@屏蔽掉输出
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key => $val){
            if($val == '.' || $val == '..' || $val == '.svn'){

            }else {
                if(is_dir($dir.'/'.$val)){                            
                    if(@rmdir($dir.'/'.$val) == 'true'){

                    }else{
                        rmdirs($dir.'/'.$val);
                    }                   
                }else{  
                    unlink($dir.'/'.$val);
                }
            }
        }
    } 
}