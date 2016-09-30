<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/product_category/css/style.css" rel="stylesheet" type="text/css">
<link rel="StyleSheet" href="<?=$SETUPFOLDER?>/modules/product_category/tree/dtree.css" type="text/css">
<script type="text/javascript" src="<?=$SETUPFOLDER?>/modules/product_category/tree/dtree.js"></script>
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td >
 <?
		$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$category_id."&level=".$category_level;
		?>
        	<div class="product_listings_category">
                <a  href="<?=$link_url?>"><?=$infos_category_name?></a>
            </div>
            <div class="product_listings_line"></div>
<?
 $sql="select  a.*,2 as page_level from  ".$TableEb_product_category." as a where   a.is_show=1  order by a.pid, a.sortid" ;
$result_nav=$db->getAll($sql);
$nav_count=count($result_nav);
 $dispatch_page="product.php";
 $menuid="201";
if($nav_count>0)
{
?>
	<div class="dtree">
	<script type='text/javascript'>
	<!--
		var target='center';
	    d = new dTree('d');
	    d.add(0,-1,'','#','','');
		<? 
			 for($k=0;$k<$nav_count;$k++)
			{
				$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$result_nav[$k]['id']."&level=".$result_nav[$k]['page_level'];
				echo "d.add(".$result_nav[$k]['id'].",".$result_nav[$k]['pid'].",'".$result_nav[$k]['name']."','".$link_url."','','".$T_Link_method[$result_nav[$k]['link_method']]."');";
			}
		?>
        document.write(d);
	 //-->
	</script>
</div>
<?
}
?>
    </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>