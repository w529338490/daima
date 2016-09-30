<?php
class blogAction
{
	function blogUpdate($message,$picture,$origin)
	{
		global $DB,$mysql_prefix,$blog_config;
		
		$arr = array("message"=>$message,"picture"=>$picture,"dateline"=>time(),"origin"=>$origin,"comments"=>0);

		if( $DB->query($DB->insert_sql("`".$mysql_prefix."blog`",$arr)) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function commentUpdate($mid,$name,$msg,$ip,$display=1)
	{
		global $DB,$mysql_prefix;

		$arr = array("mid"=>$mid,"nickname"=>$name,"message"=>$msg,"dateline"=>time(),"ipaddress"=>$ip,"display"=>$display);

		if( $DB->query( $DB->insert_sql("`".$mysql_prefix."comment`",$arr) ) )
		{
			$DB->query( $DB->update_sql("`".$mysql_prefix."blog`",array("comments"=>array("`comments`+1")),"`mid`=".$mid) );

			return true;
		}
		else
		{
			return false;
		}
	}

	function delBlog($mid,$pic)
	{
		global $DB,$mysql_prefix;

		$DB->query("DELETE FROM `".$mysql_prefix."blog` WHERE `mid`='".$mid."'");

		$DB->query("DELETE FROM `".$mysql_prefix."comment` WHERE `mid`='".$mid."'");

		delPicture($pic);

		return true;
	}

	function delComment($mid,$cid)
	{
		global $DB,$mysql_prefix;

		$delNum = $DB->affected_rows("DELETE FROM `".$mysql_prefix."comment` WHERE `mid`='".$mid."' AND `cid`='".$cid."'");

		if( $delNum > 0 )
		{
			$DB->query( $DB->update_sql("`".$mysql_prefix."blog`",array("comments"=>array("`comments`-1")),"`mid`='".$mid."'") );
		}

		return true;
	}

	function getBlog($page,$per)
	{
		global $DB,$mysql_prefix;

		$blogArr = array();

		$Total = $DB->fetch_one("SELECT COUNT(`mid`) FROM `".$mysql_prefix."blog`");

		if( $Total > 0 )
		{
			$lastPage = ceil($Total/$per);

			if( $page > $lastPage )
			{
				$page = $lastPage;
			}

			$Result = $DB->query("SELECT * FROM `".$mysql_prefix."blog` ORDER BY `mid` DESC LIMIT ".($page-1)*$per.",".$per);

			while($Re = $DB->fetch_array($Result))
			{
				$blogArr[] = array(
									"mid"		=> $Re['mid'],
									"message"	=> filterHTML($Re['message']),
									"picture"	=> $Re['picture'],
									"piclink"	=> str_replace("/s_","/b_",$Re['picture']),
									"dateline"	=> $Re['dateline'],
									"origin"	=> stripslashes($Re['origin']),
									"comments"	=> $Re['comments']
									);
			}
		}

		$return['Total'] = $Total;

		$return['Blog'] = $blogArr;
		
		return $return;
	}

	function getComment($mid,$page,$per)
	{
		global $DB,$mysql_prefix;

		$commentArr = array();

		$Total = $DB->fetch_one("SELECT COUNT(`cid`) FROM `".$mysql_prefix."comment` WHERE `mid`=".$mid);

		if( $Total > 0 )
		{
			$lastPage = ceil($Total/$per);

			if( $page > $lastPage )
			{
				$page = $lastPage;
			}

			$Rs = $DB->query("SELECT * FROM `".$mysql_prefix."comment` WHERE `mid`=".$mid." ORDER BY `cid` ASC LIMIT ".($page-1)*$per.",".$per);

			while($Re = $DB->fetch_array($Rs))
			{
				$commentArr[] = array(
									"cid"		=> $Re['cid'],
									"mid"		=> $Re['mid'],
									"nickname"	=> stripslashes($Re['nickname']),
									"message"	=> filterHTML($Re['message']),
									"dateline"	=> $Re['dateline'],
									"ipaddress"	=> $Re['ipaddress'],
									"display"	=> $Re['display']
									);
			}
		}

		$return['Total'] = $Total;

		$return['Comment'] = $commentArr;
		
		return $return;
	}

	function getStat($time)
	{
		global $DB,$mysql_prefix;

		return $DB->fetch_one("SELECT COUNT(`mid`) FROM `".$mysql_prefix."blog` WHERE `dateline` > ".$time);
	}

	function getFriend($where,$order,$page,$per)
	{
		global $DB,$mysql_prefix;

		$friendArr = array();

		$Total = $DB->fetch_one("SELECT COUNT(`fid`) FROM `".$mysql_prefix."friend` WHERE ".$where);

		if( $Total > 0 )
		{
			$lastPage = ceil($Total/$per);

			if( $page > $lastPage )
			{
				$page = $lastPage;
			}

			$Result = $DB->query("SELECT * FROM `".$mysql_prefix."friend` WHERE ".$where." ORDER BY ".$order." DESC LIMIT ".($page-1)*$per.",".$per);

			while($Re = $DB->fetch_array($Result))
			{
				$friendArr[] = array(
									"fid"			=> $Re['fid'],
									"furl"			=> $Re['furl'],
									"fupdate"		=> $Re['fupdate'],
									"friendavatar"	=> urlencode(base64_encode($Re['furl']."|||".$Re['friendavatar'])),
									"friendname"	=> stripslashes($Re['friendname']),
									"friendmsg"		=> filterHTML($Re['friendmsg']),
									"friendpic"		=> empty($Re['friendpic']) ? "" : $Re['furl'].$Re['friendpic'],
									"friendpid"		=> empty($Re['friendpic']) ? "" : urlencode(base64_encode($Re['furl'].$Re['friendpic'])),
									"friendtime"	=> $Re['friendtime'],
									"friendorigin"	=> stripslashes($Re['friendorigin'])
									);
			}
		}

		$return['Total'] = $Total;

		$return['Friend'] = $friendArr;
		
		return $return;
	}
}
?>