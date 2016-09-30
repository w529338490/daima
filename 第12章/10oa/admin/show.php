<?php
/*
凤鸣山中小学网络办公室
*/
//是否为日程安排中的事件
if ($action=='s'){
	$query="select *
        from $table_schedule
        where id=$id
        limit 1;";
	$r=$db->query_first($query);
	if ($r[articleid]==0){
		$intime=date('Y-m-d',$r[intime]);
		$content=array('content'=>$r[content],'title'=>$r[title],'author'=>$real_name,'addtime'=>$intime);
		
	}else{
		$id=$r[articleid];
		$action='article';
	}
}else{
	$action='article';
}

if ($action=='article'){
	#################输出页面###########################
	//设置相应的浏览量
	$sql="UPDATE $table_articles SET `hits` = `hits`+1 WHERE `articleid` ='$id' LIMIT 1";
	$db->query($sql);
	//读取相应的文章
	$query="select * from $table_articles where articleid='$id' limit 1";
	$r=$db->query_first($query);
	//文章输出数据设置
	$id=$r[articleid];
	$title=$r[title];
	//站点标题
	$sitetitle=$title."----".$sitetitle;
	if ($r[includepic]) $incluedpic=$r[includepic];
	if ($r[titlefontcolor]){
		$titlefontcolor=$r[titlefontcolor];
		$titlefontcolor=explode("#",$titlefontcolor);
		$titlefontcolor=$titlefontcolor[1];
		$title="<font color=$titlefontcolor>$title</font>";
	}
	$addtime=date('Y-m-d',$r[addtime]);
	//附件的读取
	$query="select * from $table_soft where postid='$id'";
	$sresult=$db->query($query);
	$i=1;
	while($s=$db->fetch_array($sresult)){
		if($i==1)$addfile="<font color=red><p><p>-----------------------------------<br>附件:</font>";
		$softid=$s[softid];
		$softname=$s[softname];
		$softsize=$s[softsize];
		$softnumber=$s[number];
		$softmoney=$s[money];
		$hash=$s[other];
		$addfile.="<a href='?filename=soft_down&id=$softid&hash=$hash' target='_blank' class=a alt=$softname>下载地址$i </a>";
		$i++;
	};
	$content=array('title'=>$title,'content'=>$r[content],'subheading'=>$r[subheading],'author'=>$r[author],'copyfrom'=>$r[copyfromname],
	'includepic'=>$includepic,'addfile'=>$addfile,'hits'=>$r[hits],'inputer'=>$r[inputer],'keywords'=>$r[keywords],'addtime'=>$addtime);
}
$tpl->assign($content);
$tpl->assign('style',$style);
$tpl->assign('action',$action);
$tpl->display('show.html');
?>

                                                        