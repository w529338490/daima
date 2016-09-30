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
	if($status=="removePic")
    {
		$sql=" select * from ".$TableInfo_category."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/info_category/".$row['picture'];
		$FileName_thumbnail=$UploadPath."upload/info_category/thumbnail_".$row['picture'];
		if(file_exists($FileName)&&!empty($row['picture']))
		{
			 unlink($FileName);
			 unlink($FileName_thumbnail);
		}
		$sql="update  ".$TableInfo_category." set 	picture='' where id=".$id;
		$query=$db->query($sql);
	}
	if($status=="edit")
	{
		$indate=date('Y-n-j H:i:s');
		$id=$_POST['id'];//
		$menu_ids=$_POST['menu_ids'];
		$url_type=$_POST['url_type'];
		$module_com=$_POST['module_com'];
		$module_poss=$_POST['module_poss'];
		$pid=$_POST['pid'];//上级信息栏目
		$access_level=$_POST['access_level'];//Dispach Page
		$name=$_POST['name'];//信息栏目名
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
			
		//check old category is_leaf ,update new parent category is_leaf=2
		//check old category is_leaf
		$sql="select pid   from  ".$TableInfo_category." where  id=".$id;
		$rowOld=$db->getRow($sql);
		$old_pid=$rowOld['pid'];
		$sql="select count(1) as num  from  ".$TableInfo_category." where  pid=".$old_pid." and id<>".$id;
		$row=$db->getRow($sql);
		if(empty($row['num'])||$row['num']<=0)
		{
			$sql="update ".$TableInfo_category." set is_leaf=1 where id=".$old_pid;
			$db->query($sql);
		}
		//update new parent category is_leaf=2
		if(!empty($pid)||$pid!=0)
		{
			$sql="update ".$TableInfo_category." set is_leaf=2 where id=".$pid;
			$db->query($sql);
		}
		//
		$sql="select *  from  ".$TableInfo_category." where id=".$pid;
		$rowParent=$db->getRow($sql);
		$nodepath=$rowParent['nodepath'].",".$id_no;
		if($pid=="0") $nodepath="0,".$id_no;
		
		if(!empty($file_name))
	    {
			//delete old
		   $sql="select * from  ".$TableInfo_category."  where id=".$id;
		   $row=$db->getRow($sql);
		   $PicName=$UploadPath."upload/info_category/".$row['picture'];
		   $PicName_thumbnail=$UploadPath."upload/info_category/thumbnail_".$row['picture'];
			 if(file_exists($PicName)&&!empty($row['picture']))
			{
			   unlink($PicName);
			   unlink($PicName_thumbnail);
			}
				
			$sql="update  ".$TableInfo_category." set alias_name='".$alias_name."',url_type=".$url_type.",	module_com='".$module_com."',module_pos='".$module_poss."',access_level=".$access_level.",menu_ids='".$menu_ids."',module_id=".$module_id.",id=".$id_no.",pid=".$pid.",name='".$name."' , nodepath='".$nodepath."' , url='".$url."', link_method=".$link_method." ,	picture='".$picture."',  is_default=".$is_default.", is_show=".$is_show.", is_au=".$is_au."    where id=".$id;
			$query=$db->query($sql);
			$FileName=$UploadPath."upload/info_category/".$picture;
			$FileName_thumbnail=$UploadPath."upload/info_category/thumbnail_".$picture;
			$file = $_FILES['file']['tmp_name'];
			if(copy($file,$FileName))
			{
				unlink($file);
			}
			ImageResize($FileName,$config_row['menuitem_thumbnail_width'],$config_row['menuitem_thumbnail_height'],$FileName_thumbnail);
		}
		else
		{
			$sql="update  ".$TableInfo_category." set  alias_name='".$alias_name."', url_type=".$url_type.",	module_com='".$module_com."',module_pos='".$module_poss."',	access_level=".$access_level.", 	menu_ids='".$menu_ids."',	module_id=".$module_id.",	id=".$id_no.",pid=".$pid.",name='".$name."' , nodepath='".$nodepath."' , url='".$url."', link_method=".$link_method.",  is_default=".$is_default." , is_show=".$is_show.", is_au=".$is_au."     where id=".$id;
			$query=$db->query($sql);
		}
		
		$message=1;
	}
	$sql="select * from  ".$TableInfo_category."  where id=".$id;
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
		location="info_category.php";
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
			alert("请输入 菜单名称!");
			form.name.focus();
			return;
		}
		
		/*if(!isIntegerPlus(form.sortid.value))
		{
			alert("排序号 必须为整数r!");
			form.sortid.focus();
			return;
		}*/
		for(var i=0;i<form.menu_id.length;i++)
		{
			if(form.menu_id[i].selected)
				form.menu_ids.value+=form.menu_id[i].value+",";
		}
		if(form.menu_ids.value=="")
		{
			alert("请选择菜单位置!");
			form.sortid.focus();
			return;
		}
		/*if(form.url.value=="")
		{
			alert("Please select a Module!");
			form.url.focus();
			return;
		}*/
		for(var i=0;i<form.module_pos.length;i++)
		{
			if(form.module_pos[i].selected)
				form.module_poss.value+=form.module_pos[i].value+",";
		}
		form.menu_ids.value=form.menu_ids.value.substring(0,form.menu_ids.value.length-1);
		form.module_poss.value=form.module_poss.value.substring(0,form.module_poss.value.length-1);
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
					  elSel.remove(i);
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
												echo "修改成功!";
											}
										?>
										</font>									</td>
								</tr>
								<tr  class='tr2'  >
                          <td >上级菜单 :</td>
                          <td >
                            <select name="pid" id="pid">
							<option value="0"></option>
                              <? 
	                         			$sql3="select * from ".$TableInfo_category." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableInfo_category." where pid<>0" ;
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
							      <span class="star">*编号必须为整数</span></td>
					  </tr>
								<tr  class='tr2'>
									<td width="156" >菜单名称:</td>
								  <td width="632" ><input name="name" type="text" id="name" value="<?=$row[name]?>">
							      <span class="star">* </span>别名:
							      <input name="alias_name" type="text" id="alias_name" value="<?=$row[alias_name]?>" >
							     </td>
								</tr>
                                <tr  class='tr2'   >
									<td >菜单位置:</td>
									<td >
								   <select name="menu_id" id="menu_id" multiple size="5"  >
                                        <?
										$menu_ids_array=explode(',',$row['menu_ids']);
										$sql3="select id,menu_name from ".$TableMain_menu." order by id asc" ;
										$query3=$db->query($sql3);
										while($object3=$db->fetch_object($query3))
										{
											if(in_array($object3->id,$menu_ids_array))
												echo "<option value='".$object3->id."' selected>".$object3->menu_name."</option>";
											else
												echo "<option value='".$object3->id."' >".$object3->menu_name."</option>";
										}
									?>
                                      </select>                                    </td>
					  </tr>
                       <script language="javascript">
									function MenuUrlType_change(flag)
									{
										if(flag==1)
										{
											document.getElementById('tr_url').style.display="none";
											document.getElementById('tr_module').style.display="";
											document.getElementById('tr_component').style.display="";
											document.getElementById('tr_component_position').style.display="";
										}
										if(flag==2)
										{
											document.getElementById('tr_url').style.display="";
											document.getElementById('tr_module').style.display="none";
											document.getElementById('tr_component').style.display="none";
											document.getElementById('tr_component_position').style.display="none";
										}
									}
								</script>
                      <tr  class='tr2' >
									<td >菜单链接类型:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Url_type);$i++)
										{
											if((int)$row['url_type']==$i)
												echo "<input name='url_type' onclick='MenuUrlType_change(".$i.")' type='radio' checked  value=".$i.">".$T_Url_type[$i];
											else
												echo "<input name='url_type' onclick='MenuUrlType_change(".$i.")'  type='radio'   value=".$i.">".$T_Url_type[$i];
										}
									?><span class="star">*</span>
                                    </td>
					  </tr>
                      <tr  class='tr2' id="tr_url" <? if($row['url_type']==1) echo "style='display:none;'"; ?> >
									<td width="156" > 菜单链接地址:</td>
						  <td width="632" ><input name="url" type="text" id="url" value="<?=$row['url']?>" ></td>
					  </tr>
          <tr  class='tr2'  id="tr_module"   <? if($row['url_type']==2) echo "style='display:none;'"; ?>  >
									<td >选择模块:</td>
									<td ><select name="module_id" id="module_id"  onChange="changeModuleCom(this)">
                                     
                                      <?
											$pid=$row['module_id'];
											$sql3="select module_name,id,pid from ".$TableModules." where pid=0 order by id ";
												$query3=$db->query($sql3);
												$sql4="select module_name,id,pid from ".$TableModules." where pid<>0  " ;
												$resultCategroy=$db->getAll($sql4);
												while($object3=$db->fetch_object($query3))
												{
													$levelStr="";
													$level_num=1;
													if($object3->id==$pid)
														echo "<option value='".$object3->id."' selected>".$object3->module_name."</option>";
													else
														echo "<option value='".$object3->id."' >".$object3->module_name."</option>";
														for($i=0;$i<count($resultCategroy);$i++)
														{
															for($j=0;$j<$level_num;$j++)
																$levelStr.="----";
															if($object3->id==$resultCategroy[$i][pid])
															{
																if($resultCategroy[$i][id]==$pid)
																{
																	echo "<option value='".$resultCategroy[$i][id]."' selected>";
																		echo $levelStr.$resultCategroy[$i][module_name];
																	echo "</option>";
																}
																else
																{
																	echo "<option value='".$resultCategroy[$i][id]."' >";
																		echo $levelStr.$resultCategroy[$i][module_name];
																	echo "</option>";
																}
																subModuleCategory($resultCategroy,$resultCategroy[$i][id],$pid);
															}
															$levelStr="";
														}
												}
										
												function subModuleCategory($resultCategroy,$id,$pid)
												{
													global $level_num;
													$level_num++;
													for($i=0;$i<count($resultCategroy);$i++)
													{
														$levelStr="";
														for($j=0;$j<$level_num;$j++)
															$levelStr.="----";
														if($id==$resultCategroy[$i][pid])
														{
																if($resultCategroy[$i][id]==$pid)
																{
																	echo "<option value='".$resultCategroy[$i][id]."' selected>";
																		echo $levelStr.$resultCategroy[$i][module_name];
																	echo "</option>";
																}
																else
																{
																	echo "<option value='".$resultCategroy[$i][id]."' >";
																		echo $levelStr.$resultCategroy[$i][module_name];
																	echo "</option>";
																}
																subModuleCategory($resultCategroy,$resultCategroy[$i][id],$pid);
														}
														$levelStr="";
													}
													$level_num--;
												}
										?>
                                    </select></td>
					  </tr>
                        <tr  class='tr2'  id="tr_component"  <? if($row['url_type']==2) echo "style='display:none;'"; ?>   >
									<td >选择组件</td>
                         <td >
                         <select name="module_com" id="module_com">
                   		</select>
                         <script language="javascript">
						 	changeModuleCom(document.getElementById('module_id'));
						 </script>
                         </td>
                        </tr>
                      <tr  class='tr2'   id="tr_component_position"  <? if($row['url_type']==2) echo "style='display:none;'"; ?>  >
									<td >组件位置:</td>
									<td >
								   <select name="module_pos" id="module_pos" multiple size="5"  >
                                        <?
										$module_poss_array=explode(',',$row['module_pos']);
										for($i=1;$i<=count($T_Module_Position);$i++)
										{
											if(in_array($i,$module_poss_array))
												echo "<option value='".$i."' selected>".$T_Module_Position[$i]."</option>";
											else
												echo "<option value='".$i."' >".$T_Module_Position[$i]."</option>";
										}
									?>
                                      </select>                                    </td>
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
								<tr  class='tr2'  style="display:none;"  >
									<td >默认:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$row['is_default']==$i)
												echo "<input name='is_default' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_default' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
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
                      <tr  class='tr2'  >
									<td >属于内容:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$row['is_au']==$i)
												echo "<input name='is_au' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_au' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?>									<span class="star">*</span></td>
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
								<tr  class='tr2' >
									<td >图片</td>
								  <td >
								  <?
								  if(!empty($row['picture']))
								  {
								  ?>
								  <a target="_blank" href="../../upload/info_category/<?=$row['picture']?>"><img width="<?=$config_row['menuitem_thumbnail_width']?>" height="<?=$config_row['menuitem_thumbnail_height']?>"  src="../../upload/info_category/thumbnail_<?=$row['picture']?>" border="0" ></a>
								    <input type="button" class="button" onClick="removePic()" value="删除">
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
 

