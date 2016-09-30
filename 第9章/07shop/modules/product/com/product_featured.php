<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
         <link href="<?=$SETUPFOLDER?>/modules/product/css/style.css" rel="stylesheet" type="text/css">
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
		<?
			
			$sql="select  a.price ,a.market_price ,a.id ,a.eb_product_category_id ,a.product_name ,a.picture   from    ".$TableEb_product." as a where a.is_verify=1 and a.featured=1 order by a.publish_time desc limit 12";
           
			$result_product_featured=$db->getAll($sql);
			for($k=0;$k<count($result_product_featured);$k++)
			{
				$link_url=$SETUPFOLDER."/product.php?menuid=".$category_id."&pcatid=".$result_product_featured[$k]['eb_product_category_id']."&id=".$result_product_featured[$k]['id']."&level=3";

		?>
                
                  <td class="product_listings">
                      <div class="product_listings_picture">
                      <a href="<?=$link_url?>">
                      <img  class="product_listings_img"      src="<?=$SETUPFOLDER?>/upload/eb_product/s<?=$result_product_featured[$k]['picture']?>" border="0" >
                      
                      </a>
                      </div>
                      <div class="product_listings_text">
                      <a href="<?=$link_url?>">
                        <?=$result_product_featured[$k]['product_name']?>
                      </a>
                      </div>
                      <div class="product_listings_price">
                        <del><?=$result_product_featured[$k]['market_price']?> <?=$T_Price_type[$config_row['price_type']]?></del>
                      </div>
                      <div class="product_listings_price">
                        <?=$result_product_featured[$k]['price']?> <?=$T_Price_type[$config_row['price_type']]?>
                      </div>
                  </td>
              
           
         <?
		 if(($k+1)%3==0) echo "</tr><tr>";
		}
		?>
          </tr>
	</table>
  </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>