<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
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

			showmessage("ϵͳ���óɹ����뷵�أ�","?filename=setvar");
		}else
		showmessage("ϵͳ����ʧ�ܣ����� ./config.php �ļ��Ƿ��д��");
		fclose($fp);
		break;
		//ѧ����Ϣ�ļ��ϴ�
	case 'upfile':
		if($up)
		{
			$error="ok";
			if(empty($upfile)){
				$error="�Բ���û���ϴ��ļ���";
			}
			if($upfile_size==0){
				$error="�Բ����ϴ��ļ����ֽ���Ϊ0��";
			}
			if(!is_uploaded_file($upfile)){
				$error="�Բ����ļ��ϴ�ʧ�ܣ�";
			}
			if($upfile_size>$MAX_FILE_SIZE){
				$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
				$error="�Բ������ϴ����ļ����ó���$MAX_FILE_SIZE k��";
			}
			$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
			if($type=file_type($upfile_name,$notuptypes)){
				$error="�Բ����벻Ҫ�ϴ�".$type."��ʽ���ļ���";
			}
			//���ļ��е�.phpȥ��
			$newname=ereg_replace(".php","php",$upfile_name);
			if($error=="ok")
			{

				createdir($updir);
				if(copy($upfile,$updir.$newname))
				{
					$error="ѧ����Ϣ�ϴ��ɹ�";
				}
			}
			$showmg="�ϴ��ɹ�,���еڶ�������";
			showmessage($showmg, "index.php?filename=student&action=insert&fileid=$newname");
		}

		break;
		//ѧ����Ϣ��⴦��
	case 'studentadd':
		$referer="?filename=student&action=in";
		//����һֱ����ļ��ж�ȡѧ����Ϣ
		//ѧ����Ϣ����
		/*$student_datas=explode(",", $student_data);
		for ($i=0;$i<=sizeof($student_datas);$i++)
		$list_data[$student_datas[$i]]=1;
		//��ȡ�ļ���Ϣ����ʾ����
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
		//��������post�ж�ȡѧ����Ϣ

		$student_datas=explode(",", $student_data);
		for ($i=0;$i<sizeof($student_datas);$i++)
		{
			$out=explode("|", $student_datas[$i]);
			//����Ƿ��ظ�������
			$query="select id from `$table_student` where stnumber='$out[0]' limit 1";
			$result=$db->query($query);
			if($db->num_rows($result)!=1){
				//��������ͳ�ʼ������
				$oldpasswd=getcode(6,2);
				$passwd=addslashes($oldpasswd);
				$passwd=md5($passwd);
				//�������ڸ�ʽ
				switch($birthday_type){
					case '0':
						$date_t=explode(".",$out[3]);
						$out[3]=mktime(0,0,0,$date_t[1],1,$date_t[0]);
						break;
					case '1':
						$date_t=explode("��",$out[3]);
						$date_tt=explode("��",$date_t[1]);
						$out[3]=mktime(0,0,0,$date_tt[0],1,$date_t[0]);
						break;
					case '2':
						$date_t=explode("/",$out[3]);
						$out[3]=mktime(0,0,0,$date_t[1],1,$date_t[0]);
						break;
				}
				//����classid
				$classid=substr($out[0],0,6);
				$query="INSERT INTO `$table_student` ( `id` , `$list_type[0]` , `$list_type[1]` , `$list_type[2]` , `$list_type[3]` , `$list_type[4]` , `$list_type[5]` , `$list_type[6]` , `$list_type[7]` , `$list_type[8]` , `$list_type[9]` , `$list_type[10]` , `$list_type[11]` , `$list_type[12]` , `$list_type[13]` , `passwd` , `oldpasswd`,`classid`)
                           VALUES (
                                      '', '".$out[0]."', '".$out[1]."', '".$out[2]."', '".$out[3]."', '".$out[4]."', '".$out[5]."', '".$out[6]."', '".$out[7]."', '".$out[8]."', '".$out[9]."', '".$out[10]."', '".$out[11]."', '".$out[12]."', '".$out[13]."', '$passwd', '$oldpasswd','$classid'
                                  );";

				$db->query($query);
			}
		}
		showmessage("ѧ����Ϣ��⴦��ɹ���",$referer);
		break;
		//�ϴ��ɼ���������
	case 'upresult':
		if($up)
		{
			$error="ok";
			if(empty($upfile)){
				$error="�Բ���û���ϴ��ļ���";
			}
			if($upfile_size==0){
				$error="�Բ����ϴ��ļ����ֽ���Ϊ0��";
			}
			if(!is_uploaded_file($upfile)){
				$error="�Բ����ļ��ϴ�ʧ�ܣ�";
			}
			if($upfile_size>$MAX_FILE_SIZE){
				$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
				$error="�Բ������ϴ����ļ����ó���$MAX_FILE_SIZE k��";
			}
			$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
			if($type=file_type($upfile_name,$notuptypes)){
				$error="�Բ����벻Ҫ�ϴ�".$type."��ʽ���ļ���";
			}
			if(!eregi(".csv",$upfile_name)) $error="�Բ�����ֻ���ϴ�excel�е�csv��ʽ���ļ���";
			//echo $upfile_name;
			//exit;
			//���ļ��е�.phpȥ��
			$newname=ereg_replace(".php","php",$upfile_name);
			if($error=="ok")
			{
				createdir("./".$uptemp);
				if(copy($upfile,$uptemp.$newname))
				{
					$error="ѧ���ɼ�";
				}
				$showmg=$error."�ϴ��ɹ�,���еڶ�������";
			showmessage($showmg, "index.php?filename=result&action=insert&fileid=$newname");
			}
			$showmg=$error."�ϴ�ʧ��,�����ϴ�";
			showmessage($showmg, "index.php?filename=result&action=up");
		}

		break;
		//ѧ���ɼ������
	case 'resultadd':
		$referer="?filename=result&action=list";
        $state=0;
		//�����������
		$intime=time();
		$rtype="$total_type[0]:$total_type[1]:$total_type[2]:$total_type[3]:$total_type[4]:$total_type[5]";
		$query="INSERT INTO `$table_resultset` (`id`,`title`,`gradeid`,`rtype`,`intime`,`userid`,`state`)
                          VALUES ('','$result_title','$gradeid:$gradecid','$rtype','$intime',$user_id,$state
                          );";
		$db->query($query);
		$resultid=$db->insert_id();

		//��������post�ж�ȡѧ���ɼ���Ϣ
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
		showmessage("ѧ���ɼ�����ɹ���",$referer);
		break;
		//ѧ���ɼ��޸�
	case 'resultedit':
		//ͳ���ܷ�
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
		//�޸ĸ������������
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
		//������Ϣ
	case 'messagenew':
		$referer="?filename=message&action=new";
		$sendtime=time();
		if ($classtotal==$total)
		{//Ⱥ��
			$type=2;
			$query="INSERT INTO `$table_message` ( `id` , `send` , `receive` , `sendtime` ,`content`, `type` , `state`)
                                VALUES (
                                          '','$class_id','$class_id','$sendtime','$content','$type','0' 
                                           );";
			$db->query($query);
		}else {
			//������
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
		showmessage("��Ϣ���ͳɹ�",$referer);
		break;
	case 'classadd':
		$referer="?filename=class&action=list";
		//ʱ�����
		$styear=substr($styear+3,2);
		$noyear=time();
		for ($i=$stclassnumb;$i<=$endclassnumb;$i++){
			//���ò���
			if ($i<10) $classid="0".$i;
			else   $classid=$i;
			$classid=$styear.$schoolnumb.$classid;
			//����Ƿ��ظ�����������
			$query="select id from $table_class where `classid`='$classid' limit 1";
			$result=$db->query($query);
			if($db->num_rows($result)!=0){
				showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
			}
			//��������
			$query="INSERT INTO `$table_class` ( `id` , `classid` , `buildtime`)
                       VALUES ('', '$classid', '$noyear');"; 
			$db->query($query);
		}
		$db->close();
		showmessage("�༶��ӳɹ���",$referer);
		break;
	case 'classaddone':
		$referer="?filename=student&action=list";
		//ʱ�����
		$noyear=time();
		//��������
		$query="INSERT INTO `$table_class` ( `id` , `classid` , `buildtime`)
                       VALUES ('', '$classid', '$noyear');"; 
		$db->query($query);
		$db->close();
		showmessage("�༶��ӳɹ���",$referer);
		break;
}