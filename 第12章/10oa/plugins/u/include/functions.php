<?
/**
* 截取中文部分字符串
*
* 截取指定字符串指定长度的函数,该函数可自动判定中英文,不会出现乱码
*
* @access public
* @param string    $string 要处理的字符串
* @param int       $strlen 要截取的长度默认为10
* @param string    $other  是否要加上省略号,默认会加上
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
//建立文件夹
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
	} else {
		if($url_forward) {
			$message .= "<br><a href=\"$url_forward\">如果您的浏览器没有自动跳转，请点击这里</a>";
			$message .= "<script>setTimeout(\"redirect('$url_forward');\", 1250);</script>";
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
        <table width='400'  border='0' cellpadding='1' cellspacing='1' bgcolor='#ffffff' align='center'>
            <tr align='center' bgcolor='#E5E5E5'>
               <td height='100' valign='middle'>$message</td>
            </tr>
          </table>";
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
?>
