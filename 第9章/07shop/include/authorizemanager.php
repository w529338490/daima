<? defined("_ACCESS_") or die('Restricted access'); ?>
<? //您好
	session_start();
  if($menuid!="")
  	$_SESSION['SessionMenuid']=$menuid;
  if(!isAccessPage($_SESSION['SessionMenuid']))
  {
	 echo "<script language='javascript'>top.location='".$SETUPFOLDER."/admin/admin.php?message=2';</script>";
	 return;
   }
   if(!isSite($Site_No))
   {
   		 echo "<script language='javascript'>top.location='".$SETUPFOLDER."/admin/admin.php?message=2';</script>";
	 	return;
   }
  
?>
