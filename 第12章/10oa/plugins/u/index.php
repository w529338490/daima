<?php
/*
[slcms] php����Ӳ��ϵͳ
This is a freeware
Version: 1.5.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ�
Copyright: ����У԰ (www.nbcjzx.com)
Last Modified: 2007/4/23 16:04
*/
//��ʼ����
ob_start();
//����global�ļ�
require './global.php';
//��������sqlע��
$_POST = sql_injection($_POST);
$_GET = sql_injection($_GET);
//���ýű�ִ��ʱ��Ϊ600��
@set_time_limit(600);

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
if($filename!='login') checkadmin("�Բ������¼��",'?'.$QUERY_STRING);
//���ù���Ȩ��
//�������cookie��Ϣ���ȡcookie[group]����Ȩ����Ϣ
if (isset($_COOKIE[u_id])){
	$groups=$_COOKIE[u_id];
	$group=explode("|",$groups);
	$user_name=$group[0];     //�û��ʺ�
	$real_name=$group[1];     //�û���ʵ����
	$group_title=$group[2];   //�û�������
	$u_size=$group[3];        //�û�Ӳ������
	$cookie_id=$group[4];     //�û�idֵ
}
//����Ƿ����$user_id��$cookie_id��ȣ������������������cookie[group_id]����Ȩ����Ϣ
if (($user_id!=$cookie_id) and isset($user_id)){
	$sql="select members.*,usergroup.*  from `members`
            LEFT JOIN usergroup ON members.groupid=usergroup.groupid where  members.userid='$user_id'
            order by members.userid DESC limit 1";
	$r=$db->query_first($sql);
	$user_name=$r[username];      //�û��ʺ�
	$real_name=$r[realname];      //�û���ʵ����
	$group_title=$r[grouptitle];  //�û�������
	$u_size=$r[usize];            //�û�Ӳ������
	$cookie_id=$r[userid];        //�û�idֵ
	setcookie("u_id","$user_name|$real_name|$group_title|$u_size|$cookie_id");
}
//�ϴ�����
$uptypes=array('rar','zip','ppt','doc','txt','ppt','xsl','jpeg','jpg','bmp','gif','pdf');
//���ÿɲ������ļ�
$filenames=array('index','left','header','main','deal','down','upload','list','pass','type','demo','upfile','login','cache','upbigfile','log','setvar','user','tohtml','review','database','template','contribute','uphtml','editor','swfupload');
$filename = empty($filename) ? 'index' : $filename;
//��ȡ��Ӧ�ļ����
if(in_array($filename,$filenames)){
	require $admin_root.'/'.$filename.'.php';}
	else { exit("�����������ļ������ڣ��Բ���ò�������ִ�У�");}
?>