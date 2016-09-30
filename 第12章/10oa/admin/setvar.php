<?php
/*
凤鸣山中小学网络办公室
*/
switch ($action) {
	case "setvar":
		$dir=opendir("./templates");
		while($templatedir=readdir($dir)){
			if(is_dir("./templates/".$templatedir) && $templatedir!='.' && $templatedir!='..'){
				if($templatedir==$style)
				$liststyle.= "<option value='$templatedir' selected>$templatedir</option>";
				else
				$liststyle.= "<option value='$templatedir'>$templatedir</option>";
			}
		}
		$data=array("sitename"=>$sitename,"siteurl"=>$siteurl,"sitemaster"=>$sitemaster,"sitetitle"=>$sitetitle,
		"sitedescription"=>$sitedescription,"sitekeywords"=>$sitekeywords,"rootpath"=>$rootpath,"newstyle"=>$liststyle,
		"perpage"=>$perpage,"register_key"=>$register_key,"school_type"=>$school_type,"school_name"=>$school_name,
		"uppath"=>$uppath,"max_file_size"=>$MAX_FILE_SIZE,"pagenavpages"=>$pagenavpages,"uptypes"=>$uptypes,
		"strnum"=>$strnum,"showtime"=>$showtime,"force_html"=>$force_html,"port"=>$port,"ftp_ip"=>$ftp_ip
		);
		$tpl->assign($data);
		break;
	case "setindex":
		//栏目数据读取
		$query="select * from $table_type order by `path`,`tid`";
		$result=$db->query($query);
		while($r=$db->fetch_array($result)){
			$type[$r[uid]][]=$r[id];
			$totaltype[$r[id]]=array($r[id],$r[uid],$r[cid],$r[path],$r[layerid],$r[typename],$r[tid],$r[isshow],$r[enablecontribute],$r[templatetitle],$r[actionurl],$r[typepic]);
			if ($r[layerid]==1) $toolbar[]=$r[id];
		};
		show_type_select(0,1);
		$tpl->assign("type_select",$type_select);
		$tpl->assign(array("outtypeids"=>$outtypeids,"class_subject_arr"=>$class_subject_arr,"includepic_arr"=>$includepic_arr));
		break;
}
$tpl->assign('style',$style);
$tpl->assign('action',$action);
$tpl->display('setvar.html');
?>