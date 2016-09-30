<?php
/*
凤鸣山中小学网络办公室
*/

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
if ($right==0) showmessage("对不起，你没有权限访问！");
/**********************************************************************/
//获取临时postid值
$temppostid=getcode();
/******************栏目读取**********************************************/
//栏目数据读取
$query="select * from $table_type where enablecontribute=1 order by `path`,`tid`";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$totaltype[$r[id]]=$r[typename];
	$typelist.="<option value=$r[id]>$r[typename]</option>";
};
$tpl->assign('typelist',$typelist);
//部门信息读取
$query="SELECT * FROM `management` ORDER BY `manageid` ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$totalmanagement[$r[manageid]]=$r[managename];
	$management.="<option value=$r[manageid]>$r[managename]</option>";
}
$tpl->assign('management',$management);
//文章短标题
$includepic_arr=explode(",",$includepic_arr);
$i=0;
foreach($includepic_arr AS $value){
	$includepic_list.="<option value=$i>$value</option>";
	$i++;
}
$tpl->assign('includepic_list',$includepic_list);
if ($totaltype[$typeid]=="")  unset($is_type); else $is_type=1;
/*******************************************************************************/
switch ($action){
	case 'add':
		//权限检测
		if ($rightdata[$typeid][1]!=1) showmessage("对不起，你没有权限访问！");
		$no_repeat=getcode(4);
		setcookie('no_repeat_state',$no_repeat);
		//load edit
		include_once('./include/sinaEditor.class.php');
		$editor=new sinaEditor('gently_editor');
		$editor->BasePath='.';
		$editor->Height=500;
		$editor->Width=700;
		$editor->AutoSave=false;
		$editor=$editor->Create();
		$tpl->assign('editor',$editor);
		//date
		$o_day=date("Y-m-d",time());
		$t_day=date("Y-m-d",time()+86400);
		//
		$hidden_data=array('user_id'=>$user_id,'real_name'=>$real_name,'temppostid'=>$temppostid,
		'o_day'=>$o_day,'t_day'=>$t_day,'no_repeat'=>$no_repeat);
		$tpl->assign($hidden_data);
		break;
	case 'edit':
		/*****************************开始修改文章****************************************************/
		//权限检测
		if ($rightdata[$typeid][2]!=1) showmessage("对不起，你没有权限访问！");
		$query="select * from $table_articles where articleid='$articleid'";
		$result=$db->query($query);
		$r=$db->fetch_array($result);
		/*******************设置列表变量************************/
		//数据初始化
		$temppostid=$r[articleid];
		$tpl->assign('temppostid',$temppostid);
		//栏目选择
		$classid=$r[typeid];
		$typename=$totaltype[$r[typeid]];
		$tpl->assign(array('classid'=>$classid,'typename'=>$typename));
		//部门选择
		$manageid=$r[manageid];
		$managename=$totalmanagement[$r[manageid]];
		$tpl->assign(array('manageid'=>$manageid,'managename'=>$managename));
		//标题前缀选择
		$includepic=$r[includepic];
		$tpl->assign('includepic',$includepic);
		//标题颜色选择
		$titlefontcolor=$r[titlefontcolor];
		$tpl->assign('titlefontcolor',$titlefontcolor);
		//标题字形选择
		$titlefonttype=$r[titlefonttype];
		$tpl->assign('titlefonttype',$titlefonttype);
		//内容
		$content=$r[content];
		//是否发表
		if ($r[pass]==1) {$pass1="checked";} else {$pass0="checked";};
		$tpl->assign(array('pass1'=>$pass1,'pass0'=>$pass0));
		/*//图片标题选择
		$sql="SELECT * FROM `$table_images` where postid='$r[articleid]'";
		$result=$db->query($sql);
		while($rimages=$db->fetch_array($result))
		{
		$imagesselect.="<option value=$rimages[imagepath]>$rimages[imagepath]</option>";
		};*/
		//附加文件选择
		$sql="SELECT * FROM `$table_soft` where postid='$r[articleid]'";
		$result=$db->query($sql);
		while($rsoft=$db->fetch_array($result))
		{
			$softselect.="<option value=$rsoft[softid]>$rsoft[softname]</option>";
		};
		$tpl->assign('softselect',$softselect);
		//data
		$outtime=date("Y-m-d",$r[outtime]);
		$tpl->assign(array('title'=>$r[title],'subheading'=>$r[subheading],'outtime'=>$outtime,'copyfromname'=>$r[copyfromname],'copyfromurl'=>$r[copyfromurl],'author'=>$r[author],
		'real_name'=>$real_name,'typeid'=>$typeid,'articleid'=>$articleid));
		//相关人员的信息处理
		$sql="select * from $table_schedule
		      LEFT JOIN members ON members.userid=$table_schedule.inputer 
              where $table_schedule.articleid=$r[articleid]
              ";
		$result=$db->query($sql);
		$d="";
		while($tr=$db->fetch_array($result))
		{
			$teacherlist.=$d.$tr[realname];
			$d=",";
		}
		$tpl->assign('teacherlist',$teacherlist);
		//content
		//load edit
		include_once('./include/sinaEditor.class.php');
		$editor=new sinaEditor('gently_editor');
		$editor->Value=$content;
		$editor->BasePath='.';
		$editor->Height=500;
		$editor->Width=700;
		$editor->AutoSave=false;
		$editor=$editor->Create();
		$tpl->assign('editor',$editor);
		break;
	case 'list':
		//权限检测
		if ($rightdata[$typeid][0]!=1) showmessage("对不起，你没有权限访问！");
		//分页设置
		$query="select count(*) as num from $table_articles where inputer=$user_id";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,"?filename=article&action=list&typeid=$typeid");
		$tpl->assign("pagenav",$pagenav);
		//相应版块数据读取
		$query="select $table_articles.*,$table_type.typename,members.realname,management.managename
        from $table_articles
        left join $table_type on $table_articles.typeid=$table_type.id 
        left join members on $table_articles.inputer=members.userid 
        left join management on $table_articles.manageid=management.manageid 
        where $table_articles.inputer=$user_id
        order by articleid desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		if($result){
			while($r=$db->fetch_array($result)){
				$adddate=date("Y-m-d",$r["addtime"]);
				$articleurl="?filename=show&id=$r[articleid]";
				$content[]=array("articleid"=>$r[articleid],"articleurl"=>$articleurl,"adddate"=>$adddate,
				"ntypeid"=>$r[typeid],"typename"=>$r[typename],"manageid"=>$r[manageid],
				"managename"=>$r[managename],"title"=>$r[title]);
			}
		}
		$tpl->assign("realname",$real_name);
	
		$tpl->assign('content',$content);
		break;
}	
$tpl->assign("typeid",$typeid);
$tpl->assign('sitetitle',$sitetitle);
$tpl->assign('action',$action);
$tpl->display('article.html');
?>
