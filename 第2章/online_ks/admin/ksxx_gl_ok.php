<?php session_start();
if($_SESSION[admin_user]==true){
include("../conn/conn.php");
if($delete_ksxx==true){
$query=mssql_query("delete from tb_user where online_id='$delete_ksxx'");
if($query){
echo "<script>alert('������Ϣɾ���ɹ���'); window.location.href='index.php?htgl=������Ϣ����';</script>";

}
}
?>

<?php 
}else{
echo "<script>alert('������ȷ��¼��'); window.location.href='checkadmin.php';</script>";
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
