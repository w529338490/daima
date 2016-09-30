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
<?

	if($status=="remove")
	{
		
		$sql="select count(*) as num from ".$TableMenu."  where pid=".$id;
	    $row=$db->getRow($sql);
		$b=false;
		if(!empty($row[num]))
		{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo "<script language='javascript'>alert('请先删除子菜单!');</script>";
			$b=true;
		}
		if(!$b){
			$sql=" select * from ".$TableMenu."  where id=$id;";
			$row=$db->getRow($sql);
			$FileName=$UploadPath."/upload/manager_menu/".$row[id].$row[picture];
			if(file_exists($FileName))
			{     
				 unlink($FileName);
			}
			$sql="delete from ".$TableMenu."  where id=".$id;
			$query=$db->query($sql);
			$sql="delete from ".$TableMenu_role."  where menuid=".$id;
			$query=$db->query($sql);
		}
	}
	
	if($status=="removeSelect")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql=" select * from ".$TableMenu."  where id in (".$filter;
	  $result=$db->getAll($sql);
	  for($i=0;$i<count($result);$i++)
	  {
		  $FileName=$UploadPath."/upload/manager_menu/".$result[$i][id].$result[$i][picture];
		  if(file_exists($FileName))
		  {     
			 unlink($FileName);
		  }
	  }
	  $sql="delete from ".$TableMenu."  where id in (".$filter;
	  $query=$db->query($sql);
	  $sql="delete from ".$TableMenu_role."  where menuid in (".$filter;
	  $query=$db->query($sql);
	}
	

	if($status=="statusSortid")
	{
		$id=$_POST['id'];
		$sql="update ".$TableMenu." set sortid=".$_POST['sortid_'.$id]."  where id=".$id;
	    $db->query($sql);
	}
	
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
</head>
<body>
<form name="form1" method="post" >
  <table border="0" cellpadding="0"  cellspacing="0" class="firsttable">
    <tr>
      <td align="center" valign="top">
	  	<table   class="centertable">
      		<tr> 
           	  <td>&nbsp;</td>
       		</tr>
        	<tr> 
       		  <td align="center" valign="top">
				  <table class="containContentsTable">
              			<tr>
              			  <td colspan="2"><input name="cboAll2" type="checkbox" id="cboAll2" value="checkbox" onClick="checkBoxAll2()">
选择所有
  <input name="button2" type='button' class='button' onClick="javascript:add()" value="添加" >
  <input name="button2" type='button' style="width:80px;" class='button' onClick="javascript:removeSelect()" value="删除" ></td>
       			    </tr>
              			<tr>
               				 <td colspan="2">
								<?
									$sql="select * from ".$TableMenu." where pid=0 and is_user=1 order by sortid" ;
									$query=$db->query($sql);
									$sql1="select * from ".$TableMenu." where pid<>0 and is_user=1  order by pid , sortid" ;
									$result=$db->getAll($sql1);
		        					echo "<table  class='contentsTable' border='0'  cellpadding='0'  cellspacing='1'>";
									echo "<tr class='tr1' align=center ><td width=5% ></td><td  width=15% >菜单名称</td><td >链接地址</td><td width=30%>功能</td><td >排序号</td>";
									
										echo "<td width=10% >&nbsp;</td>";
									
									echo "</tr>";
									while($object=$db->fetch_object($query))
									{
				  						echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
										echo "<td><img src='../image/folderopen.gif' border=0 ></td>";
				  						echo "<td>$object->name</td>";
				  						echo "<td>$object->url</td>";
										echo "<td>$object->func_name</td>";
										echo "<td align='center' ><input  style='width:40px; text-align:center;'  type='text' name='sortid_".$object->id."'  id='sortid_".$object->id."' value='".$object->sortid."'><a href='javascript:editSortid(".$object->id.")'>修改</a></td>";
											echo "<td align=center>";
											
												echo "<a   href='javascript:remove(".$object->id.")'>删除</a>";
											
												echo " <a href='javascript:edit(".$object->id.")'>修改</a>";
											echo "</td>";
									
										echo "</tr>";
										for($i=0;$i<count($result);$i++)
										{
										    if($object->id==$result[$i][pid])
											{
												echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
												echo "<td align='right'><input type='checkbox' name=checkvalue value='".$result[$i][id]."'></td>";
				  								echo "<td>".$result[$i][name]."</td>";
				  								echo "<td>".$result[$i][url]."</td>";
												echo "<td>".$result[$i][func_name]."</td>";
												echo "<td  align='center' ><input style='width:40px;text-align:center;' type='text' name='sortid_".$result[$i][id]."'  id='sortid_".$result[$i][id]."' value='".$result[$i]['sortid']."'><a href='javascript:editSortid(".$result[$i][id].")'>修改</a></td>";
													echo "<td align=center>";
													
														echo "<a   href='javascript:remove(".$result[$i][id].")'>删除</a>";
													
														echo " <a href='javascript:edit(".$result[$i][id].")'>修改</a>";
													echo "</td>";
												
												echo "</tr>";
											}
										}
									}
				 					echo "</table>";
			 					?>                			        </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
						    选择所有<input name="button" type='button' class='button' onClick="javascript:add()" value="添加" >
					      <input name="button" type='button' style="width:80px;" class='button' onClick="javascript:removeSelect()" value="删除" ></td>
       			          <td align="right">&nbsp;						</td>
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
 function checkBoxAll()//选择所有
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
  
   function checkBoxAll2()//选择所有
 {
    	var form = form1;
     for(i=0; i<form.elements.length; i++)
    	{
        	if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
        	{
                	form.elements[i].checked = form.cboAll2.checked;
       	}
    	}
  }

 function edit(id){
     var form=form1;
	location="menuedit.php?id="+id;
  }

  function look(id){
     var form=form1;
	location="menulook.php?id="+id;
  }

  function remove(id){
    if(confirm("真的想要删除吗 ?")==true){
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
  	location="menuadd.php";
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

 

