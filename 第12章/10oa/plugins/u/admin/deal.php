<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//�������ָ�ʽ
header("Content-type: text/html;charset=GB2312");
switch ($action){
	//---------------------------------���û���ͨ����Ӳ��
	case 'newdisk' :
		//���ļ��б����¿�һ��Ŀ¼Ϊ���û��ĸ�Ŀ¼
		$sql="INSERT INTO $table_folder ( `foldername` , `layerid` , `uid` , `isshare` , `password` , `userid`)
	                    values ('$user_name','1','0','0','','$user_id');";
		$db->query($sql);
		//�½���Ŀ¼
		createdir("$uppath/$user_name");
		$referer="?filename=main";
		showmessage("ͨ����U�̿�ͨ�ɹ���",$referer);
		break;
		//------------------------------�����ļ���
	case 'creatfolder' :
		//��ȡ�ļ�������
		$foldername=$_COOKIE[foldername];
		setcookie ("foldername", "", time()-3600);
		//����Ƿ�����ͬ��ͬһ�ļ��д���
		$sql="select count(*) AS ct from $table_folder where uid=$uid and userid=$user_id and `foldername`='$foldername';";
		$r=$db->query_first($sql);
		if ($r[ct]<1){
			//û����ͬ�ļ��д���
			$layerid=$layerid+1;
			$addtime=time();
			//�½��ļ���
			$sql="INSERT INTO $table_folder (  `foldername` , `layerid` , `uid` , `isshare` , `password` , `userid`,`addtime` )
                        VALUES ('$foldername','$layerid','$uid','0','','$user_id',$addtime);";
			$db->query($sql);
			$id=$db->insert_id();
			$sql="UPDATE $table_folder SET `cid` = '|$id|' WHERE `id` =$id LIMIT 1 ;";
			$db->query($sql);
			//���ӵ�ǰidֵ��������cid��
			$querycid="select id,cid from $table_folder where `cid` like '%|$uid|%'";
			$result=$db->query($querycid);
			while($r=$db->fetch_array($result)){
				$cid=$r[cid]."$id|";
				$queryupcid="UPDATE $table_folder SET `cid` = '$cid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$db->query($queryupcid);
			}
			//���� cookieֵ
			setcookie("tempid",$id);
			echo "�½��ļ��У�$foldername ->�����ɹ�!";
		}else {
			//����ʧ��
			setcookie("tempid",0);
			//���� cookieֵ
			echo "�½��ļ��У�$foldername ->ʧ�ܣ��Ѿ����ڣ�";
		};
		break;
	case 'delrow' :
		//ɾ���ļ�
		if ($type=="file"){
			//��ȡ������Ϣ������--��ȡ·��ɾ���ļ�
			$sql="SELECT * FROM $table_file where id=$id LIMIT 1 ";
			$r=$db->query_first($sql);
			$filepath=$uppath.$r[path];
			unlink($filepath);
			//ɾ�����ݿ��ļ�
			$sql="delete from $table_file where id=$id limit 1;";
			$db->query($sql);
		}else {
			//ɾ���ļ��в���
			$typeid=0;
			$sql="SELECT * FROM $table_folder where id=$id LIMIT 1 ";
			$r=$db->query_first($sql);
			//��ȡ���ļ���
			$oldcid=$r[cid];
			$cid=eregi_replace("\|",",",$r[cid]);
			$cid=substr($cid, 1, -1);
			//���þɸ����ı��������cid
			$sql="select id,cid from $table_folder where (`cid` like '%|$id|%') and id!=$id;";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result)){
				$newcid=$r[cid];
				$eregi=$oldcid;
				$eregicid=explode("|", $eregi);
				$endi=sizeof($eregicid);
				for ($i=1;$i<$endi-1;$i++){
					$newcid=eregi_replace("\|$eregicid[$i]\|","|",$newcid);
				}
				$queryupcid="UPDATE $table_folder SET `cid` = '$newcid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$resultup=$db->query($queryupcid);
			}
			//��ȡ���ļ�����Ϣ������
			$sql="SELECT * FROM $table_folder where id in ($cid) and userid=$user_id";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$id=$r[id];
				//ɾ���ļ����ļ��б�
				$sql="delete from $table_folder where id=$id limit 1;";
				$db->query($sql);
			}
			//��ȡ���ļ���Ϣ������
			$typeid=1;
			$sql="SELECT * FROM $table_file where uid in ($cid) and userid=$user_id";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$id=$r[id];
				$filepath=$uppath.$r[path];
				unlink($filepath);
				//ɾ���ļ����ļ��б�
				$sql="delete from $table_file where id=$id limit 1;";
				$db->query($sql);
			}
		};
		echo "ɾ���ɹ�";
		break;
	case 'paste':
		$addtime=time();
		//��ȡcookie[pasteid]���ָ�ŵ�������
		$r_pasterid=$_COOKIE[pasteid];
		if($r_pasterid==""){
			$pasteid="file|0|0";
			setcookie("pasteid",$pasteid);
		}
		$r_pasterids=explode("|",$r_pasterid);
		//�ж��Ƿ�Ϊ�ļ���Ϊ�ļ���
		if ($r_pasterids[0]=="file") {
			//���ļ�����
			if ($r_pasterids[2]=="cut"){
				//�ļ����в���
				//��ȡ�ļ�����
				$sql="SELECT * FROM $table_file where id=$r_pasterids[1] LIMIT 1;";
				$r=$db->query_first($sql);
				$outname=$r[filename];
				$size=$r[size];
				$extend=$r[extend];
				//�ж��Ƿ�ͬһ�ļ���������ͬ���ļ�
				$sql="select count(*) AS ct from $table_file where userid=$user_id and uid=$uid and `filename`='$outname';";
				$r=$db->query_first($sql);
				if ($r[ct]<1){
					//û����ͬ���ļ�
					$sql="UPDATE $table_file SET `uid` = '$uid',`addtime`='$addtime' WHERE `id` =$r_pasterids[1] LIMIT 1 ;";
					$db->query($sql);
					//���÷��ص���Ϣ��ҳ����
					if(!eregi("$extend",$uptypes)){$extend="unknown";};
					$pasteid="file|".$r_pasterids[1]."|".$extend."|".$r[size];
					setcookie("pasteid",$pasteid);
				}else {
					//����ͬ���ļ�����
					$pasteid="file|0|1";
					setcookie("pasteid",$pasteid);
				}
			}else {
				//���ļ����Ʋ���----------------------------�˹�����ʱ����
				$sql="select * from $table_file where id=$r_pasterids[1] limit 1;";
				$r=$db->query_first($sql);
				$oldpath="./$uppath$r[path]";
				$path="$login_name/$addtime$r[filename]";
				$newpath="./$uppath".$path;
				copy($oldpath,$newpath);
				$sql="INSERT INTO $table_file ( `filename` , `uid` , `userid` , `size` , `path` , `extend` , `addtime` )
                           VALUES ( '$r[filename]', '$uid', '$r[userid]', '$r[size]', '$path', '$r[extend]', '$addtime');";
				$db->query($sql);
				setcookie("pasteid",$id);
				setcookie("size",$r[size]);
				$outname=$r[filename];
				if(eregi("$r[extend]",$uptypes)){$extend=$r[extend];}else {$extend="unknown";};
				setcookie("extend",$extend);
			}
		}
		//���ļ��в���
		else if($r_pasterids[0]=="folder"){
			//���ļ��еļ��в���
			if ($r_pasterids[2]=="cut"){
				//�����ļ��м��в���
				$id=$r_pasterids[1];
				//��ȡ���ļ��е�����
				$sql="select * from $table_folder where id=$id limit 1;";
				$r=$db->query_first($sql);
				$oldcid=$r[cid];
				$oldlayerid=$r[layerid];
				$foldername=$r[foldername];
				//��ȡ���ļ��е�����
				$sql="select * from $table_folder where id=$uid limit 1;";
				$r=$db->query_first($sql);
				$ulayerid=$r[layerid];
				//�жϸ����Ƿ�����ͬ���ļ���
				$sql="select count(*) AS ct from $table_folder where `uid`=$uid and userid=$user_id and `foldername`='$foldername';";
				$r=$db->query_first($sql);
				if ($r[ct]<1) {
					//û����ͬ�ļ���
					//���ı��ļ��еĲ���
					$sql="UPDATE $table_folder SET `uid` = '$uid' WHERE `id` =$id LIMIT 1 ;";
					$db->query($sql);
					//���÷��ز���
					$outname=$foldername;
					$pasteid="folder|".$id."|0";
					setcookie("pasteid",$pasteid);
					//���þɸ����ı��������cid
					$sql="select id,cid from $table_folder where (`cid` like '%|$id|%') and id!=$id;";
					$result=$db->query($sql);
					while($r=$db->fetch_array($result)){
						$newcid=$r[cid];
						$eregi=$oldcid;
						$eregicid=explode("|", $eregi);
						$endi=sizeof($eregicid);
						for ($i=1;$i<$endi-1;$i++){
							$newcid=eregi_replace("\|$eregicid[$i]\|","|",$newcid);
						}
						$queryupcid="UPDATE $table_folder SET `cid` = '$newcid' WHERE `id` = '$r[id]' LIMIT 1 ;";
						$resultup=$db->query($queryupcid);
					}

					//�����¸����ı��������cid
					$sql="select * from $table_folder where (`cid` like '%|$uid|%')";
					$result=$db->query($sql);
					while($r=$db->fetch_array($result)){
						$subcid= substr($oldcid, 1);
						$addcid=$r[cid]."$subcid";
						$queryupcid="UPDATE $table_folder SET `cid` = '$addcid' WHERE `id` = '$r[id]' LIMIT 1 ;";
						$resultup=$db->query($queryupcid);
					}

					//�����Ӽ��ı��������layerid
					$ctcid=eregi_replace("\|",",",$oldcid);
					$ctcid=substr($ctcid, 1,-1);
					$sql="select * from $table_folder where id in ('$ctcid');";
					$result=$db->query($sql);
					while($r=$db->fetch_array($result)){
						$newlayerid=$r[layerid]-$oldlayerid+$ulayerid+1;
						$queryupcid="UPDATE $table_folder SET `layerid`='$newlayerid' WHERE `id` = '$r[id]' LIMIT 1 ;";
						$resultup=$db->query($queryupcid);
					}
				}
			}
			else{//�ļ��и��Ʋ���-------------------�˹�����ʱ����
			}
			//���ļ����д���
		}elseif ($r_pasterids[0]=="fileall"){
			if   ($r_pasterids[2]=="cut"){
				//���в���
				$fileids=explode(",",$r_pasterids[1]);
				$dd="";
				$size="";
				$j=0;
				for ($i=0;$i<sizeof($fileids);$i++){
					$sql="SELECT * FROM $table_file where id=$fileids[$i] LIMIT 1;";
					$rt=$db->query_first($sql);
					$sql="select count(*) AS ct from $table_file where userid=$user_id and uid=$uid and `filename`='$rt[filename]';";
					$r=$db->query_first($sql);
					if ($r[ct]<1){
						$sql="UPDATE $table_file SET `uid` = '$uid',`addtime`='$addtime' WHERE `id` =$fileids[$i] LIMIT 1 ;";
						$db->query($sql);
						$pasteids.=$dd.$fileids[$i];
						$outname.=$dd.$rt[filename];
						$size.=$dd.$rt[size];
						if(eregi("$rt[extend]",$uptypes)){
							$extend.=$dd.$rt[extend];
						}else { $extend.=$dd."unknown";
						};
						$dd=",";
						$j++;
					}
				}
				$pasteid="fileall|$pasteids|cut|$j|$extend|$size";
				setcookie("pasteid",$pasteid);
			}else{
				//���Ʋ���-------------------�˹�����ʱ����
				$fileids=explode(",",$r_pasterids[1]);
				$dd="";
				$size="";
				for ($i=0;$i<sizeof($fileids);$i++){
					//��ʼ�������ƹ���
					$sql="select * from $table_file where id=$fileids[$i] limit 1;";
					$r=$db->query_first($sql);
					$oldpath="./$uppath$r[path]";
					$path="$login_name/$addtime$r[filename]";
					$newpath="./$uppath".$path;
					copy($oldpath,$newpath);
					$sql="INSERT INTO $table_file (`id` , `filename` , `uid` , `userid` , `size` , `path` , `extend` , `addtime` )
                                           VALUES ('$id', '$r[filename]', '$uid', '$r[userid]', '$r[size]', '$path', '$r[extend]', '$addtime');";
					$db->query($sql);

					$outname.=$dd.$r[filename];
					if(eregi("$r[extend]",$uptypes)){
						$extend.=$dd.$r[extend];
					}else {
						$extend.=$dd."unknown";
					};
					$size.=$dd.$r[size];
					$newid.=$dd.$id;
					$dd=",";
				}
				setcookie("newid",$newid);
				setcookie("sizes",$size);
				setcookie("extend",$extend);
			}
		}
		//������Ӧ���ļ�����
		echo $outname;
		break;
		//�������
	case "downlist":
		$z = new PHPZip();
		$sql="select path from $table_file where id in ($downlistid);";
		$result=$db->query($sql);
		while($r=$db->fetch_array($result)){
			$files[].="./$uppath".$r[path];
		}
		createdir("./".$uptemp);
		$downurl="./".$uptemp."out2.zip";
		$z->Zip($files,$downurl);
		header ("Location:".$downurl);
		exit;
		break;
}
?>