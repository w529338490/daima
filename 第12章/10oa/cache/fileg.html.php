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
      
function getuser(username){	
   var tbl = window.document.form2;
       tbl.username.value=username;  
  }
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">    
<?php
if($this->ftpl_var['action']=="add"){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=fileg&action=list">文件列表</A> | <A 
      href="?filename=fileg&action=add">添加文件</A></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置 >> <?php echo $this->ftpl_var['now_typename'];?> >> 文件添加 </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 

    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addfile" OnSubmit="return check(this)"  enctype="multipart/form-data">
        <TBODY>
          <TR> 
            <TH colSpan=2>添加文件到文件柜</TH>
          </TR>   
          <TR> 
            <TD class=tablerow>标 题</TD>
            <TD class=tablerow>
            	 <input type=text name="title" size=40> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>                
            <TR> 
              <TD class=tablerow>文 件</TD>
              <TD class=tablerow>
              
              <input type="file" name="userfile" id=userfile>
              <input type="hidden" name=MAX_FILE_SIZE value=30000000></TD>
            </TR>                         
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
              	<input type="hidden" name=do value=1>
                <input type="submit" name="Submit" value=" 上 传 " > 
                &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE>
       </td>
  </tr>
</table>     
      <?php
}
elseif($this->ftpl_var['action']=="list"){
?>
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=fileg&action=list">文件列表</A> | <A 
      href="?filename=fileg&action=add">添加文件</A></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置 >> <?php echo $this->ftpl_var['now_typename'];?> >> 文件列表 </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top">      
       <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>序列</td>
        <td width="40%"  valign="middle" align=left class=tr_head>文件标题</td>
        <td width="10%"  valign="middle" align=center class=tr_head>转发者</td>
        <td width="12%"  valign="middle" align=center class=tr_head>添加日期</td>
        <td width="30%"  valign="middle" align=center class=tr_head>操作</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
         <tr>
   <td height=28 align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['id'];?></td>
   <td  align=left valign=middle class=td1><?php echo $this->ftpl_var['cont']['title'];?></td>
   <td  align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['realname'];?></td>
   <td  align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['intime'];?></td>
   <td  align=center valign=middle class=td1> <a href='?filename=softdown&fileid=<?php echo $this->ftpl_var['cont']['id'];?>&hash=<?php echo $this->ftpl_var['cont']['hash'];?>' target=_blank>下载</a> | 
                                              转存 | 
                                              <a href=# onclick="openurl('<?php echo $this->ftpl_var['cont']['id'];?>');">转送</a> | 
                                              <a href='?filename=fileg&action=filedel&fileid=<?php echo $this->ftpl_var['cont']['id'];?>&hash=<?php echo $this->ftpl_var['cont']['hash'];?>'>删除</a> </td>
   </tr>
    <?php
    }
}
else{
 unset($_form);?>
    没有文件
      <?php  
}
?>
      
     </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
          </td>
  </tr>
</table>
    <?php
}
elseif($this->ftpl_var['action']=="userdo"){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100"  height="42" valign="top">    
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
        	<form name=form1>
          <TR> 
            <TD  align=middle class=tr_head>部门列表</td>
          </tr>
        <tr>
        	<td>
          <select name=manageid size=9
          	onclick="javascript:location.href='index.php?filename=fileg&action=userdo&fileid=<?php echo $this->ftpl_var['fileid'];?>&manageid='+this.options[this.selectedIndex].value;">
          <?php echo $this->ftpl_var['managementlist'];?>
          </select>
          <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.manageid;
                     Obj.value=<?php echo $this->ftpl_var['manageid'];?>;
               </SCRIPT>
          </TD></TR></form>
        </TBODY>
      </TABLE>
    </td>
        <td width="100"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle  class=tr_head>部门人员</TD>
          </TR>
          <tr>
          	<td>
          <select name=username size=9
          	onclick="getuser(this.options[this.selectedIndex].text);">
          <?php echo $this->ftpl_var['userlist'];?>
        </select>
        </td>
      </tr>
        </TBODY>
      </TABLE>
    </td>
        </tr>
        <tr>
        <td width="100%"  height="42" valign="top" colspan=2>
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
        	<form id=form2 name="form2" method="post" action="?filename=deal&action=filetouser" OnSubmit="return check(this)">
          <TR> 
            <TD  align=middle class=submenu>
            <input type=text name=username size=10>
            	</TD>
            <TD  align=middle  class=submenu>
            	<input type=hidden name=fileid value="<?php echo $this->ftpl_var['fileid'];?>">
           <input type=submit name=ss value="开始发送">  
          	</TD>
          </TR>
        </form>
        </TBODY>
      </TABLE>
          </td>
  </tr>
</table>      
    <?php
}
?>
</body>
</html>