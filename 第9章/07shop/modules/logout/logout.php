<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
<?
	$_SESSION['SessionUser']=null;
	echo "<script language='javascript'>top.location='".$SETUPFOLDER."/index.php?menuid=12&level=2&flag=logout';</script>";
	return;
?>