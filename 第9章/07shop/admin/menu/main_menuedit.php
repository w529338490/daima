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
	if($status=="edit")
	{
			$indate=date('Y-m-j H:i:s');
		$id_no=$_POST['id_no'];//
		$menu_name=$_POST['menu_name'];//Menu Name
		$description=$_POST['description'];//Description
				$sql="update  ".$TableMain_menu." set 	id=".$id_no.",	menu_name='".$menu_name."',	description='".$description."'   where id=".$id;
				$query=$db->query($sql);
			$message='1';
	}
	$sql="select * from  ".$TableMain_menu."  where id=".$id;
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
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script>
</head>
<script language="javascript">
	function back()
	{
		location="main_menu.php";
	}

	function winclose()
	{
		window.opener.location.reload();
		window.close();
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
		if(form.menu_name.value=="")
		{
			alert("请输入菜单名称!");
			form.menu_name.focus();
			return;
		}
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
										</font>
									</td>
								</tr>
                                <tr  class='tr2' >
									<td width="156" > 编号</td>
                                  <td width="632" ><input name="id_no" type="text" id="id_no" value="<?=$row['id']?>" >
                                          <span class="star">*编号必须为整数</span></td>
                              </tr>
								<tr  class='tr2' >
									<td >菜单名称:</td>
									<td ><input name="menu_name" type="text" id="menu_name"  value="<?=$row['menu_name']?>" ></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100>描述</td>
									<td ><textarea name="description" cols="70" rows="10" id="description"><?=$row['description']?></textarea></td>
								</tr>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="提交" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="javascript:back()">
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
