<?php
/*
����ɽ��Сѧ����칫��
*/

switch($action){

//�����Ʒ�Ǽ�
case 'addproduct':
//��������
$referer="?filename=product&action=inproduct";
$intime=time();
//��������
$query="INSERT INTO `$table_product` ( `id` , `name` , `content` , `type` , `grade` , `subject`,`intime`,`sumnumber`,`innumber`) 
                              VALUES ('','$name','$content', '$type', '$grade', '$subject', '$intime', '$sumnumber','$sumnumber');";
$db->query($query);
$id=$db->insert_id();
$intime=date("Y/m/d",$intime);
//������Ʒ�������
$query="select * from $table_type where type='t' and id=$type limit 1";
$r=$db->query_first($query);
$type=$r[name];
//������Ʒ�����꼶
$query="select * from $table_type where type='g' and id=$grade limit 1";
$r=$db->query_first($query);
$grade=$r[name];
//������Ʒ����ѧ��
$query="select * from $table_type where type='s' and id=$subject limit 1";
$r=$db->query_first($query); 
$subject=$r[name];      
echo " <script  language='JavaScript'>  
var nowTable=window.opener.document.getElementById(\"newlist\");  
        var newTr=nowTable.insertRow();
            newTr.id=\"list".$id."1\";
            newTr.height=24;
            
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
        var newTd5=newTr.insertCell(5);
        var newTd6=newTr.insertCell(6);
    
            newTd.width=\"5%\";
            newTd1.width=\"50%\";
            newTd2.width=\"10%\";
            newTd3.width=\"10%\";
            newTd4.width=\"10%\";
            newTd5.width=\"5%\";
            newTd6.width=\"10%\";
        
            newTd.className=\"tr_head\";
            newTd1.className=\"tr_head\";
            newTd2.className=\"tr_head\";
            newTd3.className=\"tr_head\";
            newTd4.className=\"tr_head\";
            newTd5.className=\"tr_head\";
            newTd6.className=\"tr_head\";
            
            newTd.innerHTML=\"<center>����</center>\";
            newTd1.innerHTML=\"<center>����</center>\";
            newTd2.innerHTML=\"<center>����</center>\";
            newTd3.innerHTML=\"<center>�꼶</center>\";
            newTd4.innerHTML=\"<center>ѧ��</center>\";
            newTd5.innerHTML=\"<center>����</center>\";
            newTd6.innerHTML=\"<center>���ʱ��</center>\";
            
        var newTr=nowTable.insertRow();
            newTr.id=\"list".$id."2\";
            newTr.height=24;
            
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
        var newTd5=newTr.insertCell(5);
        var newTd6=newTr.insertCell(6);

            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
            newTd4.className=\"td1\";
            newTd5.className=\"td1\";
            newTd6.className=\"td1\";
            
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$name</center>\";
            newTd2.innerHTML=\"<center>$type</center>\";
            newTd3.innerHTML=\"<center>$grade</center>\";
            newTd4.innerHTML=\"<center>$subject</center>\";
            newTd5.innerHTML=\"<center>$sumnumber</center>\";
            newTd6.innerHTML=\"<center>$intime</center>\";

        var newTr=nowTable.insertRow();
            newTr.id=\"list".$id."3\"; 
            newTr.height=24;
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);

             newTd1.colSpan=3;
             newTd3.colSpan=2;
             
            newTd.className=\"tr_head\";
            newTd1.className=\"td2\";
            newTd2.className=\"tr_head2\";
            newTd3.className=\"td2\";

            newTd.innerHTML=\"<center>����</center>\";
            newTd1.innerHTML=\"$content\";
            newTd2.innerHTML=\"<center>����</center>\";
            newTd3.innerHTML=\"<center><font color=red>���</font>|<a href=# onclick=popUp('editproduct','$id')>�༭</a>|ɾ��</center>\";

        var newTr=nowTable.insertRow();
            newTr.height=5;
        var newTd=newTr.insertCell(0);
             newTd.colSpan=7;
     </script>
     
     ";
$db->close();     
showmessage("�����Ʒ�Ǽǳɹ���",$referer);
break;
//�༭��Ʒ�Ǽ�
case 'editproduct':
//��������
$types=array("","����","����");
$query="UPDATE `$table_product` SET `name`='$name',
                                    `content`='$content',
                                    `type`='$type',
                                    `grade`='$grade', 
                                    `subject`='$subject', 
                                    `sumnumber`='$sumnumber',
                                    `innumber`='$sumnumber'
                                    WHERE `id` = '$id' 
                                    LIMIT 1 ;";
$result=$db->query($query);
//������Ʒ�������
$query="select * from $table_type where type='t' and id=$type limit 1";
$r=$db->query_first($query);
$type=$r[name];
//������Ʒ�����꼶
$query="select * from $table_type where type='g' and id=$grade limit 1";
$r=$db->query_first($query);
$grade=$r[name];
//������Ʒ����ѧ��
$query="select * from $table_type where type='s' and id=$subject limit 1";
$r=$db->query_first($query); 
$subject=$r[name];  
$db->close();  
echo "
     <script language='JavaScript'>  
        var tbl = window.opener.document.getElementById(\"list".$id."2\");
            tbl.cells[1].innerHTML=  \"<center><font color=red>$name</font><center>\";
            tbl.cells[2].innerHTML=  \"<center><font color=red>$type</font><center>\";
            tbl.cells[3].innerHTML=  \"<center><font color=red>$grade</font><center>\";              
            tbl.cells[4].innerHTML=  \"<center><font color=red>$subject</font><center>\"; 
            tbl.cells[5].innerHTML=  \"<center><font color=red>$sumnumber</font><center>\"; 
        var tbl = window.opener.document.getElementById(\"list".$id."3\");
            tbl.cells[1].innerHTML=  \"<font color=red>$content</font>\";

             window.close();
     </script>
";
   
break;
//Ԥ�账��
case 'preborrow':
//��������
$user_id=$user_id;
$bortime=time();
$query="INSERT INTO `$table_borrow` ( `id` , `pid` , `author` , `bortime` , `bornumber` , `state`) 
                              VALUES ('','$id','$user_id', '$bortime', '1', '0');";
$db->query($query);
$query="UPDATE `$table_product` SET `innumber`=`innumber`-1,`prenumber`=`prenumber`+1 WHERE `id` = '$id' LIMIT 1 ;";
$db->query($query);
$query="select innumber,prenumber from $table_product where id=$id limit 1";
$r=$db->query_first($query);
$db->close();
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list".$id."2\");
            tbl.cells[5].innerHTML=  \"<center><font color=red>$r[innumber]</font><center>\";
            tbl.cells[7].innerHTML=  \"<center><font color=red>$r[prenumber]</font><center>\";
            
             window.close();
     </script>
";
break;
//��Ǵ���
case 'borrow':
//��ȡ��Ʒ��Ϣ���е����к�
$query="select pid from $table_borrow where id=$id";
$r=$db->query_first($query);
$pid=$r[pid];
//�޸���Ʒ��Ϣ���е�����
$query="UPDATE `$table_product` SET `outnumber`=`outnumber`+1,`prenumber`=`prenumber`-1,bornumber=bornumber+1 WHERE `id` = '$pid' LIMIT 1 ;";
$db->query($query);
//�޸Ľ�Ǳ��е�״̬
$query="UPDATE `$table_borrow` SET `state`='1' WHERE `id` = '$id' LIMIT 1 ;";
$db->query($query);
$db->close();
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[6].innerHTML=  \"<center><font color=red>�ѽ�</font><center>\";
            tbl.cells[7].innerHTML=  \"<center><a href=# onclick=popUp('return','$id')><font color=red>�黹</font></a><center>\";
            
             window.close();
     </script>
";
break;
case 'return':
//��ȡ��Ʒ��Ϣ���е����к�
$query="select pid from $table_borrow where id=$id";
$r=$db->query_first($query);
$pid=$r[pid];
//�޸���Ʒ��Ϣ���е�����
$retime=time();
$query="UPDATE `$table_product` SET `outnumber`=`outnumber`-1,`innumber`=`innumber`+1 WHERE `id` = '$pid' LIMIT 1 ;";
$db->query($query);
//�޸Ľ�Ǳ��е�״̬
$query="UPDATE `$table_borrow` SET `state`='2',`retime`='$retime' WHERE `id` = '$id' LIMIT 1 ;";
$db->query($query);
$db->close();
$retime=date("Y/m/d",$retime);
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[4].innerHTML=  \"<center><font color=red>$retime</font><center>\";
            tbl.cells[6].innerHTML=  \"<center><font color=red>�ѻ�</font><center>\";
            tbl.cells[7].innerHTML=  \"<center><font color=red>�ѻ�</font><center>\";
            
             window.close();
     </script>
";
break;
//��ҳ��ɾ���ҵļ�¼
case 'delborrow':
//��ȡ��Ʒ��Ϣ���е����к�
$query="select pid from $table_borrow where id=$id";
$r=$db->query_first($query);
$pid=$r[pid];
//�޸���Ʒ��Ϣ���е�����
$query="UPDATE `$table_product` SET `prenumber`=`prenumber`-1,`innumber`=`innumber`+1 WHERE `id` = '$pid' LIMIT 1 ;";
$db->query($query);
$query="DELETE from `$table_borrow` WHERE `id` = '$id' LIMIT 1 ;";
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
case 'typeadd':
$referer="?filename=setting&action=typeadd";
//����Ƿ��ظ�����������
$query="select id from $table_type where `name`='$name' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
exit;
}
//��������
$query="INSERT INTO `$table_type` ( `id` , `name` , `type`) 
                       VALUES ('', '$name', 't');
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

            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
                      
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$name</center>\";
            newTd2.innerHTML=\"<center><a href='#' onclick=popUp('typeedit','$id')>�޸�</a> | <a href='#' onclick=popUp('typedel','$id')>ɾ��</a></center>\";
     </script>
     ";
$db->close();     
showmessage("������ӳɹ���",$referer);
break;
case 'typeedit':
$query="UPDATE `$table_type` SET `name`='$name'  WHERE id= $id LIMIT 1 ;";  
$db->query($query);
$db->close(); 
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<center><font color=red>$name</font></center>\";
             window.close();
     </script>
";
break;
case 'typedel':
$query="DELETE from $table_type WHERE `id` = '$id' LIMIT 1 ;";
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
case 'subjectadd':
$referer="?filename=setting&action=subjectadd";
//����Ƿ��ظ�����������
$query="select id from $table_type where `name`='$name' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
exit;
}
//��������
$query="INSERT INTO `$table_type` ( `id` , `name` , `type`) 
                       VALUES ('', '$name', 's');
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

            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
                      
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$name</center>\";
            newTd2.innerHTML=\"<center><a href='#' onclick=popUp('subjectedit','$id')>�޸�</a> | <a href='#' onclick=popUp('subjectdel','$id')>ɾ��</a></center>\";
     </script>
     ";
$db->close();     
showmessage("������ӳɹ���",$referer);
break;
case 'subjectedit':
$query="UPDATE `$table_type` SET `name`='$name'  WHERE id= $id LIMIT 1 ;";  
$db->query($query);
$db->close(); 
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<center><font color=red>$name</font></center>\";
             window.close();
     </script>
";
break;
case 'subjectdel':
$query="DELETE from $table_type WHERE `id` = '$id' LIMIT 1 ;";
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
$query="select id from $table_type where `name`='$name' limit 1";
$result=$db->query($query);
if($db->num_rows($result)!=0){
$ordertime_show=date("Y-m-d",$ordertime);
showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
exit;
}
//��������
$query="INSERT INTO `$table_type` ( `id` , `name` , `type`) 
                       VALUES ('', '$name', 'g');
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

            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
                      
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$name</center>\";
            newTd2.innerHTML=\"<center><a href='#' onclick=popUp('gradeedit','$id')>�޸�</a> | <a href='#' onclick=popUp('gradedel','$id')>ɾ��</a></center>\";
     </script>
     ";
$db->close();     
showmessage("������ӳɹ���",$referer);
break;
case 'gradeedit':
$query="UPDATE `$table_type` SET `name`='$name'  WHERE id= $id LIMIT 1 ;";  
$db->query($query);
$db->close(); 
echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<center><font color=red>$name</font></center>\";
             window.close();
     </script>
";
break;
case 'gradedel':
$query="DELETE from $table_type WHERE `id` = '$id' LIMIT 1 ;";
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
