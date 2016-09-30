<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   多功能教室登记系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

if (isset($user_name)){
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：$user_name  <a href=\"?filename=index\" >首 页</a> | <a href=\"#\" onclick=popUp('order','0')>预 订</a> | <a href=\"#today\" >今日预约</a> | <a href=\"?filename=list\" >我的预约</a> | <a href=\"?filename=admin\">管 理</a> | <a href=\"?filename=login&action=logout\">退出系统</a>
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" />
                                    帐号：<input type=\"text\" name=\"username\" size=\"15\"/>
                                    密码：<input type=\"password\" name=\"password\" size=\"15\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"点击登入\" />
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };
?>
<body topmargin="0" leftmargin="0" rightMargin="0">
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
            管理设置	
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
            <td width="100%" height="32" valign="middle" align=center><a href="?filename=setvar">参数设置</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=type">分类管理</a></td>
            </tr>
          <tr> 
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=class">教室管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=grade">班级管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell-->&nbsp;</td>
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
          <td  height="254">
<table width="100%"  border="0" cellpadding="2" cellspacing="0" >
  <tr>
    <td height="28" class=bg><strong>　当前位置：参数设置</strong></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
  <form name="form1" method="post" action="?filename=deal&action=setvar">
    <tr bgcolor="#F5F5F5"> 
      <td width="15%" align="right">网站名称：</td>
      <td width="85%"><input name="newsitename" type="text" size="30" value="<?=$sitename?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">网站地址：</td>
      <td ><input name="newsiteurl" type="text" size="30" value="<?=$siteurl?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">站长姓名：</td>
      <td ><input name="newsitemaster" type="text" size="15" value="<?=$sitemaster?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站主题：</td>
      <td><input name="newsitetitle" type="text" size="40" value="<?=$sitetitle?>"><br>（将作为网站标题栏后缀，正确设置有利于在搜索引擎上靠前）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站介绍：</td>
      <td><input name="newsitedescription" type="text" size="50" value="<?=$sitedescription?>"><br>（不显示，正确设置有利于在搜索引擎上靠前）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站关键词：</td>
      <td><input name="newsitekeywords" type="text" size="50" value="<?=$sitekeywords?>"><br>(多个关键词请用半角逗号“,”隔开，有利于在搜索引擎上靠前)</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td width="25%" align="right">根目录网址：</td>
      <td width="75%"><input name="newrootpath" type="text" size="50" value="<?=$rootpath?>"><br>（本系统根目录访问网址，后面不要加“/”）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td width="25%" align="right">网站风格：</td>
      <td width="75%">
<select name="newstyle">
<?php
$dir=opendir("./templates");
while($templatedir=readdir($dir)){
if(is_dir("./templates/".$templatedir) && $templatedir!='.' && $templatedir!='..'){
if($templatedir==$style)
echo "<option value='$templatedir' selected>$templatedir</option>";
else
echo "<option value='$templatedir'>$templatedir</option>";
}
}
?>
</select>
</td>
</tr>
<tr bgcolor="#F5F5F5"> 
    <td width="25%" align="right">是否允许投稿：</td>
      <td width="75%"><input type="radio" name="newcontribute" value="1" <?php if($contribute)echo 'checked';?>>是 <input type="radio" name="newcontribute" value="0" <?php if(!$contribute)echo 'checked';?>>否</td>
    </tr>
<tr bgcolor="#F5F5F5"> 
 <td width="25%" align="right">每页数据数：</td>
  <td width="75%"><input name="newperpage" type="text" size="10" value="<?=$perpage?>"></td>
</tr>
 <tr bgcolor="#F5F5F5"> 
      <td></td>
      <td height="30"> <input type="submit" name="Submit" value=" 确 定 "> 
        &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </td>
    </tr>
  </form>
</table>       	          	
          	</td>
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
      <TD align=middle height=24>
ban      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>开发笔记 技术支持</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table>   
    </td>
  </tr>
</table>    
</body>
