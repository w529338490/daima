<?php
/*
����ɽ��Сѧ����칫��
*/

/*************************��������*****************************************/
//��ȡ�û���
$query="select * from usergroup order by groupid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$showgroup.="<option value='$r[groupid]'>$r[grouptitle]</option>";
}
//��ȡ������Ϣ
$query="select * from management order by manageid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$managements[$r[manageid]]=$r[managename];
	$showmanage.="<option value='$r[manageid]'>$r[managename]</option>";
}
//��ȡѧ����Ϣ
$query="select * from subject order by subjectid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$showsubject.="<option value='$r[subjectid]'>$r[subjectname]</option>";
} 
/*****************************************************************************/
//���ݲ���
switch($action){
  case 'useradd':
  if ($group_id>1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�û�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=user&action=useradd">����û�</A> | <A 
      href="?filename=user&action=useredit">�༭�û�</A> | <A 
      href="?filename=user&action=modifypassword">�޸�����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã��û����� >> ����û�</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>����û�</TH></TR>
         <form name="form1" method="post" action="?filename=deal&action=useradd">
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">��  �ţ�</td>
    <td bgcolor="#F9F9F9"><input name="username" type="text" id="username" size="15" </td>
  </tr>
    <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">��ʵ������</td>
    <td bgcolor="#F9F9F9"><input name="realname" type="text" id="realname" size="15" </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">�������룺</td>
    <td bgcolor="#F9F9F9"><input name="password" type="password" id="password" size="15"></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">�û����</td>
    <td bgcolor="#F9F9F9">
       <select name="groupid">
       <?=$showgroup;?>
       </select>  
       <SCRIPT LANGUAGE="JavaScript1.2">
        var Obj=document.form1.groupid;
            Obj.value="99";
       </SCRIPT> 
    </td>
  </tr>
    <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">�������ţ�</td>
    <td bgcolor="#F9F9F9">
       <select name="manageid">
       	<option value=0>��ѡ����</option>
       <?=$showmanage;?>
       </select>  
       <SCRIPT LANGUAGE="JavaScript1.2">
        var Obj=document.form1.manageid;
            Obj.value=0;
       </SCRIPT> 
    </td>
  </tr>  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">����ѧ�ƣ�</td>
    <td bgcolor="#F9F9F9">
       <select name="subjectid">
      	<option value=0>��ѡ��ѧ��</option>
       <?=$showsubject;?>
       </select>  
       <SCRIPT LANGUAGE="JavaScript1.2">
        var Obj=document.form1.subjectid;
            Obj.value=0;
       </SCRIPT> 
    </td>
  </tr>  
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">&nbsp;</td>
    <td bgcolor="#F9F9F9"><input type="submit" name="Submit" value=" ȷ �� ">
</td>
  </tr>
</form>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?
  break;
  case 'useredit':
  if ($group_id>1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
  //��ҳ����
$query="select count(*) as num from members order by userid";
$r=$db->query_first($query);
$totalnum=$r[num];
$pagenumber = intval($pagenumber);
if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
$curpage=($pagenumber-1)*$perpage;
$listurl="?filename=user&action=useredit";
$pagenav=getpagenav($totalnum,$listurl); 

  $query="SELECT * FROM `members` ORDER BY `groupid`,`manageid` ASC limit $curpage,$perpage";
  $result=$db->query($query);
  while($s=$db->fetch_array($result)){
  $userid=$s[userid];
	$username=$s[username];	
	$realname=$s[realname];
	$groupid=$s[groupid];
	$manageid=$s[manageid];
  $subjectid=$s[subjectid];
	$userlist.="<form name=form$userid method=post action=?filename=deal&action=useredit>
	            <input type=hidden name=userid value=$userid>
	            <tr align=center>
	               <td width=80 height=25  bgcolor=#F0F0F0>
	               $username
	               </td>
	               <td width=100   bgcolor=#F0F0F0>
	                <input type=text name=realname value=\"$realname\" size=16>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <select name=groupid>$showgroup</select>
	                <SCRIPT LANGUAGE=\"JavaScript1.2\">
                  var Obj=document.form$userid.groupid;
                      Obj.value=\"$groupid\";
                </SCRIPT>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <select name=manageid>$showmanage</select>
	                <SCRIPT LANGUAGE=\"JavaScript1.2\">
                  var Obj=document.form$userid.manageid;
                      Obj.value=\"$manageid\";
                </SCRIPT>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <select name=subjectid>$showsubject</select>
	                <SCRIPT LANGUAGE=\"JavaScript1.2\">
                  var Obj=document.form$userid.subjectid;
                      Obj.value=\"$subjectid\";
                </SCRIPT>
	               </td>
	               <td bgcolor=#F9F9F9 width=110>
	                <input type=submit name=submit value=�޸�>
	                <a href=?filename=user&action=userdel&userid=$userid>ɾ��</a>
	               </td>
	             </tr>
	             </form>";	
	         }
  ?>
  <html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�û�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=user&action=useradd">����û�</A> | <A 
      href="?filename=user&action=useredit">�༭�û�</A> | <A 
      href="?filename=user&action=modifypassword">�޸�����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã��û����� >> �༭�û�</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH>�� ��</TH><TH>��ʵ����</TH><TH>�û���</TH><TH>��������</TH><TH>����ѧ��</TH><TH>����</TH></TR>
     <?=$userlist?>
     <?=$pagenav?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?
  break;
  case 'modifypassword':
  if ($group_id>1){
 $modifypass="
    <form name=form1 method=post action=?filename=deal&action=modifypassword>
  <tr>
    <td width=180 height=25 align=right bgcolor=#F0F0F0>�ʺţ�</td>
    <input name=user_admin type=hidden id=username size=15 value=$user_admin>
    <td bgcolor=#F9F9F9>$user_name</td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>������ԭ���룺</td>
    <td bgcolor=#F9F9F9><input name=oldpassword type=password id=oldpassword size=15></td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>�����������룺</td>
    <td bgcolor=#F9F9F9><input name=password type=text id=password size=15></td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>�������������룺</td>
    <td bgcolor=#F9F9F9><input name=password1 type=text id=password1 size=15></td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>&nbsp;</td>
    <td bgcolor=#F9F9F9><input type=submit name=Submit value=' ȷ �� '>
</td>
  </tr>
</form>
";
} else
{
   $modifypass="
    <form name=form1 method=post action=?filename=deal&action=modifypassword>
      <input name=user_admin type=hidden id=username size=15 value=$user_admin>
  <tr>
    <td width=180 height=25 align=right bgcolor=#F0F0F0>�ʺţ�</td>
    <td bgcolor=#F9F9F9><input name=username type=text id=username size=15 value=></td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>�����������룺</td>
    <td bgcolor=#F9F9F9><input name=password type=text id=password size=15></td>
  </tr>
  <tr>
    <td height=25 align=right bgcolor=#F0F0F0>&nbsp;</td>
    <td bgcolor=#F9F9F9><input type=submit name=Submit value='ȷ ��'>
</td>
  </tr>
</form>
";

} ?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�û�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=user&action=useradd">����û�</A> | <A 
      href="?filename=user&action=useredit">�༭�û�</A> | <A 
      href="?filename=user&action=modifypassword">�޸�����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã��û����� >> �޸�����</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>�޸�����</TH></TR>
     <?=$modifypass?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?
break;
case 'userlist':
while (list($key,$value)=each($managements)){
$managementlist.= "<tr><td style=\"cursor:hand\" onclick=\"javascript:location.href='index.php?filename=user&action=userlist&manageid=$key';\">$value</td></tr>";
}
if ($manageid){
   $query="SELECT * FROM `members` where manageid=$manageid";
   $result=$db->query($query);
   while($r=$db->fetch_array($result)){
   	$userlist.= "<tr><td style=\"cursor:hand\" onclick=getuser('$r[realname]')>$r[realname]</td></tr>";
   	}
}
?>
<script language='JavaScript'>   
function getuser(username){	
   var tbl = window.opener.document.form1;
       tbl.leaver.value=username;   
   window.close();
  }
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�����б�</TD>
          </TR>
          <?=$managementlist;?>
        </TBODY>
      </TABLE>
    </td>
        <td width="100"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>������Ա</TD>
          </TR>
          <?=$userlist;?>
        </TBODY>
      </TABLE>
    </td>
</TR>
</TABLE>
</body>
<?
break;
case 'usersetting':
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100"  height="50" valign="middle">
    	<img src="./templates/<?=$style;?>/images/menu/person_info.gif" border="0" align="absmiddle" width="20" height="20" alt="�������">�������-<?=$realname;?></td>
  </tr>
  <tr>  
    <td width="100%"  height="200" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle  class=td1 height=200 width=33%>
            	<a href=index.php?filename=user&action=infoedit><img src="./templates/<?=$style;?>/images/menu/person_info.gif" border="0" align="absmiddle" width="16" height="16" alt="������������">������������</a>
            	<p>���ø��˵���Ϣ����
            </TD>
            <TD  align=middle  class=td1 width=33%>
            <a href=index.php?filename=user&action=modifypassword><img src="./templates/<?=$style;?>/images/login.gif" border="0" align="absmiddle" width="16" height="16" alt="�����޸�">�����޸�</a>
            <p>�޸��ʺ�����
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    </td>
</TR>
</TABLE>
</body>
<?
break;
case 'infoedit':
//��¼���ݵĶ�ȡ
$query="select members.*,userinfo.*  from members 
            LEFT JOIN userinfo ON members.userid=userinfo.userid 
            where members.userid=$user_id 
            limit 1";
$r=$db->query_first($query);
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>

<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.username.value == "")
   {
   		alert("����������!");
		theform.username.focus();
		return false ;
   }
   return true ;
  }
</SCRIPT>
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
            <TD  align=middle  class=td1 height=24 width=33%>
            	<a href=index.php?filename=user&action=infoedit><img src="./templates/<?=$style;?>/images/menu/person_info.gif" border="0" align="absmiddle" width="16" height="16" alt="������������">������������</a>
            </TD>
            <TD  align=middle  class=td1 width=33%>
            <a href=index.php?filename=user&action=modifypassword><img src="./templates/<?=$style;?>/images/login.gif" border="0" align="absmiddle" width="16" height="16" alt="�����޸�">�����޸�</a>
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    </td>
</TR>
  <tr> 
 <td  height="24"><strong>��ǰλ�� >> ������� >> ������������ </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=editinfo" OnSubmit="return check(this)">
        <TBODY>
          <TR> 
            <Td colSpan=2 class=tr_head height=28 align=center>������������</Td>
          </TR>             
          <TR> 
            <TD class=tablerow>��ʵ����</TD>
            <TD class=tablerow>
            	 <input type=text name="realname" size=20 value=<?=$r[realname];?>> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>   
	        <tr>	<TD class=tablerow>�� ��</TD>
          	      <td bgcolor=#F9F9F9>
	                <select name=sex>
	                	<option value=0>��</option>
	                	<option value=1>Ů</option>
	                	</select>
	                <SCRIPT LANGUAGE="JavaScript1.2">
                  var Obj=document.form1.sex;
                      Obj.value="<?=$r[sex];?>";
                </SCRIPT>
	               </td>
	        </tr>           
	        <tr>	<TD class=tablerow>��������</TD>
	               <td bgcolor=#F9F9F9>
	                <select name=manageid><?=$showmanage;?></select>
	                <SCRIPT LANGUAGE="JavaScript1.2">
                  var Obj=document.form1.manageid;
                      Obj.value="<?=$r[manageid];?>";
                </SCRIPT>
	               </td>
	        </tr>
	        <tr>	   <TD class=tablerow>����ѧ��</TD>    
	               <td bgcolor=#F9F9F9>
	                <select name=subjectid><?=$showsubject;?></select>
	                <SCRIPT LANGUAGE="JavaScript1.2">
                  var Obj=document.form1.subjectid;
                      Obj.value="<?=$r[subjectid];?>";
                </SCRIPT>
            </td>
          </tr>      
          <TR> 
            <TD class=tablerow>��ͥ��ַ</TD>
            <TD class=tablerow>
            	 <input type=text name="address" size=40 value=<?=$r[address];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>������λ</TD>
            <TD class=tablerow>
            	 <input type=text name="work" size=40 value=<?=$r[work];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>�ֻ�����</TD>
            <TD class=tablerow>
            	 <input type=text name="tel1" size=20 value=<?=$r[tel1];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>С��ͨ</TD>
            <TD class=tablerow>
            	 <input type=text name="tel2" size=20 value=<?=$r[tel2];?>> 
            	</TD>
          </TR> 
          <TR> 
            <TD class=tablerow>��ͥ�绰</TD>
            <TD class=tablerow>
            	 <input type=text name="tel3" size=20 value=<?=$r[tel3];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>QQ����</TD>
            <TD class=tablerow>
            	 <input type=text name="qq" size=20 value=<?=$r[qq];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>email</TD>
            <TD class=tablerow>
            	 <input type=text name="email" size=20 value=<?=$r[email];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>msn</TD>
            <TD class=tablerow>
            	 <input type=text name="msn" size=20 value=<?=$r[msn];?>> 
            	</TD>
          </TR>                                
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
                <input type="submit" name="Submit" value=" �� �� " > 
                </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
</table>
</body>
<?
break;
case 'userdel':
//��¼���ݵĶ�ȡ
$query="select * from members where `userid`='$userid' limit 1";
$r=$db->query_first($query);
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=userdel">
  <tr>
    <td height="160" valign="middle" align=center>
    	���Ҫɾ���û�<font color=red>{<?=$r[realname];?>}</font> <p>
    	<input type=hidden name=userid value=<?=$userid;?>>	
      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
}
?>
