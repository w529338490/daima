<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
/************************************************************/
//Ȩ������
$sql="SELECT * FROM `$table_manage` where admin=$user_id limit 1";
$r=$db->query_first($sql);
$limit=$r[groupid];   
/***********************************************************/
if (!isset($action)) $action="list";
switch($action){
case 'add'://��Ӱ༶��Ϣ
if ($limit>2)  showmessage("�Բ�����û��Ȩ�޲�����Ӱ༶��Ϣ!");
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
   		alert("����ѧʱ��!");
		theform.styear.focus();
		return false ;
   }
   if(theform.stclassnumb.value == "" )
   {
   		alert("�����뿪ʼ�༶!");
		theform.stclassnumb.focus();
		return false ;
   }
      if(theform.endclassnumb.value == "")
   {
   		alert("����������༶");
		theform.endclassnumb.focus();
		return false ;
   }
   if(theform.endclassnumb.value < theform.stclassnumb.value)
   {
   		alert("����ȷ����༶");
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>�༶��Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=class&action=list">�༶�б�</A>  |
            	<A href="?filename=class&action=add">��Ӱ༶</A>  |
            	<A href="?filename=class&action=adminlist">����������</A> 
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
				    		 <th colspan=3 height=28 class=tr_head2>��Ӱ༶				     		 
				    		</th>
					       </tr>
					       <tr align=center>
      	             <td height=24 class=td1 colspan=3></td>
      	          </tr>
      	          <tr align=center>
      	             <td height=24 width=50 class=td1><b>���:</b></td>
      	             <td height=24 class=td1 align=left valign=middle colspan=2>
      	             	   <b>��ѧʱ��:</b><input type="text" name=styear value="" size=8>��
                         <b>�༶����</b><input type="text" name=stclassnumb value="" size=8>
                         ��<input type="text" name=endclassnumb value="" size=8>
                         <input type=submit name=s value="��ʼ��Ӱ༶">
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
      	Powered By <b>slcms ѧ������ϵͳ Version 1.0.1 ��2007��</b> ������ƣ������������ҡ�</td>
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
case 'list'://ѧУ�༶��Ϣ�б�
if (!isset($gradeid)) $gradeid=0;
switch ($gradeid){
case '0':
$where="order by buildtime desc,classid asc";
break;	
case '1':
case '2':
case '3':
//��Уʱ�����:8��1��Ϊ��ѧ�ڵĿ�ʼ����
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
//���ݶ�ȡ
$query="select * from $table_class $where ";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //�༶
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
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
      //�༶��������
      $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=0";
      $t=$db->query_first($sql);
      $sttotal_online=$t[0];
      //�༶תУ����	 
      $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=1";
      $t=$db->query_first($sql);
      $sttotal_out=$t[0]; 
      //�༶������
      $sttotal=$sttotal_online+$sttotal_out;
      //������
      $classadmin="δ����";
      //��ʾ����	        	
      $class_list.="<tr align=center>
      	             <td height=24 class=td1 width=25%><a href=?filename=class&action=class&classid=$r[classid]>$classname</a></td>
      	             <td class=td1>".$bytime."��</td>
      	             <td class=td1>".$sttotal."��</td>
      	             <td class=td1>".$sttotal_online."��</td>
                     <td class=td1>".$sttotal_out."��</td>
      	             <td class=td1>$classadmin</td>
      	             <td class=td1><a href=?filename=class&action=class&classid=$r[classid]>�鿴</a> 
      	                           �༭ 
      	                           ɾ��</td>
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>�༶��Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=class&action=list">�༶�б�</A>  |
            	<A href="?filename=class&action=add">��Ӱ༶</A>  |
            	<A href="?filename=class&action=adminlist">����������</A> 
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
				    		 	<td  height=28 class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=0>ȫ��</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=1>��һ</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=2>����</a></td>
				    		 	<td   class=tr_head width=40 align=center><a href=?filename=class&action=list&gradeid=3>����</a></td>
				    		 	<td   class=tr_head >��ѯ</td>
				    		 </tr>
				    		</table>
				    		</td>
					       </tr>
					       <tr align=center>
      	             <td height=24 class=td1 width=25%>�༶����</td>
      	             <td class=td1>��ҵʱ��</td>
      	             <td class=td1>�༶������</td>
      	             <td class=td1>ʵ������</td>
                     <td class=td1>תУ����</td>
      	             <td class=td1>������</td>
      	             <td class=td1>����</td>
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
      	Powered By <b>slcms ѧ������ϵͳ Version 1.0.1 ��2007��</b> ������ƣ������������ҡ�</td>
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
//��ȡ�༶��Ϣ
if ($limit>2)  showmessage("�Բ�����û��Ȩ�޲������ð�����!");
$startyear=mktime(0,0,0,7,1,date(Y)-3);
$query="select * from $table_class where  buildtime>=$startyear order by buildtime Desc";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    //�༶
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
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
      if ($r[classadmin]==0){$classadmin="δ����";}	 
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
				    		 	<td  height=24  class=td1 ><input type=button name=ww value=���ð�����></td>
					       </tr>
    ";      	         

}
//ѧ�ű��빲8λ��ҵ������2��ѧУ��ţ�2���༶��ţ�2��ѧ����ţ�2��
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
						   	  <td  class=tr_head height=28 colspan=5>ѧ����Ϣ�ļ��б�</td>
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
<?	
break;
//ĳ�༶��ѧ���б�
case 'class':
//��ȡ�����ð༶��Ϣ
$query="select * from $table_class where  classid=$classid";
$r=$db->query_first($query);
	    //�༶
      $class_id=substr($r[classid],4,2);
      if ($class_id<10)$class_id=substr($class_id,1,1);
      //��ҵʱ��
      $bytime=substr(date('Y',$r[buildtime]),0,2).substr($r[classid],0,2);
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
//�༶��������
$sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=0";
$t=$db->query_first($sql);
$sttotal_online=$t[0];
//�༶תУ����	 
$sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$r[classid]%') and state=1";
$t=$db->query_first($sql);
$sttotal_out=$t[0]; 
//�༶������
$sttotal=$sttotal_online+$sttotal_out;   	      	         	
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
 $sql = "SELECT count(*) FROM $table_student where `stnumber` like ('$classid%') ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=class&action=class&classid=$classid&type=1");      
 //ҳ�����ý���
 $query="select * from $table_student where  `stnumber` like ('$classid%') order by stnumber limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $studentone.="
          <TABLE cellSpacing=2 cellPadding=1 width=\"98%\" align=center border=0 class=table1>
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>�༶��Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> <A 
      href="?filename=class&action=list">�༶��Ϣ�б�</A>  | <A 
      href="?filename=class&action=adminlist">�༶��������</A> 
      </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><strong>��ǰλ�ã��༶��Ϣ���� >>
      	 <A href="?filename=class&action=list">�༶��Ϣ�б�</a></strong>
      (<a href=?filename=class&action=class&classid=<?=$classid;?>&type=0>��ͨ�б�</a>--<a href=?filename=class&action=class&classid=<?=$classid;?>&type=1>��ϸ�б�</a>)</td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head2 colspan=5><?=$classname;?>ѧ���б�(���๲��<?=$sttotal;?>��)----������[<font color=red><?=$classadmin;?></font>]
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