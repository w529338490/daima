<?php

require_once('include/sql_class.php');
$db=new db_Mysql(); 
$db->dbServer  = 'localhost';
$db->dbbase   = 'gbook';
$db->dbUser  = 'root';
$db->dbPwd  = '1234';
$db->dbconnect(); 

define('MCBOOKINSTALLED', true);
define('TABLE_PREFIX', "ly_");

if (PHP_VERSION > '5.0.0'){
date_default_timezone_set('PRC');
}

?>