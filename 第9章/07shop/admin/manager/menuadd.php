<? require "../../db/Connect.php"?>
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

    //Add
	if($status=="add")
	{
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
	   	if(!empty($file_name))
	    {
			$sql="insert into ".$TableMenu."(name,pid,url,picture,sortid,is_user)values('$name',0,'$url','$picture',".$sortid.",1)";
		    $query=$db->query($sql);
			if($query)
			{
				$sql="select max(id) as id from ".$TableMenu;
				$row=$db->getRow($sql);
				$FileName=$UploadPath."upload/manager_menu/".$row[id].$picture;
				$file = $_FILES['file']['tmp_name'];
			   if(copy($file,$FileName))
			   {
				  unlink($file);
			   }
			}
		}
		else
		{
			$sql="insert into ".$TableMenu."(name,pid,url,sortid,is_user)values('$name',0,'$url',".$sortid.",1)";
		    $query=$db->query($sql);
		}
	}
	if($status=="addSub")
	{
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
	   	if(!empty($file_name))
	    {
			$sql="insert into ".$TableMenu."(name,pid,url,picture,func_id,func_name,sortid,is_user)values('$name',$pid,'$url','$picture','$func_id','$func_name',".$sortid.",1)";
			$query=$db->query($sql);
			if($query)
			{
				$sql="select max(id) as id from ".$TableMenu;
				$row=$db->getRow($sql);
				$FileName=$UploadPath."upload/manager_menu/".$row[id].$picture;
				$file = $_FILES['file']['tmp_name'];
			   if(copy($file,$FileName))
			   {
				  unlink($file);
			   }
			}
		}
		else
		{
			$sql="insert into ".$TableMenu."(name,pid,url,func_id,func_name,sortid,is_user)values('$name',$pid,'$url','$func_id','$func_name',".$sortid.",1)";
			$query=$db->query($sql);
		}
	}
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
</head>
<script language="javascript">

	function back()
	{
		location="menu.php";
	}
	function Check()
    {
		var form=form1;
		if(form.name.value=="")
		{
			alert("请输入菜单名称!");
			form.name.focus();
			return;
		}
		if(form.url.value=="")
		{
			alert("请输入链接地址!");
			form.url.focus();
			return;
		}
		if(!isIntegerPlus(form.sortid.value))
		{
			alert("排序号必须为整数!");
			form.sortid.focus();
			return;
		}
		 form.status.value="add";
		 form.message.value=1;
		 form.submit();    
  	}
	
	function addSub()
    {
		var form=form1;
		if(form.pid.value=="")
		{
			alert("请选择上级菜单!");
			form.pid.focus();
			return;
		}
		if(form.name.value=="")
		{
			alert("请输入菜单名称!");
			form.name.focus();
			return;
		}
		if(form.url.value=="")
		{
			alert("请输入链接地址!");
			form.url.focus();
			return;
		}
		if(!isIntegerPlus(form.sortid.value))
		{
			alert("排序号必须为整数!");
			form.sortid.focus();
			return;
		}
		 form.status.value="addSub";
		 form.message.value=1;
		 form.submit();    
  	}
	
	function change(obj)
	{
		if(obj.value=="")
		{
			document.all("id1").style.display="none";
			document.all("id2").style.display="none";
		}
		else
		{
			document.all("id1").style.display="";
			document.all("id2").style.display="";
		}
	}
</script>
<body>
<form action=""  method="post"  name="form1" enctype="multipart/form-data">
  <table class="firsttable">
      <tr>
    	<td align="center" valign="top">
        	    <table class="centertable">
          	<tr>
            		<td></td>
          	</tr>
          	<tr>
            		<td align="center" class="addborder">
					  <table  class="addTable" border='0'  cellpadding='0'  cellspacing='1'>
                        <tr align="center"  class='tr2'>
                          <td colspan="2"> <font  class="message">
                            <? if($message==1){echo "添加成功";}?>
                          </font> </td>
                        </tr>
                        <tr  class='tr2'>
                          <td >上级菜单</td>
                          <td >
                            <select name="pid" id="pid"  onChange="change(this)">
							<option value=""></option>
                              <? 
	                         			$sql3="select * from ".$TableMenu." where pid=0 and is_user=1";
										$query3=$db->query($sql3);
							 			while($object3=$db->fetch_object($query3))
							 	  		{
										  if($pid==$object3->id)
										  {
                          					echo "<option value='$object3->id' selected>";
                          					echo $object3->name;
                         				    echo "</option>";
										  }
										  else
										  {
										  	echo "<option value='$object3->id' >";
                          					echo $object3->name;
                         				    echo "</option>";
										  }
                         			 	}
									?>
                            </select>
                          </td>
                        </tr>
                        <tr class='tr2' >
                          <td >菜单名称:</td>
                          <td ><input name="name" type="text" id="name" ></td>
                        </tr>
                        <tr  class='tr2'>
                          <td >链接地址:</td>
                          <td ><input name="url" type="text" id="url" size="50" ></td>
                        </tr>
						<tr  class='tr2'>
									<td width="156" > 排序号:</td>
								    <td width="632" ><input name="sortid" type="text" id="sortid" value="1" ></td>
								</tr>
						<tr  class='tr2'>
                				<td >图片</td>
                				<td ><input name="file" type="file" size="50"></td>
              			</tr>
						<tr class='tr2' id='id1' <? if($pid=="") echo "style='display:none;' ";?>>
                          <td >功能编号:</td>
                          <td ><input name="func_id" type="text" id="func_id" size="70" >
                          例如:100,101,102</td>
                        </tr>
						<tr class='tr2'  id='id2'  <? if($pid=="") echo "style='display:none;' ";?>>
                          <td >功能名称:</td>
                          <td ><input name="func_name" type="text" id="func_name" size="70" >
                          例如:添加,删除,修改</td>
                        </tr>
                        <tr class='tr2' >
                          <td colspan="2" align="center">
                            <input name="Button" type="button" class="button" style="width:80px;" onClick="Check()" value="添加一级">
&nbsp;
      <input name="Button" type="button" class="button" onClick="addSub()" style="width:80px;" value="添加子级">
&nbsp;
      <input name="Submit2" type="button" class="button" onClick="back()" value="返回">
                          </td>
                        </tr>
                      </table></td>
          		</tr>
          		<tr>
            		  <td></td>
          		</tr>
       	           </table>
    	   </td>
     </tr>
</table>
<input type="hidden" name="status" value=0>
<input type="hidden" name="message" value=0>
</form>
</body>
</html>
<? $db->close_db();?>

 

