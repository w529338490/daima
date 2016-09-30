<?php
include "./dbconnect.php";
	$sql = mysql_query("select * from room_ddz where ID = '".$_GET[ID]."'");
	$num = mysql_num_rows($sql);

	$lord = mysql_result($sql, 0, lord);
	
	if($_GET[action] == no)
	{
		if($_GET[player_ID] == player1)
		$_GET[player_ID] = player2;
		else
		$_GET[player_ID] = player1;
	}
	
	if($lord == '')
	mysql_query("update room_ddz set ".$_GET[player_ID]."_p = '".mysql_result($sql, 0, $_GET[player_ID]._p).mysql_result($sql, 0, lord_p)."', lord = '".$_GET[player_ID]."', flag = '".$_GET[player_ID]."' where ID = '".$_GET[ID]."'");
?>