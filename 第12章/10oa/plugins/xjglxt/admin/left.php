<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
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
        <td align=center><a href="?filename=main" target="right">首页</a>|<a href="javascript:showset('setid')">设置</a>|<a href="javascript:showset('conid')">管理</a>|<a href="?filename=login&action=logout" target="_top">退出</a></td>
      </tr>
      

  
   
      <tr>
      <td>      
       <table width="100%"  border="0" cellspacing="0" cellpadding="4"> 
       <tbody style="display:block" id="conid">
       	          <tr>
          <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>班级管理</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
              	<tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=add" target="right">建立班级</a></td>
             </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=list" target="right">班级列表</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=class&action=adminlist" target="right">班主任设置</a></td>
                  </tr>
                 
        </tbody>
        </table>
        </td>
      </tr> 
            <tr>
              <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('articleid')"><font color=#ffffff>学生管理</font></a></td>
                  </tr>
              <TBODY style="display:block" id="articleid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=student&action=up" target="right">学生上传</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=student&action=list" target="right">学生列表</a></td>
                  </tr>
                  
             </tbody>
              </table>
             </td>
            </tr> 
           
        
       <tr>
            <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>成绩管理</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=result&action=up" target="right">成绩上传</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=result&action=list" target="right">成绩列表</a></td>
              </tr>
        </tbody>
        </table>
        </td>
      </tr>
       
   
          <tr>
            <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
                  <tr>
                    <td height="22" class="tablepic"><img src="<?=$rootpath?>/templates/<?=$style?>/images/minus.gif" width="20" height="9"><a href="javascript:show('classid')"><font color=#ffffff>信息公告管理</font></a></td>
                  </tr>
              <TBODY style="display:block" id="classid">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=new" target="right">信息公告发布</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=list" target="right">所发信息列表</a></td>
                 </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=listup" target="right">上级公告查看</a></td>
                  </tr>
                 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?filename=message&action=listst" target="right">学生信息查看</a></td>
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