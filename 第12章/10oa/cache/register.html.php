<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $this->ftpl_var['sitetitle'];?>--注册程式</title>
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
    <TD width="100%" height="25" valign="top" bgcolor="#deebff" align=center valign=middle style="color:red" ><?php echo $this->ftpl_var['sitetitle'];?>注册程式</TD>
    </TR>
  <TR>
    <TD height="285" valign="top" width="100%">
    	<INPUT type=hidden value=2 name=step> <BR>
      当您申请用户时，表示您已经同意遵守本规章，请您自觉遵守以下条款： <BR>
      <BR>
      一、不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本站制作、复制和传播下列信息：<BR>　
      （一）煽动抗拒、破坏宪法和法律、行政法规实施的；<BR>　
      （二）煽动颠覆国家政权，推翻社会主义制度的；<BR>　
      （三）煽动分裂国家、破坏国家统一的；<BR>　
      （四）煽动民族仇恨、民族歧视，破坏民族团结的；<BR>　
      （五）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；<BR>　
      （六）宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；<BR>　
      （七）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；<BR>　
      （八）损害国家机关信誉的；<BR>　
      （九）其他违反宪法和法律行政法规的；<BR>　
      （十）进行商业广告行为的。<BR>
      <BR>
      二、互相尊重，对自己的言论和行为负责。<BR>
      三、禁止在申请用户时使用相关本站的词汇，或是带有侮辱、毁谤、造谣类的或是有其含义的各种语言进行注册用户，否则我们会将其删除。<BR>
      四、禁止以任何方式对本站进行各种破坏行为。<BR></TD>
    </TR></TBODY></TABLE>
		</td>
      </tr>
	  <tr>
        <td  height="40" align="center" valign="middle"><INPUT type=submit value="同 意"> <INPUT onclick=javascript:history.go(-1); type=button value=取消></td>
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
		alert('会员名或密码为空,请填写');
		formct.username.focus();
		return false; 
	}
	if (formct.password.value!=formct.passwordrepeat.value)
	{
		alert('两次输入的密码不一致，请检查后重试。');
		formct.password.focus();
		return false; 
	}
		if (formct.realname.value=='')
	{
		alert('真实姓名为空,请输入');
		formct.realname.focus();
		return false; 
	}
		if (formct.subjectid.value==0)
	{
		alert('请选择学科');
		formct.subjectid.focus();
		return false; 
	}
		if (formct.manageid.value==0)
	{
		alert('请选择部门');
		formct.manageid.focus();
		return false; 
	}
	if (formct.reg_key.value=="")
	{
		alert('请输入邀请码');
		formct.reg_key.focus();
		return false; 
	}
	if (formct.password.value.length<6)
	{
		alert('密码太少，请用6位以上');
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
                  <td height=25 colspan=2 bgcolor="Deebff" class=right_head>必填内容（<span class="STYLE1">*</span>）</td>
    </tr>
                <tr>
                  <td width=15% valign=middle class='f_one' height="28"> 帐 号<font color=red>*</font></td>
      <td width=85%  class='f_one'><input type=text size=20 maxlength=14 name='username' value=''>
        <font color=blue><b></b></font>,不能有空格,只能是英文
        &nbsp;<div id="check_info"></div height="28"></td></tr>
                <tr>
                  <td valign=middle class='f_one' height="28"> 真实姓名<font color=red>*</font></td>
      <td  class='f_one'><input type=text size=20 maxlength=14 name='realname' value=''>
        必须为中文 &nbsp;<div id="check_info" height="28"></div></td></tr>
                <tr>
                  <td valign=middle  class='f_one' height="28"> 密 码<font color=red>*</font></td>
      <td  class='f_one'>
        <input type=password size=20 maxlength=75 name=password>英文字母或数字等不少于6位</td></tr>
                <tr> <td valign=middle  class='f_one'> 确认密码<font color=red>*</font></td>
    <td class='f_one'>
      <input type=password size=20 maxlength=75 name='passwordrepeat'></td></tr>
                  <td class='f_one'>所任学科<font color="red">*</font></td>
	    <td class='f_one'>
	      <select name="subjectid"><option value=0>请选择学科</option>
	      <?php echo $this->ftpl_var['subject_data'];?>
	        </select></td>
    </tr>
            <tr>
                  <td class='f_one'>所任学科<font color="red">*</font></td>
	    <td class='f_one'>
	      <select name=manageid><option value=0>请选择部门</option>
	      <?php echo $this->ftpl_var['manage_data'];?>
	      	 </select>
                </td>
    </tr>      
       <tr>
          <td class='f_one'>邀请码<font color="red">*</font></td>
	    <td class='f_one'>
	      <input type=text name=reg_key value=""><font color=red><b>向网络管理员索取</font>
                </td>
    </tr>    
                <tr><td height=25 colspan=2 bgcolor="Deebff" class=right_head>注意事项：</td>
    </tr>
                <tr>
                <td height="93"  colspan=2>&nbsp;&nbsp;
                  <p> <div align="center"><font color=red ><b>注册好以后请等待，需等管理员审核以后才能登陆系统</font></div></td>
    </tr>
                <tr>
                  <td height="41" colspan=2 align="center" valign="middle" bgcolor="Deebff"><input type='submit' name='regsubmit' value='提 交'></td>
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