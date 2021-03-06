<?php
/*
凤鸣山中小学网络办公室
*/
//计算页面执行时间
class timer 
{ 
    var $StartTime = 0; 
    var $StopTime = 0; 
 
    function get_microtime() 
    { 
        list($usec, $sec) = explode(' ', microtime()); 
        return ((float)$usec + (float)$sec); 
    } 
 
    function start() 
    { 
        $this->StartTime = $this->get_microtime(); 
    } 
 
    function stop() 
    { 
        $this->StopTime = $this->get_microtime(); 
    } 
 
    function spent() 
    { 
        return round(($this->StopTime - $this->StartTime) * 1000, 1); 
    } 
 
}  
/** * 截取中文部分字符串 
* 
* 
截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码 
* 
* @access public 
* @param string    $string 要处理的字符串 
* @param int       $strlen 要截取的长度默认为10 
* @param string    $other  是否要加上省略号,默认会加上 
* @return string   $s 
*/ 
function cnSubStr($string,$sublen=10,$other="..") { 
if($sublen>=strlen($string)) { return $string; } 
$s=""; 
for($i=0;$i<$sublen;$i++) { 
	  if(ord($string{$i})>127) { 
           $s.=$string{$i}.$string{++$i}; 
           continue; 
           }else{ 
           	    $s.=$string{$i}; continue; 
           	    } 
    } 
$s.=$other; 
return $s; 
}

