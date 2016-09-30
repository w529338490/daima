<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCMS
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<? include "../../include/FileDir.php"?>
<?

	// iterator template dir,  add template to database;
	$sql="select  ".$TableTemplates.".template_name  from    ".$TableTemplates."  ";
	$result=$db->getAll($sql);
	$Template_array=array();
	for($i=0;$i<count($result);$i++)
	{
		$Template_array[$i]=$result[$i]['template_name'];
	}
	$dir_array=searchDir("../../Templates");
	for($i=0;$i<count($dir_array);$i++)
	{
		if(!in_array($dir_array[$i],$Template_array))
		{
			 $sql="insert into  ".$TableTemplates."(template_name,is_default)values('".$dir_array[$i]."',2)";
			$query=$db->query($sql);
		}
	}
	//
	//delete
	$status=$_POST['status'];
	if($status=="remove")
	{
		$sql="select template_name from ".$TableTemplates."   where id=".$id;
	    $row=$db->getRow($sql);
		$template_name_save=$row['template_name'];
	    $sql="delete from ".$TableTemplates."   where is_default<>1 and id=".$id;
	    $query=$db->query($sql);
		//delete template dir
		$template_name_dir=$UploadPath."Templates/".$template_name_save;
		  if($query&&file_exists($template_name_dir)&&!empty($template_name_save))
		  {
			$d=new FileDir();
			$d->deleteAllDir($template_name_dir);
		  }
	}
	//delete seleted
	if($status=="removeSelect")
	{
	  $checkednums=array();
	  $ids=$_POST['ids'];
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="delete from  ".$TableTemplates."  where id in (".$filter;
	  $query=$db->query($sql);
	  
	}
	//verify
	if($status=="f_is_default")
	{
	  $checkednums=array();
	  $ids=$_POST['ids'];
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	   $sql="update  ".$TableTemplates." set is_default=2 ";
	   $query=$db->query($sql);
	  $sql="update  ".$TableTemplates." set is_default=1   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	//unverify
	if($status=="unverify")
	{
	  $checkednums=array();
	  $ids=$_POST['ids'];
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableTemplates." set is_verify=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	$page=$_POST['page'];
	if(empty($page))
    	{$page=1;}
    else
    {
		 if($page<1){ $page=1;}
	}
             $b=false;
             $filter="";
             $template_name=$_POST['template_name'];
             $fvalue=$template_name;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableTemplates.".template_name like '%".$fvalue."%' ";
                 $b=true;
             }
             $is_default=$_POST['is_default'];
             $fvalue=$is_default;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableTemplates.".is_default = ".$fvalue." ";
                 $b=true;
             }
	$sql="select  ".$TableTemplates.".*  from    ".$TableTemplates."  ";
	$sql1="select count(*) as num from    ".$TableTemplates."  ";
	if($b)
	{
		$sql.=" where ".$filter."  order by ".$TableTemplates.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by ".$TableTemplates.".id desc  ";
	}
	else
	{
		$sql.="  order by ".$TableTemplates.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by ".$TableTemplates.".id desc  ";
	}
	$result=$db->getAll($sql);
	$row=$db->getRow($sql1);
	$totalnum=$row['num'];
	$page_num=ceil($totalnum/$pagenum);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script>
</head>
<body>
<form name="form1" method="post" >
  <table border="0" cellpadding="0"  cellspacing="0" class="firsttable">
    <tr>
      <td align="center" valign="top">
	  	<table   class="centertable">
      		<tr>
            	<td>&nbsp;
            	</td>
       		</tr>
        	<tr>
       		  <td align="center" valign="top">
				  <table class="containContentsTable">
              			<tr align="right">
           				  <td colspan="2" >
模板名称:<input type="text" size=10 name="template_name" value="<?=$template_name?>">
默认:<select name="is_default" id="is_default">
	<option value=""></option>
	<?
		for($i=1;$i<=count($T_Is_YesNO);$i++)
		{
			 if((int)$is_default==$i)
			 	echo "<option value='".$i."' selected>".$T_Is_YesNO[$i]."</option>";
			else
				echo "<option value='".$i."'>".$T_Is_YesNO[$i]."</option>";
		}
	?>
