<?php

/************************************************************/
//设置班级
switch($school_type){
	case '1':
		$gradearr=array("1"=>"小一","2"=>"小二","3"=>"小三","4"=>"小四","5"=>"小五","6"=>"小六");
		break;
	case '2':
		$gradearr=array("1"=>"初一","2"=>"初二","3"=>"初三");
		break;
	case '3':
		$gradearr=array("1"=>"高一","2"=>"高二","3"=>"高三");
		break;
	case '12':
		$gradearr=array("1"=>"小一","2"=>"小二","3"=>"小三","4"=>"小四","5"=>"小五","6"=>"小六","7"=>"初一","8"=>"初二","9"=>"初三");
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
   		alert("请选择年级!");
		theform.grade.focus();
		return false ;
   }
     if(theform.nonum1.value ==0)
   {
   		alert("请选择章节!");
		theform.nonum1.focus();
		return false ;
   }
    if(theform.nonum2.value ==0)
   {
   		alert("请选择章节!");
		theform.nonum2.focus();
		return false ;
   }
   if(theform.title.value == "")
   {
   		alert("请填写实验名称!");
		theform.title.focus();
		return false ;
   }

  if(theform.content.value == "")
   {
   		alert("请填写实验器材和物品!");
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
    <td height="28" valign="middle"><strong>年级：</strong>
     <select name=grade>
       <option value=0>请选择</option>
     <?=$grade;?>                    	
     </select>
     <strong>章节：</strong>
     <select name=nonum1>
       <option value=0>请选择</option>
       <option value=1>第一章</option>
       <option value=2>第二章</option>
       <option value=3>第三章</option>   
       <option value=4>第四章</option>
       <option value=5>第五章</option>
       <option value=6>第六章</option> 
       <option value=7>第七章</option>
       <option value=8>第八章</option>
       <option value=9>第九章</option>                   	
       <option value=10>第十章</option> 
     </select>
     <select name=nonum2>
       <option value=0>请选择</option>
       <option value=1>第一节</option>  
       <option value=2>第二节</option>                  	
       <option value=3>第三节</option> 
       <option value=4>第四节</option> 
       <option value=5>第五节</option> 
       <option value=6>第六节</option> 
       <option value=7>第七节</option> 
       <option value=8>第八节</option> 
       <option value=9>第九节</option> 
       <option value=10>第十节</option> 
       
     </select>
   </td>
  </tr> 
      </label></td>
  </tr>   
  <tr>
    <td height="28" valign="middle"><strong>实验名称：
      <label>
      <input type="text" name="title" size=30>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      实验器材：
      <label>
      <textarea name=content cols="28" rows="4"></textarea>
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
   		alert("请选择年级!");
		theform.grade.focus();
		return false ;
   }
     if(theform.nonum1.value ==0)
   {
   		alert("请选择章节!");
		theform.nonum1.focus();
		return false ;
   }
    if(theform.nonum2.value ==0)
   {
   		alert("请选择章节!");
		theform.nonum2.focus();
		return false ;
   }
   if(theform.title.value == "")
   {
   		alert("请填写实验名称!");
		theform.title.focus();
		return false ;
   }

  if(theform.content.value == "")
   {
   		alert("请填写实验器材和物品!");
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
    <td height="28" valign="middle"><strong>年级：</strong>
     <select name=grade>
       <option value=0>请选择</option>
       <?=$grade;?>                     	
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.grade;
                     Obj.value=<?=$gradeid;?>;
               </SCRIPT>
     <strong>章节：</strong>
     <select name=nonum1>
       <option value=0>请选择</option>
       <option value=1>第一章</option>
       <option value=2>第二章</option>
       <option value=3>第三章</option>   
       <option value=4>第四章</option>
       <option value=5>第五章</option>
       <option value=6>第六章</option> 
       <option value=7>第七章</option>
       <option value=8>第八章</option>
       <option value=9>第九章</option>                   	
       <option value=10>第十章</option> 
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum1;
                     Obj.value=<?=$nonum1;?>;
               </SCRIPT>
     <select name=nonum2>
       <option value=0>请选择</option>
       <option value=1>第一节</option>  
       <option value=2>第二节</option>                  	
       <option value=3>第三节</option> 
       <option value=4>第四节</option> 
       <option value=5>第五节</option> 
       <option value=6>第六节</option> 
       <option value=7>第七节</option> 
       <option value=8>第八节</option> 
       <option value=9>第九节</option> 
       <option value=10>第十节</option> 
       
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
    <td height="28" valign="middle"><strong>实验名称：
      <label>
      <input type="text" name="title" size=30 value=<?=$edit_title;?>>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      实验器材：
      <label>
      <textarea name=content cols="28" rows="4"><?=$edit_content;?></textarea>
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
case 'showcontent':
//记录数据的读取
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
    <td height="28" valign="middle"><strong>年级：</strong>
     <select name=grade>
       <option value=0>请选择</option>
<?=$grade;?>                    	
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.grade;
                     Obj.value=<?=$gradeid;?>;
               </SCRIPT>
     <strong>章节：</strong>
     <select name=nonum1>
       <option value=0>请选择</option>
       <option value=1>第一章</option>
       <option value=2>第二章</option>
       <option value=3>第三章</option>   
       <option value=4>第四章</option>
       <option value=5>第五章</option>
       <option value=6>第六章</option> 
       <option value=7>第七章</option>
       <option value=8>第八章</option>
       <option value=9>第九章</option>                   	
       <option value=10>第十章</option> 
     </select>
                   <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.nonum1;
                     Obj.value=<?=$nonum1;?>;
               </SCRIPT>
     <select name=nonum2>
       <option value=0>请选择</option>
       <option value=1>第一节</option>  
       <option value=2>第二节</option>                  	
       <option value=3>第三节</option> 
       <option value=4>第四节</option> 
       <option value=5>第五节</option> 
       <option value=6>第六节</option> 
       <option value=7>第七节</option> 
       <option value=8>第八节</option> 
       <option value=9>第九节</option> 
       <option value=10>第十节</option> 
       
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
    <td height="28" valign="middle"><strong>实验名称：
      <label>
      <input type="text" name="title" size=30 value=<?=$edit_title;?>>
      </label>
    </strong></td>
  </tr>
  <tr>
    <td height="28" valign="top"><strong>
      <label>      </label>
      实验器材：
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
      准备好  
      <input type="radio" name="state" value="2">
      使用中	
      <input type="radio" name="state" value="3">
      已归还
      </label><p>
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
case 'delrepair':
$query="select * from $table_content where id=$id limit 1";
$r=$db->query_first($query);
if ($r[state]>0)$state_t="<font color=red>实验已经开始中,如要取消,请和实验员联系!</font>";
else $sub="<input type=\"submit\" name=\"submit\" value=\"确定\">";
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
    	真的要取消你此次申请的实验器材和物品?<p><?=$state_t;?><p>
    	<input type=hidden name=id value=<?=$id;?>>
      <?=$sub;?>
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