/**
* 分页设置函数
*
* 分页函数，分类里面的所有文章按照某个量进行分页
*
* @access public
* @param string    $results    文章总量
* @param int       $address    url
* @global int      $perpage    当前页码
* @global int      $pagenumber 每页文章数
* @global int      $pagenavepages  页码显示数     
* @return string   $pagenav
*/
function getpagenav($results,$address) {
	global $perpage,$pagenumber,$pagenavpages;

	if ($results <= $perpage) {
		return "";
	}
    
	$totalpages = ceil($results/$perpage);                                   
	if ($pagenumber>1) {
		$prevpage = $pagenumber-1;
		$prevlink="<a href=\"$address&pagenumber=$prevpage\" title=\"上一页\" class=a>&laquo;</a>";    

	}
	if ($pagenumber<$totalpages) {
		$nextpage = $pagenumber+1;
		$nextlink="<a href=\"$address&pagenumber=$nextpage\" title=\"下一页\" class=a>&raquo;</a>";
	}
	while ($curpage++<$totalpages) {
		if ( ( $curpage <= $pagenumber-$pagenavpages || $curpage >= $pagenumber+$pagenavpages ) && $pagenavpages!=0 ) {
			if ($curpage==1) {
				$firstlink="<a href=\"$address&pagenumber=$curpage\" title=\"第一页\" class=a>&laquo; 第一页</a> ..."; 
			}
		    if ($curpage==$totalpages) {
				$lastlink="... <a href=\"$address&pagenumber=$curpage\" title=\"最末页\" class=a>最末页 &raquo;</a> ";               
			}
		} else {
			if ($curpage==$pagenumber) {
				$pagenav .="[$curpage] "; 
			} else {
			$pagenav .= "<a href=\"$address&pagenumber=$curpage\" class=a>$curpage</a> ";
			}
		}
	}
	$pagenav="共 $totalpages 页文章 <b> $firstlink $prevlink $pagenav $nextlink $lastlink </b>   20篇文章/页 "; 
//	$pagenav="总页数 ($totalpages): <b> $firstlink $prevlink $pagenav $nextlink $lastlink </b>";           
	return $pagenav;

}
/**
* 摸版输出函数
*
* 将生成的网页最终直间输出到网页
*
* @access public
* @param string    $vartext   要处理的内容
* @param int       $sendheader 参数默认韦1
*/
function dooutput($vartext,$sendheader=1) {
	global $showtime,$timer;
//$vartext=dovars($vartext,$sendheader);
if ($showtime) {
	$timer->stop();
  $vartext.="<br><center>页面执行时间：".$timer->spent()."毫秒</center>";
  
}  
echo $vartext;
flush();

}
//cache
/**
* 数据cache函数
*
* 数据缓存函数，将比较费时的数据生成以后缓存到数据库中，
*
* @access public
* @param string    $vartext    要处理的内容
* @param int       $cachename  被缓存的内容标题
*/
function docache($vartext,$cachename) {
global $db;

//$vartext=dovars($vartext,$sendheader);
$content=addslashes($vartext);
$sql="select * from cache where `cachename`='$cachename' order by cacheid limit 1";
$dd=$db->query($sql);
if ($temp=$db->fetch_array($dd))
{$sql="UPDATE `cache` SET `cachecont` = '$content' WHERE `cachename` = '$cachename' ";
$db->query($sql);
}
else
{
$sql="INSERT INTO `cache` (`cachename` , `cachecont` ) VALUES ('$cachename', '$content'); ";
$db->query($sql);
}
}
/**
* 内容cache函数
*
* 将数据库中的cache一次行输出到数据中，作缓存
*
* @access public
* @param string     $cacheeslist      $cache列
* @global array     $ecache           存放cache数组
* @global class     $db               数据库操作类   
* @return string
*/
function cachelist($cachelist) {
  // $templateslist: comma delimited list
  global $cache,$db;

  // add in sql info
  //$templateslist=str_replace(",","' OR title='",$templateslist);
  $cachelist=str_replace(',', "','", addslashes($cachelist));

  // run query
  $temps=$db->query("SELECT cachename,cachecont
                          FROM template
                          WHERE cachename IN ('$cachelist')
                            AND ORDER BY cacheid");

  // cache templates
  while ($temp=$db->fetch_array($temps)) {
    $cache["$temp[cachename]"]=$temp['cachecont'];
  }
  unset($temp);
  $db->free_result($temps);
}

/**
* 获取cache生成函数
*
* 将数据库中存放的模板输出到变量中
*
* @access public
* @param  string    $cachename        要处理的$cachename名称
* @global array     $cache            存放cache数组
* @global class     $db               数据库操作类
* @return string    $cachecont
*/
function getcache($cachename) {
  // gets a template from the db or from the local cache
  global $cache,$db;
  if (isset($cache[$cachename])) {
    $cachecont=$cache[$cachename];
  } else {
    $sql="SELECT cachecont FROM cache WHERE cachename='".addslashes($cachename)."' ORDER BY cacheid DESC LIMIT 1";
    $gettemp=$db->query_first($sql);
    $cachecont=$gettemp[cachecont];
    $cache[$cachename]=$cachecont;
 }

  return $cachecont;
}

/**
* 变量替换函数
*
* 将模板中的变量进行替换
*
* @access public
* @param string    $newtext    要处理的数据
* @param int       $sendheader 参数 默认 1
* @return string   $newtext
*/
function dovars($newtext,$sendheader=1) {
  // parses replacement vars

  global $db,$replacementsetid,$gzipoutput,$gziplevel,$newpmmsg;
  static $vars;

  if (connection_status()) {
    exit;
  }

  if (!isset($vars)) {
    $vars=$db->query("SELECT findword,replaceword FROM replacement WHERE replacementsetid IN(-1,'" . intval($replacementsetid) . "') ORDER BY replacementsetid DESC,replacementid DESC");
  } else {
    $db->data_seek(0,$vars);
  }

  while ($var=$db->fetch_array($vars)) {
    if ($var['findword']!="") {
      $newtext=str_replace($var['findword'],$var['replaceword'],$newtext);
    }
  }

  global $PHP_SELF;

  if ($newpmmsg) {
    if (substr($PHP_SELF,-strlen('private.php'))=='private.php') {
    } else {
      $newtext=preg_replace("/<body/i","<body onload=\"Javascript:confirm_newpm()\"",$newtext);
    }
  }

  if ($gzipoutput and !headers_sent()) {
    $newtext=gzipoutput($newtext,$gziplevel);
  }

  if ($sendheader) {
    @header("Content-Length: ".strlen($newtext));
  }
 
  return $newtext;
}



/**
* iif
*
* if 函数
*
* @access public
* @param int      $expression    是否为真
* @param string   $returntrue    为真则返回 此变量值
* @param string   $returnfalse   为否则返回 此变量值
* @return string
*/
function iif ($expression,$returntrue,$returnfalse) {

  if ($expression==0) {
    return $returnfalse;
  } else {
    return $returntrue;
  }

}

/**
* 摸版cache函数
*
* 将网页中的模板一次行输出到数据中，作缓存
*
* @access public
* @param string    $templateslist  模板列，如"index,footer,head"
* @global array     $templatecache    存放模板cache数组
* @global class     $db               数据库操作类
* @global int       $templatesetid    模板套系      
* @return string
*/
function cachetemplates($templateslist) {
  // $templateslist: comma delimited list
  global $templatecache,$db,$templatesetid;

  // add in sql info
  //$templateslist=str_replace(",","' OR title='",$templateslist);
  $templateslist=str_replace(',', "','", addslashes($templateslist));

  // run query
  $temps=$db->query("SELECT template,title
                          FROM template
                          WHERE title IN ('$templateslist')
                            AND templatesetid=$templatesetid
                           ORDER BY templatesetid");

  // cache templates
  while ($temp=$db->fetch_array($temps)) {
    $templatecache["$temp[title]"]=$temp['template'];
  }
  unset($temp);
  $db->free_result($temps);
}

/**
* 摸版生成函数
*
* 将数据库中存放的模板输出到变量中
*
* @access public
* @param  string    $templatename   要处理的模板名称
* @global array     $templatecache    存放模板cache数组
* @global class     $db               数据库操作类
* @global int       $templatesetid    模板套系  
* @return string    $template
*/
function gettemplate($templatename,$escape=1,$gethtmlcomments=1) {
  // gets a template from the db or from the local cache
  global $templatecache,$db,$templatesetid,$addtemplatename;

  if (isset($templatecache[$templatename])) {
    $template=$templatecache[$templatename];
  } else {
    $sql="SELECT template FROM template WHERE title='".addslashes($templatename)."' AND templatesetid='$templatesetid' ORDER BY templatesetid DESC LIMIT 1";
    $gettemp=$db->query_first($sql);
    $template=$gettemp[template];
    $templatecache[$templatename]=$template;
 }

  if ($escape==1) {
    $template=addslashes($template);
    $template=str_replace("\\'","'",$template);
  }
  if ($gethtmlcomments and $addtemplatename) {
    return "<!-- BEGIN TEMPLATE: $templatename -->\n$template\n<!-- END TEMPLATE: $templatename -->";
  }
  
  return $template;
}

/**
* 显示信息函数
*
* 信息显示函数
*
* @access public
* @param string    $message    输出的信息
* @param int       $url_forword 页面跳转的url
* @param string    $msgtype  判定是否是跳转或是信息确定
* @return string
*/
function showmessage($message, $url_forward = '', $msgtype = 'message') {
	if($msgtype == 'form') {
		$message = "<form method=\"post\" action=\"$url_forward\"><br><br><br>$message<br><br><br><br>\n".
        		"<input type=\"submit\" name=\"confirmed\" value=\"确 定\"> &nbsp; \n".
       			"<input type=\"button\" value=\"返 回\" onClick=\"history.go(-1);\"></form><br>";
	} elseif ($msgtype=="close"){
		    			$message .= "<br>浏览器将关闭";
			$message .= "<script>setTimeout(\"window.close();\", 1000);</script>";
	}else{
		if($url_forward) {
			$message .= "<br><a href=\"$url_forward\">如果您的浏览器没有自动跳转，请点击这里</a>";
			$message .= "<script>setTimeout(\"redirect('$url_forward');\", 2000);</script>";
		} elseif(strpos($message, "返回")) {
			$message .= "<a href=\"$url_forward\" >[ 点这里返回上一页 ]</a>";
		}
	}
        $message="
              <script language=JavaScript>
                     function redirect(url) {
	                   window.location.replace(url);
                     }
             </script>
            <body> 
           <table width='300'  border='0' cellpadding='1' cellspacing='1' bgcolor='#ffffff' align='center'>
            <tr align='center' bgcolor='#E5E5E5'>
               <td height='100' valign='middle'>$message</td>
            </tr>
          </table>
          <body>
          ";
        exit($message); 
}

/**
* 用户检测函数
*
* 对登入的用户进行检测
*
* @access public
* @param string    $message   输出的信息
* @param int       $referer   跳转的页面
* @return string
*/
function checkadmin($message,$referer=''){
global $user_id;
$referer='?filename=login&referer='.$referer;
$message=$message?$message:"请登录！";
if(!isset($user_id)){
showmessage($message,$referer);
exit();
}
}

/**
* 目录是否可写函数
*
* 目录是否可写函数
*
* @access public
* @param string    $dir    被检测的目录
* @return string
*/
function dir_writeable($dir) {
        if(!is_dir($dir)) {
        @mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.test", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.test");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

/**
* 目录复制
*
* 把目录复制到制定目录
*
* @access public
* @param string    $source       源目录
* @param string    $destination  目标目录
* @param int       $child=1      变量参数
* @return string
*/
function copydir($source,$destination,$child=1){ 
   if(!is_dir($destination)){ 
      mkdir($destination,0777); 
   }
   $dir=opendir($source); 
   while($entry=readdir($dir)) { 
     if($entry!="." && $entry!=".."){ 
       if(is_dir($source."/".$entry)){ 
           if($child)copydir($source."/".$entry,$destination."/".$entry,1); 
       }else{ 
          copy($source."/".$entry,$destination."/".$entry);
       } 
     } 
   } 
return 1; 
} 
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function file_write($filename,$content) { 
       if (@file_exists($filename) && !is_writable($filename)) {
           chmod($filename, 0777) or die("Cannot change the mode of file ".$filename);
       }
       $fp = @fopen($filename, "w") or die("Cannot open file ".$filename);
       fwrite($fp,$content) or die("Cannot write to file ".$filename);
       fclose($fp) or die("Cannot close file ".$filename);
}



/**文件大小转化
*
* 文件大小转化
*
* @access public
* @param string    $filesize    要处理的字符串

* @return string
*/
function sizecount($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' G';
	} elseif($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' M';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' K';
	} else {
		$filesize = $filesize . ' bytes';
	}
	return $filesize;
}
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function dirsize($dir) { 
	@$dh = opendir($dir);
	$size = 0;
	while ($file = @readdir($dh)) {
		if ($file != "." and $file != "..") {
			$path = $dir."/".$file;
			if (is_dir($path)) {
				$size += dirsize($path);
			} elseif (is_file($path)) {
				$size += filesize($path);
			}
		}
	}
	@closedir($dh);
	return $size;
}
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function getimages($string,$savepath){
        global $rootpath;
        createdir($savepath);
        $string=strtolower($string);
        $matches="/<img[^>]+src[[:space:]]*=[[:space:]]*(\"|\')?(http:\/\/[[:alnum:]][A-Za-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)(\"|\')?.*>/";
        if(preg_match_all($matches,$string,$outs,PREG_PATTERN_ORDER)){
                $result = array_unique($outs[2]);

                foreach($result as $imageurl){

                     if(!strstr($imageurl,$rootpath)){
                        $imagename=basename($imageurl);
                        $newname=$savepath."/".$imagename;
                        $imagespath[]=$rootpath."/".$newname;
                        $imagesurl[]=$imageurl;                       
                        $fp=@fopen($imageurl,"r");
                        $image=fread($fp,1000000000);
                        if(!empty($image)){
                                $fp=@fopen($newname,"w");
                                fwrite($fp,$image);
                        }
                        fclose($fp);
                    }
                }
        }

        if(is_array($imagesurl) && is_array($imagespath)){
            $string=str_replace($imagesurl,$imagespath,$string);
        }

        return $string;
}
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function splitsql($sql){
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query) {
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= $query[0] == "#" ? NULL : $query;
		}
		$num++;
	}
	return($ret);
}
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function sqldumptable($table, $startfrom = 0, $currsize = 0) {
	global $db, $multivol, $sizelimit, $startrow;

	$offset = 64;
	if(!$startfrom) {
		$tabledump = "DROP TABLE IF EXISTS $table;\n";

		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_row($createtable);

		$tabledump .= $create[1].";\n\n";
	}

	$tabledumped = 0;
	$numrows = $offset;
	while(($multivol && $currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) || (!$multivol && !$tabledumped)) {
		$tabledumped = 1;
		if($multivol) {
			$limitadd = "LIMIT $startfrom, $offset";
			$startfrom += $offset;
		}

		$rows = $db->query("SELECT * FROM $table $limitadd");
		$numfields = $db->num_fields($rows);
		$numrows = $db->num_rows($rows);
		while ($row = $db->fetch_row($rows)) {
			$comma = "";
			$tabledump .= "INSERT INTO $table VALUES(";
			for($i = 0; $i < $numfields; $i++) {
				$tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
				$comma = ",";
			}
			$tabledump .= ");\n";
		}
	}

	$startrow = $startfrom;
	$tabledump .= "\n";
	return $tabledump;
}
// ###################### 摸版生成函数 #######################
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function message($C_alert,$I_goback='') {
    if(!empty($I_goback)) {
        echo "<script>alert('$C_alert');window.location.href='$I_goback';</script>";
    } else {
        echo "<script>alert('$C_alert');</script>";
    }
}

