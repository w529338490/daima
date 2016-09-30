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

	$status=$_POST['status'];
	if($status=="removePic")
    {
		$sql=" select * from ".$TableEb_product_category."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/eb_product_category/".$row['picture'];
		if(file_exists($FileName)&&!empty($row['picture']))
		{
			 unlink($FileName);
			 unlink($FileName_thumbnail);
		}
		$sql="update  ".$TableEb_product_category." set 	picture='' where id=".$id;
		$query=$db->query($sql);
	}
	if($status=="edit")
	{
		$indate=date('Y-n-j H:i:s');
		$id=$_POST['id'];//
		
		$pid=$_POST['pid'];//上级信息栏目
		$name=$_POST['name'];//信息栏目名
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
			
		//check old category is_leaf ,update new parent category is_leaf=2
		//check old category is_leaf
		$sql="select pid   from  ".$TableEb_product_category." where  id=".$id;
		$rowOld=$db->getRow($sql);
		$old_pid=$rowOld['pid'];
		$sql="select count(1) as num  from  ".$TableEb_product_category." where  pid=".$old_pid." and id<>".$id;
		$row=$db->getRow($sql);
		if(empty($row['num'])||$row['num']<=0)
		{
			$sql="update ".$TableEb_product_category." set link_method=".$link_method.", is_leaf=1 where id=".$old_pid;
			$db->query($sql);
		}
		//update new parent category is_leaf=2
		if(!empty($pid)||$pid!=0)
		{
			$sql="update ".$TableEb_product_category." set is_leaf=2 where id=".$pid;
			$db->query($sql);
		}
		//
		$sql="select *  from  ".$TableEb_product_category." where id=".$pid;
		$rowParent=$db->getRow($sql);
		$nodepath=$rowParent['nodepath'].",".$id_no;
		if($pid=="0") $nodepath="0,".$id_no;
		
		if(!empty($file_name))
	    {
			//delete old
		   $sql="select * from  ".$TableEb_product_category."  where id=".$id;
		   $row=$db->getRow($sql);
		   $PicName=$UploadPath."upload/eb_product_category/".$row['picture'];
			 if(file_exists($PicName)&&!empty($row['picture']))
			{
			   unlink($PicName);
			   unlink($PicName_thumbnail);
			}
				
			$sql="update  ".$TableEb_product_category." set link_method=".$link_method.", id=".$id_no.",pid=".$pid.",name='".$name."' , nodepath='".$nodepath."' , url='".$url."', picture='".$picture."',  is_show=".$is_show."    where id=".$id;
			$query=$db->query($sql);
			$FileName=$UploadPath."upload/eb_product_category/".$picture;
			$file = $_FILES['file']['tmp_name'];
			if(copy($file,$FileName))
			{
				unlink($file);
			}
		}
		else
		{
			$sql="update  ".$TableEb_product_category." set id=".$id_no.",pid=".$pid.",name='".$name."' , nodepath='".$nodepath."' , url='".$url."',  is_show=".$is_show."    where id=".$id;
			$query=$db->query($sql);
		}
		
		$message=1;
	}
	$sql="select * from  ".$TableEb_product_category."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<script language="javascript" src="../../js/ajax.js"></script>
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
		location="eb_product_category.php";
	}

	function Check()
	{
		var form=form1;
	
		if(!isIntegerPlus(form.id_no.value))
		{
			alert("请输入 ID!");
			form.id_no.focus();
			return;
		}
		
		if(form.name.value=="")
		{
			alert("请输入 分类名称!");
			form.name.focus();
			return;
		}
		
		 form.status.value="edit";
		 form.submit();
  	}
	
	function removePic()
	{
		var form=form1;
		if(confirm("真的想要删除吗?")==false)
			return;
		form.status.value="removePic";
		form.submit();
	}
	
	function select_page_template(obj)
	{
		var form=form1;
		form.url.value=obj.value;
	}
