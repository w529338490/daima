<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
?>
<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<body>

    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center height=30>长江中学网络U盘系统</td>
      </tr>
  <tr>
        <td>
          <table width="100%"  border="0" cellspacing="0" cellpadding="4"> 
           <tbody id="setid">
            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" class=tableborder>
                   <tr>
                    <td height="22" colspan=2 class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><font color="#ffffff">用户信息</font></td>
                   </tr>
                   <tbody>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">登录帐号：</td><td height="22" bgcolor="#FFFFFF"><?=$user_name;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">用户名称：</td><td height="22" bgcolor="#FFFFFF"><?=$real_name;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">用户组别：</td><td height="22" bgcolor="#FFFFFF"><?=$group_title;?></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">Ｕ盘容量：</td><td height="22" bgcolor="#FFFFFF"><?=$u_size;?>M</td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF">单个文件：</td><td height="22" bgcolor="#FFFFFF">30M</td>
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
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><font color="#ffffff">操作管理</font></td>
                   </tr>
                   <tbody>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=setvar&action=setvar" target="right">系统信息</a></td>
                   </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=setvar&action=setindex" target="right">首页设置</a></td>
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