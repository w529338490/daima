<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<script language='JavaScript'> 
<?php
if($this->ftpl_var['action']=='useradd'){
?>
function getuser(username){	
   var tbl = window.opener.document.form1;
   var t_value=tbl.teacherlist.value;
       if (t_value.length<1) {    
       tbl.teacherlist.value=username;   
       } else if (t_value.indexOf(username)<0)
          {
          	tbl.teacherlist.value=t_value+','+username;
          }
  }
<?php
}
elseif($this->ftpl_var['action']=='useradd_1'){
?>
function getuser(username){	
   var tbl = window.opener.document.form1;
   var t_value=tbl.username.value;
       if (t_value.length<1) {    
       tbl.username.value=username;   
       } else if (t_value.indexOf(username)<0)
          {
          	tbl.username.value=t_value+','+username;
          }
  } 
 <?php
}
elseif($this->ftpl_var['action']=='useradd_2'){
?>
function getuser(username){	
   var tbl = window.opener.document.form1;   
       tbl.leaver.value=username;   
  }   
 <?php
}
elseif($this->ftpl_var['action']=='useradd_3'){
?>
function getuser(username){	
   var tbl = window.opener.document.form2; 
       tbl.teacher.value=username;   
  }     
<?php
}
elseif($this->ftpl_var['action']=='userdel'){
?>
function getuser(username){	
   var tbl = window.opener.document.form1;
   var d_value=tbl.delteacherlist.value;
   var t_value=tbl.teacherlist.value;
   var w=t_value.indexOf(username);
   var w_d=t_value.indexOf(",");
      if (w==0){
      	if (w_d>0)
      	    t_value=t_value.replace(username+",","");
      	    else t_value=t_value.replace(username,"");
        }else{
      	   t_value=t_value.replace(","+username,"");
        }
        tbl.delteacherlist.value+=username+",";
        tbl.teacherlist.value=t_value;  
  }
<?php
}
?>
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">	
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
          	onclick="javascript:location.href='index.php?filename=userlist&action=<?php echo $this->ftpl_var['action'];?>&manageid='+this.options[this.selectedIndex].value;">
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
</TABLE>
</body>
</html>