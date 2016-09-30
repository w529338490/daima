<?php
/*
凤鸣山中小学网络办公室
*/
class  File_class  {  
 
           var  $file;          
           var  $index;      
 

           //  返回数据文件的总行数  
           function  getlines()  {  
                       $f=file($this->file);          
                       return  count($f);          
           }  

           //  打开数据文件---以一维数组返回一行文件内容  
           function  read_file()  {  
                       if  (file_exists($this->file))  {  
                              $line=file($this->file);  
                       }  
                       return  $line;  
           } 
           //操作一行中的文件内容已制表符进行分割并取出数据放入一维数组中 
           function read_array($line){
           	  $line=explode("\t", $line);
           	  return $line;
           }	  
}

?>