<?php
include 'check.php';
include 'include/config.php';
include 'include/para.php';

	$rs=$db->execute("select * from ".TABLE_PREFIX."gbconfig where id=1");
	if($db->num_rows($rs)!=0)
	{
	$rows=$db->fetch_array($rs);
	$db->free_result($rs);
	}
	
$pageUrl=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸Ĺ������� - <?php echo $gb_name?></title>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<script language=JavaScript>
function FrontPage_Form1_Validator(theForm)
{
  if (theForm.admin_pass.value == "")
  {
    alert("����дԭ���룡");
    theForm.admin_pass.focus();
    return (false);
  }
   if (theForm.admin_pass1.value == "")
  {
    alert("�����뻹û�����أ���");
    theForm.admin_pass1.focus();
    return (false);
  }
  if (theForm.admin_pass1.value.length<=2)
  {
    alert("������ڼ򵥣����3���ַ�");
    theForm.admin_pass1.focus();
    return (false);
  }
  if (theForm.admin_pass2.value == "")
  {
    alert("ȷ�����뻹û�����");
    theForm.admin_pass2.focus();
    return (false);
  }
  if (theForm.admin_pass1.value != theForm.admin_pass2.value)
  {
    alert("���벻һ�£�����");
    theForm.admin_pass1.focus();
    return (false);
  }
  return (true);
}
</script>
<body>
<div id="main">
<?php include 'include/head.php';?>
<div id="submit">
<?php if(empty($_POST['ac'])){?>
<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return FrontPage_Form1_Validator(this)">
	  <p><img src="images/admin_set.gif" /><img src="images/set.gif" /></p><br />
	  <div id="submit_set_left"><ul>
  <li><a href="admin_mp.php">�޸Ĺ�������</a>
  <li><a href="admin_set.php">ϵͳ��������</a>
  </ul></div>

<div id="submit_set_right">
	<label for="admin_pass">ԭʼ���룺</label><input type="text" name="admin_pass" />*<br />
	<label for="password">�����룺</label><input type="text" name="password" />*<br />
	<label for="admin_pass2">ȷ�������룺</label><input type="text" name="admin_pass2" />*<br />
	<input type="submit" id="sbutton" name="Submit" value="��ȷ���޸ġ�"> 
	<input name="ac" type="hidden" id="ac" value="modify">
</div> 
<div class="clear"></div>              
</form>
<?php }else{?>
<div id="alertmsg">
<?php
	include 'include/config.php';
	//echo md5($_POST['admin_pass']);
	$rs=$db->execute("select admin_pass,admin_user from ".TABLE_PREFIX."gbconfig where admin_pass='".md5($_POST['admin_pass'])."' and id=1");
	if($db->num_rows($rs)!=0){
		$db->update("update ".TABLE_PREFIX."gbconfig set admin_pass='".md5($_POST["admin_pass1"])."' where id=1");
			echo "�޸ĳɹ������Ժ򡭡�<br><a href=".$pageUrl.">��������û���Զ����أ������˴�����</a>";
			echo "<meta http-equiv=\"refresh\" content=\"2; url=".$pageUrl."\">";
	}else{
			echo "����ʧ�ܣ�ԭʼ���벻��ȷ�����ڷ��ء���<br><a href=".$pageUrl.">��������û���Զ����أ������˴�����</a>";
			echo "<meta http-equiv=\"refresh\" content=\"2; url=".$pageUrl."\">";
	}
	$db->free_result($rs);
?>
</div>
<?php }?>
</div>
</div>
<?php include 'include/foot.php';?>
</body>
</html>