<?php
/*
����ɽ��Сѧ����칫��
*/
//Ȩ�޼��
if ($group_id!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ѧУ����칫ϵͳ2009 v2.2.0</title>
<LINK href="./templates/<?=$style;?>/css/style.css" rel=stylesheet type=text/css>
</head>
<?
switch($action){
	//--------------���Ź���------------------------------------
	case 'manage'://���Ź���
	switch($do){
		case 'edit':
			$action="manageedit";
			$sql="select * from management where id=$id limit 1";
			$r=$db->query_first($sql);
			$manageid=$r[manageid];
			$managename=$r[managename];
			$managetel=$r[managetel];
		case 'add':
			if (!isset($id))$action="manageadd";
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>���Ź���</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=manage&do=add">�������</A> | <A 
      href="?filename=setting&action=manage&do=list">�����б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã����Ź��� >> �������</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>�������</TH></TR>
         <form name="form1" method="post" action="?filename=deal">
         	  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">����id��</td>
    <td bgcolor="#F9F9F9"><input name="manageid" type="text" id="manageid" size="15" value="<?=$manageid;?>"> </td>
  </tr>
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">�������ƣ�</td>
    <td bgcolor="#F9F9F9"><input name="managename" type="text" id="managename" size="15" value="<?=$managename;?>"> </td>
  </tr>
    <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">���ŵ绰��</td>
    <td bgcolor="#F9F9F9"><input name="managetel" type="text" id="managetel" size="15" value="<?=$managetel;?>">����绰��;�ָ� </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">&nbsp;</td>
    <td bgcolor="#F9F9F9">
    	<input type=hidden name=id value=<?=$id;?>>
    	<input type=hidden name=action value=<?=$action;?>>
    	<input type="submit" name="Submit" value=" ȷ �� ">
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
		case 'list':
			//��ҳ����
			$query="select count(*) as num from management";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$listurl="?filename=setting&action=manage&do=list";
			$pagenav=getpagenav($totalnum,$listurl);
			//���ݶ�ȡ
			$query="SELECT * FROM `management` ORDER BY `manageid` ASC limit $curpage,$perpage";
			$result=$db->query($query);
			while($s=$db->fetch_array($result)){
				$id=$s[id];
				$manageid=$s[manageid];
				$managename=$s[managename];
				$managetel=$s[managetel];
				$list.="<tr align=center>
	               <td width=80 height=25  bgcolor=#F0F0F0>
	                $manageid
	               </td>
	               <td width=100   bgcolor=#F0F0F0>
	                $managename
	               </td>
	               <td bgcolor=#F9F9F9>
	                $managetel
	               </td>
	               <td bgcolor=#F9F9F9 width=110>
	                <a href=?filename=setting&action=manage&do=edit&id=$id>�༭</a>
	                <a href=?filename=setting&action=manage&do=del&id=$id>ɾ��</a>
	               </td>
	             </tr>";	
			}
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
       <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>���Ź���</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=manage&do=add">�������</A> | <A 
      href="?filename=setting&action=manage&do=list">�����б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã����Ź��� >> �༭����</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH>��  ��</TH><TH>��������</TH><TH>���ŵ绰</TH><TH>����</TH></TR>
     <?=$list?>
     <?=$pagenav?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?	
break;
		case 'del':
			$referer="?filename=deal&action=managedel&id=$id";
			showmessage("�Ƿ�ɾ���˲���",$referer,'form');
			break;
	}
	break;
	case 'group'://�û�������
	switch($do){
		case 'edit':
			$action="groupedit";
			$sql="select * from usergroup where id=$id limit 1";
			$r=$db->query_first($sql);
			$groupid=$r[groupid];
			$grouptitle=$r[grouptitle];
			$usize=$r[usize];
		case 'add':
			if (!isset($id))$action="groupadd";
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
<TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>������</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=group&do=add">������</A> | <A 
      href="?filename=setting&action=group&do=list">����б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã������� >> ������</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>�û������</TH></TR>
         <form name="form1" method="post" action="?filename=deal">
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">�û���id��</td>
    <td bgcolor="#F9F9F9"><input name="groupid" type="text" id="groupid" size="15" value="<?=$groupid;?>"> </td>
  </tr>
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">�û������ƣ�</td>
    <td bgcolor="#F9F9F9"><input name="grouptitle" type="text" id="grouptitle" size="15" value="<?=$grouptitle;?>"> </td>
  </tr>
    <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">����������</td>
    <td bgcolor="#F9F9F9"><input name="usize" type="text" id="isize" size="15" value="<?=$usize;?>"> </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">&nbsp;</td>
    <td bgcolor="#F9F9F9">
    	<input type=hidden name=id value=<?=$id;?>>
    	<input type=hidden name=action value=<?=$action;?>>
    	<input type="submit" name="Submit" value=" ȷ �� ">
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
		case 'list':
			//��ҳ����
			$query="select count(*) as num from usergroup";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$listurl="?filename=setting&action=group&do=list";
			$pagenav=getpagenav($totalnum,$listurl);
			//���ݶ�ȡ
			$query="SELECT * FROM `usergroup` ORDER BY `groupid` ASC limit $curpage,$perpage";
			$result=$db->query($query);
			while($s=$db->fetch_array($result)){
				$id=$s[id];
				$groupid=$s[groupid];
				$grouptitle=$s[grouptitle];
				$usize=$s[usize];
				$list.="<tr align=center>
	               <td width=80 height=25  bgcolor=#F0F0F0>
	                $groupid
	               </td>
	               <td width=100   bgcolor=#F0F0F0>
	                $grouptitle
	               </td>
	               <td bgcolor=#F9F9F9>
	                $usize
	               </td>
	               <td bgcolor=#F9F9F9 >
	                <a href=?filename=setting&action=right&groupid=$groupid>Ȩ������</a>
	                <a href=?filename=setting&action=group&do=edit&id=$id>�༭</a>
	                <a href=?filename=setting&action=group&do=del&id=$id>ɾ��</a>
	               </td>
	             </tr>";	
			}
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>������</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=group&do=add">������</A> | <A 
      href="?filename=setting&action=group&do=list">����б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã������� >> �༭���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH>��  ��</TH><TH>�������</TH><TH>U������</TH><TH>����</TH></TR>
     <?=$list?>
     <?=$pagenav?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?	
break;
		case 'del':
			$referer="?filename=deal&action=groupdel&id=$id";
			showmessage("�Ƿ�ɾ�������",$referer,'form');
			break;
	}
	break;
	case 'subject'://ѧ�ƹ���
	switch($do){
		case 'edit':
			$action="subjectedit";
			$sql="select * from subject where id=$id limit 1";
			$r=$db->query_first($sql);
			$subjectid=$r[subjectid];
			$subjectname=$r[subjectname];
		case 'add':
			if (!isset($id))$action="subjectadd";
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
<TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ѧ�ƹ���</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=subject&do=add">ѧ�����</A> | <A 
      href="?filename=setting&action=subject&do=list">ѧ���б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã�ѧ�ƹ��� >> ѧ�����</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>�������</TH></TR>
         <form name="form1" method="post" action="?filename=deal">
         	  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">ѧ��id��</td>
    <td bgcolor="#F9F9F9"><input name="subjectid" type="text" id="subjectid" size="15" value="<?=$subjectid;?>"> </td>
  </tr>
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">ѧ�����ƣ�</td>
    <td bgcolor="#F9F9F9"><input name="subjectname" type="text" id="subjectname" size="15" value="<?=$subjectname;?>"> </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">&nbsp;</td>
    <td bgcolor="#F9F9F9">
    	<input type=hidden name=id value=<?=$id;?>>
    	<input type=hidden name=action value=<?=$action;?>>
    	<input type="submit" name="Submit" value=" ȷ �� ">
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
		case 'list':
			//��ҳ����
			$query="select count(*) as num from subject";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$listurl="?filename=setting&action=subject&do=list";
			$pagenav=getpagenav($totalnum,$listurl);
			//���ݶ�ȡ
			$query="SELECT * FROM `subject` ORDER BY `subjectid` ASC limit $curpage,$perpage";
			$result=$db->query($query);
			while($s=$db->fetch_array($result)){
				$id=$s[id];
				$subjectid=$s[subjectid];
				$subjectname=$s[subjectname];
				$list.="<tr align=center>
	               <td width=80 height=25  bgcolor=#F0F0F0>
	                $subjectid
	               </td>
	               <td width=100   bgcolor=#F0F0F0>
	                $subjectname
	               </td>
	               <td bgcolor=#F9F9F9 width=110>
	                <a href=?filename=setting&action=subject&do=edit&id=$id>�༭</a>
	                <a href=?filename=setting&action=subject&do=del&id=$id>ɾ��</a>
	               </td>
	             </tr>";	
			}
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
       <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>ѧ�ƹ���</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=subject&do=add">ѧ�����</A> | <A 
      href="?filename=setting&action=subject&do=list">ѧ���б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã�ѧ�ƹ��� >> �༭ѧ��</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH>��  ��</TH><TH>ѧ������</TH><TH>����</TH></TR>
     <?=$list?>
     <?=$pagenav?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?	
break;
		case 'del':
			$referer="?filename=deal&action=subjectdel&id=$id";
			showmessage("�Ƿ�ɾ����ѧ��",$referer,'form');
			break;
	}
	break;
	case 'right':
		if ($groupid){
			//�û���Ȩ�޶�ȡ
			$sql="select * from userright where rightid=$groupid limit 1";
			$result=$db->query($sql);
			if($db->affected_rows()!=0){
				$r=$db->fetch_array($result);
				$rights=$r[rights];
				$right=1;
				$rights=explode(":",$rights);
				while (list($key,$tright)=each($rights)){
					$tright=explode("|",$tright);
					$lright=sizeof($tright);
					for ($i=1;$i<=$lright;$i++)
					$rightdata[$tright[0]][]=$tright[$i];
				}
			} else $right=0;
		} else $right=0;

		//��Ŀ���ݶ�ȡ
		$query="SELECT * FROM $table_type where isright=1 ORDER BY `id` ASC ";
		$result=$db->query($query);
		$dd="";
		while($r=$db->fetch_array($result)){
			$types.=$dd.$r[id];
			if ($rightdata[$r[id]][0]==1) $islist="checked";
			if ($rightdata[$r[id]][1]==1) $isadd="checked";
			if ($rightdata[$r[id]][2]==1) $isedit="checked";
			if ($rightdata[$r[id]][3]==1) $isdel="checked";
			if ($rightdata[$r[id]][4]==1) $ispass="checked";
			$rightlist.="
	       <tr align=center valign=middle>
	         <td >$r[typename]</td>
	         <td><input type=checkbox name=list$r[id] value=1 $islist></td>
	         <td><input type=checkbox name=add$r[id] value=1  $isadd></td>
	         <td><input type=checkbox name=edit$r[id] value=1 $isedit></td>
	         <td><input type=checkbox name=del$r[id] value=1  $isdel></td>
	         <td><input type=checkbox name=pass$r[id] value=1 $ispass></td>
	       </tr>
	      ";
			$dd=",";
			$islist=$isadd=$isedit=$isdel=$ispass="";
		}
		unset($islist,$isadd,$isedit,$isdel,$ispass);
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="24"><strong>��ǰλ�ã������� >> Ȩ�޹���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
     	<form name="form1" method="post" action="?filename=deal&action=addright">
      <TR>
       <TH>��Ŀ����</TH><TH>���</TH><TH>���</TH><TH>�༭</TH><TH>ɾ��</TH><TH>����</TH></TR>
       <?=$rightlist;?>
       <tr>
       	<td align=center>
       		<input type=hidden name=types value="<?=$types;?>">
       		<input type=hidden name=right value="<?=$right;?>">
       		<input type=hidden name=groupid value="<?=$groupid;?>">
       		<input type=submit name=s value=�༭Ȩ��></td>
      </tr>
     </TBODY>
    </form>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?
break;
//--------------------------------------�༶����----------------------------------------------------------
	case 'classset'://�༶����
	switch ($school_type){
		case '1':
			$grade_arr=array("1"=>"Сһ�꼶","2"=>"С���꼶","3"=>"С���꼶","4"=>"С���꼶","5"=>"С���꼶","6"=>"С���꼶");
			break;
		case '2':
			$grade_arr=array("1"=>"��һ�꼶","2"=>"�����꼶","3"=>"�����꼶");
			break;
		case '3':
			$grade_arr=array("1"=>"��һ�꼶","2"=>"�߶��꼶","3"=>"�����꼶");
			break;
		case '12':
			$grade_arr=array("1"=>"Сһ�꼶","2"=>"С���꼶","3"=>"С���꼶","4"=>"С���꼶","5"=>"С���꼶","6"=>"С���꼶","7"=>"��һ�꼶","8"=>"�����꼶","9"=>"�����꼶");
			break;
	}
	foreach($grade_arr as $key=>$value)
	  $grade.="<option value=$key>$value</option>";
	switch($do){
		case 'edit':
			$action="classedit";
			$sql="select * from classset where id=$id limit 1";
			$r=$db->query_first($sql);
			$classid=$r[classid];
			$noid=substr($classid,1,2);
			$classname=$r[classname];
			$gradeid=$r[gradeid];
			$state=$r[state];
		case 'add':
			if (!isset($id)) {
				$action="classadd";
				$gradeid=1;
				$noid='01';
			}
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�༶����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=classset&do=add">�༶���</A> | <A 
      href="?filename=setting&action=classset&do=list">�༶�б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã��༶���� >> �༶���</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH colSpan=2>�༶���</TH></TR>
         <form name="form1" method="post" action="?filename=deal">
    <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">�����꼶��</td>
    <td bgcolor="#F9F9F9">
    <select name=gradeid>
   <?=$grade;?>
    </select>
    <SCRIPT LANGUAGE="JavaScript1.2">
    var Obj=document.form1.gradeid;
    Obj.value="<?=$gradeid;?>";
      </SCRIPT>
          <select name=noid>
    <option value='01'>1��</option>
    <option value='02'>2��</option>
    <option value='03'>3��</option>
    <option value='04'>4��</option>
    <option value='05'>5��</option>
    <option value='06'>6��</option>
    <option value='07'>7��</option>
    <option value='08'>8��</option>
    <option value='09'>9��</option>
    <option value='10'>10��</option>
    <option value='11'>11��</option>
    <option value='12'>12��</option>
    </select>
    <SCRIPT LANGUAGE="JavaScript1.2">
    var Obj=document.form1.noid;
    Obj.value="<?=$noid;?>";
      </SCRIPT>
    </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">&nbsp;</td>
    <td bgcolor="#F9F9F9">
    	<input type=hidden name=id value=<?=$id;?>>
    	<input type=hidden name=action value=<?=$action;?>>
    	<input type="submit" name="Submit" value=" ȷ �� ">
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
		case 'list':
			//��ҳ����
			$query="select count(*) as num from classset";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$listurl="?filename=setting&action=classset&do=list";
			$pagenav=getpagenav($totalnum,$listurl);
			//���ݶ�ȡ
			$query="SELECT * FROM `classset` ORDER BY `classid` ASC limit $curpage,$perpage";
			$result=$db->query($query);
			while($s=$db->fetch_array($result)){
				$id=$s[id];
				$classid=$s[classid];
				$classname=$s[classname];
				$list.="<tr align=center>
	               <td width=80 height=25  bgcolor=#F0F0F0>
	                $classid
	               </td>
	               <td width=100   bgcolor=#F0F0F0>
	                $classname
	               </td>
	               <td bgcolor=#F9F9F9 width=110>
	                <a href=?filename=setting&action=classset&do=edit&id=$id>�༭</a>
	                <a href=?filename=setting&action=classset&do=del&id=$id>ɾ��</a>
	               </td>
	             </tr>";	
			}
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="993"  height="42" valign="top">
     <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
       <TBODY>
          <TR> 
            <TD  align=middle bgcolor="#4466cc" class=submenu>�༶����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=setting&action=classset&do=add">�༶���</A> | <A 
      href="?filename=setting&action=classset&do=list">�༶�б�</A> 
      </td>
       </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
    <td  height="24"><strong>��ǰλ�ã��༶���� >> �༭�༶</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top">
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder width=100%>
     <TBODY>
      <TR>
       <TH>�༶���</TH><TH>�༶����</TH><TH>����</TH></TR>
     <?=$list?>
     <?=$pagenav?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?	
break;
		case 'del':
			$referer="?filename=deal&action=classdel&id=$id";
			showmessage("�Ƿ�ɾ���˰༶",$referer,'form');
			break;
	}
	break;
}
?>


