<?php


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
                     
                      showmessage("ϵͳ���óɹ����뷵�أ�","?filename=setvar");
                }else
                      showmessage("ϵͳ����ʧ�ܣ����� ./config.php �ļ��Ƿ��д��");
		fclose($fp);
break;
//���,�Ǽ���Ϣ
case 'add':
//��������
$referer="?filename=repair&action=repair&close=1";
$intime=time();
switch($school_type){
	case '1':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��");
		break;
	case '2':
		$gradearr=array("1"=>"��һ","2"=>"����","3"=>"����");
		break;
	case '3':
		$gradearr=array("1"=>"��һ","2"=>"�߶�","3"=>"����");
		break;
	case '12':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��","7"=>"��һ","8"=>"����","9"=>"����");
		break;
}
$states=array("������","׼����","ʹ����","�ѹ黹");

//��������
$query="INSERT INTO `$table_content` ( `id` , `userid` , `grade` ,`nonum`,`title`, `content` ,`intime`) 
                              VALUES ('', '$user_id', '$grade','$nonum1.$nonum2', '$title','$content',  '$intime');";
$db->query($query);
$id=$db->insert_id();
$intime=date("Y/m/d",$intime);
$t_l=strlen($nonum1.$nonum2.$title);
$rcontent=cnSubStr($content,60-$t_l);
$title_c=$nonum1.".".$nonum2." ".$title."{".$content."}";
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

        
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
            newTd4.className=\"td1\";
            newTd5.className=\"td1\";
            
            newTd.innerHTML=\"<center>".$gradearr[$grade]."</center>\";
            newTd1.innerHTML=\"<center>$real_name</center>\";
            newTd2.innerHTML=\"$title_c\";
            newTd3.innerHTML=\"<center>".$states[0]."</center>\";
            newTd4.innerHTML=\"<center>$intime</center>\";
            newTd5.innerHTML=\"<center>�༭|����</center>\";

     </script>
     ";
$db->close();     
showmessage("���ϱ��޳ɹ���",$referer);
break;
//�༭�ҵı��޼�¼
case 'editrepair':
//����Ƿ��ظ�����������
$grade_arr=array("","һ�꼶","���꼶","���꼶","���꼶","���꼶","���꼶"
                   ,"��һ","����","����"
                   ,"��һ","�߶�","����");
$states=array("������","׼����","ʹ����","�ѹ黹");
$query="UPDATE `$table_content` SET `grade` = '$grade',`nonum`='$nonum1.$nonum2',`title`='$title',`content`='$content' WHERE `id` = '$id' LIMIT 1 ;";
$result=$db->query($query);
$t_l=strlen($nonum1.$nonum2.$title);
$rcontent=cnSubStr($content,60-$t_l);
$title_c=$nonum1.".".$nonum2." ".$title."{".$content."}";
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[0].innerHTML=  \"<font color=red>$grade_arr[$grade]</font>\";
            tbl.cells[2].innerHTML=  \"<font color=red>$title_c</font>\";              
             window.close();
     </script>
";
break;
//��ҳ��ɾ���ҵļ�¼
case 'unorder':
$states=array("������","׼����","ʹ����","�ѹ黹");
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
//����ı�״̬
case 'adminrepair':
$states=array("������","׼����","ʹ����","�ѹ黹");
$intime=time();
$query="UPDATE `$table_content` SET `state` = '$state',`intime`='$intime' WHERE `id` = '$id' LIMIT 1 ;";
                $db->query($query);
                $db->close();  
                $intime=date("Y/m/d",$intime);
               echo "
               <script language='JavaScript'>   
                  var tbl = window.opener.document.getElementById(\"list$id\");
                      tbl.cells[3].innerHTML=  \"<font color=red>$states[$state]</font>\";
                      tbl.cells[4].innerHTML=  \"<font color=red>$intime</font>\";    
                      window.close();
               </script>";

break;
//��Լ��¼
case 'aorder':
//����Ƿ��ظ�������
$query="select id from $table_content where ordertime='$ordertime' and nonumber='$ordernonumber' and classid='$orderclassid' and state='1' limit 1";
$result=$db->query($query);

if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
$showmessange="�Բ����Ѿ�����ԤԼ���ÿΣ�";
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
           tbl.cells[5].innerHTML=  \"<font color=red>�� Ч</font>\";
           tbl.cells[6].innerHTML=  \"<a href=# onclick=popUp('delorder','$tableid','$orderid')>ȡ��</a> | <a href=# onclick=popUp('editorder','$tableid','$orderid')>�޸�</a>\";    
           window.close();
     </script>
     ";
	
	     }

break;
case 'delorder':
$query="delete from $table_content where id=$id LIMIT 1 ;";
	     $db->query($query);
echo "
     <script  language='JavaScript'>  
	     var tbl = window.opener.document.getElementById(\"list$id\");
           tbl.removeNode(true);  
           window.close(); 
     </script>
";

break;
case 'classadd':
$referer="?filename=setting&action=classadd";
//����Ƿ��ظ�����������
$query="select id from $table_class where `name`='$name' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
exit;
}
//��������
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
            newTd3.innerHTML=\"<center><a href='#' onclick=popUp('classedit','$id')>�޸�</a> | <a href='#' onclick=popUp('classdel','$id')>ɾ��</a></center>\";

     </script>
     ";
$db->close();     
showmessage("������ӳɹ���",$referer);
break;
case 'classedit':
//����Ƿ��ظ�����������
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
//����Ƿ��ظ�����������
$query="select id from $table_setting where `name`='$name' and `type`='g' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
exit;
}
//��������
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
            newTd3.innerHTML=\"<center><a href='#' onclick=popUp('gradeedit','$id')>�޸�</a> | <a href='#' onclick=popUp('gradedel','$id')>ɾ��</a></center>\";

     </script>
     ";
$db->close();     
showmessage("������ӳɹ���",$referer);
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
