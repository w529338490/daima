<?php
/*
����ɽ��Сѧ����칫��
*/
/************************************************************/
//ģ���ʼ��
$templatesused.="result,result_up,footer";
cachetemplates($templatesused);
switch($action){
case 'insert':
//��ȡ�ļ���Ϣ����ʾ����
require("./include/file_class.php");
$updir="./attach/$class_id/";
$filepath="$updir$fileid";
// set fl
$fl = new File_class;
$fl->file=$filepath;
$h=$fl->getlines();
$line=$fl->read_file();
for ($i=0;$i<$h;$i++){
	$out=explode("|", $line[$i]);
	//$student_data=$i;//���ݴ��ݷ���һ
	//���ݴ��ݷ�����
	$result_data=trim($out[0])."|".trim($out[1])."|".trim($out[2])."|".trim($out[3])."|".trim($out[4])."|".trim($out[5])."|".trim($out[6])."|".trim($out[7]);
	$result_list.="<tr  align=center>
	                <td  height=24 class=td1><input type=\"checkbox\" name=\"stdata\" value=\"$result_data\">  </td>
						   	  <td   class=td1>".$i."</td>
					  		  <td  class=td1>".trim($out[0])."</td>
						  	  <td  class=td1>".trim($out[1])."</td>
						  	  <td  class=td1>".trim($out[2])."</td>
					  		  <td  class=td1>".trim($out[3])."</td>
						  	  <td  class=td1>".trim($out[4])."</td>
						  	  <td  class=td1>".trim($out[5])."</td>
						  	  <td  class=td1>".trim($out[6])."</td>
						  	  <td  class=td1>".trim($out[7])."</td>						  	  						  	  
					       </tr>
					       ";

	
	}
$head_nav="ѧ���ɼ�����";
$admin_nav="<A href=\"?filename=result&action=up\">ѧ���ɼ��ϴ�</A>  | 
            	<A href=\"?filename=result&action=in\">ѧ���ɼ����</A>  | 
            	<A href=\"?filename=result&action=list\">ѧ���ɼ��б�</A> 
            	"; 
$now_nav="ѧ���ɼ��ϴ�";
eval("\$result_list = \"".gettemplate('result_insert')."\";");
$templatetitle="result";
break;
case 'in':
//��ȡĿ¼�����ϴ����ļ�	
$updir="./attach/$class_id/";
$handle=opendir($updir);
$i=1;
while (false !== ($file = readdir($handle))) {
$i++;
if (($file==".") or ($file=="..") or ($file=="index.htm")) continue;
$filename=explode(".",$file);
$filename=$filename[0];
$list_file.="<tr bgColor=\"#f1f3f5\" onmouseout=\"this.style.backgroundColor='#F1F3F5'\" onmouseover=\"this.style.backgroundColor='#BFDFFF'\">
               <td align=center height=24 width=80>
               <input type=button name=aa value=ɾ�� onclick=delfile('./data/$file')>
               </td>
               <td align=left>
               <a href=?filename=result&action=insert&fileid=$file>$file</a>
               </td>
             </tr>  
             ";
}
closedir($handle);
$head_nav="ѧ���ɼ�����";
$admin_nav="<A href=\"?filename=result&action=up\">ѧ���ɼ��ϴ�</A>  | 
            	<A href=\"?filename=result&action=in\">ѧ���ɼ����</A>  | 
            	<A href=\"?filename=result&action=list\">ѧ���ɼ��б�</A> 
            	"; 
$now_nav="ѧ���ɼ����";
eval("\$result_list = \"".gettemplate('result_in')."\";");
$templatetitle="result";
break;
case 'up':
$head_nav="ѧ���ɼ�����";
$admin_nav="<A href=\"?filename=result&action=up\">ѧ���ɼ��ϴ�</A>  | 
            	<A href=\"?filename=result&action=in\">ѧ���ɼ����</A>  | 
            	<A href=\"?filename=result&action=list\">ѧ���ɼ��б�</A> 
            	"; 
$now_nav="ѧ���ɼ��ϴ�";
eval("\$result_list = \"".gettemplate('result_up')."\";");
$templatetitle="result";
break;
//����ѧ���ɼ��б�
case 'list':
//ҳ�����ÿ�ʼ
 $sql = "SELECT count(*) FROM $table_result where `stnumber`='$class_id'";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=result&action=list");      
 //ҳ�����ý���
//��¼���ݵĶ�ȡ
$i=1;
$class_style="td1";
$query="select * from $table_result 
                 where `stnumber`='$class_id'
                 order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $intime=date("Y/m/d",$r[intime]);
      $result_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style>$r[id]</td>
			              <td align=center class=$class_style><a href=\"?filename=result&action=listone&id=$r[id]\">$r[note]</a></td>
			              <td align=center class=$class_style>$intime</td>
				            <td align=center class=$class_style>  <a href=\"?filename=result&action=listone&id=$r[id]\" >�鿴</a> | <a href=\"?filename=result&action=delone&id=$r[id]\">ɾ��</a></td>				
				           </tr>     
		               "; 
		  if ($class_style=="td1") $class_style="td2";else $class_style="td1";                         
}
$head_nav="ѧ���ɼ�����";
$admin_nav="<A href=\"?filename=result&action=up\">ѧ���ɼ��ϴ�</A>  | 
            	<A href=\"?filename=result&action=in\">ѧ���ɼ����</A>  | 
            	<A href=\"?filename=result&action=list\">ѧ���ɼ��б�</A> 
            	"; 
$now_nav="ѧ���ɼ��б�";
eval("\$result_list = \"".gettemplate('result_list')."\";");
$templatetitle="result";
break;
//����ѧ������ɼ��б�
case 'listone':
//��¼���ݵĶ�ȡ
$i=1;
$class_style="td1";
$sql = "SELECT count(*) FROM $table_result where averageid=$id";
$result = $db->query_first($sql);
$totalnum=$result[0];
$query="select $table_result.*,$table_student.name  from $table_result 
            LEFT JOIN $table_student ON $table_result.stnumber=$table_student.stnumber
             where $table_result.averageid='$id' 
            order by $table_result.id  limit 0,$totalnum";            
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $intime=date("Y/m/d",$r[intime]);
      $result_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style>$r[stnumber]</td>
			              <td align=center class=$class_style>$r[name]</td>
			              <td align=center class=$class_style>$r[yw]</td>
			              <td align=center class=$class_style>$r[sx]</td>
			              <td align=center class=$class_style>$r[wy]</td>
			              <td align=center class=$class_style>$r[kx]</td>
			              <td align=center class=$class_style>$r[sz]</td>
			              <td align=center class=$class_style>$r[ls]</td>
				            <td align=center class=$class_style>  <a href=\"#\" >�޸�</a> </td>				
				           </tr>     
		               "; 
		  if ($class_style=="td1") $class_style="td2";else $class_style="td1";                         
}
$head_nav="ѧ���ɼ�����";
$admin_nav="<A href=\"?filename=result&action=up\">ѧ���ɼ��ϴ�</A>  | 
            	<A href=\"?filename=result&action=in\">ѧ���ɼ����</A>  | 
            	<A href=\"?filename=result&action=list\">ѧ���ɼ��б�</A> 
            	"; 
$now_nav="ѧ���ɼ��б�";
eval("\$result_list = \"".gettemplate('result_listone')."\";");
$templatetitle="result";
break;
}
//β���ļ��Ķ�ȡ
eval("\$footer = \"".gettemplate('footer')."\";");
//���ļ�������������
eval("dooutput(\"".gettemplate($templatetitle)."\");");//����������
?>