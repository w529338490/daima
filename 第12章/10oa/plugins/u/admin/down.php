<?
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009  php����Ӳ�� 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
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
