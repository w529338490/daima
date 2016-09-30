<?php
include "./dbconnect.php";

$sql = mysql_query("select count(*) as num from room_ddz where player1_name = '$player_name' or player2_name = '$player_name' where ID = '".$_GET[ID]."'");
if(@mysql_result($sql, 0, num))
{
header("location:room_ddz.php?ID=".$_GET[ID]);
exit;
}else{

	$sql = mysql_query("select count(*) as num from user_ddz where name = '$player_name'");
	if(!@mysql_result($sql, 0, num))
	{
		header("location:index.php");
		exit;
	}
	$sql = mysql_query("select * from room_ddz where ID = '".$_GET[ID]."'");
	$num = mysql_num_rows($sql);
		if(!$num)
		die(参数有误！);
	$player1_name = mysql_result($sql, 0, player1_name);
	$player2_name = mysql_result($sql, 0, player2_name);
		if($player1_name && $player2_name)
		{
			header("location:hall.php");
			exit;
		}
	if($player1_name == '')
	{
		mysql_query("update room_ddz set player1_name = '$player_name', player1_time = '$ori_time', system_time = '$ori_time' where ID = '".$_GET[ID]."'");
		header("location:room_ddz.php?ID=".$_GET[ID]);
		exit;
	}
	if($player2_name == '')
	{
		mysql_query("update room_ddz set player2_name = '$player_name', player2_time = '$ori_time', system_time = '$ori_time' where ID = '".$_GET[ID]."'");
		header("location:room_ddz.php?ID=".$_GET[ID]);
		exit;
	}
}
?>