<?php

/************************************************************/
//���ð༶
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
foreach ($gradearr AS $key=>$value)
    $grade.=" <option value=$key>$value</option>";
switch($action){
case 'repair':
if ($close==1){
  echo "  <script language='JavaScript'>  
             window.close();
          </script>
       ";
   exit;  
}

?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
function check(theform)
{
	   if(theform.grade.value == 0)
   {
   		alert("��ѡ���꼶!");
		theform.grade.focus();
		return false ;
   }
     if(theform.nonum1.value ==0)
   {
   		alert("��ѡ���½�!");
		theform.nonum1.focus();
		return false ;
   }
    if(theform.nonum2.value ==0)
   {
   		alert("��ѡ���½�!");
		theform.nonum2.focus();
		return false ;
   }
   if(theform.title.value == "")
   {
   		alert("����дʵ������!");
		theform.title.focus();
		return false ;
   }

  if(theform.content.value == "")
   {
   		alert("����дʵ�����ĺ���Ʒ!");
		theform.content.focus();
		return false ;
   }

   return true;     
 }    
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=add" OnSubmit="return check(this)">
  <tr>
    <td height="28" valign="middle"><strong>�꼶��</strong>
     <select name=grade>
       <option value=0>��ѡ��</option>
     <?=$grade;?>                    	
     </select>
     <strong>�½ڣ�</strong>
     <select name=nonum1>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>
       <option value=2>�ڶ���</option>
       <option value=3>������</option>   
       <option value=4>������</option>
       <option value=5>������</option>
       <option value=6>������</option> 
       <option value=7>������</option>
       <option value=8>�ڰ���</option>
       <option value=9>�ھ���</option>                   	
       <option value=10>��ʮ��</option> 
     </select>
     <select name=nonum2>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>  
       <option value=2>�ڶ���</option>                  	
       <option value=3>������</option> 
       <option value=4>���Ľ�</option> 
       <option value=5>�����</option> 
       <option value=6>������</option> 
       <option value=7>���߽�</option> 
       <option value=8>�ڰ˽�</option> 
       <option value=9>�ھŽ�</option> 
       <option value=10>��ʮ��</option> 
       
     </select>
   </td>
  </tr> 
      </label></td>
  </tr>   
  <tr>
    <td height="28" valign="middle"><strong>ʵ�����ƣ�
      <label>
      <input type="text" name="title" size=30>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      ʵ�����ģ�
      <label>
      <textarea name=content cols="28" rows="4"></textarea>
      </label>
    </strong></td>
  </tr>
  <tr><td align=center height=28 valign=bottom>
      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'editrepair':
if ($close==1){
  echo "  <script language='JavaScript'>  
             window.close();
          </script>
       ";
   exit;  
}
//��¼���ݵĶ�ȡ
$query="select * from $table_content where id='$id' limit 1";
$r=$db->query_first($query);
$edit_id=$r[id];
$gradeid=$r[grade];
$nonum_arr=explode(".",$r[nonum]);
$nonum1=$nonum_arr[0];
$nonum2=$nonum_arr[1];
$edit_title=$r[title];
$edit_content=$r[content];
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
function check(theform)
{
	   if(theform.grade.value == 0)
   {
   		alert("��ѡ���꼶!");
		theform.grade.focus();
		return false ;
   }
     if(theform.nonum1.value ==0)
   {
   		alert("��ѡ���½�!");
		theform.nonum1.focus();
		return false ;
   }
    if(theform.nonum2.value ==0)
   {
   		alert("��ѡ���½�!");
		theform.nonum2.focus();
		return false ;
   }
   if(theform.title.value == "")
   {
   		alert("����дʵ������!");
		theform.title.focus();
		return false ;
   }

  if(theform.content.value == "")
   {
   		alert("����дʵ�����ĺ���Ʒ!");
		theform.content.focus();
		return false ;
   }

   return true;     
 }      
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=editrepair&id=<?=$edit_id;?>" OnSubmit="return check(this)">
  <tr>
    <td height="28" valign="middle"><strong>�꼶��</strong>
     <select name=grade>
       <option value=0>��ѡ��</option>
       <?=$grade;?>                     	
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.grade;
                     Obj.value=<?=$gradeid;?>;
               </SCRIPT>
     <strong>�½ڣ�</strong>
     <select name=nonum1>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>
       <option value=2>�ڶ���</option>
       <option value=3>������</option>   
       <option value=4>������</option>
       <option value=5>������</option>
       <option value=6>������</option> 
       <option value=7>������</option>
       <option value=8>�ڰ���</option>
       <option value=9>�ھ���</option>                   	
       <option value=10>��ʮ��</option> 
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum1;
                     Obj.value=<?=$nonum1;?>;
               </SCRIPT>
     <select name=nonum2>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>  
       <option value=2>�ڶ���</option>                  	
       <option value=3>������</option> 
       <option value=4>���Ľ�</option> 
       <option value=5>�����</option> 
       <option value=6>������</option> 
       <option value=7>���߽�</option> 
       <option value=8>�ڰ˽�</option> 
       <option value=9>�ھŽ�</option> 
       <option value=10>��ʮ��</option> 
       
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum2;
                     Obj.value=<?=$nonum2;?>;
               </SCRIPT>
   </td>
  </tr> 
      </label></td>
  </tr>   
  <tr>
    <td height="28" valign="middle"><strong>ʵ�����ƣ�
      <label>
      <input type="text" name="title" size=30 value=<?=$edit_title;?>>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      ʵ�����ģ�
      <label>
      <textarea name=content cols="28" rows="4"><?=$edit_content;?></textarea>
      </label>
    </strong></td>
  </tr>
  <tr><td align=center height=28 valign=bottom>
      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'showcontent':
//��¼���ݵĶ�ȡ
$query="select * from $table_content where id='$id' limit 1";
$r=$db->query_first($query);
$edit_id=$r[id];
$gradeid=$r[grade];
$nonum_arr=explode(".",$r[nonum]);
$nonum1=$nonum_arr[0];
$nonum2=$nonum_arr[1];
$edit_title=$r[title];
$edit_content=$r[content];
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }

