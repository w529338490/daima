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

	$status=$_POST['status'];
	
	if($status=="edit")
	{
		$indate=date('Y-n-j H:i:s');
		$id=$_POST['id'];//
		$pid=$_POST['pid'];//上级信息栏目
		$indate=date('Y-m-j H:i:s');
		$module_name=$_POST['module_name'];//模块名称
		$module_page=$_POST['module_page'];//模块页面
		$dispach_page=$_POST['dispach_page'];//转发页面
		$access_level=$_POST['access_level'];//转发页面
		$page_level=$_POST['page_level'];
		$description=$_POST['description'];//Description
		
		$sql="select *  from  ".$TableModules." where id=".$pid;
		$rowParent=$db->getRow($sql);
		$nodepath=$rowParent['nodepath'].",".$id;
		if($pid=="0") $nodepath="0,".$id;
		$sql="update  ".$TableModules." set 	pid=".$pid." , nodepath='".$nodepath."' ,module_name='".$module_name."',	module_page='".$module_page."',	dispach_page=".$dispach_page.",	description='".$description."',	access_level=".$access_level.",	page_level=".$page_level."  where id=".$id;
		$query=$db->query($sql);
		
		
		header("location: modules.php");
			return;
	}
	$sql="select * from  ".$TableModules."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>
<script language="javascript">
	function back()
	{
		location="modules.php";
	}

	function Check()
	{
		var form=form1;
	
		if(form.module_name.value=="")
		{
			alert("请输入 模块名称!");
			form.module_name.focus();
			return;
		}
		
		
		 form.status.value="edit";
		 form.submit();
  	}
	
</script>
<body>
<form action=""  method="post"  name="form1"  enctype="multipart/form-data">
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
								<tr  class='tr2'  >
                          <td >上级模块 :</td>
                          <td width="632" >
                            <select name="pid" id="pid">
							<option value="0"></option>
                              <? 
	                         			$sql3="select * from ".$TableModules." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableModules." where pid<>0" ;
							            $result=$db->getAll($sql4);
										while($object3=$db->fetch_object($query3))
							 	  		{
										    $levelStr="";
										    $level_num=1;
											if($object3->id==$row[pid])
                          						echo "<option value='$object3->id' selected>".$object3->module_name."</option>";
                  							else
                          						echo "<option value='$object3->id' >".$object3->module_name."</option>";
											    for($i=0;$i<count($result);$i++)
												{
													for($j=0;$j<$level_num;$j++)
														$levelStr.="----";
													if($object3->id==$result[$i][pid])
													{
														if($result[$i][id]==$row[pid])
														{
															echo "<option value='".$result[$i][id]."' selected>";
															echo $levelStr.$result[$i][module_name];
															echo "</option>";
														}
														else
														{
															echo "<option value='".$result[$i][id]."'>";
															echo $levelStr.$result[$i][module_name];
															echo "</option>";
														}
														subCategory($result,$result[$i][id],$row[pid]);
													}
													$levelStr="";
												}
                         			 	}
										
										function subCategory($result,$id,$pid)
										{
											global $level_num;
											$level_num++;
											
											for($i=0;$i<count($result);$i++)
											{
												$levelStr="";
												for($j=0;$j<$level_num;$j++)
													$levelStr.="----";
												if($id==$result[$i][pid])
												{
													if($result[$i][id]==$pid)
													{
														echo "<option value='".$result[$i][id]."' selected>";
														echo $levelStr.$result[$i][module_name];
														echo "</option>";
													}
													else
													{
														echo "<option value='".$result[$i][id]."'>";
														echo $levelStr.$result[$i][module_name];
														echo "</option>";
													}
													subCategory($result,$result[$i][id],$pid);
													$levelStr="";
												}
											}
											$level_num--;
										}
									?>
                            </select>                          </td>
                        </tr>
								<tr  class='tr2' >
									<td >模块名称:</td>
									<td ><input name="module_name" type="text" id="module_name"  value="<?=$row['module_name']?>" ></td>
								</tr>
								<tr  class='tr2'  style="display:none;" >
									<td >模块页面:</td>
									<td ><input name="module_page" type="text" id="module_page"  value="<?=$row['module_page']?>" ></td>
								</tr>
                                <tr  class='tr2'   >
									<td >访问权限:</td>
									<td >									<?
										for($i=1;$i<=count($T_Access_Level);$i++)
										{
											if((int)$row['access_level']==$i)
												echo "<input name='access_level' type='radio' checked  value='".$i."'>".$T_Access_Level[$i];
											else
												echo "<input name='access_level' type='radio'   value='".$i."'>".$T_Access_Level[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2'   >
									<td >转发页面:</td>
									<td >									<?
										for($i=1;$i<=count($T_Dispach);$i++)
										{
											if((int)$row['dispach_page']==$i)
												echo "<input name='dispach_page' type='radio' checked  value='".$i."'>".$T_Dispach[$i];
											else
												echo "<input name='dispach_page' type='radio'   value='".$i."'>".$T_Dispach[$i];
										}
									?>									</td>
								</tr>
                                 <tr  class='tr2' >
									<td >页面级别:</td>
									<td >									<?
										for($i=1;$i<=count($T_Page_Level);$i++)
										{
											if((int)$row['page_level']==$i)
												echo "<input name='page_level' type='radio' checked  value='".$i."'>".$T_Page_Level[$i];
											else
												echo "<input name='page_level' type='radio'   value='".$i."'>".$T_Page_Level[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2' >
									<td  width=156>描述</td>
									<td ><textarea name="description" cols="70" rows="10" id="description"><?=$row['description']?></textarea></td>
								</tr>
              				<tr  class='tr2'>
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="提交" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">						        </td>
              				</tr>
           			  </table>
			  </td>
          		</tr>
          		<tr class='tr2'>
            		  <td></td>
          		</tr>
          </table>
   	    </td>
     </tr>
</table>
<input type="hidden" name="status" value="">
<input type="hidden" name="id" value=<?=$id?>>
<input type="hidden" name="menu_ids" value="">
</form>
</body>
</html>
<? $db->close_db();?>
 

