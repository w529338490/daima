<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

unset($dbservertype);
//load config
require '../../config.php';
//require './config.php';
//set
$uppath="../../".$uppath."u/";
$uptemp="../../".$uptemp;
$renamed=1;
//load functions
require './include/functions.php';
require './include/phpzip.inc.php';
$css="<LINK href=templates/$style/css/style.css rel=stylesheet type=text/css>";
// init db **********************
// load db class
$dbservertype = strtolower($dbservertype);
$dbclassname="./include/db_$dbservertype.php";
require "$dbclassname";
// load db table
$tablepre.="u_";
$tables = array('file', 'folder','members'); 
foreach($tables as $tablename) {
	${'table_'.$tablename} = $tablepre.$tablename;
}
unset($tablename);
// set db
$db = new DB_Sql_vb;
$db->appname="��̳�������";
$db->appshortname="vBulletin (cp)";
$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;
$db->connect();
$db->query("SET NAMES '$charset'");
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
//load Micro Template
require_once('../../include/tpl.class.php');
//set Micro Template
$templates_dir='./templates/'.$style.'/html';
$cache_dir='../../cache/u';
$html_dir='../../cache/u/html';
$tpl = new MicroTpl($templates_dir,$cache_dir,$html_dir);
?>






