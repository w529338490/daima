<? include "../db/Connect.php"?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
<? // 您好
		$psw_old=$_POST['psw_old'];
		$psw=$_POST['psw'];
		$username=$_POST['c_username'];
		$sql="select * from ".$TableUser." where username='$username' and psw='$psw_old'  ";
		$row=$db->getRow($sql);
		if(!empty($row[username]))
		{
					//last_visittime
					$last_visittime=date('Y-m-j H:i:s');
					$sql="update ".$TableUser." set last_visittime='".$last_visittime."', psw='".$new_psw."'  where username='".$username."' ";
					$db->query($sql);
					
					
					echo "1";//changed
		}
		else
		{
			echo "2";//password exsit
		}
?>
<? $db->close_db();?>