<?php 
//����һ��XML��ʽ���
header('Content-Type: text/xml');
//����XMLͷ
echo '<?xml version="1.0" encoding="gb2312" standalone="yes" ?>';
//����<response>Ԫ��
echo '<response>';
//��ȡ�û�����

$online_tel=$_GET[online_tel];
$online_address=$_GET[online_address];
$online_number=substr(mt_rand(100000,999999),0,6);
$online_pass=substr(mt_rand(100000,999999),0,6);
//���ݴӿͻ��˻�ȡ���û��������
include("conn/conn.php");
$query=mssql_query("insert into tb_user(online_user,online_tel,online_address,online_number,online_pass) values('$online_user','$online_tel','$online_address','$online_number','$online_pass')");
if($query==true){
echo $online_user=$_GET[online_user];
	echo "�û�ע��ɹ�����������׼��֤����$online_number.������$online_pass.";
}
	//�ر�<response>Ԫ��
	echo '</response>';
?>
