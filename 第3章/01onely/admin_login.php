<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include 'include/config.php';
include 'include/para.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����¼ - <?php echo $gb_name?></title>
<link href="css/css.css" rel="stylesheet" type="text/css">

 <script language=JavaScript>
function FrontPage_Form1_Validator(theForm)
{
  if (theForm.admin_user.value == "")
  {
    alert("���������Ա�ʺţ�");
    theForm.admin_user.focus();
    return (false);
  }
  if (theForm.admin_pass.value == "")
  {
    alert("���������Ա���룡");
    theForm.admin_pass.focus();
    return (false);
  }
  if (theForm.unum.value == "")
  {
    alert("����������֤�룡");
    theForm.unum.focus();
    return (false);
  }
   return (true);
}
</script>
</head>
<body onload="i=0;document.getElementsByName('unum')[0].value=''">
<div id="main">
<?php include 'include/head.php';?>
<div id="submit">
<?php if(empty($_POST['action'])){?>
<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return FrontPage_Form1_Validator(this)">
<p><img src="images/i3.gif" /><img src="images/login.gif" /></p><br />
<div id="submit_div">
<label for="admin_user">����Ա�˺ţ�</label><input name="admin_user" type="text" id="admin_user"><br />
<label for="admin_pass">����Ա���룺</label><input name="admin_pass" type="password" id="admin_pass"><br />
<label for="unum">��¼��֤�룺</label>
<input name="unum" type="text" id="unum" size="10">* <img src="include/randnum.php?id=-1" title="���ˢ��" style="cursor:pointer" onclick=eval('this.src="include/randnum.php?id='+i+++'"')><br />
<input type="submit" id="sbutton" value="ȷ  ��" /><br /><input name="action" type="hidden" value="add">
</div>
</form>

<?php }else{?>
<div id="alertmsg">
<?php
		 if($_POST['unum']==$_SESSION["randValid"]){
			$admin_user=$_POST['admin_user'];
			$admin_pass=md5($_POST['admin_pass']);
			$rs=$db->execute("select admin_user,admin_pass from ".TABLE_PREFIX."gbconfig where admin_user='".$admin_user."'");
				if($db->num_rows($rs)!=0){
					//Check PASSWORD
					///////////////////////////////////////////////////////////
					$row=$db->fetch_array($rs);
					$db->free_result($rs);
					if($row['admin_pass']==$admin_pass){

						$_SESSION['admin_pass']=$admin_pass;
						echo "�ɹ���¼�����Ժ򡭡�<br><a href=".$pageUrl.">��������û���Զ����أ������˴�����</a>";
						echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
						
					}else{
						echo "<script language=\"javascript\">alert('���벻��ȷ��');history.go(-1)</script>";
					}
				}else{
					echo "<script language=\"javascript\">alert('�����ʺŲ���ȷ��');history.go(-1)</script>";
				}
		}else{
			echo "<script language=\"javascript\">alert('��֤�벻��ȷ�����������롭��');history.go(-1)</script>";
		}
?>
</div>
<?php }?>
</div>
</div>
<?php include 'include/foot.php';?>
</body>
</html>