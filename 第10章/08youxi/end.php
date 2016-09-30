<?php
include "./dbconnect.php";
mysql_query("update room_ddz set player1_name = '', player2_name = '' where ID = '".$_GET[ID]."'");
?>