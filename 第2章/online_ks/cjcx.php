<?php session_start();

include("conn/conn.php");
if($_SESSION[online_number]!=""){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
.STYLE1 {font-size: 12}
-->
</style>
</head>
<body>
<table width="592" height="103" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">
 <form name="form1" method="post" action="index.php?online=�ɼ���ѯ" >
 <tr>
    <td width="165" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="2" align="center" bgcolor="#FFFFFF"><span class="STYLE1">���Կ�Ŀ��
        <select name="select">
          <?php $querys=mssql_query("select * from tb_ktlb");
	  while($myrows=mssql_fetch_array($querys)){
	  ?>
          <option value="<?php echo $myrows[online_ktlb];?>"><?php echo $myrows[online_ktlb];?></option>
          <?php  } ?>
          </select>
    </span></td>
    <td width="203" bgcolor="#FFFFFF"><input name="Submit" type="submit" value="�ύ" /></td>
  </tr>
  </form>
  <tr>
    <td align="center" bgcolor="#EEEEEE"><span class="STYLE1">׼��֤��</span></td>
    <td width="76" align="center" bgcolor="#EEEEEE"><span class="STYLE1">���Կ�Ŀ</span></td>
    <td width="120" align="center" bgcolor="#EEEEEE"><span class="STYLE1">����ʱ��</span></td>
    <td align="center" bgcolor="#EEEEEE"><span class="STYLE1">���Է���</span></td>
  </tr>
 <?php $query=mssql_query("select * from tb_user where online_number='".$_SESSION[online_number]."' and online_subject='$select'");
 if(mssql_num_rows($query)<1){
 echo "<span class='STYLE1'>��û�иÿ�Ŀ�ĳɼ���</span>";
 }else{
 while($myrow=mssql_fetch_array($query)){
 ?>
  <tr>
    <td bgcolor="#FFFFFF"><span class="STYLE1"><?php echo $myrow[online_number];?></span></td>
    <td bgcolor="#FFFFFF"><span class="STYLE1"><?php echo $myrow[online_subject];?></span></td>
    <td bgcolor="#FFFFFF"><span class="STYLE1"><?php echo $myrow[online_date];?></span></td>
    <td bgcolor="#FFFFFF"><span class="STYLE1"><?php echo $myrow[online_grade];?></span></td>
  </tr>
<?php }}?>
</table>
</body>
</html>
<?php
}else{
echo "<script> alert('������ȷ��¼!'); window.location.href='index.php?online=�û���¼';</script>";
}
?>