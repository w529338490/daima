<? require "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?

	$status=$_POST['status'];
	$id=$_POST['id'];
	$sql="select * from  ".$TableEb_order_product."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function back()
	{
		location="eb_order_product.php";
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
					<table  class="addTable">
								<tr >
									<td><font class='fontb'>订单号:</font></td>
									<td ><?=$row['order_id']?></td>
								</tr>
								<tr >
									<td><font class='fontb'>产品编号:</font></td>
									<td ><?=$row['product_id']?></td>
								</tr>
								<tr >
									<td><font class='fontb'>价格:</font></td>
									<td ><?=$row['price']?></td>
								</tr>
								<tr >
									<td><font class='fontb'>数量:</font></td>
									<td ><?=$row['quantity']?></td>
								</tr>
              				<tr >
                				        <td colspan="2" align="center">
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
 

