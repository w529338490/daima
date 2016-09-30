<? include dirname(__FILE__)."/header.php"?>
<?  
//   您好
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
	//create template object
	$t = new Template($template_path); 
	if(empty($page_level)||$page_level<2)
		$t->set_file("index","index.html");
	if($page_level>=2)
		$t->set_file("index","sub.html");
		
	//template dir
	$t->set_var("template_dir",$SETUPFOLDER);
	
	//include header file
	ob_start();
	include $BASEPATH."/modules/header/header.php";
	$include_header=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_header",$include_header);
	
	//include top file
	ob_start();
	include $BASEPATH."/modules/top/top.php";
	$include_top=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_top",$include_top); 
	
	//include logo file
	ob_start();
	include $BASEPATH."/modules/logo/logo.php";
	$include_logo=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_logo",$include_logo); 
	
	//include sub_navigator file
	if(!empty($page_level)&&$page_level>1)//check if sub page
	{
		ob_start();
		include $BASEPATH."/modules/sub_navigator/sub_navigator.php";
		$include_nav=ob_get_contents();
		ob_end_clean();
		$t->set_var("template_nav",$include_nav); 
	}
	
	$include_left="";
	//include left file
	if(!empty($page_level)&&$page_level>1)//check if sub page
	{
		ob_start();
		include $BASEPATH."/modules/left_menu_navigator/left_menu_navigator.php";
		$include_left=ob_get_contents()."<br>";
		ob_end_clean();
	}

	
	//mainpage left mod
	if(empty($page_level)||$page_level<2)
	{
		$sql="select  a.id,a.picture,a.name as infos_category_name,a.module_com,b.page_level,b.dispach_page,b.module_name from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id and  FIND_IN_SET('2',a.module_pos)>0   and a.is_show=1 order by a.sortid " ;
		$result=$db->getAll($sql);
		for($i=0;$i<count($result);$i++)
		{
			ob_start();
			$dispatch_page=$T_Dispach_Page[$result[$i]['dispach_page']];
			$category_id=$result[$i]['id'];
			$infos_category_name=$result[$i]['infos_category_name'];
			$category_picture=$result[$i]['picture'];
			$category_level=$result[$i]['page_level'];
			include $BASEPATH."/modules/".$result[$i]['module_name']."/com/".trim($result[$i]['module_com']);
			$include_left.=ob_get_contents()."<br>";
			ob_end_clean();
		}
	}
	
	//
	//subpage left mod
	if($page_level>=2)
	{
		$sql="select  a.id,a.picture,a.name as infos_category_name,a.module_com,b.page_level,b.dispach_page,b.module_name from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id and  FIND_IN_SET('5',a.module_pos)>0   and a.is_show=1 order by a.sortid" ;
		$result=$db->getAll($sql);
		for($i=0;$i<count($result);$i++)
		{
			ob_start();
			$dispatch_page=$T_Dispach_Page[$result[$i]['dispach_page']];
			$category_id=$result[$i]['id'];
			$infos_category_name=$result[$i]['infos_category_name'];
			$category_picture=$result[$i]['picture'];
			$category_level=$result[$i]['page_level'];
			include $BASEPATH."/modules/".$result[$i]['module_name']."/com/".trim($result[$i]['module_com']);
			$include_left.=ob_get_contents()."<br>";
			ob_end_clean();
		}
	}
	
	$t->set_var("template_left",$include_left);
	//

	
	//include content file
	ob_start();
	include $include_content_path;
	$include_content=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_content",$include_content);
	
	//include right file
	//mainpage right mod
	$include_right="";
	if(empty($page_level)||$page_level<2)//check if sub page
	{
		$sql="select  a.id,a.picture,a.name as infos_category_name,a.module_com,b.page_level,b.dispach_page,b.module_name from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id and  FIND_IN_SET('4',a.module_pos)>0   and a.is_show=1 order by a.sortid" ;
		$result=$db->getAll($sql);
		for($i=0;$i<count($result);$i++)
		{
			ob_start();
			$dispatch_page=$T_Dispach_Page[$result[$i]['dispach_page']];
			$category_id=$result[$i]['id'];
			$infos_category_name=$result[$i]['infos_category_name'];
			$category_picture=$result[$i]['picture'];
			$category_level=$result[$i]['page_level'];
			include $BASEPATH."/modules/".$result[$i]['module_name']."/com/".trim($result[$i]['module_com']);
			$include_right.=ob_get_contents()."<br>";
			ob_end_clean();
		}
	}
	$t->set_var("template_right",$include_right); 
	//
	//include login nav file
	ob_start();
	include $BASEPATH."/modules/logined_navigator/logined_navigator.php";
	$include_login_nav=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_login_nav",$include_login_nav); 
	
	//include bottom file
	ob_start();
	include $BASEPATH."/modules/footer/footer.php";
	$include_footer=ob_get_contents();
	ob_end_clean();
	$t->set_var("template_footer",$include_footer); 
	
	$t->parse("Output","index"); 
	$t->p("Output");

?>
<? $db->close_db();?>