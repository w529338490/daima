<?php 
session_start();
//����һ��XML��ʽ���
header('Content-Type: text/xml');
//����XMLͷ
	$dates=$_SESSION[dates];
    $dates1=$dates+20*60;

	$dates2=mktime();
    $dates3=$dates1-$dates2;
	echo date("i:s",$dates3);
	//�ر�<response>Ԫ��

?>