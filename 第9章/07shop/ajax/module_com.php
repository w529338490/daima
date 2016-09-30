<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
 <? include "../include/FileDir.php"?>
  <? include "../include/function.php"?>
<?

	$module_name=$_POST['module_name'];
	$dir_array=searchDir("../modules/".$module_name."/com");
	$dir_str="";
	if($dir_array)
		$dir_str=implode(',',$dir_array);
	echo $dir_str;
 ?>