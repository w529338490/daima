<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �๦�ܽ��ҵǼ�ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

switch($action){
	//��Ӽ�¼
	case 'insertorder':
		$referer="?filename=order&action=order&gtypeid=$gtypeid";
		$inputtime=time();
		//���ҵ�����
		//������������ݵĶ�ȡ
		$query="select id from $table_class where typeid=$gtypeid order by id ASC";
		$result=$db->query($query);
		$i=0;
		while($r=$db->fetch_array($result)){
			$class_order[$r[id]]=$i;
			$i++;
		}
		//�趨�Ͽο�Ŀ
		$query="select userid,realname,subjectid from members where username='$user_name' limit 1";
		$query="select members.*,subject.*
        from members
        left join subject on subject.subjectid=members.subjectid 
        where members.userid=$user_id  
        limit 1";
		$r=$db->query_first($query);
		$realname=$r[realname];
		$subject=$r[subjectname];
		//����Ƿ��ظ�����������
		$query="select id from $table_content where ordertime='$ordertime' and nonumber='$nonum' and classid='$classid' and state='1' limit 1";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){
			$ordertime_show=date("Y-m-d",$ordertime);
			showmessage("�Բ����Ѿ�����ԤԼ$ordertime_show ��$grade �ÿΣ�",$referer);
		}
		//����Ƿ��ظ��Լ��Ѿ�������
		$query="select id from $table_content where `ordertime`='$ordertime' and `nonumber`='$nonum' and `classid`='$classid' and `state`='0' and `teacher`=$user_id limit 1";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){
			$r=$db->fetch_array($result);
			$orderid=$r[id];
			$query="UPDATE `$table_content` SET `state` = '1' , `content`='$content' WHERE `id` = '$orderid' LIMIT 1 ;";
			$db->query($query);
		}else {
			//��������
			$query="INSERT INTO `$table_content` ( `id` , `classid` , `teacher` , `grade` , `subject` , `nonumber` , `content` , `inputtime` , `ordertime` , `state` )
                       VALUES ('', '$classid', '$user_id', '$grade', '$subject', '$nonum', '$content', '$inputtime', '$ordertime', '1'
     );";

			$db->query($query);
			$orderid=$db->insert_id();}
			//�������ݵĶ�ȡ
			$query="select * from $table_class where id='$classid' order by id ASC";
			$r=$db->query_first($query);
			$show_class_name=$r[name];
			//�趨�Ͽΰ༶
			$query="select * from `classset` where `classid`='$grade' order by id ASC";
			$r=$db->query_first($query);
			$show_grade=$r[classname];
			//����
			$show_class="showtable".$classid;
			$today_time=mktime(0,0,0,date("m"),date("d"),date("Y"));
			$show_date_id=($ordertime-$today_time)/86400+1;
			$show_nonum=$nonum+1;
			if($today_time==$ordertime){
				echo " <script  language='JavaScript'>
        var nowTable=window.opener.document.all.todayorder;
        var col = nowTable.cells.length/nowTable.rows.length;
        var row = nowTable.rows.length;
  
        var newTr=nowTable.insertRow();
            newTr.id=$orderid;
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);

            newTd.innerHTML=\"<center>$realname</center>\";
            newTd1.innerHTML=\"<center>$show_grade</center>\";
            newTd2.innerHTML=\"<center>[$show_class_name]</center>\";
            newTd3.innerHTML=\"<center>��".$nonum."�ÿ�</center>\";
     </script>
     ";};
				echo " <script  language='JavaScript'>
        window.opener.document.all.$show_class.rows[$show_date_id].cells[$show_nonum].innerHTML =\"<a href=# onclick=popUp('unorder','$orderid') title='�� �ݣ�$content&#13;&#10;�� Ŀ��$subject &#13;&#10;�������ȡ��ԤԼ'>$realname<br>$show_grade</a>\";
        window.opener.ShowTabs1(".$class_order[$classid].");
     </script>
     "; 
				$db->close();
				showmessage("������ӳɹ���",$referer);
				break;
				//�༭�ҵļ�¼
	case 'editorder':
		//����Ƿ��ظ�����������
		$ok=0;
		$query="select id from $table_content where `ordertime`='$ordertime' and `nonumber`='$nonum' and `classid`='$classid'  limit 1";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){
			$r=$db->fetch_array($result);
			if ($r[id]==$orderid){
				$ok=1;
			}else {
				$ordertime_show=date("Y-m-d",$ordertime);
				showmessage("�Բ����Ѿ�����ԤԼ$ordertime_show ��$nonum �ÿΣ�",$referer);
			}
		}
		if ($ok==1) $query="UPDATE `$table_content` SET `content`='$content' WHERE `id` = '$orderid' LIMIT 1 ;";
		else $query="UPDATE `$table_content` SET `classid` = '$classid',`grade`='$grade',`nonumber`='$nonum',`ordertime`='$ordertime',`content`='$content' WHERE `id` = '$orderid' LIMIT 1 ;";
		$db->query($query);
		$db->close();
		//�������ݵĶ�ȡ
		$query="select * from $table_class where id='$classid' order by id ASC";
		$r=$db->query_first($query);
		$show_class_name=$r[name];
		//�趨�Ͽΰ༶
		$query="select * from $table_setting where type='g' and `id`='$grade' order by id ASC";
		$r=$db->query_first($query);
		$show_grade=$r[name];
		//�趨����ʱ��
		$week=array("������","����һ","���ڶ�","������","������","������","������");
		$show_ordertime=date("Y-m-d",$ordertime);
		$weekid=date("w",$ordertime);
		$show_week=$week[$weekid];
		echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$orderid\");
            tbl.cells[0].innerHTML=  \"<font color=red>$show_ordertime</font>\";
            tbl.cells[1].innerHTML=  \"<font color=red>$show_week</font>\";
            tbl.cells[2].innerHTML=  \"<font color=red>��".$nonum."�ÿ�</font>\"; 
            tbl.cells[3].innerHTML=  \"<font color=red>$show_grade</font>\";
            tbl.cells[4].innerHTML=  \"<font color=red>[$show_class_name]</font>\";  
             
             window.close();
     </script>
