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
	$id="1";
	if($status=="edit")
	{
		$indate=date('Y-n-j H:i:s');
		$id=$_POST['id'];//
		$editor_type=$_POST['editor_type'];
		$editor_width=$_POST['editor_width'];
		$editor_height=$_POST['editor_height'];
		$user_thumbnail_width=$_POST['user_thumbnail_width'];
		$user_thumbnail_height=$_POST['user_thumbnail_height'];
		$host_email=$_POST['host_email'];
		$host_url=$_POST['host_url'];
		$product_picture_width=$_POST['product_picture_width'];
		$product_picture_height=$_POST['product_picture_height'];
		$product_picture_thumbnail_width=$_POST['product_picture_thumbnail_width'];
		$product_picture_thumbnail_height=$_POST['product_picture_thumbnail_height'];
		$upload_size=$_POST['upload_size'];
		$list_pageturn_num=$_POST['list_pageturn_num'];
		$module_limit_num=$_POST['module_limit_num'];
		$menuitem_thumbnail_width=$_POST['menuitem_thumbnail_width'];
		$menuitem_thumbnail_height=$_POST['menuitem_thumbnail_height'];
		$price_type=$_POST['price_type'];
		
		$sql="update  ".$TableConfig." set ";
		$sql.="	editor_type=".$editor_type.",";
		$sql.="	editor_width='".$editor_width."',";
		$sql.="	editor_height='".$editor_height."',";
		$sql.="	user_thumbnail_width='".$user_thumbnail_width."',";
		$sql.="	user_thumbnail_height='".$user_thumbnail_height."',";
		$sql.="	host_url='".$host_url."',";
		$sql.="	host_email='".$host_email."',";
		$sql.="	product_picture_width='".$product_picture_width."',";
		$sql.="	product_picture_height='".$product_picture_height."',";
		$sql.="	product_picture_thumbnail_width='".$product_picture_thumbnail_width."',";
		$sql.="	product_picture_thumbnail_height='".$product_picture_thumbnail_height."',";
		$sql.="	list_pageturn_num='".$list_pageturn_num."',";
		$sql.="	module_limit_num='".$module_limit_num."',";
		$sql.="	menuitem_thumbnail_width='".$menuitem_thumbnail_width."',";
		$sql.="	menuitem_thumbnail_height='".$menuitem_thumbnail_height."',";
		$sql.="	price_type=".$price_type.",";
		$sql.="	upload_size='".$upload_size."'";
		$sql.="	  where id=".$id;
		$query=$db->query($sql);
		if(!empty($query))
		{
			$message="1";
		}
	}
	$sql="select * from  ".$TableConfig."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script></head>
