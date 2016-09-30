<?php
require_once(dirname(__FILE__)."/database/config_mysql.php");

if( isset($_GET['from']) )
{
	$link = mysql_connect($mysql_host, $mysql_user, $mysql_pass);

	mysql_select_db($mysql_dbname, $link);

	if( $_GET['from'] == "1.0" )
	{
		mysql_query("ALTER TABLE `".$mysql_prefix."friend` ADD `friendavatar` char( 50 ) NOT NULL AFTER `fupdate`");
	}

	if( $_GET['from'] == "1.0" || $_GET['from'] == "1.1" )
	{
		mysql_query("ALTER TABLE `".$mysql_prefix."comment` ADD `nickname` char( 15 ) NOT NULL AFTER `mid`");
	}

	mysql_close($link);

	$file_site = "./database/config_site.php";

	$site_str = str_replace(array('1.0','1.1','/");'),array('1.2','1.2','/","tracking_code" => "","url_short" => false);'),file_get_contents($file_site));

	$handle = @fopen($file_site, 'w');

	if ( @flock($handle, LOCK_EX) )
	{
		@fwrite($handle, $site_str);

		@flock($handle, LOCK_UN);
	}
			
	@fclose($handle);

	@unlink("upto.php");

	echo "OK";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>莎莎微博</title>
<style>
body {
	font-family: "Verdana", "Arial", "Helvetica", "sans-serif";
	font-size: 15px;
	text-align: center;
 
}
div {
	padding: 8px;
	margin-top: 100px;
	margin-bottom: 10px;
	width:150px;
	margin-right: auto;
	margin-left: auto;
	text-align: left;
	border: 1px solid #999;
	background-color: #F9F9F9;
	text-align: center;
}
a {
	color:#666;
	text-decoration:none;
}
a:hover {
	color:#999;
	text-decoration:none;
}
</style>
</head>
<body>
<div><a href="upto.php?from=1.0">从 1.0 升级到 1.2</a></div>
<div><a href="upto.php?from=1.1">从 1.1 升级到 1.2</a></div>
</body>
</html>