<?php session_start();
if($_SESSION[online_number]==true){
?>
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
<script language="JavaScript" type="text/javascript">
 function check_pass(){
   if(form1.online_number.value==""){
     alert("������׼��֤�ţ�");
	 form1.online_number.select();
	 return(false);
	}
	if(form1.online_pass.value==""){
     alert("���������룡");
	 form1.online_pass.select();
	 return(false);
	}
	if(form1.online_pass2.value==""){
     alert("�����������룡");
	 form1.online_pass2.select();
	 return(false);
	}
	if(form1.online_pass3.value==""){
     alert("������ȷ�����룡");
	 form1.online_pass3.select();
	 return(false);
	}
	if(form1.online_pass2.value!=form1.online_pass3.value){
     alert("��������������ȷ�����벻����");
	 form1.online_pass22.select();
	 return(false);
	}
   return(true);	 
 }
</script>
<body>
<table width="500" height="50" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="form1" method="post" action="xgmm_ok.php" onSubmit="javascript:return check_pass();" >
<table width="592" height="103" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">
  <tr>
    <td width="104" bgcolor="#EEEEEE">&nbsp;</td>
    <td width="157" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="95" bgcolor="#EEEEEE">&nbsp;</td>
    <td width="208" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#EEEEEE"><span class="STYLE1">׼��֤���룺</span></td>
    <td bgcolor="#FFFFFF"><input name="online_number" type="text" id="online_number" size="20" /></td>
    <td bgcolor="#EEEEEE"><span class="STYLE1">&nbsp;</span></td>
    <td bgcolor="#FFFFFF"><span class="STYLE1">&nbsp;</span></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#EEEEEE"><span class="STYLE1">��&nbsp; �룺</span></td>
    <td bgcolor="#FFFFFF"><input name="online_pass" type="password" id="online_pass" size="20" /></td>
    <td bgcolor="#EEEEEE"><span class="STYLE1">&nbsp;</span></td>
    <td bgcolor="#FFFFFF"><span class="STYLE1">&nbsp;</span></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#EEEEEE"><span class="STYLE1">�����룺</span></td>
    <td bgcolor="#FFFFFF"><input name="online_pass2" type="password" id="online_pass2" size="20" /></td>
    <td align="right" bgcolor="#EEEEEE"><span class="STYLE1">������֤��</span></td>
    <td bgcolor="#FFFFFF"><input name="online_pass3" type="password" id="online_pass3" size="20" /></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#EEEEEE"><input type="submit" name="Submit" value="�ύ" /></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
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