<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
//权限设置
$sql="SELECT * FROM `$table_manage` where admin=$user_id limit 1";
$r=$db->query_first($sql);
$limit=$r[groupid];
/************************************************************/
switch ($action){
//***************************************本班学生成绩列表***************************/
case 'listone':
//记录数据的读取
$i=1;
$class_style="td1";
$sql = "SELECT count(*) FROM $table_result where resultid=$id";
$result = $db->query_first($sql);
$totalnum=$result[0];
$query="select $table_result.*,$table_student.name,$table_student.classid,$table_class.buildtime  from $table_result 
            LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
            LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
            where $table_result.resultid='$id' 
            order by $table_result.id  limit 0,$totalnum";            
$result=$db->query($query);
while($r=$db->fetch_array($result)){
$classid=substr($r[stnumber],0,6);
//学科成绩信息按[班级][学号]存放:0总分1语文2数学3外语4科学5思政6历社7名次8姓名9序列号	
$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[name],$r[id]);
//班级输入时间
$classbuildtime[$classid]=$r[buildtime];
$i++;
}
$colid=0;
//数据输出
foreach($resultarr as $key => $arr){             
      //班级id 	
	    $classid=$key;
			//名次计数		       
	    $j=1;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    	$table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=stlist>
				    		 <tr  align=center>		
				    			<td  class=tr_head>序列号</td>	
				    		 	<td  width=15% height=24 class=tr_head>班级</td>
				    		 	<td   class=tr_head>学号</td>
				    		 	<td  class=tr_head>学生姓名</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>
					  		  <td  class=tr_head>总分</td>
					  		 	<td  class=tr_head>操作</td>	
	
					       </tr>"; 
  foreach ($arr as $key => $value){
   //本班输出成绩信息
   $table_show.="
     				    <tr  align=center id=list$value[9]> 
     				    <td  class=td1>$j</td>
     				      <td  class=td1 width=15% height=24 >$classname</td>
				    		 	<td   class=td1>$key</td>
				    		 	<td  class=td1>$value[8]</td>
						   	  <td  class=td1>$value[1]</td>
					  		  <td  class=td1>$value[2]</td>
					  		  <td  class=td1>$value[3]</td>
					  		  <td  class=td1>$value[4]</td>
					  		  <td  class=td1>$value[5]</td>
					  		  <td  class=td1>$value[6]</td>	
					  		  <td   class=td1>$value[0]</td>					  		 
     				      <td  class=td1><a href=# onclick=popUp('editst','$value[9]')>修改</a></td>	
					       </tr>
       ";

  $j++;
  }
  $table_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";				       
}

?>

<?
break;
//******************************************班级排名统计***********************************/
case 'cout':
//数据读取
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
$totalnum=$r[0];
$i=1;
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
$classid=substr($r[stnumber],0,6);	
$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[name]);
$classbuildtime[$classid]=$r[buildtime];
$i++;
}
$colid=1;
//数据输出
foreach($resultarr as $key => $arr){             
      //班级id 	
	    $classid=$key;
			//名次计数		       
	    $j=1;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    	$table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td  width=15% height=24 class=tr_head>班级</td>
				    		 	<td   class=tr_head>学号</td>
				    		 	<td  class=tr_head>学生姓名</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>
					  		  <td  class=tr_head>总分</td>
					  		 	<td  class=tr_head>班级名次</td>	
				    		 	<td  class=tr_head>年级名次</td>		
					       </tr>"; 
  foreach ($arr as $key => $value){
   //本班输出成绩信息
   $table_show.="
     				    <tr  align=center>
     				      <td  class=td1 width=15% height=24 >$classname</td>
				    		 	<td   class=td1>$key</td>
				    		 	<td  class=td1>$value[8]</td>
						   	  <td  class=td1>$value[1]</td>
					  		  <td  class=td1>$value[2]</td>
					  		  <td  class=td1>$value[3]</td>
					  		  <td  class=td1>$value[4]</td>
					  		  <td  class=td1>$value[5]</td>
					  		  <td  class=td1>$value[6]</td>	
					  		  <td   class=td1>$value[0]</td>
					  		  <td  class=td1>$j</td>
     				      <td  class=td1>$value[7]</td>	
					       </tr>
       ";
    //年级总成绩信息   
    $grade_show[$value[7]]="
     				    <tr  align=center>
     				      <td  class=td1 width=15% height=24 >$classname</td>
				    		 	<td   class=td1>$key</td>
				    		 	<td  class=td1>$value[8]</td>
						   	  <td  class=td1>$value[1]</td>
					  		  <td  class=td1>$value[2]</td>
					  		  <td  class=td1>$value[3]</td>
					  		  <td  class=td1>$value[4]</td>
					  		  <td  class=td1>$value[5]</td>
					  		  <td  class=td1>$value[6]</td>	
					  		  <td   class=td1>$value[0]</td>
     				      <td  class=td1>$value[7]</td>	
					       </tr>
       ";   
    $total[$classid][yw]+=$value[0];
    $total[$classid][sx]+=$value[1];
    $total[$classid][wy]+=$value[2];
    $total[$classid][kx]+=$value[3];
    $total[$classid][sz]+=$value[4];
    $total[$classid][ls]+=$value[5];
    //语文成绩分类0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
    $t_name=array(" ","type_yw","type_sx","type_wy","type_ke","type_sz","type_ls");
    for ($i=1;$i<=6;$i++)
    if ($value[$i]>=0 and $value[$i]<10)
        ${$t_name[$i]}[$classid][1][]=$value[$i];
        elseif ($value[$i]>=10 and $value[$i]<20)
                ${$t_name[$i]}[$classid][2][]=$value[$i];
        elseif ($value[$i]>=20 and $value[$i]<30)
                ${$t_name[$i]}[$classid][3][]=$value[$i];
        elseif ($value[$i]>=30 and $value[$i]<40)
                ${$t_name[$i]}[$classid][4][]=$value[$i];
        elseif ($value[$i]>=40 and $value[$i]<50)
                ${$t_name[$i]}[$classid][5][]=$value[$i];
        elseif ($value[$i]>=50 and $value[$i]<60)
                ${$t_name[$i]}[$classid][6][]=$value[$i];
        elseif ($value[$i]>=60 and $value[$i]<70)
                ${$t_name[$i]}[$classid][7][]=$value[$i];
        elseif ($value[$i]>=70 and $value[$i]<80)
                ${$t_name[$i]}[$classid][8][]=$value[$i];
        elseif ($value[$i]>=80 or $value[$i]<85)
                ${$t_name[$i]}[$classid][9][]=$value[$i];
        elseif ($value[$i]>=85 or $value[$i]<90)
                ${$t_name[$i]}[$classid][10][]=$value[$i];
        elseif ($value[$i]>=90 or $value[$i]<100)
                ${$t_name[$i]}[$classid][11][]=$value[$i];
        elseif ($value[$i]==100)
                ${$t_name[$i]}[$classid][12][]=$value[$i];
  $j++;
  }
  $table_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";				       
}
//设置年级成绩输出
$class_show="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1(0);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>整个年级</STRONG></FONT></TD>".$class_show;
$t_show="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
$t_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td  width=15% height=24 class=tr_head>班级</td>
				    		 	<td   class=tr_head>学号</td>
				    		 	<td  class=tr_head>学生姓名</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>
					  		  <td  class=tr_head>总分</td>
				    		 	<td  class=tr_head>年级名次</td>		
					       </tr>";     
