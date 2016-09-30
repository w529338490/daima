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
		$sql=" select * from ".$TableAdmin."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/manager_users/".$row['photo'];
		$FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$row['photo'];
		if(file_exists($FileName)&&!empty($row['photo']))
		{
			 unlink($FileName);
			 unlink($FileName_thumbnail);
		}
	    $sql="delete from ".$TableAdmin."   where id=".$id;
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
	  $sql=" select * from ".$TableAdmin."  where id in (".$filter;
	  $results=$db->getAll($sql);
	  for($i=0;$i<count($results);$i++)
	  {
	     	$FileName=$UploadPath."upload/manager_users/".$results[$i]['photo'];
			$FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$results[$i]['photo'];
			if(file_exists($FileName)&&!empty($results[$i]['photo']))
			{ 
				 unlink($FileName);
			}
	  }
	  $sql="delete from  ".$TableAdmin."  where id in (".$filter;
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
	  $sql="update  ".$TableAdmin." set is_verify=1   where id in (".$filter;
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
	  $sql="update  ".$TableAdmin." set is_verify=2   where id in (".$filter;
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
             $UserGrade=$_POST['UserGrade'];
             $fvalue=$UserGrade;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableAdmin.".UserGrade = ".$fvalue." ";
                 $b=true;
             }
             $nick_name=$_POST['nick_name'];
             $fvalue=$nick_name;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableAdmin.".nick_name like '%".$fvalue."%' ";
                 $b=true;
             }
             $username=$_POST['username'];
             $fvalue=$username;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableAdmin.".username like '%".$fvalue."%' ";
                 $b=true;
             }
             $country=$_POST['country'];
             $fvalue=$country;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableAdmin.".country like '%".$fvalue."%' ";
                 $b=true;
             }
             $sex=$_POST['sex'];
             $fvalue=$sex;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableAdmin.".sex = ".$fvalue." ";
                 $b=true;
             }
             $regtime=$_POST['regtime'];
             $fvalue=$regtime;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" TO_DAYS(".$TableAdmin.".regtime) = TO_DAYS('".$fvalue."') ";
                 $b=true;
             }
             $fvalue="has_link_table";
             if(!empty($fvalue))
             {
             	if($b)
             		$filter.=" and";
             	$filter.=" ".$TableAdmin.".UserGrade = ".$TableRole.".id   ";
             	$b=true;
             }
	$sql="select  ".$TableAdmin.".* ,".$TableRole.".name as  manager_role_name  from    ".$TableAdmin." ,".$TableRole."  ";
	$sql1="select count(*) as num from    ".$TableAdmin." ,".$TableRole."  ";
	if($b)
	{
		$sql.=" where ".$filter."  order by ".$TableAdmin.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.=" where ".$filter."  order by ".$TableAdmin.".id desc  ";
	}
	else
	{
		$sql.="  order by ".$TableAdmin.".id desc  limit ".(($page-1)*$pagenum).",$pagenum";
		$sql1.="   order by ".$TableAdmin.".id desc  ";
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
<script language="javascript" src="../../js/country.js"></script>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="containContentsTable">
  <tr>
    <td>
      用户组:
        <select name="UserGrade" id="UserGrade">
          <option value=""></option>
          <?
		$pid=$UserGrade;
		$sql3="select name,id,pid from ".$TableRole." where pid=0 order by id ";
			$query3=$db->query($sql3);
			$sql4="select name,id,pid from ".$TableRole." where pid<>0   " ;
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
        </select></td>
    <td>国家 :　　
      <select name="country" id="country">
        <option value="" ></option>
        <script language="javascript">
			for(i=0;i<countryArray.length;i++)
			{
				if('<?=$country?>'==countryArray[i]) 
					countrySelect="selected";
				else
					countrySelect="";
				document.write("<option "+countrySelect+" value='"+countryArray[i]+"'>"+countryArray[i]+"</option>");
			}
		  </script>
      </select></td>
    <td>性别:
      <select name="sex" id="sex">
        <option value=""></option>
        <?
		for($i=1;$i<=count($T_Gender);$i++)
		{
			 if((int)$sex==$i)
			 	echo "<option value='".$i."' selected>".$T_Gender[$i]."</option>";
			else
				echo "<option value='".$i."'>".$T_Gender[$i]."</option>";
		}
	?>
      </select></td>
    <td>用户名:
      <input type="text" size=10 name="username" value="<?=$username?>"></td>
    <td><input type='button'  class='button' onClick="javascript:query()" value='查询' ></td>
  </tr>
</table>

   </td>
   				    </tr>
              			<tr>
               				 <td colspan="2">
								<?
								echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
								echo "<tr class='tr1'  align=center ><td width=5% ></td><td>用户组</td><td>用户名</td><td>出生日期</td><td>国家</td><td>性别</td><td>注册日期</td><td width='15%' >&nbsp;</td></tr>";
								for($i=0;$i<count($result);$i++)
								{
				  					echo "<tr  onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
				  					echo "<td><input type='checkbox' name=checkvalue value='".$result[$i]['id']."'></td>";
				  					echo "<td  align='center'>";
				  					echo $result[$i]['manager_role_name'];
				  					echo "</td>";
				  					//echo "<td>".$result[$i]['nick_name']."</td>";//Nick Name
				  					echo "<td  align='center'>".$result[$i]['username']."</td>";//电子邮件
				  					echo "<td align='center'>".FormatDate($result[$i]['date_of_birth'])."</td>";//出生日期
				  					echo "<td  align='center'>".$result[$i]['country']."</td>";//市/县
				  					echo "<td  align='center'>";
				  							echo $T_Gender[$result[$i]['sex']];
				  					echo "</td>";
				  					echo "<td align='center'>".FormatDate($result[$i]['regtime'])."</td>";//Register Date
				  					echo "<td align='center'><a   href='javascript:remove(".$result[$i]['id'].")'>删除</a> <a href='javascript:edit(".$result[$i]['id'].")'>修改</a></td></tr>";
								}
				 				echo "</table>";
								?>
                			        </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
选择所有 <input type='button'  class='button' onClick="javascript:add()" value='添加'> <input type='button'  class='button' onClick="javascript:removeSelect()"  value='删除' ></td><td align="right"> 共 <?=$totalnum?> 条, 共 <?=$page_num?> 页, 第 <?=$page?> 页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
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
		location="manager_usersedit.php?id="+id;
	}

	function look(id){
		var form=form1;
		location="manager_userslook.php?id="+id;
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
		location="manager_usersadd.php";
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
