<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../css/style.css" rel="stylesheet">
<?php
include("../conn/conn.php");
$state=$_POST[state];
$type=$_POST[type];
if($_POST[type]==""){
$state=$_GET[state];
$type=$_GET[type];
}
if($state=="all"){
	$sql1=mysql_query("select count(*) as total from tb_info where type='$type' order by edate");
}else{
	$sql1=mysql_query("select count(*) as total from tb_info where type='$type' and checkstate=$state order by edate");
}
$minfo=mysql_fetch_array($sql1);
$total=$minfo[total];
$pagesize=10;
if($total<=$pagesize){
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
if($state=="all"){
	$sql=mysql_query("select * from tb_info where type='$type' order by edate limit ".($page-1)*$pagesize.",$pagesize");
}else{
	$sql=mysql_query("select * from tb_info where type='$type' and checkstate=$state order by edate limit ".($page-1)*$pagesize.",$pagesize");
}
$info=mysql_fetch_array($sql);
?>
<table width="776" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="32" background="images/right_line.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�����ڵ�λ�ã��Ĺ���������&nbsp;&gt;&nbsp;��̨����ϵͳ</td>
  </tr>
  <tr>
    <td height="32" background="images/right_top.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="488" align="center" valign="top" background="images/right_middle.gif">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ǰ��Ϣ���&nbsp;��<span class="style11">&nbsp;<?php echo $type;?>&nbsp;</span>��<br>
        <table width="708" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFCC33">
          <tr align="center" bgcolor="#FFCC33">
            <td width="111">��Ϣ����</td>
            <td width="203">��Ϣ����</td>
            <td width="63">��ϵ��</td>
            <td width="79">��ϵ�绰</td>
            <td width="125">����ʱ��</td>
            <td width="61">���״̬</td>
            <td width="58">����</td>
          </tr>
	<?php
	if($info){
	do{
		if($info[checkstate]==1){ 
			$state1="�����";
		}else{
			$state1="δ���";
		}
	?>
          <tr bgcolor="#FFFFFF">
            <td>&nbsp;<?php echo $info[title];?></td>
            <td>&nbsp;<?php echo $info[content];?></td>
            <td>&nbsp;<?php echo $info[linkman];?></td>
            <td>&nbsp;<?php echo $info[tel];?></td>
            <td>&nbsp;<?php echo $info[edate];?></td>
            <td align="center" class="style11"><?php echo $state1;?></td>
            <td align="center" bgcolor="#FFFFFF"><a href="state_ok.php?id=<?php echo $info[id];?>&type=<?php echo $type;?>&state=<?php echo $state;?>">���</a>/<a href="miandel_ok.php?id=<?php echo $info[id];?>&type=<?php echo $type;?>&state=<?php echo $state;?>">ɾ��</a></td>
          </tr>
	<?php
	}while($info=mysql_fetch_array($sql));
	?>
  <tr bgcolor="#FFFFDD">
    <td height="22" colspan="7" align="right"> &nbsp; ����&nbsp;
        <?php
		   echo $total;
		?>
&nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
      <?php
		  if($page>=2){
	  ?>
      <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=1" title="��ҳ"></a>
	  <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=<?php echo $page-1;?>" title="��һҳ"></a>
      <?php
		  }
	  if($pagecount<=4){
		 for($i=1;$i<=$pagecount;$i++){
	  ?>
      <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
      <?php
		 }
      }else{
	  for($i=1;$i<=4;$i++){	 
	  ?>
      <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
      <?php }?>
      <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=<?php echo $page-1;?>" title="��һҳ"></a>
	  <a href="find_mianfei.php?type=<?php echo $type;?>&state=<?php echo $state;?>&page=<?php echo $pagecount;?>" title="βҳ"></a>
      <?php }?>
      &nbsp;</td>
  </tr>
<?php
	}else{
?>
		<tr align="center" bgcolor="#FFFFFF"><td colspan="7">�Բ�������������Ϣ�����ڣ�</td>
		</tr>
<?php
}
?>
    </table></td>
  </tr>
  <tr>
    <td height="32" background="images/right_bottom.gif">&nbsp;</td>
  </tr>
</table>