</script>
<script language="javascript">
                function send_request_post(url,querystring,func) {
                    create_request();
                    if(func=='getModuleCom') http_request.onreadystatechange = processGetModuleCom;
                    
                    http_request.open("POST", url, true);
                    http_request.setRequestHeader("Content-Type"," application/x-www-form-urlencoded"); 
                    http_request.send(querystring);
                }
                
            	 
            	function removeOptionSelected()
				{
				  var elSel = document.getElementById('module_com');
				  var i;
				  for (i = elSel.length - 1; i>=0; i--) {
					if (elSel.options[i].selected) {
					  elSel.remove(i);
					}
				  }
				}

                function processGetModuleCom() {
                        var form=form1;
                        if (http_request.readyState == 4) { 
                            if (http_request.status == 200) {
								if(http_request.responseText=="") return; 
                        		module_name_array=http_request.responseText.split(',');
								removeOptionSelected();
								//add option to select
								for(var i=0;i<module_name_array.length;i++)
								{
									var elOptNew = document.createElement('option');
									module_name=module_name_array[i].replace(/\s/ig,'');
									  elOptNew.text =module_name;
									  elOptNew.value =module_name;
									  row_module_com="<?=$row['module_com']?>";
									  row_module_com=row_module_com.replace(/\s/ig,'');
									  if(row_module_com==module_name)
									  { 
									  		elOptNew.selected=true;
									  }
									  var elSel = document.getElementById('module_com');
									
									  try {
										elSel.add(elOptNew, null); // standards compliant; doesn't work in IE
									  }
									  catch(ex) {
										elSel.add(elOptNew); // IE only
									  }
							    }

                            } else { //页面不正常
                                alert("error");
                            }
                        }
                    }
                
                function changeModuleCom(obj) {
                    var form=form1;
					
					module_name=obj.options[obj.selectedIndex].text;
					module_name=module_name.replace(/-/g,'');
                   if(module_name=="")
                    {
                        alert("Please select your module!");
                        return;
                    }
                    
                    querystring="module_name="+module_name;
                     send_request_post('../../ajax/module_com.php',querystring,"getModuleCom");
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
                    <tr align="center"  class='tr2' >
									<td colspan="2">
										<font  class="message">
										<?
											if($message=="1")
											{
												echo "修改成功";
											}
										?>
										</font>									</td>
								</tr>
								<tr  class='tr2'  >
                          <td >上级分类 :</td>
                          <td >
                            <select name="pid" id="pid">
							<option value="0"></option>
                              <? 
	                         			$sql3="select * from ".$TableEb_product_category." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableEb_product_category." where pid<>0" ;
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
						<tr  class='tr2' style="display:none;" >
									<td width="156" > 编号</td>
						  <td width="632" ><input name="id_no" type="text" id="id_no" value="<?=$row['id']?>" >
							      <span class="star">*ID 必须为整数</span></td>
					  </tr>
								<tr  class='tr2'>
									<td width="156" >分类名称:</td>
								  <td width="632" ><input name="name" type="text" id="name" value="<?=$row[name]?>">
							      <span class="star">*</span>							     </td>
								</tr>
                       	<tr  class='tr2'  >
									<td >链接类型:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Link_method);$i++)
										{
											if((int)$row['link_method']==$i)
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
											if((int)$row['is_show']==$i)
												echo "<input name='is_show' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_show' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?>									<span class="star">*</span></td>
					  </tr>
								<tr  class='tr2' >
									<td >图片:</td>
								  <td >
								  <?
								  if(!empty($row['picture']))
								  {
								  ?>
								  <a target="_blank" href="../../upload/eb_product_category/<?=$row['picture']?>"><img width="<?=$config_row['category_thumbnail_width']?>" height="<?=$config_row['category_thumbnail_height']?>"  src="../../upload/eb_product_category/thumbnail_<?=$row['picture']?>" border="0" ></a>
								    <input type="button" class="button" onClick="removePic()" value="Delete">
							     <?
								 }
								 ?>
								  <br><input type="file" name="file"></td>
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
<input type="hidden" name="module_poss" value="">
</form>
</body>
</html>
<? $db->close_db();?>
 

