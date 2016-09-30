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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?
		$sql="update      ".$TableEb_product." set click_count=click_count+1   where id=".$id;
		$db->query($sql);
		$sql="select  ".$TableEb_product.".* ,".$TableEb_product_category.".name as  product_category_name  from    ".$TableEb_product." ,".$TableEb_product_category."   where ".$TableEb_product.".eb_product_category_id = ".$TableEb_product_category.".id  and  ".$TableEb_product.".id=".$id;
		$row=$db->getRow($sql);
	?>
      <tr>
        <td  class="product_details_img_td" align="center">
		<?
                if(!empty($row['picture']))
                {
                ?>
          <a target="_blank" href="<?=$SETUPFOLDER?>/upload/eb_product/<?=$row['picture']?>" ><img width="<?=$config_row['product_picture_width']?>" height="<?=$config_row['product_picture_height']?>"  src="<?=$SETUPFOLDER?>/upload/eb_product/<?=$row['picture']?>" border="0" /></a>
          <?
                }
                ?></td>
        <td valign="top" class="product_details_text">
        <span class="product_details_title">产品分类</span> : <?=$row['product_category_name']?> 
        <br />       
        <span class="product_details_title">产品名称</span> : <?=$row['product_name']?> 
        <br />  
        <span class="product_details_title">市场价格</span> : <del><?=$row['market_price']?> <?=$T_Price_type[$config_row['price_type']]?></del>
        <br />
        <span class="product_details_title">当前价格</span> : <?=$row['price']?> <?=$T_Price_type[$config_row['price_type']]?>
        <br />
        <div class="product_addcartbutton_div"><input type="button" class="button" onclick="addCart(<?=$row['id']?>)" value="添加到购物车" />
        </div>       
        </td>
  </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
        <?=$row['content']?>        </td>
      </tr>
      <tr>
        <td align="center"></td>
        <td align="center">          </td>
      </tr>
    </table>
<script language="javascript">
	function addCart(id)
	{
		location="<?=$SETUPFOLDER?>/product.php?menuid=202&level=2&product_id="+id;
	}
</script>
