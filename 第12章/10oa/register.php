<?

require './global.php';
if (!isset($step))
$step=1;
if ($action=="reg")
{  
if ($_POST['reg_key']!=$register_key)
{
	showmessage("�Բ������������","?filename=reg&step=2");
	exit;
}
$reg_username=addslashes($username);
$reg_realname=addslashes($realname);
$reg_password=addslashes($password);
$reg_password=md5($reg_password);
//����Ƿ�����ע��
$sql="select * from members where username='$reg_username' or realname='$reg_realname' limit 1";
$result=$db->query($sql);
if($db->num_rows($result)==1) {
	showmessage("�Բ����Ѿ�����ע����","?filename=reg&step=2");
	exit;
}

//��ʼ����ע����Ϣ
$sql="INSERT INTO `members` ( `username` , `realname` , `password` , `groupid`  , `admining`,`subjectid`,`manageid` )
                         VALUES ( '$reg_username', '$reg_realname', '$reg_password', '99' , '-1',$subjectid,$manageid);";
$db->query($sql);
$query_id=$db->insert_id();
//�����û�����
$query="INSERT INTO `userinfo` ( `id` , `userid`  )
                          VALUES ('', '	$query_id');";
$db->query($query);
showmessage("��ϲ�㣡ע��ɹ������,��û�����Ȩ��.��ȴ�,����Ա�Ὺͨ����ʺ�","index.php");
exit;
}
switch ($step){
	case '1':
		break;
	case '2':
	//�������ݶ�ȡ
	$query="SELECT * FROM `management` ORDER BY `manageid` ASC";
	$result=$db->query($query);
	while($s=$db->fetch_array($result)){
		$manage_data.="<option value='$s[manageid]'>$s[managename]</option>";
	}
	$dd="";
	//ѧ�����ݶ�ȡ
	$query="SELECT * FROM `subject` ORDER BY `subjectid` ASC ";
	$result=$db->query($query);
	while($s=$db->fetch_array($result)){
		$subject_data.="<option value='$s[subjectid]'>$s[subjectname]</option>";
	}
	$tpl->assign("subject_data",$subject_data);
	$tpl->assign("manage_data",$manage_data);
		break;
}
$tpl->assign('step',$step);
$tpl->display('register.html');
?>