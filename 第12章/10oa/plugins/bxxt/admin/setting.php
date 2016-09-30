<?php
/*
凤鸣山中小学校网络办公室
*/
/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //获取登入人员信息
	        $query="select userid,username,realname,groupid from members where userid=$user_id";
          $r=$db->query_first($query);
          $username=$r[username];
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$adminrepair=1;}
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：[$username]  <a href=\"?filename=index\" >首 页</a> | <a href=\"#\" onclick=popUp('repair','0')>申请报修</a>  | <a href=\"?filename=list\" >我的报修</a> | <a href=\"?filename=admin\">管 理</a> | <a href=\"?filename=login&action=logout\">退出系统</a>
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"100%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" /><a href=\"?filename=index\" >首 页</a> | 
                                    帐号：<input type=\"text\" name=\"username\" size=\"10\"/>
                                    密码：<input type=\"password\" name=\"password\" size=\"10\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"点击登入\" /> 
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };

switch($action){	
case 'class'://多功能教室的管理
$setting_title="教室管理 (<a href=# onclick=popUp('classadd','0')> 添加记录 </a>)";
$setting_content="
             <table border='0' cellspacing='2' cellpadding='1' width='100%'  align=center>
					  <tbody id=classlist>
						<tr align=center valign=middle>
							<td width='10%' class=tr_head>编 号</td>
							<td width='20%' class=tr_head>名 称</td>
							<td width='20%' class=tr_head>地 址</td>
							<td width='20%' class=tr_head>操 作</td>
					  </tr>
					  </tbody>
                 ";
//页码设置开始
 $sql = "SELECT count(*) FROM $table_class";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=setting&action=class");      
 //页码设置结束                 
//记录数据的读取
$class_style="td1";
$query="select * from $table_class  order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $setting_content.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center class=$class_style height=24>$r[id]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style>$r[address]</td>
				            <td align=center class=$class_style><a href=\"#\" onclick=popUp('classedit','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('classdel','$r[id]')>删除</a></td>				           </tr>     
		               ";        	
		   if ($class_style=="td1") $class_style="td2";else $class_style="td1";            
      } 
$setting_content.="</table>";  
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
    props=window.open('?filename=setting&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
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
            <td width="100%" height="32" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setvar">参数设置</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=class">教室管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=grade">班级管理</a></td>
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
          <td  height="254" valign=top>
          <table width="100%"  border="0" cellpadding="2" cellspacing="0" >
            <tr>
             <td height="28" class=bg><strong>　当前位置：<?=$setting_title;?></strong></td>
              </tr>
          </table>
          <?=$setting_content;?>	
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
      <TD align=middle height=24></td>
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
<?					                           
break;
case 'grade'://学校班级的管理
$setting_title="班级管理 (<a href=# onclick=popUp('gradeadd','0')> 添加记录 </a>)";
$setting_content="
             <table border='0' cellspacing='2' cellpadding='1' width='100%' id=todayorder align=center>
						<tbody id=classlist>
						<tr align=center valign=middle>
							<td width='10%' class=tr_head>序列号</td>
							<td width='20%' class=tr_head>编 号</td>
							<td width='30%' class=tr_head>名 称</td>
							<td width='30%' class=tr_head>操 作</td>
					  </tr>
					  </tbody>
					  <tbody id=todayorder1>
                 ";
//页码设置开始
 $sql = "SELECT count(*) FROM $table_setting where `type`='g'";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=setting&action=grade");      
 //页码设置结束                 
//记录数据的读取
$class_style="td1";
$query="select * from $table_setting where type='g'  order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
$i=1;
while($r=$db->fetch_array($result)){
      $setting_content.="
			             <tr id=list$r[id] valign=middle>
			             	<td align=center class=$class_style height=24>$i</td>
			              <td align=center class=$class_style>$r[other]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style><a href=\"#\" onclick=popUp('gradeedit','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('gradedel','$r[id]')>删除</a></td>				           </tr>     
		               ";  
		               $i++;      	
		   if ($class_style=="td1") $class_style="td2";else $class_style="td1";            
      } 
$setting_content.=" </tbody>
					         </table>
					       ";
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
    props=window.open('?filename=setting&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
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
            <td width="100%" height="32" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setvar">参数设置</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=class">教室管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell--><a href="?filename=setting&action=grade">班级管理</a></td>
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
          <td  height="254" valign=top>
          <table width="100%"  border="0" cellpadding="2" cellspacing="0" >
            <tr>
             <td height="28" class=bg><strong>　当前位置：<?=$setting_title;?></strong></td>
              </tr>
          </table>
          <?=$setting_content;?>	
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
      <TD align=middle height=24></td>
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
<?					           
break;	
case 'classadd':
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=classadd">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    多功能预定系统教室设置</strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	名 称：<input type="text" name="name" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	地 址：<input type="text" name="address" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
     </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'classedit':
//记录数据的读取
$query="select * from $table_class  where id=$id";
$r=$db->query_first($query);
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=classedit&id=<?=$r[id];?>">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    多功能预定系统教室设置</strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	名 称：<input type="text" name="name" value="<?=$r[name];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	地 址：<input type="text" name="address" value="<?=$r[address];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
     </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'classdel':
//记录数据的读取
$query="select * from $table_class  where id=$id";
$r=$db->query_first($query);
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=classdel">
  <tr>
    <td height="160" valign="middle" align=center>
    	真的要删除<font color=red>{<?=$r[name];?>}</font>多功能教室的信息 <p>
    	<input type=hidden name=id value=<?=$id;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
      <p>教育资源网版权所有 不凡
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'gradeadd':
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=gradeadd">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    多功能预定系统[班级设置]</strong>
    </td>
  </tr>
    <tr>
    <td height="28" valign="middle" align=center><strong>
    	编 号：<input type="text" name="other" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	名 称：<input type="text" name="name" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
     </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'gradeedit':
//记录数据的读取
$query="select * from $table_setting  where id=$id and `type`='g'";
$r=$db->query_first($query);
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=gradeedit&id=<?=$r[id];?>">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    多功能预定系统[班级设置]</strong>
    </td>
  </tr>
    <tr>
    <td height="28" valign="middle" align=center><strong>
    	编 号：<input type="text" name="other" value="<?=$r[other];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center><strong>
    	名 称：<input type="text" name="name" value="<?=$r[name];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
     </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'gradedel':
//记录数据的读取
$query="select * from $table_setting where id=$id and `type`='g'";
$r=$db->query_first($query);
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=gradedel">
  <tr>
    <td height="160" valign="middle" align=center>
    	真的要删除<font color=red>{<?=$r[name];?>}</font>多功能教室的信息 <p>
    	<input type=hidden name=id value=<?=$id;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
      <p>教育资源网版权所有 不凡
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
}                    
?>


