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
 //mainpage right mod
	$home_content="";
	$sql="select  a.id,a.picture,a.name as infos_category_name, a.module_com,b.page_level,b.dispach_page,b.module_name from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id and  FIND_IN_SET('3',a.module_pos)>0   and a.is_show=1 order by a.sortid" ;
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
		$home_content.=ob_get_contents()."<br>";
		ob_end_clean();
	}
	echo $home_content;
?>