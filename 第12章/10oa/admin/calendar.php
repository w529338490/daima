<?php
/*
����ɽ��Сѧ����칫��
*/
error_reporting(0);
global $HTTP_GET_VARS;
//<-------����ͨ��GET�����ύ�ı���;��ʼ-------->

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
//<-------����ͨ��GET�����ύ�ı���;����-------->

if($year<1971)
{ 
    echo "����!";
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
//<-------���·ݳ���1��12ʱ�Ĵ���;��ʼ------->

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
//<-------���·ݳ���1��12ʱ�Ĵ���;����------->

//***************************************

//<---------��һ��,��һ��,����,���µ����Ӵ������;��ʼ--------->

echo "<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year-1)."&month=".$month.">&lt;&lt;</a>��<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year+1)."&month=".$month.">&gt;&gt;</a>";
?>
</td><td colspan="3"><?php echo $year."��".$month."��";?>
</td><td colspan="2">
<?php 
echo "<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month-1)."&year=".$year.">&lt;&lt;</a>��<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month+1)."&year=".$year.">&gt;&gt;</a>";
//<--------��һ��,��һ��,����,���µ����Ӵ������;����--------->

   ?></td></tr>
<tr align=center>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24><font color="red">��</font></td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>һ</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>��</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>��</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>��</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>��</td>
	 <td background="./templates/<?=$style;?>/images/calendarweek.gif" width=24>��</td>
</tr>
<tr>
<?php
$d=date("d");
$FirstDay=date("w",mktime(0,0,0,$month,1,$year));//ȡ���κ�һ���µ�һ�������ڼ�,���ڼ���һ�����ɱ��ĵڼ���ʼ

$bgtoday=date("d");
function font_color($month,$today,$year)//���ڼ����������������ɫ

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
function bgcolor($month,$bgtoday,$today_i,$year)//���ڼ��㵱�յı�����ɫ

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
function font_style($month,$today,$year)//���ڼ����������������

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
for($i=0;$i<=$FirstDay;$i++)//��for�������ĳ���µ�һ��λ��

{
    for($i;$i<$FirstDay;$i++)
    {
                echo "<td align=center  class=td1>&nbsp; </td>\n";
    }
    if($i==$FirstDay)
    {
                //echo "<td align=center ".bgcolor($month,$bgtoday,1,$year)." background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."<a href=# onclick=get(\"1\")>1</a></font></td>\n";
                echo "<td align=center ".bgcolor($month,$bgtoday,1,$year)."  onclick=get(\"1\") style=\"cursor:hand\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."1</font></td>\n";
                if($FirstDay==6)//�ж�1���Ƿ�������

                {
                        echo "</tr>";
                }
    }
}
$countMonth=date("t",mktime(0,0,0,$month,1,$year));//ĳ�µ�������

for($i=2;$i<=$countMonth;$i++)//�����1�Ŷ�λ,���2��ֱ����β�����к���

{
   // echo "<td align=center ".bgcolor($month,$bgtoday,$i,$year)."  background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."<a href=# onclick=get(\"$i\")>$i</a></font></td>\n";
    echo "<td  align=center ".bgcolor($month,$bgtoday,$i,$year)." style=\"cursor:hand\" onclick=get(\"$i\")><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."$i</font></td>\n";
    if(date("w",mktime(0,0,0,$month,$i,$year))==6)//�жϸ����Ƿ�������

    {
        echo "</tr>\n";
    }
}
?>


