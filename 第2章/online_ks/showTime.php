<?php 
session_start();
//����һ��XML��ʽ���
header('Content-Type: text/xml');
//��ȡ�û�����
	$dates=$_SESSION[dates];
    $dates2=mktime();
    $dates3=$dates2-$dates;
	echo date("i:s",$dates3);
?>