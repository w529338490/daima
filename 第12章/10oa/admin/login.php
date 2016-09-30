<? 
/*
凤鸣山中小学网络办公室
*/

if($action=='login'){
	$referer=$referer?$referer:'index.php';
	header("Content-type: text/html; charset=gbk");
	//检测验证码是否输入正确
	if (($_COOKIE["code"])!=$_POST["chknumber"]) {
		$success = "{success:false,msg:\"验证码错误\"}";
		echo $success;
		exit;
	}

	//格式化输入的帐号和密码，并读取用户信息
	$username=$_POST["username"];
	$password=$_POST["password"];
	$username=addslashes($username);
	$password=addslashes($password);
	$password=md5($password);
	//验证是否为需要验证的用户
	$query="select * from members where username='$username' and groupid=99";
	$result=$db->query($query);
	//检测是否为教师帐号
	if($db->num_rows($result)!=0){
		$success = "{success:false,msg:\"你需要管理员审核以后才能登入，请与管理员联系\"}";
		loginfaile($username);
		echo $success;
		exit;
	}
	//检测是否为教师帐号
	$query="select * from members where username='$username' and password='$password' and groupid<5";
	$result=$db->query($query);
	if($db->num_rows($result)!=0){
		$r=$db->fetch_array($result);
		$user_id=$r[userid];                     //用户id值
		$system_id=1;                            //系统id值
		$user_system_id=$user_id."|".$system_id; //用户和系统id值
        //注册session
		Session_Register("user_system_id");
		$success = "{success:true}";
		//保留cookietime sessionid
		$cookietime=$_POST["cookietime"];
		if ($cookietime>0){
		$cookietime=86400*$cookietime+time();
		$sid= md5(uniqid(rand()));    //生成sid
        session_id($sid);
      setcookie('sid',$sid,$cookietime);
      }
		loginsucceed($username);
	}else{
		//帐号密码不匹配
		$success = "{success:false,msg:\"账号或密码输入不对\"}";
		loginfaile($username);
	}
	print $success;
	//注销帐号
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