<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $this->ftpl_var['sitetitle'];?>--ע���ʽ</title>
<?php
if($this->ftpl_var['step']==1){
?>
<script language="JavaScript">
function redirect(url) {
	window.location.replace(url);
}
</script>
</head>
<body>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="760" height="52" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="760" height="52">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td height="291" valign="top">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable--> 
      <FORM action=?filename=reg method=post>
      <tr>
        <td width="760">
		<TABLE  style="TABLE-LAYOUT: fixed; WORD-BREAK: break-all" cellSpacing=0 cellPadding=6 width="90%" align=center border=1>
		  <!--DWLayoutTable-->
  <TBODY>
  <TR>
    <TD width="100%" height="25" valign="top" bgcolor="#deebff" align=center valign=middle style="color:red" ><?php echo $this->ftpl_var['sitetitle'];?>ע���ʽ</TD>
    </TR>
  <TR>
    <TD height="285" valign="top" width="100%">
    	<INPUT type=hidden value=2 name=step> <BR>
      ���������û�ʱ����ʾ���Ѿ�ͬ�����ر����£������Ծ������������ <BR>
      <BR>
      һ���������ñ�վΣ�����Ұ�ȫ��й¶�������ܣ������ַ�������Ἧ��ĺ͹���ĺϷ�Ȩ�棬�������ñ�վ���������ƺʹ���������Ϣ��<BR>��
      ��һ��ɿ�����ܡ��ƻ��ܷ��ͷ��ɡ���������ʵʩ�ģ�<BR>��
      ������ɿ���߸�������Ȩ���Ʒ���������ƶȵģ�<BR>��
      ������ɿ�����ѹ��ҡ��ƻ�����ͳһ�ģ�<BR>��
      ���ģ�ɿ�������ޡ��������ӣ��ƻ������Ž�ģ�<BR>��
      ���壩�������������ʵ��ɢ��ҥ�ԣ������������ģ�<BR>��
      ����������⽨���š����ࡢɫ�顢�Ĳ�����������ɱ���ֲ�����������ģ�<BR>��
      ���ߣ���Ȼ�������˻���������ʵ�̰����˵ģ����߽����������⹥���ģ�<BR>��
      ���ˣ��𺦹��һ��������ģ�<BR>��
      ���ţ�����Υ���ܷ��ͷ�����������ģ�<BR>��
      ��ʮ��������ҵ�����Ϊ�ġ�<BR>
      <BR>
      �����������أ����Լ������ۺ���Ϊ����<BR>
      ������ֹ�������û�ʱʹ����ر�վ�Ĵʻ㣬���Ǵ������衢�ٰ�����ҥ��Ļ������京��ĸ������Խ���ע���û����������ǻὫ��ɾ����<BR>
      �ġ���ֹ���κη�ʽ�Ա�վ���и����ƻ���Ϊ��<BR></TD>
    </TR></TBODY></TABLE>
		</td>
      </tr>
	  <tr>
        <td  height="40" align="center" valign="middle"><INPUT type=submit value="ͬ ��"> <INPUT onclick=javascript:history.go(-1); type=button value=ȡ��></td>
      </tr></FORM>
    </table>   
  </tr>
  <tr>
    <td height="134" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="760" height="134">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php
}
elseif($this->ftpl_var['step']==2){
?>
<script language=JavaScript1.2>
function javacheck(formct)
{
	if (formct.username.value=='' || formct.password.value=='' || formct.passwordrepeat.value=='')
	{
		alert('��Ա��������Ϊ��,����д');
		formct.username.focus();
		return false; 
	}
	if (formct.password.value!=formct.passwordrepeat.value)
	{
		alert('������������벻һ�£���������ԡ�');
		formct.password.focus();
		return false; 
	}
		if (formct.realname.value=='')
	{
		alert('��ʵ����Ϊ��,������');
		formct.realname.focus();
		return false; 
	}
		if (formct.subjectid.value==0)
	{
		alert('��ѡ��ѧ��');
		formct.subjectid.focus();
		return false; 
	}
		if (formct.manageid.value==0)
	{
		alert('��ѡ����');
		formct.manageid.focus();
		return false; 
	}
	if (formct.reg_key.value=="")
	{
		alert('������������');
		formct.reg_key.focus();
		return false; 
	}
	if (formct.password.value.length<6)
	{
		alert('����̫�٣�����6λ����');
		formct.password.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body>
<table width="760"  align="center" cellpadding="0" cellspacing="0" border=1>
  <!--DWLayoutTable-->
  <tr>
    <td width="760" height="40" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="760" height="40" style="color:red"  align=center valign=middle><b><?php echo $this->ftpl_var['sitetitle'];?></td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td height="394" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <form action='?filename=reg&action=reg' method=post name='creator' onSubmit='return javacheck(this)'>
        <input type=hidden name='step' value='3'>
        <!--DWLayoutTable-->
        <tr>
          <td width="100%" valign="top">
              <table width="100%" cellspacing=0 cellpadding=6 align=center class=i_table>
                <!--DWLayoutTable-->
                <tr>
                  <td height=25 colspan=2 bgcolor="Deebff" class=right_head>�������ݣ�<span class="STYLE1">*</span>��</td>
    </tr>
                <tr>
                  <td width=15% valign=middle class='f_one' height="28"> �� ��<font color=red>*</font></td>
      <td width=85%  class='f_one'><input type=text size=20 maxlength=14 name='username' value=''>
        <font color=blue><b></b></font>,�����пո�,ֻ����Ӣ��
        &nbsp;<div id="check_info"></div height="28"></td></tr>
                <tr>
                  <td valign=middle class='f_one' height="28"> ��ʵ����<font color=red>*</font></td>
      <td  class='f_one'><input type=text size=20 maxlength=14 name='realname' value=''>
        ����Ϊ���� &nbsp;<div id="check_info" height="28"></div></td></tr>
                <tr>
                  <td valign=middle  class='f_one' height="28"> �� ��<font color=red>*</font></td>
      <td  class='f_one'>
        <input type=password size=20 maxlength=75 name=password>Ӣ����ĸ�����ֵȲ�����6λ</td></tr>
                <tr> <td valign=middle  class='f_one'> ȷ������<font color=red>*</font></td>
    <td class='f_one'>
      <input type=password size=20 maxlength=75 name='passwordrepeat'></td></tr>
                  <td class='f_one'>����ѧ��<font color="red">*</font></td>
	    <td class='f_one'>
	      <select name="subjectid"><option value=0>��ѡ��ѧ��</option>
	      <?php echo $this->ftpl_var['subject_data'];?>
	        </select></td>
    </tr>
            <tr>
                  <td class='f_one'>����ѧ��<font color="red">*</font></td>
	    <td class='f_one'>
	      <select name=manageid><option value=0>��ѡ����</option>
	      <?php echo $this->ftpl_var['manage_data'];?>
	      	 </select>
                </td>
    </tr>      
       <tr>
          <td class='f_one'>������<font color="red">*</font></td>
	    <td class='f_one'>
	      <input type=text name=reg_key value=""><font color=red><b>���������Ա��ȡ</font>
                </td>
    </tr>    
                <tr><td height=25 colspan=2 bgcolor="Deebff" class=right_head>ע�����</td>
    </tr>
                <tr>
                <td height="93"  colspan=2>&nbsp;&nbsp;
                  <p> <div align="center"><font color=red ><b>ע����Ժ���ȴ�����ȹ���Ա����Ժ���ܵ�½ϵͳ</font></div></td>
    </tr>
                <tr>
                  <td height="41" colspan=2 align="center" valign="middle" bgcolor="Deebff"><input type='submit' name='regsubmit' value='�� ��'></td>
    </tr>
            </table></td>
        </tr>
	  </form>
    </table></td>
  </tr>
  <tr>
    <td height="128" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="760" height="128">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php
}
?>
</body>
</html>