<? include "../db/Connect.php"?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
<?
		$username=$_POST['username'];
		$psw=$_POST['psw'];
		$remember=$_POST['remember'];
		$sql="select * from ".$TableUser." where username='$username' and psw='$psw'  ";
		$row=$db->getRow($sql);
		if(!empty($row[username]))
		{
					//last_visittime
					$last_visittime=date('Y-m-j H:i:s');
					$sql="update ".$TableUser." set last_visittime='".$last_visittime."' where username='".$username."' ";
					$db->query($sql);
					
					$user=array();
					$user['username']=$row[username];
					$user['UserGrade']=$row[UserGrade];
					$user['nick_name']=$row[nick_name];
					//remember username and password
					if((int)$remember==1)
					{
						setMyCookie("CookieUser_username",$user['username']);
						setMyCookie("CookieUser_UserGrade",$user['UserGrade']);
						setMyCookie("CookieUser_nick_name",$user['nick_name']);
						setMyCookie("CookieUser_psw",$row['psw']);
					}
					$_SESSION['SessionUser']=$user;
					echo "1";//登陆成功
		}
		else
		{
			echo "2";//登陆失败
		}
?>
<? $db->close_db();?>