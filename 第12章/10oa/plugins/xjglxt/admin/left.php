<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
?>
</script>
<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<body>
<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF">
    
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center><a href="?filename=main" target="right">��ҳ</a>|<a href="javascript:showset('setid')">����</a>|<a href="javascript:showset('conid')">����</a>|<a href="?filename=login&action=logout" target="_top">�˳�</a></td>
      </tr>
      

  
   
      <tr>
      <td>      
       <table width="100%"  border="0" cellspacing="0" cellpadding="4"> 
       <tbody style="display:block" id="conid">
       	          <tr>
          <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>�༶����</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
              	<tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=add" target="right">�����༶</a></td>
             </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=list" target="right">�༶�б�</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=adminlist" target="right">����������</a></td>
                  </tr>
                 
        </tbody>
        </table>
        </td>
      </tr> 
            <tr>
              <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('articleid')"><font color=#ffffff>ѧ������</font></a></td>
                  </tr>
              <TBODY style="display:block" id="articleid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=student&action=up" target="right">ѧ���ϴ�</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=student&action=list" target="right">ѧ���б�</a></td>
                  </tr>
                  
             </tbody>
              </table>
             </td>
            </tr> 
           
        
       <tr>
            <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>�ɼ�����</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=result&action=up" target="right">�ɼ��ϴ�</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=result&action=list" target="right">�ɼ��б�</a></td>
              </tr>
        </tbody>
        </table>
        </td>
      </tr>
       
   
          <tr>
            <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>��Ϣ�������</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=new" target="right">��Ϣ���淢��</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=list" target="right">������Ϣ�б�</a></td>
                 </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=listup" target="right">�ϼ�����鿴</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=listst" target="right">ѧ����Ϣ�鿴</a></td>
                 </tr> 
        </tbody>
        </table>
        </td>
      </tr>
       
    </table></td>
  </tr>
</table>
</body>
</html>