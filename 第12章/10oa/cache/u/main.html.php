<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background:#F8F8F0;">
<?php
if($this->ftpl_var['action']=='new'){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
    <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD valign=middle align=center bgcolor="#4466cc" class=submenu></TD>
          </TR>
          <TR> 
            <TD class=tablerow align=center valign=middle>
      </TD>
          </TR>
        </TBODY>
      </TABLE>
      </td></tr>
<tr><td>
<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="500" id=ftable>
<tbody id=tbody1>
<TR>
	<td width="100%"><a href="?filename=deal&action=newdisk&user_name=<?php echo $this->ftpl_var['user_name'];?>&user_id=<?php echo $this->ftpl_var['user_id'];?>">点击这里开通网络U盘，你的U盘容量为<?php echo $this->ftpl_var['u_size'];?>M</a></td>
</TR>
</tbody>
</TABLE>  
</td>
</tr>
<tr> 
<td  valign="top"> 
</td> 
</tr> 
</table> 
<?php
}
elseif($this->ftpl_var['action']=='list'){
?>   
<script type="text/javascript" src="./include/ajax.js"></script>
<table width="760" border="0" cellpadding="0" cellspacing="0" align=center>
  <!--DWLayoutTable-->
  <tr> 
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->  
        <TBODY>
            <TR> 
            <Td height=24 valign=middle><b>你的网络U盘容量是<?php echo $this->ftpl_var['u_size'];?>M,已使用的容量：<?php echo $this->ftpl_var['dirsize'];?></b></Td>
          </TR>
        </tbody>
     </table>
    </td> 
 </tr>  
<tr>
<td>
<SCRIPT language=JavaScript> 
   var aID=0;
   function ShowTabs1(ID){
      if(ID!=aID){
                  Tabs1[aID].style.display="none";
                  Tabs1[ID].style.display="";
                  aID=ID;
                  }
   }
 function upfile(){
window.open("index.php?filename=swfupload&id=<?php echo $this->ftpl_var['id'];?>","newwindow","height=100, width=400, top=200, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}  
 function upsfile(){
window.open("index.php?filename=upload&id=<?php echo $this->ftpl_var['id'];?>","newwindow","height=100, width=400, top=200, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}  
</SCRIPT>
<table width="500" height="62" border="0" cellPadding=2 cellSpacing=1 class=tableborder>
       <!--DWLayoutTable-->
       <tr>         
          <td width="60" align="center" valign="middle" height="40"><a href=?filename=main&id=<?php echo $this->ftpl_var['uid'];?>><img src="./images/up.gif" alt="上一级" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60" align="center" valign="middle"><a href=?filename=main&id=0><img src="./images/home.gif" alt="根目录" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60" align="center" valign="middle"><a href="#" onclick=ShowTabs1(1);><img src="./images/new_folder.gif" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60"  align="center" valign="middle"><a href="#" onclick=upsfile()><img src="./images/upload.gif" alt="上传" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="70"  align="center" valign="middle"><a href="#" onclick=upfile()><img src="./images/upload.gif" alt="上传大文件" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60"  align="center" valign="middle"><a href="#" onclick=cut('fileall',0);><img src="./images/bcut.gif" alt="剪切" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60"  align="center" valign="middle"><a href="#" onclick=paste(<?php echo $this->ftpl_var['id'];?>,<?php echo $this->ftpl_var['layerid'];?>);><img src="./images/paste.gif" alt="粘贴" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="60"  align="center" valign="middle"><a href="#" onclick=bzip();><img src="./images/bzip.jpg" alt="打包下载" width="32" height="32" align="absmiddle" border=0 /></a></td>
          <td width="150" rowspan="2">
           </td>
       </tr>
       <tr>
         <td height="22" align="center" valign="middle" width="60">向上一级</td>
         <td align="center" valign="middle" width="60">根目录</td>
         <td align="center" valign="middle" width="60">新文件夹</td>
         <td align="center" valign="middle" width="60">上传文件</td>
         <td align="center" valign="middle" width="70"><font color=red><b>上传大文件</font></td>
         <td align="center" valign="middle" width="60">剪切</td>
         <td align="center" valign="middle" width="60">粘贴</td>
         <td align="center" valign="middle" width="60">打包下载</td>
       </tr>
     </table>
</td>
</tr>
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
             <!--DWLayoutTable-->
            <tbody style="display:block" id="Tabs1">
            <tr>
            <td height="20">
            <div id="msg"></div> 
            </td>
            </tr>
            </tbody>
             <tbody style="display:none" id="Tabs1">
             <tr>
              <form name="form1" method="post" action="">
              <td height="20" >文件夹名称:
              <input type=text name=foldername size=20 id=foldername>
              <input type=hidden name=id value=<?php echo $this->ftpl_var['id'];?>>
              <input type=hidden name=uid value=<?php echo $this->ftpl_var['uid'];?>>
              <input type=hidden name=layerid value=<?php echo $this->ftpl_var['layerid'];?>> 
              <input type=hidden name=cid>   
              <input type=button name=ww value=创建文件夹 onClick="creatfolder()">        
              </td> 
              </form>
            </tr>
            </tbody>
           </table>
</td>
</tr>
<tr> 
<td  height="24">
<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="500" id=ftable>

<TR>
	<td width="5%">选中</td>
	<TD width="40%">名称</TD>
  <TD width="10%">大小</TD>
  <TD width="30%">更新时间</TD>
	<TD width="20%">操作</TD>
</TR>
<tbody id=tbody1>
<?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?> 
<tr bgcolor="#F8F8F8" id=folder<?php echo $this->ftpl_var['cont']['cid'];?>>
	              <td><input type=checkbox name=checkfolder id=checkfolder value=<?php echo $this->ftpl_var['cont']['cid'];?> disabled></td>
	              <td><img src=./images/folder.gif border=0 alt=文件夹 align=absmiddle> <a href=?filename=main&uid=<?php echo $this->ftpl_var['cont']['id'];?>&id=<?php echo $this->ftpl_var['cont']['cid'];?>><?php echo $this->ftpl_var['cont']['foldername'];?></a></td>
	              <td>-</td>
	              <td><?php echo $this->ftpl_var['cont']['addtime'];?></td>
	              <td><a href=# onClick=del('ftable','folder<?php echo $this->ftpl_var['cont']['cid'];?>','folder',<?php echo $this->ftpl_var['cont']['cid'];?>)><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('folder',<?php echo $this->ftpl_var['cont']['cid'];?>)><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a> </td>
	             </tr>
<?php
}
		unset($_form);
		
} ?>
</tbody>
<FORM name=form3 METHOD=POST  action="" >
<input type=hidden name=checkLines>
<tbody id=tbody2>
<?php 
$_from = $this->ftpl_var['content2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid2'] => $this->ftpl_var['cont2']){
?> 
<tr bgcolor="#F8F8F8" id=file<?php echo $this->ftpl_var['cont2']['cid'];?>>
	            <td><input type=checkbox name=checkLine id=checkLine value=<?php echo $this->ftpl_var['cont2']['cid'];?>></td>
	            <td><img src=./images/<?php echo $this->ftpl_var['cont2']['extend'];?>.gif border=0  align=absmiddle alt='文件'> <a href=?filename=down&uid=<?php echo $this->ftpl_var['cont2']['id'];?>&id=<?php echo $this->ftpl_var['cont2']['cid'];?>><?php echo $this->ftpl_var['cont2']['filename'];?></a></td>
	            <td><?php echo $this->ftpl_var['cont2']['file_size'];?></td>
	            <td><?php echo $this->ftpl_var['cont2']['addtime'];?></td>
	            <td><a href=# onClick=del('ftable','file<?php echo $this->ftpl_var['cont2']['cid'];?>','file',<?php echo $this->ftpl_var['cont2']['cid'];?>)><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('file',<?php echo $this->ftpl_var['cont2']['cid'];?>)><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a> </td>
	           </tr>
<?php
}
		unset($_form);
		
} ?>
</tbody>
</form>
</TABLE>  
</td>
</tr>
<tr> 
<td  valign="top"> 
</td> 
</tr> 
</table>       
<iframe name='hidden_frame' id="hidden_frame"  style='display:none'></iframe>
<?php
}
?>   
</body>
</html>