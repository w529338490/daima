<? require "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
    //添加
	$status=$_POST['status'];
	if($status=="add")
	{
		$indate=date('Y-m-j H:i:s');
		$eb_product_category_id=$_POST['eb_product_category_id'];//产品分类
		$product_name=$_POST['product_name'];//产品名称
		
		$market_price=$_POST['market_price'];//市场价格
		$price=$_POST['price'];//当前价格
		$price_type=$_POST['price_type'];//当前价格货币
		
		$keywords=$_POST['keywords'];
		$quantity=$_POST['quantity'];//数量
		$is_verify=$_POST['is_verify'];//审核
		$is_recomend="1";//是否推荐
		$featured=$_POST['featured'];//推荐
		
		$content=$_POST['content'];//描述
		$publish_people=$_SESSION['SessionAdminUser']['username'];//发布人
		$publish_time=$indate;//发布时间
		$picture=$_POST['picture'];//商品图片

		$click_count="0";//点击数
		$remark_count="0";//评论数
		
	   	$file_name = $_FILES["file"]['name'];
		$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
		if(!empty($picture))
			$picture=getRandomNum().$picture;
		
		 $sql="insert into  ".$TableEb_product."(keywords,eb_product_category_id,product_name,market_price,price,quantity,is_verify,is_recomend,featured,content,publish_people,publish_time,picture,click_count,remark_count)values('".$keywords."',".$eb_product_category_id.",'".$product_name."',".$market_price.",".$price.",".$quantity.",".$is_verify.",".$is_recomend.",".$featured.",'".$content."','".$publish_people."','".$publish_time."','".$picture."',".$click_count.",".$remark_count.")";
		$query=$db->query($sql);
	   	if(!empty($file_name))
	    {
				$FileName=$UploadPath."upload/eb_product/".$picture;
				$file = $_FILES['file']['tmp_name'];
			   if(copy($file,$FileName))
			   {
				  unlink($file);
			   }
			   $FileName_s=$UploadPath."upload/eb_product/s".$picture;
				ImageResize($FileName,$config_row['product_picture_thumbnail_width'],$config_row['product_picture_thumbnail_height'],$FileName_s);
			   $message=1;
			
		}
		
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
		location="eb_product.php";
	}

	function Check()
	{
		var form=form1;
		if(form.eb_product_category_id.value=="")
		{
			alert("请选择 产品分类!");
			form.eb_product_category_id.focus();
			return;
		}
	
		if(form.product_name.value=="")
		{
			alert("请输入 产品名称!");
			form.product_name.focus();
			return;
		}
		
		
		if(!isFloat(form.market_price.value))
		{
			alert("市场价格必须 0.00!");
			form.market_price.focus();
			return;
		}
		if(!isFloat(form.price.value))
		{
			alert("当前价格必须 0.00!");
			form.price.focus();
			return;
		}
		
		if(!isIntegerPlus(form.quantity.value))
		{
			alert("数量必须为整数!");
			form.quantity.focus();
			return;
		}
		
		 form.status.value="add";
		 form.submit();
  	}
</script>
<body >
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
                                                    echo "Add Successfully";
                                                }
                                           ?>
                                      </font>                				         </td>
              				</tr>
								<tr  class='tr2' >
									<td >产品分类:</td>
									<td >
									<select name="eb_product_category_id" id="eb_product_category_id">
										
										<?;
											$pid=$eb_product_category_id;
											$sql3="select name,id,pid from ".$TableEb_product_category." where pid=0";
												$query3=$db->query($sql3);
												$sql4="select name,id,pid from ".$TableEb_product_category." where pid<>0" ;
												$resultCategroy=$db->getAll($sql4);
												while($object3=$db->fetch_object($query3))
												{
													$levelStr="";
													$level_num=1;
													if($object3->id==$pid)
														echo "<option value=".$object3->id." selected>".$object3->name."</option>";
													else
														echo "<option value=".$object3->id." >".$object3->name."</option>";
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
																sub产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
															}
															$levelStr="";
														}
												}
										
												function sub产品分类($resultCategroy,$id,$pid)
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
																sub产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
														}
														$levelStr="";
													}
													$level_num--;
												}
										?>
									</select>									</td>
								</tr>
								<tr  class='tr2' >
									<td >产品名称:</td>
									<td ><input name="product_name" type="text" id="product_name" ></td>
								</tr>
								<tr    class='tr2' >
									<td >市场价格:</td>
									<td ><input name="market_price" type="text" id="market_price" value="0.00" ></td>
								</tr>
								<tr  class='tr2' >
									<td >当前价格:</td>
								  <td ><input name="price" type="text" id="price" value="0.00" ></td>
								</tr>
								
								<tr   style="display:none;"  class='tr2' >
								  <td >数量:</td>
								  <td ><input name="quantity" type="text" id="quantity" value="1" ></td>
					  </tr>
								<tr    class='tr2' >
								  <td >审核:</td>
								  <td ><?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$is_verify==$i||(empty($is_verify)&&$i==1))
												echo "<input name='is_verify' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='is_verify' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?>
                                    <span class="star">*</span></td>
					  </tr>
								<tr    class='tr2' >
									<td >推荐:</td>
									<td ><?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$featured==$i||(empty($featured)&&$i==2))
												echo "<input name='featured' type='radio' checked  value=".$i.">".$T_Is_YesNO[$i];
											else
												echo "<input name='featured' type='radio'   value=".$i.">".$T_Is_YesNO[$i];
										}
									?></td>
								</tr>
								
								<script language="javascript">
									window.onload = function()
									{
								    	var sBasePath  = "<?=$T_Fk_sBasePath?>";
								   		var oFCKeditor = new FCKeditor( 'content' );
								    	oFCKeditor.BasePath	= sBasePath;
										oFCKeditor.Config['AutoDetectLanguage'] = false;
										oFCKeditor.Config['DefaultLanguage']    = 'zh-cn';
										oFCKeditor.Config['LinkBrowserURL']     = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=File';
										oFCKeditor.Config['ImageBrowserURL']    = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=Image';
										oFCKeditor.Config['FlashBrowserURL']    = oFCKeditor.BasePath + 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&Type=Flash';
										oFCKeditor.Config['LinkUploadURL']      = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=File';
										oFCKeditor.Config['ImageUploadURL']     = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=Image';
										oFCKeditor.Config['FlashUploadURL']     = oFCKeditor.BasePath + 'editor/filemanager/upload/php/upload.php?Type=Flash';
										oFCKeditor.Height='<?=$config_row['editor_height']?>';
										oFCKeditor.Width='<?=$config_row['editor_width']?>';
										oFCKeditor.ReplaceTextarea();
									}
								</script>
								<tr  class='tr2' >
									<td >描述:</td>
									<td >
									<textarea name="content" cols="70" rows="10" id="content"></textarea>									</td>
								</tr>
                                <tr  class='tr2'  >
									<td >关键字:</td>
									<td ><textarea name="keywords" cols="70" rows="4" id="keywords"></textarea></td>
								</tr>
								<tr  class='tr2' >
									<td >产品图片:</td>
									<td ><input type="file" name="file"></td>
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
 

