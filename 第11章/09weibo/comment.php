<?php
require_once(dirname(__FILE__)."/global.php");

if( isset($_POST['mid'],$_POST['nickname'],$_POST['comment']) )
{
	if( $blog_config['comment_open'] == "0" )
	{
		$error_info =  "0 禁止评论";
	}
	else
	{
		if( $loginStat )
		{
			$nickname = "";

			$ipAddress = "";

			$display = 1;
		}
		else
		{
			$nickname = trim($_POST['nickname']);

			if( !empty($nickname) )
			{
				$checkName = checkName($nickname);

				if( !empty($checkName) )
				{
					$error_info = "-1 ".$checkName;
				}
			}

			$ipAddress = getClientIP();

			$display = ( $blog_config['comment_open'] == "1" ) ? 1 : 0;
		}
	}

	if( isset($error_info) )
	{
		echo $error_info;
	}
	else
	{
		$msg_con = filterCode($_POST['comment'],$blog_config['url_short']);

		if( empty($msg_con) || getStrlen($msg_con) > 70 )
		{
			echo "0 评论不能为空且不超过70个字符";
		}
		else
		{
			$DB = database();

			$blogId = $DB->fetch_one("SELECT `mid` FROM `".$mysql_prefix."blog` WHERE `mid`='".$_POST['mid']."'");

			if( empty($blogId) )
			{
				echo "0 评论被拒绝";
			}
			else
			{
				if( blogAction::commentUpdate($blogId,$nickname,$msg_con,$ipAddress,$display) )
				{
					if( $display )
					{
						$commentNum = $DB->fetch_one("SELECT COUNT(`cid`) FROM `".$mysql_prefix."comment` WHERE `mid`=".$blogId);

						$lastPage = ceil($commentNum/$blog_config['per_comment']);

						echo "1 ".$lastPage;
					}
					else
						echo "2 评论成功 审核后可见";
				}
				else
					echo "0 评论失败";
			}

			$DB->close();

			unset($DB);
		}
	}
}

if( isset($_POST['messageId'],$_POST['deleteId']) )
{
	if( $loginStat )
	{
		$DB = database(false);

		if( blogAction::delComment($_POST['messageId'],$_POST['deleteId']) )
		{
			echo "1";
		}

		$DB->close();

		unset($DB);
	}
}

if( isset($_POST['displayId']) )
{
	if( $loginStat )
	{
		$DB = database(false);

		if( $DB->query($DB->update_sql("`".$mysql_prefix."comment`",array("display"=>1),"`cid`='".$_POST['displayId']."'")) )
		{
			echo "1";
		}

		$DB->close();

		unset($DB);
	}
}

if( isset($_POST['id'],$_POST['pg']) )
{
	$msgId = intval($_POST['id']);

	$pgNum = intval($_POST['pg']);

	$DB = database();

	$commentArr = blogAction::getComment($msgId,$pgNum,$blog_config['per_comment']);

	$DB->close();

	unset($DB);

	$pageArr = pageAction::commentPage($msgId,$commentArr['Total'],$blog_config['per_comment'],$pgNum);

	$tmp = template("comment.html");

	$tmp->assign( 'blogConfig',  $blog_config );

	$tmp->assign( 'loginStat',  $loginStat );

	$tmp->assign( 'messageId',  $msgId );

	$tmp->assign( 'commentArr',  $commentArr );

	$tmp->assign( 'pageArr',  $pageArr );

	$tmp->output();

	unset($tmp);
}

ob_end_flush();
?>