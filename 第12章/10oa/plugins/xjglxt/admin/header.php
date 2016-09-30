<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   成绩统计系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
//班级
$classid=substr($class_id,5,1);
$nowtime=mktime(0,0,0,date("m"),date("d"),date("Y"))."<br>";
$temptime=$nowtime-$class_buildtime;
$temptime=round($temptime/2592000);
      if ($temptime>0 ANd $temptime<=12) {
                  $class_name="初一($classid)班";          
      	         }
         elseif ($temptime>12 AND $temptime<=24){
         	       $class_name="初二($classid)班";      	      
      	         }
         elseif ($temptime>24 AND $temptime<=36){
         	       $class_name="初三($classid)班";
      	         	}   
$chajian=$class_name;
?>
<body leftmargin="0" topmargin="0">
<table cellspacing="0" cellpadding="2" border="0" width="100%" height="100%" bgcolor="#FFFFFF">
<tr valign="middle"  align="center">
<td></td>
<td></td>
<td></td>
<td><a href="./" target="_blank">网站首页</a> |<?=$chajian;?><?="-$ok-$user_id-".$groupid."|".$admining_id."|".$class_id."|".$class_buildtime;?> <a href="?filename=login&action=logout" target="_top">退出</a></TD>
</tr>
</table>
<SCRIPT language=Javascript></SCRIPT>
</body>
