<?php
/*
����ɽ��Сѧ����칫��
*/
$sql="select softpath from $table_soft where softid='$softid'";
$re=$db->query_first($sql);
$rmpath="./".$uppath."attach/".$re[softpath];
unlink($rmpath);
$sql="DELETE FROM $table_soft WHERE softid = '$softid'";
$db->query($sql);
?>