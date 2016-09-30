<? include "../../db/Connect.php"?>
<? include "../../include/authorizemanager.php"?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCMS
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<?
	//delete
	$status=$_POST['status'];
	if($status=="remove")
	{
		$id=$_POST['id'];
		$sql=" select * from ".$TableInfos."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/infos/".$row['upload_path'];
		$PicName=$UploadPath."upload/infos/".$row['picture'];
		$PicName_thumbnail=$UploadPath."upload/infos/thumbnail_".$row['picture'];
		if(file_exists($FileName)&&!empty($row['upload_path']))
		{
			 unlink($FileName);
		}
		if(file_exists($PicName)&&!empty($row['picture']))
		{
			 unlink($PicName);
			 unlink($PicName_thumbnail);
		}
	
	    $sql="delete from ".$TableInfos."   where id=".$id;
	    $query=$db->query($sql);
		$sql="delete from ".$TableInfos_comment."   where infos_id=".$id;
	    $query=$db->query($sql);
	}
	//delete seleted
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
	  $sql=" select * from ".$TableInfos."  where id in (".$filter;
	  $results=$db->getAll($sql);
	  for($i=0;$i<count($results);$i++)
	  {
	     	$FileName=$UploadPath."upload/infos/".$results[$i]['upload_path'];
			$PicName=$UploadPath."upload/infos/".$results[$i]['picture'];
			$PicName_thumbnail=$UploadPath."upload/infos/thumbnail_".$results[$i]['picture'];
			if(file_exists($FileName)&&!empty($results[$i]['upload_path']))
			{ 
				 unlink($FileName);
			}
			if(file_exists($PicName)&&!empty($results[$i]['picture']))
			{
				 unlink($PicName);
				 unlink($PicName_thumbnail);
			}
			
	  }
	  $sql="delete from  ".$TableInfos."  where id in (".$filter;
	  $query=$db->query($sql);
	  $sql="delete from ".$TableInfos_comment."   where infos_id in (".$filter;
	  $query=$db->query($sql);
	}
	//verify
	if($status=="verify")
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
	  $sql="update  ".$TableInfos." set is_verify=1   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	//unverify
	if($status=="unverify")
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
	  $sql="update  ".$TableInfos." set is_verify=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	//featured
	if($status=="featured1")
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
	  $sql="update  ".$TableInfos." set featured=1,upload_datetime='".date('Y-m-j H:i:s')."'     where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	//unverify
	if($status=="unfeatured")
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
	  $sql="update  ".$TableInfos." set featured=2   where id in (".$filter;
	  $query=$db->query($sql);
	}
	
	if($status=="transfer_info")
	{
	  $checkednums=array();
	  $checkednums=explode('.',$ids);
	  $filter="";
	  for($i=0;$i<count($checkednums)-2;$i++)
	  {
	     	$filter=$filter.$checkednums[$i].",";
	  }
	  $filter=$filter.$checkednums[count($checkednums)-2].")";
	  
	  $sql="update  ".$TableInfos." set infos_category_id=".$change_info_category_id."  where id in (".$filter;
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
             $infos_category_id=$_POST['infos_category_id'];
             $fvalue=$infos_category_id;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableInfos.".infos_category_id = ".$fvalue." ";
                 $b=true;
             }
             $info_title=$_POST['info_title'];
             $fvalue=$info_title;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableInfos.".info_title like '%".$fvalue."%' ";
                 $b=true;
             }
             $is_verify=$_POST['is_verify'];
             $fvalue=$is_verify;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableInfos.".is_verify = ".$fvalue." ";
                 $b=true;
             }
			 $featured=$_POST['featured'];
             $fvalue=$featured;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableInfos.".featured = ".$fvalue." ";
                 $b=true;
             }
             $fvalue="has_link_table";
             if(!empty($fvalue))
             {
             	if($b)
             		$filter.=" and";
             	$filter.=" ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id   ";
             	$b=true;
             }
	$sql="select  ".$TableInfos.".* ,".$TableInfo_category.".name as  video_category_name  from    ".$TableInfos." ,".$TableInfo_category."  ";
	$sql1="select count(*) as num from    ".$TableInfos." ,".$TableInfo_category."  ";
	if($b)
	{
		$sql.=" where ".$filter."  order by ".$TableInfos.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by ".$TableInfos.".id desc  ";
	}
	else
	{
		$sql.="  order by ".$TableInfos.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by ".$TableInfos.".id desc  ";
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
           				  <td colspan="2" >
菜单栏目:<select name="infos_category_id" id="infos_category_id">
	<option value=""></option>
	<?
		$pid=$infos_category_id;
		$sql3="select name,id,pid from ".$TableInfo_category." where pid=0 and is_au=1 order by id ";
			$query3=$db->query($sql3);
			$sql4="select name,id,pid from ".$TableInfo_category." where pid<>0  and is_au=1  order by sortid " ;
			$resultCategroy=$db->getAll($sql4);
			while($object3=$db->fetch_object($query3))
			{
				$levelStr="";
				$level_num=1;
				if($object3->id==$pid)
					echo "<option value='".$object3->id."' selected>".$object3->name."</option>";
				else
					echo "<option value='".$object3->id."' >".$object3->name."</option>";
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
							subCategory($resultCategroy,$resultCategroy[$i][id],$pid);
						}
						$levelStr="";
					}
			}
	
			function subCategory($resultCategroy,$id,$pid)
			{
				global $level_num;
				$level_num++;
				for($i=0;$i<count($resultCategroy);$i++)
				{
					$levelStr="";
					for($j=0;$j<$level_num;$j++)
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
							subCategory($resultCategroy,$resultCategroy[$i][id],$pid);
					}
					$levelStr="";
				}
				$level_num--;
			}
	?>
