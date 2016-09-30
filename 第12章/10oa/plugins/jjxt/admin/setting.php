<?php
/*
凤鸣山中小学网络办公室
*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //获取登入人员信息
	        $query="select userid,username,realname,groupid from members where userid=$user_id and groupid<4 limit 1";
          $r=$db->query_first($query);
          $username=$r[username];
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$admining=1;
          	                            $product=" | <a href=\"?filename=product\" >物品入库</a> | <a href=\"?filename=admin\">管 理</a>";
          	                          } else {$admining=0;}
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：[$real_name]  <a href=\"?filename=index\" >首 页</a> | <a href=\"?filename=inform\" >物品信息库</a>  | <a href=\"?filename=list\">借记管理</a> | <a href=\"?filename=list&action=my\">我的借记</a>  $product 
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
                                     | <a href=\"?filename=inform\" >物品信息库</a>  | <a href=\"?filename=list\">借记管理</a>
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };

switch($action){	
case 'type'://电教资料的分类管理
$setting_title="分类管理 (<a href=# onclick=popUp('typeadd','0')> 添加记录 </a>)";
$setting_content="
             <table border='0' cellspacing='2' cellpadding='1' width='100%'  align=center>
					  <tbody id=classlist>
						<tr align=center valign=middle>
							<td width='10%' class=tr_head>编 号</td>
							<td width='50%' class=tr_head>名 称</td>
							<td width='20%' class=tr_head>操 作</td>
					  </tr>
					  </tbody>
                 ";
//页码设置开始
 $sql = "SELECT count(*) FROM $table_type where `type`='t'";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=setting&action=type");      
 //页码设置结束                 
//记录数据的读取
$class_style="td1";
$query="select * from $table_type where  `type`='t'  order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $setting_content.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center class=$class_style height=24>$r[id]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style><a href=\"#\" onclick=popUp('typeedit','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('typedel','$r[id]')>删除</a></td>				           </tr>     
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
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=type">分类管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=subject">学科管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=grade">年级管理</a></td>
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
         <table width="100%"  border="0" cellpadding="2" cellspacing="0" >
            <tr>
             <td height="24"  align=center><?=$pagenav;?></td>
              </tr>
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
case 'subject'://电教资料的学科管理
$setting_title="学科管理 (<a href=# onclick=popUp('subjectadd','0')> 添加记录 </a>)";
$setting_content="
             <table border='0' cellspacing='2' cellpadding='1' width='100%'  align=center>
					  <tbody id=classlist>
						<tr align=center valign=middle>
							<td width='10%' class=tr_head>编 号</td>
							<td width='50%' class=tr_head>名 称</td>
							<td width='20%' class=tr_head>操 作</td>
					  </tr>
					  </tbody>
                 ";
//页码设置开始
 $sql = "SELECT count(*) FROM $table_type where `type`='s'";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=setting&action=subject");      
 //页码设置结束                 
//记录数据的读取
$class_style="td1";
$query="select * from $table_type where  `type`='s'  order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $setting_content.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center class=$class_style height=24>$r[id]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style><a href=\"#\" onclick=popUp('subjectedit','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('subjectdel','$r[id]')>删除</a></td>				           </tr>     
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
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=type">分类管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=subject">学科管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=grade">年级管理</a></td>
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
           <table width="100%"  border="0" cellpadding="2" cellspacing="0" >
            <tr>
             <td height="24"  align=center><?=$pagenav;?></td>
              </tr>
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
case 'grade'://电教资料的年级管理
$setting_title="年级管理 (<a href=# onclick=popUp('gradeadd','0')> 添加记录 </a>)";
$setting_content="
             <table border='0' cellspacing='2' cellpadding='1' width='100%'  align=center>
					  <tbody id=classlist>
						<tr align=center valign=middle>
							<td width='10%' class=tr_head>编 号</td>
							<td width='50%' class=tr_head>名 称</td>
							<td width='20%' class=tr_head>操 作</td>
					  </tr>
					  </tbody>
                 ";
//页码设置开始
 $sql = "SELECT count(*) FROM $table_type where `type`='g'";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=setting&action=grade");      
 //页码设置结束                 
//记录数据的读取
$class_style="td1";
$query="select * from $table_type where  `type`='g'  order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $setting_content.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center class=$class_style height=24>$r[id]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style><a href=\"#\" onclick=popUp('gradeedit','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('gradedel','$r[id]')>删除</a></td>				           </tr>     
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
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=type">分类管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=subject">学科管理</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=grade">年级管理</a></td>
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
          <table width="100%"  border="0" cellpadding="2" cellspacing="0" >
            <tr>
             <td height="24" align=center ><?=$pagenav;?></td>
              </tr>
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
case 'typeadd':
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=typeadd">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    电教资料登记借记系统分类设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	分类名称：<input type="text" name="name" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=type value="t">
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
case 'typeedit':
//记录数据的读取
$query="select * from $table_type  where `type`='t' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=typeedit">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    电教资料登记借记系统分类设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	分类名称：<input type="text" name="name" value="<?=$r[name];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=id value=<?=$id;?>>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
case 'typedel':
//记录数据的读取
$query="select * from $table_type  where `type`='t' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=typedel">
  <tr>
    <td height="160" valign="middle" align=center>
    	真的要删除<font color=red>{<?=$r[name];?>}</font>分类资料 <p>
    	<input type=hidden name=id value=<?=$id;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
      <p>教育资源网版权所有 不凡
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'subjectadd':
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=subjectadd">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    电教资料登记借记系统学科设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	学科名称：<input type="text" name="name" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=type value="t">
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
case 'subjectedit':
//记录数据的读取
$query="select * from $table_type  where `type`='s' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=subjectedit">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    电教资料登记借记系统学科设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	学科名称：<input type="text" name="name" value="<?=$r[name];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=id value=<?=$id;?>>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
case 'subjectdel':
//记录数据的读取
$query="select * from $table_type  where `type`='s' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=subjectdel">
  <tr>
    <td height="160" valign="middle" align=center>
    	真的要删除<font color=red>{<?=$r[name];?>}</font>学科资料 <p>
    	<input type=hidden name=id value=<?=$id;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
    电教资料登记借记系统年级设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	年级名称：<input type="text" name="name" value=""></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=type value="t">
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
$query="select * from $table_type  where `type`='g' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=gradeedit">
  <tr>
    <td width="300" height="28" valign="middle" align=center> <strong>
    电教资料登记借记系统年级设置</strong>
    </td>
  </tr>
  <tr>
    <td height="56" valign="middle" align=center><strong>
    	年级名称：<input type="text" name="name" value="<?=$r[name];?>"></strong>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle" align=center>
    	<input type=hidden name=id value=<?=$id;?>>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
$query="select * from $table_type  where `type`='g' and id=$id";
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
  <form name="form1" method="post" action="?filename=deal&action=subjectdel">
  <tr>
    <td height="160" valign="middle" align=center>
    	真的要删除<font color=red>{<?=$r[name];?>}</font>年级资料 <p>
    	<input type=hidden name=id value=<?=$id;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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


