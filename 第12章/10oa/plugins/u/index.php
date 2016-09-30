<?php
/*
[slcms] php网络硬盘系统
This is a freeware
Version: 1.5.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】
Copyright: 数字校园 (www.nbcjzx.com)
Last Modified: 2007/4/23 16:04
*/
//开始缓冲
ob_start();
//读入global文件
require './global.php';
//检测变量防sql注入
$_POST = sql_injection($_POST);
$_GET = sql_injection($_GET);
//设置脚本执行时间为600秒
@set_time_limit(600);

session_start();
//读取用户登入的id号，如果不存在则注销这个变量；
if (session_is_registered("user_system_id")){
	$user_system_ids=$_SESSION["user_system_id"];
	$user_system_ids=explode("|",$user_system_ids);
	$user_id=$user_system_ids[0];    //用户id值
	$system_id=$user_system_ids[1];  //系统id值
	if ($system_id!=1) {
		unset($user_system_ids,$user_id,$system_id);
		showmessage("对不起你已经登入了本工作室开发的另一个产品！<bt>请退出该产品","?filename=login");
	}
}else{
	unset($user_system_id,$user_id,$system_id);
};
//判定是否登入过
if($filename!='login') checkadmin("对不起，请登录！",'?'.$QUERY_STRING);
//设置管理权限
//如果存在cookie信息则读取cookie[group]管理权限信息
if (isset($_COOKIE[u_id])){
	$groups=$_COOKIE[u_id];
	$group=explode("|",$groups);
	$user_name=$group[0];     //用户帐号
	$real_name=$group[1];     //用户真实姓名
	$group_title=$group[2];   //用户组名称
	$u_size=$group[3];        //用户硬盘容量
	$cookie_id=$group[4];     //用户id值
}
//检测是否存在$user_id和$cookie_id相等，如果不等则重新设置cookie[group_id]管理权限信息
if (($user_id!=$cookie_id) and isset($user_id)){
	$sql="select members.*,usergroup.*  from `members`
            LEFT JOIN usergroup ON members.groupid=usergroup.groupid where  members.userid='$user_id'
            order by members.userid DESC limit 1";
	$r=$db->query_first($sql);
	$user_name=$r[username];      //用户帐号
	$real_name=$r[realname];      //用户真实姓名
	$group_title=$r[grouptitle];  //用户组名称
	$u_size=$r[usize];            //用户硬盘容量
	$cookie_id=$r[userid];        //用户id值
	setcookie("u_id","$user_name|$real_name|$group_title|$u_size|$cookie_id");
}
//上传类型
$uptypes=array('rar','zip','ppt','doc','txt','ppt','xsl','jpeg','jpg','bmp','gif','pdf');
//设置可操作的文件
$filenames=array('index','left','header','main','deal','down','upload','list','pass','type','demo','upfile','login','cache','upbigfile','log','setvar','user','tohtml','review','database','template','contribute','uphtml','editor','swfupload');
$filename = empty($filename) ? 'index' : $filename;
//读取相应文件入口
if(in_array($filename,$filenames)){
	require $admin_root.'/'.$filename.'.php';}
	else { exit("你所操作地文件不存在，对不起该操作不可执行！");}
?>