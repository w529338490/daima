<?php include("conn/conn.php");
$online_number=$_POST[online_number];
$online_pass=$_POST[online_pass];

$query=mssql_query("select * from tb_user where online_number='$online_number' and online_pass='$online_pass'");
if(mssql_num_rows($query)>0){
session_register(online_number);
echo "<script> alert('��¼�ɹ�!'); window.location.href='index.php?online=���뿼��';</script>";
}else{
echo "��¼ʧ��!";
}
?>