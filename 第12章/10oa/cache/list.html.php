<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="24"><strong>当前位置 >> <?php echo $this->ftpl_var['now_typename'];?></strong> </td>
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
         <?php echo $this->ftpl_var['cont']['date_m'];?>月</td>
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
           <td colspan=3 width="100%" height="26" valign="middle" nowrap class=tdrow><a href=?filename=show&id=<?php echo $this->ftpl_var['cont']['articleid'];?> target=_blank><font color=#249624><b>
    <?php echo $this->ftpl_var['cont']['includepic'];?><b><?php echo $this->ftpl_var['cont']['title'];?></b></font></a></td></tr>
      <tr><td height="1" valign="niddle" bgcolor="#A1C34D" colspan=3>
    </td>
    </tr>
    <tr>
    <td height="19" valign="bottom" width=120>
    【部 门】:<?php echo $this->ftpl_var['cont']['managename'];?> </td>
    <td height="19" valign="bottom" width=120>
    【发布者】:<?php echo $this->ftpl_var['cont']['author'];?> </td>
    <td height="19" valign="bottom" >
    【添加时间】:<?php echo $this->ftpl_var['cont']['date_t'];?></td>
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
</table>
</body>
</html>