ksort($grade_show);					                        
foreach ($grade_show as $key => $value){
$t_show.=$value;
}
$t_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";
$table_show=$t_show.$table_show;              
              
break;
//*************************************班级成绩统计**********************************/
case 'sout':
//数据读取
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//所有学生人数
$all_num=$r[0];
//各科所有成绩和
$all_1=$r[1];
$all_2=$r[2];
$all_3=$r[3];
$all_4=$r[4];
$all_5=$r[5];
$all_6=$r[6];
//年级名次初始化
$i=1;
//数据读取
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
$classid=substr($r[stnumber],0,6);	
$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[name]);
$classbuildtime[$classid]=$r[buildtime];
$i++;
}
//参数设置
$colid=1;
//数据输出
foreach($resultarr as $key => $arr){             
      //班级id 	
	    $classid=$key;
			//名次和班级人数计数		       
	    $j=0;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    	$table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>	
					       </tr>"; 
  foreach ($arr as $key => $value){
   //本班输出成绩信息
     $j++;
    //班级学科总分    
    $total[$classid][yw]+=$value[1];
    $total[$classid][sx]+=$value[2];
    $total[$classid][wy]+=$value[3];
    $total[$classid][kx]+=$value[4];
    $total[$classid][sz]+=$value[5];
    $total[$classid][ls]+=$value[6];
    //按学科分类存放
    $yw[$classid][]=$value[1];
    $sx[$classid][]=$value[2];
    $wy[$classid][]=$value[3];
    $kx[$classid][]=$value[4];
    $sz[$classid][]=$value[5];
    $ls[$classid][]=$value[6];
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
    $t_name=array(" ","type_yw","type_sx","type_wy","type_ke","type_sz","type_ls");
    for ($i=1;$i<=6;$i++)
        if ($value[$i]>=0 and $value[$i]<10)
               ${$t_name[$i]}[$classid][1][]=$value[$i];
        elseif ($value[$i]>=10 and $value[$i]<20)
                ${$t_name[$i]}[$classid][2][]=$value[$i];
        elseif ($value[$i]>=20 and $value[$i]<30)
                ${$t_name[$i]}[$classid][3][]=$value[$i];
        elseif ($value[$i]>=30 and $value[$i]<40)
                ${$t_name[$i]}[$classid][4][]=$value[$i];
        elseif ($value[$i]>=40 and $value[$i]<50)
                ${$t_name[$i]}[$classid][5][]=$value[$i];
        elseif ($value[$i]>=50 and $value[$i]<60)
                ${$t_name[$i]}[$classid][6][]=$value[$i];
        elseif ($value[$i]>=60 and $value[$i]<70)
                ${$t_name[$i]}[$classid][7][]=$value[$i];
        elseif ($value[$i]>=70 and $value[$i]<80)
                ${$t_name[$i]}[$classid][8][]=$value[$i];
        elseif ($value[$i]>=80 and $value[$i]<85)
                ${$t_name[$i]}[$classid][9][]=$value[$i];
        elseif ($value[$i]>=85 and $value[$i]<90)
                ${$t_name[$i]}[$classid][10][]=$value[$i];
        elseif ($value[$i]>=90 and $value[$i]<100)
                ${$t_name[$i]}[$classid][11][]=$value[$i];
        elseif ($value[$i]==100)
                ${$t_name[$i]}[$classid][12][]=$value[$i];
  }//end foreach
  //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
  $result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");           
  //学科成绩分段输出
  for ($p=12;$p>=1;$p--) {       
      $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".$result_d[$p]."</td>
				    		 	<td  class=td1>".sizeof(${$t_name[1]}[$classid][$p])."</td>
						   	  <td  class=td1>".sizeof(${$t_name[2]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[3]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[4]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[5]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[6]}[$classid][$p])."</td>
					      </tr>";
			//年级学科分段		      
			$all_[1][$p]+=sizeof(${$t_name[1]}[$classid][$p]);
			$all_[2][$p]+=sizeof(${$t_name[2]}[$classid][$p]);
			$all_[3][$p]+=sizeof(${$t_name[3]}[$classid][$p]);
			$all_[4][$p]+=sizeof(${$t_name[4]}[$classid][$p]);
			$all_[5][$p]+=sizeof(${$t_name[5]}[$classid][$p]);
			$all_[6][$p]+=sizeof(${$t_name[6]}[$classid][$p]);
			}		      					      
 //平均分成绩输出
 $avage_yw=number_format($total[$classid][yw]/$j,2);
 $avage_sx=number_format($total[$classid][sx]/$j,2);
 $avage_wy=number_format($total[$classid][wy]/$j,2);
 $avage_kx=number_format($total[$classid][kx]/$j,2);
 $avage_sz=number_format($total[$classid][sz]/$j,2);
 $avage_ls=number_format($total[$classid][ls]/$j,2);
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".平均分."</td>
				    		 	<td  class=td1>".$avage_yw."</td>
						   	  <td  class=td1>".$avage_sx."</td>
					  		  <td  class=td1>".$avage_wy."</td>
					  		  <td  class=td1>".$avage_kx."</td>
					  		  <td  class=td1>".$avage_sz."</td>
					  		  <td  class=td1>".$avage_ls."</td>
					      </tr>";
 //最高分
 rsort($yw[$classid]);
 rsort($sx[$classid]);
 rsort($wy[$classid]);
 rsort($kx[$classid]);
 rsort($sz[$classid]);
 rsort($ls[$classid]);
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>最高分</td>
				    		 	<td  class=td1>".$yw[$classid][0]."</td>
						   	  <td  class=td1>".$sx[$classid][0]."</td>
					  		  <td  class=td1>".$wy[$classid][0]."</td>
					  		  <td  class=td1>".$kx[$classid][0]."</td>
					  		  <td  class=td1>".$sz[$classid][0]."</td>
					  		  <td  class=td1>".$ls[$classid][0]."</td>
					      </tr>";
//年级最高分					      
$all_max[1][]=$yw[$classid][0];
$all_max[2][]=$sx[$classid][0];
$all_max[3][]=$wy[$classid][0];					      
$all_max[4][]=$kx[$classid][0];
$all_max[5][]=$sz[$classid][0];
$all_max[6][]=$ls[$classid][0];
 //最低分		
 $j-=1;
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>最低分</td>
				    		 	<td  class=td1>".$yw[$classid][$j]."</td>
						   	  <td  class=td1>".$sx[$classid][$j]."</td>
					  		  <td  class=td1>".$wy[$classid][$j]."</td>
					  		  <td  class=td1>".$kx[$classid][$j]."</td>
					  		  <td  class=td1>".$sz[$classid][$j]."</td>
					  		  <td  class=td1>".$ls[$classid][$j]."</td>
					      </tr>";			
//年级最低分					      
$all_mix[1][]=$yw[$classid][$j];
$all_mix[2][]=$sx[$classid][$j];
$all_mix[3][]=$wy[$classid][$j];					      
$all_mix[4][]=$kx[$classid][$j];
$all_mix[5][]=$sz[$classid][$j];
$all_mix[6][]=$ls[$classid][$j];					            
 //html代码
  $table_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";				       
}//end foreach
//设置年级学科成绩统计输出
//html代码
$class_show="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1(0);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>整个年级</STRONG></FONT></TD>".$class_show;
$t_show="<TBODY id=Tabs1>
           <TR>
             <TD class=menu_tdbg vAlign=top align=left height=180>               
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>	
					       </tr>";     
