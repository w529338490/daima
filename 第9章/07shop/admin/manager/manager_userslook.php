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
	$sql="select  ".$TableAdmin.".* ,".$TableRole.".name as  manager_role_name  from    ".$TableAdmin." ,".$TableRole."   where ".$TableAdmin.".UserGrade = ".$TableRole.".id  and  ".$TableAdmin.".id=".$id;
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
		location="manager_users.php";
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
									<td><font class='fontb'>用户组:</font></td>
									<td >
									<?=$row['manager_role_name']?>
									</td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Nick Name:</font></td>
									<td ><?=$row['nick_name']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Site 编号</font></td>
									<td ><?=$row['site_id']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>电子邮件:</font></td>
									<td ><?=$row['username']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>密码:</font></td>
									<td ><?=$row['psw']?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>出生日期:</font></td>
									<td ><?=FormatDate($row['date_of_birth'])?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>国家:</font></td>
									<td ><?=$row['country']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>省份:</font></td>
									<td ><?=$row['province_state']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>市/县:</font></td>
									<td ><?=$row['county']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>邮政编码:</font></td>
									<td ><?=$row['zip_code']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>性别:</font></td>
									<td >
									<?=$T_Gender[$row['sex']]?>
									</td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>我的网站:</font></td>
									<td ><?=$row['my_website']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>联系地址:</font></td>
									<td ><?=$row['my_location']?></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100 ><font class='fontb'>介绍:</font></td>
									<td  class="lookfont" ><?=toBr($row['introducton'])?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>上传类型:</font></td>
									<td >
									<?=$T_Avatar_Type[$row['upload_type']]?>
									</td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>照片:</font></td>
									<td ><img width="100" height="80"  src="../../upload/manager_users/<?=$row['id'].$row['photo']?>" border="0" ></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Default Avatar:</font></td>
									<td ><?=$row['default_avatar']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>College Area:</font></td>
									<td ><?=$row['college_area']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>College:</font></td>
									<td ><?=$row['college']?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>Register Date:</font></td>
									<td ><?=FormatDate($row['regtime'])?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Item 编号</font></td>
									<td ><?=$row['itemid']?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>Last Update Time:</font></td>
									<td ><?=FormatDate($row['last_updatetime'])?></td>
								</tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>Last Visited Time:</font></td>
									<td ><?=FormatDate($row['last_visittime'])?></td>
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
									<td><font class='fontb'>Sent Messages:</font></td>
									<td ><?=$row['send_msg_count']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Receive Messages:</font></td>
									<td ><?=$row['rev_msg_count']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>Profile Views:</font></td>
									<td ><?=$row['profile_views_count']?></td>
								</tr>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">
						        </td>
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
