<? require "../../Configuration.php"?>
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
	$addFileName="";
	if($status=="uploadfile")
	{
	   	$file_name = $_FILES["file"]['name'];
		//$picture=substr($file_name,strrpos($file_name,'.'),strlen($file_name)-strrpos($file_name,'.'));
	   
		if(!empty($file_name))
	    {
				$addFileName=getRandomNum().$file_name;
				$FileName=$UploadPath."upload/".$dir_name."/".$addFileName;
				$file = $_FILES['file']['tmp_name'];
			   if(copy($file,$FileName))
			   {
				  unlink($file);
			   }
		}
	}
	
	if($status=="remove")
    {
		$fileArray=explode(',',$fileRemoveList);
		for($i=0;$i<count($fileArray)-1;$i++)
		{
			$FileName=$UploadPath."upload/".$dir_name."/".$fileArray[$i];
			if(file_exists($FileName))
			{ 
				 unlink($FileName);
			}
		}
    }
?>
<html>
<head>
<title>图片上传</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
</head>
<script language="javascript">
	function winclose()
	{
		window.close();
	}
	
	function init()//打开页面保存初始化值
	{
		var form=form1;
		var file_name=window.opener.form1.<?=$picture_name?>;
		var file_nameArray=file_name.value.split(",");
		for(var i=0;file_name.value!=""&&i<file_nameArray.length;i++)
		{
			 var newoption=new Option();
			  newoption.value=file_nameArray[i];
			  newoption.text=file_nameArray[i];
			  form.fileList.options[form.fileList.length]=newoption;
		}
	}
	

	function check()
	{
		var form=form1;
		if(form.fileList.length<=0) winclose();
		save();
		winclose();
	}
	
	function save()
	{
		var form=form1;
		var file_name=window.opener.form1.<?=$picture_name?>;
		file_name.value="";
		if(form.fileList.length>0) 
		{
			for(var i=0;i<form.fileList.length-1;i++)
			{
				file_name.value+=form.fileList.options[i].value+",";
			}
			file_name.value+=form.fileList.options[form.fileList.length-1].value;
		}
	}
	
	function uploadfile()
	{
		var form=form1;
		if(form.fileList.length>0) save();
		form.status.value='uploadfile';
		form.submit();
	}
	
	function select_All()//提交前全选
	{
		var form=form1;
		for(var i=0;i<form.fileList.length;i++)
		{
		  	  form.fileList.options[i].selected=true;
		}
	}

	
	function remove()
	{
		var form=form1;
		 for(var i=form.fileList.length-1;i>=0;i--)
		{
		  	if(form.fileList.options[i].selected)
			{
				//加入删除列表
			    form.fileRemoveList.value+=form.fileList.options[i].value+",";
				form.fileList.remove(i);
			}
		}
		save();
		form.status.value="remove";
		form.submit();
	}
	

</script>
<body onLoad="init();">
<form action=""  method="post"  name="form1"  enctype="multipart/form-data">
  <table   width="100%" class="addborder">
      <tr align="center" >
        <td height="20" align="right">&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Submit23" type="button" class="button" onClick="check()" value="确定">
          &nbsp;
        <input name="Submit22" type="button" class="button" onClick="winclose()" value="关闭"></td>
      </tr>
      <tr >
        <td align="center" valign="top" ><table   width="80%" class="font1"  >
          <tr >
            <td >上传文件列表</td>
            <td >&nbsp;</td>
          </tr>
          <tr >
            <td ><input name="file" type="file" size="40"></td>
            <td >&nbsp;</td>
          </tr>
          <tr >
            <td  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><select name="fileList" id="fileList" size="20" style="width:300px; "  multiple="multiple"   onChange="changePic(this)">
                    </select>
                      <?
						 if(!empty($addFileName))
						 {
							echo "<script language='javascript'>";
							echo"	var newoption1=new Option();";
							echo"	newoption1.value='".$addFileName."';";
							echo"	newoption1.text='".$addFileName."';";
							echo"	newoption1.selected=true;";
							echo"	form1.fileList.options[form1.fileList.length]=newoption1;";
							echo"</script>";
						}
						?>
						<script language="javascript">
							function changePic(obj)
							{
								document.all("preimage").src="<?=$UploadPath."upload/".$dir_name."/"?>"+obj.value;
							}
						</script>
				</td>
                    <td>
					<img src="" width="160" height="260" border="0" id="preimage">					</td>
                  </tr>
                </table></td>
            <td  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="40" align="center"><input name="Submit2323" type="button" class="button" onClick="uploadfile()" value="上传"></td>
                </tr>
                <tr>
                  <td height="40" align="center"><input name="Submit2324" type="button" class="button" onClick="remove()" value="删除"></td>
                </tr>
            </table></td>
          </tr>
        </table>
          </td>
      </tr>
    </table>
<input type="hidden" name="status" >
<input type="hidden" name="message" value="huyang" >
<textarea name="fileRemoveList" style="display:none;"></textarea>
</form>
</body>
</html>
 