//学科成绩分段输出
for ($p=12;$p>=1;$p--) {       
      $t_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".$result_d[$p]."</td>
				    		 	<td  class=td1>".$all_[1][$p]."</td>
						   	  <td  class=td1>".$all_[2][$p]."</td>
					  		  <td  class=td1>".$all_[3][$p]."</td>
					  		  <td  class=td1>".$all_[4][$p]."</td>
					  		  <td  class=td1>".$all_[5][$p]."</td>
					  		  <td  class=td1>".$all_[6][$p]."</td>
					      </tr>";
			}	
 //年级平均分成绩输出
 $avage_yw=number_format($all_1/$all_num,2);
 $avage_sx=number_format($all_2/$all_num,2);
 $avage_wy=number_format($all_3/$all_num,2);
 $avage_kx=number_format($all_4/$all_num,2);
 $avage_sz=number_format($all_5/$all_num,2);
 $avage_ls=number_format($all_6/$all_num,2);
 $t_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".平均分."</td>
				    		 	<td  class=td1>".$avage_yw."</td>
						   	  <td  class=td1>".$avage_sx."</td>
					  		  <td  class=td1>".$avage_wy."</td>
					  		  <td  class=td1>".$avage_kx."</td>
					  		  <td  class=td1>".$avage_sz."</td>
					  		  <td  class=td1>".$avage_ls."</td>
					      </tr>";				
//年级最高分					      
rsort($all_max[1]);
rsort($all_max[2]);
rsort($all_max[3]);
rsort($all_max[4]);
rsort($all_max[5]);
rsort($all_max[6]);
$t_show.="
      <tr  align=center>
				   <td   idth=15% height=24 class=td1>最高分</td>
				   <td  class=td1>".$all_max[1][0]."</td>
					 <td  class=td1>".$all_max[2][0]."</td>
					 <td  class=td1>".$all_max[3][0]."</td>
					 <td  class=td1>".$all_max[4][0]."</td>
					 <td  class=td1>".$all_max[5][0]."</td>
					 <td  class=td1>".$all_max[6][0]."</td>
			</tr>";	
//最低分
sort($all_mix[1]);
sort($all_mix[2]);
sort($all_mix[3]);
sort($all_mix[4]);
sort($all_mix[5]);
sort($all_mix[6]);
$t_show.="
      <tr  align=center>
				   <td   idth=15% height=24 class=td1>最低分</td>
				   <td  class=td1>".$all_mix[1][0]."</td>
					 <td  class=td1>".$all_mix[2][0]."</td>
					 <td  class=td1>".$all_mix[3][0]."</td>
					 <td  class=td1>".$all_mix[4][0]."</td>
					 <td  class=td1>".$all_mix[5][0]."</td>
					 <td  class=td1>".$all_mix[6][0]."</td>
			</tr>";							
