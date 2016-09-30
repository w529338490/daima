<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

		$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
		$serverinfo .= @ini_get('safe_mode') ? ' 安全模式' : NULL;
		$dbversions=$db->query_first("SELECT VERSION()");
		$dbversion=$dbversions[0];

		if(@ini_get("file_uploads")) {
			$fileupload = "允许 - 文件 ".ini_get("upload_max_filesize")." - 表单：".ini_get("post_max_size");
		} else {
			$fileupload = "<font color=\"red\">禁止</font>";
		}

		$dbsize = 0;
		$query = $db->query("SHOW TABLE STATUS LIKE '$tablepre%'", 1);
		while($table = $db->fetch_array($query)) {
			$dbsize += $table[Data_length] + $table[Index_length];
		}
		$dbsize = $dbsize ? sizecount($dbsize) : "未知";

		$attachsize = dirsize("./upfiles");
		$attachsize = $attachsize ? sizecount($attachsize) : "未知";
		
 	 $attachpicsize = dirsize("./uppics");
		$attachpicsize = $attachpicsize ? sizecount($attachpicsize) : "未知";

?>
<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
    <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD valign=middle align=center bgcolor="#4466cc" class=submenu><b>欢迎光临 <a href="http://www.nbcjzx.com" target="_blank">slcms 1.3</a> 系统设置面板</b></TD>
          </TR>
          <TR> 
            <TD class=tablerow align=center valign=middle>版权所有&copy;数字校园（www.nbcjzx.com）, 2006. 
      </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr> 
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable-->  
        <TBODY>
            <TR> 
            <TH colSpan=2>系 统 信 息</TH>
          </TR>
<tr bgcolor="#F8F8F8"><td width="50%">服务器环境</td><td><?=$serverinfo?></td></tr>
<tr bgcolor="#F8F8F8"><td>MySQL 版本</td><td><?=$dbversion?></td></tr>
<tr bgcolor="#F8F8F8"><td>附件上传许可</td><td><?=$fileupload?></td></tr>
<tr bgcolor="#F8F8F8"><td>数据库占用</td><td><?=$dbsize?></td></tr>
<tr bgcolor="#F8F8F8"><td>附件文件占用</td><td><?=$attachsize?></td></tr>
<tr bgcolor="#F8F8F8"><td>图片文件占用</td><td><?=$attachpicsize?></td></tr>
        </tbody>
     </table>
    </td> 
    </tr>  
	  <tr> 
      <td  height="24"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr> 
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable-->  
        <TBODY>
            <TR> 
            <TH colSpan=2>开 发 团 队</TH>
          </TR>
<tr bgcolor="#F8F8F8"><td width="50%">版权所有</td><td><a href="http://www.nbcjzx.com" target="_blank">数字校园（www.nbcjzx.com）</a></td></tr>
<tr bgcolor="#F8F8F8"><td>项目经理</td><td>不凡</td></tr>
<tr bgcolor="#F8F8F8"><td>开发团队</td><td>不凡</td></tr>
<tr bgcolor="#F8F8F8"><td>插件开发</td><td>不凡</td></tr>
<tr bgcolor="#F8F8F8"><td>界面设计</td><td>不凡</td></tr>
<tr bgcolor="#F8F8F8"><td>友情支持</td><td>暂无</td></tr>
<tr bgcolor="#F8F8F8"><td>官方网站</td><td><a href="http://www.nbcjzx.com" target="_blank">http://www.nbcjzx.com</a></td></tr>
<tr bgcolor="#F8F8F8"><td>官方论坛</td><td><a href="http://bbs.nbcjzx.com" target="_blank">http://bbs.nbcjzx.com</a></td></tr>
        </tbody>
     </table>
    </td> 
    </tr> 
</table>
</body>