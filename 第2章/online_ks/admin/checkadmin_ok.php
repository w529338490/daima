<?php	session_start();
$username=$_POST[username];
$userpwd=$_POST[userpwd];
include_once("../conn/conn.php");
$sql=mssql_query("select * from tb_admin where name='".$username."' and pwd='".$userpwd."'",$conn);
$info=mssql_fetch_array($sql);
if($info==false){
  echo "<script>alert('�Բ���,�û����������������!');history.back();</script>";
  exit;
}else{
  session_register("admin_user");
  $_SESSION["admin_user"]=$username; 
  echo "<script>window.location.href='index.php';</script>";
}
?>
