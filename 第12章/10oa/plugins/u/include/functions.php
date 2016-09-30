<?
/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
*
* @access public
* @param string    $string Ҫ������ַ���
* @param int       $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string    $other  �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
* @return string   $s
*/
function cnSubStr($string,$sublen=10,$other="..")
{
	if($sublen>=strlen($string))
	{
		return $string;
	}
	$s="";
	for($i=0;$i<$sublen;$i++)
	{
		if(ord($string{$i})>127)
		{
			$s.=$string{$i}.$string{++$i};
			continue;
		}else{
			$s.=$string{$i};
			continue;
		}
	}
	$s.=$other;
	return $s;
}
//�����ļ���
function newcreatedir($dir)
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
	global $db,$htm;

	//$vartext=dovars($vartext,$sendheader);
	$content=$vartext;
	/*if (isset($htm))
	{   $file=$htm;
	$oldmask = umask(0);
	$fp = fopen($file, 'w');
	if (!$fp) return false;
	fwrite($fp,$content);
	fclose($fp);
	umask($oldmask);}*/
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
	} else {
		if($url_forward) {
			$message .= "<br><a href=\"$url_forward\">������������û���Զ���ת����������</a>";
			$message .= "<script>setTimeout(\"redirect('$url_forward');\", 1250);</script>";
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
        <table width='400'  border='0' cellpadding='1' cellspacing='1' bgcolor='#ffffff' align='center'>
            <tr align='center' bgcolor='#E5E5E5'>
               <td height='100' valign='middle'>$message</td>
            </tr>
          </table>";
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
				$file=$cur_dir."/index.htm";
				$oldmask = umask(0);
				$fp = fopen($file, 'w');
				if (!$fp) return false;
				fclose($fp);
				umask($oldmask);
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
?>
