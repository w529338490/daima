<?php include("conn/conn.php");
if($_SESSION[online_number]!=""){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>���߿���ϵͳ</title>
<style type="text/css">
<!--
.STYLE2 {font-size: 12px}
-->
</style>
</head>
<body>
<form name="form2" method="post" action="index.php?online=��ʼ����">
<table width="592" height="30" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#666666">
  
  <tr>
    <td width="592" align="right" bgcolor="#FFFFFF"><span class="STYLE2">�������
        <select name="kt_lbes" id="kt_lbes">
          <option selected="selected">ѡ�������</option>
          <?php  $query=mssql_query("select * from tb_ktlb");
	while($myrow=mssql_fetch_array($query)){
	?>
          <option value="<?php echo $myrow[online_ktlb];?>"><?php echo $myrow[online_ktlb];?></option>
          <?php }?>
          </select>
    </span></td>
    <td width="592" align="center" bgcolor="#FFFFFF"><span class="STYLE2">ѡ������
        <select name="kt_small_lb" id="kt_small_lb">
          <option selected="selected">��ѡ������</option>
          <option value="��һ����">��һ����</option>
          <option value="�ڶ�����">�ڶ�����</option>
          <option value="��������">��������</option>
          <option value="��������">��������</option>
          </select>
      </span></td>
    <td width="592" bgcolor="#FFFFFF"><span class="STYLE2">
      <input type="submit" name="Submit" value="��ʼ����" />

      <?php 
$dates=mktime();
session_register("dates")==$dates;
?>
    </span></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}else{
echo "<script> alert('������ȷ��¼!'); window.location.href='index.php?online=�û���¼';</script>";
}
?>