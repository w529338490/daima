<?php
include 'check.php';
include 'include/config.php';
include 'include/para.php';
$pageUrl=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������Ա� - <?php echo $gb_name?></title>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
<?php include 'include/head.php';?>
<div id="submit">
<?php if(empty($_POST['ac'])){?>
<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']?>" onSubmit="return FrontPage_Form1_Validator(this)">
<p><img src="images/admin_set.gif" /><img src="images/set.gif" /></p><br />
  <div id="submit_set_left"><ul>
  <li><a href="admin_mp.php">�޸Ĺ�������</a>
  <li><a href="admin_set.php">ϵͳ��������</a>
  </ul></div>

<div id="submit_set_right">
<label for="gb_name">���Ա������ƣ�</label><input type="text" name="gb_name" value="<?php echo $gb_name;?>" />* ����ʾ��IE������<br />

<label for="gb_logo">���Ա�LOGO��</label><input type="text"name="gb_logo" value="<?php echo $gb_logo;?>" />* ����ʾ�����Ͻ�<br />
<label for="index_url">��վ��ҳ��ַ��</label><input type="text" name="index_url" value="<?php echo $index_url;?>" />* �������վ��ҳ���ĵ�ַ<br />
<label for="email">ÿҳ����������</label>
<select name="pageT" id="pageT">
  <?php //��������
	$page_array=array('5','8','10','15','20','25');
	foreach($page_array as $pageT){
		if($page_==$pageT){
		echo "<option value=".$pageT." selected>".$pageT."</option>\n";
		}else{
		echo "<option value=".$pageT.">".$pageT."</option>\n";
		}
	}
	?>
 </select>�� <br />

<label for="comment">�������Լ����</label>
<select name="timejgT" id="timejgT">
<?php //��������
	$timejg_array=array('20','40','60','120','240','360');
	foreach($timejg_array as $timejgT){
		if($timejg==$timejgT){
		echo "<option value=".$timejgT." selected>".$timejgT."</option>\n";
		}else{
		echo "<option value=".$timejgT.">".$timejgT."</option>\n";
		}
	}
	?>
</select>�� (ͬһIP�������Ե�ʱ�������Է��ķ�����)<br />

<label for="replyadmtit">�ظ�ʱ��ʾ��</label><input type="text"name="replyadmtit" value="<?php echo $replyadmtit;?>"><br /> 
<label for="gb_logo">�������󿪹أ�</label><input name="ifauditing" type="checkbox" id="ifauditing" <?php if($ifauditing==1) echo 'checked';?> value="1">ѡ�д������������Ҫ����Ա��˺������ʾ<br /> 
<input name="ac" type="hidden" id="ac" value="gb_set">
<input type="submit" style="margin-left:110px;" name="Submit" value=" �� �� �� �� ">
</div>   
<div class="clear"></div>
<script language=JavaScript>
function FrontPage_Form1_Validator(theForm)
{
  if (theForm.gb_name.value == "")
  {
    alert("���Ա����Ʋ��ܿգ�");
    theForm.gb_name.focus();
    return (false);
  }
  if (theForm.gb_logo.value == "")
  {
    alert("���Ա�LOGO���ܿգ�");
    theForm.gb_logo.focus();
    return (false);
  }
  
  if (theForm.index_url.value == "")
  {
    alert("��վ��ҳ��ַ���ܿգ�");
    theForm.index_url.focus();
    return (false);
  }
   return (true);
}
</script>
</form>
<?php }else{?>

<div id="alertmsg">
<?php
$gb_name= $_POST["gb_name"];
$gb_logo=$_POST["gb_logo"];
$index_url=$_POST["index_url"];
$pageT= $_POST["pageT"];
$timejgT=$_POST["timejgT"];
$replyadmtit=$_POST["replyadmtit"];
$ifauditing=$_POST["ifauditing"];
			
$parafile="<"."?php

\$gb_name= '$gb_name';
\$gb_logo='$gb_logo';
\$index_url='$index_url';
\$page_= '$pageT';
\$timejg='$timejgT';
\$replyadmtit='$replyadmtit';
\$ifauditing='$ifauditing';
?".">";

// write the para file
$filenum = fopen ("include/para.php","w");
ftruncate($filenum, 0);
fwrite($filenum, $parafile);
fclose($filenum);
	echo "�����ѱ��棬���Ժ򡭡�<br><a href=".$pageUrl.">��������û���Զ����أ������˴�����</a>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=".$pageUrl."\">";
?>
</div>
<?php }?>
</div>
</div>
<?php include 'include/foot.php';?>
</body>
</html>