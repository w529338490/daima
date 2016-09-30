<?php
/*
凤鸣山中小学网络办公室
*/

//---------------------------------------------------------------------------
//参数设置-----------------------------------------------------------------------------------------------------
$nnextday=mktime(0,0,0,date(m),date(d)+2,date(Y));
$nextday=mktime(0,0,0,date(m),date(d)+1,date(Y));
$nowday=mktime(0,0,0,date(m),date(d),date(Y));
//文章短标题
$includepics=explode(",",$includepic_arr);
//栏目信息读取--------------------------------------------------------------------------------------------------
$query="select * from $table_type order by `path`,`tid`";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$type[$r[uid]][]=$r[id];
	$totaltype[$r[id]]=array($r[id],$r[typename],$r[actionurl],$r[typepic]);
};
//年月日星期的显示
$weeks=array("0"=>"星期日","1"=>"星期一","2"=>"星期二","3"=>"星期三","4"=>"星期四","5"=>"星期五","6"=>"星期六");
$year_show=date(Y)."年".date(m)."月".date(d)."日  ".$weeks[date(w)];
$tpl->assign('year_show',$year_show);
//今日信息------------------------------------------------------------------------------------------------------
$i=0;
$query="select $table_articles.*,$table_type.typename,members.realname,management.managename
        from $table_articles
        left join $table_type on $table_articles.typeid=$table_type.id 
        left join members on $table_articles.inputer=members.userid 
        left join management on $table_articles.manageid=management.manageid 
        where $table_articles.outtime>=$nowday
        order by articleid desc limit 20";
$result=$db->query($query);
if($result){
	while($r=$db->fetch_array($result)){
		$date_m=date("n",$r[outtime]);
			if ($nowday<=$r[outtime] and $nextday>$r[outtime])$date_d="<font color=red>今日信息</font>";
			elseif ($nextday<=$r[outtime] and $nextday>=$r[outtime])$date_d="<font color=blue>明日安排</font>";
			else $date_d="<font color=green><b>".date("Y/m/d",$r[outtime])."</font> <img src=./templates/$style/images/new.gif>";
		//$includepics=array("","<font color=#E0572A>「转告」</font>","<font color=red>「紧急」</font>","<font color=blue>「推荐」</font>","<font color=#7A66B3>「注意」</font>","<font color=#2C3588>「换课」</font>","<font color=#BF6E14>「公开课」</font>");
		$includepic="<font color=red>".$includepics[$r[includepic]]."</font>";
		$img=rand(0,2);
		$r[title]=cnSubStr($r[title],50);
		$today_content[]=array('articleid'=>$r[articleid],'img'=>$img,'typename'=>$r[typename],'includepic'=>$includepic,'title'=>$r[title],'managename'=>$r[managename],'date_d'=>$date_d);
		$i++;
	}
}
$tpl->assign('today_content',$today_content);
//--待办提醒-------------------------------------------------------------------------------------------------
$code="";
$query="select *
        from $table_schedule
        where inputer=$user_id and $nowday>=pretime and $nowday<intime
        order by pretime asc 
        limit 0,10";
$result=$db->query($query);
if($result){
	while($r=$db->fetch_array($result)){
		$intime=date("y/m/d",$r[intime]);
		$img=rand(0,2);
		$r[title]=cnSubStr($r[title],20);
		$calendar_code[]=array('img'=>$img,'id'=>$r[id],'title'=>$r[title],'intime'=>$intime);
	}
}
$tpl->assign('calendar_code',$calendar_code);
//--今日事务-------------------------------------------------------------------------------------------------
$code="";
$query="select *
        from $table_schedule
        where inputer=$user_id and `intime`='$nowday'
        order by intime desc 
        limit 0,10";
