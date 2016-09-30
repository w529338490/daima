<?php
/*
凤鸣山中小学校网络办公室
*/
if ($group_id!=1){
$referer="?filename=index";
showmessage("对不起，你没有权利",$referer);}
/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //获取登入人员信息
	        $query="select userid,username,realname,groupid from members where userid=$user_id";
          $r=$db->query_first($query);
          $username=$r[username];
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$adminrepair=1;}
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：[$real_name]  <a href=\"?filename=index\" >首 页</a> | <a href=\"#\" onclick=popUp('repair','0')>申请报修</a>  | <a href=\"?filename=list\" >我的报修</a> | <a href=\"?filename=admin\">管 理</a> 
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"100%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" /><a href=\"?filename=index\" >首 页</a> | 
                                    帐号：<input type=\"text\" name=\"username\" size=\"10\"/>
                                    密码：<input type=\"password\" name=\"password\" size=\"10\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"点击登入\" /> 
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };       
 //添加管理人员
if ($do==1){
	$sqlt="select userid from members where `realname` like '$teacher';";
	$s=$db->query_first($sqlt);
	$sql="INSERT INTO $table_manage (`admin` ) VALUES ( '".$s[userid]."');";
	$db->query($sql);
}                  
if ($do=="del"){
	$query="delete from $table_manage where id='$id'";
	$db->query($query);
}
//管理人员名单   
$sql="SELECT $table_manage.*,members.realname FROM $table_manage 
            LEFT JOIN members ON $table_manage.admin=members.userid ";
$result=$db->query($sql);
$i=1;
while($r=$db->fetch_array($result)){
	$manageshow.="<tr><td height=24>$i:</td><td>$r[realname]</td><td><a href=?filename=admin&do=del&id=$r[id]>删除</a></td></tr>";
	$i++;
}                   
?>
<SCRIPT LANGUAGE="JavaScript">
function check(theform)
{
   if(theform.teacher.value == 0)
   {
   		alert("请选择教师");
		theform.teacher.focus();
		return false ;
   }
return true;
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
<!--DWLayoutTable-->
 <tr>
  <td  valign="top">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>
<?=$login;?>
<?=$logout;?>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <!--DWLayoutTable-->
  <tr>
    <td width="25%" height="254" valign="top">
    	<table width="98%" border="0" cellpadding="0" cellspacing="0" class=tableborder_2 align=left>
      <!--DWLayoutTable-->
     <tr>
        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align=left>
          <!--DWLayoutTable-->
          <tr>
            <td width="100%" height="28" valign="middle"  class=bg_2 align=center>
            管理设置	
            </td>
            </tr>
        </table>	
        </td>
        </tr>      
      <tr>
        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align=left>
          <!--DWLayoutTable-->
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell-->&nbsp;</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell-->&nbsp;</td>
            </tr>
        </table>	
        </td>
        </tr>
       </table>
      </td>
      <td valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder_2 valign=top>
      <!--DWLayoutTable-->
        <tr>
          <td  height="28">管理人员设置：</td>
        </tr>
                <tr>
          <td  height="2" bgcolor="#f2df24"></td>
        </tr>
         <form id=form2 name="form2" method="post" action="" OnSubmit="return check(this)" onReset="return ResetForm();">
         <tr>
          <td  height="28">请选择：<input type=text name=teacher value="" size="10">[<A  href="#" 
          onclick="window.open('../../index.php?filename=userlist&action=useradd_3','new','height=200, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><FONT 
          color=green>教职工名单</FONT></A>] </FONT>
          <input type="hidden" name=do value=1>
          <input type=submit name=up value=添加></td>
        </tr>
        </form>
        <tr>
          <td  height="254" valign=top>
           <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center valign=top>
          <?=$manageshow?>
          </table>
          </td>
        </tr>
      </table>
     </td>
    </tr>
  </table>
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center class=foottable>
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=10></td>
     </tr>
  </table> 
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24></td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>开发笔记 技术支持</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table>   
    </td>
  </tr>
</table>    
</body>

