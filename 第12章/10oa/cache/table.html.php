<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
<title>凤鸣山中小学校网络办公室</title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<SCRIPT type=text/javascript>
var OA_TIME = new Date();
function timeview()
{
  timestr=OA_TIME.toLocaleString();
  timestr=timestr.substr(timestr.indexOf(":")-2);
  document.getElementById("time_area").innerHTML = timestr;
  OA_TIME.setSeconds(OA_TIME.getSeconds()+1);
  window.setTimeout( "timeview()", 1000 );
}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" BACKGROUND=ffffff onLoad="timeview();">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <!--DWLayoutTable-->
  <tr> 
  	<!--左边显示的代码-->
    <td width="70%"   valign="top" class=tableleft align=left>
      <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
       <tr> 
       	<td align=center>    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table>
      <!--今日信息-->
       <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class=tableborder>
       <!--DWLayoutTable-->    
          <tr> 
       	  <td>   
        	 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
            <!--DWLayoutTable-->
            <tr> 
         	<td class=main_title><img src="./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/mytable.gif" height=20 width="20" align="absmiddle">
           <font color=red> 今日信息</font>
           </td>	
           </tr>  
             </table> 
        </td>	
       </tr>  
       <tr> 
       	<td>
       	 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       	   <?php 
$_from = $this->ftpl_var['today_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?> 
          <tr  valign=middle>
		 <td align=left height=20 class=td2><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/<?php echo $this->ftpl_var['cont']['img'];?>.gif border=0 align=absmiddle>[<?php echo $this->ftpl_var['cont']['typename'];?>] <a href=?filename=show&id=<?php echo $this->ftpl_var['cont']['articleid'];?> target=_blank><?php echo $this->ftpl_var['cont']['includepic'];?><?php echo $this->ftpl_var['cont']['title'];?>【<?php echo $this->ftpl_var['cont']['managename'];?>】</a><?php echo $this->ftpl_var['cont']['date_d'];?></td>			
		 </tr>
		 <?php
    }
}
else{
 unset($_form);?>
		    <tr  valign=middle>
			   <td align=left height=20 class=td2>今日无信息</td>			
			 </tr> 
		 <?php  
}
?>
		  </table>
        </td>	
       </tr>  
                 <tr> 
       	  <td>   
        	 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
            <!--DWLayoutTable-->
            <tr> 
         	<td class=main_foot>
           </td>	
           </tr>  
             </table> 
        </td>	
       </tr>  
      </table> 
     <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
  <!--行政通知 工作安排 会议通知 资料下载 -->
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder >
		   <tr>
         <td valign="top" class=td_head_bg_5>  
           <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 >
              <TBODY>         
              <SCRIPT language=JavaScript> 
                        var aID=0;
                        var max_ID=<?php echo $this->ftpl_var['max_id'];?>;
                        var inter=null;
                        inter=setInterval(next,5000);
                        function ShowTabs1(ID){
                        if(ID!=aID){
                        TabTitle1[aID].className="news_menu_title2";
                        TabTitle1[ID].className="news_menu_title1";
                        Tabs1[aID].style.display="none";
                        Tabs1[ID].style.display="block";
                        aID=ID;
                             }
                        }
                        function next()
                        {
                        id=aID+1;
                        if(id>max_ID){id=0;};
                        ShowTabs1(id);
                        }
              </SCRIPT>
              <TR vAlign=bottom align=left height=32 class=main_title>
              	<TD align=middle width=18>&nbsp;</TD>
              <?php 
$_from = $this->ftpl_var['tab_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid0'] => $this->ftpl_var['cont']){
?>
              <TD width=70  class=<?php
if($this->ftpl_var['cont']['id']==0){
?>news_menu_title1 <?php
}
else
{
?>news_menu_title2<?php
}
?> id=TabTitle1 onmouseover=javascript:clearInterval(inter);ShowTabs1(<?php echo $this->ftpl_var['cont']['id'];?>); onmouseout=javascript:inter=setInterval(next,2500); vAlign=bottom align=middle >
                <STRONG><?php echo $this->ftpl_var['cont']['title'];?></STRONG></TD>              
              <?php
}
		unset($_form);
		
} ?>
                <TD align=middle>&nbsp;</TD>
              </TR>
              <TR align=middle>
                <TD align=middle  colSpan=3 height=1 bgcolor=#5da1e2><TD align=middle  colSpan=<?php echo $this->ftpl_var['max_id'];?> height=1 bgcolor=#5da1e2></TD>
              </TR>
            </TBODY>
            </TABLE>  
           </td>
		  </tr>              
            <!--DWLayoutTable-->
             <?php 
