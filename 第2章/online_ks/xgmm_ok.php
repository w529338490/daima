<?php session_start(); include("conn/conn.php");
if($_SESSION[online_number]==true){

$number=$_POST[online_number];
$pass=$_POST[online_pass];
$passes=$_POST[online_pass2];
	$query=mssql_query("select * from tb_user where online_number='$number' and online_pass='$pass'");
	if(mssql_num_rows($query)<1){
		echo "<script>alert('�������׼��֤��������벻�������������룡'); window.location.href='index.php?online=�޸�����';</script>";
	}else{
		$querys=mssql_query("update tb_user set online_pass='$passes' where online_number='$number'");
		if($querys){
			echo "<script>alert('������³ɹ���'); window.location.href='index.php?online=�޸�����';</script>";
		}
}

}else{
echo "<script> alert('������ȷ��¼!'); window.location.href='index.php?online=�û���¼';</script>";
}
?>