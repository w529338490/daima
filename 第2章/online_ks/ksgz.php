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
body,td,th {
	font-size: 12px;
	color: #999999;
}
-->
</style></head>
<body>
<p>&nbsp;</p>
<table width="592" height="203" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#676767">

 <tr>
    <td align="right" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="col">&nbsp;&nbsp;&nbsp;<span  >�������߿���ϵͳ���������ҳ����ˢ�¡����˵Ȳ������������Ը�������ڹ涨�Ŀ���</span></p>
      <p  >ʱ����û�н���ϵͳ���Զ��ύ�Ծ�ÿλ����ͬһ���γ�ֻ�ܿ�һ�Σ�ϵͳ�ἰʱ֪ͨ��</p>
      <p  >�Եľ���ʱ�䣻�뿼����ע���Կγ��Լ�����ʱ�䣡</p>
      <p  ><br>
&nbsp;&nbsp;&nbsp;&nbsp;ֻ��ͬ�����Ϲ���ſ��Խ��п��ԡ���������������δ�ҵ���صĿ��Կγ̣��������</p>
    <p  >Ա��ϵ��</td>
      </tr>
    </table></td>
  </tr>
</table>
<p align="center">
   <input type="submit" name="Submit" onClick="window.location.href='index.php?online=ѡ����'" value="��ͬ��">
  &nbsp;&nbsp;
  <input type="submit" name="Submit2" onClick="window.location.href='index.php?online=�û���¼'"value="��ͬ��">
</p>
</body>
</html>
<?php
}else{
echo "<script> alert('������ȷ��¼!'); window.location.href='index.php?online=�û���¼';</script>";
}
?>