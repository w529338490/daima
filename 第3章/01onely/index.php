<?php 
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start(); include 'include/config.php';include 'include/para.php';include 'include/page_.php';
$pager = new Page;
$page=$_GET['page'];if(empty($page)) $page=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������� - <?php echo $gb_name?></title>
<script language="JavaScript" type="text/javascript" src="include/checkform.js"></Script>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<body onload="i=0">
<?php
if(!defined('MCBOOKINSTALLED')){?><div id="alertmsg"></div><?php exit();}?>
<!--�������Ҫ����ʼ-->
<div id="main">
  <?php include 'include/head.php';?>
  <div id="list">
    <div id="listmain">
<?php
	$sql="select * from ".TABLE_PREFIX."guestbook order by settop desc,id desc";
	$total=$db->get_rows($sql);//ֱ��ȡ����¼����������ҳ֮��
	if($total!=0)//�жϼ�¼�Ƿ�Ϊ��
	{
		$pager->pagedate($page_,$total,"?page");

		$rs=$db->execute($sql." limit $offset,$pagesize");
		while($rows=$db->fetch_array($rs))
		{
?>
<h2>
<span class="leftarea">
<img src="images/icon_write.gif" /> <?php echo $rows['username']?> <font style="color:#999;">�� <?php echo date("Y-m-d H:i",strtotime($rows["systime"]));?> �������ԣ�</font>
<?php if(date("Y-m-d",strtotime($rows["systime"]))==date("Y-m-d"))  echo '<img src=images/new.gif>';?>		
<?php if($rows['settop']!=0) echo '<img src=images/settop.gif alt=���ö�>';?>
</span>
<span class="midarea">
<?php if(!empty($_SESSION['admin_pass'])){
if($ifauditing==1){ 
if($rows['ifshow']==0){?>
<a href="admin_action.php?ac=setshow&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="images/setshow.gif" alt="��˲���ʾ" /></a>
<?php }else{?>
<a href="admin_action.php?ac=unshow&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="images/unshow.gif" alt="���ش�����" /></a>
<?php }}?>
<a href="javascript:if(confirm('ȷ��ɾ��������?'))location='admin_action.php?ac=delete&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>'"><img src="images/icon_del.gif" alt="ɾ��������" /></a> <a href="edit.php?id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="images/icon_rn.gif" alt="�༭/�ظ�������" /></a>
<?php if($rows['settop']==0){?>
<a href="admin_action.php?ac=settop&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="images/settop.gif" alt="���������ö�" /></a>
<?php }else{?>
<a href="admin_action.php?ac=unsettop&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="images/unsettop.gif" alt="ȡ���ö�" /></a>
<?php }}?>
</span>
<span class="rightarea">
<?php if(!empty($rows['email'])){?>
<a href="mailto:<?php echo $rows['email']?>"><img src="images/email.gif" alt="�����OutLook�����ʼ�����<?php echo $rows['email']?>"></a> 
<?php }?><?php if(!empty($_SESSION['admin_pass'])){?>
<img src="images/ip.gif" alt="������IP��<?php echo $rows['userip'];?>"> 
<?php }?>
</span></h2>
<div class="content">
<?php 
if(empty($_SESSION['admin_pass'])){
	if($rows["ifqqh"]==1){
			echo '<span class=ftcolor_999>��������Ϊ���Ļ���ֻ�й���Ա���ܿ�Ŷ������</span>';
	}elseif($ifauditing==1){
		if($rows['ifshow']==0){
			echo '<span class=ftcolor_999>������������ͨ����ˣ���ǰ���ɼ�������</span>';
		}else{
			echo $rows['content'];
		}
	}else{
		echo $rows['content'];
	}
}else{
	echo $rows['content'];
}
?>
</div>
<?php

if(!empty($rows['reply'])){?>
<div class="reply"><p><span class="ftcolor_FF9"><b><?php echo $replyadmtit;?>��</b><?php echo date("Y-m-d H:i",strtotime($rows["replytime"]));?></span></p>
<?php echo $rows['reply'];?>
</div>
<?php 
}}
//��¼��ѭ������
$db->free_result($rs);
}else{
echo 'û�����ԡ���';
}//����жϼ�¼��Ϊ�ս���
?>
</div><!--listmain����-->
</div><!--list����-->
<div class="clear"></div>
<div id="pages" align="center">����������<?php echo $total;?> �� ��<?php $pager->pageshow();?></div>
<div class="clear"></div>
<div id="submit">
<form name="form1" method="post" action="add.php" onSubmit="return FrontPage_Form1_Validator(this)">
<p><img src="images/i1.gif" /><img src="images/add.gif" /></p><br />
<label for="user">�ǳƣ�</label><input type="text" id="username" name="username" value="" />*<br />
<label for="email">Email��</label><input type="text" id="email" name="email" value="" /><br />
<label for="comment">���ݣ�</label><textarea id=content name="content"></textarea>*<br />
<label for="comment">��</label><span>�ύǰ�밴Ctrl+C�����������ݣ��������������ʧ��
�������ݲ�������5���ַ���</span><br />
<label for="email">���Ļ���</label>
<input name="ifqqh" type="checkbox" id="ifqqh" value="1"> <span>��ѡ��ʱ��������ֻ�й���Ա�ɼ�</span><br />
<label for="umum">��֤�룺</label><input name="unum" type="text" id="unum" size="10">* <img src="include/randnum.php?id=-1" title="���ˢ��" style="cursor:pointer" onclick=eval('this.src="include/randnum.php?id='+i+++'"')>
<br />
<input type="submit" id="sbutton" value="ȷ  ��" /><br /><input name="ac" type="hidden" id="ac" value="add">
</form>
</div>
<!--�������Ҫ�������-->
</div>
<?php include 'include/foot.php';?>
</body>
</html>