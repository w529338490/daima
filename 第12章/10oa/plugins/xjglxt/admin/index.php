<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/


if (!$_SESSION["user_id"]){
	$referer="?filname=login";
	 showmessage("��û�е��룡",$referer);}
?>
<frameset cols="200,*" frameborder="no" border="0" framespacing="0" rows="*"> 
<frame name="left" noresize scrolling="yes" src="index.php?filename=left">
<frameset rows="20,*" frameborder="no" border="0" framespacing="0" cols="*"> 
<frame name="header" noresize scrolling="no" src="index.php?filename=header">
<frame name="right" noresize scrolling="yes" src="index.php?filename=main">
</frameset>
</frameset>
<noframes></noframes>