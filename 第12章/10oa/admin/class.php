<?php
/*
����ɽ��Сѧ����칫��
*/
/************************************************************/
//ģ���ʼ��
$templatesused.="class,class_list,footer";
cachetemplates($templatesused);
//end
switch($action){
//ѧУ�༶��Ϣ�б�	
case 'list':
$i=$j=$k=0;
$startyear=mktime(0,0,0,7,1,date(Y)-3);
$query="select * from $table_class where  buildtime>=$startyear order by buildtime,classid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //�༶
      $classid=substr($r[classid],5,1);
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
      $temptime=$nowtime-$r[buildtime];
      $temptime=round($temptime/2592000);
      if ($temptime>0 ANd $temptime<=12) {
      	         $i++;
      	         $classone.="<td height=24 class=td1 width=25%><a href=?filename=class&action=class&classid=$r[id]>��һ($classid)��</a></td>";
      	         if ($i%4==0) {$classone_list.="<tr align=center>$classone</tr>";
      	         	             $classone="";
      	         	             $i=0;
      	         	            }
      	         	            
      	         }
         elseif ($temptime>12 AND $temptime<=24){
         	       $j++;
         	       $classtwo.="<td height=24 class=td1 width=25%><a href=?filename=class&action=class&classid=$r[id]>����($classid)��</a></td>";
      	         if ($j%4==0) {$classtwo_list.="<tr align=center>$classtwo</tr>";
      	         	             $classtwo="";
      	         	             $j=0;
      	         	            }
      	         	}
         elseif ($temptime>24 AND $temptime<=36){
         	       $k++;
         	       $classthree.="<td height=24 class=td1 width=25%><a href=?filename=class&action=class&classid=$r[id]>����($classid)��</a></td>";
      	         if ($k%4==0) {$classthree_list.="<tr align=center>$classthree</tr>";
      	         	             $classthree="";
      	         	             $k=0;
      	         	            }
      	         	}
}
      if ($i%4!=0){
      	for ($l=$i;$l<4;$l++) $classone.="<td height=24 class=td1 width=25%>&nbsp;</td>";
        $classone_list.="<tr align=center>$classone</tr>";
        }    
      if ($j%4!=0){
      	for ($l=$j;$l<4;$l++) $classtwo.="<td height=24 class=td1 width=25%>&nbsp;</td>";
        $classtwo_list.="<tr align=center>$classtwo</tr>";
        }     
      if ($k%4!=0){
      	for ($l=$k;$l<4;$l++) $classthree.="<td height=24 class=td1 width=25%>&nbsp;</td>";
        $classthree_list.="<tr align=center>$classthree</tr>";
        }            
	    $class_list="	$classone_list$classtwo_list$classthree_list";
$head_nav="�༶��Ϣ����";
$admin_nav="<a href=\"?filename=class&action=list\">�༶��Ϣ�б�</a> | 
            <a href=\"?filename=class&action=adminlist\">�༶��������</a>
            	";
$now_nav="�༶��Ϣ�б�";
eval("\$class_list = \"".gettemplate('class_list')."\";");
$templatetitle="class";	    
break;
case 'adminlist':
//��ȡ�༶��Ϣ
$startyear=mktime(0,0,0,7,1,date(Y)-3);
$query="select * from $table_class where  buildtime>=$startyear order by buildtime Desc";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //�༶
      $classid=substr($r[classid],5,1);
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
      $temptime=$nowtime-$r[buildtime];
      $temptime=round($temptime/2592000);
      if ($temptime>0 ANd $temptime<=12) {
                  $class_name="��һ($classid)��";          
      	         }
         elseif ($temptime>12 AND $temptime<=24){
         	       $class_name="����($classid)��";      	      
      	         }
         elseif ($temptime>24 AND $temptime<=36){
         	       $class_name="����($classid)��";
      	         	}   
      if ($r[classadmin]==0){$classadmin="δ����";}	 
      else{
      	$query="select realname from members where userid=$r[classadmin] limit 1";
      	$rr=$db->query_first($query);
      	$classadmin=$rr[realname];
      	};        	
    $class_list.="
    				    <tr  align=center>
				    		 	<td  height=24  class=td1 >$r[id]</td>
				    		 	<td  height=24  class=td1 >$class_name</td>
				    		 	<td  height=24  class=td1 >$r[classnumber]</td>
				    		 	<td  height=24  class=td1>$classadmin</td>
				    		 	<td  height=24  class=td1 ><input type=button name=ww value=���ð�����></td>
					       </tr>
    ";      	         

}
$head_nav="�༶��Ϣ����";
$admin_nav="<a href=\"?filename=class&action=list\">�༶��Ϣ�б�</a> | 
            <a href=\"?filename=class&action=adminlist\">�༶��������</a>
            	";
