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
	$sql="select  ".$TableInfos.".* ,".$TableInfo_category.".name as  video_category_name  from    ".$TableInfos." ,".$TableInfo_category."   where ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id  and  ".$TableInfos.".id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
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
								<tr  class='tr2' >
									<td><font class='fontb'>菜单栏目:</font></td>
									<td >
									<?=$row['video_category_name']?>									</td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>标题:</font></td>
									<td ><?=$row['video_title']?></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100 ><font class='fontb'>描述</font></td>
									<td  class="lookfont" ><?=$row['description']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>上传类型:</font></td>
									<td >
									<?=$T_Upload_Type[$row['upload_type']]?>									</td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>图片</font></td>
									<td ><embed width="100" height="80"  src="../../upload/infos/<?=$row['id'].$row['upload_path']?>" ></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100 ><font class='fontb'>Embed:</font></td>
									<td  class="lookfont" ><?=toBr($row['embed_path'])?></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100 ><font class='fontb'>Tags:</font></td>
									<td  class="lookfont" ><?=toBr($row['keyword'])?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>审核:</font></td>
									<td >
									<?=$T_Is_YesNO[$row['is_verify']]?>									</td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Views:</font></td>
									<td ><?=$row['views_count']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Comments:</font></td>
									<td ><?=$row['comments_count']?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>Upload Datetime:</font></td>
									<td ><?=FormatDate($row['upload_datetime'])?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>Last Updatetime:</font></td>
									<td ><?=FormatDate($row['last_updatetime'])?></td>
								</tr>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
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
<input type="hidden" name="id" value=<?=$id?>>
</form>
</body>
</html>
<? $db->close_db();?>