</select>
<input type='button'  class='button' onClick="javascript:query()" value='查询' >
           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td>模板名称</td><td>默认</td><td width='15%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
									$default_check="";
									if($result[$i]['is_default']==1) $default_check="checked";
				  					echo "<tr  onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='radio' ".$default_check." name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td>".$result[$i]['template_name']."</td>";//模板名称
				  					echo "<td  align='center'>";
				  							echo $T_Is_YesNO[$result[$i]['is_default']];
				  					echo "</td>";
				  					echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].",".$result[$i]['is_default'].")'>删除</a></td></tr>";
								}
				 				echo "</table>";
								?>
                			        </td>
              			</tr>
              			<tr>
						<td><input name="button22" type='button'  class='button' onClick="javascript:f_is_default()" value='默认'></td>
			  <td align="right"> 共 <?=$totalnum?> 条, 共 <?=$page_num?> 页, 第 <?=$page?> 页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
					     			<select name="position" id="position"  onChange="goposition()">
                      				<option value=""></option>
                     				 <?
					     			for($i=1;$i<=$page_num;$i++)
					     			{
						   			echo "<option ";
						   				if(page==$i){echo "selected";}
						   					echo " value=$i>";
						   					echo $i;
						   					echo "</option>" ;
					     			}
					     	?>
					     			</select>
						</td>
              			</tr>
                      </table>
					</td>
                  </tr>
				<tr>
                    <td></td>
				</tr>
              </table>
	      </td>
      </tr>
</table>
  <input type="hidden" name="status" value="">
  <input type="hidden" name="page" value=<?=$page?>>
  <input type="hidden" name="totalpage" value=<?=$page_num?>>
   <input type="hidden" name="id" value="">
   <input type="hidden" name="ids" value="">
</form>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
	function checkBoxAll()//
	{
		var form = form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
			{
				form.elements[i].checked = form.cboAll.checked;
			}
		}
	}

	function edit(id){
		var form=form1;
		location="templatesedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="templateslook.php?id="+id;
	}

	function remove(id,is_default){
		var form=form1;
		if(is_default==1)
		{
			alert("不能删除默认的模板!");
			return;
		}
		
		if(confirm("真的想要删除吗?")==true){
			
			form.id.value=id;
			form.status.value="remove";
			form.submit();
		}
	}

	function removeSelect(){
		var form=form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
			{
				if(form.elements[i].checked==true)
				{
					form.ids.value+=form.elements[i].value+".";
				}
			}
		}
		if(form.ids.value=="")
		{
			alert("请选择记录!");
			return;
		}
		if(confirm("真的想要删除吗?")==false)
			return;
		form.status.value="removeSelect";
		form.submit();
	}

	function f_is_default(){
		var form=form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="radio" &&  form.elements[i].name=="checkvalue")
			{
				if(form.elements[i].checked==true)
				{
					form.ids.value+=form.elements[i].value+".";
				}
			}
		}
		if(form.ids.value=="")
		{
			alert("请选择记录! ");
			return;
		}
		form.status.value="f_is_default";
		form.submit();
	}

	function unverify(){
		var form=form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
			{
				if(form.elements[i].checked==true)
				{
					form.ids.value+=form.elements[i].value+".";
				}
			}
		}
		if(form.ids.value=="")
		{
			alert("请选择记录 ! ");
			return;
		}
		form.status.value="unverify";
		form.submit();
	}

	function add(){
		location="templatesadd.php";
	}

	function query()
	{
		var form=form1;
		form.submit();
	}

	function first()
	{
		var form=form1;
		if(eval(form.page.value)==1)
			return;
		form.page.value=1;
		form.submit();
	}

	function next()
	{
		var form=form1;
		if(eval(form.page.value)>=eval(form.totalpage.value))
			return;
		form.page.value=eval(form.page.value)+1;
		form.submit();
	}

	function last()
	{
		var form=form1;
		if(eval(form.page.value)==eval(form.totalpage.value))
			return;
		form.page.value=eval(form.totalpage.value);
		form.submit();
	}

	function pre()
	{
		var form=form1;
		if(form.page.value<=1)
			return;
		form.page.value=eval(form.page.value)-1;
		form.submit();
	}

	function  goposition()
	{
		var form=form1;
		form.page.value=form.position.value;
		form.submit();
	}
</script>
<? $db->close_db();?>
