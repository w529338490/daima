<?
/*
����ɽ��Сѧ����칫��
*/
//checkNum.php

 Function getRandNumber ($fMin, $fMax){ 
 srand((double)microtime()*1000000);
 $fLen = "%0".strlen($fMax). "d";
 Return sprintf($fLen, rand($fMin,$fMax));
 } 
$str=getRandNumber(1000,9999);
setcookie("code",$str);

//function images($str){
//$str=random(4); //������ɵ��ַ���

$width = 50; //��֤��ͼƬ�Ŀ��
$height = 22; //��֤��ͼƬ�ĸ߶�
@header("Content-Type:image/png");
//$_SESSION["code"] = $str;
//echo $str;
$im=imagecreate($width,$height);
//����ɫ
$back=imagecolorallocate($im,0xFF,0xFF,0xFF);
//ģ������ɫ
$pix=imagecolorallocate($im,187,230,247);
//����ɫ
$font=imagecolorallocate($im,41,163,238);
//��ģ�����õĵ�
mt_srand();
for($i=0;$i<1000;$i++)
{
imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix);
}
imagestring($im, 5, 7, 3,$str, $font);
imagerectangle($im,0,0,$width-1,$height-1,$font);
imagepng($im);
imagedestroy($im);
//$_SESSION["code"] = $str;

//}

?>