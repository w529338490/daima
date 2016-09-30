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
switch($action){
case 'insert':
if ($limit>2)  showmessage("对不起你没有权限操作添加学生信息!");
//读取文件信息并显示出来
require("./include/file_class.php");
$filepath=$updir."$fileid";
// set fl
$fl = new File_class;
$fl->file=$filepath;
$h=$fl->getlines();
$line=$fl->read_file();
for ($i=0;$i<$h;$i++){
	$out=explode("\t", $line[$i]);
	//$student_data=$i;//数据传递方法一
	//数据传递方法二
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

//学号编码共8位毕业年数（2）学校编号（2）班级编号（2）学生编号（2）
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>学生信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=student&action=list">学生信息列表</A>  | 
            	<A href="?filename=student&action=up">学生信息入库</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>当前位置：学生信息管理 >> 学生信息入库列表(第二步)</strong></td>
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
				    		 	<td  width=15% height=24 class=tr_head><input type="button" name="allbox" value="选中" onClick="CheckAll();">
           <input type="button" name="nonebox" value="取消" onClick="CheckNone();"></td>
						   	  <td  class=tr_head>序列</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[0]>
					  		  	<option value=stnumber selected>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
					  		  </td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[1]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name selected>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[2]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex selected>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[3]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday selected>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[4]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father selected>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[5]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork selected>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						   	  <td  class=tr_head>
						   	  	<select name=list_type[6]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel selected>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						   	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[7]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother selected>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[8]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork selected>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[9]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel selected>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[10]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address selected>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
						  	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[11]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg selected>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
					  		  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[12]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool selected>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note>备 注</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[13]>
					  		  	<option value=stnumber>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=sex>性 别</option>
					  		  	<option value=birthday>出生年月</option>
					  		  	<option value=gschool>毕业学校</option>
					  		  	<option value=father>父 亲</option>
					  		  	<option value=fawork>工作单位</option>
					  		  	<option value=fatel>电 话</option>
					  		  	<option value=mother>母 亲</option>
					  		  	<option value=mowork>工作单位</option>
					  		  	<option value=motel>电 话</option>
					  		  	<option value=address>家庭地址</option>
					  		  	<option value=hreg>户 籍</option>
					  		  	<option value=note selected>备 注</option>
					  		    </select>
						  	  	</td>						  	  
					       </tr>
				    		 <?=$student_list;?>
				    		 <tr  align=center>
				    		 	<td  height=24 class=tr_head>
				    		 		<input type="button" name="allbox" value="选中" onClick="CheckAll();">
                     <input type="button" name="nonebox" value="取消" onClick="CheckNone();"></td>
						   	  <td  class=tr_head colspan=14 align=left>设定日期格式：
						   	  	<select name=birthday_type>
                     <option value=0>2001.11</option>
                     <option value=1>2001年11月</option>
                     <option value=2>2001/11</option>
						   	  	</select>
					  		  	<input type=hidden name=student_data>
					  		  	<input type=hidden name=fileid value=<?=$fileid;?>>
					  		  	<input type=submit name=sub value=" 开 始 入 库 " onclick=checklistid()></td>
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
case 'in': 
if ($limit>2)  showmessage("对不起你没有权限操作添加学生信息!");
//读取目录里面上传的文件	
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
               <input type=button name=aa value=删除 onclick=delfile('./data/$file')>
               </td>
               <td align=left>
               <a href=?filename=student&action=insert&fileid=$file>./data/$file</a>$filemodtime
               </td>
             </tr>  
             ";
}
closedir($handle);
//学号编码共8位毕业年数（2）学校编号（2）班级编号（2）学生编号（2）
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>学生信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=student&action=list">学生信息列表</A>  | 
            	<A href="?filename=student&action=up">学生信息入库</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>当前位置：学生信息管理 >> 学生信息入库(第一步)</strong></td>
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
						   	  <td  class=tr_head height=28 colspan=2>学生信息文件列表</td>
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
case 'up':   
if ($limit>2)  showmessage("对不起你没有权限操作添加学生信息!");
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>学生信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=student&action=list">学生信息列表</A>  | 
            	<A href="?filename=student&action=up">学生信息入库</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><strong>当前位置：学生信息管理 >> 学生信息上传(第一步)</strong></td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder_2 width="100%"  >
        <!--DWLayoutTable-->  
        <TBODY>
        <form method="post" action="?filename=deal&action=upfile" name="form1" enctype="multipart/form-data" >
            <TR> 
            <TH colSpan=2 class=tr_head2>学生信息上传</TH>
          </TR>
          <tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align=right>选择文件:</td>
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
            <input type="submit" name="ifupload" value=" 确 定 ">&nbsp;
            <input type="reset" name="re" value=" 取 消 ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
//学生信息列表
case 'list':
//页码设置开始
 $sql = "SELECT count(*) FROM $table_student";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=student&action=list");      
 //页码设置结束
//记录数据的读取
$i=1;
$class_style="td1";
$query="select $table_student.*,$table_class.buildtime  from $table_student 
            LEFT JOIN $table_class ON $table_student.classid=$table_class.classid
            order by $table_student.id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      //设置学生是否在校还是转校
      if ($r[state]==0) {$r[state]="在校";} else {$r[state]="转学";};
      //是否设置了班级
      if ($r[buildtime]){
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
      } 
      else $classname="<a href=?filename=deal&action=classaddone&classid=$r[classid]>点击设置班级</a>";	  
      $student_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style >$r[id]</td>  
			              <td align=center class=$class_style>$classname</td>
			              <td align=center class=$class_style>$r[name]</td>
			              <td align=center class=$class_style>$r[stnumber]</td>					          
				            <td align=center class=$class_style>$r[sex]</td>
				            <td align=center class=$class_style>".date("Y.m",$r[birthday])."</td>
				            <td align=center class=$class_style>$r[state]</td>
				            <td align=center class=$class_style>  <a href=\"#\" onclick=popUp('studentedit','$i','$r[id]')>修改</a> | <a href=\"#\" onclick=popUp('studentdel','$i','$r[id]')>取消</a></td>				
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
            <TD height=24 align=middle bgcolor="#4466cc" class=tr_head>学生信息管理</TD>
          </TR>
          <TR> 
            <TD class=tablerow><B>管理选项：</B> 
            	<A href="?filename=student&action=list">学生信息列表</A>  |
            	<A href="?filename=student&action=up">学生信息入库</A> 
            </TD>
          </TR>
        </TBODY>
      </TABLE>
    <TABLE width="100%" border=0 align=center cellPadding=0 cellSpacing=0 >
     <tr> 
      <td  height="24"><strong>当前位置：学生信息管理 >> 学生信息上传</strong></td>
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
				    		 	<td  width=30 height=24 class=tr_head>序列</td>
				    		 	<td  class=tr_head>班 级</td>  
				    		 	<td  class=tr_head>名 字</td>
						   	  <td  class=tr_head>学 号</td>
					  		  <td  class=tr_head>性 别</td>
					  		  <td  class=tr_head>出生年月</td>
					  		  <td  class=tr_head>状 态</td>
					  		  <td  class=tr_head>操 作</td>				
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
      开发笔记 技术支持</td>
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