";
		break;
		//��ҳ��ɾ���ҵļ�¼
	case 'unorder':
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
		//�ҵ�ԤԼ����ɾ����¼
	case 'delorder':
		$query="UPDATE `$table_content` SET `state` = '0' WHERE `id` = '$orderid' LIMIT 1 ;";
		$db->query($query);
		$show_class="showtable".$orderclassid;
		$ordernonumber+=1;
		$db->close();
		echo "
     <script language='JavaScript'>   
        var tbl = window.opener.document.getElementById(\"list$orderid\");
            tbl.cells[5].innerHTML=  \"<font color=red>��ȡ��</font>\";
            tbl.cells[6].innerHTML=  \"<a href=# onclick=popUp('aorder','$tableid','$orderid')>��Լ</a> | <a href=# onclick=popUp('editorder','$tableid','$orderid')>�޸�</a>\";    
        window.close();
     </script>
";

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
	case 'typeadd':
		$referer="?filename=setting&action=typeadd";
		//����Ƿ��ظ�����������
		$query="select id from $table_type where `title`='$title' limit 1";
		$result=$db->query($query);
		if($db->num_rows($result)!=0){
			$ordertime_show=date("Y-m-d",$ordertime);
			showmessage("�Բ����Ѿ�����ͬ�ļ�¼",$referer);
			exit;
		}
		//��������
		$query="INSERT INTO `$table_type` ( `id` ,  `title`,`note`)
                       VALUES ('',  '$title','$note');
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
        var newTd4=newTr.insertCell(4);
        
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
              newTd4.className=\"td1\";
              
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>[$title]</center>\";
            newTd2.innerHTML=\"<center>plugins/yyxt/index.php?gtypeid=$id</center>\";
            newTd3.innerHTML=\"<center>[$note]</center>\";
            newTd4.innerHTML=\"<center><a href='#' onclick=popUp('typeedit','$id')>�޸�</a> | <a href='#' onclick=popUp('typedel','$id')>ɾ��</a></center>\";

     </script>
     ";
		$db->close();
		showmessage("������ӳɹ���",$referer);
		break;
	case 'typeedit':
		$query="UPDATE `$table_type` SET  `title`='$title' ,`note`='$note' WHERE id=$id LIMIT 1 ;";
		$db->query($query);
		$db->close();
		echo "
     <script language='JavaScript'>  
             var tbl = window.opener.document.getElementById(\"list$id\");
            tbl.cells[1].innerHTML=  \"<font color=red>$title</font>\";
            tbl.cells[3].innerHTML=  \"<font color=red>$note</font>\";
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
		$query="INSERT INTO `$table_class` ( `id` , `name` , `address`,`typeid`)
                       VALUES ('', '$name', '$address','$typeid');
       ";
		$db->query($query);
		$id=$db->insert_id();
		$query="select * from $table_type where `id`=$typeid limit 1";
		$r=$db->query_first($query);
		$typetitle=$r[title];
		echo " <script  language='JavaScript'>
        var nowTable=window.opener.document.getElementById(\"classlist\");
        var newTr=nowTable.insertRow();
            newTr.id='list$id';
        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
            newTd.className=\"td1\";
            newTd1.className=\"td1\";
            newTd2.className=\"td1\";
            newTd3.className=\"td1\";
            newTd4.className=\"td1\";                        
            newTd.innerHTML=\"<center>$id</center>\";
            newTd1.innerHTML=\"<center>$typetitle</center>\";
            newTd2.innerHTML=\"<center>$name</center>\";
            newTd3.innerHTML=\"<center>[$address]</center>\";
            newTd4.innerHTML=\"<center><a href='#' onclick=popUp('classedit','$id')>�޸�</a> | <a href='#' onclick=popUp('classdel','$id')>ɾ��</a></center>\";

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
            tbl.cells[2].innerHTML=  \"<font color=red>$name</font>\";
            tbl.cells[3].innerHTML=  \"<font color=red>$address</font>\";
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
