<?php
include "./dbconnect.php";
	$sql = mysql_query("select * from room_ddz where ID = '".$_GET[ID]."'");
	$num = mysql_num_rows($sql);
if($_GET[p_show_var] == '')
$_GET[p_show_var] = 'NO,';
	$pai = mysql_result($sql, 0, $_GET[player_ID]._p);
	$e_pai = explode(",", $pai);
	$e_p_show_var = explode(",", $_GET[p_show_var]);
	for($i = 0;$i < sizeof($e_pai) - 1;$i ++)
	{
		$flag = 1;
		for($j = 0;$j < sizeof($e_p_show_var) - 1;$j ++)
		{
			if($e_pai[$i] == $e_p_show_var[$j])
			$flag = 0;
		}
		if($flag)
		$pai_new .= $e_pai[$i].",";
	}

	mysql_query("update room_ddz set ".$_GET[player_ID]."_p = '$pai_new', ".$_GET[player_ID]."_show = '".$_GET[p_show_var]."', flag = '".($_GET[player_ID] == player1?'player2':'player1')."' where ID = '".$_GET[ID]."'");
?>