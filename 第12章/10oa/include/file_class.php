<?php
/*
����ɽ��Сѧ����칫��
*/
class  File_class  {  
 
           var  $file;          
           var  $index;      
 

           //  ���������ļ���������  
           function  getlines()  {  
                       $f=file($this->file);          
                       return  count($f);          
           }  

           //  �������ļ�---��һά���鷵��һ���ļ�����  
           function  read_file()  {  
                       if  (file_exists($this->file))  {  
                              $line=file($this->file);  
                       }  
                       return  $line;  
           } 
           //����һ���е��ļ��������Ʊ�����зָȡ�����ݷ���һά������ 
           function read_array($line){
           	  $line=explode("\t", $line);
           	  return $line;
           }	  
}

?>