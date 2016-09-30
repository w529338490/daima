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
	$status=$_POST['status'];
	if($status=="add")
	{
		$indate=date('Y-n-j H:i:s');
		$name=$_POST['name'];//栏目名
		$menu_ids=$_POST['menu_ids'];
		$module_com=$_POST['module_com'];
		$module_poss=$_POST['module_poss'];
		$access_level=$_POST['access_level'];//Dispach Page
		$menu_ids=$_POST['menu_ids'];
		$url_type=$_POST['url_type'];
		//sortid
		$sql="select max(sortid) as sortid from  ".$TableInfo_category." where pid=0";
		$rowsortid=$db->getRow($sql);
		$sortid=(int)$rowsortid['sortid']+1;
		//
		$is_leaf = "1";
		$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
			
		 $sql="insert into  ".$TableInfo_category."(module_com,module_pos,is_leaf,access_level,menu_ids,module_id,id,name,pid,url,link_method,picture,sortid,is_default,is_show,is_au,url_type,alias_name)values('".$module_com."','".$module_poss."',".$is_leaf.",".$access_level.",'".$menu_ids."',".$module_id.",".$id.",'".$name."',0,'".$url."',".$link_method.",'".$picture."',".$sortid.",".$is_default.",".$is_show.",".$is_au.",".$url_type.",'".$alias_name."')";
		$query=$db->query($sql);
		
						
		$sql="select max(id) as id from  ".$TableInfo_category;
		$rowMax=$db->getRow($sql);
		$nodepath="0,".$id;
		
		$sql="update ".$TableInfo_category." set nodepath='".$nodepath."' where id=".$id;
		$query=$db->query($sql);
	}
	
	if($status=="addSub")
	{
			$menu_ids=$_POST['menu_ids'];
			$module_poss=$_POST['module_poss'];
			$url_type=$_POST['url_type'];
			$module_com=$_POST['module_com'];
			$access_level=$_POST['access_level'];//Dispach Page
			//sortid
			$sql="select max(sortid) as sortid from  ".$TableInfo_category." where pid=".$pid;
			$rowsortid=$db->getRow($sql);
			$sortid=(int)$rowsortid['sortid']+1;
			//
			$is_leaf = "1";
			$file_name = $_FILES["file"]['name'];
			$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
			if(!empty($picture))
				$picture=getRandomNum().$picture;
			
			$sql="insert into ".$TableInfo_category."(module_com,module_pos,is_leaf,access_level,menu_ids,module_id,id,name,pid,url,link_method,picture,sortid,is_default,is_show,is_au,url_type,alias_name)values('".$module_com."','".$module_poss."',".$is_leaf.",".$access_level.",'".$menu_ids."',".$module_id.",".$id.",'".$name."',$pid,'".$url."',".$link_method.",'".$picture."',".$sortid.",".$is_default.",".$is_show.",".$is_au.",".$url_type.",'".$alias_name."')";
			$query=$db->query($sql);
			
			//update parent category is_leaf=2
			$sql="update ".$TableInfo_category." set is_leaf=2 where id=".$pid;
			$db->query($sql);
			//
			$sql="select max(id) as id from  ".$TableInfo_category;
			$rowMax=$db->getRow($sql);
			$sql="select *  from  ".$TableInfo_category." where id=".$pid;
			$rowParent=$db->getRow($sql);
			$nodepath=$rowParent['nodepath'].",".$id;
			
			$sql="update ".$TableInfo_category." set nodepath='".$nodepath."' where id=".$id;
			$query=$db->query($sql);
	}
	if(!empty($file_name))
	{
			$FileName=$UploadPath."upload/info_category/".$picture;
			$FileName_thumbnail=$UploadPath."upload/info_category/thumbnail_".$picture;
			$file = $_FILES['file']['tmp_name'];
		   if(copy($file,$FileName))
		   {
			  unlink($file);
		   }
		   ImageResize($FileName,$config_row['menuitem_thumbnail_width'],$config_row['menuitem_thumbnail_height'],$FileName_thumbnail);
	}
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
		if(!isIntegerPlus(form.id.value))
		{
			alert("请输入编号!");
			form.id.focus();
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
			alert("请输入 Module!");
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
		if(!isIntegerPlus(form.id.value))
		{
			alert("请输入编号!");
			form.id.focus();
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
			alert("please select a Module!");
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
		 form.status.value="addSub";
		 form.message.value=1;
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
									  elOptNew.text =module_name_array[i].replace(/\s/ig,'');
									  elOptNew.value =module_name_array[i].replace(/\s/ig,'');
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
					<table  class="addTable"   border='0'  cellpadding='0'  cellspacing='1'>
              				<tr align="center"  class='tr2'>
               					 <td colspan="2">
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "Add Successfull";
                                                                    }
                                                               ?>
                                   </font>       				          </td>
              				</tr>
								<tr  class='tr2'  >
                          <td >上级菜单 :</td>
                          <td >
                            <select name="pid" id="pid">
							<option value=""></option>
                              <? 
	                         			$sql3="select * from ".$TableInfo_category." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableInfo_category." where pid<>0" ;
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
						    <span class="star">*编号必须为整数</span></td>
					  </tr>
								<tr  class='tr2'>
									<td width="156" > 菜单名称:</td>
								  <td width="632" ><input name="name" type="text" id="name" >
							      <span class="star">*</span>别名:
							      <input name="alias_name" type="text" id="alias_name" ></td>
								</tr>
                                 <tr  class='tr2'   >
									<td >菜单位置:</td>
									<td >
								   <select name="menu_id" id="menu_id" multiple size="5"  >
                                        <?
										$menu_ids_array=explode(',',$menu_ids);
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
											if((int)$url_type==$i||(empty($url_type)&&$i==1))
												echo "<input name='url_type' onclick='MenuUrlType_change(".$i.")' type='radio' checked  value=".$i.">".$T_Url_type[$i];
											else
												echo "<input name='url_type' onclick='MenuUrlType_change(".$i.")'  type='radio'   value=".$i.">".$T_Url_type[$i];
										}
									?><span class="star">*</span>
                                    </td>
					  </tr>
                      <tr  class='tr2' id="tr_url" style="display:none;">
									<td width="156" > 菜单链接地址:</td>
						  <td width="632" ><input name="url" type="text" id="url" value="<?=$url?>" ></td>
					  </tr>
                      <tr  class='tr2' id="tr_module"  >
									<td >选择模块:</td>
									<td ><select name="module_id" id="module_id" onChange="changeModuleCom(this)">
                                      <?
											$pid=$module_id;
											$sql3="select module_name,id,pid from ".$TableModules." where pid=0 order by id ";
												$query3=$db->query($sql3);
												$sql4="select module_name,id,pid from ".$TableModules." where pid<>0   " ;
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
                       <tr  class='tr2' id="tr_component"  >
									<td >选择组件</td>
				 <td >
                 <select name="module_com" id="module_com">
                 </select>
				 </td>
					  </tr>
                       <tr  class='tr2'  id="tr_component_position" >
									<td >组件位置:</td>
									<td >
								   <select name="module_pos" id="module_pos" multiple size="5"  >
                                        <?
										$module_poss_array=explode(',',$module_poss);
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
                      
                      <tr  class='tr2' >
									<td >访问权限:</td>
									<td >
                                    <?
										for($i=1;$i<=count($T_Access_Level);$i++)
										{
											if((int)$access_level==$i||(empty($access_level)&&$i==1))
												echo "<input name='access_level' type='radio' checked  value='".$i."'>".$T_Access_Level[$i];
											else
												echo "<input name='access_level' type='radio'   value='".$i."'>".$T_Access_Level[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2'  style="display:none;" >
									<td >默认:</td>
									<td >									
									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$is_default==$i||(empty($is_default)&&$i==2))
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
											if((int)$is_show==$i||(empty($is_show)&&$i==1))
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
											if((int)$is_au==$i||(empty($is_au)&&$i==1))
												echo "<input name='is_au' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_au' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?>									<span class="star">*</span></td>
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
                     
								
								<tr  class='tr2' >
									<td >图片</td>
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
 

