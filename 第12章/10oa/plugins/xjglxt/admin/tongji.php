<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//生成word文件
function toword($pcontent)
{   
	ob_start();
	$mime_type="text/x-sql";
	$content_encoding="";
	$PMA_USR_BROWSER_AGENT="IE";
	//$filename="email.txt";// $filename="email.txt";
	//$sqldump=t3lib_div::_GP("sqldump");
	//$pcontent=$sqldump;
	//$filename="companyinfo".time().".XLS";
	$filename="resume_".time().".doc";
	ob_end_clean();
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: no-cache");
	header("Content-Encoding: none");
	header("Content-type: text/html; charset=gbk");
	header("Content-Disposition: attachment; filename=".$filename);
	//header("Content-Length: " . strlen($pcontent));
	//header("Content-type: txt");
	header("Content-type:application/vnd.ms-word");
	echo "<TABLE cellSpacing=0 cellPadding=0 width=98% align=center border=0 class=table1>".$pcontent."</table>";
	exit;
}
//用户组权限读取
$sql="select * from userright where rightid=$group_id limit 1";
$result=$db->query($sql);
if($db->affected_rows()!=0){
	$r=$db->fetch_array($result);
	$rights=$r[rights];
	$right=1; //标量
	$rights=explode(":",$rights);
	while (list($key,$tempright)=each($rights)){
		$tempright=explode("|",$tempright);
		$rightlen=sizeof($tempright);
		for ($i=1;$i<=$rightlen;$i++)
		$rightdata[$tempright[0]][]=$tempright[$i];
	}
} else $right=0;
if ($right==0) showmessage("对不起，你没有权限访问！");
//成绩组表
$sql = "SELECT userid,gradeid FROM $table_resultset where id=$id limit 1";
$r = $db->query_first($sql);
$grade_ids=explode(":",$r[gradeid]);
$grade_id=$grade_ids[0];
/************************************************************/
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
switch ($action){
	//***************************************本班学生成绩列表********不排序*******************/
	case 'listone':
		//成绩输入的班级信息
		$sql="SELECT * FROM $table_resultset limit 1";
		$r = $db->query_first($sql);
		$grade_class=$r[gradeid];
		//记录数据的读取
		$i=1;
		$class_style="td1";
		$sql = "SELECT count(*) FROM $table_result where resultid=$id";
		$result = $db->query_first($sql);
		$totalnum=$result[0];
		$query="select  *  from $table_result where resultid='$id' 
            order by id  limit 0,$totalnum";            
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$classid=substr($r[stnumber],0,6);
			//学科成绩信息按[班级][学号]存放:0总分1语文2数学3外语4科学5思政6历社7名次8姓名9序列号
			$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[stname],$r[id]);
			//班级输入时间
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
			$classname=$gradearr[$grade_id].$gradecarr[$class_id];
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
		$query="select *from $table_result
        where resultid='$id' order by cjsum DESC"; 
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$classid=substr($r[stnumber],0,6);
			$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[stname]);
			//$classbuildtime[$classid]=$r[buildtime];
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
			$classname=$gradearr[$grade_id].$gradecarr[$class_id];
			//$classname=$class_id;
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
			$table_show.=	 "<tr  align=center>	
				    		 	<td  width=15% height=24 class=tr_head></td>
				    		 	<td   class=tr_head></td>
				    		 	<td  class=tr_head></td>
						   	    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		 	<td  class=tr_head></td>	
				    		 	<td  class=tr_head></td>		
					       </tr>
					      </tbody>
					      </table>
					    ";
			$table_show.=" </TD></TR></TBODY>";				       
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
		$t_show.=" <tr  align=center>	
				    		 	<td  width=15% height=24 class=tr_head></td>
				    		 	<td   class=tr_head></td>
				    		 	<td  class=tr_head></td>
						   	    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		    <td  class=tr_head></td>
					  		 	<td  class=tr_head></td>	
				    		 	<td  class=tr_head></td>		
					       </tr></tbody>
				</table>
					 ";
		$t_show.=" </TD>
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
		$query="select * from $table_result where resultid='$id' order by cjsum DESC";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$classid=substr($r[stnumber],0,6);
			$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[stname]);
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
			$classname=$gradearr[$grade_id].$gradecarr[$class_id];
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
				    		 	<td   idth=15% height=24 class=td1>平均分</td>
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
				    		 	<td   idth=15% height=24 class=td1>平均分</td>
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
				//每科成绩最高分设置
				$sql="select * from $table_resultset where id=$id";
				$r= $db->query_first($sql);
				$rtype_arr[0]="";
				$rtype_arr=explode(":",$r[rtype]);
				//分数段设置
				$result_type_arr[150]=array('0','44.5','45','59.5','60','74.5','75','89.5','90','104.5','105','119.5','120','127','127.5','134.5','135','149.5','150');
				$result_type_arr[120]=array('0','35.5','36','47.5','48','59.5','60','71.5','72','83.5','84','95.5','96','101.5','102','107.5','108','119.5','120');
				$result_type_arr[110]=array('0','32.5','33','43.5','44','54.5','55','65.5','66','76.5','77','87.5','88','93','93.5','98.5','99','109.5','110');
				$result_type_arr[100]=array('0','29.5','30','39.5','40','49.5','50','59.5','60','69.5','70','79.5','80','84.5','85','89.5','90','99.5','100');
				$result_type_arr[80]=array('0','23.5','24','31.5','32','39.5','40','47.5','48','55.5','56','63.5','64','67.5','68','71.5','72','79.5','80');
				//显示输出
				$result_type_out[150]=array('','0-44.5','45-59.5','60-74.5','75-89.5','90-104.5','105-119.5','120-127','127.5-134.5','135-149.5','150');
				$result_type_out[120]=array('','0-35.5','36-47.5','48-59.5','60-71.5','72-83.5','84-95.5','96-101.5','102-107.5','108-119.5','120');
				$result_type_out[110]=array('','0-32.5','33-43.5','44-54.5','55-65.5','66-76.5','77-87.5','88-93','93.5-98.5','99-109.5','110');
				$result_type_out[100]=array('','0-29.5','30-39.5','40-49.5','50-59.5','60-69.5','70-79.5','80-84.5','85-89.5','90-99.5','100');
				$result_type_out[80]=array('','0-23.5','24-31.5','32-39.5','40-47.5','48-55.5','56-63.5','64-67.5','68-71.5','72-79.5','80');
				//合格、优秀、低分率
				$result_type_s[150]=array('127.5','90','60');
				$result_type_s[120]=array('102','72','48');
				$result_type_s[110]=array('93.5','66','44');
				$result_type_s[100]=array('85','60','40');
				$result_type_s[80]=array('68','48','32');
				//数据读取
				$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls),sum(cjsum) FROM $table_result where resultid=$id";
				$r= $db->query_first($sql);
				//所有学生人数
				$all_num=$r[0];
				//各科所有成绩和
				$all_[0]=$r[7];
				$all_[1]=$r[1];
				$all_[2]=$r[2];
				$all_[3]=$r[3];
				$all_[4]=$r[4];
				$all_[5]=$r[5];
				$all_[6]=$r[6];
				//数据读取
				$query="select * from $table_result where resultid='$id' order by cjsum DESC";
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
					$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[stname]);
					//班级信息
					$class_arr[$classid]=$classid;
				}
				ksort($class_arr);
				//学科信息
				//$subject_arr[0]=0;
				$subject_arr[1]=1;
				$subject_arr[2]=2;
				$subject_arr[3]=3;
				$subject_arr[4]=4;
				$subject_arr[5]=5;
				$subject_arr[6]=6;
				//学科最高分和最低分--20%分数段
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
					// echo $subject_20_[$e][0]."-".$temp_1.",".$temp_2."-".$temp_3.",$temp_4-$temp_5,$temp_6-$temp_7,$temp_8-".$subject_20_[$e][5]."<br>";
					unset($temp_i,$temp_1,$temp_2,$temp_3,$temp_4,$temp_5,$temp_6,$temp_7,$temp_8);
				}
				unset($temp_arr);
				//按学科统计
				foreach($subject_arr as $key){
					$subjectid=$key;
					$subject_t=$key-1;
					$s=0;
					//按班级统计
					foreach ($class_arr as $key2){
						//班级id
						$classid=$key2;
						$classid_arr[$classid]=$classid;
						//名次和班级人数计数
						$j=0;
						$s++;
						//班级总人数
						$class_num_t=count($st_arr[$classid]);
						$class_num_t30=round(number_format($class_num_t*30/100,1));
						//班级成绩分段统计
						$subject_class_max=0;
						$subject_class_mix=100;
						foreach($st_arr[$classid] as $key3=> $value)  {
							//学生编号
							$stnumber=$key3;
							//本班输出成绩信息
							$j++;
							//学科成绩分段统计
							if ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][0] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][1])
							$subject_20_result[$subjectid][$classid][1][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][2] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][3])
							$subject_20_result[$subjectid][$classid][2][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][4] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][5])
							$subject_20_result[$subjectid][$classid][3][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][6] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][7])
							$subject_20_result[$subjectid][$classid][4][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][8] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][9])
							$subject_20_result[$subjectid][$classid][5][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][10] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][11])
							$subject_20_result[$subjectid][$classid][6][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][12] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][13])
							$subject_20_result[$subjectid][$classid][7][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][14] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][15])
							$subject_20_result[$subjectid][$classid][8][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$result_type_arr[$rtype_arr[$subject_t]][16] and $subject[$subjectid][$stnumber]<=$result_type_arr[$rtype_arr[$subject_t]][17])
							$subject_20_result[$subjectid][$classid][9][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]==$result_type_arr[$rtype_arr[$subject_t]][18])
							$subject_20_result[$subjectid][$classid][10][]=$subject[$subjectid][$stnumber];

							//优秀 合格 低分
							if  ($subject[$subjectid][$stnumber]>=$result_type_s[$rtype_arr[$subject_t]][0]) $class_y[$subjectid][$classid]++;
							if  ($subject[$subjectid][$stnumber]>=$result_type_s[$rtype_arr[$subject_t]][1]) $class_h[$subjectid][$classid]++;
							if  ($subject[$subjectid][$stnumber]<$result_type_s[$rtype_arr[$subject_t]][2])  $class_d[$subjectid][$classid]++;
							//班级最高最低分
							if ($subject[$subjectid][$stnumber]> $subject_class_max)
							$subject_class_max=$subject[$subjectid][$stnumber];
							if ($subject[$subjectid][$stnumber]< $subject_class_mix)
							$subject_class_mix=$subject[$subjectid][$stnumber];
							//学科班级总分
							$total_sub[$subjectid][$classid]+=$subject[$subjectid][$stnumber];
							//30%计算
							//if ($j>=);
						}//end foreach
						//年级优秀 合格 低分
						$grade_y[$subjectid]=$grade_y[$subjectid]+$class_y[$subjectid][$classid];
						$grade_h[$subjectid]=$grade_h[$subjectid]+$class_h[$subjectid][$classid];
						$grade_d[$subjectid]=$grade_d[$subjectid]+$class_d[$subjectid][$classid];
						//最大最低初始化
						$subject_class_max_[$subjectid][$classid]=$subject_class_max;
						$subject_class_mix_[$subjectid][$classid]=$subject_class_mix;
						//学科班级平均分
						$avage_[$subjectid][$classid]=number_format($total_sub[$subjectid][$classid]/$j,2);
						//优秀率 合格率 低分率
						$class_y[$subjectid][$classid]=number_format($class_y[$subjectid][$classid]/$j,4)*100;
						$class_h[$subjectid][$classid]=number_format($class_h[$subjectid][$classid]/$j,4)*100;
						$class_d[$subjectid][$classid]=number_format($class_d[$subjectid][$classid]/$j,4)*100;

					}//end foreach
					//echo $total_sub[$subjectid][$classid]."<br>";
					//班级数
					$max_class=$s;
				}//end foreach
				//设置年级学科成绩统计输出
				//参数设置
				$colid=0;
				$subjectname=array("总分","语 文","数 学","外 语","科 学","思 政","历 社");
				//按学科成绩统计输出
				foreach($subject_arr as $key){
					$subjectid=$key;
					$subject_t=$key-1;
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
					//班级信息处理
					foreach ($class_arr as $key2){
						//班级id
						$classid=$key2;
						//名次和班级人数计数
						$j=0;
						//班级
						$class_id=substr($classid,4,2);
						if ($class_id<10)$class_id=substr($class_id,1,1);
						$classname=$gradearr[$grade_id].$gradecarr[$class_id];
						$table_show.="   <td  class=tr_head>$classname</td>";
					}//end foreach 班级名称输出
					reset($class_arr);
					$table_show.="</tr>" ;
					//学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100

					$result_d=array("","0-9.5","10-19.5","20-29.5","30-39.5","40-49.5","50-59.5","60-69.5","70-79.5","80-84.5","85-89.5","90-99.5","100");
					for ($i=10;$i>=1;$i--){
						$table_show.="   <tr><td  class=td1 align=center height=20>".$result_type_out[$rtype_arr[$subject_t]][$i]."</td>";
						foreach ($class_arr as $key2){
							$classid=$key2;
							$t_numb=sizeof($subject_20_result[$subjectid][$classid][$i]);
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
					foreach ($class_arr as $key2){
						$classid=$key2;

						$t_show.="   <td  class=td1 align=center>".$subject_class_max_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_max[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					//最低分
					$table_show.="   <tr><td  class=td1 align=center height=20>最低分</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$t_show.="   <td  class=td1 align=center>".$subject_class_mix_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_mix[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					// 平均分
					$table_show.="   <tr><td  class=td1 align=center height=20>平均分</td>";
					$t_numb=number_format($all_[$subjectid]/$all_num,2);
					$table_show.="<td  class=td1 align=center>".$t_numb."</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$avage_[$subjectid][$classid]."</td>";
					}
					$table_show.="	</tr>	" ;
					// 优秀率
					$table_show.="   <tr><td  class=td1 align=center height=20>优秀率</td>";
					$t_numb=number_format($grade_y[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_y[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					// 合格率
					$table_show.="   <tr><td  class=td1 align=center height=20>合格率</td>";
					$t_numb=number_format($grade_h[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_h[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					// 低分率
					$table_show.="   <tr><td  class=td1 align=center height=20>低分率</td>";
					$t_numb=number_format($grade_d[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_d[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					//html参数
					$table_show.="</tbody></table></TD></TR></TBODY>";
				}//end foreach
				break;

				/*****************************学科成绩20%统计******************************************/
			case 'out20':
				//数据读取
				$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls),sum(cjsum) FROM $table_result where resultid=$id";
				$r= $db->query_first($sql);
				//所有学生人数
				$all_num=$r[0];
				//各科所有成绩和
				$all_[0]=$r[7];
				$all_[1]=$r[1];
				$all_[2]=$r[2];
				$all_[3]=$r[3];
				$all_[4]=$r[4];
				$all_[5]=$r[5];
				$all_[6]=$r[6];
				//数据读取
				$query="select * from $table_result where resultid='$id' order by cjsum DESC";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					//班级编号
					$classid=substr($r[stnumber],0,6);
					//成绩分门类存放一--0总分-1语文-2数学-3外语-4科学-5思政-6历社
					$subject[0][$r[stnumber]]=$r[cjsum];
					$subject[1][$r[stnumber]]=$r[yw];
					$subject[2][$r[stnumber]]=$r[sx];
					$subject[3][$r[stnumber]]=$r[wy];
					$subject[4][$r[stnumber]]=$r[kx];
					$subject[5][$r[stnumber]]=$r[sz];
					$subject[6][$r[stnumber]]=$r[ls];
					//成绩分门类存放二--0总分-1语文-2数学-3外语-4科学-5思政-6历社
					$subject_g[0][]=$r[cjsum];
					$subject_g[1][]=$r[yw];
					$subject_g[2][]=$r[sx];
					$subject_g[3][]=$r[wy];
					$subject_g[4][]=$r[kx];
					$subject_g[5][]=$r[sz];
					$subject_g[6][]=$r[ls];
					//学生信息表--学号-姓名-年级名次
					$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[stname]);
					//班级信息
					$class_arr[$classid]=$classid;
					$classbuildtime[$classid]=$r[buildtime];
				}
				ksort($class_arr);
				//学科信息
				$subject_arr[0]=0;
				$subject_arr[1]=1;
				$subject_arr[2]=2;
				$subject_arr[3]=3;
				$subject_arr[4]=4;
				$subject_arr[5]=5;
				$subject_arr[6]=6;
				//学科最高分和最低分--20%分数段
				$temp_arr=$subject;
				$temp_i_arr=$subject_g;
				for ($e=0;$e<=6;$e++){
					//排序大到小
					rsort($temp_i_arr[$e]);
					//print_r($temp_i_arr[$e]);
					//最高分数值
					$subject_max[$e]=current($temp_i_arr[$e]);
					end($temp_i_arr[$e]);
					//最低分数值
					$subject_mix[$e]=current($temp_i_arr[$e]);
					$temp_i=$temp_add=$all_num/5;
					$temp_i=round(number_format($temp_i,1));
					$subject_20_[$e][0]=$subject_max[$e];
					$subject_20_[$e][1]=$temp_i_arr[$e][$temp_i-1];
					$temp_i+=$temp_add;
					$subject_20_[$e][2]=$temp_i_arr[$e][$temp_i-1];
					$temp_i+=$temp_add;
					$subject_20_[$e][3]=$temp_i_arr[$e][$temp_i-1];
					$temp_i+=$temp_add;
					$subject_20_[$e][4]=$temp_i_arr[$e][$temp_i-1];
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
					// echo $subject_20_[$e][0]."-".$temp_1.",".$temp_2."-".$temp_3.",$temp_4-$temp_5,$temp_6-$temp_7,$temp_8-".$subject_20_[$e][5]."<br>";
					unset($temp_i,$temp_1,$temp_2,$temp_3,$temp_4,$temp_5,$temp_6,$temp_7,$temp_8);
				}
				unset($temp_arr);
				//按学科统计
				foreach($subject_arr as $key){
					$subjectid=$key;
					$s=0;
					//按班级统计
					foreach ($class_arr as $key2){
						//班级id
						$classid=$key2;
						$classid_arr[$classid]=$classid;
						//名次和班级人数计数
						$j=0;
						$s++;
						//班级成绩分段统计
						$subject_class_max=0;
						$subject_class_mix=600;
						foreach($st_arr[$classid] as $key3=> $value)  {
							//学生编号
							$stnumber=$key3;
							//本班输出成绩信息
							$j++;
							//学科成绩20%分段统计
							if ($subject[$subjectid][$stnumber]>=$subject_20_[$subjectid][5] and $subject[$subjectid][$stnumber]< $subject_20_[$subjectid][4])
							$subject_20_result[$subjectid][$classid][5][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$subject_20_[$subjectid][4] and $subject[$subjectid][$stnumber]< $subject_20_[$subjectid][3])
							$subject_20_result[$subjectid][$classid][4][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$subject_20_[$subjectid][3] and $subject[$subjectid][$stnumber]< $subject_20_[$subjectid][2])
							$subject_20_result[$subjectid][$classid][3][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$subject_20_[$subjectid][2] and $subject[$subjectid][$stnumber]< $subject_20_[$subjectid][1])
							$subject_20_result[$subjectid][$classid][2][]=$subject[$subjectid][$stnumber];
							elseif ($subject[$subjectid][$stnumber]>=$subject_20_[$subjectid][1] and $subject[$subjectid][$stnumber]<=$subject_20_[$subjectid][0])
							$subject_20_result[$subjectid][$classid][1][]=$subject[$subjectid][$stnumber];
							//班级最高最低分
							if ($subject[$subjectid][$stnumber]> $subject_class_max)
							$subject_class_max=$subject[$subjectid][$stnumber];
							if ($subject[$subjectid][$stnumber]< $subject_class_mix)
							$subject_class_mix=$subject[$subjectid][$stnumber];
							//学科班级总分
							$total_sub[$subjectid][$classid]+=$subject[$subjectid][$stnumber];
						}//end foreach
						$subject_class_max_[$subjectid][$classid]=$subject_class_max;
						$subject_class_mix_[$subjectid][$classid]=$subject_class_mix;
						//学科班级平均分
						$avage_[$subjectid][$classid]=number_format($total_sub[$subjectid][$classid]/$j,2);
					}//end foreach
					//echo $total_sub[$subjectid][$classid]."<br>";
					//班级数
					$max_class=$s;
				}//end foreach
				//设置年级学科成绩统计输出
				//参数设置
				$colid=0;
				$subjectname=array("总分","语 文","数 学","外 语","科 学","思 政","历 社");
				//按学科成绩统计输出
				foreach($subject_arr as $key){
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
					//班级信息处理
					foreach ($class_arr as $key2){
						//班级id
						$classid=$key2;
						//名次和班级人数计数
						$j=0;
						//班级
						$class_id=substr($classid,4,2);
						if ($class_id<10)$class_id=substr($class_id,1,1);
						$classname=$gradearr[$grade_id].$gradecarr[$class_id];
						$table_show.="   <td  class=tr_head>$classname</td>";
					}//end foreach 班级名称输出
					reset($class_arr);
					$table_show.="</tr>" ;
					//学科成绩分段统计0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
					$result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");
					for ($i=1;$i<=5;$i++){
						$table_show.="   <tr><td  class=td1 align=center height=20>".$subject_20_title[$subjectid][$i]."</td>";
						foreach ($class_arr as $key2){
							$classid=$key2;
							$t_numb=sizeof($subject_20_result[$subjectid][$classid][$i]);
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
					foreach ($class_arr as $key2){
						$classid=$key2;

						$t_show.="   <td  class=td1 align=center>".$subject_class_max_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_max[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					//最低分
					$table_show.="   <tr><td  class=td1 align=center height=20>最低分</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$t_show.="   <td  class=td1 align=center>".$subject_class_mix_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_mix[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					// 平均分
					$table_show.="   <tr><td  class=td1 align=center height=20>平均分</td>";
					$t_numb=number_format($all_[$subjectid]/$all_num,2);
					$table_show.="<td  class=td1 align=center>".$t_numb."</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$avage_[$subjectid][$classid]."</td>";
					}
					$table_show.="	</tr>	" ;
					//html参数
					$table_show.="</tbody></table></TD></TR></TBODY>";
				}//end foreach
				break;
		}
		if ($do=='word')toword($table_show);
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
      	              <a href="?filename=tongji&action=listone&id=<?=$id;?>" >没有排序查看</a> | 
				              <a href="?filename=tongji&action=cout&id=<?=$id;?>" > 班级排名统计</a> |
				              <a href="?filename=tongji&action=csout&id=<?=$id;?>" > 学科成绩统计</a> |
				              <a href="?filename=tongji&action=out20&id=<?=$id;?>" > 20%分段统计</a>
				              </strong></td>
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
      <TD align=middle height=24>
      	开发笔记  技术支持</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>