//html代码			
$t_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";
$table_show=$t_show.$table_show;              
break;
/*****************************学科成绩统计******************************************/
case 'csout':
//数据读取
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//所有学生人数
$all_num=$r[0];
//各科所有成绩和
$all_[1]=$r[1];
$all_[2]=$r[2];
$all_[3]=$r[3];
$all_[4]=$r[4];
$all_[5]=$r[5];
$all_[6]=$r[6];
//数据读取
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
$classid=substr($r[stnumber],0,6);	
$resultarr[1][$classid][]=$r[yw];
$resultarr[2][$classid][]=$r[sx];
$resultarr[3][$classid][]=$r[wy];
$resultarr[4][$classid][]=$r[kx];
$resultarr[5][$classid][]=$r[sz];
$resultarr[6][$classid][]=$r[ls];
$classbuildtime[$classid]=$r[buildtime];
}
//按学科统计
foreach($resultarr as $key => $arr){ 
	  $subjectid=$key; 
	  $s=0;           
		//按班级统计			       
    foreach ($arr as $key => $arr2){
  	//班级id 	
	  $classid=$key;
	  $classid_arr[$classid]=$classid;
	  //名次和班级人数计数		       
	  $j=0;
	  $s++;
    //班级成绩分段统计  	   
    foreach($arr2 as $value)  {
    //本班输出成绩信息
    $j++;
    //学科班级总分    
    $total[$subjectid][$classid]+=$value;
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
        if ($value>=0 and $value<10)
               $type_[$subjectid][1][$classid][]=$value;
        elseif ($value>=10 and $value<20)
                $type_[$subjectid][2][$classid][]=$value;
        elseif ($value>=20 and $value<30)
                $type_[$subjectid][3][$classid][]=$value;
        elseif ($value>=30 and $value<40)
                $type_[$subjectid][4][$classid][]=$value;
        elseif ($value>=40 and $value<50)
                $type_[$subjectid][5][$classid][]=$value;
        elseif ($value>=50 and $value<60)
                $type_[$subjectid][6][$classid][]=$value;
        elseif ($value>=60 and $value<70)
                $type_[$subjectid][7][$classid][]=$value;
        elseif ($value>=70 and $value<80)
                $type_[$subjectid][8][$classid][]=$value;
        elseif ($value>=80 and $value<85)
                $type_[$subjectid][9][$classid][]=$value;
        elseif ($value>=85 and $value<90)
                $type_[$subjectid][10][$classid][]=$value;
        elseif ($value>=90 and $value<100)
                $type_[$subjectid][11][$classid][]=$value;
        elseif ($value==100)
                $type_[$subjectid][12][$classid][]=$value;
     }//end foreach
     //最高分
     rsort($arr2);
     $max_[$subjectid][$classid]=$arr2[0];
     //最低分
     sort($arr2);
     $mix_[$subjectid][$classid]=$arr2[0];
     //平均分
     $avage_[$subjectid][$classid]=number_format($total[$subjectid][$classid]/$j,2);
  }//end foreach   
  //班级数
  $max_class=$s; 
}//end foreach
//设置年级学科成绩统计输出
//参数设置
$colid=0;
$subjectname=array("","语 文","数 学","外 语","科 学","思 政","历 社");
//设置班级参数
foreach($classid_arr as $arr) $t_classid_arr[]=$arr;
reset($resultarr);
//按学科统计
foreach($resultarr as $key => $arr){ 
	    $subjectid=$key;            
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$subjectname[$subjectid]</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$subjectname[$subjectid]</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    $table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
				    		 	<td   class=tr_head>整个年级</td>
						   	  ";
		 //班级名称输出			       
     foreach ($arr as $key => $arr2){
  	  //班级id 	
	    $classid=$key;
			//名次和班级人数计数		       
	    $j=0;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
      $table_show.="   <td  class=tr_head>$classname</td>"; 	  
      }//end foreach 班级名称输出
    $table_show.="</tr>" ; 
    //班级成绩分段统计
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
    $result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");           
    for ($i=12;$i>=1;$i--){ 
    	   $table_show.="   <tr><td  class=td1 align=center height=20>".$result_d[$i]."</td>";
    		 $t_endid=sizeof($t_classid_arr); 
    	   for ($q=0;$q<$t_endid;$q++){	 
            $t_numb=sizeof($type_[$subjectid][$i][$t_classid_arr[$q]]);
      	    if (empty($t_numb)) $t_numb=0;
      	    $all_d[$subjectid][$i]+=$t_numb;
            $t_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
         }
         $table_show.= "<td  class=td1 align=center>".$all_d[$subjectid][$i]."</td>".$t_show;
         $t_show="";
     	   $table_show.="	</tr>	" ; 
    }
    //最高分 
    $table_show.="   <tr><td  class=td1 align=center height=20>最高分</td>";
    $t_endid=sizeof($t_classid_arr); 
    $t_max=0;
    for ($q=0;$q<$t_endid;$q++){	 
         $t_numb=$max_[$subjectid][$t_classid_arr[$q]];
         $t_show.="   <td  class=td1 align=center>$t_numb</td>";
         if($t_numb>$t_max)$t_max=$t_numb;     	 
     }
     $table_show.= "<td  class=td1 align=center>$t_max</td>".$t_show;
     $t_show="";
     $table_show.="	</tr>	" ; 
     //最低分   
     $table_show.="   <tr><td  class=td1 align=center height=20>最低分</td>";
     $t_endid=sizeof($t_classid_arr); 
     $t_mix=100;
     for ($q=0;$q<$t_endid;$q++){	 
          $t_numb=$mix_[$subjectid][$t_classid_arr[$q]];
          $t_show.="   <td  class=td1 align=center>$t_numb</td>"; 
          if($t_numb<$t_mix)$t_mix=$t_numb; 	 
     }
     $table_show.= "<td  class=td1 align=center>$t_mix</td>".$t_show;
     $t_show="";
     $table_show.="	</tr>	" ;
     // 平均分	  
     $table_show.="   <tr><td  class=td1 align=center height=20>平均分</td>";
     $t_numb=number_format($all_[$subjectid]/$all_num,2);
     $table_show.="<td  class=td1 align=center>".$t_numb."</td>"; 
     $t_endid=sizeof($t_classid_arr); 
     for ($q=0;$q<$t_endid;$q++){	 
           $t_numb=$avage_[$subjectid][$t_classid_arr[$q]];
          $table_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
     }
     $table_show.="	</tr>	" ; 	   	   
     //html参数 
     $table_show.="</tbody></table></TD></TR></TBODY>";
}//end foreach
break;
//*************************************班级20%成绩统计**********************************/
case 'sout20':
//数据读取
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//所有学生人数
$all_num=$r[0];
//各科所有成绩和
$all_1=$r[1];
$all_2=$r[2];
$all_3=$r[3];
$all_4=$r[4];
$all_5=$r[5];
$all_6=$r[6];
//年级名次初始化
$i=1;
//数据读取
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
$classid=substr($r[stnumber],0,6);
//成绩分门类存放--0总分-1语文-2数学-3外语-4科学-5思政-6历社
$subject[0][$r[stnumber]]=$r[cjsum];
$subject[1][$r[stnumber]]=$r[yw];	
$subject[2][$r[stnumber]]=$r[sx];
$subject[3][$r[stnumber]]=$r[wy];
$subject[4][$r[stnumber]]=$r[kx];
$subject[5][$r[stnumber]]=$r[sz];
$subject[6][$r[stnumber]]=$r[ls];
//学生信息表--学号-姓名-年级名次
$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[name],$i);
//班级信息
$class_arr[$classid]=$classid;
$classbuildtime[$classid]=$r[buildtime];
$i++;
}   
//班级排序
asort($class_arr);
//参数设置
$colid=1;
//数据输出
foreach($class_arr as $key => $arr){   
         
      //班级id 	
	    $classid=$key;
	    $arr=$st_arr[$classid];
			//名次和班级人数计数		       
	    $j=0;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$classname</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    	$table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>	
					       </tr>";
	//总分和学科最高分
	$temp_arr=$subject;
	for ($e=0;$e<=6;$e++){
		   //排序大到小
	     rsort($temp_arr[$e]);
	     //最高分数值
	     $subject_max[$e]=current($temp_arr[$e]);
	     end($temp_arr[$e]);
	     //最低分数值
	     $subject_mix[$e]=current($temp_arr[$e]);
	     $temp_i=($subject_max[$e]-$subject_mix[$e])/5;
	     $temp_i=number_format($temp_i, 1);
	     $subject_20_[$e][0]=$subject_max[$e];
	     $subject_20_[$e][1]=$subject_20_[$e][0]-$temp_i;
	     $subject_20_[$e][2]=$subject_20_[$e][1]-$temp_i;
	     $subject_20_[$e][3]=$subject_20_[$e][2]-$temp_i;
	     $subject_20_[$e][4]=$subject_20_[$e][3]-$temp_i;
	     $subject_20_[$e][5]=$subject_mix[$e];
	     $temp_1=round($subject_20_[$e][1]);
	     if ($temp_1>$subject_20[$e][1])  $temp_2= $temp_1-0.5;
	                                 else {$temp_2=$temp_1;$temp_1+=0.5;}
	                                 
	     $temp_3=round($subject_20_[$e][2]);
	     if ($temp_3>$subject_20[$e][2])  $temp_4= $temp_3-0.5;
	                                 else {$temp_4=$temp_3;$temp_3+=0.5;}
	                                 
	     $temp_5=round($subject_20_[$e][3]);
	     if ($temp_5>$subject_20[$e][3])  $temp_6= $temp_5-0.5;
	                                 else {$temp_6=$temp_5;$temp_5+=0.5;}
	                                 
	     $temp_7=round($subject_20_[$e][4]);
	     if ($temp_7>$subject_20[$e][4])  $temp_8= $temp_7-0.5;
	                                 else {$temp_8=$temp_7;$temp_7+=0.5;}
	     $subject_20_title[$e]=array("",$subject_20_[$e][0]."-".$temp_1,$temp_2."-".$temp_3,"$temp_4-$temp_5","$temp_6-$temp_7","$temp_8-".$subject_20_[$e][5]);
       unset($temp_i,$temp_1,$temp_2,$temp_3,$temp_4,$temp_5,$temp_6,$temp_7,$temp_8);
       }			       
    $s=0;  
	//本班成绩分段统计20%(最高分和最低分差除以5)			       				       
  foreach ($st_arr[$classid] as $key => $value){
    //学生学号
   $stnumber=$key;
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
   echo "$key=";
    $s++;
    for ($i=1;$i<=6;$i++)
        if ($subject[$i][$stnumber]>=$subject_20_[$i][6] and $subject[$i][$stnumber]< $subject_20_[$e][5])
            echo   $subject_20_result[$i][$classid][1][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=$subject_20_[$i][5] and $subject[$i][$stnumber]< $subject_20_[$i][4])
           echo     $subject_20_result[$i][$classid][2][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=$subject_20_[$i][4] and $subject[$i][$stnumber]< $subject_20_[$i][3])
           echo     $subject_20_result[$i][$classid][3][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=$subject_20_[$i][3] and $subject[$i][$stnumber]< $subject_20_[$i][2])
           echo     $subject_20_result[$i][$classid][4][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=$subject_20_[$i][2] and $subject[$i][$stnumber]< $subject_20_[$i][1])
           echo     $subject_20_result[$i][$classid][5][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=$subject_20_[$i][1] and $subject[$i][$stnumber]< $subject_20_[$i][0])
          echo      $subject_20_result[$i][$classid][6][]=$subject[$i][$stnumber];
    echo "<br>";
    $j++;
    //班级学科总分    
    $total[$classid][yw]+=$subject[1][$stnumber];
    $total[$classid][sx]+=$subject[2][$stnumber];
    $total[$classid][wy]+=$subject[3][$stnumber];
    $total[$classid][kx]+=$subject[4][$stnumber];
    $total[$classid][sz]+=$subject[5][$stnumber];
    $total[$classid][ls]+=$subject[6][$stnumber];
    //按学科分类存放
    $yw[$classid][]=$subject[1][$stnumber];
    $sx[$classid][]=$subject[2][$stnumber];
    $wy[$classid][]=$subject[3][$stnumber];
    $kx[$classid][]=$subject[4][$stnumber];
    $sz[$classid][]=$subject[5][$stnumber];
    $ls[$classid][]=$subject[6][$stnumber];
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
    $t_name=array(" ","type_yw","type_sx","type_wy","type_ke","type_sz","type_ls");
    for ($i=1;$i<=6;$i++)
        if ($subject[$i][$stnumber]>=0 and $subject[$i][$stnumber]<10)
               ${$t_name[$i]}[$classid][1][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=10 and $subject[$i][$stnumber]<20)
                ${$t_name[$i]}[$classid][2][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=20 and $subject[$i][$stnumber]<30)
                ${$t_name[$i]}[$classid][3][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=30 and $subject[$i][$stnumber]<40)
                ${$t_name[$i]}[$classid][4][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=40 and $subject[$i][$stnumber]<50)
                ${$t_name[$i]}[$classid][5][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=50 and $subject[$i][$stnumber]<60)
                ${$t_name[$i]}[$classid][6][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=60 and $subject[$i][$stnumber]<70)
                ${$t_name[$i]}[$classid][7][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=70 and $subject[$i][$stnumber]<80)
                ${$t_name[$i]}[$classid][8][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=80 and $subject[$i][$stnumber]<85)
                ${$t_name[$i]}[$classid][9][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=85 and $subject[$i][$stnumber]<90)
                ${$t_name[$i]}[$classid][10][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]>=90 and $subject[$i][$stnumber]<100)
                ${$t_name[$i]}[$classid][11][]=$subject[$i][$stnumber];
        elseif ($subject[$i][$stnumber]==100)
                ${$t_name[$i]}[$classid][12][]=$subject[$i][$stnumber];
  }//end foreach

  //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100         
  //学科成绩分段输出
  for ($i=1;$i<=5;$i++) {       
      $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".$subject_20_title[1][$i]."</td>
				    		 	<td  class=td1>".sizeof($subject_20_result[$i][$classid][1])."</td>
						   	  <td  class=td1>".sizeof($subject_20_result[$i][$classid][2])."</td>
					  		  <td  class=td1>".sizeof($subject_20_result[$i][$classid][3])."</td>
					  		  <td  class=td1>".sizeof($subject_20_result[$i][$classid][4])."</td>
					  		  <td  class=td1>".sizeof($subject_20_result[$i][$classid][5])."</td>
					  		  <td  class=td1>".sizeof($subject_20_result[$i][$classid][6])."</td>
					      </tr>";
			//年级学科分段		      
			$all_[1][$p]+=sizeof(${$t_name[1]}[$classid][$p]);
			$all_[2][$p]+=sizeof(${$t_name[2]}[$classid][$p]);
			$all_[3][$p]+=sizeof(${$t_name[3]}[$classid][$p]);
			$all_[4][$p]+=sizeof(${$t_name[4]}[$classid][$p]);
			$all_[5][$p]+=sizeof(${$t_name[5]}[$classid][$p]);
			$all_[6][$p]+=sizeof(${$t_name[6]}[$classid][$p]);
			}		    
	//学科成绩20%分段统计
  $result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");           
  //学科成绩分段输出
  for ($p=12;$p>=1;$p--) {       
      $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".$result_d[$p]."</td>
				    		 	<td  class=td1>".sizeof(${$t_name[1]}[$classid][$p])."</td>
						   	  <td  class=td1>".sizeof(${$t_name[2]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[3]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[4]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[5]}[$classid][$p])."</td>
					  		  <td  class=td1>".sizeof(${$t_name[6]}[$classid][$p])."</td>
					      </tr>";
			//年级学科分段		      
			$all_[1][$p]+=sizeof(${$t_name[1]}[$classid][$p]);
			$all_[2][$p]+=sizeof(${$t_name[2]}[$classid][$p]);
			$all_[3][$p]+=sizeof(${$t_name[3]}[$classid][$p]);
			$all_[4][$p]+=sizeof(${$t_name[4]}[$classid][$p]);
			$all_[5][$p]+=sizeof(${$t_name[5]}[$classid][$p]);
			$all_[6][$p]+=sizeof(${$t_name[6]}[$classid][$p]);
			}		   					      
 //平均分成绩输出
 $avage_yw=number_format($total[$classid][yw]/$j,2);
 $avage_sx=number_format($total[$classid][sx]/$j,2);
 $avage_wy=number_format($total[$classid][wy]/$j,2);
 $avage_kx=number_format($total[$classid][kx]/$j,2);
 $avage_sz=number_format($total[$classid][sz]/$j,2);
 $avage_ls=number_format($total[$classid][ls]/$j,2);
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".平均分."</td>
				    		 	<td  class=td1>".$avage_yw."</td>
						   	  <td  class=td1>".$avage_sx."</td>
					  		  <td  class=td1>".$avage_wy."</td>
					  		  <td  class=td1>".$avage_kx."</td>
					  		  <td  class=td1>".$avage_sz."</td>
					  		  <td  class=td1>".$avage_ls."</td>
					      </tr>";
 //最高分
 rsort($yw[$classid]);
 rsort($sx[$classid]);
 rsort($wy[$classid]);
 rsort($kx[$classid]);
 rsort($sz[$classid]);
 rsort($ls[$classid]);
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>最高分</td>
				    		 	<td  class=td1>".$yw[$classid][0].$subject_max[1]."</td>
						   	  <td  class=td1>".$sx[$classid][0]."</td>
					  		  <td  class=td1>".$wy[$classid][0]."</td>
					  		  <td  class=td1>".$kx[$classid][0]."</td>
					  		  <td  class=td1>".$sz[$classid][0]."</td>
					  		  <td  class=td1>".$ls[$classid][0]."</td>
					      </tr>";
