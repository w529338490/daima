<?php
/*
����ɽ��Сѧ����칫��
*/
unset($dbservertype);
//load config
require './config.php';
//*******************init*****************************************************
// load db class
$dbservertype = strtolower($dbservertype);
$dbclassname="./include/db_$dbservertype.php";
require_once "$dbclassname";
// load db table
$tables = array('content', 'setting', 'type','manage','soft','articles','members','images','message','adminlog','loginlog','chajian','friendlinks','ads','soft',
                'leave','schedule','file','message','letter','userinfo','favorite','classtable',
                'y_class','y_type','y_setting','y_content','ftp'
                );
foreach($tables as $tablename) {
	${'table_'.$tablename} = $tablepre.$tablename;
}
unset($dbclassname,$dbservertype,$tables,$tablename,$dbservertype);
// set db
$db = new FMysql;
$db->appname="���С��";
$db->appshortname="У԰2010����칫��";
$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;
$db->connect();
$db->query("SET NAMES '$charset'");
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
//load functions
require_once './include/functions.php';
//**************************init Micro Template**********************************
//load Micro Template
require_once('./include/tpl.class.php');
//set Micro Template
$templates_dir='./templates/'.$style.'/html';
$tpl = new MicroTpl($templates_dir);
$tpl->force_html=$force_html;
unset($templates_dir);
$css="<LINK href=templates/$style/css/style.css rel=stylesheet type=text/css>";
?>






