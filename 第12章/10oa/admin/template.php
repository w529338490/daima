<?php
/*
����ɽ��Сѧ����칫��
*/
//�û����
$user_id=$_SESSION[user_id];
if ($groupid>1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
////////////////////////////////////////////////////////////
if (isset($action)==0) {
  $action="modify";
}
###################### add template ######################
if ($action=="add"){
    if (empty($templatesetid)) $templatesetid=0;
  if (isset($title)) {
  	
    $templateinfo=$db->query_first("SELECT * FROM template WHERE templatesetid=$templatesetid AND title='".addslashes($title)."'");
    $template=$templateinfo[template];
    $templatesetid=$templateinfo[templatesetid];
  }	;
  	$t=$db->query("SELECT * FROM `templateset` order by `templatesetid` ASC");
 while ($r=$db->fetch_array($t)) {		
  $setlist.="<option value=$r[templatesetid]>$r[templatesetname]</option>";
  }
 
?>
<html><head>
<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
<meta http-equiv="MSThemeCompatible" content="Yes">
<link rel="stylesheet" href="./cp.css">
</head>
<body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ģ�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=template&action=add">ģ�����</A> | <A 
      href="?filename=template&action=modify">ģ�����</A> | <A 
      href="?filename=template&action=setadd">��ϵ���</A> | <A 
      href="?filename=template&action=setlist">��ϵ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã�ģ����� >> ��ϵ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>��ϵ���</TH></TR>
  <form action="?filename=template&action=insert"  name="name" method="post">
<tr ><td class=tablerow colspan='2'><a name=""><b><span >�����ģ��</span></b></a></td></tr>
<tr class=tablerow valign='top'>
<td class=tablerow><p>ģ������</p></td>
<td class=tablerow><p><input type="text" size="35" name="title" value="<?=$title;?>"></p></td>
</tr>
<tr class=tablerow valign='top'>
<td class=tablerow ><p>ģ����ϵ</p></td>
<td class=tablerow><p><select name="templatesetid">
<?=$setlist;?>
</select>
<SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.name.templatesetid;
            Obj.value="<?=$templatesetid;?>";
      </SCRIPT>
</p></td>
</tr>
<tr class='firstalt' valign='top'>
<td class=tablerow><p>ģ������<br><br></p></td>
<td class=tablerow><p><textarea name="template" rows="25" cols="80"><?=htmlspecialchars($template);?></textarea></p></td>
</tr>
<tr  valign='top'>
<td class=tablerow><p></p></td>
<td class=tablerow><p>
<SCRIPT LANGUAGE="JavaScript">
function displayHTML() {
var inf = document.name.template.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no, scrollbars=yes');
win.document.write("" + inf + "");
}
function HighlightAll() {
	var tempval=eval("document.name.template")
	tempval.focus()
	tempval.select()
	if (document.all){
	therange=tempval.createTextRange()
	therange.execCommand("Copy")
	window.status="Contents highlighted and copied to clipboard!"
	setTimeout("window.status=''",1800)
	}
}
var NS4 = (document.layers);    // Which browser?
var IE4 = (document.all);
var win = window;    // window to search.
var n   = 0;

function findInPage(str) {
  var txt, i, found;
  if (str == '')
    return false;
  if (NS4) {
    if (!win.find(str))
      while(win.find(str, false, true))
        n++;
    else
      n++;
    if (n == 0)
      alert('û���ҵ���');
  }

  if (IE4) {
    txt = win.document.body.createTextRange();
    for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) {
      txt.moveStart('character', 1);
      txt.moveEnd('textedit');
    }
    if (found) {
      txt.moveStart('character', -1);
      txt.findText(str);
      txt.select();
      txt.scrollIntoView();
      n++;
    } else {
      if (n > 0) {
        n = 0;
        findInPage(str);
      }
      else
        alert('û���ҵ���');
    }
  }
  return false;
}
</script>
<input name='string' type='text' accesskey='t' size=20 onChange='n=0;'>
<input type='button' value='����' accesskey='f' onClick='javascript:findInPage(document.name.string.value)'>&nbsp;&nbsp;&nbsp;
<input type='button' value='Ԥ��' accesskey='p' onclick='javascript:displayHTML()'>
<input type='button' value='����' accesskey='c' onclick='javascript:HighlightAll()'></p></td>
</tr>
<input type="hidden" name="group" value="">
<tr id='submitrow'>
<td class=tablerow colspan='2' align='center'><p id='submitrow'><input type="submit" value="   ����   " accesskey="s">
<input type="reset" value="   ����   ">
</p></td>
</tr>
</table>
<? 
};
// ###################### Start insert #######################
if ($action=="insert") {

  if (trim($title) != "") {
    if (!$preexists=$db->query_first("SELECT templateid FROM template WHERE title='$title' AND templatesetid='$templatesetid'")) {
      $result = $db->query("INSERT INTO template (templateid,templatesetid,title,template) VALUES (NULL,'$templatesetid','$title','$template')");
  	  $templateid = $db->insert_id($result);
  	  $ok="ģ����ӳɹ����뷵�أ�";
  	    $referer="?filename=template&action=add";
    } else {
      $db->query("UPDATE template SET template='$template' WHERE templatesetid='$templatesetid' AND title='$title'");
    $ok="ģ���޸ĳɹ����뷵�أ�";
      $referer="?filename=template&action=modify";
    }
  } 

if($db->affected_rows()>0){
showmessage($ok,$referer);
}else
showmessage("ģ�����ʧ��!");
}

