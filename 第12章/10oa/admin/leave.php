<?php
/*
����ɽ��Сѧ����칫��
*/
/***********************************************************************/
//�û���Ȩ�޶�ȡ
$sql="select * from userright where rightid=$group_id limit 1";
$result=$db->query($sql);
if($db->affected_rows()!=0){
	$r=$db->fetch_array($result);
	$rights=$r[rights];
	$right=1;  //����
	$rights=explode(":",$rights);
	while (list($key,$tempright)=each($rights)){
		$tempright=explode("|",$tempright);
		$rightlen=sizeof($tempright);
		for ($i=1;$i<=$rightlen;$i++)
		$rightdata[$tempright[0]][]=$tempright[$i];
	}
} else $right=0;
//��Ŀ���ݶ�ȡ
$query="select * from $table_type where id=$typeid";
$r=$db->query_first($query);
$type_name=$r[typename];
//������ת
switch($action){
	case 'add'://�������
	break;
	case 'edit'://�༭���
	break;
	case 'delleave'://ɾ�����
	if ($rightdata[$typeid][4]!=1) showmessage("�Բ�����û��Ȩ��ɾ����");
	$url="?filename=deal&action=delleave&leaveid=$leaveid&typeid=$typeid";
	showmessage("��ͬ�⳷��<font color=red>[$leaver]</font>ͬ־�����!",$url,"form");
	break;
	case 'passleave'://������
	if ($rightdata[$typeid][4]!=1) showmessage("�Բ�����û��Ȩ��������");
	$url="?filename=deal&action=passleave&leaveid=$leaveid&typeid=$typeid";
	showmessage("��ͬ��<font color=red>[$leaver]</font>ͬ־���!",$url,"form");
	break;
	case 'pass'://��׼���
	//���ò���
	$nowday=mktime(0,0,0,date(m),date(d),date(Y));
	$leavetypeid=array("","����","�¼�","����");
	$query="select *
            from  $table_leave
            where pass=0
            order by id desc ;";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$r[leavetypeid]=$leavetypeid[$r[leavetypeid]];
		$nowtime=mktime(0,0,0,date(m),date(d),date(Y));
		$pass_state=$nowtime>$r[stime]?"1":"";//�����ʼʱ�䳬�������ڣ���Ϊ��Ч����٣�ɾ��
		$stime=date("Y-n-d",$r[stime]);
		$etime=date("Y-n-d",$r[etime]);
		$content[]=array("leaveid"=>$r[id],"leaver"=>$r[leaver],"leavetypeid"=>$r[leavetypeid],"reason"=>$r[reason],
		"stime"=>$stime,"etime"=>$etime,"typeid"=>$typeid,"pass_state"=>$pass_state);
	}
	$tpl->assign('date_n',date(n));
	$tpl->assign('pagenav',$pagenav);
	$tpl->assign('content',$content);
	break;
	case 'myleave'://�ҵ�������
	//���ò���
	$nowday=mktime(0,0,0,date(m),date(d),date(Y));
	$leavetypeid=array("","����","�¼�","����");
	//��ҳ����
	$query="select count(*) as num from  $table_leave where typeid=$typeid and pass=1 and `leaver`='$real_name'";
	$r=$db->query_first($query);
	$totalnum=$r[num];
	$pagenumber = intval($pagenumber);
	if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
	$curpage=($pagenumber-1)*$perpage;
	$pagenav=getpagenav($totalnum,"?filename=leave&action=myleave&typeid=$typeid");
	//���ݶ�ȡ
	$query="select *
        from  $table_leave
        where typeid=$typeid and pass=1 and `leaver`='$real_name'
        order by id desc 
        limit $curpage,$perpage;";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$r[leavetypeid]=$leavetypeid[$r[leavetypeid]];
		$stime=date("Y-n-d",$r[stime]);
		$etime=date("Y-n-d",$r[etime]);
		$content[]=array("leaveid"=>$r[id],"leaver"=>$r[leaver],"leavetypeid"=>$r[leavetypeid],"reason"=>$r[reason],
		"stime"=>$stime,"etime"=>$etime,"passer"=>$r[passer]);
	}
	$tpl->assign('date_n',date(n));
	$tpl->assign('pagenav',$pagenav);
	$tpl->assign('content',$content);
	break;
	case 'all'://����������
	//���ò���
	$nowday=mktime(0,0,0,date(m),date(d),date(Y));
	$leavetypeid=array("","����","�¼�","����");
	//��ҳ����
	$query="select count(*) as num from  $table_leave where typeid=$typeid and pass=1 ";
	$r=$db->query_first($query);
	$totalnum=$r[num];
	$pagenumber = intval($pagenumber);
	if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
	$curpage=($pagenumber-1)*$perpage;
	$pagenav=getpagenav($totalnum,"?filename=leave&action=all&typeid=$typeid");
	//���ݶ�ȡ
	$query="select *
        from  $table_leave
        where typeid=$typeid and pass=1 
        order by id desc 
        limit $curpage,$perpage;";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$r[leavetypeid]=$leavetypeid[$r[leavetypeid]];
		$stime=date("Y-n-d",$r[stime]);
		$etime=date("Y-n-d",$r[etime]);
		$content[]=array("leaveid"=>$r[id],"leaver"=>$r[leaver],"leavetypeid"=>$r[leavetypeid],"reason"=>$r[reason],
		"stime"=>$stime,"etime"=>$etime,"passer"=>$r[passer]);
	}
	$tpl->assign('date_n',date(n));
	$tpl->assign('pagenav',$pagenav);
	$tpl->assign('content',$content);
	break;
	case 'week'://����������
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
	//��ȡ������Ϣ
	$query="select *
        from  $table_leave
        where typeid=$typeid and pass=1  and (stime<=$weeks[7] and etime>=$weeks[1]) 
        order by stime ASC ;";
	$result=$db->query($query);
	$i=1;
	while($r=$db->fetch_array($result)){
		$weekleave[$i]=array("$r[leaver]","$r[passer]","$r[reason]","$r[leavetypeid]","$r[stime]","$r[etime]");
		if ($weekleave[$i][4]<=$weeks[1] and $weekleave[$i][5]>=$weeks[1])$weekleavedata[1][]=$i;
		if ($weekleave[$i][4]<=$weeks[2] and $weekleave[$i][5]>=$weeks[2])$weekleavedata[2][]=$i;
		if ($weekleave[$i][4]<=$weeks[3] and $weekleave[$i][5]>=$weeks[3])$weekleavedata[3][]=$i;
		if ($weekleave[$i][4]<=$weeks[4] and $weekleave[$i][5]>=$weeks[4])$weekleavedata[4][]=$i;
		if ($weekleave[$i][4]<=$weeks[5] and $weekleave[$i][5]>=$weeks[5])$weekleavedata[5][]=$i;
		if ($weekleave[$i][4]<=$weeks[6] and $weekleave[$i][5]>=$weeks[6])$weekleavedata[6][]=$i;
		if ($weekleave[$i][4]<=$weeks[7] and $weekleave[$i][5]>=$weeks[7])$weekleavedata[7][]=$i;
		$i++;
	}

	while (list($key,$day)=each($weeks)){
		$todayleavelist="";
		if (is_array($weekleavedata[$key])){
			while(list($i,$weekleaveid)=each($weekleavedata[$key])){
				$weekleavetype=$leavetypeid[$weekleave[$weekleaveid][3]];
				$stime=date("Y-n-d",$weekleave[$weekleaveid][4]);
				$etime=date("Y-n-d",$weekleave[$weekleaveid][5]);
				$s[$key][]=array("leaveid"=>$r[id],"leaver"=>$weekleave[$weekleaveid][0],"leavetypeid"=>$weekleavetype,"reason"=>$weekleave[$weekleaveid][2],
				"stime"=>$stime,"etime"=>$etime,"passer"=>$weekleave[$weekleaveid][1]);
			}
		}
		$nowweek=$nowweeks[$key];
		$date_n=date(n,$weeks[$key]);
		$date_d=date(d,$weeks[$key]);
		$content[$key]=array("date_n"=>$date_n,"date_d"=>$date_d,"nowweek"=>$nowweek);
	}
	$tpl->assign('s',$s);
	$tpl->assign('content',$content);
	break;
	default://���ռ�������
	//���ò���
	$nowday=mktime(0,0,0,date(m),date(d),date(Y));
	$leavetypeid=array("","����","�¼�","����");

	$query="select *
        from  $table_leave
        where typeid=$typeid and pass=1 and stime<=$nowday and $nowday<=etime
        order by id desc ;";
	$result=$db->query($query);
	while($r=$db->fetch_array($result)){
		$r[leavetypeid]=$leavetypeid[$r[leavetypeid]];
		$stime=date("Y-n-d",$r[stime]);
		$etime=date("Y-n-d",$r[etime]);
		$content[]=array("leaveid"=>$r[id],"leaver"=>$r[leaver],"leavetypeid"=>$r[leavetypeid],"reason"=>$r[reason],
		"stime"=>$stime,"etime"=>$etime,"passer"=>$r[passer]);
	}
	$tpl->assign('date_n',date(n));
	$tpl->assign('pagenav',$pagenav);
	$tpl->assign('content',$content);
	break;
}
$tpl->assign('real_name',$real_name);
$tpl->assign('typeid',$typeid);
$tpl->assign('action',$action);
$tpl->display('leave.html');
?>