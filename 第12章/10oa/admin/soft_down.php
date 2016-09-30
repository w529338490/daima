<?
/*
凤鸣山中小学网络办公室
*/
if (isset($id)){
$query="select * from $table_soft where softid=$id and `other`='$hash'";
$r=$db->query_first($query);
$sql="UPDATE `$table_soft` SET `number` = `number`+1 WHERE `softid` = '$id' LIMIT 1 ";
$db->query($sql);
$downurl="./upfile/attach/$r[softpath]";
if ($r[money]=="0"){
header ("Location:".$downurl);
echo "window.close()";
exit;
}
} else { echo "window.close()";exit;};
?>
