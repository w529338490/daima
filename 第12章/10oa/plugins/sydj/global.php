<?php


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
$tablepre.="s_";
$tables = array('content', 'setting', 'class','manage','announcements','images','members','template','special','adminlog','loginlog','chajian','friendlinks','ads'); 
foreach($tables as $tablename) {
	${'table_'.$tablename} = $tablepre.$tablename;
}
unset($tablename);
// set db
$db = new DB_Sql_vb;
$db->appname="ÂÛÌ³¿ØÖÆÃæ°å";
$db->appshortname="vBulletin (cp)";
$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;
$db->connect();
$db->query("SET NAMES '$charset'");
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
?>






