<?php

/**************Login-AND-Logout*****************/
if (isset($user_id)){
	      //获取登入人员信息管理权限
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){
          	   $adminrepair=1; 
          	   $nav_admin="| <a href=\"?filename=admin\">管 理</a>";
          }
          if ($group_id==1){
          	  $adminrepair=1; 
          	   $nav_admin="| <a href=\"?filename=admin\">管 理</a>";
          }
	        $login="<table width=\"99%\" height=40 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td valign=bottom height=40 width=260 align=center>
                          <span class=b_title>{ 分组实验登记系统 }</span></td>
                       <td align=right valign=bottom> 当前用户：[$real_name] <a href=\"?filename=index\" >首 页</a> | <a href=\"#\" onclick=popUp('repair','0')>申请实验</a>  | <a href=\"?filename=list\" >我的申请</a> $nav_admin </td>
                       <td width=20></td>
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
//参数设置  
$class_style="td2";  
switch($school_type){
	case '1':
		$gradearr=array("1"=>"小一","2"=>"小二","3"=>"小三","4"=>"小四","5"=>"小五","6"=>"小六");
		break;
	case '2':
		$gradearr=array("1"=>"初一","2"=>"初二","3"=>"初三");
		break;
	case '3':
		$gradearr=array("1"=>"高一","2"=>"高二","3"=>"高三");
		break;
	case '12':
		$gradearr=array("1"=>"小一","2"=>"小二","3"=>"小三","4"=>"小四","5"=>"小五","6"=>"小六","7"=>"初一","8"=>"初二","9"=>"初三");
		break;
}
$gradecarr=array("全年级","(1)班","(2)班","(3)班","(4)班","(5)班","(6)班","(7)班","(8)班","(9)班","(10)班","(11)班","(12)班");
$state=array("申请中","准备好","使用中","已归还");
if (isset($stateid)){ 
	   $t_where="where `state`='$stateid'";
	   $t_where_2="where $table_content.state='$stateid'";
	   $t_url="&stateid=$stateid";
	   }
//页码设置开始
$sql = "SELECT count(*) FROM $table_content $t_where";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=index$t_url");      
 //页码设置结束
//记录数据的读取
$query="select $table_content.*,members.realname from $table_content 
            LEFT JOIN members ON $table_content.userid=members.userid
            $t_where_2
            order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	          $intime=date("Y/m/d",$r[intime]);
	          if ($adminrepair==1) $adminpop="onclick=popUp('adminrepair','$r[id]')"; else $adminpop="";
	          if ($user_id==$r[userid]) $editpop="onclick=popUp('editrepair','$r[id]')"; else $editpop="";
	         	$t_l=strlen($r[nonum].$r[title]);
	         	$r[content]=cnSubStr($r[content],60-$t_l);
	         	$table_show.="
	         	              <tr id=list$r[id]>
           	               <td align=\"center\" valign=\"middle\" height=24 class=$class_style>".$gradearr[$r[grade]]."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$r[realname]."</td>
           	               <td align=\"left\" valign=\"middle\" class=$class_style><a href=# onclick=popUp('showcontent','$r[id]')>".$r[nonum]." ".$r[title]."{".$r[content]."}</a></td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$state[$r[state]]."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$intime</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style><a href=# $editpop title='只有报修者才能修改'>编辑</a>|<a href=# $adminpop title='管理员才有权限'>管理</a></td>
         	               </tr>";           
       }        
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left=250, top=210');
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
      <?=$login;?>
      <?=$logout;?>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
      <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
	                 	 <TD align=left width=150> &nbsp;&nbsp;<b>当前位置:首页</td>
                      <TD align=right height=20><a href="?filename=index">全部</a> | <a href="?filename=index&stateid=0">申请</a> | <a href="?filename=index&stateid=1">准备</a> | <a href="?filename=index&stateid=2">使用</a> | <a href="?filename=index&stateid=3">归还</a> </td>
                      <TD align=right width=30> </td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
						   	  <td width='7%' height=24 class=tr_head>年级</td>
					  		  <td width='8%' class=tr_head>领用人</td>
						  	  <td width='57%' class=tr_head>章节 实验名称{器材}</td>
						  	  <td width='8%' class=tr_head>状态</td>
						    	<td width='10%' class=tr_head>操作时间</td>
						    	<td width='12%' class=tr_head>操 作</td>
					       </tr>
					      </tbody>
                <?=$table_show;?>
                <tr  align=center>
						   	  <td width='7%' height=24 class=tr_head>年级</td>
					  		  <td width='8%' class=tr_head>领用人</td>
						  	  <td width='57%' class=tr_head>章节 实验名称{器材}</td>
						  	  <td width='8%' class=tr_head>状态</td>
						    	<td width='10%' class=tr_head>操作时间</td>
						    	<td width='12%' class=tr_head>操 作</td>
					       </tr>
             </TABLE>	
             </td>
            </tr>
    <TR vAlign=bottom align=middle>
      <TD align=left height=24 colSpan=<?=$colid+1;?>>
      	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	         <TR vAlign=middle>
	         	<TD align=center height=24  > <font color=blue ><b><?=$pagenav;?>&nbsp;</td>
	         	
          </tr>
        </table>
      </td> 
     </tr>
  </table>
     
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
            

		 </td>
	 </tr>
  </table> 
 
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
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
      	开发笔记 技术支持
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>

