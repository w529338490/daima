<?php
include("conn/conn.php");
$type=$_POST[type];
$title=$_POST[title];
$content=$_POST[content];
$linkman=$_POST[linkman];
$tel=$_POST[tel];
//$edate=date("Y-m-d h:i:s");
$edate=date("Y-m-d H:i:s");
$sql=mysql_query("insert into tb_info(type,title,content,linkman,tel,checkstate,edate) values('$type','$title','$content','$linkman','$tel',0,'$edate')");
if($sql){
	echo "<script>alert('��ϲ������Ϣ�����ɹ���');window.location.href='release.php';</script>";
}else{
	echo "<script>alert('�Բ�����Ϣ����ʧ�ܣ�');history.back();</script>";
}
?>