<? require "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?

	$status=$_POST['status'];
	$id=$_POST['id'];
	if($status=="edit")
	{
			$indate=date('Y-n-j H:i:s');
		$id=$_POST['id'];//
		$order_id=$_POST['order_id'];//订单号
		$product_id=$_POST['product_id'];//产品编号
		$price=$_POST['price'];//价格
		$quantity=$_POST['quantity'];//数量
				$sql="update  ".$TableEb_order_product." set 	order_id=".$order_id.",	product_id=".$product_id.",	price=".$price.",	quantity=".$quantity."  where id=".$id;
				$query=$db->query($sql);
			header("location: eb_order_product.php");
		        return;
	}
	$sql="select * from  ".$TableEb_order_product."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script>
</head>
<script language="javascript">
	function back()
	{
		location="eb_order_product.php";
	}

	function Check()
	{
		var form=form1;
		if(form.order_id.value=="")
		{
			alert("请输入订单号!");
			form.order_id.focus();
			return;
		}
		if(form.product_id.value=="")
		{
			alert("请输入产品编号!");
			form.product_id.focus();
			return;
		}
		if(!isFloat(form.price.value))
		{
			alert("价格必须为浮点数字!");
			form.price.focus();
			return;
		}
		if(!isIntegerPlus(form.quantity.value))
		{
			alert("数量必须为整型数字!");
			form.quantity.focus();
			return;
		}
		 form.status.value="edit";
		 form.submit();
  	}
</script>
<body>
<form action=""  method="post"  name="form1"  enctype="multipart/form-data">
  <table class="firsttable">
      <tr>
    	<td align="center" valign="top">
        	    <table class="centertable">
          	<tr>
            		<td></td>
          	</tr>
          	<tr>
            		<td align="center" class="addborder">
					<table  class="addTable"  border='0'  cellpadding='0'  cellspacing='1'>
								<tr  class='tr2'>
									<td >订单号:</td>
									<td ><input name="order_id" type="text" id="order_id"  value="<?=$row['order_id']?>" ></td>
								</tr>
								<tr  class='tr2'>
									<td >产品编号:</td>
									<td ><input name="product_id" type="text" id="product_id"  value="<?=$row['product_id']?>" ></td>
								</tr>
								<tr  class='tr2'>
									<td >价格:</td>
									<td ><input name="price" type="text" id="price"  value="<?=$row['price']?>" ></td>
								</tr>
								<tr  class='tr2'>
									<td >数量:</td>
									<td ><input name="quantity" type="text" id="quantity"  value="<?=$row['quantity']?>" ></td>
								</tr>
              				<tr  class='tr2'>
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="确定" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">
						        </td>
              				</tr>
           			  </table>
				  </td>
          		</tr>
          		<tr>
            		  <td></td>
          		</tr>
       	           </table>
    	   </td>
     </tr>
</table>
<input type="hidden" name="status" value="">
<input type="hidden" name="id" value=<?=$id?>>
</form>
</body>
</html>
<? $db->close_db();?>
 

