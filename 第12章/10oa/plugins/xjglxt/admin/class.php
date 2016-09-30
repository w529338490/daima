<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
/************************************************************/
//权限设置
$sql="SELECT * FROM `$table_manage` where admin=$user_id limit 1";
$r=$db->query_first($sql);
$limit=$r[groupid];   
/***********************************************************/
if (!isset($action)) $action="list";
switch($action){
case 'add'://添加班级信息
if ($limit>2)  showmessage("对不起你没有权限操作添加班级信息!");
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }

</script>
<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.styear.value == "")
   {
   		alert("请入学时间!");
		theform.styear.focus();
		return false ;
   }
   if(theform.stclassnumb.value == "" )
   {
   		alert("请输入开始班级!");
		theform.stclassnumb.focus();
		return false ;
   }
      if(theform.endclassnumb.value == "")
   {
   		alert("请输入结束班级");
		theform.endclassnumb.focus();
		return false ;
   }
   if(theform.endclassnumb.value < theform.stclassnumb.value)
   {
   		alert("请正确输入班级");
		theform.stclassnumb.focus();
		return false ;
   }
   return true ;
  }
</SCRIPT>
<body>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>班级信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=class&action=list">班级列表</A>  |
            	<A href="?filename=class&action=add">添加班级</A>  |
            	<A href="?filename=class&action=adminlist">班主任设置</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE>

  
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="99%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    			<form action="?filename=deal&action=classadd"  method="post" name="form1" OnSubmit="return check(this)">
				    		<tr  align=center>
				    		 <th colspan=3 height=28 class=tr_head2>添加班级				     		 
				    		</th>
					       </tr>
					       <tr align=center>
      	             <td height=24 class=td1 colspan=3></td>
      	          </tr>
      	          <tr align=center>
      	             <td height=24 width=50 class=td1><b>添加:</b></td>
      	             <td height=24 class=td1 align=left valign=middle colspan=2>
      	             	   <b>入学时间:</b><input type="text" name=styear value="" size=8>年
                         <b>班级数从</b><input type="text" name=stclassnumb value="" size=8>
                         到<input type="text" name=endclassnumb value="" size=8>
                         <input type=submit name=s value="开始添加班级">
      	             	   </td>
      	          </tr>
      	          <tr align=center>
      	             <td height=24 class=td1 colspan=3></td>
      	          </tr>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head colspan=3>
				    		 		</td>
					       </tr>
				    		</form>
					      </tbody>
             </TABLE>	
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
      <TD align=middle height=24>
      	Powered By <b>slcms 学籍管理系统 Version 1.0.1 （2007）</b> 程序设计：【凡·工作室】</td>
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
case 'list'://学校班级信息列表
if (!isset($gradeid)) $gradeid=0;
switch ($gradeid){
case '0':
$where="order by buildtime desc,classid asc";
break;	
case '1':
case '2':
case '3':
//在校时间参数:8月1日为新学期的开始日期
$startyear=mktime(0,0,0,7,5,date(Y));
$nowyear=time();
if ($nowyear>$startyear) {
	      $t_time=4-$gradeid;}
   else {
        $t_time=3-$gradeid;}
$t_time=date(Y)+$t_time;
$t_time=substr($t_time,2);
$where="where  classid like ('$t_time%') order by classid asc";
unset($t_time,$gradeid,$nowyear,$startyear);
break;
default:
$where="order by buildtime desc,classid asc";
break;
}
//数据读取
$query="select * from $table_class $where ";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //班级
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
      //建立时间
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //现在时间   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //时间差参数
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //初一
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="初一($class_id)班";
      	         }
      //初二	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="初二($class_id)班";
      	         }
      //初三	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="初三($class_id)班";
      	         }
      //已毕业	         
      else{
      	 	$classname=$bytime."届($class_id)班";
      	  }  
      //班级现在人数
      $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=0";
      $t=$db->query_first($sql);
      $sttotal_online=$t[0];
      //班级转校人数	 
      $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=1";
      $t=$db->query_first($sql);
      $sttotal_out=$t[0]; 
      //班级总人数
      $sttotal=$sttotal_online+$sttotal_out;
      //班主任
      $classadmin="未设置";
      //显示数据	        	
      $class_list.="<tr align=center>
      	             <td height=24 class=td1 width=25%><a href=?filename=class&action=class&classid=$r[classid]>$classname</a></td>
      	             <td class=td1>".$bytime."年</td>
      	             <td class=td1>".$sttotal."人</td>
      	             <td class=td1>".$sttotal_online."人</td>
                     <td class=td1>".$sttotal_out."人</td>
      	             <td class=td1>$classadmin</td>
      	             <td class=td1><a href=?filename=class&action=class&classid=$r[classid]>查看</a> 
      	                           编辑 
      	                           删除</td>
      	           </tr>";
}
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }

