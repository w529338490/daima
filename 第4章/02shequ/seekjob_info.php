<link href="css/style.css" rel="stylesheet">
<?php 
include("conn/conn.php");
?>
<table width="563" height="587" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="563" height="587" valign="top" bgcolor="#FFFFFF"><table width="563" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="563" height="27" background="Images/fufei.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="96" align="center" valign="top"><br>
          <?php
			$date1=date("Y-m-d");
			$sgsql=mysql_query("select * from tb_leaguerinfo  where type='��ְ��Ϣ' and showday>='$date1' and checkstate=1 ");
			$sginfo=mysql_fetch_array($sgsql);
			if($sginfo){
			do{
			?>
          <table width="540" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="26"><span class="style1">����ְ��Ϣ��</span><span class="style8">&nbsp;<?php echo $sginfo[title];?>&nbsp;</span><span class="style6">&nbsp;<?php echo $sginfo[edate];?></span></td>
            </tr>
            <tr>
              <td height="26">&nbsp;&nbsp;&nbsp;<span class="style5">&nbsp;<?php echo $sginfo[content];?></span></td>
            </tr>
            <tr>
              <td height="26">&nbsp;<span class="style8">��ϵ�ˣ�<?php echo $sginfo[linkman];?>&nbsp;&nbsp;&nbsp;��ϵ�绰��<?php echo $sginfo[tel];?></span></td>
            </tr>
            <tr>
              <td height="3" background="Images/line1.gif"></td>
            </tr>
          </table>
          <?php
			}while($sginfo=mysql_fetch_array($sgsql));
			}else{
		  ?>
          <table width="540" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center">������ְ��Ϣ��Դ��</td>
            </tr>
          </table>
          <?php
}
?></td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="560" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="87" background="Images/guanggao.gif">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="27" background="Images/mian.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="140" align="center" valign="top">
<br>
<?php
$sql=mysql_query("select count(*) as total from tb_info where type='��ְ��Ϣ' and checkstate=1");
$info=mysql_fetch_array($sql);
$total=$info[total];
$pagesize=4;
 if ($total<=$pagesize){
    $pagecount=1;
 } 
if(($total%$pagesize)!=0){
  $pagecount=intval($total/$pagesize)+1;
}else{
 $pagecount=$total/$pagesize;
}
if(($_GET[page])==""){
  $page=1;
}else{
$page=intval($_GET[page]);
}
$gsql=mysql_query("select * from tb_info where type='��ְ��Ϣ' and checkstate=1 order by edate desc limit ".($page-1)*$pagesize.",$pagesize");
$ginfo=mysql_fetch_array($gsql);
if($ginfo){
  do{
?>
          <table width="540" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="26"><span class="style1">����ְ��Ϣ��</span><span class="style8">&nbsp;<?php echo $ginfo[title];?>&nbsp;</span><span class="style6">&nbsp;<?php echo $ginfo[edate];?></span></td>
            </tr>
            <tr>
              <td height="26">&nbsp;&nbsp;&nbsp;<span class="style5">&nbsp;<?php echo $ginfo[content];?></span></td>
            </tr>
            <tr>
              <td height="26">&nbsp;<span class="style8">��ϵ�ˣ�<?php echo $ginfo[linkman];?>&nbsp;&nbsp;&nbsp;��ϵ�绰��<?php echo $ginfo[tel];?></span></td>
            </tr>
            <tr>
              <td height="3" background="Images/line1.gif"></td>
            </tr>
          </table>
<?php
}while($ginfo=mysql_fetch_array($gsql));
?>
<table width="543" height="27" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="543" height="27" colspan="3" align="right"> &nbsp; ����&nbsp;
        <?php
		   echo $total;
		  ?>
&nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
      <?php
		  if($page>=2){
		  ?>
      <a href="seekjob.php?page=1" title="��ҳ"></a><a href="seekjob.php?page=<?php echo $page-1;?>" title="ǰһҳ"></a>
      <?php
		  }
		   if($pagecount<=4){
		    for($i=1;$i<=$pagecount;$i++){
		  ?>
      <a href="seekjob.php?page=<?php echo $i;?>"><?php echo $i;?></a>
      <?php
		     }
		   }else{
		   for($i=1;$i<=4;$i++){	 
		  ?>
      <a href="seekjob.php?page=<?php echo $i;?>"><?php echo $i;?></a>
      <?php }?>
      <a href="seekjob.php?page=<?php echo $page-1;?>" title="��һҳ"></a> <a href="seekjob.php?page=<?php echo $pagecount;?>" title="βҳ"></a>
      <?php }?></td>
  </tr>
</table>
<?php
}
else{
?>
<table width="540" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">������ְ��Ϣ��Դ��</td>
  </tr>
</table>
<?php
}
?>
</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