//年级最高分					      
$all_max[1][]=$yw[$classid][0];
$all_max[2][]=$sx[$classid][0];
$all_max[3][]=$wy[$classid][0];					      
$all_max[4][]=$kx[$classid][0];
$all_max[5][]=$sz[$classid][0];
$all_max[6][]=$ls[$classid][0];
 //最低分		
 $j-=1;
 $table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>最低分</td>
				    		 	<td  class=td1>".$yw[$classid][$j].$subject_mix[1]."</td>
						   	  <td  class=td1>".$sx[$classid][$j]."</td>
					  		  <td  class=td1>".$wy[$classid][$j]."</td>
					  		  <td  class=td1>".$kx[$classid][$j]."</td>
					  		  <td  class=td1>".$sz[$classid][$j]."</td>
					  		  <td  class=td1>".$ls[$classid][$j]."</td>
					      </tr>";			
//年级最低分					      
$all_mix[1][]=$yw[$classid][$j];
$all_mix[2][]=$sx[$classid][$j];
$all_mix[3][]=$wy[$classid][$j];					      
$all_mix[4][]=$kx[$classid][$j];
$all_mix[5][]=$sz[$classid][$j];
$all_mix[6][]=$ls[$classid][$j];					            
 //html代码
  $table_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";				       
}//end foreach
//设置年级学科成绩统计输出
//html代码
$class_show="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1(0);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>整个年级</STRONG></FONT></TD>".$class_show;
$t_show="<TBODY id=Tabs1>
           <TR>
             <TD class=menu_tdbg vAlign=top align=left height=180>               
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
						   	  <td  class=tr_head>语文</td>
					  		  <td  class=tr_head>数学</td>
					  		  <td  class=tr_head>外语</td>
					  		  <td  class=tr_head>科学</td>
					  		  <td  class=tr_head>思政</td>
					  		  <td  class=tr_head>历社</td>	
					       </tr>";     
