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

	//修改
	if($status=="edit")
	{
	  if(empty($pid))
	  {
		$file_name = $_FILES["file"]['name'];
	  	$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($file_name))
	    {
			$sql="update ".$TableMenu." set name='$name',url='$url',picture='$picture', sortid=".$sortid." where id=$id";
	   		$query=$db->query($sql);
			if($query)
			{
				$FileName=$UploadPath."upload/manager_menu/".$id.$picture;
				$file = $_FILES['file']['tmp_name'];
			   	if(copy($file,$FileName))
			  	 {
				  	unlink($file);
			   	}
			}
		}
		else
		{
			$sql="update ".$TableMenu." set name='$name',url='$url', sortid=".$sortid." where id=$id";
	   		$query=$db->query($sql);
		}
		header("location: menu.php");
		return;
	  }
	  else
	  {
		$file_name = $_FILES["file"]['name'];
	  	$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($file_name))
	    {
			$sql="update ".$TableMenu." set name='$name',url='$url',pid=$pid,picture='$picture',func_id='$func_id',func_name='$func_name', sortid=".$sortid." where id=$id";
	   		$query=$db->query($sql);
			if($query)
			{
				$FileName=$UploadPath."upload/manager_menu/".$id.$picture;
				$file = $_FILES['file']['tmp_name'];
			   	if(copy($file,$FileName))
			  	 {
				  	unlink($file);
			   	}
			}
		}
		else
		{
			$sql="update ".$TableMenu." set name='$name',url='$url',pid=$pid,func_id='$func_id',func_name='$func_name', sortid=".$sortid." where id=$id";
	   		$query=$db->query($sql);
		}
		header("location: menu.php");
		return;
	  }
	}
	$sql="select * from ".$TableMenu." where id=$id";
	$query=$db->query($sql);
	$row=$db->fetch_row($query);
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
			alert("Please enter name!");
			form.name.focus();
			return;
		}
		if(form.url.value=="")
		{
			alert("Please enter url!");
			form.url.focus();
			return;
		}
		if(!isIntegerPlus(form.sortid.value))
		{
			alert("排序号 must be integer!");
			form.sortid.focus();
			return;
		}
		 form.status.value="edit";
		 form.submit();    
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
					  <table  class="addTable"  border='0'  cellpadding='0'  cellspacing='1'>
					  <?
						  if($row[pid]!="0"){
				      ?>
                        <tr  class='tr2'>
                          <td >上级菜单</td>
                          <td >
						  
                            <select name="pid" id="pid">
                              <? 
	                         			$sql3="select * from ".$TableMenu." where pid=0  and is_user=1";
										$query3=$db->query($sql3);
							 			while($object3=$db->fetch_object($query3))
							 	  		{
										  if($row[pid]==$object3->id)
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
						<?
						}
						?>
                        <tr  class='tr2'>
                          <td >菜单名称:</td>
                          <td ><input name="name" type="text" id="name"  value="<?=$row[name]?>"></td>
                        </tr>
                        <tr  class='tr2'>
                          <td >链接地址:</td>
                          <td ><input name="url" type="text" id="url"  value="<?=$row[url]?>" size="50"></td>
                        </tr>
						<tr  class='tr2'>
									<td width="156" > 排序号:</td>
								    <td width="632" ><input name="sortid" type="text" id="sortid"  value="<?=$row[sortid]?>" ></td>
								</tr>
						<tr  class='tr2'>
                				<td >图片</td>
                				<td ><img width="80" height="50"  src="../../upload/manager_menu/<? $pic="default.jpg";
												if(!empty($row[picture]))
													$pic=$row[id].$row[picture]; echo $pic;?>" border="0" ><br><input name="file" type="file" size="50"></td>
              			</tr>
						<?
						  if($row[pid]!="0"){
				        ?>
						<tr   class='tr2'>
                          <td >功能编号:</td>
                          <td ><input name="func_id" type="text" id="func_id" size="70" value="<?=$row[func_id]?>" >
例如:100,101,102</td>
                        </tr>
						<tr  class='tr2'>
                          <td >功能名称:</td>
                          <td ><input name="func_name" type="text" id="func_name" size="70"  value="<?=$row[func_name]?>">
例如:Add,删除,修改</td>
                        </tr>
						<?
						}
						?>
                        <tr  class='tr2'>
                          <td colspan="2" align="center">
                            <input name="Button" type="button" class="button" onClick="Check()" value="提交">
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
<input type="hidden" name="id" value=<?=$id?>>
</form>
</body>
</html>
<? $db->close_db();?>

 

