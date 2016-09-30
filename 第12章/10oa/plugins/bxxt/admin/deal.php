<?php
/*
凤鸣山中小学校网络办公室
*/
switch($action){
case 'setvar':

		$fp = fopen('./config.php', 'r');
		$configfile = fread($fp, filesize('./config.php'));
		fclose($fp);

		$configfile = preg_replace("/[$]rootpath\s*\=\s*[\"'].*?[\"']/is", "\$rootpath = '$newrootpath'", $configfile);
		$configfile = preg_replace("/[$]style\s*\=\s*[\"'].*?[\"']/is", "\$style = '$newstyle'", $configfile);
		$configfile = preg_replace("/[$]sitename\s*\=\s*[\"'].*?[\"']/is", "\$sitename = '$newsitename'", $configfile);
		$configfile = preg_replace("/[$]siteurl\s*\=\s*[\"'].*?[\"']/is", "\$siteurl = '$newsiteurl'", $configfile);
		$configfile = preg_replace("/[$]sitemaster\s*\=\s*[\"'].*?[\"']/is", "\$sitemaster = '$newsitemaster'", $configfile);
		$configfile = preg_replace("/[$]sitetitle\s*\=\s*[\"'].*?[\"']/is", "\$sitetitle = '$newsitetitle'", $configfile);
		$configfile = preg_replace("/[$]sitedescription\s*\=\s*[\"'].*?[\"']/is", "\$sitedescription = '$newsitedescription'", $configfile);
		$configfile = preg_replace("/[$]sitekeywords\s*\=\s*[\"'].*?[\"']/is", "\$sitekeywords = '$newsitekeywords'", $configfile);
		$configfile = preg_replace("/[$]perpage\s*\=\s*[\"'].*?[\"']/is", "\$perpage = '$newperpage'", $configfile);
		$configfile = preg_replace("/[$]contribute\s*\=\s*[\"'].*?[\"']/is", "\$contribute = '$newcontribute'", $configfile);

		$fp = fopen('./config.php', 'w');
		if(@fwrite($fp, trim($configfile))){
                     
                      showmessage("系统设置成功！请返回！","?filename=setvar");
                }else
                      showmessage("系统设置失败！请检查 ./config.php 文件是否可写！");
		fclose($fp);
break;
//添加报修记录
case 'insertrepair':
//参数设置
$referer="?filename=repair&action=repair&close=1";
$intime=time();
$types=array("","电脑","其他");
$states=array("未维修","维修中","送外维修","维修完成");

//插入数据
$query="INSERT INTO `$table_content` ( `id` , `user` , `address` , `content` , `type` , `intime`) 
                              VALUES ('', '$user_id', '$address', '$content', '$type', '$intime');";
$db->query($query);
$id=$db->insert_id();
$intime=date("Y/m/d",$intime);
echo " <script  language='JavaScript'>  
        var nowTable=window.opener.document.getElementById(\"repairlist\");  
        var newTr=nowTable.insertRow();
            newTr.id=$id;
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
        var newTd5=newTr.insertCell(5);
        var newTd6=newTr.insertCell(6);
        var newTd7=newTr.insertCell(7);
        
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
            newTd4.className=\"td1\";
            newTd5.className=\"td1\";
            newTd6.className=\"td1\";
            newTd7.className=\"td1\";
            
            newTd.innerHTML=\"$address\";
            newTd1.innerHTML=\"<center>$real_name</center>\";
            newTd2.innerHTML=\"<center>".$types[$type]."</center>\";
            newTd3.innerHTML=\"$content\";
            newTd4.innerHTML=\"<center>".$intime."</center>\";
            newTd5.innerHTML=\"<center>".$states[0]."</center>\";
            newTd6.innerHTML=\"<center>&nbsp;</center>\";
            newTd7.innerHTML=\"<center>编辑|管理</center>\";

     </script>
     ";
$db->close();     
showmessage("网上报修成功！",$referer);
break;
//编辑我的报修记录
case 'editrepair':
//检测是否重复其他的数据
$types=array("","电脑","其他");
$query="UPDATE `$table_content` SET `content`='$content',`address`='$address',`type`='$type' WHERE `id` = '$id' LIMIT 1 ;";
$result=$db->query($query);
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[0].innerHTML=  \"<font color=red>$address</font>\";
            tbl.cells[2].innerHTML=  \"<font color=red>$types[$type]</font>\";
            tbl.cells[3].innerHTML=  \"<font color=red>$content</font>\";              
             window.close();
     </script>
";
break;
//首页中删除我的记录
case 'unorder':
$states=array("未维修","维修中","送外维修","维修完成");
$retime=time();
if ($state==2) $query="UPDATE `$table_content` SET `state` = '$state',`retime`='$retime' WHERE `id` = '$orderid' LIMIT 1 ;";
$query="UPDATE `$table_content` SET `state` = '0' WHERE `id` = '$orderid' LIMIT 1 ;";
$db->query($query);
$show_class="showtable".$orderclassid;
$ordernonumber+=1;
$db->close();  
if ($ordertimeid==1){
echo "
     <script  language='JavaScript'>  
	     var tbl = window.opener.document.getElementById(\"$orderid\");
           tbl.removeNode(true);   
     </script>
";
}
echo "
     <script language='JavaScript'>   
        window.opener.document.all.$show_class.rows[$ordertimeid].cells[$ordernonumber].innerHTML =\"\/\";
        window.close();
     </script>
";
break;
//管理改变状态
case 'adminrepair':
$states=array("未维修","维修中","送外维修","维修完成");
$retime=time();
$query="UPDATE `$table_content` SET `state` = '$state',`retime`='$retime' WHERE `id` = '$id' LIMIT 1 ;";
                $db->query($query);
                $db->close();  
                $retime=date("Y/m/d",$retime);
               echo "
               <script language='JavaScript'>   
                  var tbl = window.opener.document.getElementById(\"list$id\");
                      tbl.cells[5].innerHTML=  \"<font color=red>$states[$state]</font>\";
                      tbl.cells[6].innerHTML=  \"$retime\";    
                      window.close();
               </script>";


break;
//续约记录
case 'aorder':
//检测是否重复的数据
$query="select id from $table_content where ordertime='$ordertime' and nonumber='$ordernonumber' and classid='$orderclassid' and state='1' limit 1";
$result=$db->query($query);

if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
$showmessange="对不起，已经有人预约这堂课！";
$db->close();  
echo " <script  language='JavaScript'>  
     </script>
     <body>
     $showmessange
     </body>
     ";
} else {
	     $query="UPDATE `y_content` SET `state` = '1' WHERE `id` = '$orderid' LIMIT 1 ;";
	     $db->query($query);
	     echo " <script  language='JavaScript'>  
	     var tbl = window.opener.document.getElementById(\"list$orderid\");
           tbl.cells[5].innerHTML=  \"<font color=red>有 效</font>\";
           tbl.cells[6].innerHTML=  \"<a href=# onclick=popUp('delorder','$tableid','$orderid')>取消</a> | <a href=# onclick=popUp('editorder','$tableid','$orderid')>修改</a>\";    
           window.close();
     </script>
     ";
	
	     }

break;
case 'classadd':
$referer="?filename=setting&action=classadd";
//检测是否重复其他的数据
$query="select id from $table_class where `name`='$name' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
showmessage("对不起，已经有相同的记录",$referer);
exit;
}
//插入数据
$query="INSERT INTO `$table_class` ( `id` , `name` , `address`) 
                       VALUES ('', '$name', '$address');
       ";
$db->query($query);
$id=$db->insert_id();
echo " <script  language='JavaScript'>  
        var nowTable=window.opener.document.getElementById(\"classlist\");
        var newTr=nowTable.insertRow();
            newTr.id='list$id';
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
                                    
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$name</center>\";
            newTd2.innerHTML=\"<center>[$address]</center>\";
            newTd3.innerHTML=\"<center><a href='#' onclick=popUp('classedit','$id')>修改</a> | <a href='#' onclick=popUp('classdel','$id')>删除</a></center>\";

     </script>
     ";
$db->close();     
showmessage("数据添加成功！",$referer);
break;
case 'classedit':
//检测是否重复其他的数据
$query="UPDATE `$table_class` SET `name`='$name' , `address`='$address' WHERE id= $id LIMIT 1 ;";  
$db->query($query);
$db->close(); 
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<font color=red>$name</font>\";
            tbl.cells[2].innerHTML=  \"<font color=red>$address</font>\";
             window.close();
     </script>
";
break;
case 'classdel':
$query="DELETE from $table_class WHERE `id` = '$id' LIMIT 1 ;";
$db->query($query);
$db->close();  
echo "
     <script  language='JavaScript'>  
	     var tbl = window.opener.document.getElementById(\"list$id\");
           tbl.removeNode(true);   
      window.close();
     </script>
";
break;
case 'gradeadd':
$referer="?filename=setting&action=gradeadd";
//检测是否重复其他的数据
$query="select id from $table_setting where `name`='$name' and `type`='g' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
showmessage("对不起，已经有相同的记录",$referer);
exit;
}
//插入数据
$query="INSERT INTO `$table_setting` ( `id` , `name` , `type`,`other`) 
                       VALUES ('', '$name', 'g','$other');
       ";
$id=$db->insert_id();       
$db->query($query);
echo " <script  language='JavaScript'>  
        var nowTable=window.opener.document.getElementById(\"classlist\");
        var newTr=nowTable.insertRow();
            newTr.id='list$id';
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
            
            newTd.innerHTML=\"<center>$id</center>\";                        
            newTd1.innerHTML=\"<center>$other</center>\";
            newTd2.innerHTML=\"<center>[$name]</center>\";
            newTd3.innerHTML=\"<center><a href='#' onclick=popUp('gradeedit','$id')>修改</a> | <a href='#' onclick=popUp('gradedel','$id')>删除</a></center>\";

     </script>
     ";
$db->close();     
showmessage("数据添加成功！",$referer);
break;
case 'gradeedit':
$query="UPDATE `$table_setting` SET  `name`='$name' ,`other`='$other' WHERE id=$id and `type`='g' LIMIT 1 ;";  
$db->query($query);
$db->close(); 
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<font color=red>$other</font>\";
            tbl.cells[2].innerHTML=  \"<font color=red>$name</font>\";
             window.close();
     </script>
";
break;
case 'gradedel':
$query="DELETE from $table_setting WHERE `id` = '$id' and `type`='g' LIMIT 1 ;";
$db->query($query);
$db->close();  
echo "
     <script  language='JavaScript'>  
	     var tbl = window.opener.document.getElementById(\"list$id\");
           tbl.removeNode(true);   
      window.close();
     </script>
";
break;
}
?>
