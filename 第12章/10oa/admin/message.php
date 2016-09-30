<?php
/*
凤鸣山中小学网络办公室
*/
/************************************************************/
//栏目数据读取
if ($typeid){
   $query="select typename from $table_type where `id`='$typeid' limit 1";
   $r=$db->query_first($query);
   $now_typename=$r[typename];
   }else {
  	     $now_typename="全部文章";
  	     }
if ($action=="") $action="receive";
$tpl->assign("now_typename",$now_typename);
switch($action){
case 'new':
break;
case 'receive':
//页码设置开始
 $sql = "SELECT count(*) FROM $table_message where receive=$user_id ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=message&action=list");      
//页码设置结束
//记录数据的读取
$query="select $table_message.*,members.realname  from $table_message 
            LEFT JOIN members ON $table_message.send=members.userid 
            where receive=$user_id 
            order by $table_message.id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){ 
      $sendtime=date("Y/m/d",$r[sendtime]);
      $content[]=array("id"=>$r[id],"title"=>$r[title],"realname"=>$r[realname],"sendtime"=>$sendtime,"content"=>$r[content]);                       
}
$tpl->assign('pagenav',$pagenav);
$tpl->assign('content',$content);
break;
case 'send':
//页码设置开始
 $sql = "SELECT count(*) FROM $table_message where send=$user_id ";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=message&action=list");      
//页码设置结束
//记录数据的读取
$query="select $table_message.*,members.realname  from $table_message 
            LEFT JOIN members ON $table_message.receive=members.userid 
            where send=$user_id 
            order by $table_message.id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
      $sendtime=date("Y/m/d",$r[sendtime]);
      $content[]=array("id"=>$r[id],"title"=>$r[title],"realname"=>$r[realname],"sendtime"=>$sendtime,"content"=>$r[content]);                       
}
$tpl->assign('pagenav',$pagenav);
$tpl->assign('content',$content);
break;
}
$tpl->assign('action',$action);
$tpl->display('message.html');
?>