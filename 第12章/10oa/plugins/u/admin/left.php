<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
?>
<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<body>

    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center height=30>������ѧ����U��ϵͳ</td>
      </tr>
  <tr>
        <td>
          <table width="100%"  border="0" cellspacing="0" cellpadding="4"> 
           <tbody id="setid">
            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" class=tableborder>
                   <tr>
                    <td height="22" colspan=2 class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><font color="#ffffff">�û���Ϣ</font></td>
                   </tr>
                   <tbody>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">��¼�ʺţ�</td><td height="22" bgcolor="#FFFFFF"><?=$user_name;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">�û����ƣ�</td><td height="22" bgcolor="#FFFFFF"><?=$real_name;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">�û����</td><td height="22" bgcolor="#FFFFFF"><?=$group_title;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">����������</td><td height="22" bgcolor="#FFFFFF"><?=$u_size;?>M</td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">�����ļ���</td><td height="22" bgcolor="#FFFFFF">30M</td>
                   </tr>
                   </tbody>
               </table>
             </td>
           </tr>
          </tbody>
      </table>
    </td>
  </tr>
      <tr>
        <td>
          <table width="100%"  border="0" cellspacing="0" cellpadding="4"> 
           <tbody id="setid">
            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" class=tableborder>
                   <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><font color="#ffffff">��������</font></td>
                   </tr>
                   <tbody>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=setvar&action=setvar" target="right">ϵͳ��Ϣ</a></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=setvar&action=setindex" target="right">��ҳ����</a></td>
                   </tr>
                   </tbody>
               </table>
             </td>
           </tr>
          </tbody>
      </table>
    </td>
  </tr>
</body>
</table>

</html>