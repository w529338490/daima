<?php
/*
����ɽ��СѧУ����칫��
*/
/************************************************************/
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

   if(theform.content.value == "")
   {
   		alert("����д��������!");
		theform.content.focus();
		return false ;
   }

  if(theform.address.value == "")
   {
   		alert("����д���޵ص�!");
		theform.address.focus();
		return false ;
   }

   return true;     
 }      
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=insertrepair" OnSubmit="return check(this)">
  <tr>
    <td height="28" valign="middle"><strong>���޷��ࣺ</strong>
      <label>
      <label>
      <input type="radio" name="type" value="1" checked>
      �� ��      </label>
      <label>
      <input type="radio" name="type" value="2">
      �� ��      </label></td>
  </tr>  
  <tr>
    <td height="28" valign="middle"><strong>���޵ص㣺
      <label>
      <input type="text" name="address" size=20>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      �������ݣ�
      <label>
      <textarea name=content cols="24" rows="4"></textarea>
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
$edit_type=$r[type];
$edit_address=$r[address];
$edit_content=$r[content];
$edit_intime=$r[intime];
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=editrepair&id=<?=$id;?>">
  <tr>
    <td height="28" valign="middle"><strong>���޷��ࣺ</strong>
      <label>
      <label>
      <input type="radio" name="type" value="1" <? if ($edit_type==1) echo "checked";?>>
      �� ��      </label>
      <label>
      <input type="radio" name="type" value="2" <? if ($edit_type==2) echo "checked";?>>
      �� ��      </label></td>
  </tr>  
  <tr>
    <td height="28" valign="middle"><strong>���޵ص㣺
      <label>
      <input type="text" name="address" size=20 value="<?=$edit_address;?>">
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      �������ݣ�
      <label>
      <textarea name=content cols="24" rows="4"><?=$edit_content;?></textarea>
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
      ά����      
      <input type="radio" name="state" value="2">
      ����ά��     	
      <input type="radio" name="state" value="3">
      ���ά��   </label><p>
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
case 'delorder':
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
  <form name="form1" method="post" action="?filename=deal&action=delorder">
  <tr>
    <td height="160" valign="middle" align=center>
    	���Ҫȡ���� <?=$ordertime_show." ".$order_week;?><br>��<?=$order_class;?>ԤԼ�ĵ�<?=$order_nonumber;?>�ÿ��� <p>
    	<input type=hidden name=ordertimeid value=<?=$ordertimeid;?>>	
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