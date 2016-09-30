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
		$name=$_POST['name'];//信息栏目名
		
		$sql="select *  from  ".$TableRole." where id=".$pid;
		$rowParent=$db->getRow($sql);
		$nodepath=$rowParent['nodepath'].",".$id_no;
		if($pid=="0") $nodepath="0,".$id_no;
		$sql="update  ".$TableRole." set 	id=".$id_no.",pid=".$pid.",name='".$name."' , nodepath='".$nodepath."' , description='".$description."'  where id=".$id;
		$query=$db->query($sql);
		
		
		header("location: role.php");
			return;
	}
	$sql="select * from  ".$TableRole."  where id=".$id;
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
		location="role.php";
	}

	function Check()
	{
		var form=form1;
	
		if(!isIntegerPlus(form.id_no.value))
		{
			alert("请输入编号!");
			form.id_no.focus();
			return;
		}
		
		if(form.name.value=="")
		{
			alert("请输入 角色名称!");
			form.name.focus();
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
                          <td >上级角色 :</td>
                          <td >
                            <select name="pid" id="pid">
							<option value="0"></option>
                              <? 
	                         			$sql3="select * from ".$TableRole." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableRole." where pid<>0" ;
							            $result=$db->getAll($sql4);
										while($object3=$db->fetch_object($query3))
							 	  		{
										    $levelStr="";
										    $level_num=1;
											if($object3->id==$row[pid])
                          						echo "<option value='$object3->id' selected>".$object3->name."</option>";
                  							else
                          						echo "<option value='$object3->id' >".$object3->name."</option>";
											    for($i=0;$i<count($result);$i++)
												{
													for($j=0;$j<$level_num;$j++)
														$levelStr.="----";
													if($object3->id==$result[$i][pid])
													{
														if($result[$i][id]==$row[pid])
														{
															echo "<option value='".$result[$i][id]."' selected>";
															echo $levelStr.$result[$i][name];
															echo "</option>";
														}
														else
														{
															echo "<option value='".$result[$i][id]."'>";
															echo $levelStr.$result[$i][name];
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
														echo $levelStr.$result[$i][name];
														echo "</option>";
													}
													else
													{
														echo "<option value='".$result[$i][id]."'>";
														echo $levelStr.$result[$i][name];
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
									<td width="156" > 编号</td>
						  <td width="632" ><input name="id_no" type="text" id="id_no" value="<?=$row['id']?>" >
							      <span class="star">*编号必须为整数</span></td>
					  </tr>
								<tr  class='tr2'>
									<td width="156" >角色名称:</td>
								  <td width="632" ><input name="name" type="text" id="name" value="<?=$row[name]?>">
							      <span class="star">*</span></td>
								</tr>
								<tr  class='tr2'>
									<td width="156" > 描述</td>
							      <td width="632" ><textarea name="description" cols="70" rows="5" id="description"><?=$row[description]?>
							      </textarea></td>
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
 

