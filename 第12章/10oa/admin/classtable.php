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
//栏目数据读取
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="全部文章";
}
//参数设置
if ($action=="") $action="public";
$typearr=explode(",",$class_subject_arr);
//年级设置和班级编号设置
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$gradearr[$r[classid]]=$r[classname];
}
$nowyeartime=date("m",time());
//小于七月则为第一学期
if ($nowyeartime<=7)  {
	$nowyear=date("Y")-1;
	$yearlist=$nowyear."学年<input type=hidden name=inyear value=$nowyear>";
}else {
	$nowyear=date("Y");
	$yearlist=$nowyear."学年<input type=hidden name=inyear value=$nowyear>";
}
unset($nowyear,$nowyeartime);
//设置建班时间
$classbuild[1]=array($gradeone."01",$gradeone."02",$gradeone."03",$gradeone."04",$gradeone."05",$gradeone."06",$gradeone."07",$gradeone."08");
$classbuild[2]=array($gradetwo."01",$gradetwo."02",$gradetwo."03",$gradetwo."04",$gradetwo."05",$gradetwo."06",$gradetwo."07",$gradetwo."08");
$classbuild[3]=array($gradethree."01",$gradethree."02",$gradethree."03",$gradethree."04",$gradethree."05",$gradethree."06",$gradethree."07",$gradethree."08");
//设置课名
foreach ($typearr as $value){$classlist.="<a href=# onclick=input('$value')>$value</a> | ";}
//设置教师
$query="select * from members where subjectid>0 and groupid<99";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$subjectarr[$r[subjectid]][]=$r[realname];
}
//设置教研组
$query="select * from subject";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$subjects[$r[subjectid]]=$r[subjectname];
}
$j=1;
foreach ($subjects as  $key=> $value){
	$teacherlist.="<select name=tt onchange=javascript:input(this.options[this.selectedIndex].value);selectone($j,this.options[this.selectedIndex].value);this.options.selectedIndex=0;> <option value='#'>".$value."组</option>";
	if (is_array($subjectarr[$key])){
		foreach ($subjectarr[$key] as $valueid){
			$teacherlist.="<option value=$valueid>$valueid</option>";
		}
	}
	$teacherlist.="</select>";
	$teacheronelist.="<input type=button name=one_$j onclick=javascript:input(this.value) value=先选择> |";
	$j++;
}
//设置年级
$gradelist="<select name=gradeid><option value=''>请选择班级</option>";
if (is_array($gradearr)){
foreach ($gradearr as $key=>$value){
	$gradelist.="<option value=$key>$value</option>";
}
}
$gradelist.="</select>";
//设置学年
switch($action){
	//添加课程表操作
	case 'add':
		//权限检测
		if ($rightdata[$typeid][1]!=1) showmessage("对不起，你没有权限访问！");
		//数据添加
		$data=array("classlist"=>$classlist,"teacheronelist"=>$teacheronelist,"teacherlist"=>$teacherlist,
		"gradelist"=>$gradelist,"yearlist"=>$yearlist);
		$tpl->assign($data);
		unset($data);
		break;
		//修改操作
	case 'edit':
		//权限检测
		if ($rightdata[$typeid][2]!=1) showmessage("对不起，你没有权限访问！");
		$query="select * from $table_classtable where  state=$upid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			$teacher[$r[week]][$r[classnum]]=$r[teacher];
			$hideid.="<input name=ids[$r[week]][$r[classnum]] type=hidden value=$r[id]>";
		};
		$tpl->assign("name",$name);
		$tpl->assign("teacher",$teacher);
		//设置星期和节次数据
		$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
		$classnum_arr=array("1"=>"第一节","2"=>"第二节","3"=>"第三节","4"=>"第四节","5"=>"第五节","6"=>"第六节","7"=>"第七节","8"=>"第八节");
		$tpl->assign("week_arr",$week_arr);
		$tpl->assign("classnum_arr",$classnum_arr);
		//数据添加
		$data=array("classlist"=>$classlist,"teacheronelist"=>$teacheronelist,"teacherlist"=>$teacherlist,"gradelist"=>$gradelist,
		"yearlist"=>$yearlist,"hideid"=>$hideid,"upid"=>$upid,"class"=>$class);
		$tpl->assign($data);
		unset($data);
		break;
	case 'del':
		//权限检测
		if ($rightdata[$typeid][3]!=1) showmessage("对不起，你没有权限访问！");
		$referer="index.php?filename=deal&action=delclasstable&id=$id&typeid=$typeid";
		showmessage("是否删除此条记录！",$referer,"form");
		break;
		//管理课表
	case 'list':
		//权限检测
		if ($rightdata[$typeid][2]!=1) showmessage("对不起，你没有权限访问！");
		//分页设置
		$query="select count(*) as num from $table_classtable where state=0 ";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$listurl="?filename=classtable&typeid=$typeid&action=list";
		$pagenav=getpagenav($totalnum,$listurl);
		//相应版块数据读取
		$query="select * from $table_classtable where state=0
        order by id desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			//设置班级
			$classname=$gradearr[$r['class']];
			//设置日期
			$title=$r[inyear]."学年课程表";
			$content[]=array("classname"=>$classname,"title"=>$title,"class"=>$r['class'],"inyear"=>$r[inyear],"id"=>$r[id],"typeid"=>$typeid);
		}
		//数据添加
		$tpl->assign("pagenav",$pagenav);
		$tpl->assign("content",$content);
		break;
		//-------------------------我的课程表---------------------------------------------------------
	case 'private':
		//参数设置
		if ($do==1){
			if ($selectyear=="") $selectyear=date(Y);
			else $selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
		}else {
			$nowyear=date(Y);
			$nowm=date(m);
			if ($nowm<8) {
				$selectyear=$nowyear-1;
			}else {
				$selectyear=$nowyear;
			}
			$showtablename=$selectyear."学年";
		}
		//相应版块数据读取
		$query="select *
        from $table_classtable
        where inyear=$selectyear and teacher like '$real_name';";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			//设置班级
			$classnum[$r[week]][$r[classnum]]=$r['class'];
		}
		$tpl->assign("select",$select);
		$tpl->assign("showtablename",$showtablename);
		$tpl->assign("name",$name);
		$tpl->assign("classnum",$classnum);
		//设置星期和节次数据
		$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
		$classnum_arr=array("1"=>"第一节","2"=>"第二节","3"=>"第三节","4"=>"第四节","5"=>"第五节","6"=>"第六节","7"=>"第七节","8"=>"第八节");
		$tpl->assign("week_arr",$week_arr);
		$tpl->assign("classnum_arr",$classnum_arr);
		break;
		//---------课程表查询------------------------------------------------------------
	case 'public':
		$tpl->assign("gradelist",$gradelist);
		break;
		//---------查询老师或班级的任课情况-------------------------------------------------
	case 'selectshow':
		//参数设置
		if ($do==1){
			if ($isword!=1){
				//设置查询日期
				if($selectyear){
					$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
				}else{
					$nowyear=date(Y);
					$nowm=date(m);
					if ($nowm<8) {
						$selectyear=$nowyear-1;
					}else {
						$selectyear=$nowyear;
					}
				}
			}else $tpl->assign("isword",$isword);
			//设置日期
			$title=$r[inyear]."学年课程表";
			// 判断是教师查询
			if ($usertype=="t"){
				$real_name=$selectclass;
				//相应版块数据读取
				$query="select * from $table_classtable where inyear=$selectyear and teacher like '$real_name';";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					//设置班级
					$classnum[$r[week]][$r[classnum]]=$r['class'];
					$name[$r[week]][$r[classnum]]=$r[classtitle];
				}
				$tpl->assign("selectyear",$selectyear);
				$tpl->assign("name",$name);
				$tpl->assign("classnum",$classnum);
				$tpl->assign("teachername",$selectclass);
			}else{//判断是班级查询
				//相应版块数据读取
				$query="select * from $table_classtable where inyear=$selectyear and `class`='$selectclass'";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					$name[$r[week]][$r[classnum]]=$r[classtitle];
					$teacher[$r[week]][$r[classnum]]=$r[teacher];
				}
				//设置班级
				$classname=$gradearr[$selectclass];
				$tpl->assign("name",$name);
				$tpl->assign("selectyear",$selectyear);
				$tpl->assign("classnum",$teacher);
				$tpl->assign("classname",$classname);
				$tpl->assign("selectclass",$selectclass);
			}
			$tpl->assign("selectyear",$selectyear);
			$tpl->assign("usertype",$usertype);
			$tpl->assign("showtablename",$showtablename);
			//设置星期和节次数据
			$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
			$classnum_arr=array("1"=>"第一节","2"=>"第二节","3"=>"第三节","4"=>"第四节","5"=>"第五节","6"=>"第六节","7"=>"第七节","8"=>"第八节");
			$tpl->assign("week_arr",$week_arr);
			$tpl->assign("classnum_arr",$classnum_arr);
		}
		$tpl->assign("typeid",$typeid);
		$tpl->assign('action',$action);
		$tpl->display('selectshow.html');
		exit;
		break;
		//-----------------------------生成单个班级和教师的word文档--------------------------
	case 'toword':
		function toword($pcontent)
		{
			$filename="resume_".time().".doc";
			ob_end_clean();
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Pragma: no-cache");
			header("Content-Encoding: none");
			header("Content-Disposition: attachment; filename=".$filename);
			header("Content-Length: " . strlen($pcontent));
			header("Content-type:application/vnd.ms-word");
			echo $pcontent;
			exit;
		}
		if ($do==1){
			//设置日期
			$showtablename=$selectyear."学年";
			// 判断是否是教师还是班级
			if ($usertype=="t"){
				$teacher_name=$selectclass;
				//相应版块数据读取
				$query="select * from $table_classtable where inyear=$selectyear and teacher like '$teacher_name';";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					$teacher[$r[week]][$r[classnum]]=$r['class'];
					$name[$r[week]][$r[classnum]]=$r[classtitle];
				}
			}else{
				//相应版块数据读取
				$query="select * from $table_classtable where inyear=$selectyear and `class`='$selectclass'";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					$name[$r[week]][$r[classnum]]=$r[classtitle];
					$teacher[$r[week]][$r[classnum]]=$r[teacher];
				}
				$classname=$gradearr[$selectclass];
			}
		}
		$out="
