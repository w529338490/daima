<?php
/*
凤鸣山中小学网络办公室
*/

//读取用户组
$query="select * from usergroup order by groupid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$showgroup.="<option value='$r[groupid]'>$r[grouptitle]</option>";
}
//读取部门信息
$query="select * from management order by manageid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$managements[$r[manageid]]=$r[managename];
	$showmanage.="<option value='$r[manageid]'>$r[managename]</option>";
}
//读取学科信息
$query="select * from subject order by subjectid";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$showsubject.="<option value='$r[subjectid]'>$r[subjectname]</option>";
}

switch ($action){
	case 'useradd':
    case 'useradd_1':
    case 'useradd_2':
	case 'userdel':
	default:
		//设置数据
		while (list($key,$value)=each($managements)){
			$managementlist.="<option value=$key>$value</option>";
		}
		if ($manageid){
			$query="SELECT * FROM `members` where manageid=$manageid";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$userlist.= "<option value=$r[userid]>$r[realname]</option>";
			}
		}

		$tpl->assign(array('manageid'=>$manageid,'managementlist'=>$managementlist,'userlist'=>$userlist));
		break;
}
$tpl->assign('action',$action);
$tpl->display('userlist.html');
?>