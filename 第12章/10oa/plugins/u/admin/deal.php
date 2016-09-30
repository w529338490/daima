<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//设置文字格式
header("Content-type: text/html;charset=GB2312");
switch ($action){
	//---------------------------------新用户开通网络硬盘
	case 'newdisk' :
		//在文件夹表中新开一个目录为新用户的根目录
		$sql="INSERT INTO $table_folder ( `foldername` , `layerid` , `uid` , `isshare` , `password` , `userid`)
	                    values ('$user_name','1','0','0','','$user_id');";
		$db->query($sql);
		//新建根目录
		createdir("$uppath/$user_name");
		$referer="?filename=main";
		showmessage("通网络U盘开通成功！",$referer);
		break;
		//------------------------------建立文件夹
	case 'creatfolder' :
		//获取文件夹名称
		$foldername=$_COOKIE[foldername];
		setcookie ("foldername", "", time()-3600);
		//检查是否有相同的同一文件夹存在
		$sql="select count(*) AS ct from $table_folder where uid=$uid and userid=$user_id and `foldername`='$foldername';";
		$r=$db->query_first($sql);
		if ($r[ct]<1){
			//没有相同文件夹存在
			$layerid=$layerid+1;
			$addtime=time();
			//新建文件夹
			$sql="INSERT INTO $table_folder (  `foldername` , `layerid` , `uid` , `isshare` , `password` , `userid`,`addtime` )
                        VALUES ('$foldername','$layerid','$uid','0','','$user_id',$addtime);";
			$db->query($sql);
			$id=$db->insert_id();
			$sql="UPDATE $table_folder SET `cid` = '|$id|' WHERE `id` =$id LIMIT 1 ;";
			$db->query($sql);
			//增加当前id值到父级的cid中
			$querycid="select id,cid from $table_folder where `cid` like '%|$uid|%'";
			$result=$db->query($querycid);
			while($r=$db->fetch_array($result)){
				$cid=$r[cid]."$id|";
				$queryupcid="UPDATE $table_folder SET `cid` = '$cid' WHERE `id` = '$r[id]' LIMIT 1 ;";
				$db->query($queryupcid);
			}
			//设置 cookie值
			setcookie("tempid",$id);
			echo "新建文件夹：$foldername ->创建成功!";
		}else {
			//创建失败
			setcookie("tempid",0);
			//设置 cookie值
			echo "新建文件夹：$foldername ->失败（已经存在）";
		};
		break;
	case 'delrow' :
		//删除文件
		if ($type=="file"){
			//读取此条信息的数据--读取路径删除文件
			$sql="SELECT * FROM $table_file where id=$id LIMIT 1 ";
			$r=$db->query_first($sql);
			$filepath=$uppath.$r[path];
			unlink($filepath);
			//删除数据库文件
			$sql="delete from $table_file where id=$id limit 1;";
			$db->query($sql);
		}else {
			//删除文件夹操作
			$typeid=0;
			$sql="SELECT * FROM $table_folder where id=$id LIMIT 1 ";
			$r=$db->query_first($sql);
			//读取子文件夹
			$oldcid=$r[cid];
			$cid=eregi_replace("\|",",",$r[cid]);
			$cid=substr($cid, 1, -1);
			//设置旧父级的变更参数：cid
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
			//读取子文件夹信息并处理
			$sql="SELECT * FROM $table_folder where id in ($cid) and userid=$user_id";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$id=$r[id];
				//删除文件或文件夹表
				$sql="delete from $table_folder where id=$id limit 1;";
				$db->query($sql);
			}
			//读取子文件信息并处理
			$typeid=1;
			$sql="SELECT * FROM $table_file where uid in ($cid) and userid=$user_id";
			$result=$db->query($sql);
			while($r=$db->fetch_array($result))
			{
				$id=$r[id];
				$filepath=$uppath.$r[path];
				unlink($filepath);
				//删除文件或文件夹表
				$sql="delete from $table_file where id=$id limit 1;";
				$db->query($sql);
			}
		};
		echo "删除成功";
		break;
	case 'paste':
		$addtime=time();
		//获取cookie[pasteid]并分割放到数组中
		$r_pasterid=$_COOKIE[pasteid];
		if($r_pasterid==""){
			$pasteid="file|0|0";
			setcookie("pasteid",$pasteid);
		}
		$r_pasterids=explode("|",$r_pasterid);
		//判断是否为文件或为文件夹
		if ($r_pasterids[0]=="file") {
			//单文件操作
			if ($r_pasterids[2]=="cut"){
				//文件剪切操作
				//获取文件名称
				$sql="SELECT * FROM $table_file where id=$r_pasterids[1] LIMIT 1;";
				$r=$db->query_first($sql);
				$outname=$r[filename];
				$size=$r[size];
				$extend=$r[extend];
				//判定是否同一文件夹中有相同的文件
				$sql="select count(*) AS ct from $table_file where userid=$user_id and uid=$uid and `filename`='$outname';";
				$r=$db->query_first($sql);
				if ($r[ct]<1){
					//没有相同的文件
					$sql="UPDATE $table_file SET `uid` = '$uid',`addtime`='$addtime' WHERE `id` =$r_pasterids[1] LIMIT 1 ;";
					$db->query($sql);
					//设置返回的信息到页面中
					if(!eregi("$extend",$uptypes)){$extend="unknown";};
					$pasteid="file|".$r_pasterids[1]."|".$extend."|".$r[size];
					setcookie("pasteid",$pasteid);
				}else {
					//有相同的文件存在
					$pasteid="file|0|1";
					setcookie("pasteid",$pasteid);
				}
			}else {
				//单文件复制操作----------------------------此功能暂时不用
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
		//对文件夹操作
		else if($r_pasterids[0]=="folder"){
			//对文件夹的剪切操作
			if ($r_pasterids[2]=="cut"){
				//单个文件夹剪切操作
				$id=$r_pasterids[1];
				//读取此文件夹的属性
				$sql="select * from $table_folder where id=$id limit 1;";
				$r=$db->query_first($sql);
				$oldcid=$r[cid];
				$oldlayerid=$r[layerid];
				$foldername=$r[foldername];
				//读取父文件夹的属性
				$sql="select * from $table_folder where id=$uid limit 1;";
				$r=$db->query_first($sql);
				$ulayerid=$r[layerid];
				//判断父级是否有相同的文件夹
				$sql="select count(*) AS ct from $table_folder where `uid`=$uid and userid=$user_id and `foldername`='$foldername';";
				$r=$db->query_first($sql);
				if ($r[ct]<1) {
					//没有相同文件夹
					//更改本文件夹的参数
					$sql="UPDATE $table_folder SET `uid` = '$uid' WHERE `id` =$id LIMIT 1 ;";
					$db->query($sql);
					//设置返回参数
					$outname=$foldername;
					$pasteid="folder|".$id."|0";
					setcookie("pasteid",$pasteid);
					//设置旧父级的变更参数：cid
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

					//设置新父级的变更参数：cid
					$sql="select * from $table_folder where (`cid` like '%|$uid|%')";
					$result=$db->query($sql);
					while($r=$db->fetch_array($result)){
						$subcid= substr($oldcid, 1);
						$addcid=$r[cid]."$subcid";
						$queryupcid="UPDATE $table_folder SET `cid` = '$addcid' WHERE `id` = '$r[id]' LIMIT 1 ;";
						$resultup=$db->query($queryupcid);
					}

					//设置子级的变更参数：layerid
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
			else{//文件夹复制操作-------------------此功能暂时不用
			}
			//多文件剪切处理
		}elseif ($r_pasterids[0]=="fileall"){
			if   ($r_pasterids[2]=="cut"){
				//剪切操作
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
				//复制操作-------------------此功能暂时不用
				$fileids=explode(",",$r_pasterids[1]);
				$dd="";
				$size="";
				for ($i=0;$i<sizeof($fileids);$i++){
					//开始操作复制工作
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
		//返回相应的文件名称
		echo $outname;
		break;
		//打包下载
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