</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name=form1>
  <tr>
    <td height="28" valign="middle"><strong>�꼶��</strong>
     <select name=grade>
       <option value=0>��ѡ��</option>
<?=$grade;?>                    	
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.grade;
                     Obj.value=<?=$gradeid;?>;
               </SCRIPT>
     <strong>�½ڣ�</strong>
     <select name=nonum1>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>
       <option value=2>�ڶ���</option>
       <option value=3>������</option>   
       <option value=4>������</option>
       <option value=5>������</option>
       <option value=6>������</option> 
       <option value=7>������</option>
       <option value=8>�ڰ���</option>
       <option value=9>�ھ���</option>                   	
       <option value=10>��ʮ��</option> 
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum1;
                     Obj.value=<?=$nonum1;?>;
               </SCRIPT>
     <select name=nonum2>
       <option value=0>��ѡ��</option>
       <option value=1>��һ��</option>  
       <option value=2>�ڶ���</option>                  	
       <option value=3>������</option> 
       <option value=4>���Ľ�</option> 
       <option value=5>�����</option> 
       <option value=6>������</option> 
       <option value=7>���߽�</option> 
       <option value=8>�ڰ˽�</option> 
       <option value=9>�ھŽ�</option> 
       <option value=10>��ʮ��</option> 
       
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum2;
                     Obj.value=<?=$nonum2;?>;
               </SCRIPT>
   </td>
  </tr> 
      </label></td>
  </tr>   
  <tr>
    <td height="28" valign="middle"><strong>ʵ�����ƣ�
      <label>
      <input type="text" name="title" size=30 value=<?=$edit_title;?>>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      ʵ�����ģ�
      <label>
      <textarea name=content cols="28" rows="6"><?=$edit_content;?></textarea>
      </label>
    </strong></td>
  </tr>
  <tr><td align=center height=28 valign=bottom>
      </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'adminrepair':
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=adminrepair&id=<?=$id;?>">
  <tr>
    <td height="160" valign="middle" align=center> 
    	<label>
    	<input type="radio" name="state" value="1" checked>
      ׼����  
      <input type="radio" name="state" value="2">
      ʹ����	
      <input type="radio" name="state" value="3">
      �ѹ黹
      </label><p>
      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
      <p>������Դ����Ȩ���� ����
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'delrepair':
$query="select * from $table_content where id=$id limit 1";
$r=$db->query_first($query);
if ($r[state]>0)$state_t="<font color=red>ʵ���Ѿ���ʼ��,��Ҫȡ��,���ʵ��Ա��ϵ!</font>";
else $sub="<input type=\"submit\" name=\"submit\" value=\"ȷ��\">";
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=delorder">
  <tr>
    <td height="160" valign="middle" align=center>
    	���Ҫȡ����˴������ʵ�����ĺ���Ʒ?<p><?=$state_t;?><p>
    	<input type=hidden name=id value=<?=$id;?>>
      <?=$sub;?>
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
      <p>������Դ����Ȩ���� ����
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'aorder':
$ordertime_now=mktime(0,0,0,date("m"),date("d"),date("Y"));
$query="select * from $table_content where id=$orderid limit 1";
$r=$db->query_first($query);
$order_classid=$r[classid];
$order_nonumber=$r[nonumber];
$order_time=$r[ordertime];
$order_c=($order_time-$ordertime_now)/86400;
//�趨����ʱ��
$week=array("������","����һ","���ڶ�","������","������","������","������");
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$order_c,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$order_week=$week[$weekid];
$ordertimeid=$order_c+1;
//�趨����
$query="select * from $table_class where id=$order_classid limit 1";
$r=$db->query_first($query);
$order_class=$r[name];
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=aorder">
  <tr>
    <td height="160" valign="middle" align=center>
    	���Ҫ��Լ�� <?=$ordertime_show." ".$order_week;?><br>��<?=$order_class;?>ԤԼ�ĵ�<?=$order_nonumber;?>�ÿ��� <p>
    	<input type=hidden name=ordertime value=<?=$order_time;?>>	
    	<input type=hidden name=tableid value=<?=$tableid;?>>
    	<input type=hidden name=orderid value=<?=$orderid;?>>
    	<input type=hidden name=orderclassid value=<?=$order_classid;?>>
    	<input type=hidden name=ordernonumber value=<?=$order_nonumber;?>>	
      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onclick="ret();">
      <p>������Դ����Ȩ���� ����
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
};
?>