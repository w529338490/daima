<?php
include("../conn/conn.php");
$id=$_GET[id];
$type=$_GET[type];
$state=$_GET[state];
$sql=mysql_query("update tb_info set checkstate=1 where id=$id");
if($sql){
	echo "<script>alert('����Ϣ�Ѿ�ͨ����ˣ�');window.location.href='find_mianfei.php?type=$type&state=$state';</script>";
}
else{
	echo "<script>alert('����Ϣ��˲���ʧ�ܣ�');history.back();</script>";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
