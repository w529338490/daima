<?php
include("../conn/conn.php");
$type=$_POST[type];
$flag=$_POST[flag]==""?0:1;
$title=$_POST[title];
$content=$_POST[content];
$linkman=$_POST[linkman];
$days=$_POST[days];
$tel=$_POST[tel];
$sdate=date("Y-m-d");
$showday=date("Y-m-d",(time()+3600*24*$days));
$sql=mysql_query("insert into tb_leaguerinfo(type,title,content,linkman,tel,sdate,showday,checkstate) values('$type','$title','$content','$linkman','$tel','$sdate','$showday',$flag)");
if($sql){
	echo "<script>alert('��Ϣ�����ɹ���'); parent.mainFrame.location.href='release_content.php';</script>";
}else{
	echo "<script>alert('��Ϣ����ʧ�ܣ�');history.back();</script>";
}
?>