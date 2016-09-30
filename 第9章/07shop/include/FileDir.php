<?

function searchDir($basedir) 
{ 
	if(!file_exists($basedir))
	{
		return  false;
	}
	$handle=opendir($basedir); 
	while ($file = readdir($handle)) {
		if ($file=="." or $file=="..") { 
		
		} else { 
			$filelisting[]=$file;
		}
	}
	return $filelisting;
	//$number=sizeof($filelisting); //取得文件个数 
}

class  FileDir
{
	function  deleteAllDir($del_path)
	{
		if(!file_exists($del_path))
		{
			return  false;
		}
		$hand=opendir($del_path);
		$i=0;
		while($file=readdir($hand))
		{
			$i++;
			if($i==1||$i==2){continue;}
			if(!(strchr($file,".")))
			{
				$del_s_path=$del_path."/".$file;
				$this->deleteAllDir($del_s_path);
			}
			else
			{
				$del_file=$del_path."/".$file;
				$this->deleteFile($del_file);
			}
		}
		closedir($hand);
		$this->deleteDir($del_path);
		return  true;
	}
	//delete file
	function  deleteFile($del_file)
	{
		unlink($del_file);
	}
	//delete dir
	function  deleteDir($del_path)
	{
		rmdir($del_path);
	}
}

?>