//学科成绩分段输出
for ($p=12;$p>=1;$p--) {       
      $t_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".$result_d[$p]."</td>
				    		 	<td  class=td1>".$all_[1][$p]."</td>
						   	  <td  class=td1>".$all_[2][$p]."</td>
					  		  <td  class=td1>".$all_[3][$p]."</td>
					  		  <td  class=td1>".$all_[4][$p]."</td>
					  		  <td  class=td1>".$all_[5][$p]."</td>
					  		  <td  class=td1>".$all_[6][$p]."</td>
					      </tr>";
			}	
 //年级平均分成绩输出
 $avage_yw=number_format($all_1/$all_num,2);
 $avage_sx=number_format($all_2/$all_num,2);
 $avage_wy=number_format($all_3/$all_num,2);
 $avage_kx=number_format($all_4/$all_num,2);
 $avage_sz=number_format($all_5/$all_num,2);
 $avage_ls=number_format($all_6/$all_num,2);
 $t_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>".平均分."</td>
				    		 	<td  class=td1>".$avage_yw."</td>
						   	  <td  class=td1>".$avage_sx."</td>
					  		  <td  class=td1>".$avage_wy."</td>
					  		  <td  class=td1>".$avage_kx."</td>
					  		  <td  class=td1>".$avage_sz."</td>
					  		  <td  class=td1>".$avage_ls."</td>
					      </tr>";				
