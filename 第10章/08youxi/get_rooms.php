<?php
include "./dbconnect.php";

$sql = mysql_query("select * from room_ddz");
$num = mysql_num_rows($sql);
echo "<table>";
for($i = 0;$i < $num;$i ++)
{
$player1_name = mysql_result($sql, $i, player1_name);
$player2_name = mysql_result($sql, $i, player2_name);
if($i % 1 == 3)
echo "</tr>";
if($i % 3 == 0)
echo "<tr>";
echo "<td align=center>";
	if($ori_time - mysql_result($sql, $i, system_time) > 30)
	mysql_query("update room_ddz set player1_name = '', player2_name = '', lord = '', player1_p = '', player2_p = '', lord_p = '', flag = '', player1_show = '', player2_show = '' where ID = '".mysql_result($sql, $i, ID)."'");
	echo "<table width=240><tr><td align=right width=80>&nbsp;<font color=white>".$player1_name."</font></td><td valign=middle align=center width=80><table align=center><tr><td align=center><font color=white><b>".mysql_result($sql, $i, name)."</b></font></td></tr><tr><td align=center><a href=room_ddz.php?ID=".mysql_result($sql, $i, ID)." title='".mysql_result($sql, $i, name)."'><img src=images/hall/table".(($player1_name || $player2_name)?'':'_blank').".gif border=0></a></td></tr></table></td><td align=left width=80><font color=white>".$player2_name."</font>&nbsp;</td></tr><tr><td colspan=3 align=center><font color=white>- ".($i + 1)." -</font></td></tr></table>";
echo "</td>";
}
echo "</table>";
?>