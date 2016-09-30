<?php
/*
凤鸣山中小学网络办公室
*/

unset($dbservertype);
//load config
require '../../config.php';
//require './config.php';
//load functions
require './include/functions.php';
$css="<LINK href=templates/$style/css/style.css rel=stylesheet type=text/css>";
// init db **********************
// load db class
$dbservertype = strtolower($dbservertype);
$dbclassname="./include/db_$dbservertype.php";
require "$dbclassname";
// load db table
$tablepre.="j_";
$tables = array('content', 'setting', 'type','manage','inform','product','members','template','borrow','adminlog','loginlog','chajian','friendlinks','ads'); 
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






