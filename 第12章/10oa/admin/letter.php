<?php
/*
����ɽ��Сѧ����칫��
*/
/************************************************************/
//��Ŀ���ݶ�ȡ
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="ȫ������";
}
$tpl->assign("now_typename",$now_typename);
switch($action){
	case 'new':
		break;
	case 'edit':
		$sql="select * from $table_letter where id=$id limit 1";
		$r=$db->query_first($sql);
		$content=array("username"=>$r[username],"address"=>$r[address],
		"work"=>$r[work],"tel1"=>$r[tel1],"tel2"=>$r[tel2],
		"tel3"=>$r[tel3],"qq"=>$r[qq],"email"=>$r[email],"msn"=>$r[msn],"id"=>$id);
		$tpl->assign($content);
		break;
	case 'del':
		$referer="index.php?filename=deal&action=delletter&id=$id";
		showmessage("�Ƿ�ɾ��������¼��",$referer,"form");
		break;
	case 'person':
		//ҳ�����ÿ�ʼ
		$sql = "SELECT count(*) FROM $table_letter where inputer=$user_id ";
		$result = $db->query_first($sql);
		$totalnum=$result[0];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,"?filename=letter&action=person");
		$tpl->assign("pagenav",$pagenav);
		//ҳ�����ý���
		//��¼���ݵĶ�ȡ
		$query="select * from $table_letter
            where inputer=$user_id and typeid=0
            order by id DESC limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$content[]=array("username"=>$r[username],"address"=>$r[address],
			"work"=>$r[work],"tel1"=>$r[tel1],"tel2"=>$r[tel2],
			"tel3"=>$r[tel3],"qq"=>$r[qq],"email"=>$r[email],"msn"=>$r[msn],"id"=>$r[id]);

		}
		$tpl->assign("typeid",$typeid);
		$tpl->assign("content",$content);
		break;
	case 'public':
		//ҳ�����ÿ�ʼ
		$sql = "SELECT count(*) FROM members where groupid<99";
		$result = $db->query_first($sql);
		$totalnum=$result[0];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,"?filename=letter&action=public");
		$tpl->assign("pagenav",$pagenav);
		//ҳ�����ý���
		//��¼���ݵĶ�ȡ
		$query="select userinfo.*,members.* from members
                LEFT JOIN userinfo ON userinfo.userid=members.userid
                where members.groupid<99
                order by members.userid DESC 
                limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$content[]=array("realname"=>$r[realname],"address"=>$r[address],
			"work"=>$r[work],"tel1"=>$r[tel1],"tel2"=>$r[tel2],
			"tel3"=>$r[tel3],"qq"=>$r[qq],"email"=>$r[email],"msn"=>$r[msn],"id"=>$r[id]);

		}
		$tpl->assign("typeid",$typeid);
		$tpl->assign("content",$content);
		break;
}
$tpl->assign('action',$action);
$tpl->display('letter.html');
?>