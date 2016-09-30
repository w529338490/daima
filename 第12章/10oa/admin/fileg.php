<?php
/*
凤鸣山中小学网络办公室
*/
//栏目数据读取
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="全部文章";
}
$tpl->assign("now_typename",$now_typename);
if ($action=="")$action="list";
switch($action){
	//添加编辑操作
	case 'add':
		break;
		//文件柜列表
	case 'list':
		//参数设置
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//分页设置
		$query="select count(*) as num from $table_file where inputer=$user_id";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//相应版块数据读取
		$query="select $table_file.*,members.realname
        from $table_file
        left join members on $table_file.sender=members.userid
        where inputer=$user_id
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){

			$intime=date("Y/m/d",$r[intime]);
			$content[]=array("id"=>$r[id],"title"=>$r[title],"realname"=>$r[realname],"intime"=>$intime,"hash"=>$r[hash]);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		if (!$content) $content="今日没有事务！";
		break;
		//删除文件
	case 'filedel':
		showmessage("是否删除此文件", $url_forward = "?filename=deal&action=filedel&fileid=$fileid&hash=$hash", $msgtype = 'form');
		break;
		//发文件给其他用户
	case 'userdo':
		//读取用户组
		$query="select * from usergroup order by groupid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$showgroup.="<option value='$r[groupid]'>$r[grouptitle]</option>";
		}
		//读取部门信息
		$query="select * from management order by manageid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$managements[$r[manageid]]=$r[managename];
			$showmanage.="<option value='$r[manageid]'>$r[managename]</option>";
		}
		//读取学科信息
		$query="select * from subject order by subjectid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$showsubject.="<option value='$r[subjectid]'>$r[subjectname]</option>";
		}
		//设置数据
		while (list($key,$value)=each($managements)){
			$managementlist.="<option value=$key>$value</option>";
		}
		if ($manageid){
			$query="SELECT * FROM `members` where manageid=$manageid";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$userlist.= "<option value=$r[userid]>$r[realname]</option>";
			}
		}
		$tpl->assign(array("fileid"=>$fileid,"userlist"=>$userlist,'manageid'=>$manageid,"managementlist"=>$managementlist,"showsubject"=>$showsubject));
		break;
}
$tpl->assign('action',$action);
$tpl->display('fileg.html');
?>