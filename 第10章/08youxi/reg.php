<?php
include "./dbconnect.php";
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
	background:url(images/f_bg.gif);
	color:#FFFFFF;
	FONT-SIZE: 15px
}
.box_input{
	padding:1px 1px 1px 1px;
	border:1px solid #206300;
	background:#387800;
	color:#FFFFFF;
	FONT-SIZE: 15px
}
.box_submit{
	padding:1px 1px 1px 1px;
	border:1px solid #E19D00;
	background:#FFDC04;
	color:#000000;
	FONT-SIZE: 15px;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="landlord onWeb" />
<meta name="author" content="mickie" />
<meta name="keyword" content="mickiedd" />
<meta name="description" content="qq155448883,CSUST" />
<title>注册</title>
</head>

<body bgcolor="#EBF6E8">
<?php
if(isset($_COOKIE[message]))
{
	echo "<div align=center>".$_COOKIE[message]."</div>";
	setcookie(message, NULL);
}
?>
<form name=form method=post action=reg_d.php>
<br />
<br />

<table class="box" align=center><tr><td width="222">
	<table>
	<tr><td width="75" align="right">账号：</td>
	<td width="129" colspan=2><input class="box_input" type=text name=name size=12 maxlength=12></td></tr>
	<tr><td align="right">密码：</td>
	<td colspan=2><input class="box_input" type=password name=password size=12 maxlength=25></td></tr>
	<tr><td align="right">确认密码：</td>
	<td colspan=2><input class="box_input" type=password name=password_r size=12 maxlength=12></td></tr>
	<tr><td></td><td colspan=2><input class="box_submit" type=submit name=submit value=提交></td></tr>
	</table>
</td></tr></table>
</form>
</body>
</html>