//年级最高分					      
rsort($all_max[1]);
rsort($all_max[2]);
rsort($all_max[3]);
rsort($all_max[4]);
rsort($all_max[5]);
rsort($all_max[6]);
$t_show.="
      <tr  align=center>
				   <td   idth=15% height=24 class=td1>最高分</td>
				   <td  class=td1>".$all_max[1][0]."</td>
					 <td  class=td1>".$all_max[2][0]."</td>
					 <td  class=td1>".$all_max[3][0]."</td>
					 <td  class=td1>".$all_max[4][0]."</td>
					 <td  class=td1>".$all_max[5][0]."</td>
					 <td  class=td1>".$all_max[6][0]."</td>
			</tr>";	
//最低分
sort($all_mix[1]);
sort($all_mix[2]);
sort($all_mix[3]);
sort($all_mix[4]);
sort($all_mix[5]);
sort($all_mix[6]);
$t_show.="
      <tr  align=center>
				   <td   idth=15% height=24 class=td1>最低分</td>
				   <td  class=td1>".$all_mix[1][0]."</td>
					 <td  class=td1>".$all_mix[2][0]."</td>
					 <td  class=td1>".$all_mix[3][0]."</td>
					 <td  class=td1>".$all_mix[4][0]."</td>
					 <td  class=td1>".$all_mix[5][0]."</td>
					 <td  class=td1>".$all_mix[6][0]."</td>
			</tr>";							
