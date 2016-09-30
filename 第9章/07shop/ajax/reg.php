<? include "../db/Connect.php"?>
<?
/**
<? include "../lib/email/htmlMimeMail2.php" ?> 
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
<?
 			$indate=date('Y-m-j H:i:s');
			$UserGrade="10000";//User Group
			$username=$_POST['username'];//Email Address
			$EmailName=$_POST['EmailName'];//Email Address
			$psw=$_POST['psw'];//Password
			$date_of_birth=$_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'];//Date Of Birth
			$country=$_POST['country'];//Country
			$province_state=$_POST['province_state'];//Province/State
			$county=$_POST['county'];//County/City
			$zip_code=$_POST['zip_code'];//Zip Code
			$sex=$_POST['sex'];//Gender
			$my_website=$_POST['my_website'];//My Website
			$my_location=$_POST['my_location'];//My Location
			$introducton=$_POST['introducton'];//My interest&hobbies
			$upload_type="3";//Avatar Type
			$photo=$_POST['photo'];//Avatar Image
			$embed_photo=$_POST['embed_photo'];//Default Avatar
			$college_area=$_POST['college_area'];//College Area
			$college=$_POST['college'];//College
			$regtime=$indate;//Register Date
			$itemid="";//Item ID
			$last_updatetime=$indate;//Last Update Time
			$last_visittime=$indate;//Last Visited Time
			$views_count="0";//Views
			$comments_count="0";//Comments
			$send_msg_count="0";//Sent Messages
			$rev_msg_count="0";//Receive Messages
			$profile_views_count="0";//Profile Views
			$validate_code=$_POST['validate_code'];
		/*if($validate_code!=$_SESSION['SessionUser']["login_check_number"]||empty($validate_code))*/
			if( empty($validate_code))
			{
					echo "3";//input validate code error;
					return;
			}
		

		 $sql="select * from ".$TableAdmin." where username='".$username."' ";
		 $row=$db->getRow($sql);
		 if(empty($row['username']))
		 {
			$sql="insert into  ".$TableAdmin."(EmailName,UserGrade,username,psw,date_of_birth,country,province_state,county,zip_code,sex,my_website,my_location,introducton,upload_type,photo,embed_photo,college_area,college,regtime,itemid,last_updatetime,last_visittime,views_count,comments_count,send_msg_count,rev_msg_count,profile_views_count)values('".$EmailName."',".$UserGrade.",'".$username."','".$psw."','".$date_of_birth."','".$country."','".$province_state."','".$county."','".$zip_code."',".$sex.",'".$my_website."','".$my_location."','".$introducton."',".$upload_type.",'".$photo."','".$embed_photo."','".$college_area."','".$college."','".$regtime."','".$itemid."','".$last_updatetime."','".$last_visittime."',".$views_count.",".$comments_count.",".$send_msg_count.",".$rev_msg_count.",".$profile_views_count.")";

			$query=$db->query($sql);
			
		
			
			//发邮件
			/*
			$objEmail = new htmlMimeMail();
			$strFrom = $config_row['host_EmailName'];
			$to = $row['EmailName'];
			$strSubject = $WebSite_Name.":您的注册信息成功";
			
			$strText="您的用户名是".$row['username']."<br>";
			$strText.="您的密码是".$row['psw'];
			
			$objEmail->setFrom( $strFrom );
			$objEmail->setReturnPath( $strFrom );
			$objEmail->setSubject( $strSubject );
			$objEmail->setText($strText);
			*/
		    //$_SESSION['SessionAdminUser']=$row;
			if($query) echo "1";//注册成功
		}
		else
		{
			echo "2";//此用户已经存在
		}
?>
<? $db->close_db();?>