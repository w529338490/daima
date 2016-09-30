<?
include("../../Configuration.php");
include("../../include/authorizemanager.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
$d->query("set names utf8"); 
?>