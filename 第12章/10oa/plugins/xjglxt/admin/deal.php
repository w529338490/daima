<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

switch($action){
	case 'setvar':

		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]rootpath\s*\=\s*[\"'].*?[\"']/is", "\$rootpath = '$newrootpath'", $configfile);
		$configfile = preg_replace("/[$]style\s*\=\s*[\"'].*?[\"']/is", "\$style = '$newstyle'", $configfile);
		$configfile = preg_replace("/[$]sitename\s*\=\s*[\"'].*?[\"']/is", "\$sitename = '$newsitename'", $configfile);
		$configfile = preg_replace("/[$]siteurl\s*\=\s*[\"'].*?[\"']/is", "\$siteurl = '$newsiteurl'", $configfile);
		$configfile = preg_replace("/[$]sitemaster\s*\=\s*[\"'].*?[\"']/is", "\$sitemaster = '$newsitemaster'", $configfile);
		$configfile = preg_replace("/[$]sitetitle\s*\=\s*[\"'].*?[\"']/is", "\$sitetitle = '$newsitetitle'", $configfile);
		$configfile = preg_replace("/[$]sitedescription\s*\=\s*[\"'].*?[\"']/is", "\$sitedescription = '$newsitedescription'", $configfile);
		$configfile = preg_replace("/[$]sitekeywords\s*\=\s*[\"'].*?[\"']/is", "\$sitekeywords = '$newsitekeywords'", $configfile);
		$configfile = preg_replace("/[$]perpage\s*\=\s*[\"'].*?[\"']/is", "\$perpage = '$newperpage'", $configfile);
		$configfile = preg_replace("/[$]contribute\s*\=\s*[\"'].*?[\"']/is", "\$contribute = '$newcontribute'", $configfile);

		$fp = fopen('./config.php', 'w');
		if(@fwrite($fp, trim($configfile))){

			showmessage("系统设置成功！请返回！","?filename=setvar");
		}else
		showmessage("系统设置失败！请检查 ./config.php 文件是否可写！");
		fclose($fp);
		break;
		//学生信息文件上传
	case 'upfile':
		if($up)
		{
			$error="ok";
			if(empty($upfile)){
				$error="对不起，没有上传文件！";
			}
			if($upfile_size==0){
				$error="对不起，上传文件的字节数为0！";
			}
			if(!is_uploaded_file($upfile)){
				$error="对不起，文件上传失败！";
			}
			if($upfile_size>$MAX_FILE_SIZE){
				$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
				$error="对不起，你上传的文件不得超过$MAX_FILE_SIZE k！";
			}
			$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
			if($type=file_type($upfile_name,$notuptypes)){
				$error="对不起，请不要上传".$type."格式的文件！";
			}
			//把文件中的.php去掉
			$newname=ereg_replace(".php","php",$upfile_name);
			if($error=="ok")
			{

				createdir($updir);
				if(copy($upfile,$updir.$newname))
				{
					$error="学生信息上传成功";
				}
			}
			$showmg="上传成功,进行第二步操作";
			showmessage($showmg, "index.php?filename=student&action=insert&fileid=$newname");
		}

		break;
		//学生信息入库处理
	case 'studentadd':
		$referer="?filename=student&action=in";
		//方法一直间从文件中读取学生信息
		//学生信息条数
		/*$student_datas=explode(",", $student_data);
		for ($i=0;$i<=sizeof($student_datas);$i++)
		$list_data[$student_datas[$i]]=1;
		//读取文件信息并显示出来
		require("./include/file_class.php");
		$filepath="./data/$fileid";
		// set fl
		$fl = new File_class;
		$fl->file=$filepath;
		$h=$fl->getlines();
		$line=$fl->read_file();
		for ($i=0;$i<$h;$i++){
		if ($list_data[$i]==1){
		$out=explode("|", $line[$i]);
		$student_data=$i;
		$query.="
		INSERT INTO `x_student` ( `id` , `$list_type[0]` , `$list_type[1]` , `$list_type[2]` , `$list_type[3]` , `$list_type[4]` , `$list_type[5]` , `$list_type[6]` , `$list_type[7]` , `$list_type[8]` , `$list_type[9]` , `$list_type[10]` , `$list_type[11]` , `$list_type[12]` , `$list_type[13]` , `passwd` , `oldpasswd`)
		VALUES (
		'', '".trim($out[0])."', '".trim($out[1])."', '".trim($out[2])."', '".trim($out[3])."', '".trim($out[4])."', '".trim($out[5])."', '".trim($out[6])."', '".trim($out[7])."', '".trim($out[8])."', '".trim($out[9])."', '".trim($out[10])."', '".trim($out[11])."', '".trim($out[12])."', '".trim($out[13])."', '$passwd', '$oldpasswd'
		);";
		//$student_data=trim($out[0])."|".trim($out[2])."|".trim($out[3])."|".trim($out[4])."|".trim($out[5])."|".trim($out[6])."|".trim($out[7])."|".trim($out[8])."|".trim($out[9])."|".trim($out[10])."|".trim($out[11])."|".trim($out[12])."|".trim($out[13]);

		}
		}
		*/
		//方法二从post中读取学生信息

		$student_datas=explode(",", $student_data);
		for ($i=0;$i<sizeof($student_datas);$i++)
		{
			$out=explode("|", $student_datas[$i]);
			//检测是否重复的数据
			$query="select id from `$table_student` where stnumber='$out[0]' limit 1";
			$result=$db->query($query);
			if($db->num_rows($result)!=1){
				//设置密码和初始化密码
				$oldpasswd=getcode(6,2);
				$passwd=addslashes($oldpasswd);
				$passwd=md5($passwd);
				//设置日期格式
				switch($birthday_type){
					case '0':
						$date_t=explode(".",$out[3]);
						$out[3]=mktime(0,0,0,$date_t[1],1,$date_t[0]);
						break;
					case '1':
						$date_t=explode("年",$out[3]);
						$date_tt=explode("月",$date_t[1]);
						$out[3]=mktime(0,0,0,$date_tt[0],1,$date_t[0]);
						break;
					case '2':
						$date_t=explode("/",$out[3]);
						$out[3]=mktime(0,0,0,$date_t[1],1,$date_t[0]);
						break;
				}
				//设置classid
				$classid=substr($out[0],0,6);
				$query="INSERT INTO `$table_student` ( `id` , `$list_type[0]` , `$list_type[1]` , `$list_type[2]` , `$list_type[3]` , `$list_type[4]` , `$list_type[5]` , `$list_type[6]` , `$list_type[7]` , `$list_type[8]` , `$list_type[9]` , `$list_type[10]` , `$list_type[11]` , `$list_type[12]` , `$list_type[13]` , `passwd` , `oldpasswd`,`classid`)
                           VALUES (
                                      '', '".$out[0]."', '".$out[1]."', '".$out[2]."', '".$out[3]."', '".$out[4]."', '".$out[5]."', '".$out[6]."', '".$out[7]."', '".$out[8]."', '".$out[9]."', '".$out[10]."', '".$out[11]."', '".$out[12]."', '".$out[13]."', '$passwd', '$oldpasswd','$classid'
                                  );";

				$db->query($query);
			}
		}
		showmessage("学生信息入库处理成功！",$referer);
		break;
		//上传成绩到附件中
	case 'upresult':
		if($up)
		{
			$error="ok";
			if(empty($upfile)){
				$error="对不起，没有上传文件！";
			}
			if($upfile_size==0){
				$error="对不起，上传文件的字节数为0！";
			}
			if(!is_uploaded_file($upfile)){
				$error="对不起，文件上传失败！";
			}
			if($upfile_size>$MAX_FILE_SIZE){
				$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
				$error="对不起，你上传的文件不得超过$MAX_FILE_SIZE k！";
			}
			$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
			if($type=file_type($upfile_name,$notuptypes)){
				$error="对不起，请不要上传".$type."格式的文件！";
			}
			if(!eregi(".csv",$upfile_name)) $error="对不起，你只能上传excel中的csv格式的文件！";
			//echo $upfile_name;
			//exit;
			//把文件中的.php去掉
			$newname=ereg_replace(".php","php",$upfile_name);
			if($error=="ok")
			{
				createdir("./".$uptemp);
				if(copy($upfile,$uptemp.$newname))
				{
					$error="学生成绩";
				}
				$showmg=$error."上传成功,进行第二步操作";
			showmessage($showmg, "index.php?filename=result&action=insert&fileid=$newname");
			}
			$showmg=$error."上传失败,重新上传";
			showmessage($showmg, "index.php?filename=result&action=up");
		}

		break;
		//学生成绩入表处理
	case 'resultadd':
		$referer="?filename=result&action=list";
        $state=0;
		//考试名称入表
		$intime=time();
		$rtype="$total_type[0]:$total_type[1]:$total_type[2]:$total_type[3]:$total_type[4]:$total_type[5]";
		$query="INSERT INTO `$table_resultset` (`id`,`title`,`gradeid`,`rtype`,`intime`,`userid`,`state`)
                          VALUES ('','$result_title','$gradeid:$gradecid','$rtype','$intime',$user_id,$state
                          );";
		$db->query($query);
		$resultid=$db->insert_id();

		//方法二从post中读取学生成绩信息
		$result_datas=explode(",", $result_data);
		for ($i=0;$i<sizeof($result_datas);$i++)
		{
			$out=explode("|", $result_datas[$i]);
			$cjsum=$out[2]+$out[3]+$out[4]+$out[5]+$out[6]+$out[7];
			$query="INSERT INTO `$table_result` (`stname`,`$list_type[0]` , `$list_type[2]` , `$list_type[3]` , `$list_type[4]` , `$list_type[5]` , `$list_type[6]` , `$list_type[7]`  ,`cjsum`, `resultid`)
                                VALUES (
                                          '".$out[1]."', '".$out[0]."' , '".$out[2]."', '".$out[3]."', '".$out[4]."', '".$out[5]."', '".$out[6]."', '".$out[7]."','$cjsum','$resultid'
                                       );";
			$db->query($query);
		}

		$db->close();
		showmessage("学生成绩输入成功！",$referer);
		break;
		//学生成绩修改
	case 'resultedit':
		//统计总分
		$cjsum=$yw+$sx+$wy+$kx+$sz+$ls;
		$query="UPDATE `$table_result` SET `yw`='$yw',
                                   `sx`='$sx',
                                   `wy`='$wy', 
                                   `kx`='$kx',
                                   `sz`='$sz',
                                   `ls`='$ls',
                                   `cjsum`='$cjsum'
                                    WHERE `id` = '$id' LIMIT 1 ;";
		$result=$db->query($query);
		//修改父级表格中内容
		echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[4].innerHTML=  \"<font color=red>$yw</font>\";
            tbl.cells[5].innerHTML=  \"<font color=red>$sx</font>\";             
            tbl.cells[6].innerHTML=  \"<font color=red>$wy</font>\";
            tbl.cells[7].innerHTML=  \"<font color=red>$kx</font>\";
            tbl.cells[8].innerHTML=  \"<font color=red>$sz</font>\";
            tbl.cells[9].innerHTML=  \"<font color=red>$ls</font>\";
            tbl.cells[10].innerHTML=  \"<font color=red>$cjsum</font>\";
             window.close();
     </script>
