<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		. 您好
 */
 ?>
 <?
	//cancel
	$status=$_POST['status'];
	if($status=="remove")
	{
	    $sql="update  ".$TableEb_product_order." set order_status=2   where id=".$id;
	    $query=$db->query($sql);
	}
	
?>
<link href="<?=$SETUPFOLDER?>/modules/user_product_order/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td class="user_product_order_container" >
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr class="product_cart_tr1">
                    <td height="25" align="center">订单日期</td>
                    <td align="center" >订购用户</td>
                    <td align="center">处理日期</td>
                    <td align="center" >处理用户</td>
                    <td align="center">状态</td>
					<td align="center" >&nbsp;</td>
                  </tr>
                  <?
			  
			  $b=false;
             $filter="";
             
             $fvalue=$order_id;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" id= ".$fvalue." ";
                 $b=true;
             }
             $order_people=$_SESSION['SessionUser']['username'];
             $fvalue=$order_people;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" order_people ='".$fvalue."' ";
                 $b=true;
             }
             
			 
			$sql="select  * from  ".$TableEb_product_order." ";
			if($b)
			{
				$sql.=" where ".$filter."  order by order_time desc  ";
			}
			else
			{
				$sql.="   order by order_time desc  ";
			}
			  $result=$db->getAll($sql);
				for($i=0;$i<count($result);$i++)
				{
				
			  ?>
                  <tr  class="product_cart_tr2">
                    <td height="25" align="center">&nbsp;<?=FormatDate($result[$i]['order_time'])?>
                      &nbsp;</td>
                    <td align="center" >&nbsp;<?=$result[$i]['order_people']?></td>
                    <td align="center" >&nbsp;<?=FormatDate($result[$i]['deal_time'])?></td>
                    <td align="center" >&nbsp;<?=$result[$i]['deal_people']?></td>
                    <td align="center" >&nbsp;<?=$T_Order_status[$result[$i]['order_status']]?></td>
					<td align="center" width="100" ><? if($result[$i]['order_status']==1){ ?><a   href='javascript:remove(<?=$result[$i]['id']?>)'>删除</a><? }?><a href='<?=$SETUPFOLDER?>/profile.php?menuid=205&level=3&order_id=<?=$result[$i]['id']?>'> 浏览</a></td>
                    
                  </tr>
                  <?
				}
			  ?>
                  <tr>
                    <td height="25" colspan="6" align="right" class="style14" style="font-weight:bold; padding-right:26px; padding-top:5px;">&nbsp;</td>
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
<input type="hidden" name="id"  />
<script  language="javascript">

	function remove(id){
		if(confirm("真的想要删除吗?")==true){
			var form=document.getElementById('form1');
			form.id.value=id;
			form.status.value="remove";
			form.submit();
		}
	}
</script>