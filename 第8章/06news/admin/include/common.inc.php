<?php
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_PARSE);
@set_time_limit(0);
//获取程序所在目录及后台目录
define('ROOTPATH_ADMIN', substr(dirname(__FILE__), 0, -7));
DIRECTORY_SEPARATOR == '\\'?@ini_set('include_path', '.;' . ROOTPATH_ADMIN):@ini_set('include_path', '.:' . ROOTPATH_ADMIN);
$DS=DIRECTORY_SEPARATOR;
$url_array=explode($DS,ROOTPATH_ADMIN);
$count = count($url_array);
$last_count=$count-2;
$last_count=strlen($url_array[$last_count])+1;
define('ROOTPATH', substr(ROOTPATH_ADMIN, 0, -$last_count));

PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
session_cache_limiter('private, must-revalidate'); 
@ini_set('session.auto_start',0); //自动启动关闭
if(PHP_VERSION < '4.1.0') {
	$_GET         = &$HTTP_GET_VARS;
	$_POST        = &$HTTP_POST_VARS;
	$_COOKIE      = &$HTTP_COOKIE_VARS;
	$_SERVER      = &$HTTP_SERVER_VARS;
	$_ENV         = &$HTTP_ENV_VARS;
	$_FILES       = &$HTTP_POST_FILES;
}
require_once dirname(__file__).'/global.func.php';
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
isset($_REQUEST['GLOBALS']) && exit('Access Error');

$settings = parse_ini_file(ROOTPATH.'config/config.inc.php');
@extract($settings);

foreach(array('_COOKIE', '_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key{0} != '_' && $$_key = daddslashes($_value);
	}
}

(!MAGIC_QUOTES_GPC) && $_FILES = daddslashes($_FILES);
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
$t_array = explode(' ',microtime());
$P_S_T	 = $t_array[0] + $t_array[1];
$met_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') :ob_start();
//if (!$m_check_referer) $_SESSION['mvm_sess_referer'] = getenv('HTTP_REFERER');
$referer?$forward=$referer:$forward=$_SERVER['HTTP_REFERER'];
$char_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#','%','?');
$m_now_time     = time();
$m_now_date     = date('Y-m-d H:i:s',$m_now_time);
$m_now_counter  = date('Y-m-d',$m_now_time);
$m_now_month    = date('Ym',$m_now_time);
$m_user_agent   =  $_SERVER['HTTP_USER_AGENT'];
if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$m_user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif($_SERVER['HTTP_CLIENT_IP']){
	$m_user_ip = $_SERVER['HTTP_CLIENT_IP'];
} else{
	$m_user_ip = $_SERVER['REMOTE_ADDR'];
}
$m_user_ip  = preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$m_user_ip) ? $m_user_ip : 'Unknown';
$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
//$m_mall_skin_dir    = ROOTPATH."templates";
$db_settings = parse_ini_file(ROOTPATH.'config/config_db.php');
@extract($db_settings);
require_once ROOTPATH.'config/tablepre.php';

//$imgpath = "images/$mm_skin_name";
//执行session类
//require_once ROOTPATH.'include/session.class.php';
//!$session_save_dir&& $session_save_dir='./forumdata/session'; //存取的目录
//!$session_lifetime && $session_lifetime= get_cfg_var('session.gc_maxlifetime'); //SESSION的存活期
//PHPVERSION()<'5'?mvm_session::handler():eval(mvm_session::handler());
session_start();
$metinfo_admin_name     = $_SESSION['metinfo_admin_name'];
$metinfo_admin_pass     = $_SESSION['metinfo_admin_pass'];
$metinfo_admin_pop     = $_SESSION['metinfo_admin_pop'];

// 语言选择
if($met_language_method == "zh_cn") {
	include_once ROOTPATH_ADMIN.'language/language_china.php';
} elseif($met_language_method == "English") {
	include_once  ROOTPATH_ADMIN.'language/language_english.php';
} else {
	include_once ROOTPATH_ADMIN.'language/language_china.php';	
}

// MYSQL数据库连接
require_once ROOTPATH_ADMIN.'include/mysql_class.php';
$db = new dbmysql();
$db->dbconn($con_db_host,$con_db_id,$con_db_pass,$con_db_name);

//后台风格
$met_skin="met";

//显示参数转换
$met_e_seo=stripslashes($met_e_seo);
$met_c_seo=stripslashes($met_c_seo);
$met_c_foottext=stripslashes($met_c_foottext);
$met_e_foottext=stripslashes($met_e_foottext);
$met_c_footright=stripslashes($met_c_footright);
$met_c_footother=stripslashes($met_c_footother);
$met_e_footright=stripslashes($met_e_footright);
$met_e_footother=stripslashes($met_e_footother);


