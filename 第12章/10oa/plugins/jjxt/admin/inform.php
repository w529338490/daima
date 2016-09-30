<?php
/*
凤鸣山中小学网络办公室
*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){
	//获取登入人员信息
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
//设置物品类别
$query="select * from $table_type  order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$types[$r[id]]=$r[name];
	$types_t[$r[type]][]=array("$r[id]","$r[name]");
}
//设置物品所属类别
$ok="";
if (is_array($types_t[t])){
	foreach($types_t[t] AS $value){
		$type_show.="$ok <a href=?filename=inform&select=type&tid=$value[0] >$value[1]</a> ";
		$type_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//设置物品所属年级
$ok="";
if (is_array($types_t[g])){
	foreach($types_t[g] AS $value){
		$grade_show.="$ok <a href=?filename=inform&select=grade&tid=$value[0]>$value[1]</a> ";
		$grade_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//设置物品所属学科
$ok="";
if (is_array($types_t[s])){
	foreach($types_t[s] AS $value){
		$subject_show.="$ok <a href=?filename=inform&select=subject&tid=$value[0] >$value[1]</a> ";
		$subject_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//设置分类浏览
switch($select){
	case 'type':
		$addaction="&select=type&tid=$tid";
		$select_type=" where type='$tid' ";
		$show_nav=$types[$tid];
		break;
	case 'grade':
		$addaction="&select=grade&tid=$tid";
		$select_type=" where grade='$tid' ";
		$show_nav=$types[$tid];
		break;
	case 'subject':
		$select_type=" where subject='$tid' ";
		$addaction="&select=subject&tid=$tid";
		$show_nav=$types[$tid];
		break;
	case 'all':
		$s=0;
		//关键词
		if (empty($keyword)){ $select_type="";
		}
		else  {$select_type=" where name  REGEXP  '$keyword'";
		$addaction="&select=all&keyword=$keyword";
		$s=1;
		}
		//分类
		if ($s_type!=0) {
			if ($s==0) { $select_type=" where type=$s_type";
			$addaction="&select=all&s_type=$s_type";
			$s=1;
			}
			else { $select_type.=" AND type=$s_type";
			$addaction.="&s_type=$s_type";
			}
		}
		//年级
		if ($s_grade!=0) {
			if ($s==0) { $select_type=" where grade=$s_grade";
			$addaction="&select=all&s_grade=$s_grade";
			$s=1;
			}
			else { $select_type.=" AND grade=$s_grade";
			$addaction.="&s_grade=$s_grade";
			}
		}
		//学科
		if ($s_subject!=0) {
			if ($s==0) { $select_type=" where subject=$s_subject";
			$addaction="&select=all&s_subject=$s_subject";
			$s=1;
			}
			else { $select_type.=" AND subject=$s_subject";
			$addaction.="&s_subject=$s_subject";
			}
		}
		break;
	default:
		$select_type="";
		$addaction="";
		break;
}
//页码设置开始
$sql = "SELECT count(*) FROM $table_product $select_type";
$result = $db->query_first($sql);
$totalnum=$result[0];
$pagenumber = intval($pagenumber);
if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
$curpage=($pagenumber-1)*$perpage;
$pagenav=getpagenav($totalnum,"?filename=inform$addaction");
//页码设置结束
$kg_list="
         <TABLE cellSpacing=0 cellPadding=0 width=100% border=0 align=center >
	        <TR vAlign=bottom align=middle>
          <TD align=middle height=5></td>
          </tr>
         </table>
         ";    
//物品信息的读取
$query="select * from $table_product $select_type order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$intime=date("Y/m/d",$r[intime]);
	$type=$types[$r[type]];
	$grade=$types[$r[grade]];
	$subject=$types[$r[subject]];
	$edit="<font color=red>入库</font>|<a href=# onclick=popUp('editproduct','$r[id]')>编辑</a>|删除";
	$product_list.="
	                <TABLE id=table$r[id] cellSpacing=1 cellPadding=1 width=\"98%\" align=center border=0 class=table1>
				    		<tbody>
				    		 <tr  align=center id='list$r[id]1'>
						   	  <td width='5%' height=24 class=tr_head>序列</td>
					  		  <td width='45%' class=tr_head>名称</td>
						  	  <td width='10%' class=tr_head>分类</td>
						  	  <td width='10%' class=tr_head>年级</td>
						  	  <td width='10%' class=tr_head>学科</td>
						  	  <td width='5%' class=tr_head>库存</td>
						  	  <td width='5%' class=tr_head>已借</td>
						  	  <td width='5%' class=tr_head>预借</td>	
						  	  <td width='5%' class=tr_head>次数</td>					  	  
					       </tr>
					       <tr  align=center id='list$r[id]2'>
						   	  <td  height=24 class=td2>$r[id]</td>
					  		  <td class=td2>$r[name]</td>
						  	  <td class=td2>$type</td>
						  	  <td class=td2>$grade</td>
						  	  <td class=td2>$subject</td>
						  	  <td class=td2>$r[innumber]</td>
						  	  <td class=td2>$r[outnumber]</td>
						  	  <td class=td2>$r[prenumber]</td>
						  	  <td class=td2>$r[bornumber]</td>
					       </tr>
					       <tr  id='list$r[id]3'>
						   	  <td align=center height=24 class=tr_head>描述</td>
					  		  <td class=td2 colspan=6>$r[content]</td>
						  	  <td align=center class=tr_head2 colspan=2><a href=# class=b onclick=popUp('preborrow','$r[id]') >预 借</a></td>
					       </tr>
					      </tbody>
					    </table>
	             $kg_list      
	             ";
}
?>
<SCRIPT LANGUAGE="JavaScript">
function popUp(action,id) {
	props=window.open('?filename=borrow&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=1, menubars=1, resizable=0, width=300, height=170, left = 250, top = 210');
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
	                 <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	分 类：<?=$type_show;?>
                      </td>
                   </tr>
                   <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	学 科：<?=$subject_show;?>
                      </td>
                   </tr>
                   <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	年 级：<?=$grade_show;?>
                      </td>
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
      <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
                <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                <form name="form1" method="post" action="?filename=inform"> 
	                	<TR vAlign=bottom align=middle>
                      <TD align=left height=28 width=30%>
                      &nbsp; &nbsp;当前位置：<a href="?filename=inform" >全 部</a> >> <?=$show_nav;?> 	
                      </td>
                      <TD align=right height=28>
                      
                        关键词：<input type=text name=keyword size=12>	                      
	                       <select name="s_type">
	                       	<option value=0>分类</option>
		                      <?=$type_option;?>
                         </select>
                         <select name="s_grade">
                         	<option value=0>年级</option>
		                       <?=$grade_option;?>
                         </select>
                         <select name="s_subject">
                         	<option value=0>学科</option>
		                       <?=$subject_option;?>
                         </select>
                         <input type=hidden name=select value=all>
                         <input type=submit value="搜 索">
                         &nbsp;&nbsp;
                      </td>
                   </tr> </form>
                 </table>
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>  
                 <table cellSpacing=1 cellPadding=1 width=98% border=0 align=center>
                 <tbody id=newlist>
                </tbody>
              </table>
                </td>
               </tr>
               <tr>
              <td width="100%" valign="top">
                 <?=$product_list?>
             </td>
            </tr>
    <TR vAlign=bottom align=middle>
      <TD align=left height=24 >
      	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	         <TR vAlign=middle>
	         	<TD align=center height=24  >
	         		 <font color=blue ><b>&nbsp;<?=$pagenav;?></td>
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
      	开发笔记 技术支持】</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>