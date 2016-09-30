<?php
/*
凤鸣山中小学网络办公室
*/
error_reporting(0);
global $HTTP_GET_VARS;
//<-------处理通过GET方法提交的变量;开始-------->

if($HTTP_GET_VARS['year']=="")
{
    $HTTP_GET_VARS['year']=date("Y");
}
if($HTTP_GET_VARS['month']=="")
{
    $HTTP_GET_VARS['month']=date("n");
}
$month=$HTTP_GET_VARS['month'];
$year=$HTTP_GET_VARS['year'];
//<-------处理通过GET方法提交的变量;结束-------->

if($year<1971)
{ 
    echo "出错!";
    echo "<BR>";
    echo "<a href=$HTTP_SERVER_VARS[PHP_SELF]>Back</a>";
    exit();
}
?>
<script language='JavaScript'>   
function get(day){	
   var tbl = window.opener.document.form1;
       tbl.<?=$inputname;?>.value="<?=$year?>-<?=$month?>-"+day;   
   window.close();
  }
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="200" border="1" cellspacing="0" cellpadding="0" bordercolor="#E7E7E7" style="font-size:12px;" align="center">
<tr align="center"><td colspan="2">
<?php 
//<-------当月份超出1至12时的处理;开始------->

if($month<1)
{
    $month=12;
    $year-=1;
}
if($month>12)
{
    $month=1;
    $year+=1;
}
//<-------当月份超出1至12时的处理;结束------->

//***************************************

//<---------上一年,下一年,上月,下月的连接处理及输出;开始--------->

echo "<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year-1)."&month=".$month.">&lt;&lt;</a>年<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year+1)."&month=".$month.">&gt;&gt;</a>";
?>
</td><td colspan="3"><?php echo $year."年".$month."月";?>
</td><td colspan="2">
<?php 
echo "<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month-1)."&year=".$year.">&lt;&lt;</a>月<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month+1)."&year=".$year.">&gt;&gt;</a>";
//<--------上一年,下一年,上月,下月的连接处理及输出;结束--------->

   ?></td></tr>
<tr align=center>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24><font color="red">日</font></td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>一</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>二</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>三</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>四</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>五</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>六</td>
</tr>
<tr>
<?php
$d=date("d");
$FirstDay=date("w",mktime(0,0,0,$month,1,$year));//取得任何一个月的一号是星期几,用于计算一号是由表格的第几格开始

$bgtoday=date("d");
function font_color($month,$today,$year)//用于计算星期天的字体颜色

{
    $sunday=date("w",mktime(0,0,0,$month,$today,$year));
    if($sunday=="0")
    {
                $FontColor="red";
    }
    else
    {
                $FontColor="black";
    }
    return $FontColor;
}
function bgcolor($month,$bgtoday,$today_i,$year)//用于计算当日的背景颜色

{
    $show_today=date("d",mktime(0,0,0,$month,$today_i,$year));
    $sys_today=date("d",mktime(0,0,0,$month,$bgtoday,$year));
    if($show_today==$sys_today)
    {
                $bgcolor="bgcolor=#6699FF";
    }
    else
    {
                $bgcolor="class=td1";
    }
    return $bgcolor;
}
function font_style($month,$today,$year)//用于计算星期天的字体风格

{
    $sunday=date("w",mktime(0,0,0,$month,$today,$year));
    if($sunday=="0")
    {
                $FontStyle="<strong>";
    }
    else
    {
                $FontStyle="";
    }
    return $FontStyle;
}
for($i=0;$i<=$FirstDay;$i++)//此for用于输出某个月的一号位置

{
    for($i;$i<$FirstDay;$i++)
    {
                echo "<td align=center  class=td1>&nbsp; </td>\n";
    }
    if($i==$FirstDay)
    {
                //echo "<td align=center ".bgcolor($month,$bgtoday,1,$year)." background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."<a href=# onclick=get(\"1\")>1</a></font></td>\n";
                echo "<td align=center ".bgcolor($month,$bgtoday,1,$year)."  onclick=get(\"1\") style=\"cursor:hand\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."1</font></td>\n";
                if($FirstDay==6)//判断1号是否星期六

                {
                        echo "</tr>";
                }
    }
}
$countMonth=date("t",mktime(0,0,0,$month,1,$year));//某月的总天数

for($i=2;$i<=$countMonth;$i++)//输出由1号定位,随后2号直至月尾的所有号数

{
   // echo "<td align=center ".bgcolor($month,$bgtoday,$i,$year)."  background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."<a href=# onclick=get(\"$i\")>$i</a></font></td>\n";
    echo "<td  align=center ".bgcolor($month,$bgtoday,$i,$year)." style=\"cursor:hand\" onclick=get(\"$i\")><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."$i</font></td>\n";
    if(date("w",mktime(0,0,0,$month,$i,$year))==6)//判断该日是否星期六

    {
        echo "</tr>\n";
    }
}
?>


