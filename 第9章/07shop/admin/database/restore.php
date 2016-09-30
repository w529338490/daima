<?

include("mydb.php");
include("config.php");

/******界面*/if(!$_POST['act']&&!$_SESSION['data_file']){/**********************/

?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<form action="" method="post" enctype="multipart/form-data" name="restore.php">
<table width="91%"  style="font-size:12px;"  border="0" cellpadding="0" cellspacing="1">
<tr align="center" class="header">
  <td colspan="2" align="center">Restore</td>
</tr>
<tr><td width="33%"><input type="radio" name="restorefrom" value="server" checked>
Restore from server</td><td width="67%"><select name="serverfile">
    <option value="">-Select-</option>
<?
$handle=opendir('./backup');
while ($file = readdir($handle)) {
    if(eregi("^[0-9]{8,8}([0-9a-z_]+)(\.sql)$",$file)) echo "<option value='$file'>$file</option>";}
closedir($handle); 
?>
  </select> </td></tr>
<tr><td><input type="radio" name="restorefrom" value="localpc"> 
Restore from local    </td>
<td><input type="hidden" name="MAX_FILE_SIZE" value="1500000"><input type="file" name="myfile"></td></tr>
<tr><td colspan="2" align="center"> <input type="submit" name="act" value="submit"></td>  </tr></table></form>


<?/**************************界面结束*/}/*************************************/
/****************************主程序*/if($_POST['act']=="恢复"){/**************/
/***************服务器恢复*/if($_POST['restorefrom']=="server"){/**************/
if(!$_POST['serverfile'])
	{$msgs[]="您选择从服务器文件恢复备份，但没有指定备份文件";
	 show_msg($msgs); pageend();	}
if(!eregi("_v[0-9]+",$_POST['serverfile']))
	{$filename="./backup/".$_POST['serverfile'];
	if(import($filename)) $msgs[]="Restore ".$_POST['serverfile']." import successfully";
	else $msgs[]="Restore ".$_POST['serverfile']." import failing";
	show_msg($msgs); pageend();		
	}
else
	{
	$filename="./backup/".$_POST['serverfile'];
	if(import($filename)) $msgs[]="Restore".$_POST['serverfile']." import successfully";
	else {$msgs[]="Restore".$_POST['serverfile']." import failing";show_msg($msgs);pageend();}
	$voltmp=explode("_v",$_POST['serverfile']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("./backup/".$tmpfile))
		{
		$msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='restore.php';"; 
		echo "</script>"; 
		}
	else
		{
		$msgs[]="此分卷备份全部导入成功";
		show_msg($msgs);
		}
	}
/**************服务器恢复结束*/}/********************************************/
/*****************本地恢复*/if($_POST['restorefrom']=="localpc"){/**************/
	switch ($_FILES['myfile']['error'])
	{
	case 1:
	case 2:
	$msgs[]="您上传的文件大于服务器限定值，上传未成功";
	break;
	case 3:
	$msgs[]="未能从本地完整上传备份文件";
	break;
	case 4:
	$msgs[]="从本地上传备份文件失败";
	break;
    case 0:
	break;
	}
	if($msgs){show_msg($msgs);pageend();}
$fname=date("Ymd",time()).".sql";
if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
    copy($_FILES['myfile']['tmp_name'], "./backup/".$fname);}

if (file_exists("./backup/".$fname)) 
	{
	$msgs[]="本地备份文件上传成功";
	if(import("./backup/".$fname)) {$msgs[]="本地备份文件成功导入数据库"; unlink("./backup/".$fname);}
	else $msgs[]="本地备份文件导入数据库失败";
	}
else ($msgs[]="从本地上传备份文件失败");
show_msg($msgs);
/****本地恢复结束*****/}/****************************************************/
/****************************主程序结束*/}/**********************************/
/*************************剩余分卷备份恢复**********************************/
if(!$_POST['act']&&$_SESSION['data_file'])
{
	$filename="./backup/".$_SESSION['data_file'];
	if(import($filename)) $msgs[]="备份文件".$_SESSION['data_file']."成功导入数据库";
	else {$msgs[]="备份文件".$_SESSION['data_file']."导入失败";show_msg($msgs);pageend();}
	$voltmp=explode("_v",$_SESSION['data_file']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("./backup/".$tmpfile))
		{
		$msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='restore.php';"; 
		echo "</script>"; 
		}
	else
		{
		$msgs[]="此分卷备份全部导入成功";
		unset($_SESSION['data_file']);
		show_msg($msgs);
		}
}
/**********************剩余分卷备份恢复结束*******************************/
function import($fname)
{global $d;
$sqls=file($fname);
foreach($sqls as $sql)
	{
	str_replace("\r","",$sql);
	str_replace("\n","",$sql);
	if(!$d->query(trim($sql))) return false;
	}
return true;
}
function show_msg($msgs)
{
$title="提示：";
echo "<table width='100%' border='1'  cellpadding='0' cellspacing='1'>";
echo "<tr><td>".$title."</td></tr>";
echo "<tr><td><br><ul>";
while (list($k,$v)=each($msgs))
	{
	echo "<li>".$v."</li>";
	}
echo "</ul></td></tr></table>";
}

function pageend()
{
exit();
}
?>
 

