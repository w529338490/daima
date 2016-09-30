<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

unset($dbservertype);
//load config
require '../../config.php';
//require './config.php';
$uptemp="../../".$uptemp;
//load functions
require './include/functions.php';
$css="<LINK href=templates/$style/css/style.css rel=stylesheet type=text/css>";
// init db **********************
// load db class
$dbservertype = strtolower($dbservertype);
$dbclassname="./include/db_$dbservertype.php";
require "$dbclassname";
// load db table
$tablepre.="x_";
$tables = array('content', 'setting', 'type','manage','class','student','members','result','message','adminlog','loginlog','resultset','friendlinks','ads'); 
foreach($tables as $tablename) {
	${'table_'.$tablename} = $tablepre.$tablename;
}
unset($tablename);
// set db
$db = new DB_Sql_vb;
$db->appname="论坛控制面板";
$db->appshortname="vBulletin (cp)";
$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;
$db->connect();
$db->query("SET NAMES '$charset'");
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

?>






