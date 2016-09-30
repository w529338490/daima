<?
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
if ($do!=1){
	$tpl->assign(array('id'=>$id));
	$tpl->assign('style',$style);
	$tpl->display('upload.html');
}else{
	//程序停止运行2秒
	sleep( 2 );
	//检测是否在同意文件夹中有相同的文件，有则停止执行
	$sql="select count(*) AS ct from $table_file where userid=$user_id and uid=$uid and `filename`='$userfile_name';";
	$r=$db->query_first($sql);
	if ($r[ct]>0){
		echo "<script>parent.document.getElementById('msg').innerHTML = '$user_name存在相同的文件';</script> "   ;
		exit;
	}
	//上传文件
	$error=1;
	if(empty($userfile)){
		$error="对不起，没有上传文件！";
	}
	if($userfile_size==0){
		$error="对不起，上传文件的字节数为0！";
	}
	if(!is_uploaded_file($userfile)){
		$error="对不起，非法上传，文件上传失败！";
	}
	if($userfile_size>$MAX_FILE_SIZE){
		$MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
		$error="对不起，你上传的文件不得超过$MAX_FILE_SIZE k！";
	}
	//设置保存路径
	$dir=$uppath.$user_name;
	//获取目录的磁盘容量
	$dirsize=dirsize($dir);
	$left_size=$u_size*1024*1024-$dirsize;
	if($userfile_size>$left_size){
		//格式化磁盘容量
		$dirsize=sizecount($dirsize);
		$error="对不起，你的空间容量已经用了$dirsize ,空间即将用完，请删除部分文件以后在上传！";
	}
	//设置不能被上传的文件类型，并判断
	$notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll|.htm|.html';
	if($type=file_type($userfile_name,$notuptypes)){
		$error="对不起，请不要上传".$type."格式的文件！";
	}
	//上传无误，上传并插入信息至数据库及页面中
	if ($error==1){
		//获取扩展名
		$extend = pathinfo($userfile_name);
		$extend = strtolower($extend["extension"]);
		//参数设置
		$addtime=time();
		//需要重命名的
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
			//插入至数据库
			$query="INSERT INTO $table_file ( `filename`, `uid` ,`userid`, `size` , `path` ,`extend`, `addtime` )
                          VALUES ('$userfile_name','$uid' ,'$user_id', '$newfile_size', '$newfile_path','$extend', '$addtime')";
			$r=$db->query($query);
			$file_id=$db->insert_id();
			if(!eregi($extend,$uptypes)){$extend="unknown";};
			//显示至页面表格中
   
			echo "<script>window.opener.document.getElementById('msg').innerHTML = '成功';
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
               newTd1.innerHTML=\"<img src=./images/$extend.gif border=0  align=absmiddle alt='文件'> <a href=?filename=down&uid=$uid&id=$file_id>$userfile_name</a>\";
               newTd2.innerHTML=\"$newfile_size\";
               newTd3.innerHTML=\"".date("Y-n-d h:i:s",$addtime)."\";
               newTd4.innerHTML=\"<a href=# onClick=del('ftable','file$file_id','file',$file_id)><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('file',$file_id)><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a> \"; 
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
			exit;
		}
		//文件上传失败
	}else {
		echo "<script>window.opener.document.getElementById('msg').innerHTML = '$error';
             setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 6000);
            </script>";   
	}
}
?>