";
		break;
		//发布信息
	case 'messagenew':
		$referer="?filename=message&action=new";
		$sendtime=time();
		if ($classtotal==$total)
		{//群发
			$type=2;
			$query="INSERT INTO `$table_message` ( `id` , `send` , `receive` , `sendtime` ,`content`, `type` , `state`)
                                VALUES (
                                          '','$class_id','$class_id','$sendtime','$content','$type','0' 
                                           );";
			$db->query($query);
		}else {
			//个别发送
			$type=3;
			$student=explode(",",$student_data);
			for ($i=0;$i<sizeof($student);$i++)
			{
				$receive=$student[$i];
				$query="INSERT INTO `$table_message` ( `id` , `send` , `receive` , `sendtime` ,`content`, `type` , `state`)
                                VALUES (
                                          '','$class_id','$receive','$sendtime','$content','$type','0' 
                                           );";
				$db->query($query);
			}
		}
		$db->close();
		showmessage("信息发送成功",$referer);
		break;
	case 'classadd':
		$referer="?filename=class&action=list";
		//时间参数
		$styear=substr($styear+3,2);
		$noyear=time();
		for ($i=$stclassnumb;$i<=$endclassnumb;$i++){
			//设置参数
			if ($i<10) $classid="0".$i;
			else   $classid=$i;
			$classid=$styear.$schoolnumb.$classid;
			//检测是否重复其他的数据
			$query="select id from $table_class where `classid`='$classid' limit 1";
			$result=$db->query($query);
			if($db->num_rows($result)!=0){
				showmessage("对不起，已经有相同的记录",$referer);
			}
			//插入数据
			$query="INSERT INTO `$table_class` ( `id` , `classid` , `buildtime`)
                       VALUES ('', '$classid', '$noyear');"; 
			$db->query($query);
		}
		$db->close();
		showmessage("班级添加成功！",$referer);
		break;
	case 'classaddone':
		$referer="?filename=student&action=list";
		//时间参数
		$noyear=time();
		//插入数据
		$query="INSERT INTO `$table_class` ( `id` , `classid` , `buildtime`)
                       VALUES ('', '$classid', '$noyear');"; 
		$db->query($query);
		$db->close();
		showmessage("班级添加成功！",$referer);
		break;
}