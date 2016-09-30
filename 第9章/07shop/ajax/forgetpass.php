<?php include "../db/Connect.php"?>
<? include "../db/htmlMimeMail2.php" ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.
 */
 ?>
<?  // 您好
			$psw_username=$_POST['psw_username'];
			$sql="select * from  ".$TableUser."  where username='".$psw_username."'";
			$row=$db->getRow($sql);
			if(!empty($row['EmailName']))
			{
				$objEmail = new htmlMimeMail();
				$strFrom = $config_row['host_email'];
				$to = $row['EmailName'];
				$strSubject = "Your Password information<br><br>";
				
				$strText.="Your password : ".$row['psw'];
				
				$objEmail->setFrom( $strFrom );
				$objEmail->setReturnPath( $strFrom );
				$objEmail->setSubject( $strSubject );
				$objEmail->setText($strText);
				if($objEmail->send(explode( ',', "$to" )))
					echo "1";
				else
					echo "3";
			}
			else
			{
				echo "2";
			}
?>
<? $db->close_db();?>