<?php

/**�жϱ��ⳤ�Ⱥ���
*$title�����ַ���
*$titlelen���ⲻ�ܳ�������󳤶�*/
function titlen($title,$titlelen)
{
	$len = strlen($title);
    if ($len <= $titlelen)
		{
        $title1 = $title;
	} else {
			$title1 = substr($title,0,$titlelen); 
			$parity= 0;

			for($i=0;$i<$titlelen;$i++)
			{ 
				$temp_str=substr($title,$i,1); 
				if(Ord($temp_str)>127) $parity+=1; 
			} 
			if($parity%2==1) $title1=substr($title,0,($titlelen-1))."..."; 
			else $title1=substr($title,0,$titlelen)."..."; 
	}
return $title1;
}


/**
* ��ȡ���Ĳ����ַ���
*
* ��ȡָ���ַ���ָ�����ȵĺ���,�ú������Զ��ж���Ӣ��,�����������
* @access public
* @param string $str Ҫ������ַ���
* @param int $strlen Ҫ��ȡ�ĳ���Ĭ��Ϊ10
* @param string $other �Ƿ�Ҫ����ʡ�Ժ�,Ĭ�ϻ����
* @return string
*/
function cutstr($str,$strlen=10,$other=true)
{
	$j=0;
	for($i=0;$i<$strlen;$i++)
	{
		if(ord(substr($str,$i,1))>0xa0) 
		{
			$j++;
		}
	}
	if(($j%2) != 0) 
	{
	$strlen++;
	}

	$rstr=substr($str,0,$strlen);
	if(strlen($str)>$strlen && $other)
	{
		$rstr.='����';
	}
	return $rstr;
}

?>