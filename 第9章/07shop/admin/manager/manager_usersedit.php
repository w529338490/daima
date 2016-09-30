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
	$status=$_POST['status'];
	if($status=="removePic")
	{
		$sql=" select * from ".$TableAdmin."  where id=".$id;
		$row=$db->getRow($sql);
		$FileName=$UploadPath."upload/manager_users/".$row['photo'];
		$FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$row['photo'];
		if(file_exists($FileName)&&!empty($row['photo']))
		{
			unlink($FileName);
			unlink($FileName_thumbnail);
		}
		$sql="update  ".$TableAdmin." set 	photo='' where id=".$id;
		$query=$db->query($sql);
	}
	if($status=="edit")
	{
		$indate=date('Y-m-j H:i:s');
		$id=$_POST['id'];//
		$UserGrade=$_POST['UserGrade'];//用户组
		$site_id=$_POST['site_id'];//Site ID
		$username=$_POST['username'];//电子邮件
		$psw=$_POST['psw'];//密码
		$date_of_birth=$_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'];//出生日期
		$country=$_POST['country'];//国家
		$province_state=$_POST['province_state'];//省份
		$county=$_POST['county'];//市/县
		$zip_code=$_POST['zip_code'];//邮政编码
		$sex=$_POST['sex'];//性别
		$my_website=$_POST['my_website'];//我的网站
		$my_location=$_POST['my_location'];//联系地址
		$introducton=$_POST['introducton'];//介绍
		$upload_type=$_POST['upload_type'];//上传类型
		$photo=$_POST['photo'];//照片
		$embed_photo=$_POST['embed_photo'];//Default Avatar
		$college_area=$_POST['college_area'];//College Area
		$college=$_POST['college'];//College
		$last_updatetime=$indate;//Last Update Time
			$photo_name = $_FILES["photo"]['name'];
			$photo=substr($photo_name,strrpos($photo_name,'.'),strlen($photo_name)-strrpos($photo_name,'.'));
			if(!empty($photo))
				$photo=getRandomNum().$photo;
			
			if(!empty($photo_name))
	    	{
				//delete old
				$sql="select * from  ".$TableAdmin."  where id=".$id;
			    $row=$db->getRow($sql);
			    $FileName=$UploadPath."upload/manager_users/".$row['photo'];
			    $FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$row['photo'];
			    if(file_exists($FileName)&&!empty($row['photo']))
				{
				   unlink($FileName);
				   unlink($FileName_thumbnail);
				}
					
				$sql="update  ".$TableAdmin." set 		true_name='".$true_name."',	telepnone='".$telepnone."',	moblie='".$moblie."',EmailName='".$EmailName."',		last_updatetime='".$last_updatetime."', UserGrade=".$UserGrade.",site_id='".$site_id."',	username='".$username."',	psw='".$psw."',	date_of_birth='".$date_of_birth."',	country='".$country."',	province_state='".$province_state."',	county='".$county."',	zip_code='".$zip_code."',	sex=".$sex.",	my_website='".$my_website."',	my_location='".$my_location."',	introducton='".$introducton."',	upload_type=".$upload_type.",	photo='".$photo."',	embed_photo='".$embed_photo."',	college_area='".$college_area."',	college='".$college."'  where id=".$id;
				$query=$db->query($sql);
				if($query)
				{
					$FileName=$UploadPath."upload/manager_users/".$photo;
					$FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$photo;
					$photo = $_FILES['photo']['tmp_name'];
			   		if(copy($photo,$FileName))
			  	 	{
				  		unlink($photo);
			   		}
					ImageResize($FileName,$config_row['user_thumbnail_width'],$config_row['user_thumbnail_height'],$FileName_thumbnail);
					

				}
			}
			else
			{
				$sql="update  ".$TableAdmin." set 		true_name='".$true_name."',	telepnone='".$telepnone."',	moblie='".$moblie."',EmailName='".$EmailName."',		last_updatetime='".$last_updatetime."',	UserGrade=".$UserGrade.",	site_id='".$site_id."',	username='".$username."',	psw='".$psw."',	date_of_birth='".$date_of_birth."',	country='".$country."',	province_state='".$province_state."',	county='".$county."',	zip_code='".$zip_code."',	sex=".$sex.",	my_website='".$my_website."',	my_location='".$my_location."',	introducton='".$introducton."',	upload_type=".$upload_type.",	embed_photo='".$embed_photo."',	college_area='".$college_area."',	college='".$college."'  where id=".$id;
				$query=$db->query($sql);
			}
			$message='1';
			//echo $sql;
	}
	$sql="select * from  ".$TableAdmin."  where id=".$id;
	$row=$db->getRow($sql);
