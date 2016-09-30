<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

if($action=='login'){
$referer=$referer?$referer:'index.php';
//是否注册过验证码 
if (!session_is_registered("check_name")){
	  $check_name = getcode(4,0);
    Session_Register("check_name"); 
    }
//检测验证码是否输入正确     
if (($_SESSION["check_name"])!=$checkname){ 
	 session_unregister("check_name");
	 showmessage("附加码错误，请注意大小写！",$referer);
	 }
//格式化输入的帐号和密码，并读取用户信息
$username=addslashes($username);
$password=addslashes($password);
$password=md5($password);
$query="select * from members where username='$username' and password='$password' and groupid<5";
$result=$db->query($query);
//检测是否为注册帐号 
if($db->num_rows($result)==1){
      $r=$db->fetch_array($result);
      $user_id=$r[userid];                      //用户id值
      $system_id=1;                             //系统id值
      $user_system_id=$user_id."|".$system_id;  //用户和系统id值
      Session_Register("user_system_id");
      showmessage("登录成功！",$referer);
//帐号密码不匹配
}else{
//loginfaile($_POST['realname'],$_POST['password']);
showmessage("对不起，帐号和密码不匹配！你没有通过审核，请等待",$referer);
}
//注销帐号
}elseif($action=='logout'){
setcookie ("u_id", "", time()-3600);
session_unregister("user_system_id");
showmessage("你已经成功退出slcms数字校园管理系统！","?");
//重新分配注册码
}else{
Session_start();
$check_name = getcode(4,0);
Session_Register("check_name");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>school网络硬盘系统</title>
<style type="text/css">

</style>
<script language="JavaScript">
function checkall(form) {
	for(var i = 0;i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall' && e.disabled != true) {
			e.checked = form.chkall.checked;
		}
	}
}

function redirect(url) {
	window.location.replace(url);
}
</script>
</head>
<body>
<table width="690" border="0" cellpadding="0" cellspacing="0" align=center>
<tr>
<td height=150>&nbsp;</td>
</tr>
   <form name="form1" method="post" action="?filename=login&action=login&referer=<?=$referer;?>">
  <!--DWLayoutTable-->
  <tr>
    <td height="46" colspan="3" background="admin/style/default/images/dlu_1.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td width="354" rowspan="5" background="admin/style/default/images/dlu_2.jpg">&nbsp;</td>
    <td width="84" height="41" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>帐&nbsp;&nbsp;号：</font></b></td>
    <td width="247" align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="username" type="text" size="15" /></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>密&nbsp;&nbsp;码：</font></b></td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="password" type="password" size="15" /></td>
  </tr>
  <tr>
    <td height="26" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>附加码：</font></b></td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="checkname" type="text" size="15" />
      <font color="#FF0000"><strong>（
      <?=$_SESSION["check_name"];?>
    ）</strong></font></td>
  </tr>
  <tr>
    <td height="34" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg">&nbsp;</td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input type="submit" name="login22" value=" 登 录 " /></td>
  </tr>
  <tr>
    <td height="85" background="admin/style/default/images/dlu_16.jpg"><a href=reg.php target=_blank>注册</a></td>
    <td height="85" background="admin/style/default/images/dlu_16.jpg">&nbsp;</td>
  </tr>
  </form>
</table>
</body>
</html>
<? }?>