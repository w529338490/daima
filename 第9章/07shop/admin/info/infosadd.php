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
    //add
	$status=$_POST['status'];
	if($status=="add")
	{
		$indate=date('Y-m-j H:i:s');
		$infos_category_id=$_POST['infos_category_id'];//菜单栏目
		$info_title=$_POST['info_title'];//标题
		$description=$_POST['description'];//Description
		$upload_type=$_POST['upload_type'];//上传类型
		$upload_path=$_POST['upload_path'];//Picture
		$embed_path=$_POST['embed_path'];//Embed
		$keyword=$_POST['keyword'];//Tags
		$is_verify=$_POST['is_verify'];//审核
		$featured=$_POST['featured'];//审核
		$views_count="0";//Views
		$comments_count="0";//Comments
		$upload_datetime=$indate;//Upload Datetime
		$last_updatetime=$indate;//Last Updatetime
		$upload_user=$_SESSION['SessionAdminUser']['username'];
	   	$upload_path_name = $_FILES["upload_path"]['name'];
		$upload_path=substr($upload_path_name,strrpos($upload_path_name,'.'),strlen($upload_path_name)-strrpos($upload_path_name,'.'));
		if(!empty($upload_path))
			$upload_path=getRandomNum().$upload_path;
			
		$picture_name = $_FILES["picture"]['name'];
		$picture=substr($picture_name,strrpos($picture_name,'.'),strlen($picture_name)-strrpos($picture_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
		
		$sql="insert into  ".$TableInfos."(picture,upload_user,featured,infos_category_id,info_title,description,upload_type,upload_path,embed_path,keyword,is_verify,views_count,comments_count,upload_datetime,last_updatetime)values('".$picture."','".$upload_user."',".$featured.",".$infos_category_id.",'".$info_title."','".$description."',".$upload_type.",'".$upload_path."','".$embed_path."','".$keyword."',".$is_verify.",".$views_count.",".$comments_count.",'".$upload_datetime."','".$last_updatetime."')";
		$query=$db->query($sql);
		
		
		if(!empty($upload_path_name))
	    {
				$FileName=$UploadPath."upload/infos/".$upload_path;
				$upload_path = $_FILES['upload_path']['tmp_name'];
			   if(copy($upload_path,$FileName))
			   {
				  unlink($upload_path);
			   }
		}
		
		if(!empty($picture_name))
	    {
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
  		$message=1;
		
	}
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
		
		 form.status.value="add";
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
              				<tr align="center"  class='tr2' >
               					 <td colspan="2">
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "添加成功 ";
                                                                    }
                                                               ?>
                                                          </font>                				         </td>
              				</tr>
								<tr  class='tr2' >
									<td >菜单栏目:</td>
									<td >
									<select name="infos_category_id" id="infos_category_id">
										<option value=""></option>
										<?
											$pid=$infos_category_id;
											$sql3="select name,id,pid from ".$TableInfo_category." where pid=0 and is_au=1  order by id ";
												$query3=$db->query($sql3);
												$sql4="select name,id,pid from ".$TableInfo_category." where pid<>0 and is_au=1   order by sortid " ;
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
									<td ><input name="info_title" type="text" id="info_title" value="" ></td>
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
									<td >描述</td>
									<td ><textarea name="description" cols="70" rows="10" id="description"></textarea></td>
								</tr>
                                <tr  class='tr2' >
									<td >关键字:</td>
									<td ><textarea name="keyword" cols="70" rows="5" id="keyword"></textarea></td>
								</tr>
								<tr  class='tr2'  >
									<td >上传类型:</td>
									<td >									<?
										for($i=1;$i<=count($T_Upload_Type);$i++)
										{
											if((int)$upload_type==$i||(empty($upload_type)&&$i==1))
												echo "<input name='upload_type' onClick='Upload_change(".$i.")' type='radio' checked  value='".$i."'>".$T_Upload_Type[$i];
											else
												echo "<input name='upload_type' onClick='Upload_change(".$i.")'  type='radio'   value='".$i."'>".$T_Upload_Type[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2'  id='tr_picture'    >
									<td >图片</td>
									<td ><input type="file" name="picture"  id="picture"></td>
								</tr>
                                <tr  class='tr2'  id='tr_upload_path' style="display:none;"    >
									<td >文件:</td>
									<td ><input type="file" name="upload_path"  id="upload_path"></td>
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
                                <tr  class='tr2'>
									<td >推荐:</td>
									<td >									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$featured==$i||(empty($featured)&&$i==2))
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
											if((int)$is_verify==$i||(empty($is_verify)&&$i==1))
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
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">						        </td>
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
</form>
</body>
</html>
<? $db->close_db();?>