$_from = $this->ftpl_var['tab_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['tabid'] => $this->ftpl_var['cont1']){
?>
             <TBODY id=Tabs1 style="DISPLAY: <?php echo $this->ftpl_var['cont1']['isfirst'];?>">
              <TR width="100%" >
                 <TD  vAlign=top align=left height=160 width="100%" >
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                    <TBODY>
              <?php 
$_from = $this->ftpl_var['tab_content'][$this->ftpl_var['tabid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid2'] => $this->ftpl_var['cont_tab']){
?>
                 <tr> 
                  <td width=90% height="20" valign=middle class=td2><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/<?php echo $this->ftpl_var['cont_tab']['img'];?>.gif border=0 align=absmiddle> <a href=?filename=show&id=<?php echo $this->ftpl_var['cont_tab']['articleid'];?> target=_blank><?php echo $this->ftpl_var['cont_tab']['includepic'];?><?php echo $this->ftpl_var['cont_tab']['title'];?></a><font color=green>【<?php echo $this->ftpl_var['cont_tab']['managename'];?>】</font></td>
                  <td width=10% valign=middle class=td2><?php echo $this->ftpl_var['cont_tab']['date_d'];?></td>
                  </tr>  	
               <?php
}
		unset($_form);
		
} ?>  
                  </TBODY>
              </TABLE>
             </TD>
          </TR>
       </TBODY>              
             <?php
}
		unset($_form);
		
} ?>
     </table>
    <table width=100% border=0 cellpadding=0 cellspacing=0 >
    <!--行政通知 工作安排 会议通知 资料下载 结束-->
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
       <!--请假信息-->
       <table width=100% border=0 cellpadding=0 cellspacing=0 class=tableborder>
       <!--DWLayoutTable-->
       <tr>
         <td>
       <table width=100% border=0 cellpadding=0 cellspacing=0 >
       <!--DWLayoutTable-->
       <tr>
        <td colspan=5>
        <table width=100% border=0 cellpadding=0 cellspacing=0 >
          <tr>
            <td class=main_title><img src="./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/mytable.gif" height=20 width="20" align="absmiddle"> 公病事假<font color=red>(今日)</font></td>
          </tr>
        </table>
        </td>
       </tr>
       <tr>
        <td   valign=middle align=center class=table_tr height=20 width=10%>类型</td>
        <td   valign=middle align=center class=table_tr width=20%>请假者</td>
        <td   valign=middle align=center class=table_tr width=40%>原因</td>
        <td   valign=middle align=center class=table_tr>开始日期</td>
        <td   valign=middle align=center class=table_tr>结束日期</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['leavelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid3'] => $this->ftpl_var['cont_l']){
?> 
     	<tr  valign=middle>
			<td align=center class=td2 height=20><?php echo $this->ftpl_var['cont_l']['leavetypeid'];?></td>
			<td align=center class=td2 ><?php echo $this->ftpl_var['cont_l']['leaver'];?></td>
			<td align=center class=td2 ><?php echo $this->ftpl_var['cont_l']['reason'];?></td>
			<td align=center class=td2><?php echo $this->ftpl_var['cont_l']['stime'];?></td>		
			<td align=center class=td2><?php echo $this->ftpl_var['cont_l']['etime'];?></td>			
		</tr> 
	 <?php
}
		unset($_form);
		
} ?>		           
     </table>
     </td>
        </tr>
     </table>         
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
      <?php 
$_from = $this->ftpl_var['typelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid4'] => $this->ftpl_var['cont_g']){
?> 
     <table width=100% border=0 cellpadding=0 cellspacing=0 class=tableborder>
       <!--公共教室-->
       <tr>
         <td>
       <table width=100% border=0 cellpadding=0 cellspacing=0 >
       <!--DWLayoutTable-->
       <tr>
        <td colspan=4>
        <table width=100% border=0 cellpadding=0 cellspacing=0 >
          <tr>
            <td class=main_title height=24><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/mytable.gif height=20 width=20 align=absmiddle><?php echo $this->ftpl_var['cont_g']['typetitle'];?><font color=red>(今日)</font></td>
          </tr>
        </table>
        </td>
       </tr>
       <tr>
        <td   valign=middle align=center class=table_tr height=20 width=20%>教师</td>
        <td   valign=middle align=center class=table_tr width=20%>班级</td>
        <td   valign=middle align=center class=table_tr width=40%>公共教室</td>
        <td   valign=middle align=center class=table_tr>课次</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['re_list'][$this->ftpl_var['keyid4']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid6'] => $this->ftpl_var['cont_class']){
?> 
       <tr valign=middle>
			 <td align=center class=td2 height=20><?php echo $this->ftpl_var['cont_class']['realname'];?></td>
			 <td align=center class=td2 ><?php echo $this->ftpl_var['cont_class']['grade'];?></td>
			 <td align=center class=td2 ><?php echo $this->ftpl_var['cont_class']['name'];?></td>	
			 <td align=center class=td2>第<?php echo $this->ftpl_var['cont_class']['nonumber'];?>节课</td>			
		 </tr> 
		 <?php
}
		unset($_form);
		
} ?>		           
     </table>
     </td>
        </tr>
     </table>
     <table width=100% border=0 cellpadding=0 cellspacing=0 >
        <tr>
          <td height=5 bgcolor=#FCEFDF></td>
        </tr>
     </table>
     <?php
}
		unset($_form);
		
} ?>
     <table width=100% border=0 cellpadding=0 cellspacing=0 >
        <tr>
          <td height=5 bgcolor=#FCEFDF></td>
        </tr>
     </table>
        </td>	
       </tr>  
      </table> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="30">
        </td>	
       </tr>  
      </table> 
    </td>
    <!--右边显示的代码-->
    <td width="29%"  valign="top" align=left  >
    	<table width="98%" border="0" cellpadding="0" cellspacing="0" align="left" >
       <!--DWLayoutTable-->
       <tr> 
       	<td valign=top width=100% align=left>
       		 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
       		<!--气象预报-->
       		<table width=100%  border=0 cellpadding=0 cellspacing=0 class=tableborder>
            <tr>
          <td align=middle valign=top >
        <table width=100%   border=0 cellpadding=0 cellspacing=0 >
        	         <tr>
          <td  class=main_title>气象预报</td>
        </tr>
            <tr>
          <td align=middle valign=top><iframe src="http://weather.265.com/weather.htm" width="100%" height="54" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no"></iframe></td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
       <table width=100% border=0 cellpadding=0 cellspacing=0 >
             <tr>
            <td class=tablerow height=40 align=center><span style="PADDING-TOP:2px;color:#000000; WIDTH: 100%; FONT-SIZE: 9pt;">
          <SCRIPT language=JavaScript>
