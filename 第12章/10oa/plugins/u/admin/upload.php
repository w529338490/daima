<?
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
if ($do!=1){
	$tpl->assign(array('id'=>$id));
	$tpl->assign('style',$style);
	$tpl->display('upload.html');
}else{
	//����ֹͣ����2��
	sleep( 2 );
	//����Ƿ���ͬ���ļ���������ͬ���ļ�������ִֹͣ��
	$sql="select count(*) AS ct from $table_file where userid=$user_id and uid=$uid and `filename`='$userfile_name';";
	$r=$db->query_first($sql);
	if ($r[ct]>0){
		echo "<script>parent.document.getElementById('msg').innerHTML = '$user_name������ͬ���ļ�';</script> "   ;
		exit;
	}
	//�ϴ��ļ�
	$error=1;
	if(empty($userfile)){
		$error="�Բ���û���ϴ��ļ���";
	}
	if($userfile_size==0){
		$error="�Բ����ϴ��ļ����ֽ���Ϊ0��";
	}
	if(!is_uploaded_file($userfile)){
		$error="�Բ��𣬷Ƿ��ϴ����ļ��ϴ�ʧ�ܣ�";
	}
	if($userfile_size>$MAX_FILE_SIZE){
		$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
		$error="�Բ������ϴ����ļ����ó���$MAX_FILE_SIZE k��";
	}
	//���ñ���·��
	$dir=$uppath.$user_name;
	//��ȡĿ¼�Ĵ�������
	$dirsize=dirsize($dir);
	$left_size=$u_size*1024*1024-$dirsize;
	if($userfile_size>$left_size){
		//��ʽ����������
		$dirsize=sizecount($dirsize);
		$error="�Բ�����Ŀռ������Ѿ�����$dirsize ,�ռ伴�����꣬��ɾ�������ļ��Ժ����ϴ���";
	}
	//���ò��ܱ��ϴ����ļ����ͣ����ж�
	$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll|.htm|.html';
	if($type=file_type($userfile_name,$notuptypes)){
		$error="�Բ����벻Ҫ�ϴ�".$type."��ʽ���ļ���";
	}
	//�ϴ������ϴ���������Ϣ�����ݿ⼰ҳ����
	if ($error==1){
		//��ȡ��չ��
		$extend = pathinfo($userfile_name);
		$extend = strtolower($extend["extension"]);
		//��������
		$addtime=time();
		//��Ҫ��������
		if($renamed){
			list($usec, $sec) = explode(" ",microtime());
			$new_userfile_name=substr($usec,2).'.'.$extend;
			unset($usec);
			unset($sec);
		}else{
			$new_userfile_name=$userfile_name;
		}
		$newfile_path="$user_name/$new_userfile_name";
		$newfile=$uppath.$newfile_path;
		$newfile_size=sizecount($userfile_size);
		createdir($dir);
		if(copy($userfile,$newfile)){
			//���������ݿ�
			$query="INSERT INTO $table_file ( `filename`, `uid` ,`userid`, `size` , `path` ,`extend`, `addtime` )
                          VALUES ('$userfile_name','$uid' ,'$user_id', '$newfile_size', '$newfile_path','$extend', '$addtime')";
			$r=$db->query($query);
			$file_id=$db->insert_id();
			if(!eregi($extend,$uptypes)){$extend="unknown";};
			//��ʾ��ҳ������
   
			echo "<script>window.opener.document.getElementById('msg').innerHTML = '�ɹ�';
              var nowTable=window.opener.document.all.ftable;
              var col = nowTable.cells.length/nowTable.rows.length;
              var row = nowTable.rows.length;

              var newTr=nowTable.insertRow();
                  newTr.id=\"file$file_id\";
              var newTd=newTr.insertCell(0);
              var newTd1=newTr.insertCell(1);
              var newTd2=newTr.insertCell(2);
              var newTd3=newTr.insertCell(3);
              var newTd4=newTr.insertCell(4);

               newTd.innerHTML=\"<input type=checkbox id=checkLine name=checkLine value=$file_id>\";
               newTd1.innerHTML=\"<img src=./images/$extend.gif border=0  align=absmiddle alt='�ļ�'> <a href=?filename=down&uid=$uid&id=$file_id>$userfile_name</a>\";
               newTd2.innerHTML=\"$newfile_size\";
               newTd3.innerHTML=\"".date("Y-n-d h:i:s",$addtime)."\";
               newTd4.innerHTML=\"<a href=# onClick=del('ftable','file$file_id','file',$file_id)><img src=./images/del.gif border=0 alt=ɾ�� align=absmiddle></a> <a href=# onClick=cut('file',$file_id)><img src=./images/cut.gif border=0 alt=���� align=absmiddle></a> \"; 
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
			exit;
		}
		//�ļ��ϴ�ʧ��
	}else {
		echo "<script>window.opener.document.getElementById('msg').innerHTML = '$error';
             setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 6000);
            </script>";   
	}
}
?>