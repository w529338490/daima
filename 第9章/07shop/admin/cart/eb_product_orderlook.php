<? require "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?

	$sql="select * from ".$TableEb_product_order." where id=".$order_id;
	  $rowOrder=$db->getRow($sql);
	  $username=$rowOrder['order_people'];
	  
	  $sql="select * from  ".$TableAdmin."  where username='".$username."'";
	  $rowUser=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function back()
	{
		location="eb_product_order.php";
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
								<tr  class='tr2' >
                                <td ><span class="fontb">姓名</span>:</td>
                                <td ><?=$rowUser['true_name']?></td>
                              </tr>
							  <tr  class='tr2' >
                                <td ><span class="fontb">电话</span>:</td>
                                <td ><?=$rowUser['telepnone']?></td>
                              </tr>
                              <tr  class='tr2' >
                                <td ><span class="fontb">手机</span>:</td>
                                <td ><?=$rowUser['moblie']?></td>
                              </tr>
                              <tr  class='tr2' >
                                <td ><span class="fontb">邮箱</span>:</td>
                                <td ><?=$rowUser['EmailName']?></td>
                              </tr>
                              <tr  class='tr2' >
                                <td ><span class="fontb">国家</span>: </td>
                                <td><?=$rowUser[country]?></td>
                              </tr>
                            
							  
                              <tr  class='tr2' >
                                <td  width=100><span class="fontb">地址</span>:</td>
                                <td >&nbsp;</td>
                              </tr>
                              <tr  class='tr2' >
                                <td colspan="2"><?=$rowUser['my_location']?></td>
                              </tr>
							  
							  <tr  class='tr2' >
                                <td  width=100><span class="fontb">备注</span>:</td>
                                <td >&nbsp;</td>
                              </tr>
                              <tr  class='tr2' >
                                <td colspan="2"><?=$rowUser['memo']?></td>
                              </tr>
								<tr  class='tr2' >
									<td ><font class='fontb'>订单日期:</font></td>
									<td ><?=FormatDate($rowOrder['order_time'])?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>订购用户:</font></td>
									<td ><?=$rowOrder['order_people']?></td>
								</tr>
								<tr class='tr2'  >
									<td ><font class='fontb'>处理日期:</font></td>
									<td ><?=FormatDate($rowOrder['deal_time'])?></td>
								</tr>
								<tr class='tr2'  >
									<td><font class='fontb'>处理用户:</font></td>
								  <td ><?=$rowOrder['deal_people']?></td>
								</tr>
								<tr  class='tr2' >
									<td><font class='fontb'>状态:</font></td>
									<td ><?=$T_Order_status[$rowOrder['order_status']]?></td>
								</tr>
              				    <tr class='tr2'  >
              				      <td colspan="2"><strong>订单产品</strong></td>
   				      </tr>
           				        <tr  class='tr2' >
           				          <td colspan="2">
								  <?
								  $total=0;
								  $totalprice=0;
								  $catnum=0;
								  $sql="select a.*,b.product_name from  ".$TableEb_order_product." as a,".$TableEb_product." as b where a.product_id=b.id and a.order_id=".$order_id;
								  $result=$db->getAll($sql);
								  $catnum=count($result);
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1'>";
								echo "<tr class='tr1'  align=center ><td>订单号</td><td>产品名称</td><td>价格</td><td>数量</td><td>总价</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
									$total+=(int)$result[$i]['quantity'];
									$rowTotalPrice=(int)$result[$i]['quantity']*(int)$result[$i]['price'];
									$totalprice+=$rowTotalPrice;
				  					echo "<tr class='tr2' align='center'>";
				  					echo "<td>".$result[$i]['order_id']."</td>";//订单号
				  					echo "<td>".$result[$i]['product_name']."</td>";//产品编号
				  					echo "<td>".$result[$i]['price'].$T_Price_type[$config_row['price_type']]."</td>";//价格
				  					echo "<td>".$result[$i]['quantity']."</td>";//数量
									echo "<td>".$rowTotalPrice."</td>";
				  					echo "</tr>";
								}
				 				echo "</table>";
								?>
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td align="right"><span class="style14" style="font-weight:bold; padding-right:26px; padding-top:5px;">产品总数 
                                      <?=$total?>，总价 <?=$totalprice?> <?=$T_Price_type[$config_row['price_type']]?></span></td>
                                    </tr>
                                  </table></td>
			          </tr>
       				        <tr  class='tr2' >
                				        <td colspan="2" align="center">
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">						        </td>
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
 

