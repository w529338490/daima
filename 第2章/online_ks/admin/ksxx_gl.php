<?php session_start();
if($_SESSION[admin_user]==true){
include("../conn/conn.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="index.php?htgl=������Ϣ����" >
<table width="608" height="35" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">
  <tr align="center" bgcolor="#EEEEEE">
    <td width="104" height="35"><span class="STYLE1">׼��֤�ţ�</span></td>
    <td width="157" height="35"><input name="online_numbers" type="text" id="online_numbers" size="20" /></td>
    <td width="120" height="35"><input name="Submit" type="submit" value="���ҿ���" /></td>
  </tr>
</table>
</form>
<table width="608" height="47" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">
  <tr bgcolor="#EEEEEE">
    <td width="82" align="center" class="STYLE1">׼��֤��</td>
    <td width="83" align="center" class="STYLE1">��������</td>
    <td width="204" align="center" class="STYLE1">�����绰</td>
    <td width="43" align="center" class="STYLE1">����</td>
    <td width="96" align="center" class="STYLE1">�������</td>
    <td width="60" align="center" class="STYLE1">����</td>
  </tr>
 
<?php
	 if($online_numbers==true){
	$query=mssql_query("select * from tb_user where online_number='$online_numbers'");
	while($myrow=mssql_fetch_array($query)){  
  ?>
  <tr bgcolor="#FFFFFF">
    <td align="center" class="STYLE1"><?php echo $myrow[online_number]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_user]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_tel]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_grade];?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_subject];?></td>
    <td align="center" class="STYLE1"><a href="ksxx_gl_ok.php?delete_ksxx=<?php echo $myrow[online_id]?>">ɾ��</a></td>
  </tr>
  <?php }
}else{
$query=mssql_query("select * from tb_user");
	while($myrow=mssql_fetch_array($query)){ 
?>
<tr bgcolor="#FFFFFF">
    <td align="center" class="STYLE1"><?php echo $myrow[online_number]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_user]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_tel]?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_grade];?></td>
    <td align="center" class="STYLE1"><?php echo $myrow[online_subject];?></td>
    <td align="center" class="STYLE1"><a href="ksxx_gl_ok.php?delete_ksxx=<?php echo $myrow[online_id]?>">ɾ��</a></td>
  </tr>
<?php }}?>
</table>
</body>
</html>

<?php 
}else{
echo "<script>alert('������ȷ��¼��'); window.location.href='checkadmin.php';</script>";
}

?>