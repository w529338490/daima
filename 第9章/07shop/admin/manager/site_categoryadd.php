<? require "../../db/Connect.php"?>
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
    //Add
	$status=$_POST['status'];
	if($status=="add")
	{
		$indate=date('Y-n-j H:i:s');
		$name=$_POST['name'];
		 $sql="insert into  ".$TableSite_category."(id,name,pid)values(".$id.",'".$name."',0)";
		$query=$db->query($sql);
		
						
		$sql="select max(id) as id from  ".$TableSite_category;
		$rowMax=$db->getRow($sql);
		$nodepath="0,".$id;
		
		$sql="update ".$TableSite_category." set nodepath='".$nodepath."' where id=".$id;
		$query=$db->query($sql);
	}
	
	if($status=="addSub")
	{
			$sql="insert into ".$TableSite_category."(id,name,pid)values(".$id.",'".$name."',$pid)";
			$query=$db->query($sql);
			
									
			$sql="select max(id) as id from  ".$TableSite_category;
			$rowMax=$db->getRow($sql);
			$sql="select *  from  ".$TableSite_category." where id=".$pid;
			$rowParent=$db->getRow($sql);
			$nodepath=$rowParent['nodepath'].",".$id;
			
			$sql="update ".$TableSite_category." set nodepath='".$nodepath."' where id=".$id;
			$query=$db->query($sql);
	}
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script src="../../js/ShowDate.js"></script>
<script language="javascript">
    init();
</script>
</head>
<script language="javascript">
	function back()
	{
		location="site_category.php";
	}

	function Check()
	{
		var form=form1;
		if(!isIntegerPlus(form.id.value))
		{
			alert("Please input ID!");
			form.id.focus();
			return;
		}
		if(form.name.value=="")
		{
			alert("Please input sitename!");
			form.name.focus();
			return;
		}
		 form.status.value="add";
		 form.message.value=1;
		 form.submit();
  	}
	
	function addSub()
    {
		var form=form1;
		
		if(form.pid.value=="")
		{
			alert("Please select parent site!");
			form.pid.focus();
			return;
		}
		if(!isIntegerPlus(form.id.value))
		{
			alert("Please input ID!");
			form.id.focus();
			return;
		}
		if(form.name.value=="")
		{
			alert("Please input SiteName!");
			form.name.focus();
			return;
		}
		 form.status.value="addSub";
		 form.message.value=1;
		 form.submit();    
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
					<table  class="addTable"   border='0'  cellpadding='0'  cellspacing='1'>
              				<tr align="center"  class='tr2'>
               					 <td colspan="2">
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "添加成功";
                                                                    }
                                                               ?>
                                   </font>       				          </td>
              				</tr>
								<tr  class='tr2'>
                          <td >Parent Site:</td>
                          <td >
                            <select name="pid" id="pid">
							<option value=""></option>
                              <? 
	                         			$sql3="select * from ".$TableSite_category." where pid=0";
										$query3=$db->query($sql3);
										$sql4="select * from ".$TableSite_category." where pid<>0" ;
							            $result=$db->getAll($sql4);
										while($object3=$db->fetch_object($query3))
							 	  		{
										    $levelStr="";
										    $level_num=1;
											if($object3->id==$pid)
                          						echo "<option value='$object3->id' selected>".$object3->name."</option>";
                  							else
                          						echo "<option value='$object3->id' >".$object3->name."</option>";
											    for($i=0;$i<count($result);$i++)
												{
													for($j=0;$j<$level_num;$j++)
														$levelStr.="----";
													if($object3->id==$result[$i][pid])
													{
														if($result[$i][id]==$pid)
														{
															echo "<option value='".$result[$i][id]."' selected>";
															echo $levelStr.$result[$i][name];
															echo "</option>";
														}
														else
														{
															echo "<option value='".$result[$i][id]."'>";
															echo $levelStr.$result[$i][name];
															echo "</option>";
														}
														subCategory($result,$result[$i][id],$pid);
													}
													$levelStr="";
												}
                         			 	}
										
										function subCategory($result,$id,$pid)
										{
											global $level_num;
											$level_num++;
											
											for($i=0;$i<count($result);$i++)
											{
												$levelStr="";
												for($j=0;$j<$level_num;$j++)
													$levelStr.="----";
												if($id==$result[$i][pid])
												{
													if($result[$i][id]==$pid)
													{
														echo "<option value='".$result[$i][id]."' selected>";
														echo $levelStr.$result[$i][name];
														echo "</option>";
													}
													else
													{
														echo "<option value='".$result[$i][id]."'>";
														echo $levelStr.$result[$i][name];
														echo "</option>";
													}
													subCategory($result,$result[$i][id],$pid);
													$levelStr="";
												}
											}
											$level_num--;
										}
									?>
                            </select>                          </td>
                        </tr>
						<tr  class='tr2'>
									<td width="156" > 编号</td>
								  <td width="632" ><input name="id" type="text" id="id" ></td>
								</tr>
								<tr  class='tr2'>
									<td width="156" > SiteName:</td>
								  <td width="632" ><input name="name" type="text" id="name" ></td>
								</tr>
              				<tr  class='tr2'>
       				          <td colspan="2" align="center"><input type="button" style="width:80px;"  class="button" value="AddParent" onClick="Check()">       				            &nbsp;&nbsp;
&nbsp;
<input type="button"  class="button"  style="width:80px;" value="AddChild" onClick="addSub()">
&nbsp;      &nbsp;&nbsp;
      						    <input type="button"  class="button"  value="返回" onClick="back()">
   						      <label></label>						        </td>
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
<input type="hidden" name="message" value="">
</form>
</body>
</html>
<? $db->close_db();?>
 