// ###################### Start Remove templateset #######################
if ($action=="remove") {
?>
<html><head>
<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
<meta http-equiv="MSThemeCompatible" content="Yes">
<link rel="stylesheet" href="./cp.css">
</head>
<body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<form action="template.php"  name="name" method="post">
<input type="hidden" name="action" value="kill">
<br><table cellpadding='1' cellspacing='0' border='0' align='center' width='90%' class='tblborder'><tr><td>
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<input type="hidden" name="templateid" value="<? echo $templateid;?>">
<tr class='tblhead'><td colspan='2'><a name=""><b><span class='tblhead'>ȷ��ɾ��</span></b></a></td></tr><tr class='firstalt' valign='top'>
            <td colspan='2'>��ȷʵҪɾ�����ģ������������ɾ����ģ�壡</td>
          </tr>
<tr id='submitrow'>
<td colspan='2' align='center'><p id='submitrow'><input type="submit" value="   ��   " accesskey="s">
<input type="button" value="   ��   " onclick="history.back(1)">
</p></td>
</tr>
</table>
</td>
</tr>
</table>
</form>
</BODY></HTML>

<? }
// ###################### Start Kill #######################

if ($HTTP_POST_VARS['action']=="kill") {
  $db->query("DELETE FROM template WHERE templateid=$templateid");
  echo "<p>��ɣ�</p>";
  $action="modify";
}
// ###################### Start Modify #######################
if ($action=="modify") {
	$t=$db->query("SELECT * FROM `templateset` order by `templatesetid` ASC");
 while ($r=$db->fetch_array($t)) {		
  $setlist.="[<a href=?filename=template&action=modify&templatesetid=$r[templatesetid]>$r[templatesetname]</a>] ";
  }
  if (empty($templatesetid)) $templatesetid=0;
 //���ݶ�ȡ
 $templates=$db->query("SELECT templateid,title FROM template WHERE templatesetid=$templatesetid ORDER BY title");
 while ($template=$db->fetch_array($templates)) {		
   $templatelist.=" <tr bgColor=#f1f3f5 onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF'>
	            <td width=10% align=center>$r[templatesetid]</td>
              <td> <font face=webdings>=</font>$template[title]<a href=?filename=template&action=add&templatesetid=$templatesetid&templateid=$template[templateid]&title=$template[title]>[���ĳ�ʼֵ]</a> <a href=?filename=template&action=remove&templateid=$template[templateid]&title=$template[title]>[ɾ��]</a></td>
            </tr>";
  }
	?>
		<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ģ�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=template&action=add">ģ�����</A> | <A 
      href="?filename=template&action=modify">ģ�����</A> | <A 
      href="?filename=template&action=setadd">��ϵ���</A> | <A 
      href="?filename=template&action=setlist">��ϵ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã�ģ����� >> ģ�����</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>ģ�����</TH></TR>
  <tr>
    <td colSpan=2 class=tablerow>
    ��ϵѡ��:<?=$setlist?>
    </td>
  </tr>      
    </TBODY>
    </TABLE>
    </TD></TR>
   <tr>
    <td  height="5" valign="top">   
    </td>
  </tr>  
     <tr>
    <td  height="5" valign="top">  
      <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>ģ�����</TH></TR>
<?=$templatelist?>     
    </TBODY>
    </TABLE> 
    </td>
  </tr> 
    </TABLE>
    </td>
  </tr>
</table>
<?}
 
