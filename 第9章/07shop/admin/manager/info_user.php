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

	if($status=="configs")
	{
	  $sql="update  ".$TableAdmin." set itemid='".$ids."'  where id=".$id;
	  $query=$db->query($sql);
	  echo "<script language='javascript'>alert('栏目权限分配成功!');</script>";
	}
	
	$sql="select * from ".$TableAdmin."  where id=".$id;
	$row=$db->getRow($sql);
	$itemid=explode(',',$row["itemid"]);

?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
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
              			<tr>
               				 <td ><input name="button2" type='button' class='button' onClick="javascript:configs()" value="分配" ></td>
               				 <td align="right" >&nbsp; </td>
              			</tr>
              			<tr>
               				 <td colspan="2">
								<?
									$sql="select * from ".$TableInfo_category."  order by pid ";
									$result=$db->getAll($sql);
		        					echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
									echo "<tr class='tr1' align=center ><td width=10% ></td><td  width=20% >栏目名称</td><td >功能</td></tr>";
									for($i=0;$i<count($result);$i++)
									{
										if($result[$i][pid]!="0") continue;
										if($result[$i][pid]=="0")
										{
				  							echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
											if(in_array($result[$i][id],$itemid))
												echo "<td ><input type='checkbox'  name='id1' value='".$result[$i][id]."' id='id1' checked></td>";
											else
												echo "<td ><input type='checkbox' name='id1' value='".$result[$i][id]."' id='id1'></td>";
				  							echo "<td>".$result[$i][name]."</td>";
											echo "<td></td>";
				  							echo "</tr>";
											for($j=0;$j<count($result);$j++)
											{
												if($result[$j][pid]=="0") continue;
										    	if($result[$i][id]==$result[$j][pid])
												{
													echo "<tr   onMouseOver=\"old_bg=this.getAttribute('bgcolor');this.setAttribute('bgcolor', '".$T_Bgcolor[1]."', 0);\" onMouseOut=\"this.setAttribute('bgcolor', old_bg, 0);\" bgColor='".$T_Bgcolor[2]."' >";
													if(in_array($result[$j][id],$itemid))
														echo "<td align='right'><input type='checkbox' onclick='checkBoxAllfunc(this)' name='id2' value='".$result[$j][id]."' id='id2' checked></td>";
													else
														echo "<td align='right'><input type='checkbox' onclick='checkBoxAllfunc(this)' name='id2' value='".$result[$j][id]."' id='id2'></td>";
				  									echo "<td>".$result[$j][name]."</td>";
													echo "<td>";
													
													echo "</td>";
				  									echo "</tr>";
												}
											}
										}
									}
				 					echo "</table>";
			 					?>
       			          </td>
              			</tr>
              			<tr>
						<td>
							  <input name="cboAll" type="checkbox" id="cboAll" value="checkbox" onClick="checkBoxAll()">
						    全选栏目 
						     <input name="button" type='button' class='button' onClick="javascript:configs()" value="分配" ></td>
       			          <td align="right">&nbsp;						</td>
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
  <input type="hidden" name="id" value=<?=$id?>>
   <textarea name="ids" style="display:none; "></textarea>
</form>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
 function checkBoxAll()//全选
 {
    var form = form1;
     for(i=0; i<form.elements.length; i++)
	{
		if(form.elements[i].type=="checkbox" &&  (form.elements[i].name=="id1"||form.elements[i].name=="id2"))
		{
				form.elements[i].checked = form.cboAll.checked;
		}
	}
  }
  
  function checkBoxAll2()//全选
 {
    var form = form1;
     for(i=0; i<form.elements.length; i++)
    {
        	if(form.elements[i].type=="checkbox" &&  (form.elements[i].name=="id1"||form.elements[i].name=="id2"))
        	{
                	form.elements[i].checked = form.cboAll2.checked;
       		}
    }
  }
  
  function checkBoxAllfunc(obj)//全选
 {
    
  }

  function configs()
  {
  		var form = form1;
		flag=false;
		form.ids.value="";
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" && ( form.elements[i].id=="id1"||form.elements[i].id=="id2") && form.elements[i].checked)
			{
				form.ids.value+=form.elements[i].value+",";
			}
		}
		if(form.ids.value!="")
		{
			form.ids.value=form.ids.value.substring(0,form.ids.value.lastIndexOf(","));
		}
		form.status.value="configs";
		form.submit();
	}
</script>
<? $db->close_db();?>