<?php
include "./dbconnect.php";
if($player_name != '' && $player_name != 'guest')
{
	header("location:hall.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
body{
font-size:15px;
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: underline
}
A:active {
	COLOR: #000000; TEXT-DECORATION: none
}
A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
.box{
	padding:1px 1px 1px 1px;
	border:1px solid #487524;
	color:#000;
	FONT-SIZE: 15px;
	text-align: right;
}
.box_input{
	padding:1px 1px 1px 1px;
	border:1px solid #206300;
	color:#FFFFFF;
	FONT-SIZE: 15px;
	background-color: #FCF;
}
.box_submit{
	padding:1px 1px 1px 1px;
	border:1px solid #E19D00;
	background:#FFDC04;
	color:#000000;
	FONT-SIZE: 15px;
}

.banq {
	font-size: 12px;
}
.p {
	text-align: center;
	font-size: 36px;
	color: #900;
	font-weight: bold;
}
.box tr td table tr td a font b {
	color: #900;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="landlord onWeb" />
<meta name="author" content="mickie" />
<meta name="keyword" content="mickiedd" />
<meta name="description" content="qq155448883,CSUST" />
<title>开心斗地主|在线斗地主</title>

</head>

<body bgcolor="#EBF6E8">
<p>
  <?php
if(isset($_COOKIE[message]))
{
	echo "<div align=center>".$_COOKIE[message]."</div>";
	setcookie(message, NULL);
}
?>
</p>
<p>&nbsp;</p>
<p>&nbsp; </p>  <br />
<br />
  <br />
<br />
  <br />
<br />
  <br />
<br />
<div class="p">开心斗地主</div><br />
<br />
<form name=form method=post action=login_d.php>


<table class="box" align=center><tr><td width="317">
	<table width="306" align="center">
	<tr><td colspan="2"></td></tr>
	<tr>
	  <td width="59" align="left">账 号：</td>
	<td width="235"><input class=box_input type=text name=name id=name size=28 maxlenth=12></td></tr>
	<tr>
	  <td align="left">密 码：</td>
	<td><input class=box_input type=password name=password id=password size=28 maxlenth=25></td></tr>
	<tr><td></td><td><input class=box_submit type=submit name=submit_button id=submit_button value=登录> 
	  <a href=reg.php><font color=white><b> 注册</b></font></a></td></tr>
	</table>
</td></tr></table>
</form>
<br /><br /><br />
<div align="center" class="banq">开发笔记 技术支持</div>
</body>
</html>
