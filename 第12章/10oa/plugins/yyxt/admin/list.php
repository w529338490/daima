<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   多功能教室登记系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

/**************Login-AND-Logout*****************/
if (isset($user_name)){
	        $login="<table width=\"99%\" border=\"0\" height=32 align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：$user_name  <a href=\"?filename=index&gtypeid=$gtypeid\" >首 页</a> | <a href=\"#\" onclick=order('order','0','$gtypeid')>预 订</a> | <a href=\"?filename=index&gtypeid=$gtypeid#today\" >今日预约</a> | <a href=\"?filename=list&gtypeid=$gtypeid\" >我的预约</a> | <a href=\"?filename=admin&gtypeid=$gtypeid\">管 理</a> 
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"99%\" border=\"0\" height=32 align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
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
//数据设置                  
$ordertime_now=mktime(0,0,0,date("m"),date("d"),date("Y"));
$subjects=array("其 他","语 文","数 学","英 语","科 学","社 会","体 育","美 术","音 乐","劳 技");
//设定上课科目和真实姓名的设置
$query="select userid,realname from members where username='$user_name'";
$r=$db->query_first($query);
$user_id=$r[userid];
$user_realname=$r[realname];

//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$ordertime_now=mktime(0,0,0,date("m"),date("d"),date("Y"));
//设定上课班级
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$order_grades[$r[classid]]=$r[classname];
    }
//本分类教室数据的读取
$query="select id from $table_class where typeid=$gtypeid order by id ASC";
$result=$db->query($query);
$dd="";
while($r=$db->fetch_array($result)){   
$ingtypeid.=$dd.$r[id];
$dd=",";
}  
//教室数据的读取
$query="select * from $table_class where typeid=$gtypeid order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $order_classes[$r[id]]=array($r[id],$r[name],$r[address]);
      }  
//页码设置开始
 $sql = "SELECT count(*) FROM $table_content where teacher=$user_id and (classid in ($ingtypeid)) ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=list");      
 //页码设置结束
//记录数据的读取
$i=1;
$class_style="td1";
$query="select * from $table_content where teacher=$user_id and  (classid in ($ingtypeid)) order by ordertime DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $order_data[$r[id]]=array($r[id],$r[classid],$r[ordertime],$r[nonumber],$r[grade],$r[teacher],$r[subject],$r[content]);
      $order_time=date("Y-m-d",$r[ordertime]);
      $weekid=date("w",$r[ordertime]);
      $order_week=$week[$weekid];
      $order_grade=$order_grades[$r[grade]];
      $order_class=$order_classes[$r[classid]][1];
      if ($r[state]==0) { $order_state="已取消";$act="<a href=\"#\" onclick=popUp('aorder','$i','$r[id]')>续约</a>";} else{ $order_state="有  效"; $act="<a href=\"#\" onclick=popUp('delorder','$i','$r[id]')>取消</a>";};
      if ($r[ordertime]>=$ordertime_now){
      $todayorder.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style>$order_time</td>
			              <td align=center class=$class_style>$order_week</td>
					          <td align=center class=$class_style>第".$r[nonumber]."堂课</td>
				            <td align=center class=$class_style>$order_grade</td>
				            <td align=center class=$class_style>[$order_class]</td>
				            <td align=center class=$class_style>$order_state</td>
				            <td align=center class=$class_style> $act | <a href=\"#\" onclick=popUp('editorder','$i','$r[id]')>修改</a></td>				           </tr>     
		               "; 
		             }else {
		             	$todayorder.="
			             <tr id=list$i valign=middle>
			              <td align=center height=24 class=$class_style>$order_time</td>
			              <td align=center class=$class_style>$order_week</td>
					          <td align=center class=$class_style>第".$r[nonumber]."堂课</td>
				            <td align=center class=$class_style>$order_grade</td>
				            <td align=center class=$class_style>[$order_class]</td>
				            <td align=center class=$class_style>$order_state</td>
				            <td align=center class=$class_style>操作过期</td>				           </tr>     
		               "; 
		             	
		             	    }
		   $i++;
		   if ($class_style=="td1") $class_style="td2";else $class_style="td1";            
      }
                  
?>
<SCRIPT language=JavaScript> 
  function popUp(action,tableid,orderid) {
           props=window.open('?filename=order&action='+action+'&orderid='+orderid+'&tableid='+tableid, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
           }
  function order(action,orderid,gtypeid) {
  	        location="index.php?filename=index&gtypeid="+gtypeid;
            props=window.open('?filename=order&action='+action+'&gtypeid='+gtypeid+'&orderid='+orderid+'&aid='+0, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
           }        
</SCRIPT>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
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

    <table width='99%' border='0' cellspacing='0' cellpadding='0' height=146 align=center  class=tableborder_2>
	      <tr>
		      <td valign=top align=center>  
		      				<table width='100%'  cellspacing='0' cellpadding='0' align=center  >
	       <tr height=24 >
		       <td >
			       <b>&nbsp;&nbsp;<?=$user_realname;?>的预约课</b>
					</td>
	       </tr>
       </table> 
       <table width='98%' border='0' cellspacing='0' cellpadding='0' height=146 align=center  class=table1>
	      <tr>
		      <td valign=top align=center>
					<table border='0' cellspacing='2' cellpadding='1' width='100%' id="todayorder" align=center>
						<tr align=center valign=middle>
							<td width='15%' height=24 class=tr_head>日 期</td>
							<td width='10%' class=tr_head>星 期</td>
							<td width='10%' class=tr_head>课 次</td>
							<td width='10%' class=tr_head>班 级</td>
							<td width='20%' class=tr_head>多媒体教室</td>
							<td width='10%' class=tr_head>状 态</td>
							<td width='25%' class=tr_head>操 作</td>
					  </tr>
					  <tbody id="todayorder1">
            <?=$todayorder;?>
            </tbody>
					</table>
				</td>
					  </tr>
					</table>	
									<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=24><?=$pagenav;?></td>
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

