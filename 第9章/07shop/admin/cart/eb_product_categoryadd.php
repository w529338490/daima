<? require "../../db/Connect.php"?>
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
    //Add
	$status=$_POST['status'];
	if($status=="add")
	{
		$indate=date('Y-n-j H:i:s');
		$name=$_POST['name'];//栏目名
		
		//sortid
		$sql="select max(sortid) as sortid from  ".$TableEb_product_category." where pid=0";
		$rowsortid=$db->getRow($sql);
		$sortid=(int)$rowsortid['sortid']+1;
		//
		$is_leaf = "1";
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
			
		 $sql="insert into  ".$TableEb_product_category."(link_method,is_leaf,id,name,pid,url,picture,sortid,is_show)values(".$link_method.",".$is_leaf.",".$id.",'".$name."',0,'".$url."','".$picture."',".$sortid.",".$is_show.")";
		$query=$db->query($sql);
		
						
		$sql="select max(id) as id from  ".$TableEb_product_category;
		$rowMax=$db->getRow($sql);
		$nodepath="0,".$id;
		
		$sql="update ".$TableEb_product_category." set nodepath='".$nodepath."' where id=".$id;
		$query=$db->query($sql);
	}
	
	if($status=="addSub")
	{
			
			//sortid
			$sql="select max(sortid) as sortid from  ".$TableEb_product_category." where pid=".$pid;
			$rowsortid=$db->getRow($sql);
			$sortid=(int)$rowsortid['sortid']+1;
			//
			$is_leaf = "1";
			$file_name = $_FILES["file"]['name'];
			$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
			if(!empty($picture))
				$picture=getRandomNum().$picture;
			
		   $sql="insert into  ".$TableEb_product_category."(link_method,is_leaf,id,name,pid,url,picture,sortid,is_show)values(".$link_method.",".$is_leaf.",".$id.",'".$name."',".$pid.",'".$url."','".$picture."',".$sortid.",".$is_show.")";
			$query=$db->query($sql);
			
			//update parent category is_leaf=2
			$sql="update ".$TableEb_product_category." set is_leaf=2 where id=".$pid;
			$db->query($sql);
			//
			$sql="select max(id) as id from  ".$TableEb_product_category;
			$rowMax=$db->getRow($sql);
			$sql="select *  from  ".$TableEb_product_category." where id=".$pid;
			$rowParent=$db->getRow($sql);
			$nodepath=$rowParent['nodepath'].",".$id;
			
			$sql="update ".$TableEb_product_category." set nodepath='".$nodepath."' where id=".$id;
			$query=$db->query($sql);
	}
	if(!empty($file_name))
	{
			$FileName=$UploadPath."upload/eb_product_category/".$picture;
			$file = $_FILES['file']['tmp_name'];
		   if(copy($file,$FileName))
		   {
			  unlink($file);
		   }
	}
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>

<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>
<script language="javascript">
	function back()
	{
		location="eb_product_category.php";
	}

	function Check()
	{
		var form=form1;
		if(!isIntegerPlus(form.id.value))
		{
			alert("请输入 ID!");
			form.id.focus();
			return;
		}
		if(form.name.value=="")
		{
			alert("请输入分类名称!");
			form.name.focus();
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
			alert("请选择上级分类!");
			form.pid.focus();
			return;
		}
		if(!isIntegerPlus(form.id.value))
		{
			alert("请输入 ID!");
			form.id.focus();
			return;
		}
		if(form.name.value=="")
		{
			alert("请输入 分类名称!");
			form.name.focus();
			return;
		}
		
		 form.status.value="addSub";
		 form.message.value=1;
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
					<table  class="addTable"   border='0'  cellpadding='0'  cellspacing='1'>
              				<tr align="center"  class='tr2'>
               					 <td colspan="2">
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "添加成功";
                                                                    }
                                                               ?>
                                   </font>       				          </td>
              				</tr>
								<tr  class='tr2'  >
                          <td >上级分类 :</td>
                          <td >
                            <select name="pid" id="pid">
							<option value=""></option>
                              <? 
	                         			$sql3="select * from ".$TableEb_product_category." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableEb_product_category." where pid<>0" ;
							            $result=$db->getAll($sql4);
										while($object3=$db->fetch_object($query3))
							 	  		{
										    $levelStr="";
										    $level_num=1;
											if($object3->id==$pid)
                          						echo "<option value='$object3->id' selected>".$object3->name."</option>";
                  							else
                          						echo "<option value='$object3->id' >".$object3->name."</option>";
											    for($i=0;$i<count($result);$i++)
												{
													for($j=0;$j<$level_num;$j++)
														$levelStr.="----";
													if($object3->id==$result[$i][pid])
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
						<tr  class='tr2'>
									<td width="156" > 编号</td>
						  <td width="632" ><input name="id" type="text" id="id" value="<?=$id?>" >
						    <span class="star">*ID 必须为整数</span></td>
					  </tr>
								<tr  class='tr2'>
									<td width="156" > 分类名称:</td>
								  <td width="632" ><input name="name" type="text" id="name" ></td>
								</tr>
                     <tr  class='tr2'   >
									<td >链接类型:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Link_method);$i++)
										{
											if((int)$link_method==$i||(empty($link_method)&&$i==1))
												echo "<input name='link_method' type='radio' checked  value=".$i.">".$T_Link_method[$i];
											else
												echo "<input name='link_method' type='radio'   value=".$i.">".$T_Link_method[$i];
										}
									?>									<span class="star">*</span></td>
					  </tr>
								<tr  class='tr2'  >
									<td >发布</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$is_show==$i||(empty($is_show)&&$i==1))
												echo "<input name='is_show' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_show' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?>									<span class="star">*</span></td>
					  </tr>
                     
								
								<tr  class='tr2' >
									<td >图片:</td>
									<td ><input type="file" name="file"></td>
								</tr>
              				<tr  class='tr2'>
       				          <td colspan="2" align="center"><input type="button" style="width:80px;"  class="button" value="添加一级" onClick="Check()">
       				            &nbsp;&nbsp;
                                <input type="button"  class="button"  style="width:80px;" value="添加子级" onClick="addSub()">
                                &nbsp;&nbsp;      &nbsp;&nbsp;
      						    <input type="button"  class="button"  value="返回" onClick="back()">
   						      <label></label>						        </td>
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
<input type="hidden" name="message" value="">
<input type="hidden" name="menu_ids" value="">
<input type="hidden" name="module_poss" value="">
</form>
</body>
</html>
<? $db->close_db();?>
 

