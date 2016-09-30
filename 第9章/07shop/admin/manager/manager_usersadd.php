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
    //add
	$status=$_POST['status'];
	if($status=="add")
	{
		 $sql="select username from ".$TableAdmin." where username='$username' ";
		$row=$db->getRow($sql);
		if(empty($row['username']))
		{
			 
			$indate=date('Y-m-j H:i:s');
			$UserGrade=$_POST['UserGrade'];//用户组
			$username=$_POST['username'];//电子邮件
			$EmailName=$_POST['EmailName'];//电子邮件
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
			$regtime=$indate;//Register Date
			$itemid="";//Item ID
			$last_updatetime=$indate;//Last Update Time
			$last_visittime=$indate;//Last Visited Time
			$views_count="0";//Views
			$comments_count="0";//Comments
			$send_msg_count="0";//Sent Messages
			$rev_msg_count="0";//Receive Messages
			$profile_views_count="0";//Profile Views
			$photo_name = $_FILES["photo"]['name'];
			$photo=substr($photo_name,strrpos($photo_name,'.'),strlen($photo_name)-strrpos($photo_name,'.'));
			if(!empty($photo))
				$photo=getRandomNum().$photo;
	
			 $sql="insert into  ".$TableAdmin."(true_name,telepnone,moblie,EmailName,UserGrade,username,psw,date_of_birth,country,province_state,county,zip_code,sex,my_website,my_location,introducton,upload_type,photo,embed_photo,college_area,college,regtime,itemid,last_updatetime,last_visittime,views_count,comments_count,send_msg_count,rev_msg_count,profile_views_count)values('".$true_name."','".$telepnone."','".$moblie."','".$EmailName."',".$UserGrade.",'".$username."','".$psw."','".$date_of_birth."','".$country."','".$province_state."','".$county."','".$zip_code."',".$sex.",'".$my_website."','".$my_location."','".$introducton."',".$upload_type.",'".$photo."','".$embed_photo."','".$college_area."','".$college."','".$regtime."','".$itemid."','".$last_updatetime."','".$last_visittime."',".$views_count.",".$comments_count.",".$send_msg_count.",".$rev_msg_count.",".$profile_views_count.")";
			$query=$db->query($sql);
			if($query&&!empty($photo_name))
			{
				$FileName=$UploadPath."upload/manager_users/".$photo;
				$FileName_thumbnail=$UploadPath."upload/manager_users/thumbnail_".$photo;
				$photo = $_FILES['photo']['tmp_name'];
			   if(copy($photo,$FileName))
			   {
				  unlink($photo);
			   }
			   ImageResize($FileName,$config_row['user_thumbnail_width'],$config_row['user_thumbnail_height'],$FileName_thumbnail);

			   $message=1;
			}
		}
		else
		{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo "<script language='javascript'>alert('用户名已经存在!');</script>";
		}
		
		//echo $sql;
	}
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
		 form.status.value="add";
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
					<table  class="addTable"  border='0'  cellpadding='0'  cellspacing='1'>
              				<tr align="center"  class='tr2' >
               					 <td colspan="2">
                  					<font  class="message">
                                                               <?
                                                                    if($message=="1")
                                                                    {
                                                                        echo "添加成功 ";
                                                                    }
                                                               ?>
                                                          </font>                				         </td>
              				</tr>
								<tr  class='tr2' >
									<td >用户组<span class="star">*</span>:</td>
								  <td ><select name="UserGrade" id="UserGrade">
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
								</tr>
								<tr  class='tr2' style="display:none;" >
									<td >Site 编号</td>
									<td ><input name="site_id" type="text" id="site_id" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >用户名<span class="star">*</span>:</td>
								    <td ><input name="username" type="text" id="username" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >密码<span class="star">*</span>:</td>
								  <td ><input type="password" name="psw"></td>
								</tr>
                                <tr  class='tr2' >
									<td >重输密码<span class="star">*</span>:</td>
									<td ><input type="password" name="psw1"></td>
								</tr>
                                <tr  class='tr2' >
									<td >电子邮件<span class="star">*</span>:</td>
								  <td ><input name="EmailName" type="text" id="EmailName" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >出生日期<span class="star">*</span>:</td>
								  <td ><select name="birth_month" id="birth_month" >
                                  <option value="">--</option>
                                      <script language="javascript">
									  	monthsArray=getMonths();
										for(i=0;i<monthsArray.length;i++)
										{
											document.write("<option value='"+monthsArray[i]+"'>"+monthsArray[i]+"</option>");
										}
									  </script>
                                    </select>
                                      <select name="birth_day" id="birth_day" >
                                      <option value="">--</option>
                                        <script language="javascript">
									  	daysArray=getDays();
										for(i=0;i<daysArray.length;i++)
											document.write("<option value="+daysArray[i]+">"+daysArray[i]+"</option>");
									  </script>
                                      </select>
                                      <select name="birth_year" id="birth_year" >
                                      <option value="">--</option>
                                        <script language="javascript">
									  	yearsArray=getYears();
										for(i=0;i<yearsArray.length;i++)
											document.write("<option value='"+yearsArray[i]+"'>"+yearsArray[i]+"</option>");
									  </script>
                                      </select></td>
								</tr>
								<tr  class='tr2' >
									<td >国家<span class="star">*</span>:</td>
								  <td >
									<select name="country" id="country">
                                    <option value="" >--</option>
                                    <script language="javascript">
										for(i=0;i<countryArray.length;i++)
											document.write("<option value='"+countryArray[i]+"'>"+countryArray[i]+"</option>");
									  </script>
									</select>									</td>
								</tr>
								<tr  class='tr2'  style="display:none;">
									<td >省份:</td>
									<td ><input name="province_state" type="text" id="province_state" value="" ></td>
								</tr>
								<tr  class='tr2'  style="display:none;">
									<td >市/县:</td>
									<td ><input name="county" type="text" id="county" value="" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >姓名:</td>
								    <td ><input name="true_name" type="text" id="true_name" value="" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >电话:</td>
								    <td ><input name="telepnone" type="text" id="telepnone" value="" ></td>
								</tr>
                                 <tr  class='tr2' >
									<td >手机:</td>
								    <td ><input name="moblie" type="text" id="moblie" value="" ></td>
								</tr>
								<tr  class='tr2'  style="display:none;">
									<td >邮政编码<span class="star">*</span>:</td>
								  <td ><input name="zip_code" type="text" id="zip_code" value="" ></td>
								</tr>
								<tr  class='tr2' >
									<td >性别:</td>
									<td >									<?
										for($i=1;$i<=count($T_Gender);$i++)
										{
											if((int)$sex==$i||(empty($sex)&&$i==1))
												echo "<input name='sex' type='radio' checked  value='".$i."'>".$T_Gender[$i];
											else
												echo "<input name='sex' type='radio'   value='".$i."'>".$T_Gender[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2' >
									<td >我的网站:</td>
									<td ><input name="my_website" type="text" id="my_website" value="" size="70" ></td>
								</tr>
								<tr  class='tr2' >
									<td >联系地址:</td>
									<td ><input name="my_location" type="text" id="my_location" value="" size="70" ></td>
								</tr>
								<tr  class='tr2' >
									<td >介绍:</td>
									<td ><textarea name="introducton" cols="70" rows="10" id="introducton"></textarea></td>
								</tr>
								<tr  class='tr2' >
									<td >上传类型:</td>
									<td >									<?
										for($i=1;$i<=count($T_Avatar_Type);$i++)
										{
											if((int)$upload_type==$i||(empty($upload_type)&&$i==1))
												echo "<input name='upload_type' onClick='picture_change(".$i.")' type='radio' checked  value='".$i."'>".$T_Avatar_Type[$i];
											else
												echo "<input name='upload_type' onClick='picture_change(".$i.")'  type='radio'   value='".$i."'>".$T_Avatar_Type[$i];
										}
									?>									</td>
								</tr>
								<tr  class='tr2' id='tr_photo' >
									<td >照片:</td>
									<td ><input type="file" name="photo"  id="photo"></td>
								</tr>
								<tr  class='tr2'  style="display:none;" id='tr_embed_photo'>
									<td >照片嵌入地址:</td>
									<td ><input name="embed_photo" type="text" id="embed_photo" value="http://" size="70" ></td>
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
      						    <input type="button"  class='button' name="Submit2" value="返回" onClick="back()">						        </td>
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
</form>
</body>
</html>
<? $db->close_db();?>
