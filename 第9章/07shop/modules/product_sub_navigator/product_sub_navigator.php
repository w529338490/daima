<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/product_sub_navigator/css/style.css" rel="stylesheet" type="text/css">
<div class="product_sub_navigator_container">
<a href='<?=$config_row['host_url']?>'><span class="product_sub_navigator_font">首页</span></a>
	<? // 您好
		$dispatch_page="product.php";
		$nav_flag=false;
        if(!empty($pcatid))
        {
            $sql="select  nodepath from  ".$TableEb_product_category." as a  where a.id=".$pcatid ;
            $row_nav=$db->getRow($sql);
            $nav_nodepath=$row_nav['nodepath'];
			$nav_flag=true;
        }
		if($nav_flag==true)
		{
			 $sql="select  a.*,2 as page_level from  ".$TableEb_product_category." as a where  a.id in(".$nav_nodepath.") and  a.is_show=1 order by a.pid" ;
			 $result_nag=$db->getAll($sql);
			 $nav_count=count($result_nag);
			 for($i=0;$i<$nav_count;$i++)
			{
				$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$result_nag[$i]['id']."&level=".$result_nag[$i]['page_level'];
				echo " -<a target='".$T_Link_method[$result_nag[$i]['link_method']]."' href=".$link_url."><span  class='product_sub_navigator_font'>".$result_nag[$i]['name']."</span></a> ";
			}
		}
    ?>
</div>