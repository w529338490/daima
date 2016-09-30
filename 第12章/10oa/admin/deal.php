<?php
/*
凤鸣山中小学网络办公室
*/

switch($action){
	case 'setvar':

		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]rootpath\s*\=\s*[\"'].*?[\"']/is", "\$rootpath = '$newrootpath'", $configfile);
		$configfile = preg_replace("/[$]style\s*\=\s*[\"'].*?[\"']/is", "\$style = '$newstyle'", $configfile);
		$configfile = preg_replace("/[$]sitename\s*\=\s*[\"'].*?[\"']/is", "\$sitename = '$newsitename'", $configfile);
		$configfile = preg_replace("/[$]siteurl\s*\=\s*[\"'].*?[\"']/is", "\$siteurl = '$newsiteurl'", $configfile);
		$configfile = preg_replace("/[$]sitemaster\s*\=\s*[\"'].*?[\"']/is", "\$sitemaster = '$newsitemaster'", $configfile);
		$configfile = preg_replace("/[$]sitetitle\s*\=\s*[\"'].*?[\"']/is", "\$sitetitle = '$newsitetitle'", $configfile);
		$configfile = preg_replace("/[$]sitedescription\s*\=\s*[\"'].*?[\"']/is", "\$sitedescription = '$newsitedescription'", $configfile);
		$configfile = preg_replace("/[$]sitekeywords\s*\=\s*[\"'].*?[\"']/is", "\$sitekeywords = '$newsitekeywords'", $configfile);
		$configfile = preg_replace("/[$]school_name\s*\=\s*[\"'].*?[\"']/is", "\$school_name = '$newschool_name'", $configfile);
		$configfile = preg_replace("/[$]school_type\s*\=\s*[\"'].*?[\"']/is", "\$school_type = '$newschool_type'", $configfile);
		$configfile = preg_replace("/[$]register_key\s*\=\s*[\"'].*?[\"']/is", "\$register_key = '$newregister_key'", $configfile);
		$configfile = preg_replace("/[$]uppath\s*\=\s*[\"'].*?[\"']/is", "\$uppath = '$newuppath'", $configfile);
		$configfile = preg_replace("/[$]MAX_FILE_SIZE\s*\=\s*[\"'].*?[\"']/is", "\$MAX_FILE_SIZE = '$newmax_file_size'", $configfile);
		$configfile = preg_replace("/[$]uptypes\s*\=\s*[\"'].*?[\"']/is", "\$uptypes = '$newuptypes'", $configfile);
		$configfile = preg_replace("/[$]perpage\s*\=\s*[\"'].*?[\"']/is", "\$perpage = '$newperpage'", $configfile);
		$configfile = preg_replace("/[$]pagenavpages\s*\=\s*[\"'].*?[\"']/is", "\$pagenavpages = '$newpagenavpages'", $configfile);
		$configfile = preg_replace("/[$]strnum\s*\=\s*[\"'].*?[\"']/is", "\$strnum = '$newstrnum'", $configfile);
		$configfile = preg_replace("/[$]showtime\s*\=\s*[\"'].*?[\"']/is", "\$showtime = '$newshowtime'", $configfile);
		$configfile = preg_replace("/[$]force_html\s*\=\s*[\"'].*?[\"']/is", "\$force_html = '$newforce_html'", $configfile);
        $configfile = preg_replace("/[$]ftp_ip\s*\=\s*[\"'].*?[\"']/is", "\$ftp_ip = '$newftp_ip'", $configfile);
		$configfile = preg_replace("/[$]port\s*\=\s*[\"'].*?[\"']/is", "\$port = '$newport'", $configfile);
		
		$fp = fopen('./config.php', 'w');
		if(@fwrite($fp, trim($configfile))){
			showmessage("系统设置成功！请返回！","?filename=setvar&action=setvar");
		}else
		showmessage("系统设置失败！请检查 ./config.php 文件是否可写！");
		fclose($fp);
		break;

	case 'setindex':

		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]outtypeids\s*\=\s*[\"'].*?[\"']/is", "\$outtypeids = '$newouttypeids'", $configfile);
		$configfile = preg_replace("/[$]class_subject_arr\s*\=\s*[\"'].*?[\"']/is", "\$class_subject_arr = '$newclass_subject_arr'", $configfile);
		$configfile = preg_replace("/[$]includepic_arr\s*\=\s*[\"'].*?[\"']/is", "\$includepic_arr = '$newincludepic_arr'", $configfile);
		$fp = fopen('./config.php', 'w');
		if(@fwrite($fp, trim($configfile))){
			showmessage("系统设置成功！请返回！","?filename=setvar&action=setindex");
		}else
		showmessage("系统设置失败！请检查 ./config.php 文件是否可写！");
		fclose($fp);
		break;
		/**********************无限分类的设置***开始********************************************/
	case 'addtype':
		//设置path
		$query="select path,layerid from `$table_type` where id=$uid limit 1";
		$result=$db->query_first($query);
		if ($uid==0){$path="|$uid|";}else {$path=$result[path]."$uid|";}
		//设置tid
		$query="select count(*) AS orderid from `$table_type` where `path` = '$path' ";
		$r=$db->query_first($query);
		$tid=$r[orderid]+1;
		//设置layerid
		$layerid=$result[layerid]+1;
		//设置name
		$typename=addslashes($typename);
		//设置分类图片
		if (empty($typepic))$typepic=0;
		//保存分类信息
		$typequery="INSERT INTO `$table_type` ( `id` , `uid` , `cid`,`path`,`layerid`,`typename` ,`actionurl`, `tid` , `isshow` ,`isright`, `enablecontribute` ,  `templatetitle`,`typepic`)
                               VALUES ('', '$uid','', '$path', '$layerid','$typename','$actionurl','$tid' , '$isshow', '$isright','$enablecontribute', '$templatetitle','$typepic');";
		$db->query($typequery);
		//设置自身的cid值
		$id=$db->insert_id();
		$queryupcid="UPDATE `$table_type` SET `cid` = '|$id|' WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($queryupcid);
		//设置上一级的cid（把当前的id添加到上一级的cid中）
		if ($uid>0){
			$querycid="select id,cid from $table_type where `cid` like '%|$uid|%'";
			$result=$db->query($querycid);
			while($r=$db->fetch_array($result)){$cid=$r[cid]."$id|";
			$queryupcid="UPDATE `$table_type` SET `cid` = '$cid' WHERE `id` = '$r[id]' LIMIT 1 ;";
			$db->query($queryupcid);
			}
		};

		$referer="?filename=type&action=addtype&uid=$uid";
		if($db->affected_rows()>0){
			showmessage("<body onload='parent.left.window.location.reload()'>栏目添加成功！请返回！",$referer);
		}else
		showmessage("栏目添加失败!");
		break;

	case 'edittype':
		//格式化分类名称
		$typename=addslashes($typename);
		//读取当前修改的栏目数据
		$sql="select * from $table_type where id=$typeid limit 1;";
		$r=$db->query_first($sql);
		$path=$r[path];
		$layerid=$r[layerid];
		$tid=$r[tid];
		$cid=$r[cid];
		//判断父级栏目是否变更,如果变更则更改父级和子级的信息××××
		if ($olduid!=$uid)
		{
			unset($r,$path,$layerid,$tid,$cid);
			//读取本分类的原有信息
			$sql="select * from $table_type where id=$typeid limit 1;";
			$r=$db->query_first($sql);
			$old_cid=$r[cid];
			$old_path=$r[path];
			$old_layerid=$r[layerid];

			//不能将新的父级变更到子级中
			if (eregi("\|$uid\|",$old_cid))
			{
				$referer="?filename=type&action=listtype";
				showmessage("<body onload='parent.left.window.location.reload()'>不能将新的父级变更到子级中！请返回！",$referer);
			}

			//设置所有旧父级的变更参数：cid
			//                         (去除旧父级中有关于本类的所有子级包括本类)
			$sql="select id,cid from $table_type where (`cid` like '%|$typeid|%') and id!=$typeid;";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$old_father_cid=$r[cid];
				$temp=explode("|", $old_cid);
				$temp_size=sizeof($temp);
				for ($i=1;$i<$temp_size-1;$i++)
				{
					$old_father_cid=eregi_replace("\|$temp[$i]\|","|",$old_father_cid);
				}
				$queryupcid="UPDATE `$table_type` SET `cid` = '$old_father_cid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$db->query($queryupcid);
			}
			unset($temp,$temp_size,$queryupcid,$old_father_cid);

			//读取新父级数据
			$sql="select path,layerid from $table_type where id=$uid limit 1;";
			$ur=$db->query_first($sql);
			$upath=$ur[path];
			$ulayerid=$ur[layerid];

			//设置本分类新的路径和层次（path和layerid）;
			if ($uid==0){ $path ="|$uid|";}
			else { $path =$upath.$uid."|";};
			$layerid=$ulayerid+1;

			//设置所有新父级的变更参数：cid
			//                          添加本分类和他的子级id到父级cid中
			$sql="select * from $table_type where (`cid` like '%|$uid|%')";
			$result=$db->query($sql);
			$subcid= substr($old_cid, 1);
			while($r=$db->fetch_array($result))
			{
				$addcid=$r[cid]."$subcid";
				$queryupcid="UPDATE `$table_type` SET `cid` = '$addcid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$db->query($queryupcid);
			}
			unset($subcid,$addcid,$queryupcid);

			//设置子级的变更参数：路径和层次（path和layerid）
			$temp=explode("|", $old_path);
			$temp_size=sizeof($temp);
			$eregi_path="\|";
			for ($i=1;$i<$temp_size-1;$i++)
			{
				$eregi_path.="$temp[$i]\|";
			}

			$sql="select * from $table_type where `path` like '%$old_path$typeid|%';";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$newpath=eregi_replace("$eregi_path","$path",$r[path]);
				$newlayerid=$r[layerid]-$old_layerid+$ulayerid+1;
				$queryupcid="UPDATE `$table_type` SET `path` = '$newpath',`layerid`='$newlayerid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$db->query($queryupcid);
			}
			unset($temp,$temp_size,$queryupcid,$newlayerid);

			//设置本分类的tid值（显示顺序的值）
			$query="select count(*) AS orderid from `$table_type` where `path` = '$path' ";
			$rr=$db->query_first($query);
			$tid=$rr[orderid]+1;
		}
		//设置栏目图片
		if (empty($typepic))$typepic=0;
		//sql设置
		$typequery=" UPDATE `$table_type` SET `uid` = '$uid',
                                      `path` = '$path',
                                      `layerid` = '$layerid',
                                      `typename` = '$typename',
                                      `actionurl` ='$actionurl',
                                      `tid` = '$tid',
                                      `isshow` = '$isshow',
                                      `isright` = '$isright',
                                      `enablecontribute` = '$enablecontribute',
                                      `templatetitle` = '$templatetitle',
                                      `typepic` ='$typepic'
                                      where id=$typeid";                                    
		$db->query($typequery);
		$referer="?filename=type&action=listtype";
		if(($db->affected_rows()>0) or ($ok==1)){
			showmessage("<body onload='parent.left.window.location.reload()'>栏目修改成功！请返回！",$referer);
		}else  showmessage("栏目修改失败！");

		break;
		//删除分类
	case 'deltype':
		$referer="?filename=type&action=listtype";
		$sql="select * from $table_type where id=$typeid limit 1;";
		$r=$db->query_first($sql);
		$cid=$r[cid];
		if($cid!="|$typeid|")	showmessage("栏目不能删除,含有子栏目",$referer);
		//设置所有旧父级的变更参数：cid
		//                         (去除旧父级中有关于本类的所有子级包括本类)
		$sql="select id,cid from $table_type where (`cid` like '%|$typeid|%') and id!=$typeid;";
		$result=$db->query($sql);
		while($r=$db->fetch_array($result)){
			$old_father_cid=$r[cid];
			$old_father_cid=eregi_replace("\|$typeid\|","|",$old_father_cid);
			$queryupcid="UPDATE `$table_type` SET `cid` = '$old_father_cid' WHERE `id` = '$r[id]' LIMIT 1 ;";
			$db->query($queryupcid);
		}
		unset($queryupcid,$old_father_cid);
		//删除所在分类记录
		$sql="delete from `$table_type` where `id`='$typeid' limit 1";
		$db->query($sql);
		if(($db->affected_rows()>0) ){
			showmessage("栏目删除成功！请返回！",$referer);
		}else  showmessage("栏目删除失败！");
		break;
		//保存分类顺序值
	case 'saveorder':
		$sql="select * from $table_type order by id;";
		$result=$db->query($sql);
		while($r=$db->fetch_array($result)){
			$id=$r[id];
			$sql="UPDATE `$table_type` SET `tid` = '$order[$id]' WHERE `id` = '$id' LIMIT 1";
			$db->query($sql);
		}
		$referer="?filename=type&action=listtype";
		showmessage("<body onload='parent.left.window.location.reload()'>保存分类顺序值!请返回！",$referer);
		break;
		/**********************无限分类的设置***结束********************************/
		/************************文章**发布**管理**开始***********************************/
	case 'addarticle':
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?$referer[query]";
		if ($no_repeat!=$_COOKIE[no_repeat_state])showmessage("文章发表失败！请返回！",$referer);
		//参数设置
		$manageid=str_in($manageid);
		$typeid=str_in($typeid);
		$title=str_in($title);
		$includepic=str_in($includepic);
		$titlefontcolor=str_in($titlefontcolor);
		$titlefonttype=str_in($titlefonttype);
		$author=str_in($author);
		$inputer=$user_id;
		$copyfromname=str_in($copyfromname);
		$copyfromurl=str_in($copyfromurl);
		$content=stripslashes($gently_editor);
		//$content=getimages($content,$uppath);
		$content=addslashes($content);
		//时间设置
		$addtime=time();
		$pretime=mktime(0,0,0,date(m),date(d),date(Y));
		if ($outtime=="") $outtime=$pretime;
		else {
			$outtime=explode("-",$outtime);
			$outtime=mktime(0,0,0,$outtime[1],$outtime[2],$outtime[0]);
		}
		if ($group_id>3) $pass=0;
		//是否可以发表
		if ($_COOKIE[isadd]==1)
		{
			//删除附件和数据库
			$sql="select softpath from $table_soft where postid='$postid'";
			$rmsoft=$db->query($sql);
			while($s=$db->fetch_array($rmsoft))
			{
				unlink("./upfiles/$s[softpath]");
			}
			$sql="DELETE FROM $table_soft WHERE postid = '$postid'";
			$db->query($sql);
			/*			//删除图片和数据库
			$sql="select imagepath from $table_images where postid='$postid'";
			$rmimage=$db->query($sql);
			while($s=$db->fetch_array($rmimage))
			{
			unlink("$s[imagepath]");
			}
			$sql="DELETE FROM $table_images WHERE postid = '$postid'";
			$db->query($sql);*/
			showmessage("对不起，你还不能发表文章，间隔时间太短！",$referer);
			exit();
		}

		//发布文章
		$query="insert into $table_articles ( `title`,`includepic`,`subheading`,`titlefontcolor`,`titlefonttype`,`content`,`manageid`,`inputer`,`author`,`copyfromname`,`copyfromurl`,`typeid`,`addtime`,`outtime`,`pass`)
                             values ('$title','$includepic','$subheading','$titlefontcolor','$titlefonttype','$content','$manageid','$inputer','$author','$copyfromname','$copyfromurl','$typeid','$addtime','$outtime','$pass')";
		$db->query($query) ;
		$articleid=$db->insert_id();
		if($db->affected_rows()!=0){
			//修改图片和附件的postid值
			$sql="SELECT softid FROM `$table_soft` WHERE  `postid` = '$postid'";
			$re=$db->query($sql);
			while($s=$db->fetch_array($re))
			{$softid=$s[softid];
			$sqlr="UPDATE `$table_soft` SET `postid` = '$articleid' WHERE softid=$softid";
			$db->query($sqlr) ;
			}
			/*$sql="SELECT imageid FROM `$table_images` WHERE  `postid` = '$postid'";
			$reimages=$db->query($sql);
			while($s=$db->fetch_array($reimages))
			{$imageid=$s[imageid];
			$sqlr="UPDATE `$table_images` SET `postid` = '$articleid' WHERE imageid=$imageid";
			$db->query($sqlr) ;
			}*/
			//相关人员待办提醒
			$content="点击这里查看具体内容";
			if($teacherlist){
				$teacherlist = explode(",",$teacherlist);
				foreach ($teacherlist as $value)
				{
					$sqlt="select userid from members where `realname` like '$value';";
					$s=$db->query_first($sqlt);
					//添加新的事务
					$sqlt="insert into $table_schedule (`inputer`,`title`,`content`,`intime`,`pretime`,`articleid`)
	                             value  ('$s[userid]','$title','$content','$outtime','$pretime','$articleid')";
					$db->query($sqlt);
				}
			}
			//set cookie 防止刷新
			setcookie('no_repeat_state',1);
			showmessage("文章发表成功！请返回！",$referer);
		}else
		showmessage("文章发表失败！请返回！",$referer);
		break;
		/***********************修改**编辑**文章******************************/
	case 'editarticle':
		$classid=str_in($classid);
		$title=str_in($title);
		$includepic=str_in($includepic);
		$titlefontcolor=str_in($titlefontcolor);
		$titlefonttype=str_in($titlefonttype);
		$author=str_in($author);
		$copyfromname=str_in($copyfromname);
		$copyfromurl=str_in($copyfromurl);
		$content=stripslashes($gently_editor);
		//$content=getimages($content,$uppath);
		$content=addslashes($content);
		if ($outtime=="") $outtime=mktime(0,0,0,date(m),date(d),date(Y));
		else {
			$outtimes=explode("-",$outtime);
			$outtime=mktime(0,0,0,$outtimes[1],$outtimes[2],$outtimes[0]);
		}
		$query="update $table_articles set title='$title',
                                   subheading='$subheading',
                                   includepic='$includepic',
                                   titlefontcolor='$titlefontcolor',
                                   titlefonttype='$titlefonttype',
                                   content='$content',
                                   author='$author',
                                   copyfromname='$copyfromname',
                                   copyfromurl='$copyfromurl',
                                   manageid='$manageid',
                                   typeid='$classid',
                                   outtime='$outtime',
                                   pass='$pass'
                                   where articleid='$articleid';";
		$db->query($query) ;
		//相关人员待办提醒
		$sch[]=0;
		$content="点击这里查看具体内容";
		//list teacherlist
		$sqlt="select inputer from $table_schedule where `articleid`=$articleid";
		$result2=$db->query($sqlt);
		while ($rt=$db->fetch_array($result2)){
			$sch[]=$rt[inputer];
		}
		//del teacherlist
		$delteacherlist = explode(",",substr($delteacherlist,0,-1));
		if ($delteacherlist[0]!="") {
			foreach ($delteacherlist as $value)
			{
				$sqlt="select userid from members where `realname` like '$value';";
				$s=$db->query_first($sqlt);
				if (in_array($s[userid],$sch)){
					$sqlt2="delete from $table_schedule where articleid=$articleid and inputer=$s[userid] limit 1";
					$db->query($sqlt2);
					$temp[]=$s[userid];
					$sch=array_diff($sch,$temp);
				}
			}
		}

		//add edit teacherlist
		if ($teacherlist){
			//read intime
			$sql="select addtime from $table_articles where `articleid`='$articleid'";
			$r=$db->query_first($sql);
			$intime=$r[addtime];
			$intime=mktime(0,0,0,date(m,$intime),date(d,$intime),date(Y,$intime));
			$teacherlist = explode(",",$teacherlist);
			foreach ($teacherlist as $value)
			{
				if ($value){
					$sqlt="select userid from members where `realname` like '$value';";
					$s=$db->query_first($sqlt);
					if (in_array($s[userid],$sch)){
						$sqlt="UPDATE $table_schedule SET `title` = '$title',`pretime`='$outtime' WHERE articleid=$articleid and inputer=$s[userid] LIMIT 1 ;";
						$db->query($sqlt);
					}else{
						//添加新的事务
						$sqlt="insert into $table_schedule (`inputer`,`title`,`content`,`intime`,`pretime`,`articleid`)
	                             value  ('$s[userid]','$title','$content','$outtime','$intime','$articleid')";
						$db->query($sqlt);
					}
				}
			}
		}
		if($db->affected_rows()!=0){
			showmessage("文章修改成功！","?filename=article&action=list&typeid=$typeid");
		}else
		showmessage("文章修改失败！","?filename=article&action=list&typeid=$typeid");

		break;
		/********************审核***通过***文章*********************************/
	case 'passarticle':

		$query="update $table_articles set pass=1 where articleid='$articleid'";
		$db->query($query);
		if($db->affected_rows()>0){
			$addtime=$addtime?$addtime:time();
			showmessage("文章批准成功！","?filename=pass&typeid=".$typeid);
		}else
		showmessage("文章批准失败！","?filename=pass&typeid=".$typeid);

		break;
		/*********************推荐***文章**************************************/
	case 'commendarticle':

		$query="update $table_articles set state=2 where articleid='$id'";
		$db->query($query);if($db->affected_rows()>0)
		showmessage("文章推荐成功！","?filename=article&action=list&typeid=$typeid");
		else
		showmessage("文章推荐失败！","?filename=article&action=list&typeid=$typeid");

		break;
		/*************************删除**文章*****************************************/
	case 'deletearticle':

		$query="delete from $table_articles where articleid='$id'";
		$db->query($query);
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?$referer[query]";
		if($db->affected_rows()!=0){
			//同时将删除文件和图片
			//删除附件和数据库
			$sql="select softpath from $table_soft where postid='$id'";
			$rmsoft=$db->query($sql);
			while($s=$db->fetch_array($rmsoft))
			{
				unlink("./upfiles/$s[softpath]");
			}
			$sql="DELETE FROM $table_soft WHERE postid = '$id'";
			$db->query($sql);
			//删除图片和数据库
			$sql="select imagepath from $table_images where postid='$id'";
			$rmimage=$db->query($sql);
			while($s=$db->fetch_array($rmimage))
			{
				unlink("$s[imagepath]");
			}
			$sql="DELETE FROM $table_images WHERE postid = '$id'";
			$db->query($sql);
			showmessage("文章删除成功！请返回！",$referer);
		}else
		showmessage("文章删除失败！请返回！",$referer);

		break;
		/***********************请假***申请***添加***********************************/
	case 'addleave':
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?$referer[query]";
		//发布文章
		$typeid=str_in($typeid);
		$leaver=str_in($leaver);
		$passer=str_in($passer);
		$reason=str_in($reason);
		$leavetypeid=str_in($leavetypeid);
		//格式化时间
		$stime=str_in($stime);
		$stime=explode("-",$stime);
		$stime=mktime(0,0,0,$stime[1],$stime[2],$stime[0]);
		$etime=str_in($etime);
		$etime=explode("-",$etime);
		$etime=mktime(0,0,0,$etime[1],$etime[2],$etime[0]);
		if($stime>$etime) showmessage("请假发表失败！请假开始日期小于结束日期",$referer);
		$intime=time();
		$pass=0;
		$query="insert into $table_leave ( `typeid`,`leaver`,`passer`,`reason`,`leavetypeid`,`stime`,`etime`,`intime`,`pass`)
                          values ('$typeid','$leaver','$passer','$reason','$leavetypeid','$stime','$etime','$intime','$pass')";
		$db->query($query) ;

		if($db->affected_rows()!=0){
			showmessage("请假发表成功！请返回！",$referer);
		}else
		showmessage("请假发表失败！请返回！",$referer);
		break;
		/***********************请假***审核**************************************/
	case 'passleave':
		$query="UPDATE `$table_leave` SET `pass` = '1',`passer`='$real_name' WHERE `id` = '$leaveid' LIMIT 1 ;";
		$db->query($query) ;
		$referer="?filename=leave&typeid=$typeid&action=pass";
		if($db->affected_rows()!=0){
			showmessage("请假发表成功！返回继续审批！",$referer);
		}else
		showmessage("请假发表失败！请返回！",$referer);
		break;
		/***********************请假***删除**************************************/
	case 'delleave':
		$sql="DELETE FROM $table_leave WHERE `id` = '$leaveid'";
		$db->query($sql);
		$referer="?filename=leave&typeid=$typeid&action=pass";
		showmessage("请假删除成功！返回继续审批！",$referer);

		break;
		/***********************权限***设置**添加****编辑**开始*************************************/
	case 'addright':
		//处理types值
		$types=explode(",",$types);
		while (list($key,$value)=each($types)){
			$tadd="add".$value;
			$tlist="list".$value;
			$tedit="edit".$value;
			$tdel="del".$value;
			$tpass="pass".$value;
			if ($$tadd=="")$$tadd=0;
			if ($$tlist=="")$$tlist=0;
			if ($$tdel=="")$$tdel=0;
			if ($$tedit=="")$$tedit=0;
			if ($$tpass=="")$$tpass=0;
			$rightdata[$key]="$value|".$$tlist."|".$$tadd."|".$$tedit."|".$$tdel."|".$$tpass;
		};
		$rightdata=implode(":",$rightdata);
		if ($right==0){
			//添加新的权限
			$sql="insert into userright (`rightid`,`rights`)
	                      value  ('$groupid','$rightdata')";
			$db->query($sql);
		}else {
			//编辑有的权限
			$sql="UPDATE `userright` SET
    	                     `rights` = '$rightdata' 
    	                     WHERE `rightid` = '$groupid' LIMIT 1 ;";
			$db->query($sql);
		}
		$referer="index.php?filename=setting&action=group&do=list";
		if($db->affected_rows()!=0){
			showmessage("权限添加成功！请返回！",$referer);
		}else
		showmessage("权限添加失败！请返回！",$referer);
		break;
		/**************************添加**编辑***日程事务***开始*****************************/
	case 'addschedule':
		//设置时间格式
		$inime=str_in($intime);
		$intime=explode("-",$intime);
		$intime=mktime(0,0,0,$intime[1],$intime[2],$intime[0]);
		if ($pretime){
			$pretime=str_in($pretime);
			$pretime=explode("-",$pretime);
			$pretime=mktime(0,0,0,$pretime[1],$pretime[2],$pretime[0]);
		} else $pretime=mktime(0,0,0,date(m),date(d),date(Y));
		if ($do==1){
			//添加新的事务
			$sql="insert into $table_schedule (`inputer`,`title`,`content`,`intime`,`pretime`,`typeid`)
	                             value  ('$user_id','$title','$content','$intime','$pretime',$stypeid)";
			$db->query($sql);
		}else {
			//编辑有的事务
			$sql="UPDATE $table_schedule SET
    	                     `rights` = '$rightdata' 
    	                     WHERE `rightid` = '$groupid' LIMIT 1 ;";
			$db->query($sql);
		}
		$referer="index.php?filename=schedule&typeid=$typeid&action=a";
		if($db->affected_rows()!=0){
			showmessage("事务添加成功！请返回！",$referer);
		}else
		showmessage("事务添加失败！请返回！",$referer);
		break;
		/*******************文件柜*****文件上传****************************************/
	case 'addfile':
		include_once("./include/file_upload_class.php");
		$newfile=$uppath."user/$user_name/".date("Y")."/".date( "m")."/";
		$upload=new File_upload($newfile,$uptypes);
		$upload->renamed=1;
		$upload->upload();
		$t=$upload->get_succ_file();
		if($t[0]){
			$tempf=$uppath."user/".$user_name."/";
			$newfilepath=str_replace($tempf,"",$t[0]);
			$hash=getcode();
			$intime=time();
			$query="INSERT INTO `$table_file` ( `id` ,`title`, `path` ,`inputer`,`sender`, `intime`,`hash` )
                             VALUES ('','$title','$newfilepath','$user_id' ,'$user_id','$intime','$hash')";
			$db->query($query);
			unset($tempf,$newfilepath,$hash,$intime);
		}
		$referer="?filename=fileg&action=add";
		if($db->affected_rows()!=0){
			showmessage("文件添加成功！请返回！",$referer);
		}else
		showmessage("文件添加失败！请返回！",$referer);
		break;
	case 'filedel':
		//删除信息
		$sql="delete from $table_file where `id`=$fileid and `hash`='$hash' limit 1;";
		$db->query($sql) ;
		$referer="index.php?filename=fileg&action=list";
		if($db->affected_rows()!=0){
			showmessage("记录删除成功！请返回！",$referer);
		}else
		showmessage("记录删除失败！请返回！",$referer);
		break;
		break;
		/*******************文件柜*****文件转送****************************************/
	case 'filetouser':
		//选择用户
		$sql="select * from members where `realname`='$username' limit 1";
		$s=$db->query_first($sql);
		$touserid=$s[userid];
		$tousername=$s[username];
		//选择文件
		$sql="select * from $table_file where id=$fileid limit 1";
		$r=$db->query_first($sql);
		$title=$r[title];
		$oldfilepath="./".$uppath."user/$user_name/".$r[path];
		$filename=rand(100,999).substr(strrchr($r[path],"/"),4);
		$newdate=date("Y/m",time());
		$newpath=$uppath."user/$tousername/$newdate";
		$newfilepath=$newpath."/".$filename;
		$newfile=$newdate."/".$filename;
		createdir($newpath);
		if(copy($oldfilepath,$newfilepath)){
			$hash=getcode();
			$intime=time();
			$query="INSERT INTO `$table_file` ( `id` ,`title`, `path` ,`inputer`,`sender`, `intime`,`hash` )
                             VALUES ('','$title','$newfile','$touserid' ,'$user_id','$intime','$hash')";
			$db->query($query);
		}
		$referer="?filename=fileg&action=userdo";
		if($db->affected_rows()!=0){
			showmessage("文件转送成功！请返回！",$referer,'close');
		}else
		showmessage("文件转送失败！请返回！",$referer,'close');
		break;
		/***********************短信****添加***发送********************************/
	case 'addmessage':
		//格式化
		$title=str_in($title);
		$content=str_in($content);
		$username=str_in($username);
		$sendtime=time();
		//设置用户userid值
		$sql="select userid from members where realname='$username' limit 1";
		$r=$db->query_first($sql);
		$receive=$r[userid];
		$query="insert into $table_message ( `id`,`send`,`receive`,`sendtime`,`title`,`content`,`state`)
                          values ('','$user_id','$receive','$sendtime','$title','$content','0')";
		$db->query($query) ;
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?$referer[query]";
		if($db->affected_rows()!=0){
			showmessage("短信发送成功！请返回！",$referer);
		}else
		showmessage("短信发送失败！请返回！",$referer);
		break;
		/***********************通讯录****添加***********************************/
	case 'addletter':
		//格式化
		$username=str_in($username);
		$address=str_in($address);
		$work=str_in($work);
		$tel1=str_in($tel1);
		$tel2=str_in($tel2);
		$tel3=str_in($tel3);
		$qq=str_in($qq);
		$email=str_in($email);
		$msn=str_in($msn);
		//插入信息
		$query="insert into $table_letter ( `id`,`inputer`,`username`,`address`,`work`,`tel1`,`tel2`,`tel3`,`qq`,`email`,`msn`)
                          values ('','$user_id','$username','$address','$work','$tel1','$tel2','$tel3','$qq','$email','$msn')";
		$db->query($query) ;
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?$referer[query]";
		if($db->affected_rows()!=0){
			showmessage("通讯录添加成功！请返回！",$referer);
		}else
		showmessage("通讯录添加失败！请返回！",$referer);
		break;
		/***********************通讯录****编辑***********************************/
	case 'editletter':
		//格式化
		$username=str_in($username);
		$address=str_in($address);
		$work=str_in($work);
		$tel1=str_in($tel1);
		$tel2=str_in($tel2);
		$tel3=str_in($tel3);
		$qq=str_in($qq);
		$email=str_in($email);
		$msn=str_in($msn);
		//修改信息
		$sql="UPDATE $table_letter SET
    	                     `username`='$username', 
    	                     `address`='$address',
    	                     `work`='$work',
    	                     `tel1`='$tel1',
    	                     `tel2`='$tel2',
    	                     `tel3`='$tel3',
    	                     `qq`='$qq',
    	                     `email`='$email',
    	                     `msn`='$msn'
    	                     WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($sql) ;
		$referer=parse_url($HTTP_REFERER);
		$referer="index.php?filename=letter&action=person&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("通讯录编辑成功！请返回！",$referer);
		}else
		showmessage("通讯录编辑失败！请返回！",$referer);
		break;
		/***********************通讯录****删除***********************************/
	case 'delletter':
		//修改信息
		$sql="delete from $table_letter where id=$id;";
		$db->query($sql) ;
		$referer="index.php?filename=letter&action=person&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("记录删除成功！请返回！",$referer);
		}else
		showmessage("记录删除失败！请返回！",$referer);
		break;
		/***********************收藏夹****添加***********************************/
	case 'addfavorite':
		//格式化
		$title=str_in($title);
		$weburl=str_in($weburl);
		$note=str_in($note);
		$isshare=str_in($isshare);
		//插入信息
		$query="insert into $table_favorite ( `id`,`title`,`typeid`,`weburl`,`note`,`isshare`,`userid`)
                          values ('','$title','$ntypeid','$weburl','$note','$isshare','$user_id')";
		$db->query($query) ;
		$referer="index.php?filename=favorite&action=add&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("网站信息添加成功！请返回！",$referer);
		}else
		showmessage("网站信息添加失败！请返回！",$referer);
		break;
		/***********************收藏夹****编辑***********************************/
	case 'editfavorite':
		//格式化
		$title=str_in($title);
		$weburl=str_in($weburl);
		$note=str_in($note);
		$isshare=str_in($isshare);
		//修改信息
		$sql="UPDATE $table_favorite SET
    	                     `title`='$title',
    	                     `typeid`=$ntypeid, 
    	                     `weburl`='$weburl',
    	                     `note`='$note',
    	                     `isshare`='$isshare'
    	                     WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($sql) ;
		$referer="index.php?filename=favorite&action=list&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("网站信息编辑成功！请返回！",$referer);
		}else
		showmessage("网站信息编辑失败！请返回！",$referer);
		break;
		/***********************收藏夹****删除***********************************/
	case 'delfavorite':
		//修改信息
		$sql="delete from $table_favorite where id=$id;";
		$db->query($sql) ;
		$referer="index.php?filename=favorite&action=list&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("记录删除成功！请返回！",$referer);
		}else
		showmessage("记录删除失败！请返回！",$referer);
		break;
		/***********************课程表****添加***********************************/
	case 'addclasstable':
		//建立标题sql
		$query="insert into $table_classtable ( `id`,`classtitle`,`teacher`,`classnum`,`week`,`class`,`inyear`,`inputer`)
                               values('','0','0','0','0','$gradeid','$inyear','$user_id');";
		$db->query($query) ;
		$lastid=$db->insert_id();
		//数据数据sql
		foreach ($name as $key=> $value)
		{
			foreach($value as $key2 => $value2){
				$query="insert into $table_classtable ( `id`,`classtitle`,`teacher`,`classnum`,`week`,`class`,`inyear`,`inputer`,`state`)
                          values ('','$value2','".$teacher[$key][$key2]."','$key2','$key','$gradeid','$inyear','$user_id',$lastid);";
				$db->query($query) ;}
		}
		//插入信息
		//$db->query($query) ;
		$referer="index.php?filename=classtable&action=add&typeid=$typeid";
		if($db->affected_rows()!=0){
			showmessage("课程表添加成功！请返回！",$referer);
		}else
		showmessage("课程表添加失败！请返回！",$referer);
		break;
		/***********************课程表****编辑***********************************/
	case 'editclasstable':
		//修改班级的
		$query="UPDATE $table_classtable SET  `class` = '$gradeid'
	                                  WHERE `id` = '$upid' LIMIT 1 ;";
		$db->query($query) ;
		//数据sql
		foreach ($name as $key=> $value)
		{
			foreach($value as $key2 => $value2){
				$query="UPDATE $table_classtable SET `classtitle` = '$value2',
	                                  `teacher` = '".$teacher[$key][$key2]."',
	                                  `class` = '$gradeid' 
	                                  WHERE `id` = '".$ids[$key][$key2]."' LIMIT 1 ;";
				$db->query($query) ;
			}
		}
		//修改信息

		$referer="index.php?filename=classtable&action=list&typeid=$typeid";
		showmessage("课程表编辑成功！请返回！",$referer);
		break;
	case 'delclasstable':
		$referer="index.php?filename=classtable&action=list&typeid=$typeid";
		$query="DELETE FROM $table_classtable WHERE id=$id";
		$db->query($query);
		$query="DELETE FROM $table_classtable WHERE state=$id";
		$db->query($query);
		showmessage("课程表删除成功！请返回！",$referer);
		break;
		/***********************个人资料****编辑***********************************/
	case 'editinfo':
		$query="update members set `realname`='$realname',`subjectid`='$subjectid',`manageid`='$manageid' where userid='$user_id'";
		$db->query($query);
		//格式化
		$username=str_in($username);
		$address=str_in($address);
		$work=str_in($work);
		$tel1=str_in($tel1);
		$tel2=str_in($tel2);
		$tel3=str_in($tel3);
		$qq=str_in($qq);
		$email=str_in($email);
		$msn=str_in($msn);
		//查询是否有用户信息
		$sql="select id from userinfo where userid=$user_id limit 1";
		$db->query($sql);
		if($db->affected_rows()!=0){
			//说明存在信息，进行修改
			$sql="UPDATE userinfo SET
                           `sex`='$sex',    
    	                     `address`='$address',
    	                     `work`='$work',
    	                     `tel1`='$tel1',
    	                     `tel2`='$tel2',
    	                     `tel3`='$tel3',
    	                     `qq`='$qq',
    	                     `email`='$email',
    	                     `msn`='$msn'
    	                     WHERE `userid` = '$user_id' LIMIT 1 ;";
		}else {
			//没有信息存在，则进行添加
			$sql="INSERT INTO `userinfo` ( `id` , `userid` , `sex` , `address` , `work` , `tel1` , `tel2` , `tel3` , `qq` , `email` , `msn` )
                         VALUES (  '', '$user_id', '$sex', '$address', '$work', '$tel1', '$tel2', '$tel3', '$qq', '$email', '$msn');";
		}
		$db->query($sql);
		$referer="index.php?filename=user&action=infoedit";
		showmessage("个人信息编辑成功！请返回！",$referer);
		break;
		/***********************个人添加到单位通讯录中***********************************/
	case 'addtopub':
		//数据的读取
		$sql="select realname from members where userid=$user_id limit 1";
		$r=$db->query_first($sql);
		$username=$r[realname];
		$sql="select * from userinfo where userid=$user_id limit 1";
		$r=$db->query_first($sql);
		$address=$r[address];
		$work=$r[work];
		$tel1=$r[tel1];
		$tel2=$r[tel2];
		$tel3=$r[tel3];
		$qq=$r[qq];
		$email=$r[email];
		$msn=$r[msn];
		//查询是否有用户信息
		$sql="select id from $table_letter where inputer=$user_id and typeid=1 limit 1";
		$db->query($sql);
		if($db->affected_rows()!=0){
			//说明存在信息，进行修改
			$sql="UPDATE $table_letter SET
                           `username`='$username',
    	                     `address`='$address',
    	                     `work`='$work',
    	                     `tel1`='$tel1',
    	                     `tel2`='$tel2',
    	                     `tel3`='$tel3',
    	                     `qq`='$qq',
    	                     `email`='$email',
    	                     `msn`='$msn'
    	                     WHERE `inputer` = '$user_id' and typeid=1 LIMIT 1 ;";
		}else {
			//没有信息存在，则进行添加
			$sql="INSERT INTO `$table_letter` ( `id` , `inputer` ,`username`,  `address` , `work` , `tel1` , `tel2` , `tel3` , `qq` , `email` , `msn` ,`typeid`)
                         VALUES (  '', '$user_id', '$username', '$address', '$work', '$tel1', '$tel2', '$tel3', '$qq', '$email', '$msn','1');";
		}
		$db->query($sql);

		$referer="index.php?filename=letter&action=public&typeid=$typeid";
		showmessage("个人信息添加到通讯录成功！请返回！",$referer);
		break;
		/***********************默认左右分类桌面显示设置***********************************/
	case 'setdefaulttable':
		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]defaulttable\s*\=\s*[\"'].*?[\"']/is", "\$defaulttable = '$typesid'", $configfile);
		$fp = fopen('./config.php', 'w');
		$referer="index.php?filename=table&action=settable";
		if(@fwrite($fp, trim($configfile))){
			showmessage("分栏设置成功！",$referer);
		}else
		showmessage("分栏设置失败！",$referer);
		fclose($fp);
		break;
		/***********************默认左分类桌面显示设置***********************************/
	case 'setdefaultlefttable':
		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]defaultleft\s*\=\s*[\"'].*?[\"']/is", "\$defaultleft = '$typesid'", $configfile);
		$fp = fopen('./config.php', 'w');
		$referer="index.php?filename=table&action=settableleft";
		if(@fwrite($fp, trim($configfile))){
			showmessage("分栏设置成功！",$referer);
		}else
		showmessage("分栏设置失败！",$referer);
		fclose($fp);
		break;
		/***********************默认右分类桌面显示设置***********************************/
	case 'setdefaultrighttable':
		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]defaultright\s*\=\s*[\"'].*?[\"']/is", "\$defaultright = '$typesid'", $configfile);
		$fp = fopen('./config.php', 'w');
		$referer="index.php?filename=table&action=settableright";
		if(@fwrite($fp, trim($configfile))){
			showmessage("分栏设置成功！",$referer);
		}else
		showmessage("分栏设置失败！",$referer);
		fclose($fp);
		break;
		/***********************左右桌面显示设置***********************************/
	case 'settable':

		if ($tableclass=="right") {
			$sql="UPDATE userinfo SET  `tableright`='$typesid'
    	                     WHERE `userid` = '$user_id'  LIMIT 1 ;";
		} else {
			$sql="UPDATE userinfo SET  `tableleft`='$typesid'
    	                     WHERE `userid` = '$user_id'  LIMIT 1 ;";
		}
		$db->query($sql);
		$referer="?filename=user&action=tableedit&class=$class";
		if($db->affected_rows()!=0){
			showmessage("桌面显示设置成功！请返回！",$referer);
		}else
		showmessage("桌面显示设置失败！请返回！",$referer);
		break;

	case 'specialadd':

		$query="INSERT INTO `$table_special` ( `specialid` , `specialname` , `specialpic` , `keywords` , `discription` , `specialtemplate` , `specialstyle` , `elite` , `close` , `addtime` , `master` )
