<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>学校网络办公系统2009 v2.2.0</title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
<!--DWLayoutTable-->
 <tr>
  <td  valign="top">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>

  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>
     <?php
if($this->ftpl_var['action']=='setvar'){
?>
<table width="100%"  border="0" cellpadding="2" cellspacing="0" >
  <tr>
    <td height="28" class=main_title><strong>　当前位置：系统参数设置</strong></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
  <form name="form1" method="post" action="?filename=deal&action=setvar">
    <tr bgcolor="#F5F5F5"> 
      <td width="15%" align="right">网站名称：</td>
      <td width="85%"><input name="newsitename" type="text" size="30" value="<?php echo $this->ftpl_var['sitename'];?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">网站地址：</td>
      <td ><input name="newsiteurl" type="text" size="30" value="<?php echo $this->ftpl_var['siteurl'];?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">站长姓名：</td>
      <td ><input name="newsitemaster" type="text" size="15" value="<?php echo $this->ftpl_var['sitemaster'];?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站主题：</td>
      <td><input name="newsitetitle" type="text" size="40" value="<?php echo $this->ftpl_var['sitetitle'];?>" readonly><font color=red>只读</font>（将作为网站标题栏后缀，有利于在搜索引擎上靠前）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站介绍：</td>
      <td><input name="newsitedescription" type="text" size="50" value="<?php echo $this->ftpl_var['sitedescription'];?>">（不显示，有利于在搜索引擎上靠前）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站关键词：</td>
      <td><input name="newsitekeywords" type="text" size="50" value="<?php echo $this->ftpl_var['sitekeywords'];?>">(多关键词用半角逗号“,”隔开，有利于在搜索引擎上靠前)</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">根目录网址：</td>
      <td ><input name="newrootpath" type="text" size="50" value="<?php echo $this->ftpl_var['rootpath'];?>">（本系统根目录访问网址，后面不要加“/”）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">网站风格：</td>
      <td>
      <select name="newstyle">
      <?php echo $this->ftpl_var['newstyle'];?>
      </select>
      </td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">学校名称：</td>
      <td ><input name="newschool_name" type="text" size="15" value="<?php echo $this->ftpl_var['school_name'];?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">学校类型：</td>
      <td><input name="newschool_type" type="text" size="15" value="<?php echo $this->ftpl_var['school_type'];?>">（学校类型1：小学版；2：中学版；12：九年一贯制学校；3：高中版）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">注册邀请码：</td>
      <td><input name="newregister_key" type="text" size="15" value="<?php echo $this->ftpl_var['register_key'];?>">（注册时需要输入的代码）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">文件上传目录：</td>
      <td><input name="newuppath" type="text" size="15" value="<?php echo $this->ftpl_var['uppath'];?>">(后面加上/)</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">文件上传类型：</td>
      <td ><input name="newuptypes" type="text" size="50" value="<?php echo $this->ftpl_var['uptypes'];?>">（允许上传的文件类型用“|”分隔如：zip|rar）</td>
    </tr>
        <tr bgcolor="#F5F5F5"> 
      <td  align="right">文件上传最大限制：</td>
      <td ><input name="newmax_file_size" type="text" size="10" value="<?php echo $this->ftpl_var['max_file_size'];?>">（单位为B）</td>
    </tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">每页数据数：</td>
  <td ><input name="newperpage" type="text" size="10" value="<?php echo $this->ftpl_var['perpage'];?>"></td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">页面浏览数：</td>
  <td ><input name="newpagenavpages" type="text" size="10" value="<?php echo $this->ftpl_var['pagenavpages'];?>"></td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">标题文字显示数：</td>
  <td ><input name="newstrnum" type="text" size="10" value="<?php echo $this->ftpl_var['strnum'];?>">(一个中文字符相当于两个英文字符，此处为英文字符数)</td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">是否显示执行时间：</td>
  <td ><input name="newshowtime" type="text" size="10" value="<?php echo $this->ftpl_var['showtime'];?>">(0为不显示；1为显示)</td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">是否强制更新：</td>
  <td ><input name="newforce_html" type="text" size="10" value="<?php echo $this->ftpl_var['force_html'];?>">(false为不强制；true为强制)</td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">FTP_ip：</td>
  <td ><input name="newftp_ip" type="text" size="10" value="<?php echo $this->ftpl_var['ftp_ip'];?>">(192.168.0.1)</td>
</tr>
<tr bgcolor="#F5F5F5"> 
 <td  align="right">FTP_port：</td>
  <td ><input name="newport" type="text" size="10" value="<?php echo $this->ftpl_var['port'];?>">(21)</td>
</tr>
 <tr bgcolor="#F5F5F5"> 
      <td></td>
      <td height="30"> <input type="submit" name="Submit" value=" 确 定 "> 
        </td>
    </tr>
  </form>
</table>       	          	
<?php
}
elseif($this->ftpl_var['action']=='setindex'){
?>
<table width="100%"  border="0" cellpadding="2" cellspacing="0" >
  <tr>
    <td height="28" class=main_title><strong>　当前位置：系统参数设置</strong></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
  <form name="form1" method="post" action="?filename=deal&action=setindex">
    <tr bgcolor="#F5F5F5"> 
      <td width="15%" align="right">栏目提示：</td>
      <td width="85%"><select name=type_id>
      <?php echo $this->ftpl_var['type_select'];?></select>
      </td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">首页输出：</td>
      <td ><input name="newouttypeids" type="text" size="20" value="<?php echo $this->ftpl_var['outtypeids'];?>">（用“,”分隔如：3,5）</td>
    </tr>
        <tr bgcolor="#F5F5F5"> 
      <td  align="right">课表学科设置：</td>
      <td >
      <textarea name="newclass_subject_arr" cols=50 rows=3><?php echo $this->ftpl_var['class_subject_arr'];?></textarea>
      （用“,”分隔如：3,5）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">文章短标题设置：</td>
      <td >
      <textarea name="newincludepic_arr" cols=50 rows=3><?php echo $this->ftpl_var['includepic_arr'];?></textarea>
      （用“,”分隔如：,[紧急],[转告]最前面必须有一个","）</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td></td>
      <td height="30"> <input type="submit" name="Submit" value=" 确 定 "> 
        &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </td>
    </tr>
  </form>
</table>      

<?php
}
?>
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
      <TD align=middle height=24>
      	开发笔记 技术支持</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table>   
    </td>
  </tr>
</table>    
</body>
</html>
