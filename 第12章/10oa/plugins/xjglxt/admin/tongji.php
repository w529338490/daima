<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//����word�ļ�
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
//�û���Ȩ�޶�ȡ
$sql="select * from userright where rightid=$group_id limit 1";
$result=$db->query($sql);
if($db->affected_rows()!=0){
	$r=$db->fetch_array($result);
	$rights=$r[rights];
	$right=1; //����
	$rights=explode(":",$rights);
	while (list($key,$tempright)=each($rights)){
		$tempright=explode("|",$tempright);
		$rightlen=sizeof($tempright);
		for ($i=1;$i<=$rightlen;$i++)
		$rightdata[$tempright[0]][]=$tempright[$i];
	}
} else $right=0;
if ($right==0) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
//�ɼ����
$sql = "SELECT userid,gradeid FROM $table_resultset where id=$id limit 1";
$r = $db->query_first($sql);
$grade_ids=explode(":",$r[gradeid]);
$grade_id=$grade_ids[0];
/************************************************************/
switch($school_type){
	case '1':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��");
		break;
	case '2':
		$gradearr=array("1"=>"��һ","2"=>"����","3"=>"����");
		break;
	case '3':
		$gradearr=array("1"=>"��һ","2"=>"�߶�","3"=>"����");
		break;
	case '12':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��","7"=>"��һ","8"=>"����","9"=>"����");
		break;
}
$gradecarr=array("ȫ�꼶","(1)��","(2)��","(3)��","(4)��","(5)��","(6)��","(7)��","(8)��","(9)��","(10)��","(11)��","(12)��");
switch ($action){
	//***************************************����ѧ���ɼ��б�********������*******************/
	case 'listone':
		//�ɼ�����İ༶��Ϣ
		$sql="SELECT * FROM $table_resultset limit 1";
		$r = $db->query_first($sql);
		$grade_class=$r[gradeid];
		//��¼���ݵĶ�ȡ
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
			//ѧ�Ƴɼ���Ϣ��[�༶][ѧ��]���:0�ܷ�1����2��ѧ3����4��ѧ5˼��6����7����8����9���к�
			$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[stname],$r[id]);
			//�༶����ʱ��
			$i++;
		}
		$colid=0;
		//�������
		foreach($resultarr as $key => $arr){
			//�༶id
			$classid=$key;
			//���μ���
			$j=1;
			//�༶
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
				    			<td  class=tr_head>���к�</td>	
				    		 	<td  width=15% height=24 class=tr_head>�༶</td>
				    		 	<td   class=tr_head>ѧ��</td>
				    		 	<td  class=tr_head>ѧ������</td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>˼��</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>�ܷ�</td>
					  		 	<td  class=tr_head>����</td>	
	
					       </tr>"; 
			foreach ($arr as $key => $value){
				//��������ɼ���Ϣ
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
     				      <td  class=td1><a href=# onclick=popUp('editst','$value[9]')>�޸�</a></td>	
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
//******************************************�༶����ͳ��***********************************/
	case 'cout':
		//���ݶ�ȡ
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
		//�������
		foreach($resultarr as $key => $arr){
			//�༶id
			$classid=$key;
			//���μ���
			$j=1;
			//�༶
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
				    		 	<td  width=15% height=24 class=tr_head>�༶</td>
				    		 	<td   class=tr_head>ѧ��</td>
				    		 	<td  class=tr_head>ѧ������</td>
						   	    <td  class=tr_head>����</td>
					  		    <td  class=tr_head>��ѧ</td>
					  		    <td  class=tr_head>����</td>
					  		    <td  class=tr_head>��ѧ</td>
					  		    <td  class=tr_head>˼��</td>
					  		    <td  class=tr_head>����</td>
					  		    <td  class=tr_head>�ܷ�</td>
					  		 	<td  class=tr_head>�༶����</td>	
				    		 	<td  class=tr_head>�꼶����</td>		
					       </tr>"; 
			foreach ($arr as $key => $value){
				//��������ɼ���Ϣ
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
				//�꼶�ܳɼ���Ϣ
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
				//���ĳɼ�����0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
		//�����꼶�ɼ����
		$class_show="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1(0);
                     vAlign=bottom align=middle width=100 height=32><FONT 
                     color=#ff0000><STRONG>�����꼶</STRONG></FONT></TD>".$class_show;
		$t_show="<TBODY id=Tabs1>
                              <TR>
                                <TD class=menu_tdbg vAlign=top align=left height=180>
	                           ";    
		$t_show.="
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td  width=15% height=24 class=tr_head>�༶</td>
				    		 	<td   class=tr_head>ѧ��</td>
				    		 	<td  class=tr_head>ѧ������</td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>˼��</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>�ܷ�</td>
				    		 	<td  class=tr_head>�꼶����</td>		
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
		//*************************************�༶�ɼ�ͳ��**********************************/
	case 'sout':
		//���ݶ�ȡ
		$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
		$r= $db->query_first($sql);
		//����ѧ������
		$all_num=$r[0];
		//�������гɼ���
		$all_1=$r[1];
		$all_2=$r[2];
		$all_3=$r[3];
		$all_4=$r[4];
		$all_5=$r[5];
		$all_6=$r[6];
		//�꼶���γ�ʼ��
		$i=1;
		//���ݶ�ȡ
		$query="select * from $table_result where resultid='$id' order by cjsum DESC";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$classid=substr($r[stnumber],0,6);
			$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[stname]);
			$i++;
		}
		//��������
		$colid=1;
		//�������
		foreach($resultarr as $key => $arr){
			//�༶id
			$classid=$key;
			//���κͰ༶��������
			$j=0;
			//�༶
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>˼��</td>
					  		  <td  class=tr_head>����</td>	
					       </tr>"; 
			foreach ($arr as $key => $value){
				//��������ɼ���Ϣ
				$j++;
				//�༶ѧ���ܷ�
				$total[$classid][yw]+=$value[1];
				$total[$classid][sx]+=$value[2];
				$total[$classid][wy]+=$value[3];
				$total[$classid][kx]+=$value[4];
				$total[$classid][sz]+=$value[5];
				$total[$classid][ls]+=$value[6];
				//��ѧ�Ʒ�����
				$yw[$classid][]=$value[1];
				$sx[$classid][]=$value[2];
				$wy[$classid][]=$value[3];
				$kx[$classid][]=$value[4];
				$sz[$classid][]=$value[5];
				$ls[$classid][]=$value[6];
				//ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
			//ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
			$result_d=array("","0-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-84","85-89","90-99","100");
			//ѧ�Ƴɼ��ֶ����
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
				//�꼶ѧ�Ʒֶ�
				$all_[1][$p]+=sizeof(${$t_name[1]}[$classid][$p]);
				$all_[2][$p]+=sizeof(${$t_name[2]}[$classid][$p]);
				$all_[3][$p]+=sizeof(${$t_name[3]}[$classid][$p]);
				$all_[4][$p]+=sizeof(${$t_name[4]}[$classid][$p]);
				$all_[5][$p]+=sizeof(${$t_name[5]}[$classid][$p]);
				$all_[6][$p]+=sizeof(${$t_name[6]}[$classid][$p]);
			}
			//ƽ���ֳɼ����
			$avage_yw=number_format($total[$classid][yw]/$j,2);
			$avage_sx=number_format($total[$classid][sx]/$j,2);
			$avage_wy=number_format($total[$classid][wy]/$j,2);
			$avage_kx=number_format($total[$classid][kx]/$j,2);
			$avage_sz=number_format($total[$classid][sz]/$j,2);
			$avage_ls=number_format($total[$classid][ls]/$j,2);
			$table_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>ƽ����</td>
			<td  class=td1>".$avage_yw."</td>
			<td  class=td1>".$avage_sx."</td>
			<td  class=td1>".$avage_wy."</td>
			<td  class=td1>".$avage_kx."</td>
			<td  class=td1>".$avage_sz."</td>
			<td  class=td1>".$avage_ls."</td>
			</tr>";
 //��߷�
 rsort($yw[$classid]);
 rsort($sx[$classid]);
 rsort($wy[$classid]);
 rsort($kx[$classid]);
 rsort($sz[$classid]);
 rsort($ls[$classid]);
 $table_show.="
			<tr  align=center>
			<td   idth=15% height=24 class=td1>��߷�</td>
			<td  class=td1>".$yw[$classid][0]."</td>
			<td  class=td1>".$sx[$classid][0]."</td>
			<td  class=td1>".$wy[$classid][0]."</td>
			<td  class=td1>".$kx[$classid][0]."</td>
			<td  class=td1>".$sz[$classid][0]."</td>
			<td  class=td1>".$ls[$classid][0]."</td>
			</tr>";
//�꼶��߷�					      
$all_max[1][]=$yw[$classid][0];
$all_max[2][]=$sx[$classid][0];
$all_max[3][]=$wy[$classid][0];					      
$all_max[4][]=$kx[$classid][0];
$all_max[5][]=$sz[$classid][0];
$all_max[6][]=$ls[$classid][0];
 //��ͷ�		
 $j-=1;
 $table_show.="
			<tr  align=center>
			<td   idth=15% height=24 class=td1>��ͷ�</td>
			<td  class=td1>".$yw[$classid][$j]."</td>
			<td  class=td1>".$sx[$classid][$j]."</td>
			<td  class=td1>".$wy[$classid][$j]."</td>
			<td  class=td1>".$kx[$classid][$j]."</td>
			<td  class=td1>".$sz[$classid][$j]."</td>
			<td  class=td1>".$ls[$classid][$j]."</td>
			</tr>";
//�꼶��ͷ�					      
$all_mix[1][]=$yw[$classid][$j];
$all_mix[2][]=$sx[$classid][$j];
$all_mix[3][]=$wy[$classid][$j];					      
$all_mix[4][]=$kx[$classid][$j];
$all_mix[5][]=$sz[$classid][$j];
$all_mix[6][]=$ls[$classid][$j];					            
 //html����
  $table_show.=	"			    		
			</tbody>
			</table>
			</TD>
			</TR>
			</TBODY>";
}//end foreach
//�����꼶ѧ�Ƴɼ�ͳ�����
//html����
$class_show="<TD class=main_menu_title2 id=TabTitle1 onmousedown=javascript:ShowTabs1(0);
			vAlign=bottom align=middle width=100 height=32><FONT
			color=#ff0000><STRONG>�����꼶</STRONG></FONT></TD>".$class_show;
			$t_show="<TBODY id=Tabs1>
           <TR>
             <TD class=menu_tdbg vAlign=top align=left height=180>               
	          <TABLE cellSpacing=2 cellPadding=1 width=100% align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>	
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>˼��</td>
					  		  <td  class=tr_head>����</td>	
					       </tr>";     
			//ѧ�Ƴɼ��ֶ����
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
			//�꼶ƽ���ֳɼ����
			$avage_yw=number_format($all_1/$all_num,2);
			$avage_sx=number_format($all_2/$all_num,2);
			$avage_wy=number_format($all_3/$all_num,2);
			$avage_kx=number_format($all_4/$all_num,2);
			$avage_sz=number_format($all_5/$all_num,2);
			$avage_ls=number_format($all_6/$all_num,2);
			$t_show.="
         	    	<tr  align=center>
				    		 	<td   idth=15% height=24 class=td1>ƽ����</td>
			<td  class=td1>".$avage_yw."</td>
			<td  class=td1>".$avage_sx."</td>
			<td  class=td1>".$avage_wy."</td>
			<td  class=td1>".$avage_kx."</td>
			<td  class=td1>".$avage_sz."</td>
			<td  class=td1>".$avage_ls."</td>
			</tr>";
			//�꼶��߷�
			rsort($all_max[1]);
			rsort($all_max[2]);
			rsort($all_max[3]);
			rsort($all_max[4]);
			rsort($all_max[5]);
			rsort($all_max[6]);
			$t_show.="
			<tr  align=center>
			<td   idth=15% height=24 class=td1>��߷�</td>
			<td  class=td1>".$all_max[1][0]."</td>
			<td  class=td1>".$all_max[2][0]."</td>
			<td  class=td1>".$all_max[3][0]."</td>
			<td  class=td1>".$all_max[4][0]."</td>
			<td  class=td1>".$all_max[5][0]."</td>
			<td  class=td1>".$all_max[6][0]."</td>
			</tr>";
			//��ͷ�
			sort($all_mix[1]);
			sort($all_mix[2]);
			sort($all_mix[3]);
			sort($all_mix[4]);
			sort($all_mix[5]);
			sort($all_mix[6]);
			$t_show.="
			<tr  align=center>
			<td   idth=15% height=24 class=td1>��ͷ�</td>
			<td  class=td1>".$all_mix[1][0]."</td>
			<td  class=td1>".$all_mix[2][0]."</td>
			<td  class=td1>".$all_mix[3][0]."</td>
			<td  class=td1>".$all_mix[4][0]."</td>
			<td  class=td1>".$all_mix[5][0]."</td>
			<td  class=td1>".$all_mix[6][0]."</td>
			</tr>";
			//html����
			$t_show.=	"
			</tbody>
			</table>
			</TD>
			</TR>
			</TBODY>";
			$table_show=$t_show.$table_show;
			break;
			/*****************************ѧ�Ƴɼ�ͳ��******************************************/
			case 'csout':
				//ÿ�Ƴɼ���߷�����
				$sql="select * from $table_resultset where id=$id";
				$r= $db->query_first($sql);
				$rtype_arr[0]="";
				$rtype_arr=explode(":",$r[rtype]);
				//����������
				$result_type_arr[150]=array('0','44.5','45','59.5','60','74.5','75','89.5','90','104.5','105','119.5','120','127','127.5','134.5','135','149.5','150');
				$result_type_arr[120]=array('0','35.5','36','47.5','48','59.5','60','71.5','72','83.5','84','95.5','96','101.5','102','107.5','108','119.5','120');
				$result_type_arr[110]=array('0','32.5','33','43.5','44','54.5','55','65.5','66','76.5','77','87.5','88','93','93.5','98.5','99','109.5','110');
				$result_type_arr[100]=array('0','29.5','30','39.5','40','49.5','50','59.5','60','69.5','70','79.5','80','84.5','85','89.5','90','99.5','100');
				$result_type_arr[80]=array('0','23.5','24','31.5','32','39.5','40','47.5','48','55.5','56','63.5','64','67.5','68','71.5','72','79.5','80');
				//��ʾ���
				$result_type_out[150]=array('','0-44.5','45-59.5','60-74.5','75-89.5','90-104.5','105-119.5','120-127','127.5-134.5','135-149.5','150');
				$result_type_out[120]=array('','0-35.5','36-47.5','48-59.5','60-71.5','72-83.5','84-95.5','96-101.5','102-107.5','108-119.5','120');
				$result_type_out[110]=array('','0-32.5','33-43.5','44-54.5','55-65.5','66-76.5','77-87.5','88-93','93.5-98.5','99-109.5','110');
				$result_type_out[100]=array('','0-29.5','30-39.5','40-49.5','50-59.5','60-69.5','70-79.5','80-84.5','85-89.5','90-99.5','100');
				$result_type_out[80]=array('','0-23.5','24-31.5','32-39.5','40-47.5','48-55.5','56-63.5','64-67.5','68-71.5','72-79.5','80');
				//�ϸ����㡢�ͷ���
				$result_type_s[150]=array('127.5','90','60');
				$result_type_s[120]=array('102','72','48');
				$result_type_s[110]=array('93.5','66','44');
				$result_type_s[100]=array('85','60','40');
				$result_type_s[80]=array('68','48','32');
				//���ݶ�ȡ
				$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls),sum(cjsum) FROM $table_result where resultid=$id";
				$r= $db->query_first($sql);
				//����ѧ������
				$all_num=$r[0];
				//�������гɼ���
				$all_[0]=$r[7];
				$all_[1]=$r[1];
				$all_[2]=$r[2];
				$all_[3]=$r[3];
				$all_[4]=$r[4];
				$all_[5]=$r[5];
				$all_[6]=$r[6];
				//���ݶ�ȡ
				$query="select * from $table_result where resultid='$id' order by cjsum DESC";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					//�༶���
					$classid=substr($r[stnumber],0,6);
					//�ɼ���������--0�ܷ�-1����-2��ѧ-3����-4��ѧ-5˼��-6����
					$subject[0][$r[stnumber]]=$r[cjsum];
					$subject[1][$r[stnumber]]=$r[yw];
					$subject[2][$r[stnumber]]=$r[sx];
					$subject[3][$r[stnumber]]=$r[wy];
					$subject[4][$r[stnumber]]=$r[kx];
					$subject[5][$r[stnumber]]=$r[sz];
					$subject[6][$r[stnumber]]=$r[ls];
					//ѧ����Ϣ��--ѧ��-����-�꼶����
					$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[stname]);
					//�༶��Ϣ
					$class_arr[$classid]=$classid;
				}
				ksort($class_arr);
				//ѧ����Ϣ
				//$subject_arr[0]=0;
				$subject_arr[1]=1;
				$subject_arr[2]=2;
				$subject_arr[3]=3;
				$subject_arr[4]=4;
				$subject_arr[5]=5;
				$subject_arr[6]=6;
				//ѧ����߷ֺ���ͷ�--20%������
				$temp_arr=$subject;
				for ($e=0;$e<=6;$e++){
					//�����С
					rsort($temp_arr[$e]);
					//��߷���ֵ
					$subject_max[$e]=current($temp_arr[$e]);
					end($temp_arr[$e]);
					//��ͷ���ֵ
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
				//��ѧ��ͳ��
				foreach($subject_arr as $key){
					$subjectid=$key;
					$subject_t=$key-1;
					$s=0;
					//���༶ͳ��
					foreach ($class_arr as $key2){
						//�༶id
						$classid=$key2;
						$classid_arr[$classid]=$classid;
						//���κͰ༶��������
						$j=0;
						$s++;
						//�༶������
						$class_num_t=count($st_arr[$classid]);
						$class_num_t30=round(number_format($class_num_t*30/100,1));
						//�༶�ɼ��ֶ�ͳ��
						$subject_class_max=0;
						$subject_class_mix=100;
						foreach($st_arr[$classid] as $key3=> $value)  {
							//ѧ�����
							$stnumber=$key3;
							//��������ɼ���Ϣ
							$j++;
							//ѧ�Ƴɼ��ֶ�ͳ��
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

							//���� �ϸ� �ͷ�
							if  ($subject[$subjectid][$stnumber]>=$result_type_s[$rtype_arr[$subject_t]][0]) $class_y[$subjectid][$classid]++;
							if  ($subject[$subjectid][$stnumber]>=$result_type_s[$rtype_arr[$subject_t]][1]) $class_h[$subjectid][$classid]++;
							if  ($subject[$subjectid][$stnumber]<$result_type_s[$rtype_arr[$subject_t]][2])  $class_d[$subjectid][$classid]++;
							//�༶�����ͷ�
							if ($subject[$subjectid][$stnumber]> $subject_class_max)
							$subject_class_max=$subject[$subjectid][$stnumber];
							if ($subject[$subjectid][$stnumber]< $subject_class_mix)
							$subject_class_mix=$subject[$subjectid][$stnumber];
							//ѧ�ư༶�ܷ�
							$total_sub[$subjectid][$classid]+=$subject[$subjectid][$stnumber];
							//30%����
							//if ($j>=);
						}//end foreach
						//�꼶���� �ϸ� �ͷ�
						$grade_y[$subjectid]=$grade_y[$subjectid]+$class_y[$subjectid][$classid];
						$grade_h[$subjectid]=$grade_h[$subjectid]+$class_h[$subjectid][$classid];
						$grade_d[$subjectid]=$grade_d[$subjectid]+$class_d[$subjectid][$classid];
						//�����ͳ�ʼ��
						$subject_class_max_[$subjectid][$classid]=$subject_class_max;
						$subject_class_mix_[$subjectid][$classid]=$subject_class_mix;
						//ѧ�ư༶ƽ����
						$avage_[$subjectid][$classid]=number_format($total_sub[$subjectid][$classid]/$j,2);
						//������ �ϸ��� �ͷ���
						$class_y[$subjectid][$classid]=number_format($class_y[$subjectid][$classid]/$j,4)*100;
						$class_h[$subjectid][$classid]=number_format($class_h[$subjectid][$classid]/$j,4)*100;
						$class_d[$subjectid][$classid]=number_format($class_d[$subjectid][$classid]/$j,4)*100;

					}//end foreach
					//echo $total_sub[$subjectid][$classid]."<br>";
					//�༶��
					$max_class=$s;
				}//end foreach
				//�����꼶ѧ�Ƴɼ�ͳ�����
				//��������
				$colid=0;
				$subjectname=array("�ܷ�","�� ��","�� ѧ","�� ��","�� ѧ","˼ ��","�� ��");
				//��ѧ�Ƴɼ�ͳ�����
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
				    		 	<td   class=tr_head>�����꼶</td>
						   	  ";
					//�༶��Ϣ����
					foreach ($class_arr as $key2){
						//�༶id
						$classid=$key2;
						//���κͰ༶��������
						$j=0;
						//�༶
						$class_id=substr($classid,4,2);
						if ($class_id<10)$class_id=substr($class_id,1,1);
						$classname=$gradearr[$grade_id].$gradecarr[$class_id];
						$table_show.="   <td  class=tr_head>$classname</td>";
					}//end foreach �༶�������
					reset($class_arr);
					$table_show.="</tr>" ;
					//ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100

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
					//��߷�
					$table_show.="   <tr><td  class=td1 align=center height=20>��߷�</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;

						$t_show.="   <td  class=td1 align=center>".$subject_class_max_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_max[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					//��ͷ�
					$table_show.="   <tr><td  class=td1 align=center height=20>��ͷ�</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$t_show.="   <td  class=td1 align=center>".$subject_class_mix_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_mix[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					// ƽ����
					$table_show.="   <tr><td  class=td1 align=center height=20>ƽ����</td>";
					$t_numb=number_format($all_[$subjectid]/$all_num,2);
					$table_show.="<td  class=td1 align=center>".$t_numb."</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$avage_[$subjectid][$classid]."</td>";
					}
					$table_show.="	</tr>	" ;
					// ������
					$table_show.="   <tr><td  class=td1 align=center height=20>������</td>";
					$t_numb=number_format($grade_y[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_y[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					// �ϸ���
					$table_show.="   <tr><td  class=td1 align=center height=20>�ϸ���</td>";
					$t_numb=number_format($grade_h[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_h[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					// �ͷ���
					$table_show.="   <tr><td  class=td1 align=center height=20>�ͷ���</td>";
					$t_numb=number_format($grade_d[$subjectid]/$all_num,4)*100;
					$table_show.="<td  class=td1 align=center>".$t_numb."%</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$class_d[$subjectid][$classid]."%</td>";
					}
					$table_show.="	</tr>	" ;
					//html����
					$table_show.="</tbody></table></TD></TR></TBODY>";
				}//end foreach
				break;

				/*****************************ѧ�Ƴɼ�20%ͳ��******************************************/
			case 'out20':
				//���ݶ�ȡ
				$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls),sum(cjsum) FROM $table_result where resultid=$id";
				$r= $db->query_first($sql);
				//����ѧ������
				$all_num=$r[0];
				//�������гɼ���
				$all_[0]=$r[7];
				$all_[1]=$r[1];
				$all_[2]=$r[2];
				$all_[3]=$r[3];
				$all_[4]=$r[4];
				$all_[5]=$r[5];
				$all_[6]=$r[6];
				//���ݶ�ȡ
				$query="select * from $table_result where resultid='$id' order by cjsum DESC";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					//�༶���
					$classid=substr($r[stnumber],0,6);
					//�ɼ���������һ--0�ܷ�-1����-2��ѧ-3����-4��ѧ-5˼��-6����
					$subject[0][$r[stnumber]]=$r[cjsum];
					$subject[1][$r[stnumber]]=$r[yw];
					$subject[2][$r[stnumber]]=$r[sx];
					$subject[3][$r[stnumber]]=$r[wy];
					$subject[4][$r[stnumber]]=$r[kx];
					$subject[5][$r[stnumber]]=$r[sz];
					$subject[6][$r[stnumber]]=$r[ls];
					//�ɼ��������Ŷ�--0�ܷ�-1����-2��ѧ-3����-4��ѧ-5˼��-6����
					$subject_g[0][]=$r[cjsum];
					$subject_g[1][]=$r[yw];
					$subject_g[2][]=$r[sx];
					$subject_g[3][]=$r[wy];
					$subject_g[4][]=$r[kx];
					$subject_g[5][]=$r[sz];
					$subject_g[6][]=$r[ls];
					//ѧ����Ϣ��--ѧ��-����-�꼶����
					$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[stname]);
					//�༶��Ϣ
					$class_arr[$classid]=$classid;
					$classbuildtime[$classid]=$r[buildtime];
				}
				ksort($class_arr);
				//ѧ����Ϣ
				$subject_arr[0]=0;
				$subject_arr[1]=1;
				$subject_arr[2]=2;
				$subject_arr[3]=3;
				$subject_arr[4]=4;
				$subject_arr[5]=5;
				$subject_arr[6]=6;
				//ѧ����߷ֺ���ͷ�--20%������
				$temp_arr=$subject;
				$temp_i_arr=$subject_g;
				for ($e=0;$e<=6;$e++){
					//�����С
					rsort($temp_i_arr[$e]);
					//print_r($temp_i_arr[$e]);
					//��߷���ֵ
					$subject_max[$e]=current($temp_i_arr[$e]);
					end($temp_i_arr[$e]);
					//��ͷ���ֵ
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
				//��ѧ��ͳ��
				foreach($subject_arr as $key){
					$subjectid=$key;
					$s=0;
					//���༶ͳ��
					foreach ($class_arr as $key2){
						//�༶id
						$classid=$key2;
						$classid_arr[$classid]=$classid;
						//���κͰ༶��������
						$j=0;
						$s++;
						//�༶�ɼ��ֶ�ͳ��
						$subject_class_max=0;
						$subject_class_mix=600;
						foreach($st_arr[$classid] as $key3=> $value)  {
							//ѧ�����
							$stnumber=$key3;
							//��������ɼ���Ϣ
							$j++;
							//ѧ�Ƴɼ�20%�ֶ�ͳ��
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
							//�༶�����ͷ�
							if ($subject[$subjectid][$stnumber]> $subject_class_max)
							$subject_class_max=$subject[$subjectid][$stnumber];
							if ($subject[$subjectid][$stnumber]< $subject_class_mix)
							$subject_class_mix=$subject[$subjectid][$stnumber];
							//ѧ�ư༶�ܷ�
							$total_sub[$subjectid][$classid]+=$subject[$subjectid][$stnumber];
						}//end foreach
						$subject_class_max_[$subjectid][$classid]=$subject_class_max;
						$subject_class_mix_[$subjectid][$classid]=$subject_class_mix;
						//ѧ�ư༶ƽ����
						$avage_[$subjectid][$classid]=number_format($total_sub[$subjectid][$classid]/$j,2);
					}//end foreach
					//echo $total_sub[$subjectid][$classid]."<br>";
					//�༶��
					$max_class=$s;
				}//end foreach
				//�����꼶ѧ�Ƴɼ�ͳ�����
				//��������
				$colid=0;
				$subjectname=array("�ܷ�","�� ��","�� ѧ","�� ��","�� ѧ","˼ ��","�� ��");
				//��ѧ�Ƴɼ�ͳ�����
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
				    		 	<td   class=tr_head>�����꼶</td>
						   	  ";
					//�༶��Ϣ����
					foreach ($class_arr as $key2){
						//�༶id
						$classid=$key2;
						//���κͰ༶��������
						$j=0;
						//�༶
						$class_id=substr($classid,4,2);
						if ($class_id<10)$class_id=substr($class_id,1,1);
						$classname=$gradearr[$grade_id].$gradecarr[$class_id];
						$table_show.="   <td  class=tr_head>$classname</td>";
					}//end foreach �༶�������
					reset($class_arr);
					$table_show.="</tr>" ;
					//ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
					//��߷�
					$table_show.="   <tr><td  class=td1 align=center height=20>��߷�</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;

						$t_show.="   <td  class=td1 align=center>".$subject_class_max_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_max[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					//��ͷ�
					$table_show.="   <tr><td  class=td1 align=center height=20>��ͷ�</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$t_show.="   <td  class=td1 align=center>".$subject_class_mix_[$subjectid][$classid]."</td>";
					}
					$table_show.= "<td  class=td1 align=center>$subject_mix[$subjectid]</td>".$t_show;
					$t_show="";
					$table_show.="	</tr>	" ;
					// ƽ����
					$table_show.="   <tr><td  class=td1 align=center height=20>ƽ����</td>";
					$t_numb=number_format($all_[$subjectid]/$all_num,2);
					$table_show.="<td  class=td1 align=center>".$t_numb."</td>";
					foreach ($class_arr as $key2){
						$classid=$key2;
						$table_show.="   <td  class=td1 align=center>".$avage_[$subjectid][$classid]."</td>";
					}
					$table_show.="	</tr>	" ;
					//html����
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>ѧ���ɼ�����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> <A  
      href="?filename=result&action=up">ѧ���ɼ�����</A> | <A 
      href="?filename=result&action=list">ѧ���ɼ��б�</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE>
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=middle>
      <td  height="24"><strong>��ǰλ�ã�ѧ���ɼ����� >> 
      	              <a href="?filename=tongji&action=listone&id=<?=$id;?>" >û������鿴</a> | 
				              <a href="?filename=tongji&action=cout&id=<?=$id;?>" > �༶����ͳ��</a> |
				              <a href="?filename=tongji&action=csout&id=<?=$id;?>" > ѧ�Ƴɼ�ͳ��</a> |
				              <a href="?filename=tongji&action=out20&id=<?=$id;?>" > 20%�ֶ�ͳ��</a>
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
      	�����ʼ�  ����֧��</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>