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
$error=0;
//<-------����ͨ��GET�����ύ�ı���;����-------->
if($year<1971)
{ 
    $error="����!<BR><a href=$HTTP_SERVER_VARS[PHP_SELF]>Back</a>";
    exit();
}
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

$nextyear="<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year-1)."&month=".$month.">&lt;&lt;</a>��<a href=./index.php?filename=calendar&inputname=$inputname&year=".($year+1)."&month=".$month.">&gt;&gt;</a>";
$nextm="<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month-1)."&year=".$year.">&lt;&lt;</a>��<a href=./index.php?filename=calendar&inputname=$inputname&month=".($month+1)."&year=".$year.">&gt;&gt;</a>";
//<--------��һ��,��һ��,����,���µ����Ӵ������;����--------->
$d=date("d");
$day=date("w",mktime(0,0,0,$month,1,$year));//ȡ���κ�һ���µ�һ�������ڼ�,���ڼ���һ�����ɱ��ĵڼ���ʼ
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
                $bgcolor="";
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
for($i=0;$i<=$showday;$i++)//��for�������ĳ���µ�һ��λ��
{
    for($i;$i<$showday;$i++)
    {
                $showday.="<td align=center height=50> </td>\n";
    }
    if($i==$showday)
    {
                $showday.="<td height=50 align=center ".bgcolor($month,$bgtoday,1,$year)." background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,1,$year).">".font_style($month,1,$year)."<a href=# onclick=get(\"1\")>1</a></font></td>\n";
                if($showday==6)//�ж�1���Ƿ�������
                {
                        $showday.="</tr><tr>";
                }
    }
}
$countMonth=date("t",mktime(0,0,0,$month,1,$year));//ĳ�µ�������
for($i=2;$i<=$countMonth;$i++)//�����1�Ŷ�λ,���2��ֱ����β�����к���

{
    $showday.="<td height=50 align=center ".bgcolor($month,$bgtoday,$i,$year)."  background=\"./templates/$style/images/calendartd.gif\"><font color=".font_color($month,$i,$year).">".font_style($month,$i,$year)."<a href=# onclick=get(\"$i\")>$i</a></font></td>\n";
    if(date("w",mktime(0,0,0,$month,$i,$year))==6)//�жϸ����Ƿ�������

    {
        $showday.="</tr><tr>\n";
    }
}
?>
<script language='JavaScript'>   
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#E7E7E7" style="font-size:12px;" align="center">
<tr align="center">
	 <td colspan="2"><?=$nextyear;?></td>
	 <td colspan="3"><?=$year."��".$month."��";?></td>
	 <td colspan="2"><?=$nextm;?></td>
</tr>
<tr>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14% height=50><font color="red">��</font></td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>һ</td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>��</td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>��</td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>��</td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>��</td>
	 <td align=center background="./templates/<?=$style;?>/images/calendarweek.gif" width=14%>��</td>
</tr>
<tr>
<?=$showday;?>
</tr>
</table>
</body>