<?php
/*
����ɽ��Сѧ����칫��
*/

//Ȩ�޼��
if ($group_id!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");

/*****************************************************************************/
//��Ŀ���ݶ�ȡ
$query="select * from $table_type order by `path`,`tid`";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$tuid=$r[uid];
	$id=$r[id];
	$type[$tuid][]=$r[id];
	$totaltype[$id]=array($r[id],$r[uid],$r[cid],$r[path],$r[layerid],$r[typename],$r[tid],$r[isshow],$r[enablecontribute],$r[templatetitle],$r[actionurl],$r[typepic],$r[isright]);
};
//����б����״��ʽ
show_type_select(0,1);
/*****************************************************************************/
//Ĭ����Ŀ�������
if ($uid)$uid="$uid";
else $uid="0";
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body>
<?php
switch($action){
	case 'addtype':
		//��Ŀ���
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>��Ŀ����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=type&action=addtype">��Ŀ���</A> | <A 
      href="?filename=type&action=listtype">��Ŀ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã���Ŀ���� >> ��Ŀ���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>��Ŀ���</TH></TR>
  <FORM action="?filename=deal&action=addtype" method=post name=form1>
  <TR>
    <TD class=tablerow width="20%">������Ŀ</TD>
    <TD class=tablerow width="80%">
      <SELECT name=uid> 
      <OPTION value="0">�ޣ���Ϊһ����Ŀ��</OPTION> 
      <?=$type_select;?>
      </SELECT> 
      <SCRIPT LANGUAGE="JavaScript1.2">
      var Obj=document.form1.uid;
      Obj.value="<?=$uid;?>";
      </SCRIPT>
    </TD></TR>
  <TR>
    <TD class=tablerow>��Ŀ����</TD>
    <TD class=tablerow><INPUT name=typename size=30></TD></TR>
  <TR>
    <TD class=tablerow>�Ƿ񿪷�</TD>
    <TD class=tablerow><INPUT CHECKED name=isshow type=radio 
      value=1>��&nbsp;&nbsp;&nbsp;&nbsp; <INPUT name=isshow type=radio 
    value=0>��</TD></TR>
  <TR>
     <TD class=tablerow width=300><STRONG>�Ƿ�����Ͷ��</STRONG><BR></TD>
     <TD class=tablerow><INPUT  name=enablecontribute type=radio value=1>��&nbsp;&nbsp;&nbsp;&nbsp;
                        <INPUT  CHECKED name=enablecontribute type=radio value=0>��</TD>
  </TR>
    <TR>
     <TD class=tablerow width=300><STRONG>�Ƿ���ҪȨ������</STRONG><BR></TD>
     <TD class=tablerow><INPUT  name=isright type=radio value=1>��&nbsp;&nbsp;&nbsp;&nbsp;
                        <INPUT  CHECKED name=isright type=radio value=0>��</TD>
  </TR>
  <TR>
     <TD class=tablerow width=300><STRONG>ģ������</STRONG></TD>
     <TD class=tablerow>
     <input type=text name=templatetitle value="">
     </TD>
   </TR>
  <TR>
     <TD class=tablerow width=300><STRONG>������ҳ</STRONG></TD>
     <TD class=tablerow>
     <input type=text name=actionurl value="" size=30>
     </TD>
   </TR>

   <TR>
     <TD class=tablerow width=300><STRONG>��ĿͼƬ</STRONG></TD>
     <TD class=tablerow>
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD width="45%"><INPUT name=typepic size=20> </TD>
          <TD id=up><A href="#" onclick="javascrit:window.open('index.php?filename=file','new','height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=0,left=0,resizable=no');">�ļ�����ѡ��</A> </TD>
          <TD id=upload style="DISPLAY: none"><IFRAME border=0 frameBorder=0 frameSpacing=0 height=22 marginHeight=0 marginWidth=0 scrolling=no src="editor.php?action=upspecialpic" width=220></IFRAME></TD>
        </TR>
        </TBODY>
       </TABLE></TD>
   </TR>
 
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" ȷ�� "> <INPUT name=reset type=reset value=" ��� "></TD></TR></FORM></TBODY></TABLE></TD></TR></TABLE>
    </td>
  </tr>
</table>
<?php
break;
//��Ŀ����
	case 'listtype':
		//���Ϊ����ı����ʽ
		show_type_table(0,1);

?>

<script>
function show(c_Str){
	if(document.all(c_Str).style.display=='none'){
		document.all(c_Str).style.display='block'
	}else{
		document.all(c_Str).style.display='none'
	}
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>��Ŀ����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=type&action=addtype">��Ŀ���</A> | <A 
      href="?filename=type&action=listtype">��Ŀ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã���Ŀ���� >> ��Ŀ����</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
    <table>
    <form id="orderid" name="orderid" method="post" action="?filename=deal&action=saveorder">
    <tbody><tr><td></td></tr>
    <?= $show_type_table;?>
    </td>
  </tr>
  </form>
</table>
<?
break;
	case 'edittype':
		//�༭��Ŀ����
		$uid=$totaltype[$typeid][1];
		$typename=$totaltype[$typeid][5];
		$isshow=$totaltype[$typeid][7];
		if ($isshow==1) $isshow1="checked";
		else $isshow0="checked";
		$enablecontribute=$totaltype[$typeid][8];
		if ($enablecontribute==1) $enablecontribute1="checked";
		else  $enablecontribute0="checked";
		$isright=$totaltype[$typeid][12];
		if ($isright==1) $isright1="checked";
		else  $isright0="checked";
		$templatetitle=$totaltype[$typeid][9];
		$typepic=$totaltype[$typeid][11];
		if ($typepic=='0')$typepic="";
		$actionurl=$totaltype[$typeid][10];
		if(empty($actionurl)) $actionurl="";
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
      <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>��Ŀ����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=type&action=addtype">��Ŀ���</A> | <A 
      href="?filename=type&action=listtype">��Ŀ����</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE>
      </td>
  </tr>
  <tr> 
 <td  height="24"><strong>��ǰλ�ã���Ŀ���� >> ��Ŀ�༭</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
  <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
  <TBODY>
  <TR>
    <TH colSpan=2>��Ŀ�༭</TH></TR>
  <FORM action="?filename=deal&action=edittype&typeid=<?=$typeid?>&olduid=<?=$uid?>" method=post name=form1>
  <TR>
    <TD class=tablerow width="20%">������Ŀ</TD>
    <TD class=tablerow width="80%">
      <SELECT name=uid> 
      <OPTION value="0">�ޣ���Ϊһ����Ŀ��</OPTION> 
      <?=$type_select;?>
      </SELECT>
      <SCRIPT LANGUAGE="JavaScript1.2">
      var Obj=document.form1.uid;
      Obj.value="<?=$uid;?>";
      </SCRIPT>
    </TD></TR>
  <TR>
    <TD class=tablerow>��Ŀ����</TD>
    <TD class=tablerow><INPUT name=typename size=30 value=<?=$typename?>></TD></TR>
  <TR>
    <TD class=tablerow>�Ƿ񿪷�</TD>
    <TD class=tablerow><INPUT <?=$isshow1;?> name=isshow type=radio 
      value=1>��&nbsp;&nbsp;&nbsp;&nbsp; <INPUT <?=$isshow0;?>  name=isshow type=radio 
    value=0>��</TD></TR>
  <TR>
     <TD class=tablerow width=300><STRONG>�Ƿ�����Ͷ��</STRONG><BR></TD>
     <TD class=tablerow><INPUT <?=$enablecontribute1;?>  name=enablecontribute type=radio value=1>��&nbsp;&nbsp;&nbsp;&nbsp;
                        <INPUT  <?=$enablecontribute0;?>  name=enablecontribute type=radio value=0>��</TD>
  </TR>
      <TR>
     <TD class=tablerow width=300><STRONG>�Ƿ���ҪȨ������</STRONG><BR></TD>
     <TD class=tablerow><INPUT <?=$isright1;?> name=isright type=radio value=1>��&nbsp;&nbsp;&nbsp;&nbsp;
                        <INPUT <?=$isright0;?> name=isright type=radio value=0>��</TD>
  </TR>
  <TR>
     <TD class=tablerow width=300><STRONG>ģ������</STRONG></TD>
     <TD class=tablerow>
     <input type=text name=templatetitle value="<?=$templatetitle;?>">
     </TD>
   </TR>
  <TR>
     <TD class=tablerow width=300><STRONG>������ҳ</STRONG></TD>
     <TD class=tablerow>
     <input type=text name=actionurl value="<?=$actionurl;?>" size=30>
     </TD>
   </TR>
      <TR>
     <TD class=tablerow width=300><STRONG>��ĿͼƬ</STRONG></TD>
     <TD class=tablerow>
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD width="45%"><INPUT name=typepic size=20 value="<?=$typepic;?>"> </TD>
          <TD id=up><A href="#" onclick="javascrit:window.open('index.php?filename=file','new','height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=0,left=0,resizable=no');">�ļ�����ѡ��</A> </TD>
          <TD id=upload style="DISPLAY: none"><IFRAME border=0 frameBorder=0 frameSpacing=0 height=22 marginHeight=0 marginWidth=0 scrolling=no src="editor.php?action=upspecialpic" width=220></IFRAME></TD>
        </TR>
        </TBODY>
       </TABLE></TD>
   </TR>
 
  <TR>
    <TD class=tablerow></TD>
    <TD class=tablerow><INPUT name=submit type=submit value=" ȷ�� "> <INPUT name=reset type=reset value=" ��� "></TD></TR></FORM></TBODY></TABLE></TD></TR></TABLE>
    </td>
  </tr>
</table>
<?

break;
	case 'jointype':
?>
<table width="100%"  border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td height="25" bgcolor="#EFEFEF"><strong>����ǰλ�ã��ϲ����</strong></td>
  </tr>
</table>
<table width="100%" height="10"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td> </td>
  </tr>
</table>
<form method="post" action="deal.php?action=jointype">
<table cellspacing="0" cellpadding="0" border="0" width="85%" align="center">
<tr><td bgcolor="#000000">
<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr class="header"><td colspan="3">�ϲ���� - Դ��������ȫ��ת��Ŀ�����ͬʱɾ��Դ���</td></tr>
<tr align="center"><td bgcolor="#F8F8F8" width="40%">Դ���</td>
<td bgcolor="#FFFFFF" width="60%">
<select name="source">
<option value="0" selected="selected"> - �� - </option>
<?php
if(!empty($smtypeids)){
	while(list($stypeid,$typename)=each($smtypeids)){
		echo "<option value='$stypeid'>$typename</option>";
	}
}
?>
</select></td></tr>
<tr align="center"><td bgcolor="#F8F8F8" width="40%">Ŀ�����</td>
<td bgcolor="#FFFFFF" width="60%">
<select name="target">
<option value="0" selected="selected"> - �� - </option>
<?php
if(!empty($smtypeids)){
	reset($smtypeids);
	while(list($stypeid,$typename)=each($smtypeids)){
		echo "<option value='$stypeid'>$typename</option>";
	}
}
?>
</select>
</td></tr>
</table></td></tr></table><br><center><input type="submit" name="mergesubmit" value="�ϲ����"></center></form>
<?php
break;
	case 'deltype':
		$referer="?filename=deal&action=deltype&typeid=$typeid";
		showmessage("�Ƿ�ɾ������Ŀ",$referer,'form');
		break;
}
?>
</body>