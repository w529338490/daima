<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
	//delete
	$status=$_POST['status'];
	if($status=="remove")
	{
		$id=$_POST['id'];
		$sql=" select * from ".$TableEb_product."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/eb_product/".$row['picture'];
		if(file_exists($FileName)&&!empty($row['picture']))
		{
			 unlink($FileName);
		}
		$FileName=$UploadPath."upload/eb_product/s".$row['picture'];
		if(file_exists($FileName))
		{
			 unlink($FileName);
		}
		
	    $sql="delete from ".$TableEb_product."   where id=".$id;
	    $query=$db->query($sql);
		$sql="delete from ".$TableEb_remark."   where eb_product_id=".$id;
	    $query=$db->query($sql);
	}
	//detele all
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
	  $sql=" select * from ".$TableEb_product."  where id in (".$filter;
	  $results=$db->getAll($sql);
	  for($i=0;$i<count($results);$i++)
	  {
	     	$FileName=$UploadPath."upload/eb_product/".$results[$i]['picture'];
			if(file_exists($FileName)&&!empty($results[$i]['picture']))
			{ 
				 unlink($FileName);
			}
			$FileName=$UploadPath."upload/eb_product/s".$results[$i]['picture'];
			if(file_exists($FileName))
			{ 
				 unlink($FileName);
			}
			
	  }
	  $sql="delete from  ".$TableEb_product."  where id in (".$filter;
	  $query=$db->query($sql);
	  $sql="delete from ".$TableEb_remark."   where eb_product_id in (".$filter;
	  $query=$db->query($sql);
	}
	
	//verify
	if($status=="verify")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product." set is_verify=1  where id in (".$filter;
	  $query=$db->query($sql);
	}
	//unverify
	if($status=="unverify")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product." set is_verify=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	

	
	//okfeatured
	if($status=="okfeatured")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product." set featured=1  where id in (".$filter;
	  $query=$db->query($sql);
	}
	//unfeatured
	if($status=="unfeatured")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product." set featured=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	
	
	//transfer
	if($status=="change_product")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  $sql="update  ".$TableEb_product." set eb_product_category_id=".$change_product_category_id."   where id in (".$filter;
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
             $eb_product_category_id=$_POST['eb_product_category_id'];
             $fvalue=$eb_product_category_id;
            
			 if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" (".$TableEb_product.".eb_product_category_id = ".$fvalue." or CONCAT(',',".$TableEb_product.".nodepath,',') like '%,".$fvalue.",%') ";
                 $b=true;
             }
             $product_id=$_POST['product_id'];
             $fvalue=$product_id;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" product_id like '%".$fvalue."%' ";
                 $b=true;
             }
             $product_name=$_POST['product_name'];
             $fvalue=$product_name;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" product_name like '%".$fvalue."%' ";
                 $b=true;
             }
             $is_verify=$_POST['is_verify'];
             $fvalue=$is_verify;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_verify = ".$fvalue." ";
                 $b=true;
             }
             $is_recomend=$_POST['is_recomend'];
             $fvalue=$is_recomend;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_recomend = ".$fvalue." ";
                 $b=true;
             }
             $featured=$_POST['featured'];
             $fvalue=$featured;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" featured = ".$fvalue." ";
                 $b=true;
             }
            
             $is_special=$_POST['is_special'];
             $fvalue=$is_special;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_special = ".$fvalue." ";
                 $b=true;
             }
             $is_hot=$_POST['is_hot'];
             $fvalue=$is_hot;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_hot = ".$fvalue." ";
                 $b=true;
             }
             $fvalue="has_link_table";
             if(!empty($fvalue))
             {
             	if($b)
             		$filter.=" and";
             	$filter.=" ".$TableEb_product.".eb_product_category_id = ".$TableEb_product_category.".id   ";
             	$b=true;
             }
	$sql="select  ".$TableEb_product.".* ,".$TableEb_product_category.".name as  eb_product_category_name  from    ".$TableEb_product." ,".$TableEb_product_category."  ";
	$sql1="select count(*) as num from    ".$TableEb_product." ,".$TableEb_product_category."  ";
	if($b)
	{
		$sql.=" where ".$filter."  order by ".$TableEb_product.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by ".$TableEb_product.".id desc  ";
	}
	else
	{
		$sql.="  order by ".$TableEb_product.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by ".$TableEb_product.".id desc  ";
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
           				    产品分类:
                                <select name="eb_product_category_id" id="eb_product_category_id">
                                  <option value=""></option>
                                  <?
		$pid=$eb_product_category_id;
		$sql3="select name,id,pid from ".$TableEb_product_category." where pid=0";
			$query3=$db->query($sql3);
			$sql4="select name,id,pid from ".$TableEb_product_category." where pid<>0" ;
			$resultCategroy=$db->getAll($sql4);
			while($object3=$db->fetch_object($query3))
			{
				$levelStr="";
				$level_num=1;
				if($object3->id==$pid)
					echo "<option value=".$object3->id." selected>".$object3->name."</option>";
				else
					echo "<option value=".$object3->id." >".$object3->name."</option>";
					for($i=0;$i<count($resultCategroy);$i++)
					{
						for($j=0;$j<$level_num;$j++)
							$levelStr.="----";
						if($object3->id==$resultCategroy[$i][pid])
						{
							if($resultCategroy[$i][id]==$pid)
							{
								echo "<option value='".$resultCategroy[$i][id]."' selected>";
									echo $levelStr.$resultCategroy[$i][name];
								echo "</option>";
							}
							else
							{
								echo "<option value='".$resultCategroy[$i][id]."' >";
									echo $levelStr.$resultCategroy[$i][name];
								echo "</option>";
							}
							sub产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
						}
						$levelStr="";
					}
			}
	
			function sub产品分类($resultCategroy,$id,$pid)
			{
				global $level_num;
				$level_num++;
				for($i=0;$i<count($resultCategroy);$i++)
				{
					$levelStr="";
					for($j=0;$j<$level_num;$j++);
						$levelStr.="----";
					if($id==$resultCategroy[$i][pid])
					{
							if($resultCategroy[$i][id]==$pid)
							{
								echo "<option value='".$resultCategroy[$i][id]."' selected>";
									echo $levelStr.$resultCategroy[$i][name];
								echo "</option>";
							}
							else
							{
								echo "<option value='".$resultCategroy[$i][id]."' >";
									echo $levelStr.$resultCategroy[$i][name];
								echo "</option>";
							}
							sub产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
							$levelStr="";
					}
				}
				$level_num--;
			}
	?>
                                </select>
                            产品名称:
                            <input type="text" size=10 name="product_name" value="<?=$product_name?>">
                            审核:
                            <select name="is_verify" id="is_verify">
                              <option value=""></option>
                              <?
		for($i=1;$i<=count($T_Is_YesNO);$i++)
		{
			 if((int)$is_verify==$i)
			 	echo "<option value=".$i." selected>".$T_Is_YesNO[$i]."</option>";
			else
				echo "<option value=".$i.">".$T_Is_YesNO[$i]."</option>";
		}
	?>
                            </select>
                            推荐:
                            <select name="featured" id="featured">
                              <option value=""></option>
                              <?
		for($i=1;$i<=count($T_Is_YesNO);$i++)
		{
			 if((int)$featured==$i)
			 	echo "<option value=".$i." selected>".$T_Is_YesNO[$i]."</option>";
			else
				echo "<option value=".$i.">".$T_Is_YesNO[$i]."</option>";
		}
	?>
                            </select>
                            <input name="button" type='button'  class='button' onClick="javascript:query()" value='查询' >
           				  </p>           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								
								
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td>产品分类</td><td>产品名称</td><td width='10%' >价格</td><td width='10%' >审核</td><td width='10%' >推荐</td><td width='10%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr   align=center   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td  align='center'>";
				  					echo $result[$i]['eb_product_category_name'];
				  					echo "</td>";
				  					//echo "<td>".$result[$i]['product_id']."</td>";//ID
				  					echo "<td>".$result[$i]['product_name']."</td>";//产品名称
				  					
				  					//echo "<td>".$result[$i]['market_price']."</td>";//市场价格
				  					echo "<td>".$result[$i]['price'].$T_Price_type[$config_row['price_type']]."</td>";//当前价格
				  					//echo "<td>".$result[$i]['score']."</td>";//积分购买
				  					//echo "<td>".$result[$i]['quantity']."</td>";//数量
				  					echo "<td  align='center'>";
				  							echo $T_Is_YesNO[$result[$i]['is_verify']];
				  					echo "</td>";
									echo "<td  align='center'>";
				  							echo $T_Is_YesNO[$result[$i]['featured']];
				  					echo "</td>";
				  					//echo "<td>".FormatDate($result[$i]['publish_time'])."</td>";//发布时间
				  					//echo "<td>".$result[$i]['click_count']."</td>";//点击数
				  					//echo "<td>".$result[$i]['remark_count']."</td>";//评论数
				  		
				  					echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].")'>Delete</a><br> <a href='javascript:edit(".$result[$i]['id'].")'>Modify</a> <a target='_blank' href='".$SETUPFOLDER."/product.php?menuid=201&pcatid=".$result[$i]['eb_product_category_id']."&id=".$result[$i]['id']."&level=3'>View</a></td></tr>";
								}
				 				echo "</table>";
								?>                			        </td>
              			</tr>
              			<tr>
              			  <td colspan="2" align="left"><input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