VALUES ('', '$specialname', '$specialpic', '$keywords', '$discription', '$specialtemplate', '$specialstyle', '$elite', '0', '0', '0');";


		$db->query($query);

		$referer="?filename=special&action=addspecial";
		if($db->affected_rows()!=0){
			showmessage("专题添加成功！请返回！",$referer);
		}else
		showmessage("专题添加失败！请返回！",$referer);

		break;
	case 'specialedit':
		$query="UPDATE `$table_special` SET `specialname` = '$specialname',
             `specialpic` = '$specialpic',
             `keywords` = '$keywords',
             `discription` = '$discription',
             `specialtemplate` = '$specialtemplate',
             `specialstyle` = '$specialstyle',
             `elite` = '$elite' WHERE `specialid` = '$id' LIMIT 1 ;";
		$db->query($query);

		$referer="?filename=special&action=listspecial";
		if($db->affected_rows()!=0){
			showmessage("专题修改成功！请返回！",$referer);
		}else
		showmessage("专题修改失败！请返回！",$referer);
		break;
	case 'deletereply':
		if(is_array($delete)) {
			$ids = $comma =	"";
			foreach($delete	as $id)	{
				$ids .=	"$comma'$id'";
				$comma = ", ";
			}
			$query="DELETE FROM $table_replys WHERE id IN ($ids)";
			$db->query($query);
		}
		if($db->affected_rows()!=0){

			$addtime=$addtime?$addtime:time();
			$html->createhtml($rootpath.'/show.php?id='.$articleid,$addtime);

			showmessage("评论删除成功！请返回！");
		}else{
			showmessage("评论删除失败！请返回！");
		}
		break;

	case 'updatehtml':

		$html->setvar('name','name','./');
		$html->createhtml($rootpath.'/index.php',0,'.','index.htm');

		$html->setvar('query','name',$htmldir);
		$query="select typeid from $table_types where isupdate=1";
		$result=$db->query($query);

		if($db->num_rows($result)){

			while($r=$db->fetch_array($result)){
				$typeids[]=$r[typeid];
				$html->createhtml($rootpath.'/list.php?typeid='.$r[typeid],0,'lists');

				$query="select count(id) as num from $table_articles where typeid='$r[typeid]' and state>0 ";
				$result1=$db->query($query);
				$row=$db->fetch_array($result1);
				$number=$row["num"];
				$pages=ceil($number/$pagesize);
				for($i=1;$i<=$pages;$i++){
					$html->createhtml($rootpath.'/list.php?typeid='.$r[typeid].'&page='.$i,0,'lists');
				}
			}

			$typeids=join(',',$typeids);
			$query="update $table_types set isupdate=0 where typeid in ($typeids)";
			$db->query($query);

		}

		showmessage("网页更新成功！");

		break;

	case 'tohtml':

		if($fid>$tid){
			showmessage("起始ID不得大于结束ID！");
			exit();
		}

		if(($fid+1000)<$tid){
			showmessage("起始ID与结束ID之差不得超过1000！");
			exit();
		}

		$query="select id,addtime from $table_articles where id>='$fid' and id<='$tid'";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$id=$r[id];
			$addtime=$r[addtime];
			$html->createhtml($rootpath.'/show.php?id='.$id,$addtime);
		}

		showmessage("ID从".$fid."至".$tid."的网页更新成功！");

		break;

	case 'upfile':

		if(empty($photo)){
			showmessage("对不起，没有上传文件！");
			exit();
		}
		if($photo_size==0){
			showmessage("对不起，上传文件的字节数为0！");
			exit();
		}
		if(!is_uploaded_file($photo)){
			showmessage("对不起，文件上传失败！");
			exit();
		}

		if($type=file_type($photo_name,$notuptypes)){
			showmessage("对不起，请不要上传".$type."格式的文件！");
			exit();
		}
		$savepath="upfiles/".$path.'/'.$photo_name;
		$savepathtemp="../upfiles/".$path.'/'.$photo_name;
		if(copy($photo,$savepathtemp)){
			showmessage("<script>window.opener.theform.".$thename.".value='".$rootpath."/".$savepath."';window.close();</script>");
		}

		break;

	case 'updatespecials':

		if(is_array($typeids)) {
			foreach($typeids as $id =>$val) {
				$image=${'image'.$id};
				$query="UPDATE $table_types SET title='$title[$id]',url='$url[$id]',image='$image',isupdate='1' WHERE typeid='$id'";
				$db->query($query);
			}
		}
		showmessage("专题信息更新成功！",$referer);

		break;

	case 'deleteannouncements':
		$db->query("DELETE FROM $table_announcements WHERE id='$id'");
		$referer="?filename=announcement";
		showmessage("指定公告成功删除",$referer);

		break;

	case 'addannouncement':
		$addtime=time();
		$title = dhtmlspecialchars($title);
		if(strpos($starttime, "-")) {
			$time = explode("-", $starttime);
			$starttime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
		} else {
			$starttime = 0;
		}
		if(strpos($endtime, "-")) {
			$time = explode("-", $endtime);
			$endtime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
		} else {
			$endtime = 0;
		}

		if(!$starttime) {
			showmessage("您必须输入起始时间，请返回修改。");
		} elseif(!trim($title) || !trim($content)) {
			showmessage("您必须输入公告标题和内容，请返回修改。");
		} else {
			$db->query("INSERT INTO $table_announcements (classid, author, title, starttime, endtime, content,addtime)
		VALUES ('$classid','$user_name', '$title', '$starttime', '$endtime', '$content','$addtime')");
			$referer="?filename=announcement";
			showmessage("公告添加成功!",$referer);
		}

		break;

	case 'editannouncement':

		$title = dhtmlspecialchars($title);
		if(strpos($starttime, "-")) {
			$time = explode("-", $starttime);
			$starttime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
		} else {
			$starttime = 0;
		}
		if(strpos($endtime, "-")) {
			$time = explode("-", $endtime);
			$endtime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
		} else {
			$endtime = 0;
		}

		if(!$starttime) {
			showmessage("您必须输入起始时间，请返回修改。");
		} elseif(!trim($title) || !trim($content)) {
			showmessage("您必须输入公告标题和内容，请返回修改。");
		} else {
			$db->query("UPDATE $table_announcements SET classid='$classid', title='$title', starttime='$starttime', endtime='$endtime', content='$content' WHERE articleid='$articleid'");
			$referer="?filename=announcement";
			showmessage("公告成功编辑。",$referer);
		}

		break;

	case 'updatefriendlinks':

		if(is_array($delete)) {
			$ids = $comma =	"";
			foreach($delete	as $id)	{
				$ids .=	"$comma'$id'";
				$comma = ", ";
			}
			$db->query("DELETE FROM	$table_friendlinks WHERE id IN ($ids)");
		}

		if(is_array($name)) {
			foreach($name as $id =>	$val) {
				$logo[$id]=${'logo'.$id};
				$db->query("UPDATE $table_friendlinks SET displayorder='$displayorder[$id]', name='$name[$id]', url='$url[$id]',	note='$note[$id]', logo='$logo[$id]' WHERE id='$id'");
			}
		}

		if($newname != "") {
			$db->query("INSERT INTO	$table_friendlinks (displayorder, name, url, note, logo) VALUES ('$newdisplayorder', '$newname',	'$newurl', '$newnote', '$newlogo')");
		}
		$referer="?filename=friendlink";
		showmessage("友情链接更新成功！",$referer);

		break;

	case 'updateads':
		$referer="?filename=ads";
		if(is_array($delete)) {
			$ids = $comma =	"";
			foreach($delete	as $id)	{
				$ids .=	"$comma'$id'";
				$comma = ", ";
			}
			$db->query("DELETE FROM	$table_ads WHERE id IN ($ids)");
		}

		if(is_array($name)) {
			foreach($name as $id =>	$val) {
				if(strpos($newstarttime, "-")) {
					$time = explode("-", $starttime[$id]);
					$starttime[$id] = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
				} else {
					$starttime[$id] = 0;
				}
				if(strpos($endtime[$id], "-")) {
					$time = explode("-", $endtime[$id]);
					$endtime[$id] = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
				} else {
					$endtime[$id] = 0;
				}

				$filepath=${'filepath'.$id};
				$db->query("UPDATE $table_ads SET name='$name[$id]', note='$note[$id]',filepath='$filepath', url='$url[$id]', type='$type[$id]',starttime='$starttime[$id]', endtime='$endtime[$id]',price='$price[$id]' WHERE id='$id'");
			}
		}

		if($newname != "") {

			if(strpos($newstarttime, "-")) {
				$time = explode("-", $newstarttime);
				$newstarttime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
			} else {
				$newstarttime = 0;
			}
			if(strpos($newendtime, "-")) {
				$time = explode("-", $newendtime);
				$newendtime = gmmktime(0, 0, 0, $time[1], $time[2], $time[0]) - $timeoffset * 3600;
			} else {
				$newendtime = 0;
			}
			if(!$newstarttime) {
				showmessage("您必须输入起始时间，请返回修改。");
			} elseif(!trim($newfilepath) || !trim($newurl)) {
				showmessage("您必须输入广告文件地址和链接地址，请返回修改。");
			} else {
				$addtime=time();
				$db->query("INSERT INTO	$table_ads (name,note,filepath, url,type,starttime,endtime, price, addtime)	VALUES ('$newname','$newnote','$newfilepath','$newurl','$newtype','$newstarttime','$newendtime', '$newprice', '$addtime')");
			}
		}

		$time=time();
		$query="select name,type from $table_ads where starttime<$time and ( endtime>$time or endtime=0 )";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){

			if(strstr($r[type],'*')){
				$type=explode("*",$r[type]);
				$width=$type[0];
				$height=$type[1];
			}
			$adjs="document.write(\"<iframe src=".$rootpath."/ad/".$r[name].".htm width=".$width." height=".$height." align=left frameborder=no border=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no></iframe>\")";
			$fp=@fopen("ad/js/".$r[name].".js","w");
			@fwrite($fp,$adjs) or die("can not write the file ad/js/".$r[name].".js please check it is writable!" );
			fclose($fp);
		}
		showmessage("广告信息更新成功！",$referer);

		break;

	case 'exportdata':

		set_time_limit(1200);

		foreach($tables as $table) {
			$sqldump .= sqldumptable($tablepre.$table);
		}
		$filename=date("Ymd",time()).".sql";
		@$fp = fopen("data/".$filename, "w");
		@flock($fp, 3);
		if(@!fwrite($fp, $sqldump)) {
			showmessage("数据无法备份到服务器！",$referer);
			exit();
		}
		header("Content-type: application/force-download");
		header("Content-Disposition: attachment; filename=".$filename);
		echo $sqldump;

		break;

	case 'importdata':

		set_time_limit(1200);

		if($from == "server") {
			$datafile = $datafile_server;
			$datafile_size = @filesize($datafile_server);
		}
		@$fp = fopen($datafile, "r");
		if($datafile_size) {
			@flock($fp, 3);
			$sqldump = @fread($fp, $datafile_size);
		} else {
			$sqldump = @fread($fp, 99999999);
		}
		@fclose($fp);
		$sqlquery = splitsql($sqldump);
		unset($sqldump);
		foreach($sqlquery as $sql) {
			if(trim($sql) != '') {
				$db->query($sql);
			}
		}
		showmessage("数据恢复成功！",$referer);

		break;

	case 'useradd':
		$username=addslashes($username);
		$password=addslashes($password);
		if ($admining)$admining=0;
		if($password==""){showmessage("密码不能为空！",$referer);exit();}
		$password=md5($password);
		$query="select * from members where username='$username'";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){showmessage("已经有用户存在！",$referer); exit();}
		$query="INSERT INTO `members` ( `userid` , `username` ,`realname`, `password` , `groupid` ,`admining`, `subjectid` , `manageid` ) VALUES ('', '$username', '$realname','$password', '$groupid', '$admining','$subjectid','$manageid')";
		$db->query($query);
		$referer="?filename=user&action=useradd";
		if($db->affected_rows()>0){
			showmessage("用户添加成功！",$referer);}
			else showmessage("用户添加失败！",$referer);
			break;
	case 'useredit':
		$query="update members set `realname`='$realname',`groupid`='$groupid',`subjectid`='$subjectid',`manageid`='$manageid' where userid='$userid'";
		$db->query($query);
		$referer="?filename=user&action=useredit";
		if($db->affected_rows()>0){
			showmessage("用户修改成功！",$referer);}
			else showmessage("用户修改失败！",$referer);
			break;
	case 'userdel':
		$referer="?filename=user&action=useredit";
		//删除
		$sql2="delete from `userinfo` where `userid`='$userid' limit 1";
		$db->query($sql2);
		$sql="delete from `members` where `userid`='$userid' limit 1";
		$db->query($sql);

		if($db->affected_rows()>0){
			showmessage("用户删除成功！请返回！",$referer);
		}
		break;
	case 'modifypassword':
		if ($group_id>1){
			echo "asdf";
			$oldpassword=addslashes($oldpassword);
			$password=addslashes($password);
			$password1=addslashes($password1);
			$oldpassword=md5($oldpassword);
			if($password=="" || $password1=="" || $oldpassword==""){showmessage("密码不能为空！",$referer);exit();}
			if($password!=$password1){showmessage("两次输入的新密码不一样！",$referer);exit();}
			$query="select * from members where username='$user_name' and password='$oldpassword'";
			$result=$db->query($query);
			if($db->num_rows($result)==0){showmessage("原密码错误！",$referer);exit();}
			$password=md5($password);
			$query="update members set password='$password' where username='$user_name'";
		} else{
			$password=addslashes($password);
			$password=md5($password);
			$query="update members set password='$password' where username='$username'";

		}
		$db->query($query);
		$referer="?filename=user&action=modifypassword";
		if($db->affected_rows()>0){
			showmessage("密码修改成功！",$referer);}
			else showmessage("密码修改失败！",$referer);
			break;
	case 'chajianadd':
		$referer="?filename=chajian";
		$query="select * from $table_chajian where title='$title'";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){showmessage("已经有插件存在！",$referer); exit();}
		$query="INSERT INTO `$table_chajian` ( `title` , `path` ) VALUES ('$title', '$path')";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("插件添加成功！",$referer);}
			else showmessage("插件添加失败！",$referer);
			break;
	case 'chajianedit':
		$referer="?filename=chajian";
		$query="update $table_chajian set title='$title',path='$path' where id='$id'";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("插件修改成功！",$referer);}
			else showmessage("插件修改失败！",$referer);
			break;
	case 'manageadd':
		$referer="?filename=setting&action=manage&do=add";
		$sql="select * from `management` where `manageid`='$manageid' limit 1";
		$result=$db->query($sql);
		if ($db->num_rows($result)==0){
			$query="INSERT INTO `management` (`manageid`, `managename` , `managetel` ) VALUES ('$manageid','$managename', '$managetel')";
			$db->query($query);
			if($db->affected_rows()>0){
				showmessage("部门添加成功！",$referer);}
				else showmessage("部门添加失败！",$referer);
		}else showmessage("部门添加失败！已经存在一个相同的编号",$referer);
		break;
	case 'manageedit':
		$referer="?filename=setting&action=manage&do=list";
		$query="UPDATE `management` SET `manageid`='$manageid',`managename` = '$managename',`managetel`='$managetel' WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("部门编辑成功！",$referer);}
			else showmessage("部门编辑失败！",$referer);
			break;
	case 'managedel':
		$referer="?filename=setting&action=manage&do=list";
		//删除
		$sql="delete from `management` where `id`='$id' limit 1";
		$db->query($sql);
		if(($db->affected_rows()>0) ){
			showmessage("部门删除成功！请返回！",$referer);
		}
		break;
	case 'groupadd':
		$referer="?filename=setting&action=group&do=add";
		$sql="select * from `usergroup` where `groupid`='$groupid' limit 1";
		$result=$db->query($sql);
		if ($db->num_rows($result)==0){
			$query="INSERT INTO `usergroup` ( `groupid`,`grouptitle` , `usize` ) VALUES ('$groupid','$grouptitle', '$usize')";
			$db->query($query);
			if($db->affected_rows()>0){
				showmessage("组别添加成功！",$referer);}
				else showmessage("组别添加失败！",$referer);
		}else showmessage("组别添加失败！已经存在一个相同的编号",$referer);
		break;
	case 'groupedit':
		$referer="?filename=setting&action=group&do=list";
		$query="UPDATE `usergroup` SET `groupid`='$groupid', `grouptitle` = '$grouptitle',`usize`='$usize' WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("组别编辑成功！",$referer);}
			else showmessage("组别编辑失败！",$referer);
			break;
	case 'groupdel':
		$referer="?filename=setting&action=group&do=list";
		//删除
		$sql="delete from `usergroup` where `id`='$id' limit 1";
		$db->query($sql);
		if(($db->affected_rows()>0) ){
			showmessage("组别删除成功！请返回！",$referer);
		}
		break;
	case 'subjectadd':
		$referer="?filename=setting&action=subject&do=add";
		$sql="select * from `subject` where `subjectid`='$subjectid' limit 1";
		$result=$db->query($sql);
		if ($db->num_rows($result)==0){
			$query="INSERT INTO `subject` (`subjectid`, `subjectname`  ) VALUES ('$subjectid','$subjectname')";
			$db->query($query);
			if($db->affected_rows()>0){
				showmessage("学科添加成功！",$referer);}
				else showmessage("学科添加失败！",$referer);
		}else 	showmessage("学科添加失败！已经存在一个相同的编号",$referer);
		break;
	case 'subjectedit':
		$referer="?filename=setting&action=subject&do=list";
		$query="UPDATE `subject` SET `subjectid`='$subjectid',`subjectname` = '$subjectname' WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("学科编辑成功！",$referer);}
			else showmessage("学科编辑失败！",$referer);
			break;
	case 'subjectdel':
		$referer="?filename=setting&action=subject&do=list";
		//删除
		$sql="delete from `subject` where `id`='$id' limit 1";
		$db->query($sql);
		if(($db->affected_rows()>0) ){
			showmessage("学科删除成功！请返回！",$referer);
		}
		break;
	case 'classadd':
		switch ($school_type){
			case '1':
				$statename="小";
				break;
			case '2':
				$statename="初";
				break;
			case '3':
				$statename="高";
				break;
			case '12':
				if($gradeid<=6) $statename="小";else $statename="初";
				break;
		}
		$referer="?filename=setting&action=classset&do=add";
		$gradearr=array("1"=>"一","2"=>"二","3"=>"三","4"=>"四","5"=>"五","6"=>"六","7"=>"七","8"=>"八","9"=>"九");
		$classarr=array("01"=>"(1)班","02"=>"(2)班","03"=>"(3)班","04"=>"(4)班","05"=>"(5)班","06"=>"(6)班","07"=>"(7)班",
		"08"=>"(8)班","09"=>"(9)班","10"=>"(10)班","11"=>"(11)班","12"=>"(12)班");
		$classid=$gradeid.$noid;
		$classname=$statename.$gradearr[$gradeid].$classarr[$noid];
		$sql="select * from `classset` where `classid`='$classid' limit 1";
		$result=$db->query($sql);
		if ($db->num_rows($result)==0){
			$query="INSERT INTO `classset` (`classid`, `classname` ,`gradeid` ) VALUES ('$classid','$classname','$gradeid')";
			$db->query($query);
			if($db->affected_rows()>0){
				showmessage("班级添加成功！",$referer);
			}else showmessage("班级添加失败！",$referer);
		}
		else showmessage("班级添加失败！已经存在一个相同的编号",$referer);
		break;
	case 'classedit':
		$referer="?filename=setting&action=classset&do=list";
		switch ($school_type){
			case '1':
				$statename="小";
				break;
			case '2':
				$statename="初";
				break;
			case '3':
				$statename="高";
				break;
			case '12':
				if($gradeid<=6) $statename="小";else $statename="初";
				break;
		}
		$gradearr=array("1"=>"一","2"=>"二","3"=>"三","4"=>"四","5"=>"五","6"=>"六","7"=>"七","8"=>"八","9"=>"九");
		$classarr=array("01"=>"(1)班","02"=>"(2)班","03"=>"(3)班","04"=>"(4)班","05"=>"(5)班","06"=>"(6)班","07"=>"(7)班",
		"08"=>"(8)班","09"=>"(9)班","10"=>"(10)班","11"=>"(11)班","12"=>"(12)班");
		$classname=$statename.$gradearr[$gradeid].$classarr[$noid];
		$classid=$gradeid.$noid;
		$query="UPDATE `classset` SET `classid`='$classid',`classname` = '$classname',`gradeid`=$gradeid WHERE `id` = '$id' LIMIT 1 ;";
		$db->query($query);
		if($db->affected_rows()>0){
			showmessage("班级编辑成功！",$referer);}
			else showmessage("班级编辑失败！",$referer);
			break;
	case 'classdel':
		$referer="?filename=setting&action=classset&do=list";
		//删除
		$sql="delete from `classset` where `id`='$id' limit 1";
		$db->query($sql);
		if(($db->affected_rows()>0) ){
			showmessage("班级删除成功！请返回！",$referer);
		}
		break;
}

?>