<script language="javascript">
	function back()
	{
		location="config.php";
	}

	function Check()
	{
		var form=form1;
		
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
								<tr  class='tr1'  >
								  <td colspan="2" align="center"   class="fontb">&nbsp;</td>
					  </tr>
                      <tr  class='tr1'  >
									<td   class="fontb">系统:</td>
									<td >									</td>
					  </tr>
								<tr  class='tr2'   >
									<td >网站地址 :</td>
								    <td ><input name="host_url" type="text" id="host_url"   value="<?=$row['host_url']?>" ></td>
								</tr>
                                <tr  class='tr2'   >
									<td >邮件地址 :</td>
								    <td ><input name="host_email" type="text" id="host_email"   value="<?=$row['host_email']?>" ></td>
								</tr>
								<tr  class='tr1'  >
									<td   class="fontb">编辑器:</td>
									<td >									</td>
								</tr>
								<tr  class='tr2'  style="display:none;" >
									<td >Editor Type :</td>
								    <td >
								  <?
										for($i=1;$i<=count($T_Editor_type);$i++)
										{
											if((int)$row['editor_type']==$i)
												echo "<input name='editor_type' type='radio' checked  value=".$i.">".$T_Editor_type[$i];
											else
												echo "<input name='editor_type' type='radio'   value=".$i.">".$T_Editor_type[$i];
										}
									?>								  </td>
								</tr>
								<tr  class='tr2'   >
									<td >编辑器宽度 :</td>
								    <td ><input name="editor_width" type="text" id="editor_width"   value="<?=$row['editor_width']?>" ></td>
								</tr>
								<tr  class='tr2'   >
									<td >编辑器高度 :</td>
								    <td ><input name="editor_height" type="text" id="editor_height"   value="<?=$row['editor_height']?>" ></td>
								</tr>
                                <tr  class='tr1'  >
									<td   class="fontb">用户:</td>
									<td >									</td>
								</tr>
								<tr  class='tr2'   >
									<td >用户小图片宽度 :</td>
								    <td ><input name="user_thumbnail_width" type="text" id="user_thumbnail_width"   value="<?=$row['user_thumbnail_width']?>" ></td>
								</tr>
								<tr  class='tr2'   >
									<td >用户小图片高度 :</td>
								    <td ><input name="user_thumbnail_height" type="text" id="user_thumbnail_height"   value="<?=$row['user_thumbnail_height']?>" ></td>
								</tr>
                                 <tr  class='tr1'  >
									<td   class="fontb">菜单:</td>
									<td >									</td>
								</tr>
                               <tr  class='tr2'   >
									<td >菜单小图片宽度 :</td>
								    <td ><input name="menuitem_thumbnail_width" type="text" id="menuitem_thumbnail_width"   value="<?=$row['menuitem_thumbnail_width']?>" ></td>
								</tr>
								<tr  class='tr2'   >
									<td >菜单小图片高度 :</td>
								    <td ><input name="menuitem_thumbnail_height" type="text" id="menuitem_thumbnail_height"   value="<?=$row['menuitem_thumbnail_height']?>" ></td>
								</tr>
                                 <tr  class='tr1'  >
									<td   class="fontb">产品:</td>
									<td >									</td>
								</tr>
                                <tr  class='tr2'   >
									<td >货币符号 :</td>
								    <td ><select name="price_type" id="price_type">
                                      <?
											for($i=1;$i<=count($T_Price_type);$i++)
											{
												 if((int)$price_type==$i)
													echo "<option value=".$i." selected>".$T_Price_type[$i]."</option>";
												else
													echo "<option value=".$i.">".$T_Price_type[$i]."</option>";
											}
										?>
                                    </select></td>
								</tr>
                               <tr  class='tr2'   >
									<td >产品图片宽度 :</td>
								    <td ><input name="product_picture_width" type="text" id="product_picture_width"   value="<?=$row['product_picture_width']?>" ></td>
								</tr>
								<tr  class='tr2'   >
									<td >产品图片高度:</td>
								    <td ><input name="product_picture_height" type="text" id="product_picture_height"   value="<?=$row['product_picture_height']?>" ></td>
								</tr>
                                <tr  class='tr2'   >
									<td >产品小图片宽度 :</td>
								    <td ><input name="product_picture_thumbnail_width" type="text" id="product_picture_thumbnail_width"   value="<?=$row['product_picture_thumbnail_width']?>" ></td>
								</tr>
								<tr  class='tr2'   >
									<td >产品小图片高度 :</td>
								    <td ><input name="product_picture_thumbnail_height" type="text" id="product_picture_thumbnail_height"   value="<?=$row['product_picture_thumbnail_height']?>" ></td>
								</tr>
                                <tr  class='tr2'   >
									<td >翻页每页显示条数:</td>
								    <td ><input name="list_pageturn_num" type="text" id="list_pageturn_num"   value="<?=$row['list_pageturn_num']?>" size="3" maxlength="3" ></td>
								</tr>
                                <tr  class='tr2'   >
									<td >上传文件大小:</td>
							      <td ><input name="upload_size" type="text" id="upload_size"   value="<?=$row['upload_size']?>" size="8" maxlength="8" >
1000 = 1KB</td>
								</tr>
                                 <tr  class='tr1'  >
									<td   class="fontb">模块:</td>
									<td >									</td>
								</tr>
								<tr  class='tr2'   >
									<td >模块显示条数 :</td>
								    <td ><input name="module_limit_num" type="text" id="module_limit_num"   value="<?=$row['module_limit_num']?>" size="2" maxlength="2" ></td>
								</tr>
              				<tr  class='tr2' >
       				          <td colspan="2" align="center"><input type="button"  class='button' name="Button" value="Submit" onClick="Check()"></td>
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
 

