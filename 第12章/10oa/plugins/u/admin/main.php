<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

//---------------------------------------------�鿴�Ƿ�ͨ����U�̹���,û��������ͨ--------------
$query="select * from $table_folder where userid=$user_id limit 1";
$result=$db->query($query);
if($db->num_rows($result)==0){
	//---------------------------------------------���û������ʾ�Ƿ�ͨ��ҳ��-------------------
	$tpl->assign(array('user_name'=>$user_name,'user_id'=>$user_id,'u_size'=>$u_size));
	$tpl->assign('action','new');
}else{
	//---------------------------------------------�Ѿ���ͨ�˵�����U�̿ռ�------------------------
	//----------------------------------------------��ȡ��ǰ�û�������Ӳ����Ϣ--------------------
	if (empty($id)) {
		//���������idֵ����Ϊ��Ŀ¼����ȡ��Ŀ¼����Ϣ
		$uid=0;
		$sql="SELECT * FROM $table_folder where uid=$uid and userid=$user_id limit 1;";
		$r=$db->query_first($sql);
		$id=$r[id];
		$layerid=1;
	}else {
		//����idֵ����Ϊ��ȡ��ǰ�ļ��е���Ϣ
		$sql="SELECT * FROM $table_folder where id=$id and userid=$user_id limit 1;";
		$r=$db->query_first($sql);
		$uid=$r[uid];
		$layerid=$r[layerid];
	}
	//��ȡ��ǰĿ¼���ļ���
	$sql="SELECT * FROM $table_folder where uid=$id and userid=$user_id;";
	$result=$db->query($sql);
	while($r=$db->fetch_array($result)){
		$cid=$r[id];
		$foldername=$r[foldername];
		$addtime=date("Y-n-d H:i:s",$r[addtime]);
		$content[]=array('cid'=>$cid,'foldername'=>$foldername,'addtime'=>$addtime,'id'=>$id);
	}
	$tpl->assign('content',$content);
	//��ȡ��ǰĿ¼�µ��ļ�
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
	//�û�Ӳ��ʹ�õ�����ֵ
	$dir="./".$uppath.$user_name;
	$dirsize=dirsize($dir);
	$dirsize=sizecount($dirsize);
	//��������
	$tpl->assign(array('id'=>$id,'uid'=>$uid,'layerid'=>$layerid,'dirsize'=>$dirsize,'u_size'=>$u_size));
	//��ʾҳ��
	$tpl->assign('action','list');
}
$tpl->assign('style',$style);
$tpl->display('main.html');
?>