<style type=\"text/css\">
<!--
body{background-color: #ffffff;}
td{
border-left:0;
border-top:0;
font-family:\"Courier New\", Courier, mono;
border-color:#000000;
font-size:12px;
}
-->
</style>
<table width=\"500\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=ffffff align=center>
  <!--DWLayoutTable-->
  <tr>
    <td  valign=\"top\"> 
    <TABLE cellPadding=2 cellSpacing=1  width=\"100%\" >
        <!--DWLayoutTable-->
    <tr>
    <td width=\"500\" valign=\"top\">
    	<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
       <!--DWLayoutTable-->
       <tr>
        <td width=\"100%\"  valign=\"middle\" align=center height=32 class=style1>长江中学---".$classname.$teacher_name.$showtablename."课程表</td>
      </tr>
      <tr>
        <td width=\"100%\"  valign=\"middle\" align=center height=1 bgcolor=#000000></td>
      </tr>
      <tr>
        <td width=\"100%\"  valign=\"middle\" align=center>
        	<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" > 

            <tr>
              <td width=\"100%\"  valign=\"middle\" align=center colspan=2>
        	          	<TABLE cellPadding=2 cellSpacing=1 border=1 width=\"100%\" >
        <!--DWLayoutTable--> 
        <TBODY>
  <tr bgcolor=eeeeee>
    <td width=\"10%\" height=\"28\" align=\"center\" valign=\"middle\">星期</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期一</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期二</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期三</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期四</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期五</td>
  </tr>

  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第一节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$teacher[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$teacher[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$teacher[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$teacher[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$teacher[5][1]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第二节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$teacher[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$teacher[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$teacher[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$teacher[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$teacher[5][2]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第三节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$teacher[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$teacher[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$teacher[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$teacher[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$teacher[5][3]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第四节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$teacher[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$teacher[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$teacher[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$teacher[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$teacher[5][4]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第五节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$teacher[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$teacher[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$teacher[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$teacher[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$teacher[5][5]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第六节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$teacher[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$teacher[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$teacher[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$teacher[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$teacher[5][6]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第七节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$teacher[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$teacher[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$teacher[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$teacher[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$teacher[5][7]."</td>
  </tr>
    <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >第八节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][8]."/".$teacher[1][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][8]."/".$teacher[2][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][8]."/".$teacher[3][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][8]."/".$teacher[4][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][8]."/".$teacher[5][8]."</td>
  </tr>
          </TBODY>

      </TABLE>
              </td>
             </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
    </TABLE>
    </td>
  </tr>
</table>";
		toword($out);
		break;
	case 'savealltowordone':
				//设置查询日期
		if($selectyear){
			$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
		}else{
			$nowyear=date(Y);
			$nowm=date(m);
			if ($nowm<8) {
				$selectyear=$nowyear-1;
			}else {
				$selectyear=$nowyear;
			}
		}
		if ($tok=="t")
		$turl=" <a href=?filename=classtable&action=teacheralltoword&inyear=$selectyear> 开始生成全体教师课表word文件</a>";
		else
		$turl="<a href=?filename=classtable&action=classalltoword&inyear=$selectyear> 开始生成全体班级课表word文件</a>";
		echo "
			<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
       <!--DWLayoutTable-->
       <tr>
        <td width=\"100%\"  valign=\"middle\" align=center height=80 class=style1>
      $turl
        </td>
      </tr></table>
			";
		exit;
		break;
		//-----------------------------------------------保存教师课程表至word----------------------------------------
	case 'teacheralltoword':
		function toword($pcontent)
		{
			$mime_type="text/x-sql";
			$content_encoding="";
			$PMA_USR_BROWSER_AGENT="IE";
			//$filename="email.txt";// $filename="email.txt";
			//$sqldump=t3lib_div::_GP("sqldump");
			//$pcontent=$sqldump;
			//$filename="companyinfo".time().".XLS";
			$filename="resume_".time().".doc";
			ob_end_clean();
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Pragma: no-cache");
			header("Content-Encoding: none");
			header("Content-Disposition: attachment; filename=".$filename);
			header("Content-Length: " . strlen($pcontent));
			//header("Content-type: txt");
			header("Content-type:application/vnd.ms-word");
			echo $pcontent;
			exit;
		}
		$out="<style type=\"text/css\">
<!--
body{background-color: #ffffff;}
td{
border-left:0;
border-top:0;
font-family:\"Courier New\", Courier, mono;
border-color:#000000;
font-size:12px;
}
-->
</style>";
		$sql="select * from members where groupid<99;";
		$result=$db->query($sql);
		while($r=$db->fetch_array($result)){
			$user[]=$r[realname];
		}
		$i=1;
		foreach ($user as  $key=> $value){
			//相应版块数据读取
	echo		$query="select *
        from $table_classtable
        where inyear=$inyear and teacher like '$value';";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$name[$r[week]][$r[classnum]]=$r[classtitle];
				//设置班级
				$classnum[$r[week]][$r[classnum]]=$r['class'];
			}
			$out.="
  <TABLE cellPadding=2 cellSpacing=1 border=1 width=\"450\" borderclolr=#d32322>
        <!--DWLayoutTable--> 
          <TBODY>
  <tr><td colspan=6 align=\"center\" valign=\"middle\" height=24 bgcolor=#cccccc style=\"font:bold 14pt \">".$value.$inyear."学年课程表</td>
    </tr>
  <tr>
    <td width=\"10%\" height=\"20\" align=\"center\" valign=\"middle\" class=tr_head>星期</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>星期一</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>星期二</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>星期三</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>星期四</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>星期五</td>
  </tr>
    <tr>
      <td height=\"20\" align=\"center\" valign=\"middle\" class=tr_head2>节次</td>
      <td  align=\"center\" valign=\"middle\" class=tr_head2>课名/班级</td>
    <td align=\"center\" valign=\"middle\" class=tr_head2>课名/班级</td>
    <td  align=\"center\" valign=\"middle\" class=tr_head2>课名/班级</td>  
    <td align=\"center\" valign=\"middle\" class=tr_head2>课名/班级</td>
    <td  align=\"center\" valign=\"middle\" class=tr_head2>课名/班级</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第一节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$classnum[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$classnum[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$classnum[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$classnum[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$classnum[5][1]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第二节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$classnum[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$classnum[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$classnum[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$classnum[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$classnum[5][2]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第三节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$classnum[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$classnum[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$classnum[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$classnum[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$classnum[5][3]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第四节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$classnum[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$classnum[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$classnum[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$classnum[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$classnum[5][4]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第五节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$classnum[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$classnum[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$classnum[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$classnum[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$classnum[5][5]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第六节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$classnum[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$classnum[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$classnum[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$classnum[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$classnum[5][6]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第七节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$classnum[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$classnum[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$classnum[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$classnum[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$classnum[5][7]."</td>
  </tr>
    <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第八节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][8]."/".$classnum[1][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][8]."/".$classnum[2][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][8]."/".$classnum[3][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][8]."/".$classnum[4][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][8]."/".$classnum[5][8]."</td>
  </tr>
  </TBODY>
</TABLE>
";
			if ($i%3==0)$out."";else $out.="<br />";
			$i++;
			unset($name,$classnum);
		}
		toword($out);
		break;
		//-------------------所有班级课程表输出到word-----------------------------------------------------
	case 'classalltoword':
		function toword($pcontent)
		{
			$mime_type="text/x-sql";
			$content_encoding="";
			$PMA_USR_BROWSER_AGENT="IE";
			//$filename="email.txt";// $filename="email.txt";
			//$sqldump=t3lib_div::_GP("sqldump");
			//$pcontent=$sqldump;
			//$filename="companyinfo".time().".XLS";
			$filename="resume_".time().".doc";
			ob_end_clean();
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Pragma: no-cache");
			header("Content-Encoding: none");
			header("Content-Disposition: attachment; filename=".$filename);
			header("Content-Length: " . strlen($pcontent));
			//header("Content-type: txt");
			header("Content-type:application/vnd.ms-word");
			echo $pcontent;
			exit;
		}

		$sql="select * from $table_classtable where state=0 and inyear=$inyear;";
		$result=$db->query($sql);
		while($r=$db->fetch_array($result)){
			$classarr[]=$r["class"];
		}

		$i=1;
		$out="<style type=\"text/css\">
<!--
body{background-color: #ffffff;}
td{
border-left:0;
border-top:0;
font-family:\"Courier New\", Courier, mono;
border-color:#000000;
font-size:14px;
}
-->
</style>";
		foreach ($classarr as  $key=> $selectclass){
			//设置查询日期
			//$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
			//$select=$selectyear.$selectm;
			$showtablename=$inyear."学年";
			//相应版块数据读取
			$query="select *
            from $table_classtable
            where inyear=$inyear and `class`='$selectclass'";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$name[$r[week]][$r[classnum]]=$r[classtitle];
				$teacher[$r[week]][$r[classnum]]=$r[teacher];
			}
			$classname=$gradearr[$selectclass];
			$out.="
   <TABLE cellPadding=2 cellSpacing=1 border=1 width=\"500\" >
        <!--DWLayoutTable--> 
        <TBODY><tr>
        <td width=\"100%\"  valign=\"middle\" align=center height=24 colspan=6>长江中学---".$classname.$showtablename."课程表</td>
      </tr>
  <tr bgcolor=eeeeee>
    <td width=\"10%\" height=\"20\" align=\"center\" valign=\"middle\">星期</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期一</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期二</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期三</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期四</td>
    <td  width=18% align=\"center\" valign=\"middle\" >星期五</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第一节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$teacher[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$teacher[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$teacher[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$teacher[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$teacher[5][1]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第二节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$teacher[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$teacher[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$teacher[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$teacher[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$teacher[5][2]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第三节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$teacher[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$teacher[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$teacher[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$teacher[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$teacher[5][3]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第四节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$teacher[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$teacher[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$teacher[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$teacher[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$teacher[5][4]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第五节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$teacher[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$teacher[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$teacher[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$teacher[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$teacher[5][5]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第六节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$teacher[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$teacher[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$teacher[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$teacher[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$teacher[5][6]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第七节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$teacher[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$teacher[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$teacher[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$teacher[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$teacher[5][7]."</td>
  </tr>
    <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >第八节</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][8]."/".$teacher[1][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][8]."/".$teacher[2][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][8]."/".$teacher[3][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][8]."/".$teacher[4][8]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][8]."/".$teacher[5][8]."</td>
  </tr>
          </TBODY>

      </TABLE>
             ";
			$out.="<br />";
			unset($name,$classnum);
		}
		toword($out);
		break;
	case 'printtable':
		//设置查询日期
		//$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
		//$select=$selectyear.$selectm;
		//设置班级
		$buildyear=date("Y",mktime(0,0,0,1,1,substr($selectclass,0,2)));
		$buildclassid=substr($selectclass,-2);
		//设置日期
		$year=substr($select,0,4);
		$riqi=substr($select,-1);
		if ($riqi==1) {
			$year-=1;
			$classt=$year-$buildyear+3;
			$classname=$gradearr[$classt][$buildclassid-1];
			$showtablename=$year."年第二学期";
		}else {
			$classt=$year-$buildyear+4;
			$classname=$gradearr[$classt][$buildclassid-1];
			$showtablename=$year."年第一学期";
		}
		//相应版块数据读取
		$query="select *
            from $table_classtable
            where inyear=$select and `class`='$selectclass'";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			$teacher[$r[week]][$r[classnum]]=$r[teacher];
		}

		/***********************页面输出***********************************************/
?>

<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
	font-size:16px;
}
-->
</style>
<style type="text/css">
<!--
body{background-color: #ffffff;}

td{
border-left:0;
border-top:0;

font-family:"Courier New", Courier, mono;
border-color:#000000;
font-size:11px;

}

-->
</style>
<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.selectyear.value == "")
   {
   		alert("请输入日期!");
		theform.selectyear.focus();
		return false ;
   }
   return true ;
  }
</SCRIPT>
<body backgroundColor=#000000>
	<!--startprint-->
<table width="500" border="1" cellpadding="0" cellspacing="0" bgcolor=ffffff align=center>
  <!--DWLayoutTable-->
  <tr>
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="500" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=style1>长江中学---<?=$classname.$showtablename;?>课程表</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center height=1 bgcolor=#000000></td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" > 

            <tr>
              <td width="100%"  valign="middle" align=center colspan=2>
        	          	<TABLE cellPadding=2 cellSpacing=1 border=1 width="100%" >
        <!--DWLayoutTable--> 

        <TBODY>
  <tr bgcolor=eeeeee>
    <td width="10%" height="28" align="center" valign="middle">星期</td>
    <td  width=18% align="center" valign="middle" >星期一</td>
    <td  width=18% align="center" valign="middle" >星期二</td>
    <td  width=18% align="center" valign="middle" >星期三</td>
    <td  width=18% align="center" valign="middle" >星期四</td>
    <td  width=18% align="center" valign="middle" >星期五</td>
  </tr>

  <tr>
    <td height="24" align="center" valign="middle" >第一节</td>
    <td align="center" valign="middle" ><?=$name[1][1];?>/<?=$teacher[1][1];?></td>
    <td align="center" valign="middle" ><?=$name[2][1];?>/<?=$teacher[2][1];?></td>
    <td align="center" valign="middle" ><?=$name[3][1];?>/<?=$teacher[3][1];?></td>
    <td align="center" valign="middle" ><?=$name[4][1];?>/<?=$teacher[4][1];?></td>
    <td align="center" valign="middle" ><?=$name[5][1];?>/<?=$teacher[5][1];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第二节</td>
    <td align="center" valign="middle" ><?=$name[1][2];?>/<?=$teacher[1][2];?></td>
    <td align="center" valign="middle" ><?=$name[2][2];?>/<?=$teacher[2][2];?></td>
    <td align="center" valign="middle" ><?=$name[3][2];?>/<?=$teacher[3][2];?></td>
    <td align="center" valign="middle" ><?=$name[4][2];?>/<?=$teacher[4][2];?></td>
    <td align="center" valign="middle" ><?=$name[5][2];?>/<?=$teacher[5][2];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第三节</td>
    <td align="center" valign="middle" ><?=$name[1][3];?>/<?=$teacher[1][3];?></td>
    <td align="center" valign="middle" ><?=$name[2][3];?>/<?=$teacher[2][3];?></td>
    <td align="center" valign="middle" ><?=$name[3][3];?>/<?=$teacher[3][3];?></td>
    <td align="center" valign="middle" ><?=$name[4][3];?>/<?=$teacher[4][3];?></td>
    <td align="center" valign="middle" ><?=$name[5][3];?>/<?=$teacher[5][3];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第四节</td>
    <td align="center" valign="middle" ><?=$name[1][4];?>/<?=$teacher[1][4];?></td>
    <td align="center" valign="middle" ><?=$name[2][4];?>/<?=$teacher[2][4];?></td>
    <td align="center" valign="middle" ><?=$name[3][4];?>/<?=$teacher[3][4];?></td>
    <td align="center" valign="middle" ><?=$name[4][4];?>/<?=$teacher[4][4];?></td>
    <td align="center" valign="middle" ><?=$name[5][4];?>/<?=$teacher[5][4];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第五节</td>
    <td align="center" valign="middle" ><?=$name[1][5];?>/<?=$teacher[1][5];?></td>
    <td align="center" valign="middle" ><?=$name[2][5];?>/<?=$teacher[2][5];?></td>
    <td align="center" valign="middle" ><?=$name[3][5];?>/<?=$teacher[3][5];?></td>
    <td align="center" valign="middle" ><?=$name[4][5];?>/<?=$teacher[4][5];?></td>
    <td align="center" valign="middle" ><?=$name[5][5];?>/<?=$teacher[5][5];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第六节</td>
    <td align="center" valign="middle" ><?=$name[1][6];?>/<?=$teacher[1][6];?></td>
    <td align="center" valign="middle" ><?=$name[2][6];?>/<?=$teacher[2][6];?></td>
    <td align="center" valign="middle" ><?=$name[3][6];?>/<?=$teacher[3][6];?></td>
    <td align="center" valign="middle" ><?=$name[4][6];?>/<?=$teacher[4][6];?></td>
    <td align="center" valign="middle" ><?=$name[5][6];?>/<?=$teacher[5][6];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >第七节</td>
    <td align="center" valign="middle" ><?=$name[1][7];?>/<?=$teacher[1][7];?></td>
    <td align="center" valign="middle" ><?=$name[2][7];?>/<?=$teacher[2][7];?></td>
    <td align="center" valign="middle" ><?=$name[3][7];?>/<?=$teacher[3][7];?></td>
    <td align="center" valign="middle" ><?=$name[4][7];?>/<?=$teacher[4][7];?></td>
    <td align="center" valign="middle" ><?=$name[5][7];?>/<?=$teacher[5][7];?></td>
  </tr>
    <tr>
    <td height="24" align="center" valign="middle" >第八节</td>
    <td align="center" valign="middle" ><?=$name[1][8];?>/<?=$teacher[1][8];?></td>
    <td align="center" valign="middle" ><?=$name[2][8];?>/<?=$teacher[2][8];?></td>
    <td align="center" valign="middle" ><?=$name[3][8];?>/<?=$teacher[3][8];?></td>
    <td align="center" valign="middle" ><?=$name[4][8];?>/<?=$teacher[4][8];?></td>
    <td align="center" valign="middle" ><?=$name[5][8];?>/<?=$teacher[5][8];?></td>
  </tr>
          </TBODY>

      </TABLE>
              </td>
             </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
    </TABLE>
    </td>
  </tr>

</table>
<!--endprint-->
<div align=center>
<OBJECT  id=WebBrowser  classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2  height=0  width=0 VIEWASTEXT>
  </OBJECT>
  <script language=javascript>
function preview() { 
bdhtml=window.document.body.innerHTML; 
sprnstr="<!--startprint-->"; 
eprnstr="<!--endprint-->"; 
prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17); 
prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr)); 
window.document.body.innerHTML=prnhtml; 
window.print(); 
         }
</script>
<input type="button" name="aa" onclick="preview()" value=开始打印>
<input type=button value=页面设置 onclick="document.all.WebBrowser.ExecWB(8,1)" class="NOPRINT">
<input type=button value=打印预览 onclick="document.all.WebBrowser.ExecWB(7,1)" class="NOPRINT">
</div>
</body>
<?
break;
	case 'word':
		header("Content-type:application/vnd.ms-word");
		header("Content-Disposition:filename=zgfun.doc");
		$id=$_GET['id'];
		if (!get_magic_quotes_gpc()) {
			$id=addslashes($id);
		}
		function validateSize($Size)
		{
			return ereg("^[0-9]+$", $Size);
		}
		if (validateSize($id)<>1){
			echo '<script>alert("您的操作不合法，已被服务器记录！");</script>';
			die();
		}
		function PMA_getenv($var_name) {
			if (isset($_SERVER[$var_name])) {
				return $_SERVER[$var_name];
			} elseif (isset($_ENV[$var_name])) {
				return $_ENV[$var_name];
			} elseif (getenv($var_name)) {
				return getenv($var_name);
			} elseif (function_exists('apache_getenv')
			&& apache_getenv($var_name, true)) {
				return apache_getenv($var_name, true);
			}
			return '';
		}
		if (emptyempty($HTTP_HOST)) {
			if (PMA_getenv('HTTP_HOST')) {
				$HTTP_HOST = PMA_getenv('HTTP_HOST');
			} else {
				$HTTP_HOST = '';
			}
		}

		$URL = "http://".htmlspecialchars($HTTP_HOST)."/ext-test/oa/index.php?filename=classtable&action=selectshow&do=1&usertype=t&selectclass=".$selectclass."&select=$select";
		$content = file_get_contents("$URL");
		$search = array("/(.*<div id=print>)/is","/(<\/div>.*)/is");
		$replace = array('','');
		$title = preg_replace($search,$title,$content);
		$content=$title;
		echo $content;
		exit;
		break;
}
$tpl->assign("typeid",$typeid);
$tpl->assign('action',$action);
$tpl->display('classtable.html');
?>