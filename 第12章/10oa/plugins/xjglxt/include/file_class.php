<?php
class  File_class  {  
 
           var  $file;          
           var  $index;      
 
           //  返回数据文件的总行数  
           function  getlines()  {  
                       $f=file($this->file);          
                       return  count($f);          
           }  

           //  打开数据文件---以一维数组返回文件内容  
           function  read_file()  {  
                       if  (file_exists($this->file))  {  
                                   $line  =file($this->file);  
                       }  
                       return  $line;  
           }  
}  
?>