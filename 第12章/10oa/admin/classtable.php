<?php
/*
����ɽ��Сѧ����칫��
*/
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
if ($typeid){
	$query="select typename from $table_type where `id`='$typeid' limit 1";
	$r=$db->query_first($query);
	$now_typename=$r[typename];
}else {
	$now_typename="ȫ������";
}
//��������
if ($action=="") $action="public";
$typearr=explode(",",$class_subject_arr);
//�꼶���úͰ༶�������
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$gradearr[$r[classid]]=$r[classname];
}
$nowyeartime=date("m",time());
//С��������Ϊ��һѧ��
if ($nowyeartime<=7)  {
	$nowyear=date("Y")-1;
	$yearlist=$nowyear."ѧ��<input type=hidden name=inyear value=$nowyear>";
}else {
	$nowyear=date("Y");
	$yearlist=$nowyear."ѧ��<input type=hidden name=inyear value=$nowyear>";
}
unset($nowyear,$nowyeartime);
//���ý���ʱ��
$classbuild[1]=array($gradeone."01",$gradeone."02",$gradeone."03",$gradeone."04",$gradeone."05",$gradeone."06",$gradeone."07",$gradeone."08");
$classbuild[2]=array($gradetwo."01",$gradetwo."02",$gradetwo."03",$gradetwo."04",$gradetwo."05",$gradetwo."06",$gradetwo."07",$gradetwo."08");
$classbuild[3]=array($gradethree."01",$gradethree."02",$gradethree."03",$gradethree."04",$gradethree."05",$gradethree."06",$gradethree."07",$gradethree."08");
//���ÿ���
foreach ($typearr as $value){$classlist.="<a href=# onclick=input('$value')>$value</a> | ";}
//���ý�ʦ
$query="select * from members where subjectid>0 and groupid<99";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$subjectarr[$r[subjectid]][]=$r[realname];
}
//���ý�����
$query="select * from subject";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$subjects[$r[subjectid]]=$r[subjectname];
}
$j=1;
foreach ($subjects as  $key=> $value){
	$teacherlist.="<select name=tt onchange=javascript:input(this.options[this.selectedIndex].value);selectone($j,this.options[this.selectedIndex].value);this.options.selectedIndex=0;> <option value='#'>".$value."��</option>";
	if (is_array($subjectarr[$key])){
		foreach ($subjectarr[$key] as $valueid){
			$teacherlist.="<option value=$valueid>$valueid</option>";
		}
	}
	$teacherlist.="</select>";
	$teacheronelist.="<input type=button name=one_$j onclick=javascript:input(this.value) value=��ѡ��> |";
	$j++;
}
//�����꼶
$gradelist="<select name=gradeid><option value=''>��ѡ��༶</option>";
if (is_array($gradearr)){
foreach ($gradearr as $key=>$value){
	$gradelist.="<option value=$key>$value</option>";
}
}
$gradelist.="</select>";
//����ѧ��
switch($action){
	//��ӿγ̱����
	case 'add':
		//Ȩ�޼��
		if ($rightdata[$typeid][1]!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
		//�������
		$data=array("classlist"=>$classlist,"teacheronelist"=>$teacheronelist,"teacherlist"=>$teacherlist,
		"gradelist"=>$gradelist,"yearlist"=>$yearlist);
		$tpl->assign($data);
		unset($data);
		break;
		//�޸Ĳ���
	case 'edit':
		//Ȩ�޼��
		if ($rightdata[$typeid][2]!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
		$query="select * from $table_classtable where  state=$upid";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			$teacher[$r[week]][$r[classnum]]=$r[teacher];
			$hideid.="<input name=ids[$r[week]][$r[classnum]] type=hidden value=$r[id]>";
		};
		$tpl->assign("name",$name);
		$tpl->assign("teacher",$teacher);
		//�������ںͽڴ�����
		$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
		$classnum_arr=array("1"=>"��һ��","2"=>"�ڶ���","3"=>"������","4"=>"���Ľ�","5"=>"�����","6"=>"������","7"=>"���߽�","8"=>"�ڰ˽�");
		$tpl->assign("week_arr",$week_arr);
		$tpl->assign("classnum_arr",$classnum_arr);
		//�������
		$data=array("classlist"=>$classlist,"teacheronelist"=>$teacheronelist,"teacherlist"=>$teacherlist,"gradelist"=>$gradelist,
		"yearlist"=>$yearlist,"hideid"=>$hideid,"upid"=>$upid,"class"=>$class);
		$tpl->assign($data);
		unset($data);
		break;
	case 'del':
		//Ȩ�޼��
		if ($rightdata[$typeid][3]!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
		$referer="index.php?filename=deal&action=delclasstable&id=$id&typeid=$typeid";
		showmessage("�Ƿ�ɾ��������¼��",$referer,"form");
		break;
		//����α�
	case 'list':
		//Ȩ�޼��
		if ($rightdata[$typeid][2]!=1) showmessage("�Բ�����û��Ȩ�޷��ʣ�");
		//��ҳ����
		$query="select count(*) as num from $table_classtable where state=0 ";
		$r=$db->query_first($query);
		$totalnum=$r[num];
		$pagenumber = intval($pagenumber);
		if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
		$curpage=($pagenumber-1)*$perpage;
		$listurl="?filename=classtable&typeid=$typeid&action=list";
		$pagenav=getpagenav($totalnum,$listurl);
		//��Ӧ������ݶ�ȡ
		$query="select * from $table_classtable where state=0
        order by id desc 
        limit $curpage,$perpage";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			//���ð༶
			$classname=$gradearr[$r['class']];
			//��������
			$title=$r[inyear]."ѧ��γ̱�";
			$content[]=array("classname"=>$classname,"title"=>$title,"class"=>$r['class'],"inyear"=>$r[inyear],"id"=>$r[id],"typeid"=>$typeid);
		}
		//�������
		$tpl->assign("pagenav",$pagenav);
		$tpl->assign("content",$content);
		break;
		//-------------------------�ҵĿγ̱�---------------------------------------------------------
	case 'private':
		//��������
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
			$showtablename=$selectyear."ѧ��";
		}
		//��Ӧ������ݶ�ȡ
		$query="select *
        from $table_classtable
        where inyear=$selectyear and teacher like '$real_name';";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			//���ð༶
			$classnum[$r[week]][$r[classnum]]=$r['class'];
		}
		$tpl->assign("select",$select);
		$tpl->assign("showtablename",$showtablename);
		$tpl->assign("name",$name);
		$tpl->assign("classnum",$classnum);
		//�������ںͽڴ�����
		$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
		$classnum_arr=array("1"=>"��һ��","2"=>"�ڶ���","3"=>"������","4"=>"���Ľ�","5"=>"�����","6"=>"������","7"=>"���߽�","8"=>"�ڰ˽�");
		$tpl->assign("week_arr",$week_arr);
		$tpl->assign("classnum_arr",$classnum_arr);
		break;
		//---------�γ̱��ѯ------------------------------------------------------------
	case 'public':
		$tpl->assign("gradelist",$gradelist);
		break;
		//---------��ѯ��ʦ��༶���ο����-------------------------------------------------
	case 'selectshow':
		//��������
		if ($do==1){
			if ($isword!=1){
				//���ò�ѯ����
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
			//��������
			$title=$r[inyear]."ѧ��γ̱�";
			// �ж��ǽ�ʦ��ѯ
			if ($usertype=="t"){
				$real_name=$selectclass;
				//��Ӧ������ݶ�ȡ
				$query="select * from $table_classtable where inyear=$selectyear and teacher like '$real_name';";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					//���ð༶
					$classnum[$r[week]][$r[classnum]]=$r['class'];
					$name[$r[week]][$r[classnum]]=$r[classtitle];
				}
				$tpl->assign("selectyear",$selectyear);
				$tpl->assign("name",$name);
				$tpl->assign("classnum",$classnum);
				$tpl->assign("teachername",$selectclass);
			}else{//�ж��ǰ༶��ѯ
				//��Ӧ������ݶ�ȡ
				$query="select * from $table_classtable where inyear=$selectyear and `class`='$selectclass'";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					$name[$r[week]][$r[classnum]]=$r[classtitle];
					$teacher[$r[week]][$r[classnum]]=$r[teacher];
				}
				//���ð༶
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
			//�������ںͽڴ�����
			$week_arr=array("1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1");
			$classnum_arr=array("1"=>"��һ��","2"=>"�ڶ���","3"=>"������","4"=>"���Ľ�","5"=>"�����","6"=>"������","7"=>"���߽�","8"=>"�ڰ˽�");
			$tpl->assign("week_arr",$week_arr);
			$tpl->assign("classnum_arr",$classnum_arr);
		}
		$tpl->assign("typeid",$typeid);
		$tpl->assign('action',$action);
		$tpl->display('selectshow.html');
		exit;
		break;
		//-----------------------------���ɵ����༶�ͽ�ʦ��word�ĵ�--------------------------
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
			//��������
			$showtablename=$selectyear."ѧ��";
			// �ж��Ƿ��ǽ�ʦ���ǰ༶
			if ($usertype=="t"){
				$teacher_name=$selectclass;
				//��Ӧ������ݶ�ȡ
				$query="select * from $table_classtable where inyear=$selectyear and teacher like '$teacher_name';";
				$result=$db->query($query);
				while($r=$db->fetch_array($result)){
					$teacher[$r[week]][$r[classnum]]=$r['class'];
					$name[$r[week]][$r[classnum]]=$r[classtitle];
				}
			}else{
				//��Ӧ������ݶ�ȡ
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
        <td width=\"100%\"  valign=\"middle\" align=center height=32 class=style1>������ѧ---".$classname.$teacher_name.$showtablename."�γ̱�</td>
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
    <td width=\"10%\" height=\"28\" align=\"center\" valign=\"middle\">����</td>
    <td  width=18% align=\"center\" valign=\"middle\" >����һ</td>
    <td  width=18% align=\"center\" valign=\"middle\" >���ڶ�</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
  </tr>

  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >��һ��</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$teacher[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$teacher[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$teacher[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$teacher[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$teacher[5][1]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >�ڶ���</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$teacher[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$teacher[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$teacher[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$teacher[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$teacher[5][2]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$teacher[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$teacher[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$teacher[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$teacher[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$teacher[5][3]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >���Ľ�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$teacher[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$teacher[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$teacher[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$teacher[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$teacher[5][4]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >�����</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$teacher[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$teacher[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$teacher[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$teacher[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$teacher[5][5]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$teacher[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$teacher[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$teacher[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$teacher[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$teacher[5][6]."</td>
  </tr>
  <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >���߽�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$teacher[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$teacher[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$teacher[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$teacher[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$teacher[5][7]."</td>
  </tr>
    <tr>
    <td height=\"24\" align=\"center\" valign=\"middle\" >�ڰ˽�</td>
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
				//���ò�ѯ����
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
		$turl=" <a href=?filename=classtable&action=teacheralltoword&inyear=$selectyear> ��ʼ����ȫ���ʦ�α�word�ļ�</a>";
		else
		$turl="<a href=?filename=classtable&action=classalltoword&inyear=$selectyear> ��ʼ����ȫ��༶�α�word�ļ�</a>";
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
		//-----------------------------------------------�����ʦ�γ̱���word----------------------------------------
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
			//��Ӧ������ݶ�ȡ
	echo		$query="select *
        from $table_classtable
        where inyear=$inyear and teacher like '$value';";
			$result=$db->query($query);
			while($r=$db->fetch_array($result)){
				$name[$r[week]][$r[classnum]]=$r[classtitle];
				//���ð༶
				$classnum[$r[week]][$r[classnum]]=$r['class'];
			}
			$out.="
  <TABLE cellPadding=2 cellSpacing=1 border=1 width=\"450\" borderclolr=#d32322>
        <!--DWLayoutTable--> 
          <TBODY>
  <tr><td colspan=6 align=\"center\" valign=\"middle\" height=24 bgcolor=#cccccc style=\"font:bold 14pt \">".$value.$inyear."ѧ��γ̱�</td>
    </tr>
  <tr>
    <td width=\"10%\" height=\"20\" align=\"center\" valign=\"middle\" class=tr_head>����</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>����һ</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>���ڶ�</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>������</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>������</td>
    <td  width=18% align=\"center\" valign=\"middle\" class=tr_head>������</td>
  </tr>
    <tr>
      <td height=\"20\" align=\"center\" valign=\"middle\" class=tr_head2>�ڴ�</td>
      <td  align=\"center\" valign=\"middle\" class=tr_head2>����/�༶</td>
    <td align=\"center\" valign=\"middle\" class=tr_head2>����/�༶</td>
    <td  align=\"center\" valign=\"middle\" class=tr_head2>����/�༶</td>  
    <td align=\"center\" valign=\"middle\" class=tr_head2>����/�༶</td>
    <td  align=\"center\" valign=\"middle\" class=tr_head2>����/�༶</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >��һ��</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$classnum[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$classnum[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$classnum[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$classnum[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$classnum[5][1]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�ڶ���</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$classnum[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$classnum[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$classnum[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$classnum[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$classnum[5][2]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$classnum[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$classnum[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$classnum[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$classnum[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$classnum[5][3]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >���Ľ�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$classnum[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$classnum[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$classnum[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$classnum[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$classnum[5][4]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�����</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$classnum[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$classnum[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$classnum[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$classnum[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$classnum[5][5]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$classnum[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$classnum[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$classnum[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$classnum[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$classnum[5][6]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >���߽�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$classnum[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$classnum[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$classnum[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$classnum[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$classnum[5][7]."</td>
  </tr>
    <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�ڰ˽�</td>
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
		//-------------------���а༶�γ̱������word-----------------------------------------------------
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
			//���ò�ѯ����
			//$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
			//$select=$selectyear.$selectm;
			$showtablename=$inyear."ѧ��";
			//��Ӧ������ݶ�ȡ
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
        <td width=\"100%\"  valign=\"middle\" align=center height=24 colspan=6>������ѧ---".$classname.$showtablename."�γ̱�</td>
      </tr>
  <tr bgcolor=eeeeee>
    <td width=\"10%\" height=\"20\" align=\"center\" valign=\"middle\">����</td>
    <td  width=18% align=\"center\" valign=\"middle\" >����һ</td>
    <td  width=18% align=\"center\" valign=\"middle\" >���ڶ�</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
    <td  width=18% align=\"center\" valign=\"middle\" >������</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >��һ��</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][1]."/".$teacher[1][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][1]."/".$teacher[2][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][1]."/".$teacher[3][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][1]."/".$teacher[4][1]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][1]."/".$teacher[5][1]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�ڶ���</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][2]."/".$teacher[1][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][2]."/".$teacher[2][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][2]."/".$teacher[3][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][2]."/".$teacher[4][2]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][2]."/".$teacher[5][2]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][3]."/".$teacher[1][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][3]."/".$teacher[2][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][3]."/".$teacher[3][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][3]."/".$teacher[4][3]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][3]."/".$teacher[5][3]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >���Ľ�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][4]."/".$teacher[1][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][4]."/".$teacher[2][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][4]."/".$teacher[3][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][4]."/".$teacher[4][4]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][4]."/".$teacher[5][4]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�����</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][5]."/".$teacher[1][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][5]."/".$teacher[2][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][5]."/".$teacher[3][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][5]."/".$teacher[4][5]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][5]."/".$teacher[5][5]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >������</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][6]."/".$teacher[1][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][6]."/".$teacher[2][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][6]."/".$teacher[3][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][6]."/".$teacher[4][6]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][6]."/".$teacher[5][6]."</td>
  </tr>
  <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >���߽�</td>
    <td align=\"center\" valign=\"middle\" >".$name[1][7]."/".$teacher[1][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[2][7]."/".$teacher[2][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[3][7]."/".$teacher[3][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[4][7]."/".$teacher[4][7]."</td>
    <td align=\"center\" valign=\"middle\" >".$name[5][7]."/".$teacher[5][7]."</td>
  </tr>
    <tr>
    <td height=\"20\" align=\"center\" valign=\"middle\" >�ڰ˽�</td>
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
		//���ò�ѯ����
		//$selectyear=date("Y",mktime(0,0,0,1,1,$selectyear));
		//$select=$selectyear.$selectm;
		//���ð༶
		$buildyear=date("Y",mktime(0,0,0,1,1,substr($selectclass,0,2)));
		$buildclassid=substr($selectclass,-2);
		//��������
		$year=substr($select,0,4);
		$riqi=substr($select,-1);
		if ($riqi==1) {
			$year-=1;
			$classt=$year-$buildyear+3;
			$classname=$gradearr[$classt][$buildclassid-1];
			$showtablename=$year."��ڶ�ѧ��";
		}else {
			$classt=$year-$buildyear+4;
			$classname=$gradearr[$classt][$buildclassid-1];
			$showtablename=$year."���һѧ��";
		}
		//��Ӧ������ݶ�ȡ
		$query="select *
            from $table_classtable
            where inyear=$select and `class`='$selectclass'";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$name[$r[week]][$r[classnum]]=$r[classtitle];
			$teacher[$r[week]][$r[classnum]]=$r[teacher];
		}

		/***********************ҳ�����***********************************************/
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
   		alert("����������!");
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
        <td width="100%"  valign="middle" align=center height=32 class=style1>������ѧ---<?=$classname.$showtablename;?>�γ̱�</td>
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
    <td width="10%" height="28" align="center" valign="middle">����</td>
    <td  width=18% align="center" valign="middle" >����һ</td>
    <td  width=18% align="center" valign="middle" >���ڶ�</td>
    <td  width=18% align="center" valign="middle" >������</td>
    <td  width=18% align="center" valign="middle" >������</td>
    <td  width=18% align="center" valign="middle" >������</td>
  </tr>

  <tr>
    <td height="24" align="center" valign="middle" >��һ��</td>
    <td align="center" valign="middle" ><?=$name[1][1];?>/<?=$teacher[1][1];?></td>
    <td align="center" valign="middle" ><?=$name[2][1];?>/<?=$teacher[2][1];?></td>
    <td align="center" valign="middle" ><?=$name[3][1];?>/<?=$teacher[3][1];?></td>
    <td align="center" valign="middle" ><?=$name[4][1];?>/<?=$teacher[4][1];?></td>
    <td align="center" valign="middle" ><?=$name[5][1];?>/<?=$teacher[5][1];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >�ڶ���</td>
    <td align="center" valign="middle" ><?=$name[1][2];?>/<?=$teacher[1][2];?></td>
    <td align="center" valign="middle" ><?=$name[2][2];?>/<?=$teacher[2][2];?></td>
    <td align="center" valign="middle" ><?=$name[3][2];?>/<?=$teacher[3][2];?></td>
    <td align="center" valign="middle" ><?=$name[4][2];?>/<?=$teacher[4][2];?></td>
    <td align="center" valign="middle" ><?=$name[5][2];?>/<?=$teacher[5][2];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >������</td>
    <td align="center" valign="middle" ><?=$name[1][3];?>/<?=$teacher[1][3];?></td>
    <td align="center" valign="middle" ><?=$name[2][3];?>/<?=$teacher[2][3];?></td>
    <td align="center" valign="middle" ><?=$name[3][3];?>/<?=$teacher[3][3];?></td>
    <td align="center" valign="middle" ><?=$name[4][3];?>/<?=$teacher[4][3];?></td>
    <td align="center" valign="middle" ><?=$name[5][3];?>/<?=$teacher[5][3];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >���Ľ�</td>
    <td align="center" valign="middle" ><?=$name[1][4];?>/<?=$teacher[1][4];?></td>
    <td align="center" valign="middle" ><?=$name[2][4];?>/<?=$teacher[2][4];?></td>
    <td align="center" valign="middle" ><?=$name[3][4];?>/<?=$teacher[3][4];?></td>
    <td align="center" valign="middle" ><?=$name[4][4];?>/<?=$teacher[4][4];?></td>
    <td align="center" valign="middle" ><?=$name[5][4];?>/<?=$teacher[5][4];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >�����</td>
    <td align="center" valign="middle" ><?=$name[1][5];?>/<?=$teacher[1][5];?></td>
    <td align="center" valign="middle" ><?=$name[2][5];?>/<?=$teacher[2][5];?></td>
    <td align="center" valign="middle" ><?=$name[3][5];?>/<?=$teacher[3][5];?></td>
    <td align="center" valign="middle" ><?=$name[4][5];?>/<?=$teacher[4][5];?></td>
    <td align="center" valign="middle" ><?=$name[5][5];?>/<?=$teacher[5][5];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >������</td>
    <td align="center" valign="middle" ><?=$name[1][6];?>/<?=$teacher[1][6];?></td>
    <td align="center" valign="middle" ><?=$name[2][6];?>/<?=$teacher[2][6];?></td>
    <td align="center" valign="middle" ><?=$name[3][6];?>/<?=$teacher[3][6];?></td>
    <td align="center" valign="middle" ><?=$name[4][6];?>/<?=$teacher[4][6];?></td>
    <td align="center" valign="middle" ><?=$name[5][6];?>/<?=$teacher[5][6];?></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" >���߽�</td>
    <td align="center" valign="middle" ><?=$name[1][7];?>/<?=$teacher[1][7];?></td>
    <td align="center" valign="middle" ><?=$name[2][7];?>/<?=$teacher[2][7];?></td>
    <td align="center" valign="middle" ><?=$name[3][7];?>/<?=$teacher[3][7];?></td>
    <td align="center" valign="middle" ><?=$name[4][7];?>/<?=$teacher[4][7];?></td>
    <td align="center" valign="middle" ><?=$name[5][7];?>/<?=$teacher[5][7];?></td>
  </tr>
    <tr>
    <td height="24" align="center" valign="middle" >�ڰ˽�</td>
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
<input type="button" name="aa" onclick="preview()" value=��ʼ��ӡ>
<input type=button value=ҳ������ onclick="document.all.WebBrowser.ExecWB(8,1)" class="NOPRINT">
<input type=button value=��ӡԤ�� onclick="document.all.WebBrowser.ExecWB(7,1)" class="NOPRINT">
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
			echo '<script>alert("���Ĳ������Ϸ����ѱ���������¼��");</script>';
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