/**
* 判断下拉菜音的选取项
*
* 可以判断字符串一和字符串二是否相等.从而使相等的项目在下拉菜单中被选择
*
* @access public
* @param string $str1  要比较的字符串一
* @param string $str2  要比较的字符串二
* @return string       相等返回字符串"selected",否则返回空字符串
*/
function selected($str1,$str2) {
    if($str1==$str2) {
        return ' selected';
    }
    return '';
}

/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function showtitle($str,$strlen=10,$other=true) {
    $j = 0;
    for($i=0;$i<$strlen;$i++)
      if(ord(substr($str,$i,1))>0xa0) $j++;
    if($j%2!=0) $strlen++;
    $rstr=substr($str,0,$strlen);
    if (strlen($str)>$strlen && $other) {$rstr.='...';}
    return $rstr;
}

/**
* 格式化用户评论
*
* @access public
* @param string
* @return void
*/
function clean_note($text) {
    $text = htmlspecialchars(trim($text));

    /* turn urls into links */
    $text = preg_replace("/((mailto|http|ftp|nntp|news):.+?)(&gt;|\s|\)|\"|\.\s|$)/","<a href=\"\1\">\1</a>\3",$text);

    /* this 'fixing' code will go away eventually. */
    $fixes = array('<br>', '<p>', '</p>');
    reset($fixes);
    while (list(,$f) = each($fixes)) {
        $text = str_replace(htmlspecialchars($f), $f, $text);
        $text = str_replace(htmlspecialchars(strtoupper($f)), $f, $text);
    }
    
    /* <p> tags make things look awfully weird (breaks things out of the <code>
       tag). Just convert them to <br>'s
    */
    $text = str_replace (array ('<P>', '<p>'), '<br>', $text);
    
    /* Remove </p> tags to prevent it from showing up in the note */
    $text = str_replace (array ('</P>', '</p>'), '', $text);

    /* preserve linebreaks */
    $text = str_replace("\n", "<br>", $text);

    /* this will only break long lines */
    if (function_exists("wordwrap")) {
        $text = wordwrap($text);
    }
    
    // Preserve spacing of user notes
    $text = str_replace("  ", " &nbsp;", $text);

    return $text;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function createdir($dir='')
{
        if (!is_dir($dir))
        {
            $temp = explode('/',$dir);
            $cur_dir = '';
            for($i=0;$i<count($temp);$i++)
            {
                $cur_dir .= $temp[$i].'/';
                if (!is_dir($cur_dir))
                {
                @mkdir($cur_dir,0777);
                @fopen("$cur_dir/index.htm","a");

                }
            }
        }
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function dhtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val);
		}
	} else {
		$string = str_replace('&', '&amp;', $string);
		$string = str_replace('"', '&quot;', $string);
		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);
		$string = preg_replace('/&amp;(#\d{3,5};)/', '&\\1', $string);
	}
	return $string;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function daddslashes($string, $force = 0) {
	if(!$GLOBALS['magic_quotes_gpc'] || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function url_rewriter($url, $tag = '') {
	global $sid;
	$tag = stripslashes($tag);
	if(!$tag || (!preg_match("/^(http:\/\/|mailto:|#|javascript)/i", $url) && !strpos($url, 'sid='))) {
		$pos = strpos($url, '#');
		if($pos) {
			$urlret = substr($url, $pos);
			$url = substr($url, 0, $pos);
		}
		$url .= strpos($url, '?') ? '&' : '?';
		$url .= "sid=$sid$urlret";
	}
	return $tag.$url;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function random($length) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function str_out($string) {
$string=stripslashes($string);
$string=str_replace(chr(13), "<BR>",$string);
$string=str_replace(" ", "&nbsp;",$string);
return $string;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function str_in($string) {
$string=daddslashes($string,'1');
return $string;
}
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function file_type($name,$types){

if(!eregi($types,$name))
return false;

$types=explode("|",$types);
for($i=0;$i<count($types);$i++){
if(eregi("$types[$i]$",$name)){
return $types[$i];
break;
}
}
}


/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $str    要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
* @return string
*/
function file_type_name($name){
$types='.jpg|.png|.gif|.bmp|';
$types=explode("|",$types);
for($i=0;$i<count($types);$i++){
if(eregi("$types[$i]$",$name)){
return $types[$i];
}
}
}
/**
* 读取随机数
*
* 默认为16为随机数
*
* @access public
* @param  int       length  随机数的长度
* @return string    $result
*/
function getcode ($length=16,$mode=1)
  {
  if ($mode==1){$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';}
  else if($mode==2){$str='abcdefghijklmnopqrstuvwxyz1234567890';}
   else {$str='1234567890';}
  $result = '';
  $l = strlen($str);
  for($i = 0;$i < $length;$i ++)
     {
      $num = rand(0, $l);
      $result .= $str[$num];
     }
  return $result;
  }
// ####################### 获取客户端IP #######################
function getip() {
	if (isset($_SERVER)) {
		if (isset($_SERVER[HTTP_X_FORWARDED_FOR])) {
			$realip = $_SERVER[HTTP_X_FORWARDED_FOR];
		} elseif (isset($_SERVER[HTTP_CLIENT_IP])) {
			$realip = $_SERVER[HTTP_CLIENT_IP];
		} else {
			$realip = $_SERVER[REMOTE_ADDR];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$realip = getenv( "HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	return $realip;
}
// ####################### 后台成功登录记录 #######################
function loginsucceed($username="",$password="") {
	global $db,$table_loginlog;
	$extra .= "\nScript: ".getenv("REQUEST_URI");
	$db->query("INSERT INTO $table_loginlog (username,password,date,ipaddress,result) VALUES
	('".$username."','密码正确','".time()."','".getip()."','1')");
}

// ####################### 后台失败登录记录 #######################
function loginfaile($username="",$password="") {
	global $db,$table_loginlog;
	$extra .= "\nScript: ".getenv("REQUEST_URI");
	$db->query("INSERT INTO $table_loginlog (username,password,date,ipaddress,result) VALUES
	('".$username."','密码错误','".time()."','".getip()."','2')");
}

// ####################### 后台管理记录 #######################
function getlog() {
	global $db,$table_adminlog;
	if (isset($_POST[action])) {
		$action = $_POST[action];
	} elseif (isset($_GET[action])) {
		$action = $_GET[action];
	}
	if (isset($action)) {
		$script = "".getenv("REQUEST_URI");
		$db->query("INSERT INTO $table_adminlog (action,script,date,ipaddress) VALUES ('".htmlspecialchars(trim($action))."','".htmlspecialchars(trim($script))."','".time()."','".getip()."')");
	}
}
/**
* 客户数据的读取至浏览器中--方法一
*
* @access public    db              数据库类
* @access public    table_articles  文章表
* @access public    totaltype       分类存放数组
* @param  int       typeid          信息输出的分类
* @param  int       template_body   信息输出的体部
* @param  int       template_head   信息输出的头部
* @param  int       length          标题长度输出的截取长度
* @param  int       limit           信息输出条数的多少
* @param  int       newday  
* @return string    $result  返回的数据
*/
function list_article($typeid,$template_body,$template_head,$typetitle=0,$length=40,$limit=10,$newday=2,$start=0){
	 global $db,$table_articles,$totaltype,$rootpath,$pagenav;
	 if ($typetitle=='0'){ 
	   if ($totaltype[$typeid][4]==1)	$typetitle="<a href=$rootpath/index.php?typeid=$typeid  class=Class>".$totaltype[$typeid][5]."</a>";
	       else $typetitle="<a href=$rootpath/class.php?typeid=$typeid  class=Class>".$totaltype[$typeid][5]."</a>";
	 }
	 $newtime=mktime(0,0,0,date("m"),date("d")-$newday,date("Y"));
   $topcid=eregi_replace("\|",",",substr($totaltype[$typeid][2], 1, -1));
   $query="select articleid,typeid,title,includepic,author,addtime from $table_articles where typeid in ($topcid) and pass>0 order by articleid desc limit $start,$limit";
   $result=$db->query($query);		      
   while($r=$db->fetch_array($result)){   
   	     if ($newtime<$r[addtime]){//最近更新 文字标题加红
   	     	   $t_length=$length; //设置文字截取长度初始值
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[图文]";
   	     	   	break;
   	     	   	case '2':$includepic="[组图]";
   	     	   	break;
   	     	   	case '3':$includepic="[推荐]";
   	     	   	break;
   	     	   	case '4':$includepic="[注意]";
   	     	   	break;
   	     	   	default:$includepic="";
   	     	   	break;
   	     	    }
   	     	   $d_length=strlen($includepic);
   	     	   $includepic="<font color=blue>$includepic</font>";
   	     	   $t_length=$t_length-$d_length;
      	     $utitle="[<a href=$rootpath/class.php?typeid=$r[typeid]>".$totaltype[$r[typeid]][5]."</a>]";
      	     $typename=$totaltypes[$typeid][2];;
      	     $pic="<img src=templates/$style/images/dot2.gif width=9  align=absmiddle>";
    	       $url="show.php?id=$r[articleid]";                 
             $title="<font color=red>".cnSubStr($r[title],$t_length)."</font>";
             $adddate="<font color=red>".date('y/m/d',$r[addtime])."</font>";
             $author="<font color=red>".$r[author]."</font>";
   	         $alt=$totaltype[$r[typeid]][5]."：".$r[title]."&#13;&#10;作&nbsp;&nbsp;&nbsp;&nbsp;者：".$r[author]."&#13;&#10;更新时间：".date('y/m/d',$r[addtime]);                                 
             eval("\$data_body .= \"".gettemplate($template_body)."\";"); 
             }
         else{  
         	   $t_length=$length; //设置文字截取长度初始值
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[图文]";
   	     	   	break;
   	     	   	case '2':$includepic="[组图]";
   	     	   	break;
   	     	   	case '3':$includepic="[推荐]";
   	     	   	break;
   	     	   	case '4':$includepic="[注意]";
   	     	   	break;
   	     	   	default:$includepic="";
   	     	   	break;
   	     	    }
   	     	   $d_length=strlen($includepic);
   	     	   $t_length=$t_length-$d_length;
         	   $utitle="[<a href=$rootpath/class.php?typeid=$r[typeid]>".$totaltype[$r[typeid]][5]."</a>]";
      	     $typename=$totaltypes[$typeid][2];;
      	     $pic="<img src=templates/$style/images/dot2.gif width=9  align=absmiddle>";
    	       $url="show.php?id=$r[articleid]";                 
             $title=cnSubStr($r[title],$t_length);
             $adddate=date('y/m/d',$r[addtime]);
             $author=$r[author]; 
    	       $alt=$totaltype[$r[typeid]][5]."：".$r[title]."&#13;&#10;作&nbsp;&nbsp;&nbsp;&nbsp;者：$author&#13;&#10;更新时间：$adddate";                
             eval("\$data_body .= \"".gettemplate($template_body)."\";");
             }      
        }//while end               
   if (empty($template_head)) {$data_list=$data_body;}
                    else  {eval("\$data_list = \"".gettemplate($template_head)."\";"); }
   return $data_list;
}
/**
* 客户数据的读取至浏览器中方法二
*
* @access public    db              数据库类
* @access public    table_articles  文章表
* @access public    totaltype       分类存放数组
* @param  int       typeid          信息输出的分类
* @param  int       template_body   信息输出的体部
* @param  int       template_head   信息输出的头部
* @param  int       length          标题长度输出的截取长度
* @param  int       limit           信息输出条数的多少
* @param  int       newday  
* @return string    $result  返回的数据
*/
function list_article_2($typeid,$template_body,$template_head,$typetitle=0,$length=40,$type_image,$limit=10,$newday=2,$start=0){
	 global $db,$table_articles,$totaltype,$rootpath,$pagenav;
	 if ($typetitle=='0'){ 
	   if ($totaltype[$typeid][4]==1)	$typetitle="<a href=$rootpath/index.php?typeid=$typeid  class=Class>".$totaltype[$typeid][5]."</a>";
	       else $typetitle="<a href=$rootpath/class.php?typeid=$typeid  class=Class>".$totaltype[$typeid][5]."</a>";
	 }
	 $newtime=mktime(0,0,0,date("m"),date("d")-$newday,date("Y"));
   $topcid=eregi_replace("\|",",",substr($totaltype[$typeid][2], 1, -1));
   $i=0;
   $query="select articleid,typeid,title,includepic,author,addtime from $table_articles where typeid in ($topcid) and pass>0 order by articleid desc limit $start,$limit";
   $result=$db->query($query);		      
   while($r=$db->fetch_array($result)){   
   	     if ($newtime<$r[addtime]){//最近更新 文字标题加红
   	     	   $t_length=$length; //设置文字截取长度初始值
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[图文]";
   	     	   	break;
   	     	   	case '2':$includepic="[组图]";
   	     	   	break;
   	     	   	case '3':$includepic="[推荐]";
   	     	   	break;
   	     	   	case '4':$includepic="[注意]";
   	     	   	break;
   	     	   	default:$includepic="";
   	     	   	break;
   	     	    }
   	     	   $d_length=strlen($includepic);
   	     	   $includepic="<font color=blue>$includepic</font>";
   	     	   $t_length=$t_length-$d_length;
      	     $utitle="[<a href=$rootpath/class.php?typeid=$r[typeid]>".$totaltype[$r[typeid]][5]."</a>]";
      	     $typename=$totaltypes[$typeid][2];;
      	     $pic="<img src=templates/$style/images/dot2.gif width=9  align=absmiddle>";
    	       $url="show.php?id=$r[articleid]";  
    	       $alt=$totaltype[$r[typeid]][5].":".$r[title];               
             if ($i<3) $title="<font color=red>".cnSubStr($r[title],18)."</font>";
    	           else  $title="<font color=red>".cnSubStr($r[title],$t_length)."</font>";
             $adddate="<font color=red>".date('y/m/d',$r[addtime])."</font>";
             $author="<font color=red>".$r[author]."</font>";  
             if ($i<3){
             	   $utitle="";
             	   eval("\$data_body_1 .= \"".gettemplate($template_body)."\";"); 
             	   }
            else {  
                 eval("\$data_body_2 .= \"".gettemplate($template_body)."\";");
                 }
             }
         else{  
         	   $t_length=$length; //设置文字截取长度初始值
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[图文]";
   	     	   	break;
   	     	   	case '2':$includepic="[组图]";
   	     	   	break;
   	     	   	case '3':$includepic="[推荐]";
   	     	   	break;
   	     	   	case '4':$includepic="[注意]";
   	     	   	break;
   	     	   	default:$includepic="";
   	     	   	break;
   	     	    }
   	     	   $d_length=strlen($includepic);
   	     	   $t_length=$t_length-$d_length;
         	   $utitle="[<a href=$rootpath/class.php?typeid=$r[typeid]>".$totaltype[$r[typeid]][5]."</a>]";
      	     $typename=$totaltypes[$typeid][2];;
      	     $pic="<img src=templates/$style/images/dot2.gif width=9  align=absmiddle>";
    	       $alt=$totaltype[$r[typeid]][5].":".$r[title];  
    	       $url="show.php?id=$r[articleid]";  
    	       if ($i<3) $title=cnSubStr($r[title],18);
    	           else  $title=cnSubStr($r[title],$t_length);
             $adddate=date('y/m/d',$r[addtime]);
             $author=$r[author];   
             if ($i<3){
             	   $utitle="";
             	   eval("\$data_body_1 .= \"".gettemplate($template_body)."\";"); 
             	   }
            else {  
                 eval("\$data_body_2 .= \"".gettemplate($template_body)."\";");
                 }
             } 
         $i++;     
        }//while end                  
   eval("\$data_list = \"".gettemplate($template_head)."\";"); 
   return $data_list;
}
/* 
* 图片缩略图 
* $srcfile 来源图片，
* $rate 缩放比,默认为缩小一半,或者具体宽度象素值
* $filename 输出图片文件名jpg
* 例如: resizeimage("zt32.gif",0.1);
* 例如: resizeimage("zt32.gif",250　);
* 说明:调用时直接把函数的结果放在HTML文件IMG标签中的SRC属性里
*/
function resizeimage($srcfile,$rate=.5, $filename = "" ){
        $size=getimagesize($srcfile);
        switch($size[2]){
                case 1:
                        $img=imagecreatefromgif($srcfile);
                        break;
                case 2:
                        $img=imagecreatefromjpeg($srcfile);
                        break;
                case 3:
                        $img=imagecreatefrompng($srcfile);
                        break;
                default:
                        exit;
        }
        //源图片的宽度和高度
        $srcw=imagesx($img);
        $srch=imagesy($img);
        //目的图片的宽度和高度
        if($size[0] <= $rate || $size[1] <= $rate){
                $dstw=$srcw;
                $dsth=$srch;
        }else{
                if($rate <= 1){
                        $dstw=floor($srcw*$rate);
                        $dsth=floor($srch*$rate);
                }else {
                        $dstw=$rate;
                        $rate = $rate/$srcw;
                        $dsth=floor($srch*$rate);
                }
        }
                        //echo "$dstw,$dsth,$srcw,$srch ";
        //新建一个真彩色图像
        $im=imagecreatetruecolor($dstw,$dsth);
        $black=imagecolorallocate($im,255,255,255);
        
        imagefilledrectangle($im,0,0,$dstw,$dsth,$black);
        imagecopyresized($im,$img,0,0,0,0,$dstw,$dsth,$srcw,$srch);
        // 以 JPEG 格式将图像输出到浏览器或文件
        if( $filename ) {
          //图片保存输出
          imagejpeg($im, $filename);
        }else {
          //图片输出到浏览器
          imagejpeg($im);
        }
        //释放图片
        imagedestroy($im);
        imagedestroy($img);
}
/**
* 防sql注入函数
* @access public
* @param string    $content                传递的变量
* @return string   $content                返回转义的变量
*/
function sql_injection($content)
{
if (!get_magic_quotes_gpc()) {
if (is_array($content)) {
foreach ($content as $key=>$value) {
$content[$key] = addslashes($value);
}
} else {
addslashes($content);
}
} 
return $content;
} 
/*****************************************************************************/
//参数一为分类id ，参数二为分类所在的层id+1;
//例如：show_type_select(0,1); 
//* @param array[uid]    $type         相关同一子级的栏目放在父级
//* @param array[id][]   $totaltype    具体分类的信息
//* @return string       $type_select  最后输出的内容

function show_type_select($uid,$slayerid)
{  
	global $type,$totaltype,$type_select;
  $tree_t="┝";
  $tree_c="┕";
  $tree_l="│";
  $tree_k="&nbsp;";
if (is_array($type)){
	foreach($type[$uid] as $tid)
	{ 
		$temp=$type[$tid][0];//变量判断是否到了树尾；
	  $layerid=$totaltype[$tid][4];//读取层数 	  
	  if ($layerid==$slayerid){  
	  	                 //当层次为最高层时前面显示的图标为┝
	  	                 $tree=$tree_t; 
	  	                 }
	                else { 	                	
	                	   //不是则显示为图标│ 
	                	   $tree=$tree_l;
	           	         for ($i=1;$i<$layerid-1;$i++)
	           	                    { $tree.=$tree_l;
	           	                    }
	           	         //添加图标为┕    
	           	         if (next($type[$uid])>0) 
                       $tree.=$tree_t;
                       else $tree.=$tree_c;
                       };
    //添加到option列表变量$type_select中                   
	  $type_select.="<option value=$tid>".$tree.$totaltype[$tid][5].$tid."</option>";
		//复位$type指针
		reset($type);
		//如果到了树尾则结束递归
	  if ($temp!=""){  
                   show_type_select($tid,$slayerid);
                  }
  }	
  }
}

//*****************************************************************************/
//输出为表格的形式
//参数一为分类id ，参数二为分类所在的层id+1;
//例如：show_type_table(0,1); 
//* @param array[uid]    $type         相关同一子级的栏目放在父级
//* @param array[id][]   $totaltype    具体分类的信息
//* @return string       $type_select  最后输出的内容
function show_type_table($uid,$slayerid)//参数一为分类id ，参数二为分类所在的层id+1
{  global $type,$totaltype,$show_type_table,$style;
   $tree_t="┝";//节点,下面还有同深度的节点  
   $tree_c="┕";//节点,下面还没有同深度的节点  
   $tree_l="│";//非节点,过渡,下面有父节点同深度的节点  
   $tree_k="&nbsp;&nbsp;";//非节点,过渡,下面没有父节点同深度的节点  
 if (isset($type[$uid])){
	foreach($type[$uid] as $tid)
	{ $temp=$type[$tid][0];//变量判断是否到了树尾；
	  $layerid=$totaltype[$tid][4];//读取层数 
	  if  ($layerid==$slayerid){ //当为当前第一层时
         $show_type_table.="
                     </TBODY>
                     </table>
                     <table cellPadding=2 cellSpacing=1 class=tableborder width=100%>
                     <tr>
                      <th width=5% height=20 ><a href=javascript:show('$tid')><img border=0 src=./templates/$style/images/0.gif></a>
                      </th>
                      <th align=left width=30%><a href=javascript:show('$tid')><font color=#fffff>".$tree_t.$layerid.$totaltype[$tid][5]."</font></a>
                      </th>
                      <th align=center width=25%><input type=\"submit\" name=\"Submit\" value=\"保存\">顺序:<input type=\"text\" name=order[$tid] value=".$totaltype[$tid][6]." size=\"5\">
                      </th>
                      <th align=left width=40%>
                                               <a href=?filename=type&action=addtype&uid=$tid>添加子栏目</a> 
                                               | <a href=?filename=type&action=edittype&typeid=$tid>修改</a> 
                                               | <a href=?filename=type&action=deltype&typeid=$tid>删除</a>$test
                      </th>
                     </tr>
                     <TBODY style=\"display:none\" id=\"$tid\">";
                        }
	  else{  
         $tree=$tree_l;
	       for ($i=1;$i<$layerid-1;$i++)$tree.=$tree_l;
         if (next($type[$uid])>0) 
             $tree.=$tree_t;
         else $tree.=$tree_c;
         if ($layerid==2) $styled="class=tablerows";
         $show_type_table.="<tr >
                             <td height=18 width=5% $styled></td>
                             <td width=30% $styled>$tree".$layerid.$totaltype[$tid][5]."</td>
                             <td $styled width=25% align=center>显示顺序:<input type=\"text\" name=order[$tid] value=".$totaltype[$tid][6]." size=\"5\"></td>
                             <td $styled width=40%><a href=?filename=type&action=addtype&uid=$tid>添加子栏目</a>
                                                               | <a href=?filename=type&action=edittype&typeid=$tid>修改</a> 
                                                               | <a href=?filename=type&action=deltype&typeid=$tid>删除</a>$test</td> 
                            </tr>";
          };
		reset($type);
		//如果到了树尾则结束递归
	  if ($temp!=""){ show_type_table($tid,$slayerid);}
  }	
  }
 if ($layerid==$slayerid){  $show_type_table.="</tbody></table>";}

}

/**********************************************************************
* 栏目读取到文章添加页面函数
* @access public
* @param string    $slayerid               开始级分类的层次
* @param int       $uid                    开始级分类
* @global array    $type                   栏目分类排序数组
* @global array    $totaltype              栏目分类名称数组
* @global array    $show_type_table_left   结果输出单元格左边内容
* @global array    $show_type_table_right  结果输出单元格左边内容
* @global array    $totaltopid=0           父级输出的个数统计
* @global array    $tempidid=0             记数用的临时变量
* @global int      $topid=0                顶级分类的id值
* @global int      $typeid=""              本分类的id值
* @return string   
*/
//参数一为分类id ，参数二为分类所在的层id+1
function show_type_table_edit($uid,$slayerid,$topid,$typeid)
{  
	global $type,$totaltype,$show_type_table_left,$show_type_table_right,$totaltopid,$tempid; 
  $i=1;
  if (isset($type[$uid])){
	foreach($type[$uid] as $tid)
	{ $temp=$type[$tid][0];//变量判断是否到了树尾；
	  $layerid=$totaltype[$tid][4];//读取层数 
	  if  ($layerid==$slayerid)//当为当前第一层时
	      { 
         if ($topid==$tid)
             {
             	$show_type_table_left.="<input type=radio checked name=topid onclick=showc('f$i') value=$tid>".$totaltype[$tid][5]."<br>";
             	$show_type_table_right.="<TBODY style=display:block id=f$i><td valign=top>";   
              $i++;
             }
         else{
         	    $show_type_table_left.="<input type=radio name=topid onclick=showc('f$i') value=$tid>".$totaltype[$tid][5]."<br>";
              $show_type_table_right.="<TBODY style=display:none id=f$i><td valign=top>"; 
              $i++;
             } 
         $totaltopid++;  
         $tempid=0;
        }
	  elseif ($totaltype[$tid][8]==1){  
	       $tempid++;
	       if ($typeid==$tid){
	       	    $show_type_table_right.="<input type=radio name=typeid value=$tid checked><font color=red>".$totaltype[$tid][5]."</font>";
	            }
	            else
	            {
              $show_type_table_right.="<input type=radio name=typeid value=$tid>".$totaltype[$tid][5];
              }
         if  ($tempid%5==0){$show_type_table_right.="<br>";};
         };
		reset($type);
		//如果到了树尾则结束递归
	  if ($temp!=""){  show_type_table_edit($tid,$slayerid,$topid,$typeid); }
    if ($layerid==$slayerid){ $show_type_table_right.="</td></TBODY>";}                    
    }	
  }
}
/**在文章编辑状态的时候显示的分类表格
* 栏目读取到文章添加页面显示函数
* @access public
* @param string    $slayerid               开始级分类的层次
* @param int       $$uid                   开始级分类
* @global array    $show_type_table_left   结果输出单元格左边内容
* @global array    $show_type_table_right  结果输出单元格左边内容
* @return string   $show_result            结果输出
*/
function show_typemenu_edit($uid,$slayerid,$topid,$typeid)
{ 
	global $show_type_table_left,$show_type_table_right,$totaltopid,$tempid;
	$totaltopid=$tempid=0;
  $show_type_table_left=$show_type_table_right=""; 
	show_type_table_edit($uid,$slayerid,$topid,$typeid); 
  $show_result="
    <table width=100%>
      <tr>
       <td width=15%>
         $show_type_table_left
       </td>
       <td width=85%>
          <table width=100%>
          <tr>
            $show_type_table_right
          </tr>
          </table>
       </td>
     </tr>
    </table>
    ";
  unset($show_type_table_left,$show_type_table_right,$tempid,$totaltopid);
  return $show_result;
}

/*显示分类信息到添加页面**************************************************
* 栏目读取到文章添加页面函数
* @access public
* @param string    $slayerid               开始级分类的层次
* @param int       $$uid                   开始级分类
* @global array    $type                   栏目分类排序数组
* @global array    $totaltype              栏目分类名称数组
* @global array    $show_type_table_left   结果输出单元格左边内容
* @global array    $show_type_table_right  结果输出单元格右边内容
* @return string   
*/

function show_type_table_add($uid,$slayerid)//参数一为分类id ，参数二为分类所在的层id+1
{  global $type,$totaltype,$show_type_table_left,$show_type_table_right,$totaltopid,$tempid; 
	 $i=1;
   if (isset($type[$uid])){
	     foreach($type[$uid] as $tid){
	             $temp=$type[$tid][0];//变量判断是否到了树尾；
	             $layerid=$totaltype[$tid][4];//读取层数 
	             if  ($layerid==$slayerid)
	                 { //当为当前第一层时
                   if ($totaltopid==0)
                       {
             	         $show_type_table_left.="<input type=radio checked name=topid onclick=showc('f$i') value=$tid>".$totaltype[$tid][5]."<br>";
                       $show_type_table_right.="<TBODY style=display:block id=f$i><td valign=top>";   
                       $i++;
                       }
                   else{
         	             $show_type_table_left.="<input type=radio name=topid onclick=showc('f$i') value=$tid>".$totaltype[$tid][5]."<br>";
                       $show_type_table_right.="<TBODY style=display:none id=f$i><td valign=top>"; 
                       $i++;
                       } 
                   $totaltopid++;  
                   $tempid=0;
                   }
	              elseif ($totaltype[$tid][8]==1){  
	                     $tempid++;
                       $show_type_table_right.="<input type=radio name=typeid value=$tid>".$totaltype[$tid][5];
                       if  ($tempid%5==0){$show_type_table_right.="<br>";};
                       };
		            reset($type);
		            //如果到了树尾则结束递归
	              if ($temp!=""){
                       show_type_table_add($tid,$slayerid);
                       }
                if ($layerid==$slayerid){ 
                	    $show_type_table_right.="</td></TBODY>";}                    
                }	
      }
}
/**
* 栏目读取到文章添加页面显示函数
* @access public
* @param string    $slayerid               开始级分类的层次
* @param int       $$uid                   开始级分类
* @global array    $show_type_table_left   结果输出单元格左边内容
* @global array    $show_type_table_right  结果输出单元格左边内容
* @return string   $show_result            结果输出
*/
function show_typemenu_add($uid,$slayerid)
{ 
	global $show_type_table_left,$show_type_table_right,$totaltopid,$tempid;
	$totaltopid=$tempid=0; 
	show_type_table_add($uid,$slayerid); 
  $show_result="
    <table width=100%>
      <tr>
       <td width=15%>
         $show_type_table_left
       </td>
       <td width=85%>
          <table width=100%>
          <tr>
            $show_type_table_right
          </tr>
          </table>
       </td>
     </tr>
    </table>
    ";
  return $show_result;
}

//显示目录中的图片
function list_dir_images($dir){
$extends=array("gif","jpg","jpeg","png","bmp");
$handle=opendir($dir);
$eg="";
while (false !== ($file = readdir($handle))) {
  if (($file==".") or ($file=="..")  or is_dir("$dir/$file")) continue;
  $extend= substr(strrchr($file,"."),1);
  if (in_array($extend,$extends)){
      $list_file.=$eg.$file;
      $eg="|";
      }
}
closedir($handle);
return $list_file;
}
/************************获取用户组权限**************************/
function getright($groupid=99){
global $db;
//用户组权限读取
$sql="select * from userright where rightid=$groupid limit 1";
$result=$db->query($sql);
if($db->affected_rows()!=0){
   $r=$db->fetch_array($result);
   $rights=$r[rights];
   $rights=explode(":",$rights);
   while (list($key,$tright)=each($rights)){
      $tright=explode("|",$tright);
      $lright=sizeof($tright);
      for ($i=1;$i<=$lright;$i++)
           $rightdata[$tright[0]][$i]=$tright[$i];
      }
  } else $rightdata="";
return $rightdata;  
}
//参数说明：
//file_path:文件的具体路径和名称
function download($file_path)
{   
	  //获取文件名
    $file_name=substr(strrchr($file_path,"/"),1);
    //判断要下载的文件是否存在
    if(!file_exists($file_path))
    {
        echo '对不起,你要下载的文件不存在。';
        return false;
    }

    $file_size = filesize($file_path);
 
    header("Content-type: application/octet-stream");
    header("Accept-Ranges: bytes");
    header("Accept-Length: $file_size");
    header("Content-Disposition: attachment; filename=".$file_name);
    
    $fp = fopen($file_path,"r");
    $buffer_size = 1024;
    $cur_pos = 0;
    
    while(!feof($fp)&&$file_size-$cur_pos>$buffer_size)
    {
        $buffer = fread($fp,$buffer_size);
        echo $buffer;
        $cur_pos += $buffer_size;
    }
    
    $buffer = fread($fp,$file_size-$cur_pos);
    echo $buffer;
    fclose($fp);
    return true;
}
?>
