<?php
/*
����ɽ��Сѧ����칫��
*/
//����ҳ��ִ��ʱ��
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
/** * ��ȡ���Ĳ����ַ��� 
* 
* 
��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,����������� 
* 
* @access public 
* @param string    $string Ҫ������ַ��� 
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10 
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ���� 
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
* ��ҳ���ú���
*
* ��ҳ����������������������°���ĳ�������з�ҳ
*
* @access public
* @param string    $results    ��������
* @param int       $address    url
* @global int      $perpage    ��ǰҳ��
* @global int      $pagenumber ÿҳ������
* @global int      $pagenavepages  ҳ����ʾ��     
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
		$prevlink="<a href=\"$address&pagenumber=$prevpage\" title=\"��һҳ\" class=a>&laquo;</a>";    

	}
	if ($pagenumber<$totalpages) {
		$nextpage = $pagenumber+1;
		$nextlink="<a href=\"$address&pagenumber=$nextpage\" title=\"��һҳ\" class=a>&raquo;</a>";
	}
	while ($curpage++<$totalpages) {
		if ( ( $curpage <= $pagenumber-$pagenavpages || $curpage >= $pagenumber+$pagenavpages ) && $pagenavpages!=0 ) {
			if ($curpage==1) {
				$firstlink="<a href=\"$address&pagenumber=$curpage\" title=\"��һҳ\" class=a>&laquo; ��һҳ</a> ..."; 
			}
		    if ($curpage==$totalpages) {
				$lastlink="... <a href=\"$address&pagenumber=$curpage\" title=\"��ĩҳ\" class=a>��ĩҳ &raquo;</a> ";               
			}
		} else {
			if ($curpage==$pagenumber) {
				$pagenav .="[$curpage] "; 
			} else {
			$pagenav .= "<a href=\"$address&pagenumber=$curpage\" class=a>$curpage</a> ";
			}
		}
	}
	$pagenav="�� $totalpages ҳ���� <b> $firstlink $prevlink $pagenav $nextlink $lastlink </b>   20ƪ����/ҳ "; 
//	$pagenav="��ҳ�� ($totalpages): <b> $firstlink $prevlink $pagenav $nextlink $lastlink </b>";           
	return $pagenav;

}
/**
* �����������
*
* �����ɵ���ҳ����ֱ���������ҳ
*
* @access public
* @param string    $vartext   Ҫ���������
* @param int       $sendheader ����Ĭ��Τ1
*/
function dooutput($vartext,$sendheader=1) {
	global $showtime,$timer;
//$vartext=dovars($vartext,$sendheader);
if ($showtime) {
	$timer->stop();
  $vartext.="<br><center>ҳ��ִ��ʱ�䣺".$timer->spent()."����</center>";
  
}  
echo $vartext;
flush();

}
//cache
/**
* ����cache����
*
* ���ݻ��溯�������ȽϷ�ʱ�����������Ժ󻺴浽���ݿ��У�
*
* @access public
* @param string    $vartext    Ҫ���������
* @param int       $cachename  ����������ݱ���
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
* ����cache����
*
* �����ݿ��е�cacheһ��������������У�������
*
* @access public
* @param string     $cacheeslist      $cache��
* @global array     $ecache           ���cache����
* @global class     $db               ���ݿ������   
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
* ��ȡcache���ɺ���
*
* �����ݿ��д�ŵ�ģ�������������
*
* @access public
* @param  string    $cachename        Ҫ�����$cachename����
* @global array     $cache            ���cache����
* @global class     $db               ���ݿ������
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
* �����滻����
*
* ��ģ���еı��������滻
*
* @access public
* @param string    $newtext    Ҫ���������
* @param int       $sendheader ���� Ĭ�� 1
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
* if ����
*
* @access public
* @param int      $expression    �Ƿ�Ϊ��
* @param string   $returntrue    Ϊ���򷵻� �˱���ֵ
* @param string   $returnfalse   Ϊ���򷵻� �˱���ֵ
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
* ����cache����
*
* ����ҳ�е�ģ��һ��������������У�������
*
* @access public
* @param string    $templateslist  ģ���У���"index,footer,head"
* @global array     $templatecache    ���ģ��cache����
* @global class     $db               ���ݿ������
* @global int       $templatesetid    ģ����ϵ      
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
* �������ɺ���
*
* �����ݿ��д�ŵ�ģ�������������
*
* @access public
* @param  string    $templatename   Ҫ�����ģ������
* @global array     $templatecache    ���ģ��cache����
* @global class     $db               ���ݿ������
* @global int       $templatesetid    ģ����ϵ  
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
* ��ʾ��Ϣ����
*
* ��Ϣ��ʾ����
*
* @access public
* @param string    $message    �������Ϣ
* @param int       $url_forword ҳ����ת��url
* @param string    $msgtype  �ж��Ƿ�����ת������Ϣȷ��
* @return string
*/
function showmessage($message, $url_forward = '', $msgtype = 'message') {
	if($msgtype == 'form') {
		$message = "<form method=\"post\" action=\"$url_forward\"><br><br><br>$message<br><br><br><br>\n".
        		"<input type=\"submit\" name=\"confirmed\" value=\"ȷ ��\"> &nbsp; \n".
       			"<input type=\"button\" value=\"�� ��\" onClick=\"history.go(-1);\"></form><br>";
	} elseif ($msgtype=="close"){
		    			$message .= "<br>��������ر�";
			$message .= "<script>setTimeout(\"window.close();\", 1000);</script>";
	}else{
		if($url_forward) {
			$message .= "<br><a href=\"$url_forward\">������������û���Զ���ת����������</a>";
			$message .= "<script>setTimeout(\"redirect('$url_forward');\", 2000);</script>";
		} elseif(strpos($message, "����")) {
			$message .= "<a href=\"$url_forward\" >[ �����ﷵ����һҳ ]</a>";
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
* �û���⺯��
*
* �Ե�����û����м��
*
* @access public
* @param string    $message   �������Ϣ
* @param int       $referer   ��ת��ҳ��
* @return string
*/
function checkadmin($message,$referer=''){
global $user_id;
$referer='?filename=login&referer='.$referer;
$message=$message?$message:"���¼��";
if(!isset($user_id)){
showmessage($message,$referer);
exit();
}
}

/**
* Ŀ¼�Ƿ��д����
*
* Ŀ¼�Ƿ��д����
*
* @access public
* @param string    $dir    ������Ŀ¼
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
* Ŀ¼����
*
* ��Ŀ¼���Ƶ��ƶ�Ŀ¼
*
* @access public
* @param string    $source       ԴĿ¼
* @param string    $destination  Ŀ��Ŀ¼
* @param int       $child=1      ��������
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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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



/**�ļ���Сת��
*
* �ļ���Сת��
*
* @access public
* @param string    $filesize    Ҫ������ַ���

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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
// ###################### �������ɺ��� #######################
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* �ж�����������ѡȡ��
*
* �����ж��ַ���һ���ַ������Ƿ����.�Ӷ�ʹ��ȵ���Ŀ�������˵��б�ѡ��
*
* @access public
* @param string $str1  Ҫ�Ƚϵ��ַ���һ
* @param string $str2  Ҫ�Ƚϵ��ַ�����
* @return string       ��ȷ����ַ���"selected",���򷵻ؿ��ַ���
*/
function selected($str1,$str2) {
    if($str1==$str2) {
        return ' selected';
    }
    return '';
}

/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ʽ���û�����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
* @return string
*/
function str_out($string) {
$string=stripslashes($string);
$string=str_replace(chr(13), "<BR>",$string);
$string=str_replace(" ", "&nbsp;",$string);
return $string;
}
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
* @return string
*/
function str_in($string) {
$string=daddslashes($string,'1');
return $string;
}
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $str    Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
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
* ��ȡ�����
*
* Ĭ��Ϊ16Ϊ�����
*
* @access public
* @param  int       length  ������ĳ���
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
// ####################### ��ȡ�ͻ���IP #######################
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
// ####################### ��̨�ɹ���¼��¼ #######################
function loginsucceed($username="",$password="") {
	global $db,$table_loginlog;
	$extra .= "\nScript: ".getenv("REQUEST_URI");
	$db->query("INSERT INTO $table_loginlog (username,password,date,ipaddress,result) VALUES
	('".$username."','������ȷ','".time()."','".getip()."','1')");
}

// ####################### ��̨ʧ�ܵ�¼��¼ #######################
function loginfaile($username="",$password="") {
	global $db,$table_loginlog;
	$extra .= "\nScript: ".getenv("REQUEST_URI");
	$db->query("INSERT INTO $table_loginlog (username,password,date,ipaddress,result) VALUES
	('".$username."','�������','".time()."','".getip()."','2')");
}

// ####################### ��̨�����¼ #######################
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
* �ͻ����ݵĶ�ȡ���������--����һ
*
* @access public    db              ���ݿ���
* @access public    table_articles  ���±�
* @access public    totaltype       ����������
* @param  int       typeid          ��Ϣ����ķ���
* @param  int       template_body   ��Ϣ������岿
* @param  int       template_head   ��Ϣ�����ͷ��
* @param  int       length          ���ⳤ������Ľ�ȡ����
* @param  int       limit           ��Ϣ��������Ķ���
* @param  int       newday  
* @return string    $result  ���ص�����
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
   	     if ($newtime<$r[addtime]){//������� ���ֱ���Ӻ�
   	     	   $t_length=$length; //�������ֽ�ȡ���ȳ�ʼֵ
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[ͼ��]";
   	     	   	break;
   	     	   	case '2':$includepic="[��ͼ]";
   	     	   	break;
   	     	   	case '3':$includepic="[�Ƽ�]";
   	     	   	break;
   	     	   	case '4':$includepic="[ע��]";
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
   	         $alt=$totaltype[$r[typeid]][5]."��".$r[title]."&#13;&#10;��&nbsp;&nbsp;&nbsp;&nbsp;�ߣ�".$r[author]."&#13;&#10;����ʱ�䣺".date('y/m/d',$r[addtime]);                                 
             eval("\$data_body .= \"".gettemplate($template_body)."\";"); 
             }
         else{  
         	   $t_length=$length; //�������ֽ�ȡ���ȳ�ʼֵ
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[ͼ��]";
   	     	   	break;
   	     	   	case '2':$includepic="[��ͼ]";
   	     	   	break;
   	     	   	case '3':$includepic="[�Ƽ�]";
   	     	   	break;
   	     	   	case '4':$includepic="[ע��]";
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
    	       $alt=$totaltype[$r[typeid]][5]."��".$r[title]."&#13;&#10;��&nbsp;&nbsp;&nbsp;&nbsp;�ߣ�$author&#13;&#10;����ʱ�䣺$adddate";                
             eval("\$data_body .= \"".gettemplate($template_body)."\";");
             }      
        }//while end               
   if (empty($template_head)) {$data_list=$data_body;}
                    else  {eval("\$data_list = \"".gettemplate($template_head)."\";"); }
   return $data_list;
}
/**
* �ͻ����ݵĶ�ȡ��������з�����
*
* @access public    db              ���ݿ���
* @access public    table_articles  ���±�
* @access public    totaltype       ����������
* @param  int       typeid          ��Ϣ����ķ���
* @param  int       template_body   ��Ϣ������岿
* @param  int       template_head   ��Ϣ�����ͷ��
* @param  int       length          ���ⳤ������Ľ�ȡ����
* @param  int       limit           ��Ϣ��������Ķ���
* @param  int       newday  
* @return string    $result  ���ص�����
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
   	     if ($newtime<$r[addtime]){//������� ���ֱ���Ӻ�
   	     	   $t_length=$length; //�������ֽ�ȡ���ȳ�ʼֵ
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[ͼ��]";
   	     	   	break;
   	     	   	case '2':$includepic="[��ͼ]";
   	     	   	break;
   	     	   	case '3':$includepic="[�Ƽ�]";
   	     	   	break;
   	     	   	case '4':$includepic="[ע��]";
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
         	   $t_length=$length; //�������ֽ�ȡ���ȳ�ʼֵ
   	     	   $d_length=strlen($totaltype[$r[typeid]][5]);
   	     	   $t_length=$t_length-$d_length;
   	     	   $includepic=$r[includepic];
   	     	   switch($includepic){
   	     	   	case '0':$includepic="";
   	     	   	break;
   	     	   	case '1':$includepic="[ͼ��]";
   	     	   	break;
   	     	   	case '2':$includepic="[��ͼ]";
   	     	   	break;
   	     	   	case '3':$includepic="[�Ƽ�]";
   	     	   	break;
   	     	   	case '4':$includepic="[ע��]";
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
* ͼƬ����ͼ 
* $srcfile ��ԴͼƬ��
* $rate ���ű�,Ĭ��Ϊ��Сһ��,���߾���������ֵ
* $filename ���ͼƬ�ļ���jpg
* ����: resizeimage("zt32.gif",0.1);
* ����: resizeimage("zt32.gif",250��);
* ˵��:����ʱֱ�ӰѺ����Ľ������HTML�ļ�IMG��ǩ�е�SRC������
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
        //ԴͼƬ�Ŀ�Ⱥ͸߶�
        $srcw=imagesx($img);
        $srch=imagesy($img);
        //Ŀ��ͼƬ�Ŀ�Ⱥ͸߶�
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
        //�½�һ�����ɫͼ��
        $im=imagecreatetruecolor($dstw,$dsth);
        $black=imagecolorallocate($im,255,255,255);
        
        imagefilledrectangle($im,0,0,$dstw,$dsth,$black);
        imagecopyresized($im,$img,0,0,0,0,$dstw,$dsth,$srcw,$srch);
        // �� JPEG ��ʽ��ͼ���������������ļ�
        if( $filename ) {
          //ͼƬ�������
          imagejpeg($im, $filename);
        }else {
          //ͼƬ����������
          imagejpeg($im);
        }
        //�ͷ�ͼƬ
        imagedestroy($im);
        imagedestroy($img);
}
/**
* ��sqlע�뺯��
* @access public
* @param string    $content                ���ݵı���
* @return string   $content                ����ת��ı���
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
//����һΪ����id ��������Ϊ�������ڵĲ�id+1;
//���磺show_type_select(0,1); 
//* @param array[uid]    $type         ���ͬһ�Ӽ�����Ŀ���ڸ���
//* @param array[id][]   $totaltype    ����������Ϣ
//* @return string       $type_select  ������������

function show_type_select($uid,$slayerid)
{  
	global $type,$totaltype,$type_select;
  $tree_t="��";
  $tree_c="��";
  $tree_l="��";
  $tree_k="&nbsp;";
if (is_array($type)){
	foreach($type[$uid] as $tid)
	{ 
		$temp=$type[$tid][0];//�����ж��Ƿ�����β��
	  $layerid=$totaltype[$tid][4];//��ȡ���� 	  
	  if ($layerid==$slayerid){  
	  	                 //�����Ϊ��߲�ʱǰ����ʾ��ͼ��Ϊ��
	  	                 $tree=$tree_t; 
	  	                 }
	                else { 	                	
	                	   //��������ʾΪͼ�ꩦ 
	                	   $tree=$tree_l;
	           	         for ($i=1;$i<$layerid-1;$i++)
	           	                    { $tree.=$tree_l;
	           	                    }
	           	         //���ͼ��Ϊ��    
	           	         if (next($type[$uid])>0) 
                       $tree.=$tree_t;
                       else $tree.=$tree_c;
                       };
    //��ӵ�option�б����$type_select��                   
	  $type_select.="<option value=$tid>".$tree.$totaltype[$tid][5].$tid."</option>";
		//��λ$typeָ��
		reset($type);
		//���������β������ݹ�
	  if ($temp!=""){  
                   show_type_select($tid,$slayerid);
                  }
  }	
  }
}

//*****************************************************************************/
//���Ϊ������ʽ
//����һΪ����id ��������Ϊ�������ڵĲ�id+1;
//���磺show_type_table(0,1); 
//* @param array[uid]    $type         ���ͬһ�Ӽ�����Ŀ���ڸ���
//* @param array[id][]   $totaltype    ����������Ϣ
//* @return string       $type_select  ������������
function show_type_table($uid,$slayerid)//����һΪ����id ��������Ϊ�������ڵĲ�id+1
{  global $type,$totaltype,$show_type_table,$style;
   $tree_t="��";//�ڵ�,���滹��ͬ��ȵĽڵ�  
   $tree_c="��";//�ڵ�,���滹û��ͬ��ȵĽڵ�  
   $tree_l="��";//�ǽڵ�,����,�����и��ڵ�ͬ��ȵĽڵ�  
   $tree_k="&nbsp;&nbsp;";//�ǽڵ�,����,����û�и��ڵ�ͬ��ȵĽڵ�  
 if (isset($type[$uid])){
	foreach($type[$uid] as $tid)
	{ $temp=$type[$tid][0];//�����ж��Ƿ�����β��
	  $layerid=$totaltype[$tid][4];//��ȡ���� 
	  if  ($layerid==$slayerid){ //��Ϊ��ǰ��һ��ʱ
         $show_type_table.="
                     </TBODY>
                     </table>
                     <table cellPadding=2 cellSpacing=1 class=tableborder width=100%>
                     <tr>
                      <th width=5% height=20 ><a href=javascript:show('$tid')><img border=0 src=./templates/$style/images/0.gif></a>
                      </th>
                      <th align=left width=30%><a href=javascript:show('$tid')><font color=#fffff>".$tree_t.$layerid.$totaltype[$tid][5]."</font></a>
                      </th>
                      <th align=center width=25%><input type=\"submit\" name=\"Submit\" value=\"����\">˳��:<input type=\"text\" name=order[$tid] value=".$totaltype[$tid][6]." size=\"5\">
                      </th>
                      <th align=left width=40%>
                                               <a href=?filename=type&action=addtype&uid=$tid>�������Ŀ</a> 
                                               | <a href=?filename=type&action=edittype&typeid=$tid>�޸�</a> 
                                               | <a href=?filename=type&action=deltype&typeid=$tid>ɾ��</a>$test
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
                             <td $styled width=25% align=center>��ʾ˳��:<input type=\"text\" name=order[$tid] value=".$totaltype[$tid][6]." size=\"5\"></td>
                             <td $styled width=40%><a href=?filename=type&action=addtype&uid=$tid>�������Ŀ</a>
                                                               | <a href=?filename=type&action=edittype&typeid=$tid>�޸�</a> 
                                                               | <a href=?filename=type&action=deltype&typeid=$tid>ɾ��</a>$test</td> 
                            </tr>";
          };
		reset($type);
		//���������β������ݹ�
	  if ($temp!=""){ show_type_table($tid,$slayerid);}
  }	
  }
 if ($layerid==$slayerid){  $show_type_table.="</tbody></table>";}

}

/**********************************************************************
* ��Ŀ��ȡ���������ҳ�溯��
* @access public
* @param string    $slayerid               ��ʼ������Ĳ��
* @param int       $uid                    ��ʼ������
* @global array    $type                   ��Ŀ������������
* @global array    $totaltype              ��Ŀ������������
* @global array    $show_type_table_left   ��������Ԫ���������
* @global array    $show_type_table_right  ��������Ԫ���������
* @global array    $totaltopid=0           ��������ĸ���ͳ��
* @global array    $tempidid=0             �����õ���ʱ����
* @global int      $topid=0                ���������idֵ
* @global int      $typeid=""              �������idֵ
* @return string   
*/
//����һΪ����id ��������Ϊ�������ڵĲ�id+1
function show_type_table_edit($uid,$slayerid,$topid,$typeid)
{  
	global $type,$totaltype,$show_type_table_left,$show_type_table_right,$totaltopid,$tempid; 
  $i=1;
  if (isset($type[$uid])){
	foreach($type[$uid] as $tid)
	{ $temp=$type[$tid][0];//�����ж��Ƿ�����β��
	  $layerid=$totaltype[$tid][4];//��ȡ���� 
	  if  ($layerid==$slayerid)//��Ϊ��ǰ��һ��ʱ
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
		//���������β������ݹ�
	  if ($temp!=""){  show_type_table_edit($tid,$slayerid,$topid,$typeid); }
    if ($layerid==$slayerid){ $show_type_table_right.="</td></TBODY>";}                    
    }	
  }
}
/**�����±༭״̬��ʱ����ʾ�ķ�����
* ��Ŀ��ȡ���������ҳ����ʾ����
* @access public
* @param string    $slayerid               ��ʼ������Ĳ��
* @param int       $$uid                   ��ʼ������
* @global array    $show_type_table_left   ��������Ԫ���������
* @global array    $show_type_table_right  ��������Ԫ���������
* @return string   $show_result            ������
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

/*��ʾ������Ϣ�����ҳ��**************************************************
* ��Ŀ��ȡ���������ҳ�溯��
* @access public
* @param string    $slayerid               ��ʼ������Ĳ��
* @param int       $$uid                   ��ʼ������
* @global array    $type                   ��Ŀ������������
* @global array    $totaltype              ��Ŀ������������
* @global array    $show_type_table_left   ��������Ԫ���������
* @global array    $show_type_table_right  ��������Ԫ���ұ�����
* @return string   
*/

function show_type_table_add($uid,$slayerid)//����һΪ����id ��������Ϊ�������ڵĲ�id+1
{  global $type,$totaltype,$show_type_table_left,$show_type_table_right,$totaltopid,$tempid; 
	 $i=1;
   if (isset($type[$uid])){
	     foreach($type[$uid] as $tid){
	             $temp=$type[$tid][0];//�����ж��Ƿ�����β��
	             $layerid=$totaltype[$tid][4];//��ȡ���� 
	             if  ($layerid==$slayerid)
	                 { //��Ϊ��ǰ��һ��ʱ
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
		            //���������β������ݹ�
	              if ($temp!=""){
                       show_type_table_add($tid,$slayerid);
                       }
                if ($layerid==$slayerid){ 
                	    $show_type_table_right.="</td></TBODY>";}                    
                }	
      }
}
/**
* ��Ŀ��ȡ���������ҳ����ʾ����
* @access public
* @param string    $slayerid               ��ʼ������Ĳ��
* @param int       $$uid                   ��ʼ������
* @global array    $show_type_table_left   ��������Ԫ���������
* @global array    $show_type_table_right  ��������Ԫ���������
* @return string   $show_result            ������
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

//��ʾĿ¼�е�ͼƬ
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
/************************��ȡ�û���Ȩ��**************************/
function getright($groupid=99){
global $db;
//�û���Ȩ�޶�ȡ
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
//����˵����
//file_path:�ļ��ľ���·��������
function download($file_path)
{   
	  //��ȡ�ļ���
    $file_name=substr(strrchr($file_path,"/"),1);
    //�ж�Ҫ���ص��ļ��Ƿ����
    if(!file_exists($file_path))
    {
        echo '�Բ���,��Ҫ���ص��ļ������ڡ�';
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
