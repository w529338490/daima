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
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=fileg&action=list">�ļ��б�</A> | <A 
      href="?filename=fileg&action=add">����ļ�</A></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �ļ���� </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 

    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addfile" OnSubmit="return check(this)"  enctype="multipart/form-data">
        <TBODY>
          <TR> 
            <TH colSpan=2>����ļ����ļ���</TH>
          </TR>   
          <TR> 
            <TD class=tablerow>�� ��</TD>
            <TD class=tablerow>
            	 <input type=text name="title" size=40> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>                
            <TR> 
              <TD class=tablerow>�� ��</TD>
              <TD class=tablerow>
              
              <input type="file" name="userfile" id=userfile>
              <input type="hidden" name=MAX_FILE_SIZE value=30000000></TD>
            </TR>                         
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
              	<input type="hidden" name=do value=1>
                <input type="submit" name="Submit" value=" �� �� " > 
                &nbsp; <input type="reset" name="Submit1" value=" �� �� "> </TD>
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
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=fileg&action=list">�ļ��б�</A> | <A 
      href="?filename=fileg&action=add">����ļ�</A></td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �ļ��б� </strong> </td>
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
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>����</td>
        <td width="40%"  valign="middle" align=left class=tr_head>�ļ�����</td>
        <td width="10%"  valign="middle" align=center class=tr_head>ת����</td>
        <td width="12%"  valign="middle" align=center class=tr_head>�������</td>
        <td width="30%"  valign="middle" align=center class=tr_head>����</td>
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
   <td  align=center valign=middle class=td1> <a href='?filename=softdown&fileid=<?php echo $this->ftpl_var['cont']['id'];?>&hash=<?php echo $this->ftpl_var['cont']['hash'];?>' target=_blank>����</a> | 
                                              ת�� | 
                                              <a href=# onclick="openurl('<?php echo $this->ftpl_var['cont']['id'];?>');">ת��</a> | 
                                              <a href='?filename=fileg&action=filedel&fileid=<?php echo $this->ftpl_var['cont']['id'];?>&hash=<?php echo $this->ftpl_var['cont']['hash'];?>'>ɾ��</a> </td>
   </tr>
    <?php
    }
}
else{
 unset($_form);?>
    û���ļ�
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
            <TD  align=middle class=tr_head>�����б�</td>
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
            <TD  align=middle  class=tr_head>������Ա</TD>
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
           <input type=submit name=ss value="��ʼ����">  
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