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
/******************************************************/
$tpl->assign('now_typename',$now_typename);
$tpl->assign('typeid',$typeid);
if ($action=="")$action="d";
switch($action){
	//添加编辑操作
	case 'a':
		break;
		//今日工作安排
	case 'd':
		//参数设置
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//分页设置
		$query="select count(*) as num from $table_schedule where inputer=$user_id and `intime`='$nowday'";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//相应版块数据读取
		$query="select *
        from $table_schedule
        where inputer=$user_id and `intime`='$nowday'
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="今日";else $date_d=date("d",$r["intime"]);
				$content[]=array('id'=>$r[id],'date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content]);
			}
		}
		$tpl->assign('content',$content);
		break;
		//周工作安排
	case 'w':
		//设置参数
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		$leavetypeid=array("","公假","事假","病假");
		$noday=date(w);   //一周的第几天
		if ($noday==0)$noday=7;
		//设置周一到周日的time值
		for ($i=1;$i<=7;$i++){
			$weeks[$i]=mktime(0,0,0,date(m),date(d)+$i-$noday,date(Y));
			$nowweeks=array("","星期一","星期二","星期三","星期四","星期五","星期六","星期日");
		}
		//分页设置
		$query="select count(*) as num from $table_schedule  where inputer=$user_id and (intime<=$weeks[7] and intime>=$weeks[1])";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//读取本周信息
		$query="select *
        from  $table_schedule
        where inputer=$user_id and (intime<=$weeks[7] and intime>=$weeks[1]) 
        order by intime ASC ;";
		$result=$db->query($query);
		$i=1;
		while($r=$db->fetch_array($result)){
			$weeksch[$i]=array("$r[title]","$r[content]","$r[intime]");
			if ($weeksch[$i][2]==$weeks[1] )$weekschdata[1][]=$i;
			if ($weeksch[$i][2]==$weeks[2])$weekschdata[2][]=$i;
			if ($weeksch[$i][2]==$weeks[3])$weekschdata[3][]=$i;
			if ($weeksch[$i][2]==$weeks[4] )$weekschdata[4][]=$i;
			if ($weeksch[$i][2]==$weeks[5] )$weekschdata[5][]=$i;
			if ($weeksch[$i][2]==$weeks[6] )$weekschdata[6][]=$i;
			if ($weeksch[$i][2]==$weeks[7] )$weekschdata[7][]=$i;
			$i++;
		}
		while (list($key,$day)=each($weeks)){
			$todayschlist="";
			$l="";
			if (is_array($weekschdata[$key])){
				while(list($i,$weekschid)=each($weekschdata[$key])){
					$todayschlist.=" $l ".$weeksch[$weekschid][0];
					$l="|";
				}
			}
			if (!$todayschlist){
				$todayschlist="今日没有事务";
			}
			$nowweek=$nowweeks[$key];
			$daten=date(n,$weeks[$key]);
			$dated=date(d,$weeks[$key]);
			$content[]=array('nowweek'=>$nowweek,'daten'=>$daten,'dated'=>$dated,'todayschlist'=>$todayschlist);
			$tpl->assign('content',$content);
		}

		break;
		//待办提醒
	case 't':
		//参数设置
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//分页设置
		$query="select count(*) as num from $table_schedule where inputer=$user_id and  ($nowday>=pretime and $nowday<=intime)";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//相应版块数据读取
		$query="select *
        from $table_schedule
        where inputer=$user_id and (pretime<=$nowday and intime>=$nowday) 
        order by pretime asc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="今日";else $date_d=date("d",$r["intime"]);
				$articleurl="$rootpath/show.php?id=$r[articleid]";
				$content[]=array('id'=>$r[id],'date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content],'articleurl'=>$articleurl);
			}
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;
		//月查询列表
	case 's':
		//分页设置
		$query="select count(*) as num from $table_schedule where inputer=$user_id and `intime`='$selecttime'";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//相应版块数据读取
		$query="select *
        from $table_schedule
        where inputer=$user_id and `intime`='$selecttime'
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="今日";else $date_d=date("d",$r["intime"]);
				$articleurl="$rootpath/show.php?id=$r[articleid]";
				$content[]=array('date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content],'articleurl'=>$articleurl);
			}
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;
		//月查询
	case 'm':
	default:
		error_reporting(0);
		global $_GET;
		//<-------处理通过GET方法提交的变量;开始-------->
		if($_GET['year']=="")
		{
			$_GET['year']=date("Y");
		}
		if($_GET['month']=="")
		{
			$_GET['month']=date("n");
		}
		$month=$_GET['month'];
		$year=$_GET['year'];
		$error=0;
		//<-------处理通过GET方法提交的变量;结束-------->
		if($year<1971)
		{
			$error="出错!<BR><a href=$_SERVER[PHP_SELF]>Back</a>";
			exit();
		}
		//<-------当月份超出1至12时的处理;开始------->
		if($month<1)
		{
			$month=12;
			$year-=1;
		}
		if($month>12)
		{
			$month=1;
			$year+=1;
		}
		//<-------当月份超出1至12时的处理;结束------->
		//<---------上一年,下一年,上月,下月的连接处理及输出;开始--------->
		$nextyear="<a href=./index.php?filename=schedule&action=m&year=".($year-1)."&month=".$month."><img src=\"./templates/$style/images/prev.gif\" border=0></a> 年 <a href=./index.php?filename=schedule&action=m&year=".($year+1)."&month=".$month."><img src=\"./templates/$style/images/next.gif\" border=0></a>";
		$nextm="<a href=./index.php?filename=schedule&action=m&month=".($month-1)."&year=".$year."><img src=\"./templates/$style/images/prev.gif\" border=0></a> 月 <a href=./index.php?filename=schedule&action=m&month=".($month+1)."&year=".$year."><img src=\"./templates/$style/images/next.gif\" border=0></a>";
		//<--------上一年,下一年,上月,下月的连接处理及输出;结束--------->
		$d=date("d");
		$day=date("w",mktime(0,0,0,$month,1,$year));//取得任何一个月的一号是星期几,用于计算一号是由表格的第几格开始
		$bgtoday=date("d");
		//用于计算星期天的字体颜色
		function font_color($month,$today,$year)
		{
			$sunday=date("w",mktime(0,0,0,$month,$today,$year));
			if($sunday=="0")
			{
				$FontColor="red";
			}
			else
			{
				$FontColor="black";
			}
			return $FontColor;
		}
		//用于计算当日的背景颜色
		function bgcolor($month,$bgtoday,$today_i,$year)
		{
			$show_today=date("d",mktime(0,0,0,$month,$today_i,$year));
			$sys_today=date("d",mktime(0,0,0,$month,$bgtoday,$year));
			if($show_today==$sys_today)
			{
				$bgcolor="bgcolor=#6699FF";
			}
			else
			{
				$bgcolor="class=td1";
			}
			return $bgcolor;
		}
		//用于计算星期天的字体风格
		function font_style($month,$today,$year)
		{
			$sunday=date("w",mktime(0,0,0,$month,$today,$year));
			if($sunday=="0")
			{
				$FontStyle="<strong>";
			}
			else
			{
				$FontStyle="";
			}
			return $FontStyle;
		}
		//此for用于输出某个月的一号位置
		for($i=0;$i<=$day;$i++)
		{
			for($i;$i<$day;$i++)
			{
				$showday.="<td align=center height=50 class=td1>&nbsp; </td>\n";
			}
			if($i==$day)
			{
				$gettime=mktime(0,0,0,$month,1,$year);
				$showday.="<td height=50 align=center ".bgcolor($month,$bgtoday,1,$year)." class=td1 onclick=get(\"$gettime\") style=\"cursor:hand\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."1</font></td>\n";
				if($day==6)//判断1号是否星期六
				{
					$showday.="</tr><tr>";
				}
			}
		}
		//某月的总天数
		$countMonth=date("t",mktime(0,0,0,$month,1,$year));
		//输出由1号定位,随后2号直至月尾的所有号数
		for($i=2;$i<=$countMonth;$i++)
		{
			$gettime=mktime(0,0,0,$month,$i,$year);
			$showday.="<td height=50 align=center ".bgcolor($month,$bgtoday,$i,$year)." style=\"cursor:hand\" onclick=get(\"$gettime\")><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."$i</font></td>\n";
			$enddate=date("w",mktime(0,0,0,$month,$i,$year));
			if($enddate==6)//判断该日是否星期六
			{
				$showday.="</tr><tr>\n";
			}
		}
		for ($i=6;$i>$enddate;$i--) $showday.="<td align=center height=50 class=td1>&nbsp; </td>\n";
		$arraydata=array('month'=>$month,'year'=>$year,'nextyear'=>$nextyear,'nextm'=>$nextm);
		$tpl->assign($arraydata);
		$tpl->assign('showday',$showday);
		break;
}
$tpl->assign('action',$action);
$tpl->display('schedule.html');
?>