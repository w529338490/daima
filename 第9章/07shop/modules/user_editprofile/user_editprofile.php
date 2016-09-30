<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
	$status=$_POST['status'];
	if($status=="removePic")
	{
		$sql=" select * from ".$TableAdmin."  where   username='".$_SESSION['SessionUser']['username']."'";
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
		$UserGrade=$_POST['UserGrade'];//User Group
		$site_id=$_POST['site_id'];//Site ID
		$username=$_POST['username'];//Email Address
		$psw=$_POST['psw'];//Password
		$date_of_birth=$_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'];//Date Of Birth
		$country=$_POST['country'];//Country
		$province_state=$_POST['province_state'];//Province/State
		$county=$_POST['county'];//County/City
		$zip_code=$_POST['zip_code'];//Zip Code
		$sex=$_POST['sex'];//Gender
		$my_website=$_POST['my_website'];//My Website
		$my_location=$_POST['my_location'];//My Location
		$introducton=$_POST['introducton'];//Introducton
		$upload_type=$_POST['upload_type'];//Upload Type
		$photo=$_POST['photo'];//Photo
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
					
				$sql="update  ".$TableAdmin." set true_name='".$true_name."',	telepnone='".$telepnone."',	moblie='".$moblie."',	EmailName='".$EmailName."',		last_updatetime='".$last_updatetime."',date_of_birth='".$date_of_birth."',	country='".$country."',	province_state='".$province_state."',	county='".$county."',	zip_code='".$zip_code."',	sex=".$sex.",	my_website='".$my_website."',	my_location='".$my_location."',	introducton='".$introducton."',	upload_type=".$upload_type.",	photo='".$photo."',	embed_photo='".$embed_photo."',	college_area='".$college_area."',	college='".$college."'  where   username='".$_SESSION['SessionUser']['username']."'";
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
				$sql="update  ".$TableAdmin." set 	true_name='".$true_name."',	telepnone='".$telepnone."',	moblie='".$moblie."',EmailName='".$EmailName."',		last_updatetime='".$last_updatetime."',	date_of_birth='".$date_of_birth."',	country='".$country."',	province_state='".$province_state."',	county='".$county."',	zip_code='".$zip_code."',	sex=".$sex.",	my_website='".$my_website."',	my_location='".$my_location."',	introducton='".$introducton."',	upload_type=".$upload_type.",	embed_photo='".$embed_photo."',	college_area='".$college_area."',	college='".$college."'  where   username='".$_SESSION['SessionUser']['username']."'";
				$query=$db->query($sql);
			}
			$message=1;
			//echo $sql;
	}
