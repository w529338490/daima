<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.title.value == "")
   {
   		alert("���������!");
		theform.title.focus();
		return false ;
   }
     if(theform.intime.value == "")
   {
   		alert("�����뿪ʼʱ��");
		theform.intime.focus();
		return false ;
   } 
   return true ;
  }
</SCRIPT>
<script language='JavaScript'>   
function get(outtime){
	window.open('index.php?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=s&selecttime='+outtime,'sch','height=400, width=600, top=50, left=50, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
}	
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> 
    	<TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=d">���չ���</A>     | <A 
      href="?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=w">���ܰ���</A>     | <A 
      href="?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=m">�ճ̰��Ų�ѯ</A> | <a 
    	href="?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=t">��������</a> | <a 
    	href="?filename=schedule&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=a">�������</a></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <?php
if($this->ftpl_var['action']=='a'){
?>
  <tr> 
    <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> ������� </strong> </td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addschedule" OnSubmit="return check(this)" onReset="return ResetForm();">
    
        <TBODY>
          <TR> 
            <TH colSpan=2 class=main_title>�������</TH>
          </TR>
               <TR> 
              <TD class=tdrow nowrap>��������</TD>
              <TD class=tdrow>
              	<select name="stypeid">
                 <option value="0">��������</option>
                 <option value="1">��������</option>                
                </select> <FONT color=#ff0000>*</FONT></TD>
            </TR>    
          <TR> 
            <TD class=tdrow>�� ��</TD>
            <TD class=tdrow>
            	 <input type=text name="title" size=40> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>                
          <TR> 
            <TD class=tdrow>����</TD>
            <TD class=tdrow>
            	 <textarea name="content" cols="60" rows="4"></textarea> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR> 
            <TR> 
              <TD class=tdrow>��ʼ����</TD>
              <TD class=tdrow>
              	<input type=text name=intime size=15 >
              	<img onclick="window.open('index.php?filename=calendar&inputname=intime','new','height=150, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')" style="cursor:hand" src="./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/calendar.gif" border=0>
              	(���ڸ�ʽΪ2007-4-23)<FONT color=#ff0000>*</FONT></TD>
            </TR>                       
            <TR> 
              <TD class=tdrow>��������</TD>
              <TD class=tdrow nowrap>
              	 <input type=text name=pretime size=15 >
              	<img onclick="window.open('index.php?filename=calendar&inputname=pretime','new','height=150, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')" style="cursor:hand" src="./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/calendar.gif" border=0>
              	(���ڸ�ʽΪ2007-4-23) *���û��������,��������Ҫ���ڿ�ʼ����*</FONT></TD>
            </TR>
  
          <TBODY>
            <TR> 
              <TD class=tdrow>&nbsp; </TD>
              <TD class=tdrow>
              	<input type="hidden" name=do value=1>
              	<input type=hidden name=typeid value=<?php echo $this->ftpl_var['typeid'];?>>
                <input type="submit" name="Submit" value=" �� �� " > 
                &nbsp; <input type="reset" name="Submit1" value=" �� �� "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='d'){
?>
    <tr> 
 <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> ���չ���</strong> </td>
  </tr>
  <tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
  <!--DWLayoutTable-->
  <tr>
    <td width="43"  valign="top" height=46>
	  <table width="100%" border="0" cellpadding="1" cellspacing="0" background="./templates/<?php echo $this->ftpl_var['style'];?>/images/date-bg.gif">
      <!--DWLayoutTable-->
      <tr>
        <td width="43" height="14" valign="top" align=center>
         <?php echo $this->ftpl_var['cont']['date_m'];?>��</td>
      </tr>
      <tr>
        <td height="32" valign="middle" align=center>
        <p style="font-size: 16px ;color=red;"><b><?php echo $this->ftpl_var['cont']['date_d'];?></b></p>
        </td>
      </tr>
    </table>
    </td>
      <td  valign="middle">
      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
           <td  width="100%" height="26" valign="middle" nowrap><font color=#249624><b>
    <b>��<?php echo $this->ftpl_var['cont']['title'];?>��</b></font></td></tr>
      <tr>
      <td height="1" valign="niddle" bgcolor="#A1C34D" >
    </td>
    </tr>
    <tr>
    <td height="19" valign="middle">
    �����ݡ�<a href="?filename=show&action=s&id=<?php echo $this->ftpl_var['cont']['id'];?>" target="=_blank"><?php echo $this->ftpl_var['cont']['content'];?></a>
    </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="10" valign="middle" align=center>
        </td>
      </tr>
    </table>
    <?php
    }
}
else{
 unset($_form);?> 
    ����û������
    <?php  
}
?>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='w'){
?>
  <tr> 
 <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> ���ܰ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
       <table width="100%" border="0" cellpadding="1" cellspacing="1" class=table1>
       <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>   
          <tr>
      <td  valign="top" class=td1 height=100% width=60>
      <table width="100%" border="0" cellpadding="1" cellspacing="0" height=100%>
      <!--DWLayoutTable-->
      <tr>
      	<td nowrap align=center valign=middle class=tr_head3 ><?php echo $this->ftpl_var['cont']['nowweek'];?></td>
      </tr>
      </table>
    </td>
    <td width="43" class=td1 valign="top" height=46 align=center>
	  <table width="100%" border="0" cellpadding="1" cellspacing="0" background="./templates/<?php echo $this->ftpl_var['style'];?>/images/date-bg.gif" align=center>
      <!--DWLayoutTable-->
      <tr>
        <td width="43" height="14" valign="top" align=center>
         <?php echo $this->ftpl_var['cont']['daten'];?>��</td>
      </tr>
      <tr>
        <td height="32" valign="middle" align=center>
        <p style="font-size: 16px;color=red;"><b><?php echo $this->ftpl_var['cont']['dated'];?></b></p>
        </td>
      </tr>
    </table>
    </td>
        <td  valign="middle" >
      <table width="100%" height=100% border="0" cellpadding="1" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
      <td class=td1 valign=top>
        <?php echo $this->ftpl_var['cont']['todayschlist'];?>
        </td>
        </tr>
      </table>
    </td>
   </tr>
   <?php
}
		unset($_form);
		
} ?>
        </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='t'){
?>
   <tr> 
 <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> ��������</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
  <!--DWLayoutTable-->
  <tr>
    <td width="43"  valign="top" height=46>
	  <table width="100%" border="0" cellpadding="1" cellspacing="0" background="./templates/<?php echo $this->ftpl_var['style'];?>/images/date-bg.gif">
      <!--DWLayoutTable-->
      <tr>
        <td width="43" height="14" valign="top" align=center>
         <?php echo $this->ftpl_var['cont']['date_m'];?>��</td>
      </tr>
      <tr>
        <td height="32" valign="middle" align=center>
        <p style="font-size: 16px ;color=red;"><b><?php echo $this->ftpl_var['cont']['date_d'];?></b></p>
        </td>
      </tr>
    </table>
    </td>
      <td  valign="middle">
      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
           <td  width="100%" height="26" valign="middle" nowrap><font color=#249624><b>
    <b>��<?php echo $this->ftpl_var['cont']['title'];?>��</b></font></td></tr>
      <tr>
      <td height="1" valign="niddle" bgcolor="#A1C34D" >
    </td>
    </tr>
    <tr>
    <td height="19" valign="middle">
    �����ݡ�<a href="?filename=show&action=s&id=<?php echo $this->ftpl_var['cont']['id'];?>" target="=_blank"><?php echo $this->ftpl_var['cont']['content'];?></a>
    </td>
      </tr>
    </table>
  
    </td>
  </tr>
</table>  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="10" valign="middle" align=center>
        </td>
      </tr>
    </table>
    <?php
}
		unset($_form);
		
} ?>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='s'){
?>
   <tr> 
 <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> ��ѯ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
          	<?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
  <!--DWLayoutTable-->
  <tr>
    <td width="43"  valign="top" height=46>
	  <table width="100%" border="0" cellpadding="1" cellspacing="0" background="./templates/<?php echo $this->ftpl_var['style'];?>/images/date-bg.gif">
      <!--DWLayoutTable-->
      <tr>
        <td width="43" height="14" valign="top" align=center>
         <?php echo $this->ftpl_var['cont']['date_m'];?>��</td>
      </tr>
      <tr>
        <td height="32" valign="middle" align=center>
        <p style="font-size: 16px ;color=red;"><b><?php echo $this->ftpl_var['cont']['date_d'];?></b></p>
        </td>
      </tr>
    </table>
    </td>
      <td  valign="middle">
      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
           <td  width="380" height="26" valign="middle" nowrap><font color=#249624><b>
    <b>��<?php echo $this->ftpl_var['cont']['title'];?>��</b></font></td></tr>
      <tr>
      <td height="1" valign="niddle" bgcolor="#A1C34D" >
    </td>
    </tr>
    <tr>
    <td height="19" valign="middle">
    �����ݡ�<a href="?filename=show&action=s&id=<?php echo $this->ftpl_var['cont']['id'];?>" target="=_blank"><?php echo $this->ftpl_var['cont']['content'];?></a>
    </td>
      </tr>
    </table>
  
    </td>
  </tr>
</table>  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="10" valign="middle" align=center>
        </td>
      </tr>
    </table>
    <?php
}
		unset($_form);
		
} ?>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='m'){
?>
   <tr> 
 <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �ճ̰��Ų�ѯ</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 	
<table width="100%" border="0" cellspacing="0" cellpadding="1" class=table1 style="font-size:18px;" align="center">
<tr align="middle">
	 <td colspan="2" height=36><?php echo $this->ftpl_var['nextyear'];?></td>
	 <td colspan="3"><?php echo $this->ftpl_var['year'];?>��<?php echo $this->ftpl_var['month'];?>��</td>
	 <td colspan="2"><?php echo $this->ftpl_var['nextm'];?></td>
</tr>
<tr>
	 <td align=center class=tr_head width=14% height=40><font color="red">��</font></td>
	 <td align=center class=tr_head width=14%>һ</td>
	 <td align=center class=tr_head width=14%>��</td>
	 <td align=center class=tr_head width=14%>��</td>
	 <td align=center class=tr_head width=14%>��</td>
	 <td align=center class=tr_head width=14%>��</td>
	 <td align=center class=tr_head width=14%>��</td>
</tr>
<tr>
<?php echo $this->ftpl_var['showday'];?>
</tr>
</table></td>
</tr>
  <?php
}
?>
</table>	
</body>
</html>