$now_nav="�༶��Ϣ�б�";
eval("\$class_list = \"".gettemplate('class_adminlist')."\";");
$templatetitle="class";	
break;
//ĳ�༶��ѧ���б�
case 'class':
//��ȡ�����ð༶��Ϣ
$query="select * from $table_class where  id=$classid";
$r=$db->query_first($query);
$buildtime=$r[buildtime];
$classnumber=$r[classnumber];
$class_id=substr($r[classid],5,1);
$nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
$temptime=$nowtime-$buildtime;
$temptime=round($temptime/2592000);
if ($temptime>0 ANd $temptime<=12) {
                  $class_name="��һ($classid)��";          
      	         }
         elseif ($temptime>12 AND $temptime<=24){
         	       $class_name="����($classid)��";      	      
      	         }
         elseif ($temptime>24 AND $temptime<=36){
         	       $class_name="����($classid)��";
      	         	}   
//��ȡ��������Ϣ
if ($r[classadmin]==0){
	  $classadmin="δ����";
}else{
	  $query="select * from members where  userid=$r[classadmin] limit 1 ";
	  $r=$db->query_first($query);
	  $classadmin=$r[realname];
}     	         	   
//��ȡѧ����Ϣ 
switch($type){
case '1':
//ҳ�����ÿ�ʼ
$perpage=10;
 $sql = "SELECT count(*) FROM $table_student where classid=$classid ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=class&action=class&classid=$classid&type=1");      
 //ҳ�����ý���
 $query="select * from $table_student where  classid=$classid order by stnumber limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $studentone.="
          <TABLE cellSpacing=2 cellPadding=1 width=\"100%\" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=24 width=6% class=tr_head >ѧ ��</td>
				    		 	<td  height=24 width=6% class=tr_head >�� ��</td>
				    		 	<td  height=24 width=5% class=tr_head >�Ա�</td>
				    		 	<td  height=24 width=10% class=tr_head >��������</td>
				    		 	<td  height=24 width=5% class=tr_head >״̬</td>
				    		 	<td  height=24 width=10%  class=tr_head >��ҵѧУ</td>				    		 	
				    		 	<td  height=24 width=10% class=tr_head >��ĸ����</td>
				    		 	<td  height=24 width=30% class=tr_head >������λ</td>
				    		 	<td  height=24  class=tr_head >�绰</td>
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
				    		 	<td  height=24  class=tr_head2 colspan=3>����</td>
				    		 	<td  height=24  class=tr_head2 colspan=3>��ͥ��ַ</td>
				    		 	<td  height=24  class=td1 >$r[mother]</td>
				    		 	<td  height=24  class=td1>$r[mowork]</td>
				    		 	<td  height=24  class=td1 >$r[motel]</td>
					       </tr>
					       <tr  align=center>
				    		 	<td  height=24  class=td1 colspan=3>$r[hreg]</td>
				    		 	<td  height=24  class=td1 colspan=3>$r[address]</td>
				    		 	<td  height=24  class=tr_head2 >��ע</td>
				    		 	<td  height=24  class=td1>$r[note]</td>
				    		 	<td  height=24  class=td1 ><input type=button name=edit value=�༭><input type=button name=edit value=ɾ��></td>
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
$class_list=$studentone;
break;
default :
$i=0;     	         	
$query="select * from $table_student where  classid=$classid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $i++;
      $stnumber=substr($r[stnumber],6,2);
      $studentone.="<td height=24 class=td1 width=20%><a href=?filename=class&action=class&classid=$r[id]>$r[name]($stnumber)</a></td>";
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
$class_list=$studentone_list;
break;	
}

