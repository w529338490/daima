<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
//�û����
$query="select * from $table_members where username='$user_name' and groupid>0;";
$r=$db->query_first($query);
$user_id=$r[userid];
$user_group=$r[groupid];
$user_admining=$r[admining];
/*****************************************************************************/
//��Ŀ���ݶ�ȡ
$query="select * from $table_type order by `path`,`tid`";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	   $tuid=$r[uid];
	   $id=$r[id];
     $type[$tuid][]=$r[id];
     $totaltype[$id]=array($r[id],$r[uid],$r[cid],$r[path],$r[layerid],$r[typename],$r[tid],$r[isshow],$r[enablecontribute],$r[showid],$r[templateselect],$r[templatesetid],$r[templatetitle],$r[cssid]);    
};
/*****************************************************************************/
function show_type_select($sid,$uid)//����һΪ����id ��������Ϊ�������ڵĲ�id+1
{  global $type,$totaltype,$type_select;
    $tree_t="��";
    $tree_c="��";
    $tree_l="��";
    $tree_k="&nbsp;&nbsp;";
if (is_array($type)){
	foreach($type[$uid] as $tid)
	{ $temp=$type[$tid][0];//�����ж��Ƿ�����β��
	  $layerid=$totaltype[$tid][4];//��ȡ���� 
	  
	  if ($layerid==$sid){  $tree=$tree_t; }
	           else {  $tree=$tree_l;
	           	       for ($i=1;$i<$layerid-1;$i++){$tree.=$tree_k;}
                     $tree.=$tree_c;
                  };
	  $type_select.="<option value=$tid>".$tree.$layerid.$totaltype[$tid][5]."</option>";
		reset($type);
		//���������β������ݹ�
	  if ($temp==""){  
		              }
	                else{ $tree.=$tree_t;
                       show_type_select($sid,$tid);
                      }
  }	
  }
}
show_type_select(1,0); 
/*****************************************************************************/
//���ݲ���
switch($action){
  case 'useradd':
  if ($user_group>1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>�û�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=user&action=useradd">����û�</A> | <A 
      href="?filename=usere&action=useredit">�༭�û�</A> | <A 
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
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
     <TBODY>
      <TR>
       <TH colSpan=2>����û�</TH></TR>
         <form name="form1" method="post" action="?filename=deal&action=useradd">
  <tr>
    <td width="180" height="25" align="right" bgcolor="#F0F0F0">��  �ţ�</td>
    <td bgcolor="#F9F9F9"><input name="username" type="text" id="username" size="15" </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">�������룺</td>
    <td bgcolor="#F9F9F9"><input name="password" type="password" id="password" size="15"></td>
  </tr>
   <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">����email��</td>
    <td bgcolor="#F9F9F9"><input name="email" type="text" id="email" size="15"></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">������</td>
    <td bgcolor="#F9F9F9">
       <select name="groupid">
       <option value='3'>��ͨ�û�</option><option value='2'>����Ա</option><option value='1'>��������Ա</option>
       </select>   
    </td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#F0F0F0">�����飺</td>
    <td bgcolor="#F9F9F9">
     <select name="admining"><option value='-1'>��Ȩ��</option><option value='0'>������վ</option>
 <?=$type_select;?>
        </select> 
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
  if ($user_group>1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
  $query="SELECT * FROM `$table_members` ORDER BY `groupid` ASC ";
  $result=$db->query($query);
  while($s=$db->fetch_array($result)){
  $admining="";
  $admin="";
  $userid=$s[0];
  $useremail=$s[email];
	$username=$s[username];
	$usergroup=$s[groupid];
	$useradmining=$s[admining];
	$adminlist[3]="��ͨ�û�";
	$adminlist[2]="����Ա";
	$adminlist[1]="��������Ա"; 
	$group="";
  foreach($adminlist as $groupid => $value){
  	if ($groupid==$usergroup)	{		
  $group.="<option value='$groupid' selected>$value</option>";}
  else { $group.="<option value='$groupid'>$value</option>";}
  };
	$userlist.="<form name=form$userid method=post action=?filename=deal&action=useredit>
	            <input type=hidden name=userid value=$userid>
	            <tr align=center>
	               <td width=180 height=25  bgcolor=#F0F0F0>
	                $username
	               </td>
	               <td bgcolor=#F9F9F9>
	                <select name=groupid>$group</select>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <select name=admining>
	                 <option value='-1'>��Ȩ��</option>
	                 <option value='0'>������վ</option>
	                 $type_select
	                </select>
	               <SCRIPT LANGUAGE=\"JavaScript1.2\">
                  var Obj=document.form$userid.admining;
                      Obj.value=\"$useradmining\";
                </SCRIPT>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <input type=text name=email value=$useremail>
	               </td>
	               <td bgcolor=#F9F9F9>
	                <input type=submit name=submit value=�ύ�޸�>
	               </td>
	             </tr>
	             </form>";	
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
            <TD  align=middle bgcolor="#4466cc" class=submenu>�û�����</TD>
          </TR>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=user&action=useradd">����û�</A> | <A 
      href="?filename=usere&action=useredit">�༭�û�</A> | <A 
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
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
     <TBODY>
      <TR>
       <TH>�� ��</TH><TH>�û���</TH><TH>Ȩ��</TH><TH>email</TH><TH>����</TH></TR>
     <?=$userlist?>
     </TBODY>
     </TABLE>
    </td>
  </tr>
</table>
</body>
<?
  break;
  case 'modifypassword':
  if ($user_group>1){
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
      href="?filename=usere&action=useredit">�༭�û�</A> | <A 
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
     <TABLE cellPadding=2 cellSpacing=1 class=tableborder>
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
}
?>