?>
<link href="<?=$SETUPFOLDER?>/modules/user_editprofile/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td  class="user_editprofile_container">
     <?
		//profile_views_count count
		$sql="update  ".$TableAdmin." set profile_views_count=profile_views_count+1 where  username='".$_SESSION['SessionUser']['username']."'";
		$query=$db->query($sql);
		$sql="select * from  ".$TableAdmin."  where username='".$_SESSION['SessionUser']['username']."'";
		$row=$db->getRow($sql);
	  ?>
    	  <script language="javascript">
								
			function CheckUserEdit()
			{
				var form=document.getElementById("form1");
				
				
				if(!isEmail(form.EmailName.value))
				{
					alert("请输入有效的邮箱地址 !");
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
				 form.status.value="edit";
				 form.submit();
			}
			function removePic()
			{
				var form=document.getElementById("form1");
				if(confirm("真的想要删除吗?")==false)
					return;
				form.status.value="removePic";
				form.submit();
			}
		</script>
    	   <table  class="user_editprofile_table"  width="100%" border='0'  cellpadding='0'  cellspacing='0'>
             <tr align="center"  class='user_editprofile_tr' >
               <td colspan="2">
               <font  class="message">
                 <?
					if($message=="1")
					{
						echo "修改成功!";
					}
				?>
               </font>
                </td>
             </tr>

             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">用户名<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><?=$row['username']?></td>
             </tr>

             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">电子邮箱<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box" name="EmailName" type="text" id="EmailName"  value="<?=$row['EmailName']?>" /></td>
             </tr>
             <?
								 $date_of_birthArray=explode('-',$row['date_of_birth']);
								?>
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">出生日期<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><select name="birth_month" id="birth_month" >
                   <option value="">--</option>
                   <script language="JavaScript" type="text/javascript">
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
                     <script language="JavaScript" type="text/javascript">
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
                     <script language="JavaScript" type="text/javascript">
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
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">国家<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><select name="country" id="country">
                   <option value="" >--</option>
                   <script language="JavaScript" type="text/javascript">
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
             <tr  class='user_editprofile_tr'  style="display:none;" >
               <td  class="user_editprofile_td_title">省份:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="province_state" type="text" id="province_state"  value="<?=$row['province_state']?>" /></td>
             </tr>
             <tr  class='user_editprofile_tr' style="display:none;"  >
               <td  class="user_editprofile_td_title">城市:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="county" type="text" id="county"  value="<?=$row['county']?>" /></td>
             </tr>
             <tr  class='user_editprofile_tr'  style="display:none;">
               <td  class="user_editprofile_td_title">邮政编码<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="zip_code" type="text" id="zip_code"  value="<?=$row['zip_code']?>" /></td>
             </tr>
              <tr  class='user_editprofile_tr'>
               <td  class="user_editprofile_td_title">姓名<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="true_name" type="text" id="true_name"  value="<?=$row['true_name']?>" /></td>
             </tr>
              <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">电话<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="telepnone" type="text" id="telepnone"  value="<?=$row['telepnone']?>" /></td>
             </tr>
              <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">手机<span class="star">*</span>:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="moblie" type="text" id="moblie"  value="<?=$row['moblie']?>" /></td>
             </tr>
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">性别:</td>
               <td  class="user_editprofile_td_box"><?
										for($i=1;$i<=count($T_Gender);$i++)
										{
											if((int)$row['sex']==$i)
												echo "<input name='sex' type='radio' checked  value='".$i."'>".$T_Gender[$i];
											else
												echo "<input name='sex' type='radio'   value='".$i."'>".$T_Gender[$i];
										}
									?>               </td>
             </tr>
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">我的网站:</td>
               <td  class="user_editprofile_td_box"><input class="user_editprofile_box"  name="my_website" type="text" id="my_website"  value="<?=$row['my_website']?>" size="30" /></td>
             </tr>
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">地址:</td>
               <td class="user_editprofile_td_box" ><input class="user_editprofile_box"  name="my_location" type="text" id="my_location"  value="<?=$row['my_location']?>" size="30" /></td>
             </tr>
             <tr  class='user_editprofile_tr' >
               <td   class="user_editprofile_td_title">简介:</td>
               <td  class="user_editprofile_td_box"><textarea class="user_editprofile_box"  name="introducton" cols="30" rows="5" id="introducton"><?=$row['introducton']?>
           </textarea></td>
             </tr>
             <tr  class='user_editprofile_tr' >
               <td  class="user_editprofile_td_title">上传类型:</td>
               <td  class="user_editprofile_td_box"><?
										for($i=1;$i<=count($T_Avatar_Type);$i++)
										{
											if((int)$row['upload_type']==$i)
												echo "<input name='upload_type' onClick='Photo_change(".$i.")'  type='radio' checked  value='".$i."'>".$T_Avatar_Type[$i];
											else
												echo "<input name='upload_type' onClick='Photo_change(".$i.")'  type='radio'   value='".$i."'>".$T_Avatar_Type[$i];
										}
									?>               </td>
             </tr>
             <tr  class='user_editprofile_tr'  id='tr_photo' <? if((int)$row['upload_type']==2) echo " style='display:none;'"; ?> >
               <td  class="user_editprofile_td_title">照片:</td>
               <td  class="user_editprofile_td_box"><?									if(!empty($row['photo']))									{									?>
                   <a href="upload/manager_users/<?=$row['photo']?>" target="_blank"><img width="<?=$config_row['user_thumbnail_width']?>" height="<?=$config_row['user_thumbnail_height']?>"  src="upload/manager_users/<?="thumbnail_".$row['photo']?>" border="0" /></a>
                   <input   type="button" class='user_editprofile_button' onclick="removePic()" value="删除" />
                   <?									}									?>
                   <br />
                 <input class="user_editprofile_box"  type="file" name="photo"  id="photo" /></td>
             </tr>
             <tr  class='user_editprofile_tr'   id='tr_embed_photo' <? if((int)$row['upload_type']==1) echo " style='display:none;'"; ?>  >
               <td  class="user_editprofile_td_title">照片嵌入地址:</td>
               <td  class="user_editprofile_td_box"><a href="<?=$row['embed_photo']?>" target="_blank"><img width="100" height="80"  src="<?=$row['embed_photo']?>" border="0" /></a> <br />
                   <input class="user_editprofile_box"  name="embed_photo" type="text" id="embed_photo"  value="<?=$row['embed_photo']?>" size="30" /></td>
             </tr>
             <script language="JavaScript" type="text/javascript">
									function Photo_change(flag)
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
             <tr  class='user_editprofile_tr' >
               <td colspan="2" align="center"><input type="button"  class='user_editprofile_button' name="Button" value="提交" onclick="CheckUserEdit()" /></td>
             </tr>
           </table>
           
           </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>
<input type="hidden" name="status" value="">