<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �ɼ�ͳ��ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
//�༶
$classid=substr($class_id,5,1);
$nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
$temptime=$nowtime-$class_buildtime;
$temptime=round($temptime/2592000);
      if ($temptime>0 ANd $temptime<=12) {
                  $class_name="��һ($classid)��";          
      	         }
         elseif ($temptime>12 AND $temptime<=24){
         	       $class_name="����($classid)��";      	      
      	         }
         elseif ($temptime>24 AND $temptime<=36){
         	       $class_name="����($classid)��";
      	         	}   
$chajian=$class_name;
?>
<body leftmargin="0" topmargin="0">
<table cellspacing="0" cellpadding="2" border="0" width="100%" height="100%" bgcolor="#FFFFFF">
<tr valign="middle"  align="center">
<td></td>
<td></td>
<td></td>
<td><a href="./" target="_blank">��վ��ҳ</a> |<?=$chajian;?><?="-$ok-$user_id-".$groupid."|".$admining_id."|".$class_id."|".$class_buildtime;?> <a href="?filename=login&action=logout" target="_top">�˳�</a></TD>
</tr>
</table>
<SCRIPT language=Javascript></SCRIPT>
</body>
