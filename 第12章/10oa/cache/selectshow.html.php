<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin:0px;background:#F8F8F0;overflow:auto;">
  <!--DWLayoutTable-->
<?php
if($this->ftpl_var['action']=="selectshow"){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=tr_head>
        <?php echo $this->ftpl_var['selectyear'];?>学年<?php echo $this->ftpl_var['classname'];?><?php echo $this->ftpl_var['teachername'];?><?php echo $this->ftpl_var['showtablename'];?>课程表
        	  <font color=red>
        	  <a href=?filename=classtable&action=printtable&selectyear=<?php echo $this->ftpl_var['selectyear'];?>&selectclass=<?php echo $this->ftpl_var['selectclass'];?>>(打印课表)</a></font>
        	  <font color=red>
        	  	<?php
if($this->ftpl_var['usertype']=="c"){
?> 
        	  <a href=?filename=classtable&action=toword&usertype=c&do=1&selectyear=<?php echo $this->ftpl_var['selectyear'];?>&selectclass=<?php echo $this->ftpl_var['selectclass'];?>>(保存至word)</a></font></td>
               <?php
}
else
{
?>
                <a href=?filename=classtable&action=toword&usertype=t&do=1&selectyear=<?php echo $this->ftpl_var['selectyear'];?>&selectclass=<?php echo $this->ftpl_var['teachername'];?>>(保存至word)</a></font></td> 
               <?php
}
?> 
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" > 

            <tr>
              <td width="100%"  valign="middle" align=center colspan=2>
        	          	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
                        
                           <TBODY>
                         	
  <tr>
    <td width="10%" height="32" align="center" valign="middle" class=tr_head>星期</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期一</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期二</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期三</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期四</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期五</td>
  </tr>
  <?php
if($this->ftpl_var['usertype']=="t"){
?> 
    <tr>
      <td height="28" align="center" valign="middle" class=tr_head2>节次</td>
      <td  align="center" valign="middle" class=tr_head2>课名/班级</td>    
    <td align="center" valign="middle" class=tr_head2>课名/班级</td>
    <td  align="center" valign="middle" class=tr_head2>课名/班级</td>    
    <td align="center" valign="middle" class=tr_head2>课名/班级</td>
    <td  align="center" valign="middle" class=tr_head2>课名/班级</td>
    </tr> 
  <?php
}
else
{
?>
      <tr>
      <td height="28" align="center" valign="middle" class=tr_head2>节次</td>
      <td  align="center" valign="middle" class=tr_head2>课名/教师</td>    
    <td align="center" valign="middle" class=tr_head2>课名/教师</td>
    <td  align="center" valign="middle" class=tr_head2>课名/教师</td>    
    <td align="center" valign="middle" class=tr_head2>课名/教师</td>
    <td  align="center" valign="middle" class=tr_head2>课名/教师</td>
  </tr> 
  <?php
}
?>
  <?php 
$_from = $this->ftpl_var['classnum_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
  <tr>
    <td height="24" align="center" valign="middle" class=td2><?php echo $this->ftpl_var['cont'];?></td>
    <?php 
$_from = $this->ftpl_var['week_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid2'] => $this->ftpl_var['c']){
?>
    <td align="center" valign="middle" class=td2><?php echo $this->ftpl_var['name'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?>/<?php echo $this->ftpl_var['classnum'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?></td>
    <?php
}
		unset($_form);
		
} ?>
  </tr>
 <?php
}
		unset($_form);
		
} ?> 
   </TBODY>

                       </TABLE>
              </td>
             </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
    </TABLE>
    </td>
  </tr>
</table>
  <?php
}
?>
</body>
</html>