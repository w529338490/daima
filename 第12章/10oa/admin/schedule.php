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
/******************************************************/
$tpl->assign('now_typename',$now_typename);
$tpl->assign('typeid',$typeid);
if ($action=="")$action="d";
switch($action){
	//��ӱ༭����
	case 'a':
		break;
		//���չ�������
	case 'd':
		//��������
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//��ҳ����
		$query="select count(*) as num from $table_schedule where inputer=$user_id and `intime`='$nowday'";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//��Ӧ������ݶ�ȡ
		$query="select *
        from $table_schedule
        where inputer=$user_id and `intime`='$nowday'
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="����";else $date_d=date("d",$r["intime"]);
				$content[]=array('id'=>$r[id],'date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content]);
			}
		}
		$tpl->assign('content',$content);
		break;
		//�ܹ�������
	case 'w':
		//���ò���
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		$leavetypeid=array("","����","�¼�","����");
		$noday=date(w);   //һ�ܵĵڼ���
		if ($noday==0)$noday=7;
		//������һ�����յ�timeֵ
		for ($i=1;$i<=7;$i++){
			$weeks[$i]=mktime(0,0,0,date(m),date(d)+$i-$noday,date(Y));
			$nowweeks=array("","����һ","���ڶ�","������","������","������","������","������");
		}
		//��ҳ����
		$query="select count(*) as num from $table_schedule  where inputer=$user_id and (intime<=$weeks[7] and intime>=$weeks[1])";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//��ȡ������Ϣ
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
				$todayschlist="����û������";
			}
			$nowweek=$nowweeks[$key];
			$daten=date(n,$weeks[$key]);
			$dated=date(d,$weeks[$key]);
			$content[]=array('nowweek'=>$nowweek,'daten'=>$daten,'dated'=>$dated,'todayschlist'=>$todayschlist);
			$tpl->assign('content',$content);
		}

		break;
		//��������
	case 't':
		//��������
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//��ҳ����
		$query="select count(*) as num from $table_schedule where inputer=$user_id and  ($nowday>=pretime and $nowday<=intime)";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//��Ӧ������ݶ�ȡ
		$query="select *
        from $table_schedule
        where inputer=$user_id and (pretime<=$nowday and intime>=$nowday) 
        order by pretime asc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="����";else $date_d=date("d",$r["intime"]);
				$articleurl="$rootpath/show.php?id=$r[articleid]";
				$content[]=array('id'=>$r[id],'date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content],'articleurl'=>$articleurl);
			}
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;
		//�²�ѯ�б�
	case 's':
		//��ҳ����
		$query="select count(*) as num from $table_schedule where inputer=$user_id and `intime`='$selecttime'";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,$listurl);
		//��Ӧ������ݶ�ȡ
		$query="select *
        from $table_schedule
        where inputer=$user_id and `intime`='$selecttime'
        order by intime desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$date_m=date("n",$r["intime"]);
				if ($nowday<=$r[intime] and $nextday>=$r[intime])$date_d="����";else $date_d=date("d",$r["intime"]);
				$articleurl="$rootpath/show.php?id=$r[articleid]";
				$content[]=array('date_m'=>$date_m,'date_d'=>$date_d,'title'=>$r[title],'content'=>$r[content],'articleurl'=>$articleurl);
			}
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
		break;
		//�²�ѯ
	case 'm':
	default:
		error_reporting(0);
		global $_GET;
		//<-------����ͨ��GET�����ύ�ı���;��ʼ-------->
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
		//<-------����ͨ��GET�����ύ�ı���;����-------->
		if($year<1971)
		{
			$error="����!<BR><a href=$_SERVER[PHP_SELF]>Back</a>";
			exit();
		}
		//<-------���·ݳ���1��12ʱ�Ĵ���;��ʼ------->
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
		//<-------���·ݳ���1��12ʱ�Ĵ���;����------->
		//<---------��һ��,��һ��,����,���µ����Ӵ������;��ʼ--------->
		$nextyear="<a href=./index.php?filename=schedule&action=m&year=".($year-1)."&month=".$month."><img src=\"./templates/$style/images/prev.gif\" border=0></a> �� <a href=./index.php?filename=schedule&action=m&year=".($year+1)."&month=".$month."><img src=\"./templates/$style/images/next.gif\" border=0></a>";
		$nextm="<a href=./index.php?filename=schedule&action=m&month=".($month-1)."&year=".$year."><img src=\"./templates/$style/images/prev.gif\" border=0></a> �� <a href=./index.php?filename=schedule&action=m&month=".($month+1)."&year=".$year."><img src=\"./templates/$style/images/next.gif\" border=0></a>";
		//<--------��һ��,��һ��,����,���µ����Ӵ������;����--------->
		$d=date("d");
		$day=date("w",mktime(0,0,0,$month,1,$year));//ȡ���κ�һ���µ�һ�������ڼ�,���ڼ���һ�����ɱ��ĵڼ���ʼ
		$bgtoday=date("d");
		//���ڼ����������������ɫ
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
		//���ڼ��㵱�յı�����ɫ
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
		//���ڼ����������������
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
		//��for�������ĳ���µ�һ��λ��
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
				if($day==6)//�ж�1���Ƿ�������
				{
					$showday.="</tr><tr>";
				}
			}
		}
		//ĳ�µ�������
		$countMonth=date("t",mktime(0,0,0,$month,1,$year));
		//�����1�Ŷ�λ,���2��ֱ����β�����к���
		for($i=2;$i<=$countMonth;$i++)
		{
			$gettime=mktime(0,0,0,$month,$i,$year);
			$showday.="<td height=50 align=center ".bgcolor($month,$bgtoday,$i,$year)." style=\"cursor:hand\" onclick=get(\"$gettime\")><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."$i</font></td>\n";
			$enddate=date("w",mktime(0,0,0,$month,$i,$year));
			if($enddate==6)//�жϸ����Ƿ�������
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