?>
<html>
<head>
<title><?=$TitleName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/check.js"></script>
<link href="../../css/date.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/country.js"></script>
</head>
<script language="javascript">
	function back()
	{
		location="manager_users.php";
	}

	function winclose()
	{
		window.opener.location.reload();
		window.close();
	}

	function Check()
	{
		var form=form1;
		/*if(!isCharVar(form.nick_name.value)||form.nick_name.value.length<3||form.nick_name.value.length>15)
		{
			alert("Your Nick Name must be 3 - 15 characters long !");
			form.nick_name.focus();
			return;
		}*/
		if(!isCharVar(form.username.value)||form.username.value.length<3||form.username.value.length>15)
		{
			alert("用户名必须 3 - 15字符!");
			form.username.focus();
			return;
		}
		if(form.psw.value.length<6||form.psw.value.length>15)
		{
			alert("密码必须 6 - 15字符和数字 !");
			form.psw.focus();
			return;
		}
		if(form.psw.value!=form.psw1.value)
		{
			alert("两次密码输入不正确 !");
			form.psw1.focus();
			return;
		}
		if(!isEmail(form.EmailName.value))
		{
			alert("请输入有效的邮箱地址!");
			form.EmailName.focus();
			return;
		}
		if(form.birth_month.value=="")
		{
			alert("请选择出生月份!");
			form.birth_month.focus();
			return;
		}
		if(form.birth_day.value=="")
		{
			alert("请选择出生日!");
			form.birth_day.focus();
			return;
		}
		if(form.birth_year.value=="")
		{
			alert("请选择出生年!");
			form.birth_year.focus();
			return;
		}
		if(form.country.value=="")
		{
			alert("请选择国家!");
			form.country.focus();
			return;
		}
		/*if(form.zip_code.value=="")
		{
			alert("Please enter your 邮政编码!");
			form.zip_code.focus();
			return;
		}*/
		 form.status.value="edit";
		 form.submit();
  	}
  	function removePic()
  	{
  		var form=form1;
  		if(confirm("真的想要删除吗?")==false)
  			return;
  		form.status.value="removePic";
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
            		<td align="center" class="addborder">
					<table  class="addTable"  border='0'  cellpadding='0'  cellspacing='1'>
								<tr align="center"  class='tr2' >
									<td colspan="2">
										<font  class="message">
										<?
											if($message=="1")
											{
												echo "修改成功!";
											}
										?>
										</font>									</td>
								</tr>
								<tr  class='tr2' >
									<td >用户组<span class="star">*</span>:</td>
								  <td ><select name="UserGrade" id="UserGrade">
                                    <option value=""></option>
                                    <?
											$pid=$row['UserGrade'];
											$sql3="select name,id,pid from ".$TableRole." where pid=0 order by id ";
												$query3=$db->query($sql3);
												$sql4="select name,id,pid from ".$TableRole." where pid<>0  " ;
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
								</tr>
								<tr  class='tr2' style="display:none;"  >
									<td >Site 编号</td>
									<td ><input name="site_id" type="text" id="site_id"  value="<?=$row['site_id']?>" ></td>
								</tr>
								<tr  class='tr2' >
									<td >用户名<span class="star">*</span>:</td>
								  <td ><input name="username" type="text" id="username"  value="<?=$row['username']?>" ></td>
								</tr>
								<tr class='tr2'  >
									<td >密码:</td>
									<td ><input type="password" name="psw"  value="<?=$row['psw']?>" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >重输密码<span class="star">*</span>:</td>
									<td ><input type="password" name="psw1" value="<?=$row['psw']?>" ></td>
								</tr>
                                <tr  class='tr2' >
									<td >电子邮件<span class="star">*</span>:</td>
								  <td ><input name="EmailName" type="text" id="EmailName"  value="<?=$row['EmailName']?>"  ></td>
								</tr>
                                <?
								 $date_of_birthArray=explode('-',$row['date_of_birth']);
								?>
								<tr  class='tr2' >
									<td >出生日期<span class="star">*</span>:</td>
								  <td ><select name="birth_month" id="birth_month" >
                                    <option value="">--</option>
                                    <script language="javascript">
									  	monthsArray=getMonths();
										var birthSelect="";
										for(i=0;i<monthsArray.length;i++)
										{
											if(<?=$date_of_birthArray[1]?>==monthsArray[i]) 
											    birthSelect="selected";
											else
												birthSelect="";
											
											document.write("<option "+birthSelect+" value='"+monthsArray[i]+"'>"+monthsArray[i]+"</option>");
										}
									</script>
                                  </select>
                                    <select name="birth_day" id="birth_day" >
                                      <option value="">--</option>
                                      <script language="javascript">
									  	daysArray=getDays();
										for(i=0;i<daysArray.length;i++)
										{
											if(<?=$date_of_birthArray[2]?>==daysArray[i]) 
											    birthSelect="selected";
											else
												birthSelect="";
											document.write("<option "+birthSelect+"  value="+daysArray[i]+">"+daysArray[i]+"</option>");
										}
									  </script>
                                    </select>
                                    <select name="birth_year" id="birth_year" >
                                      <option value="">--</option>
                                      <script language="javascript">
									  	yearsArray=getYears();
										for(i=0;i<yearsArray.length;i++)
										{
											if(<?=$date_of_birthArray[0]?>==yearsArray[i]) 
											    birthSelect="selected";
											else
												birthSelect="";
											document.write("<option "+birthSelect+"   value='"+yearsArray[i]+"'>"+yearsArray[i]+"</option>");
										}
									  </script>
                                    </select></td>
								</tr>
								<tr  class='tr2' >
									<td >国家<span class="star">*</span>:</td>
								  <td ><select name="country" id="country">
                                    <option value="" >--</option>
                                    <script language="javascript">
										for(i=0;i<countryArray.length;i++)
										{
											if('<?=$row['country']?>'==countryArray[i]) 
											    countrySelect="selected";
											else
												countrySelect="";
											document.write("<option "+countrySelect+" value='"+countryArray[i]+"'>"+countryArray[i]+"</option>");
										}
									  </script>
                                  </select></td>
								</tr>
								<tr  class='tr2'  style="display:none;" >
									<td >省份:</td>
									<td ><input name="province_state" type="text" id="province_state"  value="<?=$row['province_state']?>" ></td>
								</tr>
								<tr  class='tr2' style="display:none;"  >
									<td >市/县:</td>
									<td ><input name="county" type="text" id="county"  value="<?=$row['county']?>" ></td>
								</tr>
                                <tr  class='tr2' >
									<td >姓名:</td>
								    <td ><input name="true_name" type="text" id="true_name" value="<?=$row['true_name']?>" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >电话:</td>
								    <td ><input name="telepnone" type="text" id="telepnone" value="<?=$row['telepnone']?>" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >手机:</td>
								    <td ><input name="moblie" type="text" id="moblie" value="<?=$row['moblie']?>" ></td>
								</tr>
								<tr  class='tr2'  style="display:none;">
									<td >邮政编码<span class="star">*</span>:</td>
								  <td ><input name="zip_code" type="text" id="zip_code"  value="<?=$row['zip_code']?>" ></td>
								</tr>
								<tr  class='tr2' >
									<td >性别:</td>
									<td >									<?
										for($i=1;$i<=count($T_Gender);$i++)
										{
											if((int)$row['sex']==$i)
												echo "<input name='sex' type='radio' checked  value='".$i."'>".$T_Gender[$i];
											else
												echo "<input name='sex' type='radio'   value='".$i."'>".$T_Gender[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2' >
									<td >我的网站:</td>
									<td ><input name="my_website" type="text" id="my_website"  value="<?=$row['my_website']?>" size="70" ></td>
								</tr>
								<tr  class='tr2' >
									<td >联系地址:</td>
									<td ><input name="my_location" type="text" id="my_location"  value="<?=$row['my_location']?>" size="70" ></td>
								</tr>
								<tr  class='tr2' >
									<td  width=100>介绍:</td>
									<td ><textarea name="introducton" cols="70" rows="10" id="introducton"><?=$row['introducton']?></textarea></td>
								</tr>
								<tr  class='tr2' >
									<td >上传类型:</td>
									<td >									<?
										for($i=1;$i<=count($T_Avatar_Type);$i++)
										{
											if((int)$row['upload_type']==$i)
												echo "<input name='upload_type' onClick='picture_change(".$i.")'  type='radio' checked  value='".$i."'>".$T_Avatar_Type[$i];
											else
												echo "<input name='upload_type' onClick='picture_change(".$i.")'  type='radio'   value='".$i."'>".$T_Avatar_Type[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2'  id='tr_photo' <? if((int)$row['upload_type']==2) echo " style='display:none;'"; ?> >
									<td >照片:</td>
									<td >									<?									if(!empty($row['photo']))									{									?>									<a href="../../upload/manager_users/<?=$row['photo']?>" target="_blank"><img width="<?=$config_row['user_thumbnail_width']?>" height="<?=$config_row['user_thumbnail_height']?>"  src="../../upload/manager_users/<?="thumbnail_".$row['photo']?>" border="0" ></a> 
									  <input type="button" class='button' onClick="removePic()" value="删除">
  									<?									}									?>									<br><input type="file" name="photo"  id="photo"></td>
					  </tr>
								<tr  class='tr2'   id='tr_embed_photo' <? if((int)$row['upload_type']==1) echo " style='display:none;'"; ?>  >
									<td >照片嵌入地址:</td>
								    <td ><a href="<?=$row['embed_photo']?>" target="_blank"><img width="100" height="80"  src="<?=$row['embed_photo']?>" border="0" ></a>
							      <br><input name="embed_photo" type="text" id="embed_photo"  value="<?=$row['embed_photo']?>" size="70" ></td>
					  </tr>
                                <script language="javascript">
									function picture_change(flag)
									{
										if(flag==1)
										{
											document.getElementById('tr_photo').style.display="";
											document.getElementById('tr_embed_photo').style.display="none";
										}
										if(flag==2)
										{
											document.getElementById('tr_photo').style.display="none";
											document.getElementById('tr_embed_photo').style.display="";
										}
									}
								</script>
              				<tr  class='tr2' >
                				        <td colspan="2" align="center">
							     <input type="button"  class='button' name="Button" value="提交" onClick="Check()">
							    &nbsp;&nbsp;&nbsp;&nbsp;
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="javascript:back()">						        </td>
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
