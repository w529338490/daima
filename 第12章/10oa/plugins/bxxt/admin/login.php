<? 
/*
����ɽ��СѧУ����칫��
*/
$referer='index.php';
if($action=='login'){
Session_start();
$username=addslashes($username);
$password=addslashes($password);
$password=md5($password);
$query="select * from members where username='$username' and password='$password' and groupid<5";
$result=$db->query($query);
//����Ƿ�Ϊ��ʦ�ʺ�
if($db->num_rows($result)!=0){
      $r=$db->fetch_array($result);
      $user_id=$r[userid];                     //�û�idֵ
      $system_id=1;                            //ϵͳidֵ
      $user_system_id=$user_id."|".$system_id; //�û���ϵͳidֵ
      Session_Register("user_system_id");
      showmessage("��¼�ɹ���",$referer);
}else{
showmessage("�Բ����ʺź����벻ƥ�䣡",$referer);
}

}elseif($action=='logout'){
session_unregister("user_id");
showmessage("���Ѿ��ɹ��˳�slcms����У԰����ϵͳ--��ý�����Ԥ��ϵͳ��",$referer);
}else{

Session_start();
$checkcode = getcode(4,0);
Session_Register("checkcode");
}?>