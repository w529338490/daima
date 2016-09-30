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
	  $sql="delete from ".$TableMenu_role."  where roleid=".$roleid;
	  $query=$db->query($sql);
	  
	  $firstcheck=explode('&',$ids);
	  $filter="";
	  for($i=0;$i<count($firstcheck)-1;$i++)
	  { 
	     $secondcheck=explode('-',$firstcheck[$i]);
		 $sql="insert into ".$TableMenu_role."(menuid,roleid,authorize)values(".$secondcheck[0].",".$roleid.",'".$secondcheck[1]."')";
	     $query=$db->query($sql);
	  }
	  echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	  echo "<script language='javascript'>alert('分配成功!');</script>";
	}
	
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
               				 <td ><input name="button2" type='button' class='button' onClick="javascript:configs()" value="提交" ></td>
               				 <td align="right" >&nbsp; </td>
              			</tr>
              			<tr>
               				 <td colspan="2">
								<?
									$sql="select a.*,b.menuid as menuid ,b.authorize from ".$TableMenu." as a left join ".$TableMenu_role." as b on a.id=b.menuid and b.roleid=".$roleid."   order by a.pid ";
									$result=$db->getAll($sql);
		        					echo "<table  class='contentsTable'  border='0'  cellpadding='0'  cellspacing='1' >";
									echo "<tr class='tr1' align=center ><td width=10% ></td><td  width=20% >菜单名称</td><td ></td></tr>";
									for($i=0;$i<count($result);$i++)
									{
										if($result[$i][pid]!="0") continue;
										if($result[$i]['is_user']=="2") continue;
										if($result[$i][pid]=="0")
										{
				  							echo "<tr class='tr2'>";
											if(!empty($result[$i][menuid]))
												echo "<td ><input type='checkbox'  name='id1' value='".$result[$i][id]."' id='id1' checked></td>";
											else
												echo "<td ><input type='checkbox' name='id1' value='".$result[$i][id]."' id='id1'></td>";
				  							echo "<td>".$result[$i][name]."</td>";
											echo "<td></td>";
				  							echo "</tr>";
											for($j=0;$j<count($result);$j++)
											{
												if($result[$j][pid]=="0") continue;
												if($result[$j]['is_user']=="2") continue;
										    	if($result[$i][id]==$result[$j][pid])
												{
													echo "<tr class='tr2'>";
													if(!empty($result[$j][menuid]))
														echo "<td align='right'><input type='checkbox' onclick='checkBoxAllfunc(this)' name='id2' value='".$result[$j][id].",".$result[$j][pid]."' id='id2' checked></td>";
													else
														echo "<td align='right'><input type='checkbox' onclick='checkBoxAllfunc(this)' name='id2' value='".$result[$j][id].",".$result[$j][pid]."' id='id2'></td>";
				  									echo "<td>".$result[$j][name]."</td>";
													echo "<td>";
													$func_id_array=explode(',',$result[$j][func_id]);
												    $func_name_array=explode(',',$result[$j][func_name]);
													$k=0;
													if(empty($result[$j][func_id]))
														$k=1;
													$authorize_array=explode(',',$result[$j][authorize]);//Function
												    for(;$k<count($func_id_array);$k++)
												    {
														if (in_array($func_id_array[$k],$authorize_array))
															echo "<input type='checkbox' name='id3' id='id3_".$result[$j][id]."' value='".$func_id_array[$k].",".$result[$j][id]."' checked >".$func_name_array[$k];
														else
															echo "<input type='checkbox' name='id3' id='id3_".$result[$j][id]."' value='".$func_id_array[$k].",".$result[$j][id]."' >".$func_name_array[$k];
												    }
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
						    选择所有 
					      <input name="button" type='button' class='button' onClick="javascript:configs()" value="提交" ></td>
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
  <input type="hidden" name="roleid" value=<?=$roleid?>>
   <input type="hidden" name="id" value="">
   <textarea name="ids" style="display:none; "></textarea>
</form>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
 function checkBoxAll()//选择所有
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
  
  function checkBoxAll2()//选择所有
 {
    var form = form1;
     for(i=0; i<form.elements.length; i++)
    {
        	if(form.elements[i].type=="checkbox" &&  (form.elements[i].name=="id1"||form.elements[i].name=="id2"||form.elements[i].name=="id3"))
        	{
                	form.elements[i].checked = form.cboAll2.checked;
       		}
    }
  }
  
  function checkBoxAllfunc(obj)//选择所有
 {
    var form = form1;
	var secondvalue=new Array();
	secondvalue=obj.value.split(",");
	id="id3_"+secondvalue[0];
     for(i=0; i<form.elements.length; i++)
    {
        	if(form.elements[i].type=="checkbox" &&  form.elements[i].id==id)
        	{
                	form.elements[i].checked = obj.checked;
       		}
    }
  }

  function configs(){
  	var form = form1;
		flag=false;
		form.ids.value="";
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].id=="id1" && form.elements[i].checked)
			{
				var firstvalue=new Array();
				firstvalue=form.elements[i].value.split(",");
				form.ids.value+=firstvalue[0]+"-"+"&";
			}
		}
		for(i=0; i<form.elements.length; i++)
		{
			if(form.elements[i].type=="checkbox" &&  form.elements[i].name=="id2" && form.elements[i].checked)
			{
				var secondvalue=new Array();
				secondvalue=form.elements[i].value.split(",");
				form.ids.value+=secondvalue[0]+"-";
				//Function
				for(j=0; j<form.elements.length; j++)
				{
					if(form.elements[j].type=="checkbox" &&  form.elements[j].name=="id3" && form.elements[j].checked)
					{
						var thirdvalue=new Array();
						thirdvalue=form.elements[j].value.split(",");
						if(secondvalue[0]==thirdvalue[1])
						{
							form.ids.value+=thirdvalue[0]+",";
						}
					}
				}
				form.ids.value+="&";
			}
		}
		form.status.value="configs";
		form.submit();
	}
</script>
<? $db->close_db();?>

 

