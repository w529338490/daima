<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/user_product_order/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td  class="user_product_order_container">
    <div class="message"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr class="product_cart_tr1">
                <td height="25" align="center">产品名称</td>
                <td align="center" >数量</td>
                <td align="center" >价格</td>
				<td align="center">总价</td>
              </tr>
              <?
			  $sql="select * from ".$TableEb_product_order." where id=".$order_id;
			  $rowOrder=$db->getRow($sql);
			  $username=$rowOrder['order_people'];
			  
			  $sql="select * from ".$TableEb_order_product."  where order_id=".$order_id;
			  $resultOrderProduct=$db->getAll($sql);
			  $total=0;
			  $totalprice=0;
			  $catnum=0;
			  $total_num=count($resultOrderProduct);
				for($k=0;$k<$total_num;$k++)
				{ 
				$total+=(int)$resultOrderProduct[$k]['quantity'];
				$rowTotalPrice=(int)$resultOrderProduct[$k]['quantity']*$resultOrderProduct[$k]['price'];
				$totalprice+=$rowTotalPrice;
			  ?>
              <tr class="product_cart_tr2">
                <td height="25" align="center"><?=$resultOrderProduct[$k]['product_name']?>&nbsp;</td>
                <td align="center" ><?=$resultOrderProduct[$k]['quantity']?></td>
                <td align="center"><?=$resultOrderProduct[$k]['price']?> <?=$T_Price_type[$config_row['price_type']]?></td>
				<td align="center"><?=$rowTotalPrice?> <?=$T_Price_type[$config_row['price_type']]?></td>
              </tr>
			  <?
				}
			  ?>
      <tr>
		<td height="25" colspan="6" align="right" class="style14" style="font-weight:bold; padding-right:26px; padding-top:5px;"> 产品数量: 
	    <?=$total?> , 总价: <?=$totalprice?> <?=$T_Price_type[$config_row['price_type']]?> </td>
	  </tr>
	</table>
     <?

		$sql="select * from  ".$TableAdmin."  where username='".$username."'";
		
		$row=$db->getRow($sql);
	  ?>

    	   <table  class="user_product_order_table"  width="100%" border='0'  cellpadding='0'  cellspacing='0'>
            

             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">用户名<span class="star">*</span>:</td>
               <td  class="user_product_order_td_box"><?=$row['username']?></td>
             </tr>

             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">邮箱地址<span class="star">*</span>:</td>
               <td  class="user_product_order_td_box"><?=$row['EmailName']?></td>
             </tr>
           
             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">国家<span class="star">*</span>:</td>
               <td  class="user_product_order_td_box"><?=$row['contry']?></td>
             </tr>
              <tr  class='user_product_order_tr' >
                    <td  class="user_product_order_td_title">姓名:</td>
                    <td   class="user_product_order_td_box"><?=$row['true_name']?></td>
                </tr>
                 <tr  class='user_product_order_tr' >
                    <td  class="user_product_order_td_title">电话:</td>
                    <td   class="user_product_order_td_box"><?=$row['telepnone']?></td>
                </tr>
                 <tr  class='user_product_order_tr' >
                    <td class="user_product_order_td_title" >手机:</td>
                   <td   class="user_product_order_td_box"><?=$row['moblie']?></td>
                </tr>
								
             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">邮政编码:</td>
               <td  class="user_product_order_td_box"><?=$row['zip_code']?></td>
             </tr>
             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">性别:</td>
               <td  class="user_product_order_td_box"><?=$T_Gender[$row['sex']]?> </td>
             </tr>
             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">地址:</td>
               <td class="user_product_order_td_box" ><?=$row['my_location']?></td>
             </tr>
             <tr  class='user_product_order_tr' >
               <td  class="user_product_order_td_title">备注:</td>
               <td class="user_product_order_td_box" ><?=$row['memo']?></td>
             </tr>
           
             <tr  class='user_product_order_tr' >
               <td colspan="2" align="center">&nbsp;</td>
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
<input type="hidden" name="status" value="">
