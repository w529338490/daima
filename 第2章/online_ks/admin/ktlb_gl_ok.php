<?php session_start();
if($_SESSION[admin_user]==true){
include("../conn/conn.php");
if($Submit==true){
if($_POST[online_ktlb]==""){
	echo "<script>alert('�����뿼�����'); window.location.href='index.php?htgl=����������';</script>";
}else{
	$querys=mssql_query("insert into tb_ktlb (online_ktlb)values('".$_POST[online_ktlb]."')");
	if($querys){
		echo "<script>alert('���������ӳɹ���'); window.location.href='index.php?htgl=����������';</script>";
	}
}}


if($delete_ktlb==true){
$query=mssql_query("delete from tb_ktlb where ktlb_id='$delete_ktlb'");
if($query){

echo "<script>alert('�������ɾ���ɹ���'); window.location.href='index.php?htgl=����������';</script>";

}
}
?>
<?php 
}else{
echo "<script>alert('������ȷ��¼��'); window.location.href='checkadmin.php';</script>";
}

?>