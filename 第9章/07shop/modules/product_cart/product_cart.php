<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/product_cart/css/style.css" rel="stylesheet" type="text/css">
<div class="product_cart_container">
<?
 if(!empty($product_id))
 {
	$sql="select *  from  ".$TableEb_product."  where id=".$product_id;
	$row=$db->getRow($sql);
	
	$b=false;
	for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
	{
		if($product_id==getMyCookie("cart".$i."_productid"))
		{

			setMyCookie("cart".$i."_quantity",(int)getMyCookie("cart".$i."_quantity")+1);
			$b=true;
			break;
		}
	}
	if($b==false)
	{
		$cookie_num=getMyCookie('cookie_num');
		if(empty($cookie_num))
		{
			setMyCookie('cookie_num',1);
			setMyCookie("cart1_productid",$row['id']);
			setMyCookie("cart1_product_name",$row['product_name']);
			setMyCookie("cart1_quantity",1);
			setMyCookie("cart1_price",$row['price']);
		}
		else
		{
			$cookie_num=(int)getMyCookie('cookie_num')+1;
			setMyCookie('cookie_num',$cookie_num);
			setMyCookie("cart".$cookie_num."_productid",$row['id']);
			setMyCookie("cart".$cookie_num."_product_name",$row['product_name']);
			setMyCookie("cart".$cookie_num."_quantity",1);
			setMyCookie("cart".$cookie_num."_price",$row['price']);
		}
		
   }
	header("location: ".$SETUPFOLDER."/product.php?menuid=202&level=2 ");
}

if($status=="editcart")
{
	for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
	{
			setMyCookie("cart".$i."_quantity",(int)$_POST["quantity".$i]);
	}
	header("location: ".$SETUPFOLDER."/product.php?menuid=202&level=2  ");
}

if($status=="clearcart")
{
	setMyCookie('cookie_num',time()-300);
	for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
	{
			setMyCookie("cart".$i."_productid",time()-300);
			setMyCookie("cart".$i."_product_name",time()-300);
			setMyCookie("cart".$i."_quantity",time()-300);
			setMyCookie("cart".$i."_price",time()-300);
	}
	header("location: ".$SETUPFOLDER."/product.php?menuid=202&level=2  ");
}

if($status=="removecart")
{
	//将剩下的产品导入到新的cookie里面,删除选择的cookie
	$j=1;
	for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
	{
		if((int)$remove_id==$i)
		{
			setMyCookie("cart".$i."_productid",time()-300);
			setMyCookie("cart".$i."_product_name",time()-300);
			setMyCookie("cart".$i."_quantity",time()-300);
			setMyCookie("cart".$i."_price",time()-300);
		}
		else
		{
			setMyCookie("cart".$j."_productid",getMyCookie("cart".$i."_productid"));
			setMyCookie("cart".$j."_product_name",getMyCookie("cart".$i."_product_name"));
			setMyCookie("cart".$j."_quantity",getMyCookie("cart".$i."_quantity"));
			setMyCookie("cart".$j."_price",getMyCookie("cart".$i."_price"));
			$j++;
		}
	}
	$cookie_num=(int)getMyCookie('cookie_num')-1;
	setMyCookie('cookie_num',$cookie_num);
	header("location: ".$SETUPFOLDER."/product.php?menuid=202&level=2  ");
}
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr class="product_cart_tr1">
                <td height="25" align="center">产品名称</td>
                <td align="center" >数量</td>
                <td align="center" >价格</td>
				<td align="center">总价格</td>
				<td align="center">&nbsp;</td>
              </tr>
              <?
			  $total=0;
			  $totalprice=0;
			  $catnum=0;
			  $cookie_num=getMyCookie('cookie_num');
			  if(!empty($cookie_num))
			  	$catcookie_num=getMyCookie('cookie_num');
				for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
				{
				$total+=(int)getMyCookie("cart".$i."_quantity");
				$rowTotalPrice=(int)getMyCookie("cart".$i."_quantity")*getMyCookie("cart".$i."_price");
				$totalprice+=$rowTotalPrice;
			  ?>
              <tr class="product_cart_tr2">
                <td height="25" align="center"><?=getMyCookie("cart".$i."_product_name")?>&nbsp;</td>
                <td align="center" ><input name="quantity<?=$i?>" type="text" id="quantity" style="width:40px; height:18px; border:1px solid #D4D0C8;" value="<?=getMyCookie("cart".$i."_quantity")?>"></td>
                <td align="center"><?=getMyCookie("cart".$i."_price")?> <?=$T_Price_type[$config_row['price_type']]?></td>
				<td align="center"><?=$rowTotalPrice?> <?=$T_Price_type[$config_row['price_type']]?></td>
				<td align="center" ><a href="javascript:removecart(<?=$i?>)">删除</a></td>
              </tr>
			  <?
				}
			  ?>
      <tr>
		<td height="25" colspan="6" align="right" class="style14" style="font-weight:bold; padding-right:26px; padding-top:5px;">产品数量: 
	    <?=$total?> , 总价: <?=$totalprice?> <?=$T_Price_type[$config_row['price_type']]?> </td>
	  </tr>
	</table>
    <div style="height:30px; text-align:center;">
    	 <input type="button" value="修改" class="button" onclick="editcart()"  />
         <input type="button" value="结算" onclick="checkout()" class="button"  />
    </div>
    <input  type="hidden"  name="remove_id" />
    <input type="hidden" name="status" value="">
</div>
<script language="javascript">
 function editcart()
 {
    form=document.getElementById('form1');
	form.status.value="editcart";
	form.submit();
 }
  function checkout()
 {
    location="<?=$SETUPFOLDER?>/product.php?menuid=203&level=2";
 }
  function clearcart()
 {
    form=document.getElementById('form1');
	form.status.value="clearcart";
	form.submit();
 }
 function removecart(i)
 {
    form=document.getElementById('form1');
	if(confirm("Do you want to deleter this product ?")==false)
			return;
	form.status.value="removecart";
	form.remove_id.value=i;
	form.submit();
 }
</script>