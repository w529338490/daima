<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
	//删除
	$status=$_POST['status'];
	if($status=="remove")
	{
	    $sql="delete from ".$TableEb_product_order."   where id=".$id;
	    $query=$db->query($sql);
		$sql="delete from ".$TableEb_order_product."   where order_id=".$id;
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
	  $sql="delete from  ".$TableEb_product_order."  where id in (".$filter;
	  $query=$db->query($sql);
	  $sql="delete from ".$TableEb_order_product."   where order_id in (".$filter;
	  $query=$db->query($sql);
	}
	
		//处理
	if($status=="recommend")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $indate=date('Y-n-j H:i:s');
	  $deal_time=$indate;
	  $deal_people=$_SESSION['SessionUser']['username'];
	  $sql="update  ".$TableEb_product_order." set order_status=3,deal_time='".$deal_time."' ,deal_people='".$deal_people."'  where id in (".$filter;
	  $query=$db->query($sql);
	}
	//处理
	if($status=="unrecommend")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product_order." set order_status=1 ,deal_time=null ,deal_people=null  where id in (".$filter;
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
             
             $order_time=$_POST['order_time'];
             $fvalue=$order_time;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" TO_DAYS(order_time) = TO_DAYS('".$fvalue."') ";
                 $b=true;
             }
             $order_people=$_POST['order_people'];
             $fvalue=$order_people;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" order_people like '%".$fvalue."%' ";
                 $b=true;
             }
             $deal_time=$_POST['deal_time'];
             $fvalue=$deal_time;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" TO_DAYS(deal_time) = TO_DAYS('".$fvalue."') ";
                 $b=true;
             }
             $deal_people=$_POST['deal_people'];
             $fvalue=$deal_people;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" deal_people like '%".$fvalue."%' ";
                 $b=true;
             }
             $order_status=$_POST['order_status'];
             $fvalue=$order_status;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" order_status = ".$fvalue." ";
                 $b=true;
             }
			 
	$sql="select  * from  ".$TableEb_product_order." ";
	$sql1="select count(*) as num from  ".$TableEb_product_order."  ";
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
           				  <td colspan="2" ><p>
           				    订购用户:
                                <input type="text" size=10 name="order_people" value="<?=$order_people?>">
                            状态:
                            <select name="order_status" id="order_status">
                              <option value=""></option>
                              <?
			for($i=1;$i<=count($T_Order_status);$i++)
			{
				 if((int)$order_status==$i)
					echo "<option value=".$i." selected>".$T_Order_status[$i]."</option>";
				else
					echo "<option value=".$i.">".$T_Order_status[$i]."</option>";
			}
		?>
                            </select>
                            <input name="button" type='button'  class='button' onClick="javascript:query()" value='查询' >
           				  </p>
           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1'>";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td width=20% >订单日期</td><td  width=15% >订购用户</td><td  width=15% >处理日期</td><td  width=15% >处理人</td><td  width=15% >状态</td><td width='15%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr  align='center'  onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td>".FormatDate($result[$i]['order_time'])."</td>";//预订日期
				  					echo "<td>".$result[$i]['order_people']."</td>";//Order User
				  					echo "<td>".FormatDate($result[$i]['deal_time'])."</td>";//处理时间
				  					echo "<td>".$result[$i]['deal_people']."</td>";//处理人
				  					echo "<td>".$T_Order_status[$result[$i]['order_status']]."</td>";//状态
				  					echo "<td align='center'><a href='javascript:remove(".$result[$i]['id'].")'>删除</a> <a href='eb_product_orderlook.php?order_id=".$result[$i]['id']."'>浏览</a></td></tr>";
								}
				 				echo "</table>";
								?>       			          </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
							  选择所有
						      <input name="button2" type='button'  class='button' style='width:80px' onClick="javascript:removeSelect()" value='删除' >
<input name="button22" type='button'  class='button' onClick="javascript:recommend()" value='完成'>
<input name="button23" type='button'  class='button' style='width:80px' onClick="javascript:unrecommend()" value='未完成' ></td>
						<td align="right">共
                          <?=$totalnum?>
条, 共
<?=$page_num?>
页, 第
<?=$page?>
页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
<select name="position" id="position"  onChange="goposition()">
  <option value=""></option>
  <?
					     			for($i=1;$i<=$page_num;$i++)
					     			{
						   			echo "<option ";
						   				if(page==$i){echo "selected";}
						   					echo " value=$i>";
						   					echo $i;
						   					echo "</option>" ;
					     			}
					     	?>
</select></td>
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
		form.action="eb_product_orderedit.php";
		form.submit();
	}

	function look(id){
		var form=form1;
		form.id.value=id;
		form.action="eb_product_orderlook.php";
		form.submit();
	}

	function remove(id){
		if(confirm("真的想要删除吗?")==true){
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
			alert("请选择记录!");
			return;
		}
		if(confirm("真的想要删除吗 ?")==false)
			return;
		form.status.value="removeSelect";
		form.submit();
	}
	
  function recommend(){
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
		alert("请选择记录!");
		return;
	}
	form.status.value="recommend";
	form.submit();
  }
  
   function unrecommend(){
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
		alert("请选择记录!");
		return;
	}
	form.status.value="unrecommend";
	form.submit();
  }


	function add(){
		location="eb_product_orderadd.php";
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
 

