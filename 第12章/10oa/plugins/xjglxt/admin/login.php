<? 
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

$referer='index.php';
if($action=='login'){
Session_start();
$username=addslashes($username);
$password=addslashes($password);
$password=md5($password);
$query="select * from members where username='$username' and password='$password' and groupid<5";
$result=$db->query($query);
//检测是否为教师帐号
if($db->num_rows($result)!=0){
      $r=$db->fetch_array($result);
      $user_id=$r[userid];                     //用户id值
      $system_id=1;                            //系统id值
      $user_system_id=$user_id."|".$system_id; //用户和系统id值
      Session_Register("user_system_id");
      showmessage("登录成功！",$referer);
}else{
showmessage("对不起，帐号和密码不匹配！",$referer);
}

}elseif($action=='logout'){
session_unregister("user_id");
showmessage("你已经成功退出slcms数字校园管理系统--多媒体教室预订系统！",$referer);
}else{

Session_start();
$checkcode = getcode(4,0);
Session_Register("checkcode");
}?>