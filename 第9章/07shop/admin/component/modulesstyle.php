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
	$sql="select * from  ".$TableModules." where id=".$id;
	$row=$db->getRow($sql);
    $status=$_POST['status'];
	if($status=="editstyle")
	{
		//write
		$filepath=$BASEPATH."/modules/".$row['module_name']."/css/style.css";
		$fp= fopen ($filepath,"w");
		$content=$_POST['content'];
		fwrite($fp,$content,strlen($content));
		fclose ($fp);
	}
	
	
	//read
	$filepath=$BASEPATH."/modules/".$row['module_name']."/css/style.css";
	$fp= fopen ($filepath,"r");
	$content = fread ($fp,filesize($filepath));
	fclose ($fp);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
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
		location="modules.php";
	}

	function Check()
	{
		var form=form1;
		
		
		 form.status.value="editstyle";
		 form.message.value=1;
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
					<table  class="addTable"   border='0'  cellpadding='0'  cellspacing='1'>
              				<tr align="center"  class='tr2'>
               					 <td>
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "";
                                                                    }
                                                               ?>
                                   </font>       				          </td>
              				</tr>
                                <tr  class='tr2' >
									<td >模块样式-<?=$row['module_name']?></td>
								</tr>
								<tr  class='tr2' >
									<td ><textarea style="width:100%" name="content" rows="25" id="content"><?=$content?></textarea></td>
								</tr>
              				<tr  class='tr2'>
       				          <td align="center"><input type="button" style="width:80px;"  class="button" value="提交" onClick="Check()">
       				            &nbsp;&nbsp;&nbsp;&nbsp;      &nbsp;&nbsp;
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
</form>
</body>
</html>
<? $db->close_db();?>
 

