<?php session_start();
if($_SESSION[admin_user]==true){
include("../conn/conn.php");
if($Submit2=="�ύ����"){
	$queryes=mssql_query("insert into tb_kt (kt_lb,kt_lx,kt_fs,kt_nr,kt_daan,kt_zqdaan,kt_small_lb)values('$kt_lb','$kt_lx','$kt_fs','$kt_nr','$kt_daan','$kt_zqdaan','$kt_small_lb')");
	if($queryes){
			echo "<script>alert('������ӳɹ���'); window.location.href='index.php?htgl=������Ϣ���';</script>";
		}
}
?>

<?php 
}else{
echo "<script>alert('������ȷ��¼��'); window.location.href='checkadmin.php';</script>";
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">