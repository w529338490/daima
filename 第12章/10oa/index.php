<?php
/*
����ɽ��Сѧ����칫��
*/
function gettime()
{
	$t = explode(" ",microtime());
	return $t[1] + $t[0];
}
$start = gettime();
//��ʼ����
ob_start("ob_gzhandler");
//����global�ļ�
require './global.php';
//�Ƿ���ʾִ��ʱ��
if ($showtime==0) $start=0;
//��ⰲװ�ļ��Ƿ����
if(@file_exists('./install/install.php')) {
	@unlink('./install/install.php');
	if(@file_exists('./install/install.php')) {
		message('Please delete install.php via FTP!');
		exit();
	}
}
//��������sqlע��
$_POST = sql_injection($_POST);
$_GET = sql_injection($_GET);
//���ýű�ִ��ʱ��Ϊ600��
@set_time_limit(600);
//����session_id
//print_r($_COOKIE);
$sid=$_COOKIE['sid'];
if($sid!="") {session_id($sid);}
session_start();
//��ȡ�û������id�ţ������������ע�����������
if (session_is_registered("user_system_id")){
	$user_system_ids=$_SESSION["user_system_id"];
	$user_system_ids=explode("|",$user_system_ids);
	$user_id=$user_system_ids[0];    //�û�idֵ
	$system_id=$user_system_ids[1];  //ϵͳidֵ
	if ($system_id!=1) {
		unset($user_system_ids,$user_id,$system_id);
		showmessage("�Բ������Ѿ������˱������ҿ�������һ����Ʒ��<bt>���˳��ò�Ʒ","?filename=login");
	}
}else{
	unset($user_system_id,$user_id,$system_id);
};
//�ж��Ƿ�����
if($filename!='login'){
	if(!isset($user_id)) $_GET['filename']='login';
}

//���ù���Ȩ��
//�������cookie��Ϣ���ȡcookie[group]����Ȩ����Ϣ
if (isset($_COOKIE[group])){
	$group=explode("|", $_COOKIE[group]);
	$cookie_id=$group[0];  //�û�idֵ
	$group_id=$group[1];   //�û����
	$admin_id=$group[2];   //�û�Ȩ��
	$user_name=$group[3];  //�û�����
	$real_name=$group[4];   //�û���ʵ����
}
//����Ƿ����$user_id��$cookie_id��ȣ������������������cookie[group_id]����Ȩ����Ϣ
if (($user_id!=$cookie_id) and isset($user_id)){
	$query="select username,realname,groupid,admining from members where `userid`='$user_id' and `groupid`<5 limit 1";
	$result=$db->query($query);
	//�Ƿ��ǳ�������Ա����ͨ����Ա
	if($db->num_rows($result)==1){
		$r=$db->fetch_array($result);
		$cookie_id=$user_id;      //�û�id
		$user_name=$r[username];  //�û���
		$group_id=$r[groupid];    //�û���
		$admin_id=$r[admining];   //��������Ȩ��
		$real_name=$r[realname];   //�û���ʵ����
		setcookie("group","$cookie_id|$group_id|$admin_id|$user_name|$real_name");
	}
}

unset($cookie_id);
//���ÿɲ������ļ�
$filename=$_GET['filename'];
$filenames=array('index','left','header','main','deal','info','login','setting','type','file','user','article','list','leave','calendar','schedule','fileg','softdown','message','letter','table','favorite','classtable','show','soft_down','ftp','userlist','blank','register','rmsoft','setvar','log','reg');
$filename = empty($filename) ? 'index' : $filename;
//������¼
getlog();
//��ʼ�� ����
$tpl->assign(array('style'=>$style,'rootpath'=>$rootpath,'sitetitle'=>$sitetitle,'school_name'=>$school_name));
//��ȡ��Ӧ�ļ����
if(in_array($filename,$filenames)){
	include_once($admin_root.'/'.$filename.'.php');
}else {
	exit("�����������ļ������ڣ��Բ���ò�������ִ�У�");
}
?>