var day="";
var month="";
var ampm="";
var ampmhour="";
var myweekday="";
var year="";
mydate=new Date();
myweekday=mydate.getDay();
mymonth=mydate.getMonth()+1;
myday= mydate.getDate();
myyear= mydate.getYear();
year=(myyear > 200) ? myyear : 1900 + myyear;
if(myweekday == 0)
weekday=" 星期日 ";
else if(myweekday == 1)
weekday=" 星期一 ";
else if(myweekday == 2)
weekday=" 星期二 ";
else if(myweekday == 3)
weekday=" 星期三 ";
else if(myweekday == 4)
weekday=" 星期四 ";
else if(myweekday == 5)
weekday=" 星期五 ";
else if(myweekday == 6)
weekday=" 星期六 ";
document.write(year+"年"+mymonth+"月"+myday+"日"+weekday);
      </SCRIPT>
          <img src="./templates/test/images/time.gif" align="absmiddle">
        <span id="time_area"></span>&nbsp;
        </span>
</td>
            </tr>
        </table>
          <table width=100% border=0 cellpadding=0 cellspacing=0 class=tableborder align=center>
         <!-- 待办提醒-->
           <tr>
           <td> 
            <table width=100% border=0 cellpadding=0 cellspacing=0 >
             <tr>
            <td class=main_title> 今日事务</td>
            </tr>
        </table>
        </td></tr>
              <?php 
$_from = $this->ftpl_var['t_calendar_code']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['contt']){
?> 
       <tr  valign=middle>
			<td align=left class=td2 height=20><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/<?php echo $this->ftpl_var['contt']['img'];?>.gif border=0 align=absmiddle> <a href=?filename=show&action=s&id=<?php echo $this->ftpl_var['contt']['id'];?> target=_blank><font color=red><?php echo $this->ftpl_var['contt']['title'];?> <?php echo $this->ftpl_var['contt']['intime'];?></font></a></td>				
			 </tr> 
			 <?php
}
		unset($_form);
		
} ?>
     </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
       <!--间隔-->
       <tr> 
       	<td height="5">
        </td>	
       </tr>  
      </table> 
              <table width=100% border=0 cellpadding=0 cellspacing=0 class=tableborder align=center>
         <!-- 待办提醒-->
           <tr>
           <td> 
            <table width=100% border=0 cellpadding=0 cellspacing=0 >
             <tr>
            <td class=main_title> 待办提醒</td>
            </tr>
        </table>
        </td></tr>
        <?php 
$_from = $this->ftpl_var['calendar_code']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['contd']){
?> 
       <tr  valign=middle>
			<td align=left class=td2 height=20><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/<?php echo $this->ftpl_var['contd']['img'];?>.gif border=0 align=absmiddle> <a href=?filename=show&action=s&id=<?php echo $this->ftpl_var['contd']['id'];?> target=_blank><?php echo $this->ftpl_var['contd']['title'];?> <?php echo $this->ftpl_var['contd']['intime'];?></a></td>				
			 </tr> 
			 <?php
}
		unset($_form);
		
} ?>
     </table>
     <table width=100% border=0 cellpadding=0 cellspacing=0 >
        <tr>
          <td height=5></td>
        </tr>
     </table>	
        </td>	
       </tr>  
      </table> 
    </td>	
  </tr>  
</table>  
</body>	
</html>