<?php
/*
����ɽ��Сѧ����칫��
*/
error_reporting(7);
//Ȩ�޼��
if ($group_id!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
//���ݱ�������
if ($_GET['action']){$action=$_GET['action'];}else{$action=$_POST['action'];};
switch($action){
	//ɾ�������¼����
	case 'removeadmin':
		if($pass == $dellog_pass)
		{
			$db->query("DELETE FROM $table_adminlog");
			showmessage("���м�¼��ɾ��!", "?filename=log&action=admin");
		} else {
			showmessage("ɾ����־���ܳ״���!", "?filename=log&action=admin");
		}
		break;//removeadminall

		//ɾ����½��¼����
	case 'removelogin':
		if($pass == $dellog_pass)
		{
			$db->query("DELETE FROM $table_loginlog");
			showmessage("���м�¼��ɾ��", "?filename=log&action=login");
		} else {
			showmessage("ɾ����־���ܳ״���!", "?filename=log&action=login");
		}
		break;//removeadminall
		//������־ҳ��
	case 'admin':
		//��ҳ����
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

		//ɾ��������־ҳ��
	case 'deladmin':
		break;
		//end delall
		//��½��־ҳ��
	case 'login':
		//��ҳ����
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
				$result="�ɹ�";
			} else {
				$result="<font color=\"#FF0000\">ʧ��</td>\n";
			}
			$intime=date("Y-m-d H:i:s",$loginlog[date]);
			$content[]=array('loginlogid'=>$loginlog[loginlogid],'logusername'=>$loginlog[username],'intime'=>$intime,
			'logpassword'=>$loginlog[password],'logipaddress'=>$loginlog[ipaddress],'result'=>$result);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;//end login
		//ɾ����½��־ҳ��
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