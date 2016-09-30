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
		$template_name=$_POST['template_name'];//模板名称
		$is_default=$_POST['is_default'];//Default
			 $sql="insert into  ".$TableTemplates."(template_name,is_default)values('".$template_name."',".$is_default.")";
		
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
		location="templates.php";
	}

	function Check()
	{
		var form=form1;
		if(form.template_name.value=="")
		{
			alert("请输入 模板名称!");
			form.template_name.focus();
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
								<tr  class='tr2' >
									<td >模板名称:</td>
									<td ><input name="template_name" type="text" id="template_name" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >默认:</td>
									<td >									<?
										for($i=1;$i<=count($T_Is_YesNO);$i++)
										{
											if((int)$is_default==$i||(empty($is_default)&&$i==1))
												echo "<input name='is_default' type='radio' checked  value='".$i."'>".$T_Is_YesNO[$i];
											else
												echo "<input name='is_default' type='radio'   value='".$i."'>".$T_Is_YesNO[$i];
										}
									?>
									</td>
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
