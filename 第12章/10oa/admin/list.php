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
//���¶̱���
$includepics=explode(",",$includepic_arr);
switch($action){
	/**************************���**����***�������һ*********************************************/
	case 'class':
		//Ȩ�޼��
		if ($rightdata[$typeid][0]!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
		//��Ŀ���ݶ�ȡ
		$query="select * from $table_type where id=$typeid";
		$r=$db->query_first($query);
		$type_name=$r[typename];
		//��������
		$nnextday=mktime(0,0,0,date(m),date(d)+2,date(Y));
		$nextday=mktime(0,0,0,date(m),date(d)+1,date(Y));
		$nowday=mktime(0,0,0,date(m),date(d),date(Y));
		//��ҳ����
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
		//��Ӧ������ݶ�ȡ
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
				if ($nowday<=$r[outtime] and $nextday>$r[outtime])$date_d="<font color=red>����</font>";
				elseif ($nextday<=$r[outtime] and $nnextday>=$r[outtime])$date_d="<font color=red>����</font>";
				else $date_d=date("d",$r[outtime]);
				$date_t=date("Y-m-d H:s",$r["addtime"]);
				//$includepics=array("","<font color=#E0572A>��ת�桹</font>","<font color=red>��������</font>","<font color=blue>���Ƽ���</font>","<font color=#7A66B3>��ע�⡹</font>","<font color=#2C3588>�����Ρ�</font>","<font color=#BF6E14>�������Ρ�</font>");
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
