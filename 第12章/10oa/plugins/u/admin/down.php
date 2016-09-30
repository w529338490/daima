<?
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
if (isset($id)){
	header("Content-type: text/html;charset=GB2312");
	$query="select * from $table_file where id=$id limit 1";
	$r=$db->query_first($query);
	$downurl=$uppath.$r[path];
	Header("Location: $downurl");
	//download($downurl);
	exit;
}else{
	echo "window.close()";
	exit;};
?>
