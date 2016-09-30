<?php
/*
凤鸣山中小学网络办公室
*/
//用户检测
$user_id=$_SESSION[user_id];
if ($groupid>1) showmessage("对不起，你没有权限访问！");
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>模版管理</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=template&action=add">模版添加</A> | <A 
      href="?filename=template&action=modify">模版管理</A> | <A 
      href="?filename=template&action=setadd">版系添加</A> | <A 
      href="?filename=template&action=setlist">版系管理</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置：模版管理 >> 版系添加</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>版系添加</TH></TR>
  <form action="?filename=template&action=insert"  name="name" method="post">
<tr ><td class=tablerow colspan='2'><a name=""><b><span >添加新模板</span></b></a></td></tr>
<tr class=tablerow valign='top'>
<td class=tablerow><p>模板名称</p></td>
<td class=tablerow><p><input type="text" size="35" name="title" value="<?=$title;?>"></p></td>
</tr>
<tr class=tablerow valign='top'>
<td class=tablerow ><p>模板套系</p></td>
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
<td class=tablerow><p>模板内容<br><br></p></td>
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
      alert('没有找到。');
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
        alert('没有找到。');
    }
  }
  return false;
}
</script>
<input name='string' type='text' accesskey='t' size=20 onChange='n=0;'>
<input type='button' value='查找' accesskey='f' onClick='javascript:findInPage(document.name.string.value)'>&nbsp;&nbsp;&nbsp;
<input type='button' value='预览' accesskey='p' onclick='javascript:displayHTML()'>
<input type='button' value='复制' accesskey='c' onclick='javascript:HighlightAll()'></p></td>
</tr>
<input type="hidden" name="group" value="">
<tr id='submitrow'>
<td class=tablerow colspan='2' align='center'><p id='submitrow'><input type="submit" value="   保存   " accesskey="s">
<input type="reset" value="   重置   ">
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
  	  $ok="模版添加成功！请返回！";
  	    $referer="?filename=template&action=add";
    } else {
      $db->query("UPDATE template SET template='$template' WHERE templatesetid='$templatesetid' AND title='$title'");
    $ok="模版修改成功！请返回！";
      $referer="?filename=template&action=modify";
    }
  } 

if($db->affected_rows()>0){
showmessage($ok,$referer);
}else
showmessage("模版添加失败!");
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
<tr class='tblhead'><td colspan='2'><a name=""><b><span class='tblhead'>确认删除</span></b></a></td></tr><tr class='firstalt' valign='top'>
            <td colspan='2'>你确实要删除这个模板吗？这样做将删除此模板！</td>
          </tr>
<tr id='submitrow'>
<td colspan='2' align='center'><p id='submitrow'><input type="submit" value="   是   " accesskey="s">
<input type="button" value="   否   " onclick="history.back(1)">
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
  echo "<p>完成！</p>";
  $action="modify";
}
// ###################### Start Modify #######################
if ($action=="modify") {
	$t=$db->query("SELECT * FROM `templateset` order by `templatesetid` ASC");
 while ($r=$db->fetch_array($t)) {		
  $setlist.="[<a href=?filename=template&action=modify&templatesetid=$r[templatesetid]>$r[templatesetname]</a>] ";
  }
  if (empty($templatesetid)) $templatesetid=0;
 //数据读取
 $templates=$db->query("SELECT templateid,title FROM template WHERE templatesetid=$templatesetid ORDER BY title");
 while ($template=$db->fetch_array($templates)) {		
   $templatelist.=" <tr bgColor=#f1f3f5 onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF'>
	            <td width=10% align=center>$r[templatesetid]</td>
              <td> <font face=webdings>=</font>$template[title]<a href=?filename=template&action=add&templatesetid=$templatesetid&templateid=$template[templateid]&title=$template[title]>[更改初始值]</a> <a href=?filename=template&action=remove&templateid=$template[templateid]&title=$template[title]>[删除]</a></td>
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>模版管理</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=template&action=add">模版添加</A> | <A 
      href="?filename=template&action=modify">模版管理</A> | <A 
      href="?filename=template&action=setadd">版系添加</A> | <A 
      href="?filename=template&action=setlist">版系管理</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置：模版管理 >> 模版管理</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>模版管理</TH></TR>
  <tr>
    <td colSpan=2 class=tablerow>
    版系选择:<?=$setlist?>
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
    <TH colSpan=2>模版管理</TH></TR>
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>模版管理</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=template&action=add">模版添加</A> | <A 
      href="?filename=template&action=modify">模版管理</A> | <A 
      href="?filename=template&action=setadd">版系添加</A> | <A 
      href="?filename=template&action=setlist">版系管理</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置：模版管理 >> 版系添加</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>版系添加</TH></TR>
  <FORM action="?filename=template&action=addtemplateset&templatesetid=<?=$id?>" method=post name=form1>
   
    <TR>
    <TD class=tablerow>新版系名称</TD>
    <TD class=tablerow><input type="text" name=templatesetname value=<?=$templatesetname?>>
    </td>
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" 确定 "> <INPUT name=reset type=reset value=" 清除 "></TD></TR></FORM></TBODY></TABLE></TD></TR></TABLE>
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
              <td> <a href=?filename=template&action=setadd&id=$r[templatesetid]>修改</a> | 锁定 | 清空 | 删除</td>
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>模版管理</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=template&action=add">模版添加</A> | <A 
      href="?filename=template&action=modify">模版管理</A> | <A 
      href="?filename=template&action=setadd">版系添加</A> | <A 
      href="?filename=template&action=setlist">版系管理</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置：模版管理 >> 版系管理</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=3>版系管理</TH></TR>
  <FORM action="?filename=deal&action=addtemplateset>" method=post name=form1>
   <tr align=center valign=middle>
      <td width=10% class=tablerowhighlight>栏目类型</td> 
     <td width=40%  height=28  class=tablerowhighlight>栏目名称</td>
    <td width=50%  class=tablerowhighlight >管理操作</td>
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>模版管理</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=template&action=add">模版添加</A> | <A 
      href="?filename=template&action=modify">模版管理</A> | <A 
      href="?filename=template&action=setadd">版系添加</A> | <A 
      href="?filename=template&action=setlist">版系管理</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置：模版管理 >> 版系添加</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>版系添加</TH></TR>
  <FORM action="?filename=deal&action=addtemplateset" method=post name=form1>
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" 确定 "> <INPUT name=reset type=reset value=" 清除 "></TD>
    </TR>
    </FORM></TBODY></TABLE></TD></TR></TABLE>
    </td>
  </tr>
</table>

<?
}
//##########################插入新版系##########################################
if ($action=="addtemplateset"){
	if (trim($templatesetname) != "") {
		if ($templatesetid){			
		$db->query("UPDATE templateset SET templatesetname='$templatesetname' WHERE templatesetid='$templatesetid'");
    $ok="版系修改成功";
      $referer="?filename=template&action=setlist";
    } 
                else {
    if (!$preexists=$db->query_first("SELECT templatesetid FROM templateset WHERE templatesetname='$templatesetname'")) {
         $result = $db->query("INSERT INTO templateset (templatesetid,templatesetname) VALUES ('','$templatesetname')");
  	   $templateid = $db->insert_id($result);
  	   $ok="版系添加成功";
  	     $referer="?filename=template&action=setadd";
     } 
   }
    $old="<p>模板已成功添加！</p>";
    $action="setlist";
    $expandset=$templatesetid;
  } else {
    echo "<p>你忘记为这个模板添加一个名称！</p>";
  }

 if($db->affected_rows()>0){
showmessage($ok,$referer);
}else
showmessage("模版添加失败!");
}

?>
