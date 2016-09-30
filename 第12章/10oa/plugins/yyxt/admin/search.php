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
	$login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：$real_name  <a href=\"?filename=index&gtypeid=$gtypeid\" >首 页</a> | <a href=\"#\" onclick=popUp('order','0','$gtypeid')>预 订</a> | <a href=\"#today\" >今日预约</a> | <a href=\"?filename=list&gtypeid=$gtypeid\" >我的预约</a> | <a href=\"?filename=admin&gtypeid=$gtypeid\">管 理</a> 
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
                                    <input type=\"submit\" name=\"submit\" value=\"点击登入\" /> | <a href=\"#today\" >今日预约</a>
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
};

//数据设置
$ordertime_now=mktime(0,0,0,date("m"),date("d"),date("Y"));
$subjects=array("其 他","语 文","数 学","英 语","科 学","社 会","体 育","美 术","音 乐","劳 技");
//设定上课科目和真实姓名的设置
$query="select userid,username,realname from members";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$realname[$r[userid]]=array($r[username],$r[realname]);
}
//设定日期时间
$test=explode("-",$st_time);
$ordertime_st=mktime(0,0,0,$test[1],$test[2],$test[0]);
$test=explode("-",$end_time);
$ordertime_end=mktime(0,0,0,$test[1],$test[2],$test[0]);
$endtime=($ordertime_end-$ordertime_st)/86400;
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
for ($i=0;$i<=$endtime;$i++){
	//$ordertime_value=mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
	$ordertime_value=$ordertime_st+86400*$i;
	$ordertime_byid[$i]=$ordertime_value;
	$ordertime_show=date("Y-m-d",$ordertime_value);
	$weekid=date("w",$ordertime_value);
	$ordertime_week=$week[$weekid];
	$ordertime_date[$i]=array($ordertime_value,$ordertime_show,$ordertime_week);
};

//记录数据的读取
$query="select * from $table_content where `classid`='$classid' and ordertime>=$ordertime_st and ordertime<=$ordertime_end and state>0 order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$order_data[$r[id]]=array($r[id],$r[classid],$r[ordertime],$r[nonumber],$r[grade],$r[teacher],$r[subject],$r[content]);
	$order_a[$r[classid]][$r[ordertime]][$r[nonumber]]=$r[id];
}
//设定上课班级
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$show_grade[$r[classid]]=$r[classname];
}

//教室数据的读取
$query="select * from $table_class where typeid=$classid order by id ASC";
$r=$db->query_first($query);
$address.=$n."\"".$r[address]."\"";
$class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$r[name]</STRONG></FONT></TD>";
$table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";
$class_address=$class_data[$r[id]][2];

$class_style="td1";
$table_show.="<table id=showtable$r[id] width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"1\" cellspacing=\"2\" bordercolor=\"#0099FF\">
	                   <tr>
                       <td width=\"12%\" height=28 align=\"center\" valign=\"middle\" class=tr_head >日 期</td>
                       <td width=\"8%\" align=\"center\" valign=\"middle\" class=tr_head >星 期</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第一节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第二节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第三节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第四节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head>第五节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第六节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第七节</td>
                       <td width=\"10%\" align=\"center\" valign=\"middle\" class=tr_head >第八节</td>
                     </tr>
	                  ";
if (is_array($ordertime_date)){
	$class_style="td2";
	foreach($ordertime_date as $t_date){
		$order_="";
		for($i=1;$i<=8;$i++){
			$order_id=$order_a[$classid][$t_date[0]][$i];
			if ($order_id>0){
				$grade_id=$order_data[$order_id][4];
				$user_id=$order_data[$order_id][5];
				//if ($user_name==$realname[$user_id][0]) $pop="onclick=popUp('unorder','$order_id')"; else $pop="";
				$order_[$i]="<a href=# $pop title='内 容：".$order_data[$order_id][7]."&#13;&#10;科 目：".$order_data[$order_id][6]."&#13;&#10;点击链接取消预约'>".$realname[$user_id][1]."<br>".$show_grade[$grade_id]."</a>";
			} else {$order_[$i]="/";}
		}
		$table_show.="
	         	              <tr>
           	               <td align=\"center\" valign=\"middle\" height=32 class=$class_style>$t_date[1]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$t_date[2]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[1]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[2]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[3]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[4]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[5]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[6]</td>
          	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[7]</td>
          	               <td align=\"center\" valign=\"middle\" class=$class_style>$order_[8]</td>
         	               </tr>";
		if ($class_style=="td1") $class_style="td2";else $class_style="td1";       }
}
$table_show.="</table>";
$table_show.="</TD>
                      </TR>
                     </TBODY>
	                    ";
?>
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
              <TBODY>         
              
              <TR vAlign=bottom align=left>
                <TD align=middle>
                  <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0 align=center >
	                  <TR vAlign=bottom align=middle>  
	                  <?=$class_show;?> 
	                  <TD ></TD>               	
	                  </tr>
	                 <TR align=middle>
                   <TD align=middle bgColor=#99CC00 colSpan=<?=$colid+1;?> height=2></TD>
                   </TR>
                 </table>	
                </TD>
              </TR>
            </TBODY>
            <tr>
              <td width="100%" height="180" valign="top">
              <TABLE cellSpacing=0 cellPadding=0 width="98%" align=center border=0 class=table1>
              <?=$table_show;?>
             </TABLE>	
             </td>
            </tr>
    <TR vAlign=bottom align=middle>
      <TD align=left height=24 colSpan=<?=$colid+1;?>>
      	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	         <TR vAlign=middle>
	         	<TD align=left height=24  width=150> <font color=blue ><b>&nbsp;当前多功能教室位置：</td>
	         	<TD align=left height=24  id=address> <font color=red ><b><u><?=$class_address;?></u></font></td>
	         	<TD align=right><b>("/":表示这堂课没有被预约)&nbsp;&nbsp; </td>
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


