<?php
include("../conn/conn.php");
$id=$_GET[id];
$flag=$_GET[flag];
$sql=mysql_query("delete from tb_advertising where id=$id");
if($sql){
	echo "<script>alert('����Ϣ�Ѿ�ɾ����');window.location.href='find_gg.php?flag=$flag';</script>";
}
else{
	echo "<script>alert('����Ϣɾ������ʧ�ܣ�');history.back();</script>";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
