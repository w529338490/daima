<? 
/*
����ɽ��Сѧ����칫��
*/

if($action=='login'){
	$referer=$referer?$referer:'index.php';
	header("Content-type: text/html; charset=gbk");
	//�����֤���Ƿ�������ȷ
	if (($_COOKIE["code"])!=$_POST["chknumber"]) {
		$success = "{success:false,msg:\"��֤�����\"}";
		echo $success;
		exit;
	}

	//��ʽ��������ʺź����룬����ȡ�û���Ϣ
	$username=$_POST["username"];
	$password=$_POST["password"];
	$username=addslashes($username);
	$password=addslashes($password);
	$password=md5($password);
	//��֤�Ƿ�Ϊ��Ҫ��֤���û�
	$query="select * from members where username='$username' and groupid=99";
	$result=$db->query($query);
	//����Ƿ�Ϊ��ʦ�ʺ�
	if($db->num_rows($result)!=0){
		$success = "{success:false,msg:\"����Ҫ����Ա����Ժ���ܵ��룬�������Ա��ϵ\"}";
		loginfaile($username);
		echo $success;
		exit;
	}
	//����Ƿ�Ϊ��ʦ�ʺ�
	$query="select * from members where username='$username' and password='$password' and groupid<5";
	$result=$db->query($query);
	if($db->num_rows($result)!=0){
		$r=$db->fetch_array($result);
		$user_id=$r[userid];                     //�û�idֵ
		$system_id=1;                            //ϵͳidֵ
		$user_system_id=$user_id."|".$system_id; //�û���ϵͳidֵ
        //ע��session
		Session_Register("user_system_id");
		$success = "{success:true}";
		//����cookietime sessionid
		$cookietime=$_POST["cookietime"];
		if ($cookietime>0){
		$cookietime=86400*$cookietime+time();
		$sid= md5(uniqid(rand()));    //����sid
        session_id($sid);
      setcookie('sid',$sid,$cookietime);
      }
		loginsucceed($username);
	}else{
		//�ʺ����벻ƥ��
		$success = "{success:false,msg:\"�˺Ż��������벻��\"}";
		loginfaile($username);
	}
	print $success;
	//ע���ʺ�
}elseif($action=='out'){
	session_unregister("user_system_id");
	setcookie("group","", time()-3600);
	setcookie("sid","",time()-3600);
	$tpl->assign(array("keywords"=>$sitekeywords,"description"=>$sitedescription));
	$tpl->display('login.html');
}else{
	$tpl->assign(array("keywords"=>$sitekeywords,"description"=>$sitedescription));
	$tpl->display('login.html');
}
?>