</script>
<body>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>班级信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=class&action=list">班级列表</A>  |
            	<A href="?filename=class&action=add">添加班级</A>  |
            	<A href="?filename=class&action=adminlist">班主任设置</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE>

  
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
                <tr  align=center>
				    		 	<td colspan=7>
				     		 <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0 >
				    	  <tr>
				    		 	<td  height=28 class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=0>全部</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=1>初一</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=2>初二</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=3>初三</a></td>
				    		 	<td   class=tr_head >查询</td>
				    		 </tr>
				    		</table>
				    		</td>
					       </tr>
					       <tr align=center>
      	             <td height=24 class=td1 width=25%>班级名称</td>
      	             <td class=td1>毕业时间</td>
      	             <td class=td1>班级总人数</td>
      	             <td class=td1>实际人数</td>
                     <td class=td1>转校人数</td>
      	             <td class=td1>班主任</td>
      	             <td class=td1>操作</td>
      	           </tr>
				    		 <?=$class_list;?>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head colspan=7>
				    		 		</td>
					       </tr>
					      </tbody>
             </TABLE>	
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
      <TD align=middle height=24>
      	Powered By <b>slcms 学籍管理系统 Version 1.0.1 （2007）</b> 程序设计：【凡·工作室】</td>
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
case 'adminlist':
//读取班级信息
if ($limit>2)  showmessage("对不起你没有权限操作设置班主任!");
$startyear=mktime(0,0,0,7,1,date(Y)-3);
$query="select * from $table_class where  buildtime>=$startyear order by buildtime Desc";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //班级
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
      //建立时间
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //现在时间   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //时间差参数
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //初一
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="初一($class_id)班";
      	         }
      //初二	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="初二($class_id)班";
      	         }
      //初三	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="初三($class_id)班";
      	         }
      //已毕业	         
      else{
      	 	$classname=$bytime."届($class_id)班";
      	  }  
      if ($r[classadmin]==0){$classadmin="未设置";}	 
      else{
      	$query="select realname from members where userid=$r[classadmin] limit 1";
      	$rr=$db->query_first($query);
      	$classadmin=$rr[realname];
      	};        	
    $class_list.="
    				    <tr  align=center>
				    		 	<td  height=24  class=td1 >$r[id]</td>
				    		 	<td  height=24  class=td1 >$classname</td>
				    		 	<td  height=24  class=td1 >$r[classnumber]</td>
				    		 	<td  height=24  class=td1>$classadmin</td>
				    		 	<td  height=24  class=td1 ><input type=button name=ww value=设置班主任></td>
					       </tr>
    ";      	         

}
//学号编码共8位毕业年数（2）学校编号（2）班级编号（2）学生编号（2）
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
<body>
<TABLE cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
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
              <TABLE cellSpacing=1 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
						   	  <td  class=tr_head height=28 colspan=5>学生信息文件列表</td>
					       </tr>
					       <?=$class_list;?>
					      </tbody>
             </TABLE>	
             	<TR vAlign=bottom align=middle>
      <TD align=middle>
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
<?	
break;
//某班级的学生列表
case 'class':
//读取并设置班级信息
$query="select * from $table_class where  classid=$classid";
$r=$db->query_first($query);
	    //班级
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
      //建立时间
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //现在时间   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //时间差参数
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //初一
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="初一($class_id)班";
      	         }
      //初二	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="初二($class_id)班";
      	         }
      //初三	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="初三($class_id)班";
      	         }
      //已毕业	         
      else{
      	 	$classname=$bytime."届($class_id)班";
      	  }   
//班级现在人数
$sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=0";
$t=$db->query_first($sql);
$sttotal_online=$t[0];
//班级转校人数	 
$sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=1";
$t=$db->query_first($sql);
$sttotal_out=$t[0]; 
//班级总人数
$sttotal=$sttotal_online+$sttotal_out;   	      	         	
//读取班主任信息
if ($r[classadmin]==0){
	     $classadmin="未设置";
}else{
	     $query="select * from members where  userid=$r[classadmin] limit 1 ";
	     $r=$db->query_first($query);
	     $classadmin=$r[realname];
	   }     	         	   
