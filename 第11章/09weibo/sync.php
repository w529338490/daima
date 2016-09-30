<?php
require_once(dirname(__FILE__)."/global.php");

if( isset($_POST['save']) )
{
	if( !$loginStat )
	{
		echo "0";
	}
	else
	{
		unset($_POST['save']);

		$config_str = '$sync_config = array(';

		foreach( $_POST as $key => $arr )
		{
			$config_str .= '"'.$key.'"=>array(';

			foreach( $arr as $k => $v )
			{
				$config_str .= '"'.$k.'"=>"'.strAddslashes(strip_tags($v)).'",';
			}

			$config_str = substr($config_str,0,-1).'),';
		}

		$config_str = substr($config_str,0,-1).');';

		$updateFile = updatePhpFile("database/config_sync.php",$config_str);

		if( $updateFile == "" )
		{
			echo "保存成功";
		}
		else
		{
			echo $updateFile;
		}
	}
}
else
{
	if( !$loginStat )
	{
		header("location:./login.php");
	}
	else
	{
		$tmp = template("sync.html");

		$tmp->assign( 'blogConfig', $blog_config );

		$tmp->assign( 'syncConfig', $sync_config );

		$tmp->assign( 'loginStat', $loginStat );

		$tmp->output();
	}
}

ob_end_flush();
?>