$result=$db->query($query);
if($result){
	while($r=$db->fetch_array($result)){
		$img=rand(0,2);
		$r[title]=cnSubStr($r[title],24);
		$t_calendar_code[]=array('img'=>$img,'id'=>$r[id],'title'=>$r[title]);
	}
}
$tpl->assign('t_calendar_code',$t_calendar_code);
//最近更新 行政通知 工作安排 资料下载 会议通知--------------------------------------------------------------------
$outtypeids=explode(",",$outtypeids);
$i=0;
$isfirst="block";
foreach($outtypeids as $temptypeid){
	//头部文件
	$tabhead.="<LI><A href=\"#cont_$temptypeid\"><SPAN>".$totaltype[$temptypeid][1]."</SPAN></A> </LI>";
	//板块列表
	$tab_list[$temptypeid]=array("id"=>$i,'temptypeid'=>$temptypeid,"title"=>$totaltype[$temptypeid][1],"isfirst"=>$isfirst);
	$isfirst="none";
	//相应版块数据读取
	$query="select $table_articles.*,$table_type.typename,members.realname,management.managename
        from $table_articles
        left join $table_type on $table_articles.typeid=$table_type.id 
        left join members on $table_articles.inputer=members.userid 
        left join management on $table_articles.manageid=management.manageid 
        where $table_articles.typeid=$temptypeid
        order by articleid desc 
        limit 0,8";
	$result=$db->query($query);
	if($result){
		while($r=$db->fetch_array($result)){
			$date_m=date("n",$r[outtime]);
			if ($nowday<=$r[outtime] and $nextday>$r[outtime])$date_d="<font color=red>今日信息</font>";
			elseif ($nextday<=$r[outtime] and $nextday>=$r[outtime])$date_d="<font color=blue>明日安排</font>";
			else $date_d="<font color=green><b>".date("Y/m/d",$r[outtime])."</font>";
			//$includepics=array("","<font color=#E0572A>「转告」</font>","<font color=red>「紧急」</font>","<font color=blue>「推荐」</font>","<font color=#7A66B3>「注意」</font>","<font color=#2C3588>「换课」</font>","<font color=#BF6E14>「公开课」</font>");
			$includepic="<font color=red>".$includepics[$r[includepic]]."</font>";
			$img=rand(0,2);
			$r[title]=cnSubStr($r[title],50);
			$tab_content[$temptypeid][]=array('articleid'=>$r[articleid],'img'=>$img,'includepic'=>$includepic,'title'=>$r[title],'managename'=>$r[managename],'date_d'=>$date_d);
		}
	}
	$i++;
}//endforeach
$tpl->assign('max_id',$i-1);
$tpl->assign('tabhead',$tabhead);
$tpl->assign('tab_list',$tab_list);
$tpl->assign('tab_content',$tab_content);
//----------------------------------------------------------------------------------
//今日请假者---------------------------------------------------------------------------------------------------
//设置参数
$leavetypeid=array("","公假","事假","病假");
$query="select *
        from  $table_leave
        where   stime<=$nowday and $nowday<=etime and pass=1 
        order by id desc ;";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$r[leavetypeid]=$leavetypeid[$r[leavetypeid]];
	$stime=date("Y/m/d",$r[stime]);
	$etime=date("Y/m/d",$r[etime]);
	$r[reason]=cnSubStr($r[reason],32);
	$leavelist[]=array('leavetypeid'=>$r[leavetypeid],'leaver'=>$r[leaver],'reason'=>$r[reason],'stime'=>$stime,'etime'=>$etime);
}
$tpl->assign('leavelist',$leavelist);
//--公共教室预约-----实验室预定-----------------------------------------------------------------------------------
$sql="SELECT * FROM $table_y_type ORDER BY `id` ASC ";
$result=$db->query($sql);
while($s=$db->fetch_array($result)){
	$class_list[$s[id]]=array('cid'=>$s[id],'title'=>$s[title],'note'=>$s[note]);
}
//设定上课班级
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$show_grade[$r[classid]]=$r[classname];
}
if (is_array($class_list))
foreach($class_list as $gtypeid=>$temptypeid){
	$typelist[$gtypeid]=array('gtypeid'=>$gtypeid,'typetitle'=>$class_list[$gtypeid][title]);
	//本分类教室数据的读取
	$query="select id from $table_y_class where typeid=$gtypeid";
	$result=$db->query($query);
	$dd=$ingtypeid="";
	while($r=$db->fetch_array($result)){
		$ingtypeid.=$dd.$r[id];
		$dd=",";
	}
	if ($ingtypeid=="")$ingtypeid=0;
	//班级\星期和节次数据的读取
	$query="select * from $table_y_setting order by id ASC";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$setting[$r[type]][$r[other]]=$r[name];
	}
	//今日预约的记录数据的读取
	$query="select $table_y_content.*,members.realname,$table_y_class.name
        from $table_y_content
        left join $table_y_class on $table_y_content.classid=$table_y_class.id 
        left join members on $table_y_content.teacher=members.userid  
        where $table_y_content.classid in ($ingtypeid) and $table_y_content.ordertime=$nowday and $table_y_content.state>0 
        order by id ASC";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$re_list[$gtypeid][]=array('realname'=>$r[realname],'grade'=>$show_grade[$r[grade]],'name'=>$r[name],'nonumber'=>$r[nonumber]);
	}
}
$tpl->assign('re_list',$re_list);
$tpl->assign('typelist',$typelist);
//******************页面输出******************************************************
$tpl->display('table.html');
?>

