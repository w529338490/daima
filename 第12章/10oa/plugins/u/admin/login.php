<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

if($action=='login'){
$referer=$referer?$referer:'index.php';
//�Ƿ�ע�����֤�� 
if (!session_is_registered("check_name")){
	  $check_name = getcode(4,0);
    Session_Register("check_name"); 
    }
//�����֤���Ƿ�������ȷ     
if (($_SESSION["check_name"])!=$checkname){ 
	 session_unregister("check_name");
	 showmessage("�����������ע���Сд��",$referer);
	 }
//��ʽ��������ʺź����룬����ȡ�û���Ϣ
$username=addslashes($username);
$password=addslashes($password);
$password=md5($password);
$query="select * from members where username='$username' and password='$password' and groupid<5";
$result=$db->query($query);
//����Ƿ�Ϊע���ʺ� 
if($db->num_rows($result)==1){
      $r=$db->fetch_array($result);
      $user_id=$r[userid];                      //�û�idֵ
      $system_id=1;                             //ϵͳidֵ
      $user_system_id=$user_id."|".$system_id;  //�û���ϵͳidֵ
      Session_Register("user_system_id");
      showmessage("��¼�ɹ���",$referer);
//�ʺ����벻ƥ��
}else{
//loginfaile($_POST['realname'],$_POST['password']);
showmessage("�Բ����ʺź����벻ƥ�䣡��û��ͨ����ˣ���ȴ�",$referer);
}
//ע���ʺ�
}elseif($action=='logout'){
setcookie ("u_id", "", time()-3600);
session_unregister("user_system_id");
showmessage("���Ѿ��ɹ��˳�slcms����У԰����ϵͳ��","?");
//���·���ע����
}else{
Session_start();
$check_name = getcode(4,0);
Session_Register("check_name");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>school����Ӳ��ϵͳ</title>
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
    <td width="84" height="41" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>��&nbsp;&nbsp;�ţ�</font></b></td>
    <td width="247" align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="username" type="text" size="15" /></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>��&nbsp;&nbsp;�룺</font></b></td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="password" type="password" size="15" /></td>
  </tr>
  <tr>
    <td height="26" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg"><b><font color=FFFFFf>�����룺</font></b></td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input name="checkname" type="text" size="15" />
      <font color="#FF0000"><strong>��
      <?=$_SESSION["check_name"];?>
    ��</strong></font></td>
  </tr>
  <tr>
    <td height="34" align="center" valign="middle" background="admin/style/default/images/dlu_6.jpg">&nbsp;</td>
    <td align="left" valign="middle" background="admin/style/default/images/dlu_6.jpg"><input type="submit" name="login22" value=" �� ¼ " /></td>
  </tr>
  <tr>
    <td height="85" background="admin/style/default/images/dlu_16.jpg"><a href=reg.php target=_blank>ע��</a></td>
    <td height="85" background="admin/style/default/images/dlu_16.jpg">&nbsp;</td>
  </tr>
  </form>
</table>
</body>
</html>
<? }?>