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
		 $sql="select * from ".$TableAdmin." where username='".$username."' ";
		 $row=$db->getRow($sql);
		 if(empty($row[username]))
		 {
			echo "1";//可以注册
		}
		else
		{
			echo "2";//此用户已经存在
		}
?>
<? $db->close_db();?>