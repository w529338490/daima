<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<?
	
	$status=$_POST['status'];
	if($status=="remove")
	{
	    
		$sql="select count(*) as num from ".$TableEb_product_category."  where pid=".$id;
	    $row=$db->getRow($sql);
		$b=false;
		if(!empty($row[num]))
		{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo "<script language='javascript'>alert('this category has subcategory,please remove subcategory first!');</script>";
			$b=true;
		}
	
		$sql="select count(*) as num from ".$TableEb_product."  where eb_product_category_id=".$id;
	    $row=$db->getRow($sql);
		if(!empty($row[num]))
		{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo "<script language='javascript'>alert('this category has product,please remove product first');</script>";
			$b=true;
		}
		$sql="select * from ".$TableEb_product_category."  where id=".$id;
	    $row=$db->getRow($sql);
		$old_pid=$row['pid'];
		if($b==false)
		{
			$FileName=$UploadPath."upload/eb_product_category/".$row['picture'];
			$FileName_thumbnail=$UploadPath."upload/eb_product_category/thumbnail_".$row['picture'];
			if(file_exists($FileName)&&!empty($row['picture']))
			{
				 unlink($FileName);
				 unlink($FileName_thumbnail);
			}
			$sql="delete from ".$TableEb_product_category." where id=".$id;
			$query=$db->query($sql);
			//check old category is_leaf
			$sql="select count(1) as num  from  ".$TableEb_product_category." where  pid=".$old_pid." and id<>".$id;
			$row=$db->getRow($sql);
			if(empty($row['num'])||$row['num']<=0)
			{
				$sql="update ".$TableEb_product_category." set is_leaf=1 where id=".$old_pid;
				$db->query($sql);
			}
		}
	}
	

	if($status=="show")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product_category." set is_show=1  where id in (".$filter;
	  $query=$db->query($sql);
	}

	if($status=="unshow")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product_category." set is_show=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	

	if($status=="statusSortid")
	{
		$id=$_POST['id'];
		$sql="update ".$TableEb_product_category." set sortid=".$_POST['sortid_'.$id]."  where id=".$id;
	    $db->query($sql);
	}
	
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
              			<tr >
           				  <td colspan="2" > </td>
       				    </tr>
              			<tr>
              			  <td colspan="2"><input name="button" type='button' class='button' onClick="javascript:add()" value='添加'>
              			    <input name="button2" type='button'  class='button' onClick="javascript:show()" value='发布'>
                            <input name="button2" type='button'  class='button' style='width:80px' onClick="javascript:unshow()" value='不发布' ></td>
              			</tr>
              			<tr>
               				 <td colspan="2">
								 <?
									$sql="select * from ".$TableEb_product_category."  where pid=0 order by sortid " ;
									$query=$db->query($sql);
									$sql1="select  * from  ".$TableEb_product_category." where pid<>0  order by sortid " ;
									$result=$db->getAll($sql1);
									
									echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
									echo "<tr class='tr1' align=center ><td >ID</td><td >分类名称</td><td width=10%>链接类型</td><td width=15%>排序号</td><td width=10%>发布</td><td width=10%>&nbsp;</td></tr>";
									while($object=$db->fetch_object($query))
									{
										$levelStr="";
										$level_num=1;
										echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."'  align=center>";
										echo "<td >".$object->id."</td>";
										echo "<td align='left'><input  type='checkbox' name=checkvalue value='$object->id'>$object->name</td>";
										//echo "<td >".$object->url."</td>";
										echo "<td >".$T_Link_method[$object->link_method]."</td>";
										echo "<td ><input  style='width:40px; text-align:center;'  type='text' name='sortid_".$object->id."'  id='sortid_".$object->id."' value='".$object->sortid."'><a href='javascript:editSortid(".$object->id.")'>修改</a></td>";
										//echo "<td >".$T_Is_YesNO[$object->is_default]."</td>";
										echo "<td >".$T_Is_YesNO[$object->is_show]."</td>";
										echo "<td align=center><a   href='javascript:remove($object->id)'>删除</a> <a href='javascript:edit($object->id)'>修改</a></td></tr>";
										for($i=0;$i<count($result);$i++)
										{
											for($j=0;$j<$level_num;$j++)
												$levelStr.="----";
											if($object->id==$result[$i][pid])
											{
												echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."'  align=center>";
												echo "<td >".$result[$i][id]."</td>";
												echo "<td  align='left'>".$levelStr."<input   type='checkbox' name=checkvalue value='".$result[$i][id]."'>".$result[$i][name]."</td>";
												//echo "<td >".$result[$i][url]."</td>";
												echo "<td >".$T_Link_method[$result[$i]['link_method']]."</td>";
												echo "<td ><input style='width:40px;text-align:center;' type='text' name='sortid_".$result[$i][id]."'  id='sortid_".$result[$i][id]."' value='".$result[$i]['sortid']."'><a href='javascript:editSortid(".$result[$i][id].")'>修改</a></td>";
												//echo "<td >".$T_Is_YesNO[$result[$i]['is_default']]."</td>";
												echo "<td >".$T_Is_YesNO[$result[$i]['is_show']]."</td>";
												echo "<td align=center><a   href='javascript:remove(".$result[$i][id].")'>删除</a> <a href='javascript:edit(".$result[$i][id].")'>修改</a></td></tr>";
												subCategory($result,$result[$i][id]);
											}
											$levelStr="";
										}
									}
									echo "</table>";
									function subCategory($result,$id)
									{
										global $level_num,$T_Link_method,$T_Is_YesNO,$T_Access_Level;
										$level_num++;
										
										for($i=0;$i<count($result);$i++)
										{
											$levelStr="";
											for($j=0;$j<$level_num;$j++)
												$levelStr.="----";
											if($id==$result[$i][pid])
											{
												echo "<tr class='tr2' align=center>";
												echo "<td >".$result[$i][id]."</td>";
												echo "<td  align='left'>".$levelStr."<input   type='checkbox' name=checkvalue value='".$result[$i][id]."'>".$result[$i][name]."</td>";
												//echo "<td >".$result[$i][url]."</td>";
												echo "<td >".$T_Link_method[$result[$i]['link_method']]."</td>";
												echo "<td ><input style='width:40px;text-align:center;' type='text' name='sortid_".$result[$i][id]."'  id='sortid_".$result[$i][id]."' value='".$result[$i]['sortid']."'><a href='javascript:editSortid(".$result[$i][id].")'>修改</a></td>";
												//echo "<td >".$T_Is_YesNO[$result[$i]['is_default']]."</td>";
												echo "<td >".$T_Is_YesNO[$result[$i]['is_show']]."</td>";
												echo "<td align=center><a   href='javascript:remove(".$result[$i][id].")'>删除</a> <a href='javascript:edit(".$result[$i][id].")'>修改</a></td></tr>";
												subCategory($result,$result[$i][id]);
												$levelStr="";
											}
										}
										$level_num--;
									}
									
								?>                			        </td>
              			</tr>
              			<tr>
						<td><input type='button' class='button' onClick="javascript:add()" value='添加'>
						  <input name="button22" type='button'  class='button' onClick="javascript:show()" value='发布'>
                          <input name="button23" type='button'  class='button' style='width:80px' onClick="javascript:unshow()" value='不发布' ></td>
						<td align="right">&nbsp;</td>
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
	function checkBoxAll()//全选
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
		location="eb_product_categoryedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="eb_product_categorylook.php?id="+id;
	}
	
	function remove(id){
		if(confirm("真的想要删除吗?")==true){
			var form=form1;
			form.id.value=id;
			form.status.value="remove";
			form.submit();
		}
	}
	
	 function editSortid(id){
  		var form=form1;
  		form.id.value=id;
		obj_sortid=document.getElementById("sortid_"+id);
		if(!isIntegerPlus(obj_sortid.value))
		{
			alert("排序号必须为整数!");
			obj_sortid.focus();
			return;
		}
		form.status.value="statusSortid";
		form.submit();
  }
  
  function show(){
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
	form.status.value="show";
	form.submit();
  }
  
   function unshow(){
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
		alert("请选择记录");
		return;
	}
	form.status.value="unshow";
	form.submit();
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
			alert("请选择记录");
			return;
		}
		if(confirm("真的想要删除吗?")==false)
			return;
		form.status.value="removeSelect";
		form.submit();
	}

	function add(){
		location="eb_product_categoryadd.php";
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
 

