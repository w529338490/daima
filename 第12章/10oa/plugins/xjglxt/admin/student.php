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
switch($action){
case 'insert':
if ($limit>2)  showmessage("�Բ�����û��Ȩ�޲������ѧ����Ϣ!");
//��ȡ�ļ���Ϣ����ʾ����
require("./include/file_class.php");
$filepath=$updir."$fileid";
// set fl
$fl = new File_class;
$fl->file=$filepath;
$h=$fl->getlines();
$line=$fl->read_file();
for ($i=0;$i<$h;$i++){
	$out=explode("\t", $line[$i]);
	//$student_data=$i;//���ݴ��ݷ���һ
	//���ݴ��ݷ�����
	$student_data=trim($out[0])."|".trim($out[1])."|".trim($out[2])."|".trim($out[3])."|".trim($out[4])."|".trim($out[5])."|".trim($out[6])."|".trim($out[7])."|".trim($out[8])."|".trim($out[9])."|".trim($out[10])."|".trim($out[11])."|".trim($out[12])."|".trim($out[13]);
	$student_list.="<tr  align=center>
	                <td  height=24 class=td1><input type=\"checkbox\" name=\"stdata\" value=\"$student_data\">  </td>
						   	  <td   class=td1>".$i."</td>
					  		  <td  class=td1>".trim($out[0])."</td>
						  	  <td  class=td1>".trim($out[1])."</td>
						  	  <td  class=td1>".trim($out[2])."</td>
					  		  <td  class=td1>".trim($out[3])."</td>
						  	  <td  class=td1>".trim($out[4])."</td>
						  	  <td  class=td1>".trim($out[5])."</td>
						  	  <td  class=td1>".trim($out[6])."</td>
						  	  <td  class=td1>".trim($out[7])."</td>
						  	  <td  class=td1>".trim($out[8])."</td>
					  		  <td  class=td1>".trim($out[9])."</td>
						  	  <td  class=td1>".trim($out[10])."</td>
						  	  <td  class=td1>".trim($out[11])."</td>
						  	  <td  class=td1>".trim($out[12])."</td>
						  	  <td  class=td1>".trim($out[13])."</td>						  	  						  	  
					       </tr>
					       ";

	
	}

//ѧ�ű��빲8λ��ҵ������2��ѧУ��ţ�2���༶��ţ�2��ѧ����ţ�2��
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
  function checklistid() 
{ 
var strchoice=""; 
for(var i=0;i<document.form1.stdata.length;i++) 
{ 
if (document.form1.stdata[i].checked) 
{ 
strchoice=strchoice+document.form1.stdata[i].value+","; 
} 
} 
if (!document.form1.stdata.length) 
{ 
if (document.form1.stdata.checked) 
{ 
strchoice=document.form1.stdata.value+","; 
} 
}
strchoice=strchoice.substring(0,strchoice.length-1);
document.form1.student_data.value=strchoice;

} 
function CheckAll()
{
for (var i=0;i<document.form1.elements.length;i++)
{
var e = document.form1.elements[i];
if (e.name == 'stdata')
e.checked = true;
}
}
function CheckNone()
{
for (var i=0;i<document.form1.elements.length;i++)
{
var e = document.form1.elements[i];
if (e.name == 'stdata')
e.checked = false;
}
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>ѧ����Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=student&action=list">ѧ����Ϣ�б�</A>  | 
            	<A href="?filename=student&action=up">ѧ����Ϣ���</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>��ǰλ�ã�ѧ����Ϣ���� >> ѧ����Ϣ����б�(�ڶ���)</strong></td>
     </tr>
    </TABLE>
 
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
				    		 	<td  width=15% height=24 class=tr_head><input type="button" name="allbox" value="ѡ��" onClick="CheckAll();">
           <input type="button" name="nonebox" value="ȡ��" onClick="CheckNone();"></td>
						   	  <td  class=tr_head>����</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[0]>
					  		  	<option value=stnumber selected>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
					  		  </td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[1]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name selected>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[2]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex selected>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[3]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday selected>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[4]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father selected>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[5]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork selected>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						   	  <td  class=tr_head>
						   	  	<select name=list_type[6]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel selected>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						   	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[7]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother selected>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[8]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork selected>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[9]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel selected>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[10]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address selected>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
						  	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[11]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg selected>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
					  		  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[12]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool selected>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note>�� ע</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[13]>
					  		  	<option value=stnumber>ѧ ��</option>
					  		  	<option value=name>�� ��</option>
					  		  	<option value=sex>�� ��</option>
					  		  	<option value=birthday>��������</option>
					  		  	<option value=gschool>��ҵѧУ</option>
					  		  	<option value=father>�� ��</option>
					  		  	<option value=fawork>������λ</option>
					  		  	<option value=fatel>�� ��</option>
					  		  	<option value=mother>ĸ ��</option>
					  		  	<option value=mowork>������λ</option>
					  		  	<option value=motel>�� ��</option>
					  		  	<option value=address>��ͥ��ַ</option>
					  		  	<option value=hreg>�� ��</option>
					  		  	<option value=note selected>�� ע</option>
					  		    </select>
						  	  	</td>						  	  
					       </tr>
				    		 <?=$student_list;?>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head>
				    		 		<input type="button" name="allbox" value="ѡ��" onClick="CheckAll();">
                     <input type="button" name="nonebox" value="ȡ��" onClick="CheckNone();"></td>
						   	  <td  class=tr_head colspan=14 align=left>�趨���ڸ�ʽ��
						   	  	<select name=birthday_type>
                     <option value=0>2001.11</option>
                     <option value=1>2001��11��</option>
                     <option value=2>2001/11</option>
						   	  	</select>
					  		  	<input type=hidden name=student_data>
					  		  	<input type=hidden name=fileid value=<?=$fileid;?>>
					  		  	<input type=submit name=sub value=" �� ʼ �� �� " onclick=checklistid()></td>
						  	  <td  class=tr_head></td>
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
case 'in': 
if ($limit>2)  showmessage("�Բ�����û��Ȩ�޲������ѧ����Ϣ!");
//��ȡĿ¼�����ϴ����ļ�	
$handle=opendir("./data");
$i=1;
while (false !== ($file = readdir($handle))) {
$i++;
if (($file==".") or ($file=="..") or ($file=="index.htm")) continue;
$filemod = filemtime("./data/$file");
$filemodtime = date(" m n Y h:i:s", $filemod);
$filename=explode(".",$file);
$filename=$filename[0];
$list_file.="<tr bgColor=\"#f1f3f5\" onmouseout=\"this.style.backgroundColor='#F1F3F5'\" onmouseover=\"this.style.backgroundColor='#BFDFFF'\">
               <td align=center height=24 width=80>
               <input type=button name=aa value=ɾ�� onclick=delfile('./data/$file')>
               </td>
               <td align=left>
               <a href=?filename=student&action=insert&fileid=$file>./data/$file</a>$filemodtime
               </td>
             </tr>  
             ";
}
closedir($handle);
//ѧ�ű��빲8λ��ҵ������2��ѧУ��ţ�2���༶��ţ�2��ѧ����ţ�2��
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>ѧ����Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=student&action=list">ѧ����Ϣ�б�</A>  | 
            	<A href="?filename=student&action=up">ѧ����Ϣ���</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>��ǰλ�ã�ѧ����Ϣ���� >> ѧ����Ϣ���(��һ��)</strong></td>
     </tr>
    </TABLE>
  <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=0 cellPadding=0 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		  
				    		 <tr  align=center>
						   	  <td  class=tr_head height=28 colspan=2>ѧ����Ϣ�ļ��б�</td>
					       </tr>
					       <?=$list_file;?>
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
case 'up':   
if ($limit>2)  showmessage("�Բ�����û��Ȩ�޲������ѧ����Ϣ!");
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>ѧ����Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=student&action=list">ѧ����Ϣ�б�</A>  | 
            	<A href="?filename=student&action=up">ѧ����Ϣ���</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><strong>��ǰλ�ã�ѧ����Ϣ���� >> ѧ����Ϣ�ϴ�(��һ��)</strong></td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder_2 width="100%"  >
        <!--DWLayoutTable-->  
        <TBODY>
        <form method="post" action="?filename=deal&action=upfile" name="form1" enctype="multipart/form-data" >
            <TR> 
            <TH colSpan=2 class=tr_head2>ѧ����Ϣ�ϴ�</TH>
          </TR>
          <tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align=right>ѡ���ļ�:</td>
        <td align=left>
        	<input type="file" class="TxtInput" tabindex="1" name="upfile" style="WIDTH: 282px">
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
        	  <input type=hidden name=up value=1>
            <input type="submit" name="ifupload" value=" ȷ �� ">&nbsp;
            <input type="reset" name="re" value=" ȡ �� ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       </tr>
          </form>
        </tbody>
     </table>
    </td> 
    </tr>   
</table>
</body>
</html>
<?
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
            LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
            order by $table_student.id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      //����ѧ���Ƿ���У����תУ
      if ($r[state]==0) {$r[state]="��У";} else {$r[state]="תѧ";};
      //�Ƿ������˰༶
      if ($r[buildtime]){
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
      } 
      else $classname="<a href=?filename=deal&action=classaddone&classid=$r[classid]>������ð༶</a>";	  
      $student_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style >$r[id]</td>  
			              <td align=center class=$class_style>$classname</td>
			              <td align=center class=$class_style>$r[name]</td>
			              <td align=center class=$class_style>$r[stnumber]</td>					          
				            <td align=center class=$class_style>$r[sex]</td>
				            <td align=center class=$class_style>".date("Y.m",$r[birthday])."</td>
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
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 class=tableborder_2>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>ѧ����Ϣ����</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>����ѡ�</B> 
            	<A href="?filename=student&action=list">ѧ����Ϣ�б�</A>  |
            	<A href="?filename=student&action=up">ѧ����Ϣ���</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>��ǰλ�ã�ѧ����Ϣ���� >> ѧ����Ϣ�ϴ�</strong></td>
     </tr>
    </TABLE>
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
				    		 	<td  width=30 height=24 class=tr_head>����</td>
				    		 	<td  class=tr_head>�� ��</td>  
				    		 	<td  class=tr_head>�� ��</td>
						   	  <td  class=tr_head>ѧ ��</td>
					  		  <td  class=tr_head>�� ��</td>
					  		  <td  class=tr_head>��������</td>
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
      <TD align=middle height=24></td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      �����ʼ� ����֧��</td>
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
?>