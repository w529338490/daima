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
   		alert("请输入标题!");
		theform.title.focus();
		return false ;
   }
   return true ;
  }
function openurl(id){
	window.open("index.php?filename=fileg&action=userdo&fileid="+id,"newu","height=200, width=200, top=200, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}  
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> 
      	<A href="?filename=message&action=receive&typeid=<?php echo $this->ftpl_var['typeid'];?>">收件箱</A> |  
      	<A href="?filename=message&action=send&typeid=<?php echo $this->ftpl_var['typeid'];?>">发件箱</A> | 
      	<A href="?filename=message&action=new&typeid=<?php echo $this->ftpl_var['typeid'];?>">新建短信</A></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置 >>  短信箱  </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<?php
if($this->ftpl_var['action']=="new"){
?>
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addmessage" OnSubmit="return check(this)">
        <TBODY>
          <TR> 
            <Td colSpan=2 class=tr_head height=28 align=center>新建短信</Td>
          </TR>   
          <TR> 
            <TD class=tablerow>标 题</TD>
            <TD class=tablerow>
            	 <input type=text name="title" size=40> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>    
                    <TR> 
            <TD class=tablerow>内 容</TD>
            <TD class=tablerow>
            	 <textarea name=content cols=60 rows=4></textarea> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>              
            <TR> 
              <TD class=tablerow>收信人</TD>
              <TD class=tablerow>
              	<input type=text name="username" size=10>[<A 
      href="#dd" 
      onclick="window.open('index.php?filename=userlist&action=useradd_1','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><FONT 
      color=green>教职工名单</FONT></A>] </FONT> <FONT color=#ff0000>*</FONT></td>
            </TR>                         
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
                <input type="submit" name="Submit" value=" 发 送 " > 
                &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE>
      <?php
}
elseif($this->ftpl_var['action']=="receive"){
?>
      <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>序列</td>
        <td width="40%"  valign="middle" align=left class=tr_head>短信标题</td>
        <td width="10%"  valign="middle" align=center class=tr_head>发信者</td>
        <td width="12%"  valign="middle" align=center class=tr_head>发送日期</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
         <tr id=list<?php echo $this->ftpl_var['cont']['id'];?> valign=middle>
			              <td align=center height=24 class=td2><?php echo $this->ftpl_var['cont']['id'];?></td>
			              <td align=center class=td2 title="<?php echo $this->ftpl_var['cont']['content'];?>"
			              ><?php echo $this->ftpl_var['cont']['title'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['realname'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['sendtime'];?></td>				
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
      <?php
}
elseif($this->ftpl_var['action']=="send"){
?>
      <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>序列</td>
        <td width="40%"  valign="middle" align=left class=tr_head>短信标题</td>
        <td width="10%"  valign="middle" align=center class=tr_head>发信者</td>
        <td width="12%"  valign="middle" align=center class=tr_head>发送日期</td>
      </tr>
            <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
         <tr id=list<?php echo $this->ftpl_var['cont']['id'];?> valign=middle>
			              <td align=center height=24 class=td2><?php echo $this->ftpl_var['cont']['id'];?></td>
			              <td align=center class=td2 title="<?php echo $this->ftpl_var['cont']['content'];?>"><?php echo $this->ftpl_var['cont']['title'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['realname'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['sendtime'];?></td>				
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
      <?php
}
?>
      </td>
  </tr>
</table>
</body>
</html>