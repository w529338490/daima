<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
//Ȩ������
$sql="SELECT * FROM `$table_manage` where admin=$user_id limit 1";
$r=$db->query_first($sql);
$limit=$r[groupid];
/************************************************************/
switch ($action){
//***************************************����ѧ���ɼ��б�***************************/
case 'listone':
//��¼���ݵĶ�ȡ
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
//ѧ�Ƴɼ���Ϣ��[�༶][ѧ��]���:0�ܷ�1����2��ѧ3����4��ѧ5˼��6����7����8����9���к�	
$resultarr[$classid][$r[stnumber]]=array($r[cjsum],$r[yw],$r[sx],$r[wy],$r[kx],$r[sz],$r[ls],$i,$r[name],$r[id]);
//�༶����ʱ��
$classbuildtime[$classid]=$r[buildtime];
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
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
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
//�������
foreach($resultarr as $key => $arr){             
      //�༶id 	
	    $classid=$key;
			//���μ���		       
	    $j=1;
		  //�༶
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
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
  $table_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
              </TR>
              </TBODY>";				       
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
$t_show.=	"			    		
					      </tbody>
					      </table>
					     </TD>
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
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
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
				    		 	<td   idth=15% height=24 class=td1>".ƽ����."</td>
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
				    		 	<td   idth=15% height=24 class=td1>".ƽ����."</td>
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
//���ݶ�ȡ
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//����ѧ������
$all_num=$r[0];
//�������гɼ���
$all_[1]=$r[1];
$all_[2]=$r[2];
$all_[3]=$r[3];
$all_[4]=$r[4];
$all_[5]=$r[5];
$all_[6]=$r[6];
//���ݶ�ȡ
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
//��ѧ��ͳ��
foreach($resultarr as $key => $arr){ 
	  $subjectid=$key; 
	  $s=0;           
		//���༶ͳ��			       
    foreach ($arr as $key => $arr2){
  	//�༶id 	
	  $classid=$key;
	  $classid_arr[$classid]=$classid;
	  //���κͰ༶��������		       
	  $j=0;
	  $s++;
    //�༶�ɼ��ֶ�ͳ��  	   
    foreach($arr2 as $value)  {
    //��������ɼ���Ϣ
    $j++;
    //ѧ�ư༶�ܷ�    
    $total[$subjectid][$classid]+=$value;
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
     //��߷�
     rsort($arr2);
     $max_[$subjectid][$classid]=$arr2[0];
     //��ͷ�
     sort($arr2);
     $mix_[$subjectid][$classid]=$arr2[0];
     //ƽ����
     $avage_[$subjectid][$classid]=number_format($total[$subjectid][$classid]/$j,2);
  }//end foreach   
  //�༶��
  $max_class=$s; 
}//end foreach
//�����꼶ѧ�Ƴɼ�ͳ�����
//��������
$colid=0;
$subjectname=array("","�� ��","�� ѧ","�� ��","�� ѧ","˼ ��","�� ��");
//���ð༶����
foreach($classid_arr as $arr) $t_classid_arr[]=$arr;
reset($resultarr);
//��ѧ��ͳ��
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
				    		 	<td   class=tr_head>�����꼶</td>
						   	  ";
		 //�༶�������			       
     foreach ($arr as $key => $arr2){
  	  //�༶id 	
	    $classid=$key;
			//���κͰ༶��������		       
	    $j=0;
		  //�༶
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
      	  } 
      $table_show.="   <td  class=tr_head>$classname</td>"; 	  
      }//end foreach �༶�������
    $table_show.="</tr>" ; 
    //�༶�ɼ��ֶ�ͳ��
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
    //��߷� 
    $table_show.="   <tr><td  class=td1 align=center height=20>��߷�</td>";
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
     //��ͷ�   
     $table_show.="   <tr><td  class=td1 align=center height=20>��ͷ�</td>";
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
     // ƽ����	  
     $table_show.="   <tr><td  class=td1 align=center height=20>ƽ����</td>";
     $t_numb=number_format($all_[$subjectid]/$all_num,2);
     $table_show.="<td  class=td1 align=center>".$t_numb."</td>"; 
     $t_endid=sizeof($t_classid_arr); 
     for ($q=0;$q<$t_endid;$q++){	 
           $t_numb=$avage_[$subjectid][$t_classid_arr[$q]];
          $table_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
     }
     $table_show.="	</tr>	" ; 	   	   
     //html���� 
     $table_show.="</tbody></table></TD></TR></TBODY>";
}//end foreach
break;
//*************************************�༶20%�ɼ�ͳ��**********************************/
case 'sout20':
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
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
$result=$db->query($query);
while($r=$db->fetch_array($result)){
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
$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[name],$i);
//�༶��Ϣ
$class_arr[$classid]=$classid;
$classbuildtime[$classid]=$r[buildtime];
$i++;
}   
//�༶����
asort($class_arr);
//��������
$colid=1;
//�������
foreach($class_arr as $key => $arr){   
         
      //�༶id 	
	    $classid=$key;
	    $arr=$st_arr[$classid];
			//���κͰ༶��������		       
	    $j=0;
		  //�༶
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>��ѧ</td>
					  		  <td  class=tr_head>˼��</td>
					  		  <td  class=tr_head>����</td>	
					       </tr>";
	//�ֺܷ�ѧ����߷�
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
       unset($temp_i,$temp_1,$temp_2,$temp_3,$temp_4,$temp_5,$temp_6,$temp_7,$temp_8);
       }			       
    $s=0;  
	//����ɼ��ֶ�ͳ��20%(��߷ֺ���ͷֲ����5)			       				       
  foreach ($st_arr[$classid] as $key => $value){
    //ѧ��ѧ��
   $stnumber=$key;
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
    //�༶ѧ���ܷ�    
    $total[$classid][yw]+=$subject[1][$stnumber];
    $total[$classid][sx]+=$subject[2][$stnumber];
    $total[$classid][wy]+=$subject[3][$stnumber];
    $total[$classid][kx]+=$subject[4][$stnumber];
    $total[$classid][sz]+=$subject[5][$stnumber];
    $total[$classid][ls]+=$subject[6][$stnumber];
    //��ѧ�Ʒ�����
    $yw[$classid][]=$subject[1][$stnumber];
    $sx[$classid][]=$subject[2][$stnumber];
    $wy[$classid][]=$subject[3][$stnumber];
    $kx[$classid][]=$subject[4][$stnumber];
    $sz[$classid][]=$subject[5][$stnumber];
    $ls[$classid][]=$subject[6][$stnumber];
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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

  //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100         
  //ѧ�Ƴɼ��ֶ����
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
			//�꼶ѧ�Ʒֶ�		      
			$all_[1][$p]+=sizeof(${$t_name[1]}[$classid][$p]);
			$all_[2][$p]+=sizeof(${$t_name[2]}[$classid][$p]);
			$all_[3][$p]+=sizeof(${$t_name[3]}[$classid][$p]);
			$all_[4][$p]+=sizeof(${$t_name[4]}[$classid][$p]);
			$all_[5][$p]+=sizeof(${$t_name[5]}[$classid][$p]);
			$all_[6][$p]+=sizeof(${$t_name[6]}[$classid][$p]);
			}		    
	//ѧ�Ƴɼ�20%�ֶ�ͳ��
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
				    		 	<td   idth=15% height=24 class=td1>".ƽ����."</td>
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
				    		 	<td  class=td1>".$yw[$classid][0].$subject_max[1]."</td>
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
				    		 	<td  class=td1>".$yw[$classid][$j].$subject_mix[1]."</td>
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
				    		 	<td   idth=15% height=24 class=td1>".ƽ����."</td>
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
/*****************************ѧ�Ƴɼ�20%ͳ��******************************************/
case 'csout20':
//���ݶ�ȡ
$sql = "SELECT count(*),sum(yw),sum(sx),sum(wy),sum(kx),sum(sz),sum(ls) FROM $table_result where resultid=$id";
$r= $db->query_first($sql);
//����ѧ������
$all_num=$r[0];
//�������гɼ���
$all_[1]=$r[1];
$all_[2]=$r[2];
$all_[3]=$r[3];
$all_[4]=$r[4];
$all_[5]=$r[5];
$all_[6]=$r[6];
//���ݶ�ȡ
$query="select $table_result.*,$table_student.name,$table_class.buildtime from $table_result 
        LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
        LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
        where $table_result.resultid='$id' order by cjsum DESC"; 
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
$st_arr[$classid][$r[stnumber]]=array($r[stnumber],$r[name]);
//�༶��Ϣ
$class_arr[$classid]=$classid;
$classbuildtime[$classid]=$r[buildtime];
}
//��ѧ��ͳ��
foreach($resultarr as $key => $arr){ 
	  $subjectid=$key; 
	  $s=0;           
		//���༶ͳ��			       
    foreach ($arr as $key => $arr2){
  	//�༶id 	
	  $classid=$key;
	  $classid_arr[$classid]=$classid;
	  //���κͰ༶��������		       
	  $j=0;
	  $s++;
    //�༶�ɼ��ֶ�ͳ��  	   
    foreach($arr2 as $value)  {
    //��������ɼ���Ϣ
    $j++;
    //ѧ�ư༶�ܷ�    
    $total[$subjectid][$classid]+=$value;
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
     //��߷�
     rsort($arr2);
     $max_[$subjectid][$classid]=$arr2[0];
     //��ͷ�
     sort($arr2);
     $mix_[$subjectid][$classid]=$arr2[0];
     //ƽ����
     $avage_[$subjectid][$classid]=number_format($total[$subjectid][$classid]/$j,2);
  }//end foreach   
  //�༶��
  $max_class=$s; 
}//end foreach
//�����꼶ѧ�Ƴɼ�ͳ�����
//��������
$colid=0;
$subjectname=array("","�� ��","�� ѧ","�� ��","�� ѧ","˼ ��","�� ��");
//���ð༶����
foreach($classid_arr as $arr) $t_classid_arr[]=$arr;
reset($resultarr);
//��ѧ��ͳ��
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
				    		 	<td   class=tr_head>�ɼ��ֶ�</td>
				    		 	<td   class=tr_head>�����꼶</td>
						   	  ";
		 //�༶�������			       
     foreach ($arr as $key => $arr2){
  	  //�༶id 	
	    $classid=$key;
			//���κͰ༶��������		       
	    $j=0;
		  //�༶
      $class_id=substr($classid,4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$classbuildtime[$classid]),0,2).substr($classid,0,2);
      //����ʱ��
      $buildtime=mktime(0,0,0,7,6,$bytime-3);  
      //����ʱ��   
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"));
      //ʱ������
      $temptime=$nowtime-$buildtime;
      $temptime=round($temptime/2592000);
      //��һ
      if ($temptime>=0 ANd $temptime<=12) {
                 $classname="��һ($class_id)��";
      	         }
      //����	         
      elseif ($temptime>12 AND $temptime<=24){         	       
         	       $classname="����($class_id)��";
      	         }
      //����	         
      elseif ($temptime>24 AND $temptime<=36){
         	       $classname="����($class_id)��";
      	         }
      //�ѱ�ҵ	         
      else{
      	 	$classname=$bytime."��($class_id)��";
      	  } 
      $table_show.="   <td  class=tr_head>$classname</td>"; 	  
      }//end foreach �༶�������
    $table_show.="</tr>" ; 
    //�༶�ɼ��ֶ�ͳ��
    //ѧ�Ƴɼ��ֶ�ͳ��0-10:10-20:20-30:30-40:40-50:50-60:60-70:70-80:80-85:85-90:90-100
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
    //��߷� 
    $table_show.="   <tr><td  class=td1 align=center height=20>��߷�</td>";
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
     //��ͷ�   
     $table_show.="   <tr><td  class=td1 align=center height=20>��ͷ�</td>";
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
     // ƽ����	  
     $table_show.="   <tr><td  class=td1 align=center height=20>ƽ����</td>";
     $t_numb=number_format($all_[$subjectid]/$all_num,2);
     $table_show.="<td  class=td1 align=center>".$t_numb."</td>"; 
     $t_endid=sizeof($t_classid_arr); 
     for ($q=0;$q<$t_endid;$q++){	 
           $t_numb=$avage_[$subjectid][$t_classid_arr[$q]];
          $table_show.="   <td  class=td1 align=center>$t_numb</td>"; 	 
     }
     $table_show.="	</tr>	" ; 	   	   
     //html���� 
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
      	              <a href="?filename=tongji&action=listone&id=<?=$id;?>" >�鿴</a> | 
				              <a href="?filename=tongji&action=cout&id=<?=$id;?>" > �༶����ͳ��</a> |
				              <a href="?filename=tongji&action=sout&id=<?=$id;?>" > �༶�ɼ�ͳ��</a> | 
				              <a href="?filename=tongji&action=csout&id=<?=$id;?>" > ѧ�Ƴɼ�ͳ��</a> |</strong></td>
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
      <TD align=middle height=24>�����ʼ� ����֧��</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>