</select>
标题:<input type="text" size=10 name="info_title" value="<?=$info_title?>">
审核:<select name="is_verify" id="is_verify">
	<option value=""></option>
	<?
		for($i=1;$i<=count($T_Is_YesNO);$i++)
		{
			 if((int)$is_verify==$i)
			 	echo "<option value='".$i."' selected>".$T_Is_YesNO[$i]."</option>";
			else
				echo "<option value='".$i."'>".$T_Is_YesNO[$i]."</option>";
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
			 	echo "<option value='".$i."' selected>".$T_Is_YesNO[$i]."</option>";
			else
				echo "<option value='".$i."'>".$T_Is_YesNO[$i]."</option>";
		}
	?>
</select>
<input type='button'  class='button' onClick="javascript:query()" value='查询' >           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td width=15% >菜单栏目</td><td>标题</td><td width=20% >发布日期</td><td width=10% >审核</td><td width=10% >推荐</td><td width='15%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr  onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td  align='center'>";
				  					echo $result[$i]['video_category_name'];
				  					echo "</td>";
				  					echo "<td  >".$result[$i]['info_title']."</td>";//标题
				  					
				  					echo "<td align='center'>".FormatDate($result[$i]['upload_datetime'])."</td>";//Upload Datetime
				  					echo "<td  align='center'>";
				  							echo $T_Is_YesNO[$result[$i]['is_verify']];
				  					echo "</td>";
									echo "<td  align='center'>";
				  							echo $T_Is_YesNO[$result[$i]['featured']];
				  					echo "</td>";
									echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].")'>删除</a> <a href='javascript:edit(".$result[$i]['id'].")'>修改</a></td></tr>";
								}
				 				echo "</table>";
								?>                			        </td>
              			</tr>
              			<tr>
              			  <td colspan="2"><input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
选择所有
  <input type='button'  class='button' onClick="javascript:add()" value='添加'>
  <input type='button'  class='button' onClick="javascript:removeSelect()"  value='删除' >
  <input name="button22" type='button'  class='button' onClick="javascript:verify()" value='审核'>
  <input name="button23" type='button'  class='button' style='width:80px' onClick="javascript:unverify()" value='不审核' >
  <input name="button" type='button'  class='button' onClick="javascript:featured1()" value='推荐'>
  <input name="button" type='button'  class='button' style='width:80px' onClick="javascript:unfeatured()" value='不推荐' >
  <input name="button25" type='button'  class='button' style='width:80px' onClick="javascript:transfer_info()" value='内容转移到' >
  <select name="change_info_category_id" id="change_info_category_id">
    <?
							$itemid=explode(',',$_SESSION['SessionUser']['itemid']);
							$sql3="select name,id,pid from ".$TableInfo_category." where pid=0 and is_au=1  order by id ";
							$query3=$db->query($sql3);
							$pid=$change_info_category_id;
								while($object3=$db->fetch_object($query3))
								{
									//if(!in_array($object3->id,$itemid)) continue;
									$levelStr="";
									$level_num=1;
									if($object3->id==$pid)
										echo "<option value=".$object3->id." selected>".$object3->name."</option>";
									else
										echo "<option value=".$object3->id." >".$object3->name."</option>";
										for($i=0;$i<count($resultCategroy);$i++)
										{
											//if(!in_array($resultCategroy[$i]['id'],$itemid)) continue;
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
												subChangeCategory($resultCategroy,$resultCategroy[$i][id],$pid);
											}
											$levelStr="";
										}
								}
						
								function subChangeCategory($resultCategroy,$id,$pid)
								{
									global $level_num;
									$level_num++;
									for($i=0;$i<count($resultCategroy);$i++)
									{
										$levelStr="";
										for($j=0;$j<$level_num;$j++)
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
												subChangeCategory($resultCategroy,$resultCategroy[$i][id],$pid);
										}
										$levelStr="";
									}
									$level_num--;
								}
						?>
  </select></td>
       			    </tr>
              			<tr>
						<td>&nbsp;</td><td align="right"> 共 <?=$totalnum?> 条, 共 <?=$page_num?> 页, 第 <?=$page?> 页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
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
	function checkBoxAll()//
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
		location="infosedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="infoslook.php?id="+id;
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
			alert("请选择记录 ! ");
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
			alert("请选择记录 ! ");
			return;
		}
		form.status.value="unverify";
		form.submit();
	}
	
	function featured1(){
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
			alert("请选择记录 ! ");
			return;
		}
		form.status.value="featured1";
		form.submit();
	}

	function unfeatured(){
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
			alert("请选择记录 ! ");
			return;
		}
		form.status.value="unfeatured";
		form.submit();
	}
	
	function transfer_info(){
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
			alert("请选择记录 !");
			return;
		}
		if(confirm("真的想要转移吗?")==false)
				return;
		form.status.value="transfer_info";
		form.submit();
  }


	function add(){
		location="infosadd.php";
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
