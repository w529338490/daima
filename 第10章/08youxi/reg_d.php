<?php
include "./dbconnect.php";
if($_POST[name] && $_POST[password] && $_POST[password_r])
{

if($_POST[password] != $_POST[password_r])
	message(两次输入的密码不一致，请重新填写！, "reg.php");
	
	if(strstr($_POST[name], "<"))
	message(账号不可包含.'"<"'.！, "reg.php");
	if(strstr($_POST[name], ">"))
	message(账号不可包含.'">"'.！, "reg.php");
	if(strstr($_POST[name], " "))
	message(账号不可包含空格！, "reg.php");
	
	$sql = mysql_query("select count(*) as num from user_ddz where name='".$_POST[name]."'");
	if(@mysql_result($sql, 0, num))
	message(抱赚，账号.$_POST[name].已经存在！, "reg.php");
	
	$query = mysql_query("INSERT INTO `user_ddz` (`ID`, `name`, `password`, `time`, `face`, `win`, `lost`, `run`, `score`) VALUES 
(NULL, '".$_POST[name]."', '".md5($_POST[password])."', 0, 1, 0, 0, 0, 0);");

	if($query)
	message(注册成功，请登陆游戏！, "index.php");
	else
	echo 注册失败！;
}else
message(资料填写不完整！, "reg.php");
?>