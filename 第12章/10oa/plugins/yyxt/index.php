<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �๦�ܽ��ҵǼ�ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

ob_start();

require './global.php';

if(@file_exists('./install.php')) {
	@unlink('./install.php');
	if(@file_exists('./install.php')) {
		message('Please delete install.php via FTP!');
		exit();
	}
}

@set_time_limit(600);
?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?=$sitetitle;?></title>
<?=$css;?>
<script language="JavaScript">
function checkall(form) {
	for(var i = 0;i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall' && e.disabled != true) {
			e.checked = form.chkall.checked;
		}
	}
}

function redirect(url) {
	window.location.replace(url);
}
</script>
</head>
<?php
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
//���÷�����ҵ�gtypeidֵ
/*if (isset($typesid)){
setcookie("gtypeid","",time()-3600);
setcookie("gtypeid",$typesid);
}
$gtypeid=$_COOKIE[gtypeid];
*/
unset($cookie_id);
$filenames=array('index','order','admin','main','deal','setting','list','pass','type','special','upfile','login','cache','friendlink','log','setvar','user','chajian','review','database','template','contribute','log','editor','announcement','search');
$filename = empty($filename) ? 'index' : $filename;

if(in_array($filename,$filenames)){
	require $admin_root.'/'.$filename.'.php';
}else {
	exit("�����������ļ������ڣ��Բ���ò�������ִ�У�");
}
?>