$head_nav="�༶��Ϣ����";
$admin_nav="<a href=\"?filename=class&action=list\">�༶��Ϣ�б�</a> | 
            <a href=\"?filename=class&action=adminlist\">�༶��������</a>
            	";
$now_nav="�༶��Ϣ�б�";
$tow_nav="(<a href=?filename=class&action=class&classid=$classid&type=0>��ͨ�б�</a>--<a href=?filename=class&action=class&classid=$classid&type=1>��ϸ�б�</a>)";
eval("\$class_list = \"".gettemplate('class_classlist')."\";");
$templatetitle="class";	
break;
//ѧ����Ϣ�б�
case 'list':
//ҳ�����ÿ�ʼ
 $sql = "SELECT count(*) FROM $table_student";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=student&action=list");      
 //ҳ�����ý���
//��¼���ݵĶ�ȡ
$i=1;
$class_style="td1";
$query="select $table_student.*,$table_class.buildtime  from $table_student 
            LEFT JOIN $table_class ON $table_student.classid=$table_class.id
            order by $table_student.id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      //����ѧ���Ƿ���У����תУ
      if ($r[state]==0) {$r[state]="��У";} else {$r[state]="ת��";};
      //�༶
      $classid=substr($r[stnumber],5,1);
      $nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
      $temptime=$nowtime-$r[buildtime];
      $temptime=round($temptime/2592000);
    if ($temptime>0 ANd $temptime<=12) {$class="��һ($classid)";}
    elseif ($temptime>12 AND $temptime<=24){$class="����($classid)";}
    elseif ($temptime>24 AND $temptime<=36){$class="����($classid)";}
      $student_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style>$r[id]</td>
			              <td align=center class=$class_style>$r[stnumber]</td>
					          <td align=center class=$class_style>$r[name]</td>
				            <td align=center class=$class_style>$r[sex]</td>
				            <td align=center class=$class_style>".date("Y.m",$r[birthday])."</td>
				            <td align=center class=$class_style>$class</td>
				            <td align=center class=$class_style>$r[state]</td>
				            <td align=center class=$class_style>  <a href=\"#\" onclick=popUp('studentedit','$i','$r[id]')>�޸�</a> | <a href=\"#\" onclick=popUp('studentdel','$i','$r[id]')>ȡ��</a></td>				
				           </tr>     
		               "; 
		  if ($class_style=="td1") $class_style="td2";else $class_style="td1";                         
}
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=student&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
<body>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
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
  <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		  <form action="?filename=deal&action=studentadd"  method="post" name="form1" >
				    		 <tr  align=center>
				    		 	<td  width=15% height=24 class=tr_head>����</td>
						   	  <td  class=tr_head>ѧ ��</td>
					  		  <td  class=tr_head>�� ��</td>
					  		  <td  class=tr_head>�� ��</td>
					  		  <td  class=tr_head>��������</td>
					  		  <td  class=tr_head>�� ��</td>
					  		  <td  class=tr_head>״ ̬</td>
					  		  <td  class=tr_head>�� ��</td>				
					       </tr>
				    		 <?=$student_list;?>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head colspan=8><?=$pagenav;?></td>
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
      <TD align=middle height=24>
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	</td>
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
}
//β���ļ��Ķ�ȡ
eval("\$footer = \"".gettemplate('footer')."\";");
//���ļ�������������
eval("dooutput(\"".gettemplate($templatetitle)."\");");//����������
?>