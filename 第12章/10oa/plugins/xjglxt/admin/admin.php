<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
if ($group_id!=1){
$referer="?filename=index";
showmessage("�Բ�����û��Ȩ��",$referer);}
/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //��ȡ������Ա��Ϣ
	        $query="select userid,username,realname,groupid from members where userid=$user_id and groupid<4 limit 1";
          $r=$db->query_first($query);
          $username=$r[username];
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$admining=1;
          	                            $product=" | <a href=\"?filename=product\" >��Ʒ���</a> | <a href=\"?filename=admin\">�� ��</a>";
          	                          } else {$admining=0;}
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          ��ǰ�û���[$username]  <a href=\"?filename=index\" >�� ҳ</a> | <a href=\"?filename=inform\" >��Ʒ��Ϣ��</a>  | <a href=\"?filename=list\">��ǹ���</a> | <a href=\"?filename=list&action=my\">�ҵĽ��</a>  $product | <a href=\"?filename=login&action=logout\">�˳�ϵͳ</a>
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"100%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" /><a href=\"?filename=index\" >�� ҳ</a> | 
                                    �ʺţ�<input type=\"text\" name=\"username\" size=\"10\"/>
                                    ���룺<input type=\"password\" name=\"password\" size=\"10\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"�������\" /> 
                                     | <a href=\"?filename=inform\" >��Ʒ��Ϣ��</a>  | <a href=\"?filename=list\">��ǹ���</a>
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };         
?>
<SCRIPT LANGUAGE="JavaScript">

</script>
<body>
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
            ��������	
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
            <td width="100%" height="32" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setvar">��������</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=type">�������</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=subject">ѧ�ƹ���</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=grade">�꼶����</a></td>
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
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder_2>
      <!--DWLayoutTable-->
        <tr>
          <td  height="254">&nbsp;</td>
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
      <TD align=middle height=24>�����ʼ� ����֧��</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table>   
    </td>
  </tr>
</table>    
</body>

