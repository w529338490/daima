<?php
include 'check.php';
include 'include/para.php';
include 'include/config.php';
$pageUrl="index.php?page=".$_GET['page'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��������</title>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
<?php include 'include/head.php';?>
<div id="list">
<div id="alertmsg">
  <?php if(!empty($_GET['ac'])){
	$id=$_GET['id'];
	$ac=$_GET['ac'];
	if($ac=='delete'){
		$db->delete("delete from ".TABLE_PREFIX."guestbook where id=".$id);
		echo "������ɾ����3��󷵻أ����Ժ򡭡�";
	}elseif($ac=='settop'){
		$db->update("update ".TABLE_PREFIX."guestbook set settop=1 where id=".$id);
		echo "�������ö���3��󷵻أ����Ժ򡭡�";
	}elseif($ac=='unsettop'){
		$db->update("update ".TABLE_PREFIX."guestbook set settop=0 where id=".$id);
		echo "��ȡ���ö���3��󷵻أ����Ժ򡭡�";
	}elseif($ac=='setshow'){
		$db->update("update ".TABLE_PREFIX."guestbook set ifshow=1 where id=".$id);
		echo "��������ʾ��3��󷵻أ����Ժ򡭡�";
	}elseif($ac=='unshow'){
		$db->update("update ".TABLE_PREFIX."guestbook set ifshow=0 where id=".$id);
		echo "���������أ�3��󷵻أ����Ժ򡭡�";
	}elseif($ac=='logout'){
		session_unset('admin_pass');
    	session_destroy(); 
		echo "���Ѿ��˳���3��󷵻أ����Ժ򡭡�";
	}else{
		echo '�޴����������';
	}
	
echo "<br><a href=".$pageUrl.">������������û���Զ����أ������˴��ֶ�����</a>";
echo "<meta http-equiv=\"refresh\" content=\"3; url=".$pageUrl."\">";

}?>
</div>
</div>
</div>
<?php include 'include/foot.php';?>
</body>
</html>
