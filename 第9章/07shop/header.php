<?
define(DIR_BASE,dirname(__FILE__));
?>
<? include DIR_BASE."/db/Connect.php"?>
<? include DIR_BASE."/include/template.inc" ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 
//   您好
	//get default template
	$sql="select  * from  ".$TableTemplates." where is_default=1" ;
	$rowTemplate=$db->getRow($sql);
	$template_path=$BASEPATH."/Templates/".$rowTemplate['template_name'];
	
	//get include content page
	$include_content_path=$BASEPATH."/modules/home/home.php";
	$page_level=0;
	if(!empty($menuid))
	{
		$sql="select  a.*,b.module_name,b.dispach_page,b.access_level as module_access_level from  ".$TableInfo_category." as a,".$TableModules." as b where a.module_id=b.id and a.id=".$menuid;
		$rowCategory=$db->getRow($sql);
		$module_name=$rowCategory['module_name'];
		$page_level=$_GET['level'];
		$page_extension=$page_level;
		if(empty($page_level)||$page_level<3)
			$page_extension="";
		$include_content_path=$BASEPATH."/modules/".$module_name."/".$module_name.$page_extension.".php";
		$dispatch_page=$T_Dispach_Page[$rowCategory['dispach_page']];
	}
	
	// access level
	if(!isLogin())
	{
		if($rowCategory['access_level']==2||$rowCategory['module_access_level']==2)
		{
			header("location: ".$SETUPFOLDER."/".$dispatch_page."?menuid=12&flag=nologin");
		}
	}
?>