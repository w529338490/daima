<? 
	session_start();
  if(!isAdmin())
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

