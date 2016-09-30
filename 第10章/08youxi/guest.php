<?php
include "./dbconnect.php";
if($_GET[ID]){
	if($player_name)
	header("location:hall.php");
	setcookie(player_name, guest);
	setcookie(player_password, md5(guest));
	header("location:room_ddz.php?ID=".$_GET[ID]);
}else
die(参数有误！);
?>