//读取学生信息 
switch($type){
case '1':
 //页码设置开始
 $perpage=10;
 $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$classid%') ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=class&action=class&classid=$classid&type=1");      
 //页码设置结束
 $query="select * from $table_student where  `stnumber` like ('$classid%') order by stnumber limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $studentone.="
          <TABLE cellSpacing=2 cellPadding=1 width=\"98%\" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=24 width=6% class=tr_head >学 号</td>
				    		 	<td  height=24 width=6% class=tr_head >姓 名</td>
				    		 	<td  height=24 width=5% class=tr_head >性别</td>
				    		 	<td  height=24 width=10% class=tr_head >出生年月</td>
				    		 	<td  height=24 width=5% class=tr_head >状态</td>
				    		 	<td  height=24 width=10%  class=tr_head >毕业学校</td>				    		 	
				    		 	<td  height=24 width=10% class=tr_head >父母姓名</td>
				    		 	<td  height=24 width=30% class=tr_head >工作单位</td>
				    		 	<td  height=24  class=tr_head >电话</td>
					       </tr>
				    		 <tr  align=center>
				    		 	<td  height=24  class=td1 >$r[stnumber]</td>
				    		 	<td  height=24  class=td1 >$r[name]</td>
				    		 	<td  height=24  class=td1 >$r[sex]</td>
				    		 	<td  height=24  class=td1 >".date("Y-m",$r[birthday])."</td>
				    		 	<td  height=24  class=td1 >$r[state]</td>				    		 	
				    		 	<td  height=24  class=td1 >$r[gschool]</td>
				    		 	<td  height=24  class=td1 >$r[father]</td>
				    		 	<td  height=24  class=td1 >$r[fawork]</td>
				    		 	<td  height=24   class=td1 >$r[fatel]</td>
					       </tr>
				    		 <tr  align=center>
				    		 	<td  height=24  class=tr_head2 colspan=3>户籍</td>
				    		 	<td  height=24  class=tr_head2 colspan=3>家庭地址</td>
				    		 	<td  height=24  class=td1 >$r[mother]</td>
				    		 	<td  height=24  class=td1>$r[mowork]</td>
				    		 	<td  height=24  class=td1 >$r[motel]</td>
					       </tr>
					       <tr  align=center>
				    		 	<td  height=24  class=td1 colspan=3>$r[hreg]</td>
				    		 	<td  height=24  class=td1 colspan=3>$r[address]</td>
				    		 	<td  height=24  class=tr_head2 >备注</td>
				    		 	<td  height=24  class=td1>$r[note]</td>
				    		 	<td  height=24  class=td1 ><input type=button name=edit value=编辑><input type=button name=edit value=删除></td>
					       </tr>
					      </tbody>
             </TABLE>	
             <TABLE cellSpacing=0 cellPadding=1 width=\"98%\" align=center border=0 >
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=3></td>
					       </tr>
					      </tbody>
             </TABLE>	   
      "   ;	         
} 
$pagelist=" <TABLE cellSpacing=0 cellPadding=1 width=\"98%\" align=center border=0 >
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=24>$pagenav</td>
					       </tr>
					      </tbody>
             </TABLE>	 ";
$student_list=$studentone.$pagelist;
break;
default :
$i=0;     	         	
$query="select * from $table_student where  `stnumber` like ('$classid%')";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $i++;
      $stnumber=substr($r[stnumber],6,2);
      $studentone.="<td height=24 class=td1 width=20%>$r[name]($stnumber)</td>";
      if ($i%5==0) {
      	  $studentone_list.="<tr align=center>$studentone</tr>";
      	  $studentone="";
      	  $i=0;
      	  }           
}
if ($i%5!=0){
   for ($l=$i;$l<5;$l++) 
       $studentone.="<td height=24 class=td1 width=20%>&nbsp;</td>";
   $studentone_list.="<tr align=center>$studentone</tr>";
   }    
$student_list=$studentone_list;
break;	
}
?>
<body>
<table width="770" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>班级信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> <A 
      href="?filename=class&action=list">班级信息列表</A>  | <A 
      href="?filename=class&action=adminlist">班级主任设置</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><strong>当前位置：班级信息管理 >>
      	 <A href="?filename=class&action=list">班级信息列表</a></strong>
      (<a href=?filename=class&action=class&classid=<?=$classid;?>&type=0>普通列表</a>--<a href=?filename=class&action=class&classid=<?=$classid;?>&type=1>详细列表</a>)</td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head2 colspan=5><?=$classname;?>学生列表(本班共有<?=$sttotal;?>人)----班主任[<font color=red><?=$classadmin;?></font>]
					       </tr>
				    		 <?=$student_list;?>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head2 colspan=5>
				    		 		</td>
					       </tr>
				    		</form>
					      </tbody>
             </TABLE>	
    </td> 
    </tr>   
</table>
</body>
</html>
<?
break;
}
?>