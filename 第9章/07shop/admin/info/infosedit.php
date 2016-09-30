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
	if($status=="removeFile")
	{
		$sql=" select * from ".$TableInfos."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/infos/".$row['upload_path'];
		if(file_exists($FileName)&&!empty($row['upload_path']))
		{
			unlink($FileName);
		}
		$sql="update  ".$TableInfos." set 	upload_path='' where id=".$id;
		$query=$db->query($sql);
	}
	
	if($status=="removePic")
	{
		$sql=" select * from ".$TableInfos."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/infos/".$row['picture'];
		$FileName_thumbnail=$UploadPath."upload/infos/thumbnail_".$row['picture'];
		if(file_exists($FileName)&&!empty($row['picture']))
		{
			unlink($FileName);
			unlink($FileName_thumbnail);
		}
		$sql="update  ".$TableInfos." set 	picture='' where id=".$id;
		$query=$db->query($sql);
	}
	
	if($status=="edit")
	{
			$indate=date('Y-m-j H:i:s');
		$id=$_POST['id'];//
		$infos_category_id=$_POST['infos_category_id'];//菜单栏目
		$info_title=$_POST['info_title'];//标题
		$description=$_POST['description'];//Description
		$upload_type=$_POST['upload_type'];//上传类型
		$upload_path=$_POST['upload_path'];//Picture
		$embed_path=$_POST['embed_path'];//Embed
		$thumbnail_type=$_POST['thumbnail_type'];//Thumbnail Type
		$thumbnail_path=$_POST['thumbnail_path'];//Thumbnail
		$keyword=$_POST['keyword'];//Tags
		$is_verify=$_POST['is_verify'];//审核
		$featured=$_POST['featured'];//审核
		$upload_path_name = $_FILES["upload_path"]['name'];
		$upload_path=substr($upload_path_name,strrpos($upload_path_name,'.'),strlen($upload_path_name)-strrpos($upload_path_name,'.'));
		if(!empty($upload_path))
			$upload_path=getRandomNum().$upload_path;
		
		$picture_name = $_FILES["picture"]['name'];
		$picture=substr($picture_name,strrpos($picture_name,'.'),strlen($picture_name)-strrpos($picture_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
			
		$sql="update  ".$TableInfos." set featured=".$featured.", 	infos_category_id=".$infos_category_id.",	info_title='".$info_title."',	description='".$description."',	upload_type=".$upload_type.",		embed_path='".$embed_path."',	keyword='".$keyword."',	is_verify=".$is_verify."  where id=".$id;
		$query=$db->query($sql);
		
		if(!empty($picture_name))
	    {
				//delete old
				$sql="select * from  ".$TableInfos."  where id=".$id;
			   $row=$db->getRow($sql);
			   $PicName=$UploadPath."upload/infos/".$row['picture'];
			   $PicName_thumbnail=$UploadPath."upload/infos/thumbnail_".$row['picture'];
				 if(file_exists($FileName)&&!empty($row['picture']))
				{
				   unlink($PicName);
				   unlink($PicName_thumbnail);
				}
				
				$sql="update  ".$TableInfos." set picture='".$picture."'  where id=".$id;
			   $query=$db->query($sql);
				$FileName=$UploadPath."upload/infos/".$picture;
				$FileName_thumbnail=$UploadPath."upload/infos/thumbnail_".$picture;
				$picture = $_FILES['picture']['tmp_name'];
			   if(copy($picture,$FileName))
			   {
				  unlink($picture);
			   }
			    if($upload_type==1)
			   		ImageResize($FileName,$config_row['picture_thumbnail_width'],$config_row['picture_thumbnail_height'],$FileName_thumbnail);
			   if($upload_type==3||$upload_type==2)
			   		ImageResize($FileName,$config_row['video_thumbnail_width'],$config_row['video_thumbnail_height'],$FileName_thumbnail);
			   
		}
		if(!empty($upload_path_name))
	    {
				//delete old
				$sql="select * from  ".$TableInfos."  where id=".$id;
			   $row=$db->getRow($sql);
			   $FileName=$UploadPath."upload/infos/".$row['upload_path'];
			   if(file_exists($FileName)&&!empty($row['upload_path']))
				{
				   unlink($FileName);
				}
				
				$sql="update  ".$TableInfos." set upload_path='".$upload_path."'  where id=".$id;
			   $query=$db->query($sql);
				$FileName=$UploadPath."upload/infos/".$upload_path;
				$upload_path = $_FILES['upload_path']['tmp_name'];
			   if(copy($upload_path,$FileName))
			   {
				  unlink($upload_path);
			   }
			
		}
			$message='1';
	}
	$sql="select * from  ".$TableInfos."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>

</head>
<script language="javascript">
	function back()
	{
		location="infos.php";
	}

	function winclose()
	{
		window.opener.location.reload();
		window.close();
	}

	function Check()
	{
		var form=form1;
		if(form.infos_category_id.value=="")
		{
			alert("请选择菜单栏目!");
			form.infos_category_id.focus();
			return;
		}
		if(form.info_title.value=="")
		{
			alert("请输入 标题!");
			form.info_title.focus();
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
	
	function removeFile()
  	{
  		var form=form1;
  		if(confirm("真的想要删除吗?")==false)
  			return;
  		form.status.value="removeFile";
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
								<tr  class='tr2' >
									<td >菜单栏目:</td>
									<td >
									<select name="infos_category_id" id="infos_category_id">
										<option value=""></option>
										<?
											$pid=$row['infos_category_id'];
											$sql3="select name,id,pid from ".$TableInfo_category." where pid=0  and is_au=1 order by id ";
												$query3=$db->query($sql3);
												$sql4="select name,id,pid from ".$TableInfo_category." where pid<>0  and is_au=1  order by sortid " ;
												$resultCategroy=$db->getAll($sql4);
												while($object3=$db->fetch_object($query3))
												{
													$levelStr="";
													$level_num=1;
													if($object3->id==$pid)
														echo "<option value='".$object3->id."' selected>".$object3->name."</option>";
													else
														echo "<option value='".$object3->id."' >".$object3->name."</option>";
														for($i=0;$i<count($resultCategroy);$i++)
														{
															for($j=0;$j<$level_num;$j++)
																$levelStr.="----";
															if($object3->id==$resultCategroy[$i][pid])
															{
																if($resultCategroy[$i][id]==$pid)
																{
																	echo "<option value='".$resultCategroy[$i][id]."' selected>";
																		echo $levelStr.$resultCategroy[$i][name];
																	echo "</option>";
																}
																else
																{
																	echo "<option value='".$resultCategroy[$i][id]."' >";
																		echo $levelStr.$resultCategroy[$i][name];
																	echo "</option>";
																}
																subCategory($resultCategroy,$resultCategroy[$i][id],$pid);
															}
															$levelStr="";
														}
												}
										
												function subCategory($resultCategroy,$id,$pid)
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
																		echo $levelStr.$resultCategroy[$i][name];
																	echo "</option>";
																}
																else
																{
																	echo "<option value='".$resultCategroy[$i][id]."' >";
																		echo $levelStr.$resultCategroy[$i][name];
																	echo "</option>";
																}
																subCategory($resultCategroy,$resultCategroy[$i][id],$pid);
														}
														$levelStr="";
													}
													$level_num--;
												}
										?>
									</select>									</td>
								</tr>
								<tr  class='tr2' >
									<td >标题:</td>
									<td ><input name="info_title" type="text" id="info_title"  value="<?=$row['info_title']?>" ></td>
								</tr>
								<script language="javascript">
									window.onload = function()
									{
								    	var sBasePath  = "<?=$T_Fk_sBasePath?>";
								   		var oFCKeditor = new FCKeditor( 'description' );
								    	oFCKeditor.BasePath	= sBasePath;
										oFCKeditor.Config['AutoDetectLanguage'] = false;
										oFCKeditor.Config['DefaultLanguage']    = '<?=$T_FkDefaultLanguage?>';
										oFCKeditor.Config['LinkBrowserURL']     = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=文件';
										oFCKeditor.Config['ImageBrowserURL']    = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=Image';
										oFCKeditor.Config['FlashBrowserURL']    = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=Flash';
										oFCKeditor.Config['LinkUploadURL']      = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=文件';
										oFCKeditor.Config['ImageUploadURL']     = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=Image';
										oFCKeditor.Config['FlashUploadURL']     = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=Flash';
										oFCKeditor.Height='<?=$config_row['editor_height']?>';
										oFCKeditor.Width='<?=$config_row['editor_width']?>';
										oFCKeditor.ReplaceTextarea();
									}
								</script>
								<tr  class='tr2' >
									<td  width=100>描述</td>
									<td ><textarea name="description" cols="70" rows="10" id="description"><?=$row['description']?></textarea></td>
								</tr>
                                <tr  class='tr2' >
									<td >关键字:</td>
									<td ><textarea name="keyword" cols="70" rows="5" id="keyword"><?=$row['keyword']?></textarea></td>
								</tr>
								<tr  class='tr2'  >
									<td >上传类型:</td>
									<td >									<?
										for($i=1;$i<=count($T_Upload_Type);$i++)
										{
											if((int)$row['upload_type']==$i)
												echo "<input onClick='Upload_change(".$i.")'  name='upload_type' type='radio' checked  value='".$i."'>".$T_Upload_Type[$i];
											else
												echo "<input onClick='Upload_change(".$i.")'  name='upload_type' type='radio'   value='".$i."'>".$T_Upload_Type[$i];
										}
									?>									</td>
								</tr>
                                <tr  class='tr2'  id='tr_picture'    >
									<td >图片</td>
									<td >  
									<?	
										if(!empty($row['picture']))	
										{
									?>
                                        	<a target="_blank" href="../../upload/infos/<?=$row['picture']?>"  ><img width="<?=$config_row['picture_thumbnail_width']?>" height="<?=$config_row['picture_thumbnail_height']?>"  src="../../upload/infos/thumbnail_<?=$row['picture']?>" border="0" ></a> <input type="button" class='button' onClick="removePic()" value="删除">
								  <?	
								 		 }
								  ?>
                                  <br><input type="file" name="picture"  id="picture"></td>
								</tr>
								<tr  class='tr2'   id='tr_upload_path' <? if($row['upload_type']==1) echo "style='display:none;'";  ?>  >
									<td >文件:</td>
									<td >
                                    <?	
										if(!empty($row['upload_path']))	
										{
									?>
                                        	<a target="_blank" href="../../upload/infos/<?=$row['upload_path']?>"  ><?=$row['upload_path']?></a> <input type="button" class='button' onClick="removeFile()" value="删除">
								  <?	
								 		 }
								  ?>
                                  <br><input type="file" name="upload_path"  id="upload_path"></td>
								</tr>
								 <script language="javascript">
									function Upload_change(flag)
									{
										if(flag==1)
										{
											document.getElementById('tr_upload_path').style.display="none";
										}
										if(flag==2||flag==3)
										{
											document.getElementById('tr_upload_path').style.display="";
										}
									}
								</script>
                                 <tr  class='tr2'  >
									<td >推荐:</td>
									<td >									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$row['featured']==$i)
												echo "<input name='featured' type='radio' checked  value='".$i."'>".$T_Is_YesNO[$i];
											else
												echo "<input name='featured' type='radio'   value='".$i."'>".$T_Is_YesNO[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2' >
									<td >审核:</td>
									<td >									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$row['is_verify']==$i)
												echo "<input name='is_verify' type='radio' checked  value='".$i."'>".$T_Is_YesNO[$i];
											else
												echo "<input name='is_verify' type='radio'   value='".$i."'>".$T_Is_YesNO[$i];
										}
									?>									</td>
								</tr>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="提交" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="javascript:back()">						        </td>
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
<input type="hidden" name="id" value=<?=$id?>>
</form>
</body>
</html>
<? $db->close_db();?>
