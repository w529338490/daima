<?php
/*
凤鸣山中小学网络办公室
*/
error_reporting(7);
//权限检测
if ($group_id!=1) showmessage("对不起，你没有权限访问！");
//传递变量处理
if ($_GET['action']){$action=$_GET['action'];}else{$action=$_POST['action'];};
switch($action){
	//删除管理记录操作
	case 'removeadmin':
		if($pass == $dellog_pass)
		{
			$db->query("DELETE FROM $table_adminlog");
			showmessage("所有记录已删除!", "?filename=log&action=admin");
		} else {
			showmessage("删除日志的密匙错误!", "?filename=log&action=admin");
		}
		break;//removeadminall

		//删除登陆记录操作
	case 'removelogin':
		if($pass == $dellog_pass)
		{
			$db->query("DELETE FROM $table_loginlog");
			showmessage("所有记录已删除", "?filename=log&action=login");
		} else {
			showmessage("删除日志的密匙错误!", "?filename=log&action=login");
		}
		break;//removeadminall
		//管理日志页面
	case 'admin':
		//分页设置
		$query="select count(*) as num from $table_adminlog";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$listurl="?filename=log&action=admin";
		$pagenav=getpagenav($totalnum,$listurl);
		$adminlogs = $db->query("SELECT * FROM $table_adminlog ORDER BY adminlogid DESC LIMIT  $curpage,$perpage");
		while($adminlog=$db->fetch_array($adminlogs)){
			$intime=date("Y-m-d H:i:s",$adminlog[date]);
			$content[]=array('adminlogid'=>$adminlog[adminlogid],'inaddress'=>$adminlog[ipaddress],'intime'=>$intime,
			'logscript'=>$adminlog[script],'logaction'=>$adminlog[action]);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;//end admin

		//删除管理日志页面
	case 'deladmin':
		break;
		//end delall
		//登陆日志页面
	case 'login':
		//分页设置
		$query="select count(*) as num from $table_loginlog";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$listurl="?filename=log&action=login";
		$pagenav=getpagenav($totalnum,$listurl);

		$loginlogs = $db->query("SELECT * FROM $table_loginlog ORDER BY loginlogid DESC LIMIT $curpage,$perpage");
		while($loginlog=$db->fetch_array($loginlogs)){
			if($loginlog[result] == "1")
			{
				$result="成功";
			} else {
				$result="<font color=\"#FF0000\">失败</td>\n";
			}
			$intime=date("Y-m-d H:i:s",$loginlog[date]);
			$content[]=array('loginlogid'=>$loginlog[loginlogid],'logusername'=>$loginlog[username],'intime'=>$intime,
			'logpassword'=>$loginlog[password],'logipaddress'=>$loginlog[ipaddress],'result'=>$result);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;//end login
		//删除登陆日志页面
	case 'dellogin':
		break;
	default:
		exit;
		break;
}
//end delloginall
$tpl->assign('action',$action);
$tpl->display('log.html');
?>   