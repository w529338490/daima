<?php
/*
凤鸣山中小学网络办公室
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
    	   showmessage("你没有有登入没有权力访问");
    	   };   	   
//设置管理权限
//如果存在cookie信息则读取cookie[group]管理权限信息
if (isset($_COOKIE[group])){
	$group=explode("|", $_COOKIE[group]);
	$cookie_id=$group[0];  //用户id值
	$group_id=$group[1];   //用户组别
	$admin_id=$group[2];   //用户权限
	$user_name=$group[3];  //用户姓名
	$real_name=$group[4];   //用户真实姓名
}
//检测是否存在$user_id和$cookie_id相等，如果不等则重新设置cookie[group_id]管理权限信息
if (($user_id!=$cookie_id) and isset($user_id)){
	$query="select username,realname,groupid,admining from members where `userid`='$user_id' and `groupid`<5 limit 1";
	$result=$db->query($query);
	//是否是超级管理员或普通管理员
	if($db->num_rows($result)==1){
	$r=$db->fetch_array($result);
  $cookie_id=$user_id;      //用户id
  $user_name=$r[username];  //用户名
  $group_id=$r[groupid];    //用户组
  $admin_id=$r[admining];   //管理分类的权限
  $real_name=$r[realname];   //用户真实姓名
  setcookie("group","$cookie_id|$group_id|$admin_id|$user_name|$real_name"); 
  } 
}    	
unset($cookie_id); 
//设置可操作的文件
$filenames=array('index','inform','admin','deal','setting','list','login','setvar','product','borrow');
$filename = empty($filename) ? 'index' : $filename;
//文件入口操作
if(in_array($filename,$filenames)){
require $admin_root.'/'.$filename.'.php';}
else { exit("你所操作地文件不存在，对不起该操作不可执行！");}
?>
</html>