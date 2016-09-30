<?php
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
/* ======================================================================= */
//                             database define
/* ======================================================================= */
		//db
		$mysqlhost="127.0.0.1"; //host name
		$mysqluser="root";              //login name
		$mysqlpwd="1234";              //password
		$mysqldb="07shop";      //name of database
	
	
/* ======================================================================= */
//                             table define
/* ======================================================================= */
		$TablePre = 'hono_';
	//Authorization	 table
		$TableMenu=$TablePre."cart_menu";
		$TableAdmin=$TablePre."cart_users";
		$TableRole=$TablePre."cart_role";
		$TableMenu_role=$TablePre."cart_menu_role";
		$TableUser=$TablePre."cart_users";
		$TableSite_category=$TablePre."cart_site";
	//system config
		$TableConfig =$TablePre."cart_config";
		$TableTemplates=$TablePre."cart_templates";
		$TableModules=$TablePre."cart_modules";
		$TableMain_menu=$TablePre."cart_mainmenu";
	//article
		$TableInfo_category=$TablePre."cart_menuitem";
		$TableInfos=$TablePre."cart_infos";
	//shopping cart
		$TableEb_order_product = $TablePre."cart_order_product";
		$TableEb_product = $TablePre."cart_product";
		$TableEb_product_category = $TablePre."cart_category";
		$TableEb_product_order = $TablePre."cart_order";
		$TableEb_remark = $TablePre."cart_remark";
		$TableEb_product_favorites= $TablePre."cart_favorites";
	
		
/* ---------------------------------------------------------------------- */

		define("_ACCESS_","ok");

/* ---------------------------------------------------------------------- */
		function getVirtualDirectory()
		{
			$returnvalue="";
			$current_dir=str_replace('\\','/',dirname(__FILE__));
			$DRoot=$_SERVER['DOCUMENT_ROOT'];
			if($current_dir==$DRoot)
				return $returnvalue;
			$current_dir_array=explode($DRoot,$current_dir);
			$returnvalue.=$current_dir_array[1];
			return $returnvalue;
			
		}
		
		$TitleName = "Website Administration - ShoppingCart";  //<title></title>。
		$pagenum = 15;	  //page 15
		$WebHost=$_SERVER['HTTP_HOST'];	
		$SETUPFOLDER=getVirtualDirectory();
		$BASEPATH = dirname(__FILE__); 
		$UploadPath = $BASEPATH."/"; //file upload path
		$HostUrl =  "http://".$WebHost."/";
		$Site_No= "1";	  //website number
		$dispatch_page= "index.php";
		$T_Page_Level =array(1=>"首页","二级页面","详细页面");
		$T_Module_Position =array(1=>"无","首页左边","首页中间","首页右边","子页面","用户页面");
		$T_Bgcolor=array(1=>"#FBFDDB","#E3E3E3");
		$T_Editor_type=array(1=>"Text","oFCKeditor","eWebeditor");
		$T_ToolbarSet="Basic";
		$T_FkDefaultLanguage="zh-cn";	
		$T_Fk_sBasePath=$SETUPFOLDER."/admin/fckeditor/";
		//echo $RealPath;
		

/* ======================================================================= */
//                              parameter
/* ======================================================================= */	
		
		
		
		//信息
		$T_Is_YesNO= array(1=>"是","否");
		$T_Gender =array(1=>"男","女");
		$T_Avatar_Type =array(1=>"上传","嵌入","默认");
		$T_Link_method =array(1=>"_top","_parent","_blank");
		$T_Upload_Type =array(1=>"图片","文件","媒体");
		$T_Dispach =array(1=>"Index","Profile");
		$T_Dispach_Page =array(1=>"index.php","profile.php");
		$T_Access_Level =array(1=>"公开","注册","特权");
		$T_Url_type =array(1=>"从模块选择","输入");
		//产品
		$T_Price_type= array(1=>"$","￥");
		$T_Order_status= array(1=>"处理中","取消","完成");
/* ======================================================================= */
	
//check install exsit
$Instail_dir=$BASEPATH."/install";
if(file_exists($Instail_dir))
{
	header("location: ".$SETUPFOLDER."/install");
	exit();
}

/* ======================================================================= */
		include $BASEPATH."/include/function.php";
		
		ini_set("session.use_cookies","1");
		//session_start();
		import_request_variables("pg");
		error_reporting(7);
		error_reporting(E_ALL^(E_NOTICE|E_WARNING)); 
		ob_start();	
		
		//prevent injection 
		if ($_SERVER['QUERY_STRING'] != '' && !preg_match('/^(|[a-z&=0-9_]+)$/is', chop($_SERVER['QUERY_STRING']))) {
			exit("Restricted access!");
		}
?>