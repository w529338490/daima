<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

$query="select * from members where username='$user_name' and groupid>0";
$r=$db->query_first($query);
$user_admining=$r[admining];
$user_group=$r[groupid];
if ($user_group>98) showmessage("对不起，你没有权限访问！");
$query = $db->query("SELECT * FROM sl_chajian ORDER BY id DESC;");
while($r = $db->fetch_array($query)) {
			$chajian .= " <a href=$r[path] target=_top>$r[title]</a> |";
				          
		}
?>
<body leftmargin="0" topmargin="0">
<table cellspacing="0" cellpadding="2" border="0" width="100%" height="100%" bgcolor="#FFFFFF">
<tr valign="middle"  align="center">
<td></td>
<td></td>
<td></td>
<td><a href="../index.php" target="_blank">网站首页</a> | <a href=../admin.php target=_top>校园文章管理系统</a> |<?=$chajian;?> <a href="?filename=login&action=logout" target="_top">退出</a></TD>
</tr>
</table>
<SCRIPT language=Javascript></SCRIPT>
</body>
