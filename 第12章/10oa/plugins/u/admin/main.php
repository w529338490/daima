<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//---------------------------------------------查看是否开通网络U盘功能,没有则请求开通--------------
$query="select * from $table_folder where userid=$user_id limit 1";
$result=$db->query($query);
if($db->num_rows($result)==0){
	//---------------------------------------------如果没有则显示是否开通的页面-------------------
	$tpl->assign(array('user_name'=>$user_name,'user_id'=>$user_id,'u_size'=>$u_size));
	$tpl->assign('action','new');
}else{
	//---------------------------------------------已经开通了的网络U盘空间------------------------
	//----------------------------------------------读取当前用户的网络硬盘信息--------------------
	if (empty($id)) {
		//如果不存在id值，则为根目录，读取根目录的信息
		$uid=0;
		$sql="SELECT * FROM $table_folder where uid=$uid and userid=$user_id limit 1;";
		$r=$db->query_first($sql);
		$id=$r[id];
		$layerid=1;
	}else {
		//存在id值，则为读取当前文件夹的信息
		$sql="SELECT * FROM $table_folder where id=$id and userid=$user_id limit 1;";
		$r=$db->query_first($sql);
		$uid=$r[uid];
		$layerid=$r[layerid];
	}
	//读取当前目录子文件夹
	$sql="SELECT * FROM $table_folder where uid=$id and userid=$user_id;";
	$result=$db->query($sql);
	while($r=$db->fetch_array($result)){
		$cid=$r[id];
		$foldername=$r[foldername];
		$addtime=date("Y-n-d H:i:s",$r[addtime]);
		$content[]=array('cid'=>$cid,'foldername'=>$foldername,'addtime'=>$addtime,'id'=>$id);
	}
	$tpl->assign('content',$content);
	//读取当前目录下的文件
	$sql="SELECT * FROM $table_file where uid=$id and userid=$user_id;";
	$result=$db->query($sql);
	while($r=$db->fetch_array($result)){
		$cid=$r[id];
		$filename=$r[filename];
		$addtime=date("Y-n-d H:i:s",$r[addtime]);
		$file_size=$r[size];
		$extend=$r[extend];
		if(!in_array($extend,$uptypes))$extend="unknown";
			$content2[]=array('cid'=>$cid,'filename'=>$filename,'addtime'=>$addtime,'id'=>$id,'extend'=>$extend,'file_size'=>$file_size);
	}
	$tpl->assign('content2',$content2);
	//用户硬盘使用的容量值
	$dir="./".$uppath.$user_name;
	$dirsize=dirsize($dir);
	$dirsize=sizecount($dirsize);
	//其他数据
	$tpl->assign(array('id'=>$id,'uid'=>$uid,'layerid'=>$layerid,'dirsize'=>$dirsize,'u_size'=>$u_size));
	//显示页面
	$tpl->assign('action','list');
}
$tpl->assign('style',$style);
$tpl->display('main.html');
?>