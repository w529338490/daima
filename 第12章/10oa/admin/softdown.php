<?
/*
凤鸣山中小学网络办公室
*/
if (isset($fileid)){
$query="select * from $table_file where id=$fileid and `hash`='$hash'";
$r=$db->query_first($query);
$downurl="/".$uppath."user/$user_name/$r[path]";
Header("Location: $rootpath$downurl");
//download($downurl);
exit;
} else{ echo "window.close()";exit;};
?>
