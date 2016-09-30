<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
         <link href="<?=$SETUPFOLDER?>/modules/product_cart/css/style.css" rel="stylesheet" type="text/css">
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
        	<div class="product_cart_listings_category">
                <a  href="<?=$link_url?>"><?=$infos_category_name?></a>
            </div>
      <div class="product_cart_listings_line"></div>
      <div  class="product_cart_listings_text" >
      购物车产品数<span class="style12b"> 
			<?
            $cookie_num=getMyCookie('cookie_num');
            if(!empty($cookie_num))
                 echo $cookie_num;
            else
                echo "0";
            ?> 
		</span><br />
        总价： <span class="style12b">
        <?
        $total=0;
        $totalprice=0;
        for($k=1;$k<=(int)getMyCookie('cookie_num');$k++)
        {
            $total+=(int)getMyCookie("cart".$k."_quantity");
            $rowTotalPrice=(int)getMyCookie("cart".$k."_quantity")*getMyCookie("cart".$k."_price");
            $totalprice+=$rowTotalPrice;
            
        }
        echo $totalprice;
        ?>
        </span> <?=$T_Price_type[$config_row['price_type']]?>
        <br />
        <a href="<?=$SETUPFOLDER?>/index.php?menuid=202&level=2"  class="one">查看购物车</a>
        </div>
  </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>