//########################set add#################################
if ($action=="setadd"){
	  if (isset($id)) {
    $t=$db->query_first("SELECT templatesetname FROM templateset WHERE templatesetid='$id'");
    $templatesetname=$t[templatesetname];
  }	
	?>
	<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ģ�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=template&action=add">ģ�����</A> | <A 
      href="?filename=template&action=modify">ģ�����</A> | <A 
      href="?filename=template&action=setadd">��ϵ���</A> | <A 
      href="?filename=template&action=setlist">��ϵ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã�ģ����� >> ��ϵ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>��ϵ���</TH></TR>
  <FORM action="?filename=template&action=addtemplateset&templatesetid=<?=$id?>" method=post name=form1>
   
    <TR>
    <TD class=tablerow>�°�ϵ����</TD>
    <TD class=tablerow><input type="text" name=templatesetname value=<?=$templatesetname?>>
    </td>
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" ȷ�� "> <INPUT name=reset type=reset value=" ��� "></TD></TR></FORM></TBODY></TABLE></TD></TR></TABLE>
    </td>
  </tr>
</table>
<?
}
//#########################set list#######################################
if ($action=="setlist"){
	$t=$db->query("SELECT * FROM `templateset` order by `templatesetid` ASC");
 while ($r=$db->fetch_array($t)) {		
  $setlist.=" <tr bgColor=#f1f3f5 onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF'>
	            <td width=10% align=center>$r[templatesetid]</td>
	            <td  align=left>$r[templatesetname]</td>
              <td> <a href=?filename=template&action=setadd&id=$r[templatesetid]>�޸�</a> | ���� | ��� | ɾ��</td>
            </tr>";
  }
	?>
		<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ģ�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=template&action=add">ģ�����</A> | <A 
      href="?filename=template&action=modify">ģ�����</A> | <A 
      href="?filename=template&action=setadd">��ϵ���</A> | <A 
      href="?filename=template&action=setlist">��ϵ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã�ģ����� >> ��ϵ����</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=3>��ϵ����</TH></TR>
  <FORM action="?filename=deal&action=addtemplateset>" method=post name=form1>
   <tr align=center valign=middle>
      <td width=10% class=tablerowhighlight>��Ŀ����</td> 
     <td width=40%  height=28  class=tablerowhighlight>��Ŀ����</td>
    <td width=50%  class=tablerowhighlight >�������</td>
        </tr>
        <?=$setlist?>
</table>
<?};
if ($action=="setedit"){
?>
	<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ģ�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=template&action=add">ģ�����</A> | <A 
      href="?filename=template&action=modify">ģ�����</A> | <A 
      href="?filename=template&action=setadd">��ϵ���</A> | <A 
      href="?filename=template&action=setlist">��ϵ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã�ģ����� >> ��ϵ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>��ϵ���</TH></TR>
  <FORM action="?filename=deal&action=addtemplateset" method=post name=form1>
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" ȷ�� "> <INPUT name=reset type=reset value=" ��� "></TD>
    </TR>
    </FORM></TBODY></TABLE></TD></TR></TABLE>
    </td>
  </tr>
</table>

<?
}
//##########################�����°�ϵ##########################################
if ($action=="addtemplateset"){
	if (trim($templatesetname) != "") {
		if ($templatesetid){			
		$db->query("UPDATE templateset SET templatesetname='$templatesetname' WHERE templatesetid='$templatesetid'");
    $ok="��ϵ�޸ĳɹ�";
      $referer="?filename=template&action=setlist";
    } 
                else {
    if (!$preexists=$db->query_first("SELECT templatesetid FROM templateset WHERE templatesetname='$templatesetname'")) {
         $result = $db->query("INSERT INTO templateset (templatesetid,templatesetname) VALUES ('','$templatesetname')");
  	   $templateid = $db->insert_id($result);
  	   $ok="��ϵ��ӳɹ�";
  	     $referer="?filename=template&action=setadd";
     } 
   }
    $old="<p>ģ���ѳɹ���ӣ�</p>";
    $action="setlist";
    $expandset=$templatesetid;
  } else {
    echo "<p>������Ϊ���ģ�����һ�����ƣ�</p>";
  }

 if($db->affected_rows()>0){
showmessage($ok,$referer);
}else
showmessage("ģ�����ʧ��!");
}

?>
