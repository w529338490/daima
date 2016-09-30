<?php
/*
凤鸣山中小学网络办公室
*/
//栏目数据读取
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="全部文章";
}

if ($action=="")$action="public";
$tpl->assign("now_typename",$now_typename);
//参数设置
$typearr=array("0"=>"其他","1"=>"新闻","2"=>"影音","3"=>"软件","4"=>"社区",
"5"=>"语文","6"=>"数学","7"=>"外语","8"=>"科学","9"=>"社政",
"10"=>"体育","11"=>"美术","12"=>"劳技","13"=>"电脑","14"=>"音乐");
$sharearr=array("0"=>"私有","1"=>"共享");
switch($action){
	//添加操作
	case 'add':
		$tpl->assign("html_name_o","ntypeid");
		$tpl->assign("o_data",$typearr);
		$tpl->assign("o_checked",0)	;
		$tpl->assign("html_name_r","isshare");
		$tpl->assign("r_data",$sharearr);
		$tpl->assign("r_checked",1)	;
		break;
		//添加操作
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
		showmessage("是否删除此条记录！",$referer,"form");
		break;
		//收藏夹列表
	case 'list':
		//分页设置
		$query="select count(*) as num from $table_favorite where userid=$user_id";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		$tpl->assign("pagenav",$pagenav);
		//相应版块数据读取
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
		//我的收藏夹
	case 'private':
		//参数设置
		if (isset($tid)) {
			$sqlwhere="where typeid=$tid and userid=$user_id";
			$tname=$typearr[$tid];
		}else {
			$tname="全部";
			$sqlwhere="where userid=$user_id";}
			//分页设置
			$query="select count(*) as num from $table_favorite $sqlwhere";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$pagenav=getpagenav($totalnum,$listurl);
			$tpl->assign("pagenav",$pagenav);
			//相应版块数据读取
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
			if (!$content) $content="没有此类网站被收藏！";
break;
//公共收藏夹
	case 'public':
		//参数设置
		if (isset($tid)) {
			$sqlwhere="where typeid=$tid and isshare=1";
			$tname=$typearr[$tid];
		}else {
			$tname="全部";
			$sqlwhere="where isshare=1";}
			//分页设置
			$query="select count(*) as num from $table_favorite $sqlwhere";
			$r=$db->query_first($query);
			$totalnum=$r[num];
			$pagenumber = intval($pagenumber);
			if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
			$curpage=($pagenumber-1)*$perpage;
			$pagenav=getpagenav($totalnum,$listurl);
			$tpl->assign("pagenav",$pagenav);
			//相应版块数据读取
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