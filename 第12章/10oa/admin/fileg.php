<?php
/*
����ɽ��Сѧ����칫��
*/
//��Ŀ���ݶ�ȡ
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="ȫ������";
}
$tpl->assign("now_typename",$now_typename);
if ($action=="")$action="list";
switch($action){
	//��ӱ༭����
	case 'add':
		break;
		//�ļ����б�
	case 'list':
		//��������
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//��ҳ����
		$query="select count(*) as num from $table_file where inputer=$user_id";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//��Ӧ������ݶ�ȡ
		$query="select $table_file.*,members.realname
        from $table_file
        left join members on $table_file.sender=members.userid
        where inputer=$user_id
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){

			$intime=date("Y/m/d",$r[intime]);
			$content[]=array("id"=>$r[id],"title"=>$r[title],"realname"=>$r[realname],"intime"=>$intime,"hash"=>$r[hash]);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		if (!$content) $content="����û������";
		break;
		//ɾ���ļ�
	case 'filedel':
		showmessage("�Ƿ�ɾ�����ļ�", $url_forward = "?filename=deal&action=filedel&fileid=$fileid&hash=$hash", $msgtype = 'form');
		break;
		//���ļ��������û�
	case 'userdo':
		//��ȡ�û���
		$query="select * from usergroup order by groupid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$showgroup.="<option value='$r[groupid]'>$r[grouptitle]</option>";
		}
		//��ȡ������Ϣ
		$query="select * from management order by manageid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$managements[$r[manageid]]=$r[managename];
			$showmanage.="<option value='$r[manageid]'>$r[managename]</option>";
		}
		//��ȡѧ����Ϣ
		$query="select * from subject order by subjectid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$showsubject.="<option value='$r[subjectid]'>$r[subjectname]</option>";
		}
		//��������
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
		$tpl->assign(array("fileid"=>$fileid,"userlist"=>$userlist,'manageid'=>$manageid,"managementlist"=>$managementlist,"showsubject"=>$showsubject));
		break;
}
$tpl->assign('action',$action);
$tpl->display('fileg.html');
?>