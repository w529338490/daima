<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �๦�ܽ��ҵǼ�ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
/************************************************************/

switch($action){
case 'order':
//�趨����
$query="select * from $table_class where typeid=$gtypeid order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $class.="<option value=$r[id]>$r[name]</option>";
      }
//���ð༶����      
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$grade.="<option value=$r[classid]>$r[classname]</option>";
    }
//�趨����ʱ��
$week=array("������","����һ","���ڶ�","������","������","������","������");
for ($i=0;$i<7;$i++){
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$ordertime.="<option value=$ordertime_value>$ordertime_show ".$week[$weekid]."</option>";
};
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body  topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=insertorder&aid=<?=$aid;?>">
  <tr>
    <td width="300" height="28" valign="middle">
          <strong>  ���ң�</strong>        
          <select name="classid">
		  <?=$class;?>
        </select>    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>�༶��
      <label>
      <select name="grade">
	  <?=$grade;?>
      </select>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>
      <label>      </label>
      ���ڣ�
      <label>
      <select name="ordertime">
	  <?=$ordertime;?>
      </select>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���磺</strong>
      <label>
      <input type="radio" name="nonum" value="1">
      ��1��      </label>
      <label>
      <input type="radio" name="nonum" value="2">
      ��2��      </label>
      <label>
      <input type="radio" name="nonum" value="3">
      </label>
      <label>
      ��3��
      <input type="radio" name="nonum" value="4">
      ��4��      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���磺</strong>
      <label>
      <input type="radio" name="nonum" value="5">
      ��5��      </label>
      <label>
      <input type="radio" name="nonum" value="6">
      ��6��      </label>
      <label>
      <input type="radio" name="nonum" value="7">
      ��7��      </label>
      <label>
      <input type="radio" name="nonum" value="8">
      ��8��      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>�ڿ�����:</strong>
      <label>
      <input type="text" name="content" size=15>
      <input type=hidden name=gtypeid value=<?=$gtypeid;?>>
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
case 'editorder':
//��¼���ݵĶ�ȡ
$query="select * from $table_content where id='$orderid' limit 1";
$r=$db->query_first($query);
$edit_orderid=$r[id];
$edit_orderclassid=$r[classid];
$edit_ordergrade=$r[grade];
$edit_ordertime=$r[ordertime];
$edit_nonumber=$r[nonumber];
$edit_content=$r[content];
//�趨����
$query="select * from $table_class order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $class.="<option value=$r[id]>$r[name]</option>";
      }
//�趨�Ͽΰ༶
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$grade.="<option value=$r[classid]>$r[classname]</option>";
    }
//�趨����ʱ��
$week=array("������","����һ","���ڶ�","������","������","������","������");
for ($i=0;$i<7;$i++){
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$ordertime.="<option value=$ordertime_value>$ordertime_show ".$week[$weekid]."</option>";
};
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body  topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=editorder&orderid=<?=$orderid;?>">
  <tr>
    <td width="300" height="28" valign="middle">
          <strong>  ���ң�</strong>        
          <select name="classid">
		  <?=$class;?>
        </select> 
     <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.classid;
            Obj.value="<?=$edit_orderclassid;?>";
      </SCRIPT>
           </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>�༶��
      <label>
      <select name="grade">
	  <?=$grade;?>
      </select>
      <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.grade;
            Obj.value="<?=$edit_ordergrade;?>";
      </SCRIPT>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>
      <label>      </label>
      ���ڣ�
      <label>
      <select name="ordertime">
	  <?=$ordertime;?>
      </select>
      <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.ordertime;
            Obj.value="<?=$edit_ordertime;?>";
      </SCRIPT>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���磺</strong>
      <label>
      <input type="radio" name="nonum" value="1" <? if ($edit_nonumber==1) echo "checked";?>>
      ��1��      </label>
      <label>
      <input type="radio" name="nonum" value="2" <? if ($edit_nonumber==2) echo "checked";?>>
      ��2��      </label>
      <label>
      <input type="radio" name="nonum" value="3" <? if ($edit_nonumber==3) echo "checked";?>>
      </label>
      <label>
      ��3��
      <input type="radio" name="nonum" value="4" <? if ($edit_nonumber==4) echo "checked";?>>
      ��4��      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���磺</strong>
      <label>
      <input type="radio" name="nonum" value="5" <? if ($edit_nonumber==5) echo "checked";?>>
      ��5��      </label>
      <label>
      <input type="radio" name="nonum" value="6" <? if ($edit_nonumber==6) echo "checked";?>>
      ��6��      </label>
      <label>
      <input type="radio" name="nonum" value="7" <? if ($edit_nonumber==7) echo "checked";?>>
      ��7��      </label>
      <label>
      <input type="radio" name="nonum" value="8" <? if ($edit_nonumber==8) echo "checked";?>>
      ��8��      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>�ڿ�����:</strong>
      <label>
      <input type="text" name="content" value="<?=$edit_content;?>">
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
case 'unorder':
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
<body  topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=unorder">
  <tr>
    <td height="160" valign="middle" align=center>
    	���Ҫȡ���� <?=$ordertime_show." ".$order_week;?><br>��<?=$order_class;?>ԤԼ�ĵ�<?=$order_nonumber;?>�ÿ��� <p>
    	<input type=hidden name=ordertimeid value=<?=$ordertimeid;?>>	
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
<body  topmargin="0" leftmargin="0" rightMargin="0">
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
<body  topmargin="0" leftmargin="0" rightMargin="0">
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