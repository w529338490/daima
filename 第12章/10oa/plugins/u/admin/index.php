<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/


if (!$_SESSION["user_system_id"]){
	$referer="?filname=login";
	 showmessage("你没有登入！请重新输入",$referer);}
?>
<frameset cols="200,*" frameborder="no" border="0" framespacing="0" rows="*"> 
<frame name="left" noresize scrolling="yes" src="index.php?filename=left">
<frameset rows="20,*" frameborder="no" border="0" framespacing="0" cols="*"> 
<frame name="header" noresize scrolling="no" src="index.php?filename=header">
<frame name="right" noresize scrolling="yes" src="index.php?filename=main">
</frameset>
</frameset>
<noframes></noframes>