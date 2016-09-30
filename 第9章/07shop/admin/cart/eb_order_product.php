<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
	//删除
	$status=$_POST['status'];
	if($status=="remove")
	{
	    $sql="delete from ".$TableEb_order_product."   where id=".$id;
	    $query=$db->query($sql);
	}
	//删除全部选择的
	if($status=="removeSelect")
	{
	  $checkednums=array();
	  $ids=$_POST['ids'];
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="delete from  ".$TableEb_order_product."  where id in (".$filter;
	  $query=$db->query($sql);
	}
	$page=$_POST['page'];
	if(empty($page))
    	{$page=1;}
    else
    {
		 if($page<1){ $page=1;}
	}
             $b=false;
             $filter="";
             $order_id=$_POST['order_id'];
             $fvalue=$order_id;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" order_id = ".$fvalue." ";
                 $b=true;
             }
             $product_id=$_POST['product_id'];
             $fvalue=$product_id;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" product_id = ".$fvalue." ";
                 $b=true;
             }
	$sql="select * from  ".$TableEb_order_product;
	$sql1="select count(*) as num from  ".$TableEb_order_product;
	if($b)
	{
		$sql.=" where ".$filter."  order by id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by id desc  ";
	}
	else
	{
		$sql.="  order by id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by id desc  ";
	}
	$result=$db->getAll($sql);
	$row=$db->getRow($sql1);
	$totalnum=$row['num'];
	$page_num=ceil($totalnum/$pagenum);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script>
</head>
<body>
<form name="form1" method="post" >
  <table border="0" cellpadding="0"  cellspacing="0" class="firsttable">
    <tr>
      <td align="center" valign="top">
	  	<table   class="centertable">
      		<tr>
            	<td>&nbsp;
            	</td>
       		</tr>
        	<tr>
       		  <td align="center" valign="top">
				  <table class="containContentsTable">
              			<tr align="right">
           				  <td colspan="2" >
订单号:<input type="text" size=10 name="order_id" value="<?=$order_id?>">
产品编号:<input type="text" size=10 name="product_id" value="<?=$product_id?>">
<input name="button" type='button'  class='button' onClick="javascript:query()" value='查询' >
           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'   border='0'  cellpadding='0'  cellspacing='1'>";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td>订单号</td><td>产品编号</td><td>价格</td><td>数量</td><td width='15%' >操作</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td>".$result[$i]['order_id']."</td>";//订单号
				  					echo "<td>".$result[$i]['product_id']."</td>";//产品编号
				  					echo "<td>".$result[$i]['price']."</td>";//价格
				  					echo "<td>".$result[$i]['quantity']."</td>";//数量
				  					echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].")'>删除</a> <a href='javascript:edit(".$result[$i]['id'].")'>修改</a> <a href='javascript:look(".$result[$i]['id'].")'>浏览</a></td></tr>";
								}
				 				echo "</table>";
								?>
                			        </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
全选 <input type='button'  class='button' onClick="javascript:add()" value='添加'>
                            <input name="button2" type='button'  class='button' style='width:80px' onClick="javascript:removeSelect()" value='删除选项' ></td><td align="right"> 共 <?=$totalnum?> 条, 共 <?=$page_num?> 页, 第 <?=$page?> 页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
					     			<select name="position" id="position"  onChange="goposition()">
                      				<option value=""></option>
                     				 <?
					     			for($i=1;$i<=$page_num;$i++)
					     			{
						   			echo "<option ";
						   				if($page==$i){echo "selected";}
						   					echo " value=$i>";
						   					echo $i;
						   					echo "</option>" ;
					     			}
					     	?>
					     			</select>
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
  <input type="hidden" name="page" value=<?=$page?>>
  <input type="hidden" name="totalpage" value=<?=$page_num?>>
   <input type="hidden" name="id" value="">
   <input type="hidden" name="ids" value="">
</form>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
	function checkBoxAll()//全选
	{
		var form = form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
			{
				form.elements[i].checked = form.cboAll.checked;
			}
		}
	}

	function edit(id){
		var form=form1;
		form.id.value=id;
		form.action="eb_order_productedit.php";
		form.submit();
	}

	function look(id){
		var form=form1;
		form.id.value=id;
		form.action="eb_order_productlook.php";
		form.submit();
	}

	function remove(id){
		if(confirm("是否要删除选择的记录")==true){
			var form=form1;
			form.id.value=id;
			form.status.value="remove";
			form.submit();
		}
	}

	function removeSelect(){
		var form=form1;
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="checkvalue")
			{
				if(form.elements[i].checked==true)
				{
					form.ids.value+=form.elements[i].value+".";
				}
			}
		}
		if(form.ids.value=="")
		{
			alert("请选择要删除的记录");
			return;
		}
		if(confirm("是否要删除选择的记录")==false)
			return;
		form.status.value="removeSelect";
		form.submit();
	}

	function add(){
		location="eb_order_productadd.php";
	}

	function query()
	{
		var form=form1;
		form.submit();
	}

	function first()
	{
		var form=form1;
		if(eval(form.page.value)==1)
			return;
		form.page.value=1;
		form.submit();
	}

	function next()
	{
		var form=form1;
		if(eval(form.page.value)>=eval(form.totalpage.value))
			return;
		form.page.value=eval(form.page.value)+1;
		form.submit();
	}

	function last()
	{
		var form=form1;
		if(eval(form.page.value)==eval(form.totalpage.value))
			return;
		form.page.value=eval(form.totalpage.value);
		form.submit();
	}

	function pre()
	{
		var form=form1;
		if(form.page.value<=1)
			return;
		form.page.value=eval(form.page.value)-1;
		form.submit();
	}

	function  goposition()
	{
		var form=form1;
		form.page.value=form.position.value;
		form.submit();
	}
</script>
<? $db->close_db();?>
 

