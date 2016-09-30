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
		$sql="select count(1) as num from ".$TableInfo_category."  where CONCAT(',',menu_ids,',') like '%,".$id.",%'";
	    $row=$db->getRow($sql);
		$b=false;
		if(!empty($row[num]))
		{
			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo "<script language='javascript'>alert('this menu has menuitem,please remove menuitem first!');</script>";
			$b=true;
		}
		if($b==false)
		{
			$sql="delete from ".$TableMain_menu."   where id=".$id;
			$query=$db->query($sql);
		}
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
	  $sql="delete from  ".$TableMain_menu."  where id in (".$filter;
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
	  $sql="update  ".$TableMain_menu." set is_verify=1   where id in (".$filter;
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
	  $sql="update  ".$TableMain_menu." set is_verify=2   where id in (".$filter;
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
             $menu_name=$_POST['menu_name'];
             $fvalue=$menu_name;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableMain_menu.".menu_name like '%".$fvalue."%' ";
                 $b=true;
             }
	$sql="select  ".$TableMain_menu.".*  from    ".$TableMain_menu."  ";
	$sql1="select count(*) as num from    ".$TableMain_menu."  ";
	if($b)
	{
		$sql.=" where ".$filter."  order by ".$TableMain_menu.".id   limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by ".$TableMain_menu.".id   ";
	}
	else
	{
		$sql.="  order by ".$TableMain_menu.".id   limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by ".$TableMain_menu.".id   ";
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
菜单名称:
  <input type="text" size=10 name="menu_name" value="<?=$menu_name?>">
<input type='button'  class='button' onClick="javascript:query()" value='查询' >
           				  </td>
       				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td width=5% >编号</td><td>菜单名称</td><td>描述</td><td width='15%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr  onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
									echo "<td>".$result[$i]['id']."</td>";//Menu Name
				  					echo "<td>".$result[$i]['menu_name']."</td>";//Menu Name
				  					echo "<td>".$result[$i]['description']."</td>";//Description
				  					echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].")'>删除</a> <a href='javascript:edit(".$result[$i]['id'].")'>修改</a></td></tr>";
								}
				 				echo "</table>";
								?>
                			        </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
选择所有 <input type='button'  class='button' onClick="javascript:add()" value='添加'></td>
						<td align="right"> 共 <?=$totalnum?> 条, 共 <?=$page_num?> 页, 第 <?=$page?> 页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
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
		location="main_menuedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="main_menulook.php?id="+id;
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

	function add(){
		location="main_menuadd.php";
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