选择所有
  <input type='button'  class='button' onClick="javascript:add()" value='添加'>
  <input name="button2" type='button'  class='button' style='width:80px' onClick="javascript:removeSelect()" value='删除' >
  <input name="button25" type='button'  class='button' style='width:80px' onClick="javascript:change_product()" value='转移到' >
  <select name="change_product_category_id" id="change_product_category_id">
    <?
							$sql3="select name,id,pid from ".$TableEb_product_category." where pid=0";
							$query3=$db->query($sql3);
							$pid=$change_product_category_id;
								while($object3=$db->fetch_object($query3))
								{
									$levelStr="";
									$level_num=1;
									if($object3->id==$pid)
										echo "<option value=".$object3->id." selected>".$object3->name."</option>";
									else
										echo "<option value=".$object3->id." >".$object3->name."</option>";
										for($i=0;$i<count($resultCategroy);$i++)
										{
											for($j=0;$j<$level_num;$j++)
												$levelStr.="----";
											if($object3->id==$resultCategroy[$i][pid])
											{
												if($resultCategroy[$i][id]==$pid)
												{
													echo "<option value='".$resultCategroy[$i][id]."' selected>";
														echo $levelStr.$resultCategroy[$i][name];
													echo "</option>";
												}
												else
												{
													echo "<option value='".$resultCategroy[$i][id]."' >";
														echo $levelStr.$resultCategroy[$i][name];
													echo "</option>";
												}
												subChange产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
											}
											$levelStr="";
										}
								}
						
								function subChange产品分类($resultCategroy,$id,$pid)
								{
									global $level_num;
									$level_num++;
									for($i=0;$i<count($resultCategroy);$i++)
									{
										$levelStr="";
										for($j=0;$j<$level_num;$j++);
											$levelStr.="----";
										if($id==$resultCategroy[$i][pid])
										{
												if($resultCategroy[$i][id]==$pid)
												{
													echo "<option value='".$resultCategroy[$i][id]."' selected>";
														echo $levelStr.$resultCategroy[$i][name];
													echo "</option>";
												}
												else
												{
													echo "<option value='".$resultCategroy[$i][id]."' >";
														echo $levelStr.$resultCategroy[$i][name];
													echo "</option>";
												}
												sub产品分类($resultCategroy,$resultCategroy[$i][id],$pid);
												$levelStr="";
										}
									}
									$level_num--;
								}
						?>
  </select></td>
       			    </tr>
              			<tr>
              			  <td colspan="2" align="center"><input name="button2222" type='button'  class='button' onClick="javascript:推荐()" value='推荐'>
                          <input name="button2322" type='button'  class='button' style='width:80px' onClick="javascript:un推荐()" value='不推荐' >
|
<input name="button22" type='button'  class='button' onClick="javascript:verify()" value='审核'>
<input name="button23" type='button'  class='button' style='width:80px' onClick="javascript:unverify()" value='不审核' ></td></tr>
              			<tr>
						<td>&nbsp;</td><td align="right">共
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
		location="eb_productedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="eb_productlook.php?id="+id;
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
		if(confirm("真的想要删除吗?")==false)
			return;
		form.status.value="removeSelect";
		form.submit();
	}
	
	function verify(){
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
	form.status.value="verify";
	form.submit();
  }
  
   function unverify(){
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
	form.status.value="unverify";
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

 function 推荐(){
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
	form.status.value="okfeatured";
	form.submit();
  }
  
   function un推荐(){
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
	form.status.value="unfeatured";
	form.submit();
  }
  
  	function remark(){
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
	form.status.value="remark";
	form.submit();
  }
  
   function unremark(){
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
	form.status.value="unremark";
	form.submit();
  }

   function setTop_level(){
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
	form.status.value="setTop_level";
	form.submit();
  }

   function change_product(){
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
	if(confirm("真的想要转移吗?")==false)
			return;
	form.status.value="change_product";
	form.submit();
  }

	function add(){
		location="eb_productadd.php";
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
 

