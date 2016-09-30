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
$tpl->assign("now_typename",$now_typename);  	     
//用户组权限读取
$sql="select * from userright where rightid=$group_id limit 1";
$result=$db->query($sql);
if($db->affected_rows()!=0){
	$r=$db->fetch_array($result);
	$rights=$r[rights];
	$right=1;  //标量
	$rights=explode(":",$rights);
	while (list($key,$tempright)=each($rights)){
		$tempright=explode("|",$tempright);
		$rightlen=sizeof($tempright);
		for ($i=1;$i<=$rightlen;$i++)
		$rightdata[$tempright[0]][]=$tempright[$i];
	}
} else $right=0;
//文章短标题
$includepics=explode(",",$includepic_arr);
switch($action){
	/**************************版块**内容***输出方法一*********************************************/
	case 'class':
		//权限检测
		if ($rightdata[$typeid][0]!=1) showmessage("对不起，你没有权限访问！");
		//栏目数据读取
		$query="select * from $table_type where id=$typeid";
		$r=$db->query_first($query);
		$type_name=$r[typename];
		//参数设置
		$nnextday=mktime(0,0,0,date(m),date(d)+2,date(Y));
		$nextday=mktime(0,0,0,date(m),date(d)+1,date(Y));
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//分页设置
		$perpage=10;
		$listurl="?filename=list&action=class&typeid=$typeid";
		$query="select count(*) as num from $table_articles where typeid=$typeid";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		$tpl->assign("pagenav",$pagenav);
		//相应版块数据读取
		$query="select $table_articles.*,$table_type.typename,members.realname,management.managename
        from $table_articles
        left join $table_type on $table_articles.typeid=$table_type.id 
        left join members on $table_articles.inputer=members.userid 
        left join management on $table_articles.manageid=management.manageid 
        where $table_articles.typeid=$typeid
        order by articleid desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["outtime"]);
				if ($nowday<=$r[outtime] and $nextday>$r[outtime])$date_d="<font color=red>今日</font>";
				elseif ($nextday<=$r[outtime] and $nnextday>=$r[outtime])$date_d="<font color=red>明日</font>";
				else $date_d=date("d",$r[outtime]);
				$date_t=date("Y-m-d H:s",$r["addtime"]);
				//$includepics=array("","<font color=#E0572A>「转告」</font>","<font color=red>「紧急」</font>","<font color=blue>「推荐」</font>","<font color=#7A66B3>「注意」</font>","<font color=#2C3588>「换课」</font>","<font color=#BF6E14>「公开课」</font>");
				$includepic="<font color=red>".$includepics[$r[includepic]]."</font>";
				$articleurl="$rootpath/show.php?id=$r[articleid]";
				$content[]=array("date_m"=>$date_m,"date_t"=>$date_t,"date_d"=>$date_d,"includepic"=>$includepic,
				"articleid"=>$r[articleid],"title"=>$r[title],"managename"=>$r[managename],"author"=>$r[author]
				);
			}
			$tpl->assign("content",$content);
		}
		break;
};
$tpl->assign("typeid",$typeid);
$tpl->assign('action',$action);
$tpl->display('list.html');
?>
