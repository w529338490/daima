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
<title>ǩд���� - <?php echo $gb_name?></title>
<script language="JavaScript" type="text/javascript" src="include/checkform.js"></Script>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<body onload="i=0">
<div id="main">
<?php include 'include/head.php';?>
<div id="submit">
<?php if(session_is_registered('timer') && time() - $_SESSION['timer'] <$timejg){?>
<div id="alertmsg">
�Բ��������Ǹ����Թ�����<?php echo $timejg;?>��������ԡ���������ȴ���<?php echo abs($timejg-(time()-$_SESSION['timer']))?>��<br>
<a href="javascript:history.back();">���û���Զ����أ������˴��ֶ�����</a>
</div>
<?php 
	echo "<meta http-equiv=\"refresh\" content=\"3; url=index.php\">";
}else{
	if(empty($_POST['ac'])){
?>


<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']?>" onSubmit="return FrontPage_Form1_Validator(this)">
<p><img src="images/i1.gif" /><img src="images/add.gif" /></p><br />
<label for="user">�ǳƣ�</label><input type="text" id=username name="username" value="" />*<br />
<label for="email">Email��</label><input type="text" id=email name="email" value="" /><br />
<label for="comment">���ݣ�</label><textarea id=content name="content"></textarea>*<br />
<label for="comment">��</label><span>�ύ֮ǰ���Ȱ�CTRL+C���������������ݣ��������������ʧ��
������������5���ַ���</span><br />
<label for="email">���Ļ���</label>
<input name="ifqqh" type="checkbox" id="ifqqh" value="1"> <span>��ѡ��ʱ��������ֻ�й���Ա�ɼ�</span><br />
<label for="umum">��֤�룺</label><input name="unum" type="text" id="unum" size="10">* <img src="include/randnum.php?id=-1" title="���ˢ��" style="cursor:pointer" onclick=eval('this.src="include/randnum.php?id='+i+++'"')><br />
<input type="submit" id="sbutton" value="ȷ  ��" /><br /><input name="ac" type="hidden" id="ac" value="add">
</form>

<?php }else{?>
<div id="alertmsg">

            <?php
		 if($_POST['unum']==$_SESSION["randValid"]){
			$username=addslashes(htmlspecialchars($_POST['username']));
			$email=addslashes(htmlspecialchars($_POST['email']));
			$content=addslashes(htmlspecialchars($_POST['content']));
			$userip=$_SERVER["REMOTE_ADDR"];
			$ifqqh=$_POST["ifqqh"];
			if(empty($ifqqh)) $ifqqh=0;
			$systime=date("Y-m-d H:i:s");
			if(!empty($content) or !empty($username)){
			$ifshow="";
			//��ԭ�ո�ͻس�
			if(!empty($content)){
				$content=str_replace("��","",$content);
				$content=ereg_replace("\n","<br>����",ereg_replace(" ","&nbsp;",$content));
			}
			if($ifauditing==1){$ifshow=0;}else{$ifshow=1;}
			//��ԭ����
			$sql="insert into ".TABLE_PREFIX."guestbook(username,email,content,userip,systime,ifshow,ifqqh)values('".$username."','".$email."','".$content."','".$userip."','".$systime."',".$ifshow.",".$ifqqh.")";
			//echo $sql;
				if(($db->insert($sql))>0){
					$_SESSION['timer']=time();
					echo "��ϲ�����Գɹ������ڷ������Ժ򡭡�<br><a href=index.php>�����Ե���ֶ�����</a>";
					echo "<meta http-equiv=\"refresh\" content=\"3; url=index.php\">";
				}else{
					echo "����ʧ�ܣ���Ϣ�п��ܺ��������ַ������ڳ������е������ַ�����";
					echo "<meta http-equiv=\"refresh\" content=\"5; url=".$_SERVER['PHP_SELF']."\">";
				}
			}else{
				echo "�ǳƺ��������ݲ��ܿգ���������ڷ��ء���<br><a href=index.php>�����Ե���ֶ�����</a>";
				echo "<meta http-equiv=\"refresh\" content=\"3; url=".$_SERVER["HTTP_REFERER"]."\">";
			}
		}else{
			echo "<script language=\"javascript\">alert('�Բ�����֤�벻��ȷ�����������롭��');history.back()</script>";
		}
			?>
</div>
<?php }}?>
</div></div>
<?php include 'include/foot.php';?>
</body>
</html>