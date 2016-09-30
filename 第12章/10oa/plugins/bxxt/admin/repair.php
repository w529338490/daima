<?php
/*
凤鸣山中小学校网络办公室
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
   		alert("请填写保修内容!");
		theform.content.focus();
		return false ;
   }

  if(theform.address.value == "")
   {
   		alert("请填写保修地点!");
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
    <td height="28" valign="middle"><strong>报修分类：</strong>
      <label>
      <label>
      <input type="radio" name="type" value="1" checked>
      电 脑      </label>
      <label>
      <input type="radio" name="type" value="2">
      其 他      </label></td>
  </tr>  
  <tr>
    <td height="28" valign="middle"><strong>报修地点：
      <label>
      <input type="text" name="address" size=20>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      报修内容：
      <label>
      <textarea name=content cols="24" rows="4"></textarea>
      </label>
    </strong></td>
  </tr>
  <tr><td align=center height=28 valign=bottom>
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
case 'editrepair':
if ($close==1){
  echo "  <script language='JavaScript'>  
             window.close();
          </script>
       ";
   exit;  
}
//记录数据的读取
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
    <td height="28" valign="middle"><strong>报修分类：</strong>
      <label>
      <label>
      <input type="radio" name="type" value="1" <? if ($edit_type==1) echo "checked";?>>
      电 脑      </label>
      <label>
      <input type="radio" name="type" value="2" <? if ($edit_type==2) echo "checked";?>>
      其 他      </label></td>
  </tr>  
  <tr>
    <td height="28" valign="middle"><strong>报修地点：
      <label>
      <input type="text" name="address" size=20 value="<?=$edit_address;?>">
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      报修内容：
      <label>
      <textarea name=content cols="24" rows="4"><?=$edit_content;?></textarea>
      </label>
    </strong></td>
  </tr>
  <tr><td align=center height=28 valign=bottom>
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
      维修中      
      <input type="radio" name="state" value="2">
      送外维修     	
      <input type="radio" name="state" value="3">
      完成维修   </label><p>
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
<body topmargin="0" leftmargin="0" rightMargin="0">
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
<body topmargin="0" leftmargin="0" rightMargin="0">
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