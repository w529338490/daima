<?php
switch($action){
	case 'upok':
		//��������
		$file_id=trim($_POST["hidFileID"]);
		if ($file_id!=""){
		$uid=$_POST["uid"];
		//���������ݿ���
		$sql="UPDATE $table_file SET `uid` = '$uid' WHERE `id`='$file_id' LIMIT 1 ;";
		$db->query($sql);
		//��ȡ����
		$sql="select * from $table_file where `id`='$file_id' limit 1";
		$r=$db->query_first($sql);
		//������չ��
		$extend=$r[extend];
		if(!in_array($extend,$uptypes))$extend="unknown";
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
               newTd1.innerHTML=\"<img src=./images/$extend.gif border=0  align=absmiddle alt='�ļ�'> <a href=?filename=down&uid=$uid&id=$file_id>$r[filename]</a>\";
               newTd2.innerHTML=\"$r[size]\";
               newTd3.innerHTML=\"".date("Y-n-d h:i:s",$r[addtime])."\";
               newTd4.innerHTML=\"<a href=# onClick=del('ftable','file$file_id','file',$file_id)><img src=./images/del.gif border=0 alt=ɾ�� align=absmiddle></a> <a href=# onClick=cut('file',$file_id)><img src=./images/cut.gif border=0 alt=���� align=absmiddle></a> \"; 
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
       }
       else
       {
       		echo "<script>window.opener.document.getElementById('msg').innerHTML = '�ϴ�ʧ��';
              
           window.opener.ShowTabs1(0);
           setTimeout(\"window.opener.document.getElementById('msg').style.display = 'none'\", 3000);
           window.close();
         </script>";   
      }
		exit;
		break;
	case 'upfile': 

		if (isset($_FILES["resume_file"]) && is_uploaded_file($_FILES["resume_file"]["tmp_name"]) && $_FILES["resume_file"]["error"] == 0) {
			//��ȡ�ļ��Ĵ�С
			$file_size=$_FILES["resume_file"]['size'];

			$newfile_size=sizecount($file_size);
			//�ϴ��ļ���ֵ��$upload_file
			$upload_file=$_FILES["resume_file"];
			//����ת��
			$upload_file["name"]=iconv( 'UTF-8', 'gbk' ,$upload_file["name"]);
			//ԭ���ļ�����
			$file_name=$upload_file["name"];
			//��ȡ�ļ�����
			$file_info=pathinfo($upload_file["name"]);
			//��ȡ�ļ���չ��
			$file_ext=$file_info["extension"];
			//����·����ʽ
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
			//�����ϴ���·��
			$upload_path=$uppath.$m_dir;
			newcreatedir($upload_path);			

			//��Ҫ��������
			if($renamed){
				list($usec, $sec) = explode(" ",microtime());
				$upload_file['name']=substr($usec,2).'.'.$file_ext;
				unset($usec);
				unset($sec);
			}
			//����Ĭ�Ϸ�����ļ���
			$upload_file['filename']=$upload_path.$upload_file['name'];
			//���ݿ�����ļ���
			$newfile_path=$m_dir.$upload_file['name'];
			//����ļ��Ƿ����
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

			//�����ļ�
			if(@move_uploaded_file($upload_file["tmp_name"],$upload_file["filename"])){
				//�������һ�ΰ�·�����浽���ݿ��еĴ���;
				// Create a pretend file id, this might have come from a database.
				//���������ݿ�
				$query="INSERT INTO $table_file (`filename`, `uid` ,`userid`, `size` , `path` ,`extend`, `addtime` )
                            VALUES ('$file_name','0' ,'$user_id', '$newfile_size', '$newfile_path','$file_ext', '".time()."')";
				$db->query($query);
				$insert_id=$db->insert_id();
				$db->close();
				//��ȡidֵ
				//�������echo���ݿ������ļ�id�������ݿ��е�id����Ȼ�������ִ���û�����ݴ��ص�index.php���е�hidFileID��
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