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

if ($action=="")$action="public";
$tpl->assign("now_typename",$now_typename);
//��������
$typearr=array("0"=>"����","1"=>"����","2"=>"Ӱ��","3"=>"���","4"=>"����",
"5"=>"����","6"=>"��ѧ","7"=>"����","8"=>"��ѧ","9"=>"����",
"10"=>"����","11"=>"����","12"=>"�ͼ�","13"=>"����","14"=>"����");
$sharearr=array("0"=>"˽��","1"=>"����");
switch($action){
	//��Ӳ���
	case 'add':
		$tpl->assign("html_name_o","ntypeid");
		$tpl->assign("o_data",$typearr);
		$tpl->assign("o_checked",0)	;
		$tpl->assign("html_name_r","isshare");
		$tpl->assign("r_data",$sharearr);
		$tpl->assign("r_checked",1)	;
		break;
		//��Ӳ���
	case 'edit':
		$query="select * from $table_favorite where id=$id limit 1";
		$r=$db->query_first($query);
		$content=array("id"=>$id,"typeid"=>$typeid,"title"=>$r[title],"weburl"=>$r[weburl],"note"=>$r[note]);
		$tpl->assign($content);
		$tpl->assign("html_name_o","ntypeid");
		$tpl->assign("o_data",$typearr);
		$tpl->assign("o_checked",$r[typeid]);
		$tpl->assign("html_name_r","isshare");
		$tpl->assign("r_data",$sharearr);
		$tpl->assign("r_checked",$r[isshare]);
		break;
	case 'del':
		$referer="index.php?filename=deal&action=delfavorite&id=$id&typeid=$typeid";
		showmessage("�Ƿ�ɾ��������¼��",$referer,"form");
		break;
		//�ղؼ��б�
	case 'list':
		//��ҳ����
		$query="select count(*) as num from $table_favorite where userid=$user_id";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		$tpl->assign("pagenav",$pagenav);
		//��Ӧ������ݶ�ȡ
		$query="select * from $table_favorite where userid=$user_id
        order by id desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$content[]=array("typeid"=>$typeid,"id"=>$r[id],"typename"=>$typearr[$r[typeid]],"weburl"=>$r[weburl],"note"=>$r[note],"title"=>$r[title],"isshare"=>$sharearr[$r[isshare]]);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;
		//�ҵ��ղؼ�
	case 'private':
		//��������
		if (isset($tid)) {
			$sqlwhere="where typeid=$tid and userid=$user_id";
			$tname=$typearr[$tid];
		}else {
			$tname="ȫ��";
			$sqlwhere="where userid=$user_id";}
			//��ҳ����
			$query="select count(*) as num from $table_favorite $sqlwhere";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$pagenav=getpagenav($totalnum,$listurl);
			$tpl->assign("pagenav",$pagenav);
			//��Ӧ������ݶ�ȡ
			$query="select *
        from $table_favorite
        $sqlwhere
        order by id desc 
        limit $curpage,$perpage";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$sharename=$sharearr[$r[isshare]];
				$typename=$typearr[$r[typeid]];
				$content[]=array("tid"=>$r[typeid],"weburl"=>$r[weburl],"title"=>$r[title],"note"=>$r[note],"sharename"=>$sharename,"typename"=>$typename);
			}
			$tpl->assign("content",$content);
			$tpl->assign("typeid",$typeid);
			if (!$content) $content="û�д�����վ���ղأ�";
break;
//�����ղؼ�
	case 'public':
		//��������
		if (isset($tid)) {
			$sqlwhere="where typeid=$tid and isshare=1";
			$tname=$typearr[$tid];
		}else {
			$tname="ȫ��";
			$sqlwhere="where isshare=1";}
			//��ҳ����
			$query="select count(*) as num from $table_favorite $sqlwhere";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$pagenav=getpagenav($totalnum,$listurl);
			$tpl->assign("pagenav",$pagenav);
			//��Ӧ������ݶ�ȡ
			$query="select *
        from $table_favorite
        $sqlwhere
        order by id desc 
        limit $curpage,$perpage";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$sharename=$sharearr[$r[isshare]];
				$typename=$typearr[$r[typeid]];
				$content[]=array("tid"=>$r[typeid],"weburl"=>$r[weburl],"title"=>$r[title],"note"=>$r[note],"sharename"=>$sharename,"typename"=>$typename);
			}
			$tpl->assign("content",$content);
			$tpl->assign("typeid",$typeid);
break;
}
$tpl->assign('action',$action);
$tpl->display('favorite.html');
?>