<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
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
switch($action){
	case 'up'://成绩发布第一步上传成绩文件
?>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
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
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><strong>当前位置：学生成绩管理 >> 学生成绩发布(第一步:上传文件)</strong></td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder_2 width="100%"  >
        <!--DWLayoutTable-->  
        <TBODY>
        <form method="post" action="?filename=deal&action=upresult" name="form1" enctype="multipart/form-data" >
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
            <tr>
        <td colspan="2" align="center"><font color=red><b>上传说明：上传文件只能为excel中的csv格式的文件，下载：<a href=exsample.csv target="_blank">csv格式文件</a></td>
    </tr>
     </table>
    </td> 
    </tr>   
</table>
</body>
</html>
<?
break;
	case 'insert':
		//读取文件信息并显示出来
		require("./include/file_class.php");
		$filepath="$uptemp$fileid";
		// set fl
		$fl = new File_class;
		$fl->file=$filepath;
		$h=$fl->getlines();
		$line=$fl->read_file();
		for ($i=0;$i<$h;$i++){
			$out=explode(",", $line[$i]);
			//$student_data=$i;//数据传递方法一
			//数据传递方法二
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
		//学号编码共8位毕业年数（2）学校编号（2）班级编号（2）学生编号（2）
		//年级班级设置
		foreach($gradearr AS $key=>$value)  $grade_show.="<option value=$key>$value</option>";
		foreach($gradecarr AS $key=>$value)  $grade_c_show.="<option value=$key>$value</option>";
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
	document.form1.result_data.value=strchoice;

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
function check(theform)
{
	if (theform.result_data.value == "" )
	{
		alert("请选择数据!");
		theform.submit.focus();
		return false ;
	}

	if(theform.gradeid.value == 0)
	{
		alert("请选择年级!");
		theform.gradeid.focus();
		return false ;
	}
	if(theform.result_title.value == "" )
	{
		alert("请输入考试名称!");
		theform.result_title.focus();
		return false ;
	}

	return true ;
}
</SCRIPT>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
      	   <TABLE width="100%" border=0 align=center cellPadding=1 cellSpacing=1 class=tableborder_2>
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
      <td  height="24"><strong>当前位置：学生成绩管理 >> 学生成绩发布(第二步:成绩入表)</strong></td>
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
				    		  <form action="?filename=deal&action=resultadd"  method="post" name="form1" OnSubmit="return check(this)">
	 <tr  align=center>
				    		 	<td  width=15% height=24 class=tr_head>
				    		 		<input type="button" name="allbox" value="选中" onClick="CheckAll();">
                    <input type="button" name="nonebox" value="取消" onClick="CheckNone();"></td>
						   	  <td  class=tr_head>序列</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[0]>
					  		  	<option value=stnumber selected>学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
					  		  </td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[1]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name selected>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[2]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw selected>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[3]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx selected>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						  	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=list_type[4]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy selected>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[5]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx selected>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=list_type[6]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz selected>思 政</option>
					  		  	<option value=ls>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						  	  	</td>
						   	  <td  class=tr_head>
						   	  	<select name=list_type[7]>
					  		  	<option value=stnumber >学 号</option>
					  		  	<option value=name>姓 名</option>
					  		  	<option value=yw>语 文</option>
					  		  	<option value=sx>数 学</option>
					  		  	<option value=wy>英 语</option>
					  		  	<option value=kx>科 学</option>
					  		  	<option value=sz>思 政</option>
					  		  	<option value=ls selected>历 社</option>
					  		  	<option value=0>不选择</option>
					  		    </select>
						   	  	</td>
					       </tr>
				    		  <tr  align=center>
				    		 	<td  width=15% height=24 class=tr_head>
				    		 		</td>
						   	  <td  class=tr_head></td>
					  		  <td  class=tr_head>
					  		  	
					  		  </td>
						  	  <td  class=tr_head>
						  	  	</td>
						  	  <td  class=tr_head>
					  		  	<select name=total_type[0]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=total_type[1]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
						  	  	</td>
					  		  <td  class=tr_head>
					  		  	<select name=total_type[2]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
					  		  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=total_type[3]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
						  	  	</td>
						  	  <td  class=tr_head>
						  	  	<select name=total_type[4]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
						  	  	</td>
						   	  <td  class=tr_head>
						   	   <select name=total_type[5]>					  		  	
					  		  	<option value=80>80分</option>
					  		  	<option value=100 selected>100分</option>
					  		  	<option value=110>110分</option>
					  		  	<option value=120>120分</option>
					  		  	<option value=150>150分</option>
					  		    </select>
						   	  	</td>
					       </tr>
				    		 <?=$result_list;?>	    	
					       <tr  align=center>
					       	<td   class=td1>
					       	<input type="button" name="allbox" value="选中" onClick="CheckAll();">
                  <input type="button" name="nonebox" value="取消" onClick="CheckNone();"></td>
						   	  <td   class=td1 colspan=9>
						   	  	<select name=gradeid>
						   	  	  <option value=0>请选择年级</option>
						   	  	  <?=$grade_show;?>
						   	  	</select>						   	  	
						   	  	<select name=gradecid>
						   	  	  <option value=0>请选择班级</option>
						   	  	 <?=$grade_c_show;?>
						   	  	</select>
						   	    考试名称:
						  	  	<input type=text name=result_title size=20>
						  	  	<input type=hidden name=result_data>
						  	  	<input type=submit name=submit value=成绩发布 onClick="checklistid();">
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
      	Powered By <b>slcms 成绩管理系统 Version 1.0.1 （2007）</b> 程序设计：【凡·工作室】</td>
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
/*
case 'in':
//读取目录里面上传的文件
$updir="./data/";
$handle=opendir($updir);
$i=1;
while (false !== ($file = readdir($handle))) {
$i++;
if (($file==".") or ($file=="..") or ($file=="index.htm")) continue;
$filename=explode(".",$file);
$filename=$filename[0];
$list_file.="<tr bgColor=\"#f1f3f5\" onmouseout=\"this.style.backgroundColor='#F1F3F5'\" onmouseover=\"this.style.backgroundColor='#BFDFFF'\">
<td align=center height=24 width=80>
<input type=button name=aa value=删除 onclick=delfile('./data/$file')>
</td>
<td align=left>
<a href=?filename=result&action=insert&fileid=$file>$file</a>
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
Powered By <b>slcms 考试成绩统计系统 Version 1.0.1 （2006）</b> 程序设计：【凡·工作室】</td>
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
*/
//本班学生成绩列表
	case 'list':
		$where="where userid=$user_id";
		//页码设置开始
		$sql = "SELECT count(*) FROM $table_resultset $where";
		$result = $db->query_first($sql);
		$totalnum=$result[0];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,"?filename=result&action=list");
		//页码设置结束
		//记录数据的读取
		$i=1;
		$class_style="td1";
		$query="select * from $table_resultset
                 $where
                 order by id DESC limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			//设置添加时间
			$intime=date("Y/m/d",$r[intime]);
			//设置班级或年级
			$gradeid_arr=explode(":",$r[gradeid]);
			$result_list.="
			             <tr id=list$r[id] valign=middle>
			              <td align=center height=24 class=$class_style>".$gradearr[$gradeid_arr[0]].$gradecarr[$gradeid_arr[1]]."</td>
			              <td align=center class=$class_style><a href=\"?filename=tongji&action=listone&id=$r[id]\">$r[title]</a></td>
			              <td align=center class=$class_style>$intime</td>
				            <td align=center class=$class_style>   
				              <a href=\"?filename=tongji&action=cout&id=$r[id]\" > 班级排名</a> |
				              <a href=\"?filename=tongji&action=csout&id=$r[id]\" > 学科统计</a> |
				              <a href=\"?filename=tongji&action=out20&id=$r[id]\" > 20%分段统计</a> | 
				              <a href=\"?filename=result&action=delone&id=$r[id]\">删除</a> |	
				              <a href=\"?filename=tongji&action=cout&do=word&id=$r[id]\" > 班级word</a> |
				              <a href=\"?filename=tongji&action=csout&do=word&id=$r[id]\" > 学科word</a> |
				              <a href=\"?filename=tongji&action=out20&do=word&id=$r[id]\" > 20%word</a> | 
				              </td>						
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
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
      	   <TABLE width="100%" border=0 align=center cellPadding=1 cellSpacing=1 class=tableborder_2>
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
      <td  height="24"><strong>当前位置：学生成绩管理 >> 学生成绩列表</strong></td>
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
				    		  <form action="?filename=deal&action=studentadd"  method="post" name="form1" >
				    		 <tr  align=center>
				    		 	<td  width=15% height=24 class=tr_head>年级</td>
				    		 	<td  class=tr_head>考试名称</td>
						   	  <td  class=tr_head>成绩上传时间</td>
					  		  <td  class=tr_head>操 作</td>				
					       </tr>
				    		 <?=$result_list;?>
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
<?
break;
//修改学生记录成绩
	case 'editst':
		$query="select * from $table_result
            where id='$id' 
            order by id  limit 1";            
		$r=$db->query_first($query);
?>
<body topmargin="0" leftmargin="0" rightMargin="0">
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=22>
      	<?=$classname."『".$r[stname];?>』的成绩修改
      </td>
     </tr>        
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center class=tableborder>
  	<form name="form1" method="post" action="?filename=deal&action=resultedit&id=<?=$id;?>">
	   <TR vAlign=middle align=middle class=tr_head>
      <TD align=middle height=8 colspan=4></td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=right height=20 width=40 class=td2>语文:</td>
      <TD align=left height=20 class=td1><input type="text" name=yw size=8 value="<?=$r[yw];?>"></td>
     <TD align=right height=20 class=td2>数学:</td>
      <TD align=left height=20 class=td1 ><input type="text" name=sx size=8 value="<?=$r[sx];?>"></td>
      </tr>
     	   <TR vAlign=middle align=middle>
      <TD align=right height=20 class=td2>外语:</td>
      <TD align=left height=20 class=td1><input type="text" name=wy size=8 value="<?=$r[wy];?>"></td>


      <TD align=right height=20 class=td2>科学:</td>
      <TD align=left height=20 class=td1><input type="text" name=kx size=8 value="<?=$r[kx];?>"></td>
     </tr>
     	   <TR vAlign=middle align=middle>
      <TD align=right height=20 class=td2>思政:</td>
      <TD align=left height=20 class=td1><input type="text" name=sz size=8 value="<?=$r[sz];?>"></td>
      <TD align=right height=20 class=td2>历社:</td>
      <TD align=left height=20 class=td1><input type="text" name=ls size=8 value="<?=$r[ls];?>"></td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=center height=50 colspan=4 class=td2><input type="submit" name=s value=" 开 始 修 改 " ></td>
     </tr>  
     	   <TR vAlign=middle align=middle class=tr_head>
      <TD align=middle height=12 colspan=4></td>
     </tr>     
    </form>    
  </table>
<?
break;
}

?>