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
  if(theform.weburl.value == "http://")
   {
   		alert("��������ַ!");
		theform.weburl.focus();
		return false ;
   }
   return true ;
  } 
function openurl(id){
	window.open("index.php?filename=favorite&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=userdo&fileid="+id,"newu","height=200, width=200, top=200, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}
</script>  
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>����ѡ�</B> <A 
      href="?filename=favorite&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=public">�����ղؼ�</A> | <A 
      href="?filename=favorite&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=private">�ҵ��ղؼ�</A> | <A 
      href="?filename=favorite&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=list">�༭��ַ</A> | <A 
      href="?filename=favorite&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=add">�����ַ</A> </td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <?php
if($this->ftpl_var['action']=="add"){
?>
 <tr> 
 <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �����ַ </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addfavorite&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
        <TBODY>
          <TR> 
            <TH colSpan=2>�����ַ���ղؼ�</TH>
          </TR> 
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            <?php
 echo $this->_html('options',$this->ftpl_var['html_name_o'],$this->ftpl_var['o_data'],$this->ftpl_var['o_checked']);
?>	
            	 	<FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>     
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            	 <input type=text name="title" size=40> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>                
          <TR> 
            <TD class=tablerow>��վ��ַ</TD>
            <TD class=tablerow>
            	 <input type=text name="weburl" size=40 value="http://"> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>
          <TR> 
            <TD class=tablerow>�Ƿ���</TD>
            <TD class=tablerow>
            	<?php
 echo $this->_html('radios',$this->ftpl_var['html_name_r'],$this->ftpl_var['r_data'],$this->ftpl_var['r_checked'],'');
?>
            	  <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>          
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            	 <input type=text name="note" size=40> 
            	</TD>
          </TR>                                   
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
              	<input type="hidden" name=do value=1>
                <input type="submit" name="Submit" value=" ��� " > 
                &nbsp; <input type="reset" name="Submit1" value=" �� �� "> (��*�ű���)</TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>  
  <?php
}
elseif($this->ftpl_var['action']=="edit"){
?>
  <tr> 
 <td  height="24"><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �����ַ </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=editfavorite&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
        <TBODY>
          <TR> 
            <TH colSpan=2>�����ַ���ղؼ�</TH>
          </TR> 
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            <?php
 echo $this->_html('options',$this->ftpl_var['html_name_o'],$this->ftpl_var['o_data'],$this->ftpl_var['o_checked']);
?>
            	 	<FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>     
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            	 <input type=text name="title" size=40 value=<?php echo $this->ftpl_var['title'];?>> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>                
          <TR> 
            <TD class=tablerow>��վ��ַ</TD>
            <TD class=tablerow>
            	 <input type=text name="weburl" size=40 value="<?php echo $this->ftpl_var['weburl'];?>"> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>
          <TR> 
            <TD class=tablerow>�Ƿ���</TD>
            <TD class=tablerow>
            	 <?php
 echo $this->_html('radios',$this->ftpl_var['html_name_r'],$this->ftpl_var['r_data'],$this->ftpl_var['r_checked'],'');
?>
            	  <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>          
          <TR> 
            <TD class=tablerow>��վ����</TD>
            <TD class=tablerow>
            	 <input type=text name="note" size=40 value="<?php echo $this->ftpl_var['note'];?>"> 
            	</TD>
          </TR>                                   
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
              	<input type="hidden" name=id value=<?php echo $this->ftpl_var['id'];?>>
                <input type="submit" name="Submit" value=" �� �� " > 
                &nbsp; <input type="reset" name="Submit1" value=" �� �� "> (��*�ű���)</TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=="list"){
?>
   <tr> 
 <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �༭��ַ</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>����</td>
        <td width="20%"  valign="middle" align=center class=tr_head>��վ����</td>
        <td width="30%"  valign="middle" align=center class=tr_head>��ַ</td>
        <td width="12%"  valign="middle" align=center class=tr_head>�Ƿ���</td>
        <td width="30%"  valign="middle" align=center class=tr_head>����</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
         <tr>
   <td height=24 align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['typename'];?></td>
   <td  align=center valign=middle class=td1><a href=<?php echo $this->ftpl_var['cont']['weburl'];?> target=_blank title=<?php echo $this->ftpl_var['cont']['note'];?>><?php echo $this->ftpl_var['cont']['title'];?></a></td>
   <td  align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['weburl'];?></td>
   <td  align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['isshare'];?></td>
   <td  align=center valign=middle class=td1> <a href='?filename=favorite&id=<?php echo $this->ftpl_var['cont']['id'];?>&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&action=edit'>�༭</a> | <a href='?filename=favorite&id=<?php echo $this->ftpl_var['cont']['id'];?>&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&action=del'>ɾ��</a> </td>
   </tr>
      <?php
}
		unset($_form);
		
} ?>	  
     </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=="private"){
?>
   <tr> 
     <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �ҵ��ղؼ�</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=tr_head>�� �� �� �� ��</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" > 
            <tr>
            	<td width=10% align=center valign=middle height=24><font color=blue><b>����:</font></td>
            	<td width=90% align=left valign=middle  >
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=1">����</a> | 
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=2">Ӱ��</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=3">���</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=4">����</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=5">����</a> |
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=6">��ѧ</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=7">����</a> |
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=8">��ѧ</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=9">����</a> |
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=10">����</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=11">����</a> |
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=12">�ͼ�</a> |  
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=13">����</a> |
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=14">����</a>  |         		
            		<a href="?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=0">����</a>  
            		</td>
            </tr>
            <tr>
            	<td width=100% height=1 colspan=2 bgcolor=green> </td>
            </tr>
            <tr>
              <td width="100%"  valign="middle" align=center colspan=2>
        	      <table width="100%" border="0" cellpadding="1" cellspacing="0" >
                   <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
                  <tr>
                   <td width=10% height=28 align=center valign=middle class=td1>
                   	  [<a href=?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&tid=<?php echo $this->ftpl_var['cont']['tid'];?>><?php echo $this->ftpl_var['cont']['typename'];?></a>]</td>
                   <td  align=left valign=middle class=td1>
                   	  <a href='<?php echo $this->ftpl_var['cont']['weburl'];?>' target=_blank><?php echo $this->ftpl_var['cont']['title'];?></a> ��<?php echo $this->ftpl_var['cont']['note'];?>��--<?php echo $this->ftpl_var['cont']['sharename'];?></td>
                  </tr>
                  <?php
}
		unset($_form);
		
} ?>	
                </table>
              </td>
             </tr>
             <tr align="center" valign="middle">
               <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
             </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=="public"){
?>
  <tr> 
     <td  height="24" ><strong>��ǰλ�� >> <?php echo $this->ftpl_var['now_typename'];?> >> �����ղؼ�</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=tr_head>�����á�����ַ</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
            <tr>
            	<td width=5% align=center valign=middle height=28><font color=red><b>����:</font></td>
            	<td width=45% align=left valign=middle height=28>
            		<a href=http://www.yahoo.com.cn target=_blank>�Ż��й�</a> | 
            		<a href=http://www.sina.com target=_blank>����</a> | 
            		<a href=http://www.sohu.com target=_blank>�Ѻ�</a> | 
            		<a href=http://www.163.com target=_blank>����</a> | 
            		<a href=http://www.tom.com target=_blank>TOM��</a> |  
            		<a href=http://www.qq.com target=_blank>��ѶQQ</a>
            		</td>
            <td width=5% align=center valign=middle height=28><font color=red><b>����:</font></td>
            	<td width=45% align=left valign=middle height=28>
            		<a href=http://www.google.cn target=_blank>�ȸ�</a> | 
            		<a href=http://www.baidu.com target=_blank>�ٶ�</a> | 
            		<a href=http://www.yisou.com/ target=_blank>����</a>  
            		</td>
            </tr>
            <tr>
            	<td width=5% align=center valign=middle height=24><font color=green><b>���:</font></td>
            	<td width=45% align=left valign=middle >
            		<a href=http://www.newhua.com target=_blank>����</a> | 
            		<a href=http://www.greendown.cn target=_blank>��ɫ����վ</a> | 
            		<a href=http://www.crsky.com/ target=_blank>����</a> |  
            		<a href=http://www.xdowns.com/ target=_blank>��ɫ�������</a> |  
            		<a href=http://www.onegreen.net/ target=_blank>��ɫ���վ</a>
            		</td>
            <td width=5% align=center valign=middle height=24><font color=red><b>����:</font></td>
            	<td width=45% align=left valign=middle >
            		<a href=http://www.mtv123.com/ target=_blank>����������</a> | 
            		<a href=http://www.kugoo.com/ target=_blank>kugoo</a> | 
            		<a href=http://www.1ting.com/ target=_blank>һ��������</a> | 
            		<a href=http://www.haoting.com/ target=_blank>����������</a>
            		</td>
            </tr>
            <tr>
            	<td width=100% height=1 colspan=4 bgcolor=green> </td>
            </tr>
            <tr>
            	<td width=5% align=center valign=middle height=24><font color=blue><b>����:</font></td>
            	<td width=45% align=left valign=middle colspan=3 >

            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=1">����</a> | 
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=2">Ӱ��</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=3">���</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=4">����</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=5">����</a> |
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=6">��ѧ</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=7">����</a> |
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=8">��ѧ</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=9">����</a> |
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=10">����</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=11">����</a> |
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=12">�ͼ�</a> |  
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=13">����</a> |
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=14">����</a>  |         		
            		<a href="?filename=favorite&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>&tid=0">����</a>  
            		</td>
            </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td  valign="top"> 
    <TABLE cellPadding=0  cellSpacing=0  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=left height=32 class=tr_head2>��ǰ����-><?php echo $this->ftpl_var['tname'];?> (<?php echo $this->ftpl_var['pagenav'];?>)</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="1" cellspacing="0" >
             <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
                  <tr>
                   <td width=10% height=28 align=center valign=middle class=td1>
                   	  [<a href=?filename=favorite&action=private&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&tid=<?php echo $this->ftpl_var['cont']['tid'];?>><?php echo $this->ftpl_var['cont']['typename'];?></a>]</td>
                   <td  align=left valign=middle class=td1>
                   	  <a href='<?php echo $this->ftpl_var['cont']['weburl'];?>' target=_blank><?php echo $this->ftpl_var['cont']['title'];?></a> ��<?php echo $this->ftpl_var['cont']['note'];?>��--<?php echo $this->ftpl_var['cont']['sharename'];?></td>
                  </tr>
                  <?php
}
		unset($_form);
		
} ?>	
          </table>
        </td>
      </tr>
     </table>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
?>
</table>
</body>
</html>