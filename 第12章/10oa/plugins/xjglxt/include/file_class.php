<?php
class  File_class  {  
 
           var  $file;          
           var  $index;      
 
           //  ���������ļ���������  
           function  getlines()  {  
                       $f=file($this->file);          
                       return  count($f);          
           }  

           //  �������ļ�---��һά���鷵���ļ�����  
           function  read_file()  {  
                       if  (file_exists($this->file))  {  
                                   $line  =file($this->file);  
                       }  
                       return  $line;  
           }  
}  
?>