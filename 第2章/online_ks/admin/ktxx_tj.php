<?php session_start();
if($_SESSION[admin_user]==true){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
.style2 {color: #CC0066}
.STYLE1 {font-size: 12px}
-->
</style>
</head>
<body>
<form name="form2" method="post" action="ktxx_tj_ok.php">
<table width="744" height="41" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">
  <tr>
    <td align="center" bgcolor="#EEEEEE"><span class="STYLE1">�������</span></td>
    <td width="68" bgcolor="#FFFFFF"><span class="STYLE1">
      <select name="kt_lb" id="kt_lb">
        <?php  $query=mssql_query("select * from tb_ktlb");
	while($myrow=mssql_fetch_array($query)){
	?>
        <option value="<?php echo $myrow[online_ktlb];?>"><?php echo $myrow[online_ktlb];?></option>
        <?php }?>
      </select>
    </span> </td>
    <td width="166" bgcolor="#FFFFFF"><span class="STYLE1">��������
        <select name="kt_small_lb" id="kt_small_lb">
          <option value="��һ����">��һ����</option>
          <option value="�ڶ�����">�ڶ�����</option>
          <option value="��������">��������</option>
          <option value="��������">��������</option>
          </select>
      </span></td>
    <td width="151" bgcolor="#FFFFFF"><span class="STYLE1">��������      
        <select name="kt_lx" id="kt_lx">
          <option value="��">���</option>
          <option value="��">����</option>
          <option value="��">��ѡ</option>
          <option value="��">��ѡ</option>
        </select>
    </span></td>
    <td width="211" bgcolor="#FFFFFF"><span class="STYLE1">����
        <input name="kt_fs" type="text" id="kt_fs" size="10">
    </span></td>
  </tr>
  <tr>
    <td width="114" align="center" bgcolor="#EEEEEE"><span class="STYLE1">��ӿ�������</span></td>
    <td colspan="4" bgcolor="#FFFFFF"><span class="STYLE1">
      <textarea name="kt_nr" cols="60" rows="5" id="kt_nr"></textarea>
    </span> </td>
  </tr>
  <tr>
    <td align="center" bgcolor="#EEEEEE"><span class="STYLE1">�����</span></td>
    <td colspan="4" bgcolor="#FFFFFF"><span class="STYLE1">
      <textarea name="kt_daan" cols="60" rows="5" id="kt_daan"></textarea>
      <span class="style2">ѡ������ʹ��*      �ָ���</span></span></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#EEEEEE"><span class="STYLE1">������ȷ��</span></td>
    <td colspan="4" bgcolor="#FFFFFF"><span class="STYLE1">
      <textarea name="kt_zqdaan" cols="60" rows="5" id="kt_zqdaan"></textarea>
      <span class="style2">ѡ������ʹ��* �ָ���</span></span></td>
    </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td colspan="5"><input name="Submit2" type="submit" value="�ύ����" /></td>
    </tr>
</table>
</form>
</body>
</html>

<?php 
}else{
echo "<script>alert('������ȷ��¼��'); window.location.href='checkadmin.php';</script>";
}

?>