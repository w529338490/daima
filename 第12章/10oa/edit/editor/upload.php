<?php

function set_path($dir)
{
	      @fopen("./index.htm","a");
        if (!is_dir($dir))
        {
            $temp = explode('/',$dir);
            $cur_dir = '';
            for($i=0;$i<count($temp);$i++)
            {
                $cur_dir .= $temp[$i].'/';
                if (!is_dir($cur_dir))
                {
                @mkdir($cur_dir,0777);
                @fopen("$cur_dir/index.htm","a");
                }  
            }
        }
        return $cur_dir;
	}	
$act=addslashes($_GET['action']);
$type=addslashes($_GET['uploadtype']);
if($act=='upload'){
	if($type=='attach'){
		$fileType=array('rar','zip','htm','doc','swf','fla','xls','html','txt','jpg','gif','bmp','png','jpeg');//�����ϴ����ļ�����
	}
	elseif($type=='img'){
		$fileType=array('jpg','gif','bmp','png','jpeg');
	}
	$year=date(Y);
	$upfileDir="upload/teacher/$year/";
  set_path("../../".$upfileDir);
	$maxSize=50000; //��λ��KB
	$fileExt=substr(strrchr($_FILES['file1']['name'],'.'),1);
	if(!in_array(strtolower($fileExt),$fileType))
		die("<script>alert('�������ϴ������͵��ļ���$fileExt');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['size']> $maxSize*1024)
		die( "<script>alert('�ļ�����');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['error'] !=0)
		die("<script>alert('δ֪�����ļ��ϴ�ʧ�ܣ�');window.parent.$('divProcessing').style.display='none';history.back();</script>");
	$targetDir=dirname(__FILE__).'/../../'.$upfileDir;
	$targetFile=date('md').time().strrchr($_FILES['file1']['name'],'.');
	$realFile=$targetDir.$targetFile;
	if(function_exists('move_uploaded_file')){
		 move_uploaded_file($_FILES['file1']['tmp_name'],$realFile);
	}
	else{
		@copy($_FILES['file1']['tmp_name'],$realFile);
	}
	if($type=='img'){
		die("<script>window.parent.LoadIMG('../{$upfileDir}{$targetFile}');</script>");
	}
	elseif($type=='attach'){
		die("<script>window.parent.LoadAttach('../{$upfileDir}{$targetFile}');</script>");
	}
}

?>