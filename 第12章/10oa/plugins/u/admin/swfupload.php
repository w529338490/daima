<?php
switch($action){
	case 'upok':
		//接收数据
		$file_id=trim($_POST["hidFileID"]);
		if ($file_id!=""){
		$uid=$_POST["uid"];
		//插入至数据库中
		$sql="UPDATE $table_file SET `uid` = '$uid' WHERE `id`='$file_id' LIMIT 1 ;";
		$db->query($sql);
		//读取数据
		$sql="select * from $table_file where `id`='$file_id' limit 1";
		$r=$db->query_first($sql);
		//设置扩展名
		$extend=$r[extend];
		if(!in_array($extend,$uptypes))$extend="unknown";
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
               newTd1.innerHTML=\"<img src=./images/$extend.gif border=0  align=absmiddle alt='文件'> <a href=?filename=down&uid=$uid&id=$file_id>$r[filename]</a>\";
               newTd2.innerHTML=\"$r[size]\";
               newTd3.innerHTML=\"".date("Y-n-d h:i:s",$r[addtime])."\";
               newTd4.innerHTML=\"<a href=# onClick=del('ftable','file$file_id','file',$file_id)><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('file',$file_id)><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a> \"; 
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
       }
       else
       {
       		echo "<script>window.opener.document.getElementById('msg').innerHTML = '上传失败';
              
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
      }
		exit;
		break;
	case 'upfile': 

		if (isset($_FILES["resume_file"]) && is_uploaded_file($_FILES["resume_file"]["tmp_name"]) && $_FILES["resume_file"]["error"] == 0) {
			//获取文件的大小
			$file_size=$_FILES["resume_file"]['size'];

			$newfile_size=sizecount($file_size);
			//上传文件赋值给$upload_file
			$upload_file=$_FILES["resume_file"];
			//编码转换
			$upload_file["name"]=iconv( 'UTF-8', 'gbk' ,$upload_file["name"]);
			//原来文件名称
			$file_name=$upload_file["name"];
			//获取文件类型
			$file_info=pathinfo($upload_file["name"]);
			//获取文件扩展名
			$file_ext=$file_info["extension"];
			//设置路径方式
			switch($dirtype){
				case '1':
					$m_dir=date(Y)."/".date(m)."/".date(d)."/";
					break;
				case '2':
					$m_dir=date(Y)."/".date(m)."/";
					break;
				case '3':
					$m_dir=date(Y)."/";
					break;
				default:
					$m_dir=$user_name."/";
					break;
			}
			//设置上传的路径
			$upload_path=$uppath.$m_dir;
			newcreatedir($upload_path);			

			//需要重命名的
			if($renamed){
				list($usec, $sec) = explode(" ",microtime());
				$upload_file['name']=substr($usec,2).'.'.$file_ext;
				unset($usec);
				unset($sec);
			}
			//设置默认服务端文件名
			$upload_file['filename']=$upload_path.$upload_file['name'];
			//数据库存入文件名
			$newfile_path=$m_dir.$upload_file['name'];
			//检查文件是否存在
			if(file_exists($upload_file['filename'])){
				if($overwrite){
					@unlink($upload_file['filename']);
				}else{
					$j=0;
					do{
						$j++;
						$temp_file=str_replace('.'.$file_ext,'('.$j.').'.$file_ext,$upload_file['filename']);
					}while (file_exists($temp_file));
					$upload_file['filename']=$temp_file;
					unset($temp_file);
					unset($j);
				}
			}

			//复制文件
			if(@move_uploaded_file($upload_file["tmp_name"],$upload_file["filename"])){
				//下面插入一段把路径保存到数据库中的代码;
				// Create a pretend file id, this might have come from a database.
				//插入至数据库
				$query="INSERT INTO $table_file (`filename`, `uid` ,`userid`, `size` , `path` ,`extend`, `addtime` )
                            VALUES ('$file_name','0' ,'$user_id', '$newfile_size', '$newfile_path','$file_ext', '".time()."')";
				$db->query($query);
				$insert_id=$db->insert_id();
				$db->close();
				//获取id值
				//这里必需echo内容可以是文件id或许数据库中的id，不然程序会出现错误，没有内容传回到index.php表单中的hidFileID中
				echo $insert_id;
			}else{
				echo '';
			}
		} else {
			echo ''; // I have to return something or SWFUpload won't fire uploadSuccess
		}
		exit;
		break;
	default:
		$tpl->assign('id',$id);
break;
}
$tpl->assign('action',$action);
$tpl->assign('style',$style);
$tpl->display('swfupload.html');
?>