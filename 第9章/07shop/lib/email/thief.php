<?php
 class Thief{

  // 需要得到数据的网址
  var $URL;
  // 需要分析的开始标记
  var $startFlag;
  //需要分析的结束标记
  var $endFlag;
  //存储图片的路径
  var $saveImagePath;
  //访问图片的路径
  var $imageURL;
  // 列表内容
  var $ListContent;
  //需要获得的图片路径
  var $ImageList;
  //存储的图片名称
  var $FileName;
  
  /**
  * 得到页面内容
  * @return String 列表页面内容
  */
  
  function getPageContent ()
  {                
   $pageContent = @file_get_contents( $this->URL );
   
   return $pageContent;
  }
 
  
  /**
  * 根据标记得到列表段
  * @param $content  页面源数据
  * @return String   列表段内容
  */
  
  function getContentPiece ( $content )
  {
   $content = $this->getContent( $content, $this->startFlag, $this->endFlag );
                                                     if(!$content)  $content=$this->cut ($content, $this->startFlag, $this->endFlag );
   return $content;
  }
  
  
  /**
  * 得到一个字符串中的某一部分
  * @param $sourceStr 源数据
  * @param $startStr 分离部分的开始标记
  * @param $endStart 分离部分的结束标记
  * @return boolean  操作成功返回true
  */
  
  function getContent ( $sourceStr, $startStr, $endStart )
  {
   $s = preg_quote( decode( $startStr ) );
   $e = preg_quote( decode( $endStart ) );
   $s = str_replace( " ", "[[:space:]]", $s );
   $e = str_replace( " ", "[[:space:]]", $e );
   $s = str_replace( "\r\n", "[[:cntrl:]]", $s );
   $e = str_replace( "\r\n", "[[:cntrl:]]", $e );

   preg_match_all( "@" . $s . "(.*?)". $e ."@is", $sourceStr, $tpl );

   $content = $tpl[1];
   $content = implode( "", $content );
   return $content;
  }
  
  function cut ( $sourceStr, $startStr, $endStr )
  {
                                                return  cut( $sourceStr ,decode( $startStr )  ,decode( $endStr) );
                                    }
  
  /**
  * 得到只含有连接和内容的列表数组
  * @param $sList  页面列表源数据
  * @return array  列表段内容
  */
  
  function getSourceList ( $sList )
  {
   preg_match_all( "/<a[[:space:]](.*?)<\/a>/i", $sList, $list );

   $list = $list[0];
//foreach($list as $l) echo $l;
                                                     if(!$list || !is_array($list)){
                                                                   return $this->getSourceListExtend($sList); 
                                                     }else{
                                   return $this->getList ( $list );
                                                     }
                                                     
  }
 
                                   function getSourceListExtend($sList)
                                   {
                                                  $content=explode("</a>",$sList);
                                                  for($i=0;$i<count($content)-1;$i++)
                                                  {
                                                           $lists=explode("<a",$content[$i]);
                                                           $list[]=$lists[1];
                                                  }

                                                           return $this->GetListExtend( $list );
                                   }
 
  /**
  * 得到列表内容
  * @param $list  列表段内容
  * @return array  含有标题和连接的数组
  */
  
  function getList ( $list )
  {
   for ( $i = 0; $i < count( $list ); $i++ )
   {                
    //title
    preg_match_all( "/>(.*?)<\/a>/i", $list[$i], $templ );

    //content
    preg_match_all( "/href=(\"|'|)(.*?)(\"|'|)/i", $list[$i], $tempc );
    
    //获取的数据正确
    if( !empty( $templ[1][0] ) && !empty( $tempc[2][0] ) )
    {
     if( 0 == strpos( $tempc[2][0], "/" ) )
     {
      preg_match( "@http://(.*?)/@i", $this->URL, $url );
      $tempc[2][0] = substr( $url[0], 0, strlen( $url[0] ) - 1 ) . $tempc[2][0];
     }
     
     $listContent[$i][0] = $templ[1][0];
      $listContent[$i][1] = $tempc[2][0];
    }
                                                     }
                                                     if(!$listContent || !is_array($listContent)){
                                                               return $this->GetListExtend ( $list );
                                                     }else{
             return $listContent;
                                                     }
  }

  function GetListExtend ( $list )
  {                  
                                                     $list=str_replace("\"","",$list);
                                                     $list=str_replace("'","",$list);
                                                     $list=str_replace("=","",$list);
   for ( $i = 0; $i <count( $list ); $i++ )
   {
    //content
    $temp_link=$this->cut($list[$i],"href"," ");
                                                                       echo $temp_link."<br>";
    //title 
                                                                       if(eregi(">",$list[$i])){
                                                                              $temp_title=substr(strrchr($list[$i], ">"), 1 ); 
                                                                              $temp_title=preg_replace( "@\<(.*?)\>@is","",$temp_title);
                                                                              $temp_title=str_replace( ">","",$temp_title);
                                                                              $temp_title=str_replace( "<","",$temp_title);                                                                             
                                                                              if(!$temp_title)   $temp_title=$list[$i] ;
                                                                               $temp_title=preg_replace( "@\<(.*?)\>@is","",$temp_title);
                                                                               $temp_title=str_replace( ">","",$temp_title);
                                                                               $temp_title=str_replace( "<","",$temp_title);      
                                                                                echo $temp_title."<br>";
                                                                       }else{
                                                                             $temp_title=$list[$i];       
                                                                             $temp_title=preg_replace( "@\<(.*?)\>@is","",$temp_title);
                                                                              $temp_title=str_replace( ">","",$temp_title);
                                                                              $temp_title=str_replace( "<","",$temp_title);  
                                                                              echo $temp_title."<br>";
                                                                       }
    //获取的数据正确
    if( !empty( $temp_link ) && !empty( $temp_title) )
    {
     if( 0 == strpos( $tempc[2][0], "/" ) )
     {
      preg_match( "@http://(.*?)/@i", $this->URL, $url );
      $temp_link = substr( $url[0], 0, strlen( $url[0] ) - 1 ) . $temp_link;
     }
     
     $listContent[$i][0] = trim($temp_title);
     $listContent[$i][1] = $temp_link;
    }
                                                     }
   return $listContent;

                                   }


  /**
  * 得到正文中的图片路径信息
  * @param $content 正文信息
  * @return array  信息中图片路径的数组
  */
  
  function getImageList ( $content )
  {
   preg_match_all( "/src=(\"|')(.*?)(\"|')/i", $content, $temp );
   
   $imageList = $temp[2];
   return array_unique($imageList);
  }
  
  
  /**
  * 下载图片时将页面中的路径替换成新的路径
  * @param $content  需要替换路径的页面内容
  * @return String   替换后的页面内容
  */
  
  function replaceImageParh ( $content )
  {
   for ( $i = 0; $i < count( $this->ImageList ); $i++ )
   {
                                                                      if($this->FileName[$i]){
                  $content = str_replace( $this->ImageList[$i], $this->imageURL.$this->FileName[$i], $content );
                                                                      }else{     
                                                                                    //$s=" /src=(\\\"|')".preg_quote($this->ImageList[$i])."(\\\"|')/i";
                  $content = str_replace($this->ImageList[$i], $GLOBALS[SET][webpath]."images/nopic.gif", $content );
                                                                      }
   }
   
   return $content;
  }
  
  
  /**
  * 下载图片时读取图片文件后存储在相应路径
  * @param $imageURL 需要读取的图片文件
  * @return boolean  操作成功返回true
  */
  
  function saveImage ( $imageURL )
  {
   
   for ( $i = 0; $i < count( $imageURL ); $i++ )
   {
    $fName = $this->saveFile( $imageURL[$i] );
    if( !empty( $fName ) )
    {                
     $filename[$i] = $fName;
    }
   }
   
   return $filename;
  }
  
  
  function saveFile( $fileName )
  {
   
   $s_filename = basename( $fileName );
   $ext_name = strtolower( strrchr( $s_filename, "." ) );
   
   if( ( ".jpg" && ".gif" && ".swf" ) != strtolower( $ext_name ) )
   {
    return "";
   }
   
   
   if( 0 == strpos( $fileName, "/" ) )
   {
    preg_match( "@http://(.*?)/@i", $this->URL, $url );
    $url = $url[0];
   }
   
   if( 0 == strpos( $fileName, "." ) )
   {
    $url = substr( $this->URL, 0, strrpos( $fileName, "/" ) );
   }
   
   $contents = @file_get_contents( $url . $fileName );

   $s_filename = time(). rand( 1000, 9999 ) . $ext_name;
   
   //file_put_contents( $this->saveImagePath.$s_filename, $contents );
   
   $handle = @fopen ( $this->saveImagePath.$s_filename, "w" );
   @fwrite( $handle, $contents );
   @fclose($handle);
   if(filesize($this->saveImagePath.$s_filename)>3072){
             return $s_filename;
                                                     }else{
                                                               @unlink($this->saveImagePath.$s_filename);
             return "";
                                                    }
   
  }
  
  /**
  * 不下载图片则格式化其路径为绝对路径
                                   * 不能格式化变态路径 Eg: ./../  or /./../ 一类的  不过不影响结果
  * @param $imageURL 需要读取的图片文件
  * @return $filename  返回格式化的图片路径
  */
                                   function  ToPath($imageURL)
                                   {
                                                     $PathArray=parse_url($this->URL);
                                                     $webpath=$PathArray[scheme]."://".$PathArray[host] ;
                                                     $filepath=$PathArray[path] ;
                                           for ( $i = 0; $i < count( $imageURL ); $i++ )
   {
                                                                if( substr( $imageURL[$i] ,0,1 )== '/' ){
                                                                             $filename[$i] =$webpath.$imageURL[$i];
                                                                }elseif( substr( $imageURL[$i] ,0,2 )== './' ){
                                                                             $filename[$i] =$webpath.$filepath.substr( $imageURL[$i] ,1, strlen( $imageURL[$i]) );
                                                                }elseif( substr( $imageURL[$i] ,0,3 )== '../' ){
                                                                             $index=strrchr($filepath,"/");
                                                                             $filename[$i] =$webpath.substr($filepath,0,$index).substr($imageURL[$i] ,2, strlen( $imageURL[$i]));
                                                                }elseif(substr( $imageURL[$i] ,0,4)== 'http'){
                                                                             $filename[$i] =$imageURL[$i] ;
                                                                }else{
                                                                
                                                                }
   }
   
   return $filename;                     

                                   }

  /**
  * 不下载图片时将页面中的路径替换成新的路径
  * @param $content  需要替换路径的页面内容
  * @return String   替换后的页面内容
  */
                                  function ImgPathReplace( $content ) 
                                  {
   for ( $i = 0; $i < count( $this->ImageList ); $i++ )
   {
    $content = str_replace( $this->ImageList[$i], $this->FileName[$i], $content );
   }
   
   return $content;                
                                  }    
 
  function setURL ( $u )
  {
   $this->URL = $u;
   return true;
  }
  
  function setStartFlag ( $s )
  {
   $this->startFlag = $s;
   return true;
  }
  
  function setEndFlag ( $e )
  {
   $this->endFlag = $e;
   return true;
  }
  
  function setSaveImagePath ( $p )
  {
   $this->saveImagePath = $p;
   return true;
  }
  
  function setImageURL ( $i )
  {
   $this->imageURL = $i;
   return true;
  }
  
  
 }

?>