//html代码			
$t_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";
$table_show=$t_show.$table_show;              
break;
/*****************************学科成绩20%统计******************************************/
case 'csout20':
//数据读取
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//所有学生人数
$all_num=$r[0];
//各科所有成绩和
$all_[1]=$r[1];
$all_[2]=$r[2];
$all_[3]=$r[3];
$all_[4]=$r[4];
$all_[5]=$r[5];
$all_[6]=$r[6];
//数据读取
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
//班级编号	
$classid=substr($r[stnumber],0,6);	
//成绩分门类存放--0总分-1语文-2数学-3外语-4科学-5思政-6历社
$subject[0][$r[stnumber]]=$r[cjsum];
$subject[1][$r[stnumber]]=$r[yw];	
$subject[2][$r[stnumber]]=$r[sx];
$subject[3][$r[stnumber]]=$r[wy];
$subject[4][$r[stnumber]]=$r[kx];
$subject[5][$r[stnumber]]=$r[sz];
$subject[6][$r[stnumber]]=$r[ls];
//学生信息表--学号-姓名-年级名次
$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[name]);
//班级信息
$class_arr[$classid]=$classid;
$classbuildtime[$classid]=$r[buildtime];
}
//按学科统计
foreach($resultarr as $key => $arr){ 
	  $subjectid=$key; 
	  $s=0;           
		//按班级统计			       
    foreach ($arr as $key => $arr2){
  	//班级id 	
	  $classid=$key;
	  $classid_arr[$classid]=$classid;
	  //名次和班级人数计数		       
	  $j=0;
	  $s++;
    //班级成绩分段统计  	   
    foreach($arr2 as $value)  {
    //本班输出成绩信息
    $j++;
    //学科班级总分    
    $total[$subjectid][$classid]+=$value;
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
        if ($value>=0 and $value<10)
               $type_[$subjectid][1][$classid][]=$value;
        elseif ($value>=10 and $value<20)
                $type_[$subjectid][2][$classid][]=$value;
        elseif ($value>=20 and $value<30)
                $type_[$subjectid][3][$classid][]=$value;
        elseif ($value>=30 and $value<40)
                $type_[$subjectid][4][$classid][]=$value;
        elseif ($value>=40 and $value<50)
                $type_[$subjectid][5][$classid][]=$value;
        elseif ($value>=50 and $value<60)
                $type_[$subjectid][6][$classid][]=$value;
        elseif ($value>=60 and $value<70)
                $type_[$subjectid][7][$classid][]=$value;
        elseif ($value>=70 and $value<80)
                $type_[$subjectid][8][$classid][]=$value;
        elseif ($value>=80 and $value<85)
                $type_[$subjectid][9][$classid][]=$value;
        elseif ($value>=85 and $value<90)
                $type_[$subjectid][10][$classid][]=$value;
        elseif ($value>=90 and $value<100)
                $type_[$subjectid][11][$classid][]=$value;
        elseif ($value==100)
                $type_[$subjectid][12][$classid][]=$value;
     }//end foreach
     //最高分
     rsort($arr2);
     $max_[$subjectid][$classid]=$arr2[0];
     //最低分
     sort($arr2);
     $mix_[$subjectid][$classid]=$arr2[0];
     //平均分
     $avage_[$subjectid][$classid]=number_format($total[$subjectid][$classid]/$j,2);
  }//end foreach   
  //班级数
  $max_class=$s; 
}//end foreach
//设置年级学科成绩统计输出
//参数设置
$colid=0;
$subjectname=array("","语 文","数 学","外 语","科 学","思 政","历 社");
//设置班级参数
foreach($classid_arr as $arr) $t_classid_arr[]=$arr;
reset($resultarr);
//按学科统计
foreach($resultarr as $key => $arr){ 
	    $subjectid=$key;            
     	if ($colid==0){
	    $class_show.="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$subjectname[$subjectid]</STRONG></FONT></TD>";
	    $table_show.="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";     
	              }else {
	              	    $class_show.="<TD class=main_menu_title1 id=TabTitle1 onmousedown=javascript:ShowTabs1($colid); 
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>$subjectname[$subjectid]</STRONG></FONT></TD>";
	              	    $table_show.="<TBODY id=Tabs1  style=\"DISPLAY: none\">
                                    <TR>
                                     <TD class=menu_tdbg vAlign=top align=left height=180>
	                    ";
	                    };
	    $colid++;    	 
	    $table_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>成绩分段</td>
				    		 	<td   class=tr_head>整个年级</td>
						   	  ";
		 //班级名称输出			       
     foreach ($arr as $key => $arr2){
  	  //班级id 	
	    $classid=$key;
			//名次和班级人数计数		       
	    $j=0;
		  //班级
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //毕业时间
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
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
      $table_show.="   <td  class=tr_head>$classname</td>"; 	  
      }//end foreach 班级名称输出
    $table_show.="</tr>" ; 
    //班级成绩分段统计
    //学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
    $result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");           
    for ($i=12;$i>=1;$i--){ 
    	   $table_show.="   <tr><td  class=td1 align=center height=20>".$result_d[$i]."</td>";
    		 $t_endid=sizeof($t_classid_arr); 
    	   for ($q=0;$q<$t_endid;$q++){	 
            $t_numb=sizeof($type_[$subjectid][$i][$t_classid_arr[$q]]);
      	    if (empty($t_numb)) $t_numb=0;
      	    $all_d[$subjectid][$i]+=$t_numb;
            $t_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
         }
         $table_show.= "<td  class=td1 align=center>".$all_d[$subjectid][$i]."</td>".$t_show;
         $t_show="";
     	   $table_show.="	</tr>	" ; 
    }
    //最高分 
    $table_show.="   <tr><td  class=td1 align=center height=20>最高分</td>";
    $t_endid=sizeof($t_classid_arr); 
    $t_max=0;
    for ($q=0;$q<$t_endid;$q++){	 
         $t_numb=$max_[$subjectid][$t_classid_arr[$q]];
         $t_show.="   <td  class=td1 align=center>$t_numb</td>";
         if($t_numb>$t_max)$t_max=$t_numb;     	 
     }
     $table_show.= "<td  class=td1 align=center>$t_max</td>".$t_show;
     $t_show="";
     $table_show.="	</tr>	" ; 
     //最低分   
     $table_show.="   <tr><td  class=td1 align=center height=20>最低分</td>";
     $t_endid=sizeof($t_classid_arr); 
     $t_mix=100;
     for ($q=0;$q<$t_endid;$q++){	 
          $t_numb=$mix_[$subjectid][$t_classid_arr[$q]];
          $t_show.="   <td  class=td1 align=center>$t_numb</td>"; 
          if($t_numb<$t_mix)$t_mix=$t_numb; 	 
     }
     $table_show.= "<td  class=td1 align=center>$t_mix</td>".$t_show;
     $t_show="";
     $table_show.="	</tr>	" ;
     // 平均分	  
     $table_show.="   <tr><td  class=td1 align=center height=20>平均分</td>";
     $t_numb=number_format($all_[$subjectid]/$all_num,2);
     $table_show.="<td  class=td1 align=center>".$t_numb."</td>"; 
     $t_endid=sizeof($t_classid_arr); 
     for ($q=0;$q<$t_endid;$q++){	 
           $t_numb=$avage_[$subjectid][$t_classid_arr[$q]];
          $table_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
     }
     $table_show.="	</tr>	" ; 	   	   
     //html参数 
     $table_show.="</tbody></table></TD></TR></TBODY>";
}//end foreach
break;
}
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=result&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
      	   <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>学生成绩管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> <A  
      href="?filename=result&action=up">学生成绩发布</A> | <A 
      href="?filename=result&action=list">学生成绩列表</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE>
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=middle>
      <td  height="24"><strong>当前位置：学生成绩管理 >> 
      	              <a href="?filename=tongji&action=listone&id=<?=$id;?>" >查看</a> | 
				              <a href="?filename=tongji&action=cout&id=<?=$id;?>" > 班级排名统计</a> |
				              <a href="?filename=tongji&action=sout&id=<?=$id;?>" > 班级成绩统计</a> | 
				              <a href="?filename=tongji&action=csout&id=<?=$id;?>" > 学科成绩统计</a> |</strong></td>
     </tr>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
      <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>
              <TBODY>         
              <SCRIPT language=JavaScript> 
                        var aID=0;
                        function ShowTabs1(ID){
                        if(ID!=aID){
                             TabTitle1[aID].className="main_menu_title1";
                             TabTitle1[ID].className="main_menu_title2";
                             Tabs1[aID].style.display="none";
                             Tabs1[ID].style.display="block";
                             aID=ID;
                             }
                        }
              </SCRIPT>
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