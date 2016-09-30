<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009   多功能教室登记系统 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/
/************************************************************/

switch($action){
case 'order':
//设定教室
$query="select * from $table_class where typeid=$gtypeid order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $class.="<option value=$r[id]>$r[name]</option>";
      }
//设置班级数据      
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$grade.="<option value=$r[classid]>$r[classname]</option>";
    }
//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
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
          <strong>  教室：</strong>        
          <select name="classid">
		  <?=$class;?>
        </select>    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>班级：
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
      日期：
      <label>
      <select name="ordertime">
	  <?=$ordertime;?>
      </select>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>上午：</strong>
      <label>
      <input type="radio" name="nonum" value="1">
      第1节      </label>
      <label>
      <input type="radio" name="nonum" value="2">
      第2节      </label>
      <label>
      <input type="radio" name="nonum" value="3">
      </label>
      <label>
      第3节
      <input type="radio" name="nonum" value="4">
      第4节      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>下午：</strong>
      <label>
      <input type="radio" name="nonum" value="5">
      第5节      </label>
      <label>
      <input type="radio" name="nonum" value="6">
      第6节      </label>
      <label>
      <input type="radio" name="nonum" value="7">
      第7节      </label>
      <label>
      <input type="radio" name="nonum" value="8">
      第8节      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>授课内容:</strong>
      <label>
      <input type="text" name="content" size=15>
      <input type=hidden name=gtypeid value=<?=$gtypeid;?>>
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
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
//记录数据的读取
$query="select * from $table_content where id='$orderid' limit 1";
$r=$db->query_first($query);
$edit_orderid=$r[id];
$edit_orderclassid=$r[classid];
$edit_ordergrade=$r[grade];
$edit_ordertime=$r[ordertime];
$edit_nonumber=$r[nonumber];
$edit_content=$r[content];
//设定教室
$query="select * from $table_class order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $class.="<option value=$r[id]>$r[name]</option>";
      }
//设定上课班级
$query="select * from `classset` $where order by classid ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$grade.="<option value=$r[classid]>$r[classname]</option>";
    }
//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
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
          <strong>  教室：</strong>        
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
    <td height="28" valign="middle"><strong>班级：
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
      日期：
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
    <td height="28" valign="middle"><strong>上午：</strong>
      <label>
      <input type="radio" name="nonum" value="1" <? if ($edit_nonumber==1) echo "checked";?>>
      第1节      </label>
      <label>
      <input type="radio" name="nonum" value="2" <? if ($edit_nonumber==2) echo "checked";?>>
      第2节      </label>
      <label>
      <input type="radio" name="nonum" value="3" <? if ($edit_nonumber==3) echo "checked";?>>
      </label>
      <label>
      第3节
      <input type="radio" name="nonum" value="4" <? if ($edit_nonumber==4) echo "checked";?>>
      第4节      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>下午：</strong>
      <label>
      <input type="radio" name="nonum" value="5" <? if ($edit_nonumber==5) echo "checked";?>>
      第5节      </label>
      <label>
      <input type="radio" name="nonum" value="6" <? if ($edit_nonumber==6) echo "checked";?>>
      第6节      </label>
      <label>
      <input type="radio" name="nonum" value="7" <? if ($edit_nonumber==7) echo "checked";?>>
      第7节      </label>
      <label>
      <input type="radio" name="nonum" value="8" <? if ($edit_nonumber==8) echo "checked";?>>
      第8节      </label></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>授课内容:</strong>
      <label>
      <input type="text" name="content" value="<?=$edit_content;?>">
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
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
//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$order_c,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$order_week=$week[$weekid];
$ordertimeid=$order_c+1;
//设定教室
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
    	真的要取消你 <?=$ordertime_show." ".$order_week;?><br>在<?=$order_class;?>预约的第<?=$order_nonumber;?>堂课吗？ <p>
    	<input type=hidden name=ordertimeid value=<?=$ordertimeid;?>>	
    	<input type=hidden name=orderid value=<?=$orderid;?>>
    	<input type=hidden name=orderclassid value=<?=$order_classid;?>>
    	<input type=hidden name=ordernonumber value=<?=$order_nonumber;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
      <p>教育资源网版权所有 不凡
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
//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$order_c,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$order_week=$week[$weekid];
$ordertimeid=$order_c+1;
//设定教室
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
    	真的要取消你 <?=$ordertime_show." ".$order_week;?><br>在<?=$order_class;?>预约的第<?=$order_nonumber;?>堂课吗？ <p>
    	<input type=hidden name=ordertimeid value=<?=$ordertimeid;?>>	
    	<input type=hidden name=tableid value=<?=$tableid;?>>
    	<input type=hidden name=orderid value=<?=$orderid;?>>
    	<input type=hidden name=orderclassid value=<?=$order_classid;?>>
    	<input type=hidden name=ordernonumber value=<?=$order_nonumber;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
      <p>教育资源网版权所有 不凡
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
//设定日期时间
$week=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$ordertime_value=mktime(0,0,0,date("m"),date("d")+$order_c,date("Y"));
$ordertime_show=date("Y-m-d",$ordertime_value);
$weekid=date("w",$ordertime_value);
$order_week=$week[$weekid];
$ordertimeid=$order_c+1;
//设定教室
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
    	真的要续约你 <?=$ordertime_show." ".$order_week;?><br>在<?=$order_class;?>预约的第<?=$order_nonumber;?>堂课吗？ <p>
    	<input type=hidden name=ordertime value=<?=$order_time;?>>	
    	<input type=hidden name=tableid value=<?=$tableid;?>>
    	<input type=hidden name=orderid value=<?=$orderid;?>>
    	<input type=hidden name=orderclassid value=<?=$order_classid;?>>
    	<input type=hidden name=ordernonumber value=<?=$order_nonumber;?>>	
      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onclick="ret();">
      <p>教育资源网版权所有 不凡
    </td>
  </tr>
  </form>
</table>
</body>
<?
break;
};
?>