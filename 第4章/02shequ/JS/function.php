<?php
     function unhtml($content){
			 $content=str_replace("&","&amp;",$content);
			 $content=str_replace("<","&lt;",$content);
			 $content=str_replace(">","&gt;",$content);
			 $content=str_replace(" ","&nbsp;",$content);
			 $content=str_replace(chr(13),"<br>",$content);
 			 $content=str_replace("\\","\\\\",$content);
 			 $content=str_replace(chr(34),"&quot;",$content);
			 return $content;
	}
	//����һ�����ڽ�ȡһ���ַ����ĺ���msubstr()
   function msubstr($str,$start,$len){   		 //$strָ�����ַ���,$startָ�����ַ�������ʼλ�ã�$lenָ���ǳ��ȡ�
	$strlen=$start+$len;				   		//��$strlen�洢�ַ������ܳ��ȣ����ַ�������ʼλ�õ��ַ������ܳ��ȣ�
	for($i=0;$i<$strlen;$i++){			   		//ͨ��forѭ�����
	if(ord(substr($str,$i,1))>0xa0){       		//����ַ������׸��ֽڵ�ASCII����ֵ����0xa0,���ʾΪ����
 	   $tmpstr.=substr($str,$i,2);			    //ÿ��ȡ����λ�ַ���������$tmpstr��������һ������
	   $i++;								    //�����Լ�1
	}else{								   		//������Ǻ��֣���ÿ��ȡ��һλ�ַ���������$tmpstr
 	 $tmpstr.=substr($str,$i,1);}
	}
		return $tmpstr;					//����ַ���
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
