<? 
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �๦�ܽ��ҵǼ�ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
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
if($db->num_rows($result)==1){
    $r=$db->fetch_array($result);
    $user_id=$r[userid];
    $system_id=1;                            //ϵͳidֵ
    $user_system_id=$user_id."|".$system_id; //�û���ϵͳidֵ
    Session_Register("user_system_id");
    showmessage("��¼�ɹ���",$referer);
}else{
showmessage("�Բ����ʺź����벻ƥ�䣡",$referer);
}

}elseif($action=='logout'){
session_unregister("user_system_id");
setcookie ("group", "", time()-3600);
showmessage("���Ѿ��ɹ��˳�slcms����У԰����ϵͳ--��ý�����Ԥ��ϵͳ��",$referer);
}else{

Session_start();
$checkcode = getcode(4,0);
Session_Register("checkcode");
}?>