<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
 <?
 $status=$_POST['status'];
	if($status=="checkout")
	{
		$indate=date('Y-m-j H:i:s');
		$country=$_POST['country'];//Country
		$zip_code=$_POST['zip_code'];//Zip Code
		$sex=$_POST['sex'];//Gender
		$my_location=$_POST['my_location'];//My Location
		$true_name=$_POST['true_name'];//My Location
		$telepnone=$_POST['telepnone'];//My Location
		$moblie=$_POST['moblie'];//My Location
		
		//update user 
		$sql="update  ".$TableAdmin." set 		true_name='".$true_name."',	telepnone='".$telepnone."',	moblie='".$moblie."',EmailName='".$EmailName."',	country='".$country."',zip_code='".$zip_code."',	sex=".$sex.",	my_location='".$my_location."'  where   username='".$_SESSION['SessionUser']['username']."'";
		$query=$db->query($sql);

		//insert order
		$memo=$_POST['memo'];//备注
		$order_time=$indate;//预订日期
		$order_people=$_SESSION['SessionUser']['username'];//预订人
		$order_status="1";//状态
		 $sql="insert into  ".$TableEb_product_order."(memo,order_time,order_people,order_status)values('".$memo."','".$order_time."','".$order_people."',".$order_status.")";
		$query=$db->query($sql);
		//insert order product
		$sql="select max(id) as id from  ".$TableEb_product_order."  ";
		$row=$db->getRow($sql);
		
		$order_id=$row['id'];//订单号
		for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
		{
			$product_id=getMyCookie("cart".$i."_productid");//产品编号
			$product_name=getMyCookie("cart".$i."_product_name");//产品名称
			$price=getMyCookie("cart".$i."_price");//价格
			$quantity=getMyCookie("cart".$i."_quantity");//数量
			 $sql="insert into  ".$TableEb_order_product."(order_id,product_id,product_name,price,quantity)values(".$order_id.",".$product_id.",'".$product_name."',".$price.",".$quantity.")";
			$query=$db->query($sql);
		}
		//清空购物车
		if($query)
		{
			
			for($i=1;$i<=(int)getMyCookie('cookie_num');$i++)
			{
					setMyCookie("cart".$i."_productid",null,time()-300);
					setMyCookie("cart".$i."_product_name",null,time()-300);
					setMyCookie("cart".$i."_quantity",null,time()-300);
					setMyCookie("cart".$i."_price",null,time()-300);
			}
			setMyCookie('cookie_num',0,time()-300);
			header("location: ".$SETUPFOLDER."/product.php?menuid=204&level=2&order_id=".$order_id);
		}
	}
?>
<link href="<?=$SETUPFOLDER?>/modules/product_checkout/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td  class="product_checkout_container">
     <?

		$sql="select * from  ".$TableAdmin."  where username='".$_SESSION['SessionUser']['username']."'";
		$row=$db->getRow($sql);
	  ?>
    	  <script language="javascript">
								
			function checkout()
			{
				var form=document.getElementById("form1");
				
				
				if(!isEmail(form.EmailName.value))
				{
					alert("请输入您的有效邮箱地址 !");
					form.EmailName.focus();
					return;
				}
			
				if(form.country.value=="")
				{
					alert("请选择国家!");
					form.country.focus();
					return;
				}
				if(form.true_name.value=="")
				{
					alert("请输入您的名称!");
					form.true_name.focus();
					return;
				}
				if(form.telepnone.value=="")
				{
					alert("请输入您的电话!");
					form.telepnone.focus();
					return;
				}
				if(form.moblie.value=="")
				{
					alert("请输入您的手机!");
					form.moblie.focus();
					return;
				}
				if(form.my_location.value=="")
				{
					alert("请输入您的邮寄地址!");
					form.my_location.focus();
					return;
				}
				 form.status.value="checkout";
				 form.submit();
			}
			
		</script>
    	   <table   width="100%" border='0'  cellpadding='0'  cellspacing='0'>
            
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">用户名<span class="star">*</span>:</td>
               <td  class="product_checkout_td_box"><?=$row['username']?></td>
             </tr>

             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">邮箱地址<span class="star">*</span>:</td>
               <td  class="product_checkout_td_box"><input class="product_checkout_box" name="EmailName" type="text" id="EmailName"  value="<?=$row['EmailName']?>" /></td>
             </tr>
             <?
								 $date_of_birthArray=explode('-',$row['date_of_birth']);
								?>
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">国家<span class="star">*</span>:</td>
               <td  class="product_checkout_td_box"><select name="country" id="country">
                   <option value="" >--</option>
                   <script language="JavaScript" type="text/javascript">
										for(i=0;i<countryArray.length;i++)
										{
											if('<?=$row['country']?>'==countryArray[i]) 
											    countrySelect="selected";
											else
												countrySelect="";
											document.write("<option "+countrySelect+" value='"+countryArray[i]+"'>"+countryArray[i]+"</option>");
										}
									  </script>
               </select></td>
             </tr>
              <tr  class='product_checkout_tr' >
                    <td  class="product_checkout_td_title">姓名:</td>
                    <td   class="product_checkout_td_box"><input name="true_name" type="text" id="true_name" value="<?=$row['true_name']?>" ></td>
                </tr>
                 <tr  class='product_checkout_tr' >
                    <td  class="product_checkout_td_title">电话:</td>
                    <td   class="product_checkout_td_box"><input name="telepnone" type="text" id="telepnone" value="<?=$row['telepnone']?>" ></td>
                </tr>
                 <tr  class='product_checkout_tr' >
                    <td class="product_checkout_td_title" >手机:</td>
                    <td   class="product_checkout_td_box"><input name="moblie" type="text" id="moblie" value="<?=$row['moblie']?>" ></td>
                </tr>
								
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">邮政编码:</td>
               <td  class="product_checkout_td_box"><input class="product_checkout_box"  name="zip_code" type="text" id="zip_code"  value="<?=$row['zip_code']?>" /></td>
             </tr>
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">性别:</td>
               <td  class="product_checkout_td_box"><?
										for($i=1;$i<=count($T_Gender);$i++)
										{
											if((int)$row['sex']==$i)
												echo "<input name='sex' type='radio' checked  value='".$i."'>".$T_Gender[$i];
											else
												echo "<input name='sex' type='radio'   value='".$i."'>".$T_Gender[$i];
										}
									?>               </td>
             </tr>
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">地址:</td>
               <td class="product_checkout_td_box" ><input class="product_checkout_box"  name="my_location" type="text" id="my_location"  value="<?=$row['my_location']?>" size="30" /></td>
             </tr>
             <tr  class='product_checkout_tr' >
               <td  class="product_checkout_td_title">备注:</td>
               <td class="product_checkout_td_box" ><textarea name="memo" cols="40" rows="4" id="memo" style="height:124px;"></textarea></td>
             </tr>
           
             <tr  class='product_checkout_tr' >
               <td colspan="2" align="center"><input type="button"  class='button' name="Button" value="提交" onclick="checkout()" /></td>
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
