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
		$id=$_POST['id'];
		$menu_name=$_POST['menu_name'];//Menu Name
		$description=$_POST['description'];//Description
			 $sql="insert into  ".$TableMain_menu."(id,menu_name,description)values(".$id.",'".$menu_name."','".$description."')";
			$query=$db->query($sql);
			if($query) $message=1;
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

	function Check()
	{
		var form=form1;
		if(!isIntegerPlus(form.id.value))
		{
			alert("请输入编号!");
			form.id.focus();
			return;
		}
		if(form.menu_name.value=="")
		{
			alert("请输入菜单名称!");
			form.menu_name.focus();
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
                                                          </font>
                				         </td>
              				</tr>
                            <tr  class='tr2'>
									<td width="156" > 编号</td>
						  <td width="632" ><input name="id" type="text" id="id" value="<?=$id?>" >
						    <span class="star">*编号必须为整数</span></td>
					  </tr>
								<tr  class='tr2' >
									<td >菜单名称:</td>
									<td ><input name="menu_name" type="text" id="menu_name" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >描述</td>
									<td ><textarea name="description" cols="70" rows="10" id="description"></textarea></td>
								</tr>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="提交" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
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
</form>
</body>
</html>
<? $db->close_db();?>
