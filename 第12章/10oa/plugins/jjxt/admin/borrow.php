<?php
/*
����ɽ��Сѧ����칫��
*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){

                  } else {
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ��û��Ȩ�޶Դ˽��в�����������ע�����ܲ���
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	��������������̹���Ա��ϵ
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      <input type="reset" name="reset" value="�رմ˴���" onClick="ret();">
    </td>
     </tr>          
  </table>         
</body>
<?
                   exit;
                  };
switch($action) {
case 'preborrow':   
$query="select name,innumber from $table_product where id=$id limit 1";
$r=$db->query_first($query);
if ($r[innumber]>0){                                    
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="?filename=deal&action=preborrow&id=<?=$id;?>">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ��Ԥ���ˡ�<?=$r[name];?>���������
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	������7��֮�ڵ���̹���Ա����ɽ�ǵǼ�
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	      <input type="submit" name="submit" value="ȷ��">
      <input type="reset" name="reset" value="ȡ��" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>
<?
}else{
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ��Ԥ���ˡ�<?=$r[name];?>����������Ѿ�����
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	��������������̹���Ա��ϵ
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      <input type="reset" name="reset" value="�رմ˴���" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>	
<?	
}
break;
case 'borrow':   
$query="select $table_borrow.*,$table_product.name,members.realname 
        from `$table_borrow`  
        left join $table_product on $table_borrow.pid=$table_product.id  
        left join `members` on  members.userid=$table_borrow.author 
        where $table_borrow.id='$id' 
        order by id DESC 
        limit 1";  
$r=$db->query_first($query);                                  
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="?filename=deal&action=borrow">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ͬ�⡼<?=$r[realname];?>���衾<?=$r[name];?>���������
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="ȷ��">
        <input type="reset" name="reset" value="ȡ��" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>
<?
break;
case 'return':   
$query="select $table_borrow.*,$table_product.name,members.realname 
        from `$table_borrow`  
        left join $table_product on $table_borrow.pid=$table_product.id  
        left join `members` on  members.userid=$table_borrow.author 
        where $table_borrow.id='$id' 
        order by id DESC 
        limit 1";  
$r=$db->query_first($query);                                  
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="?filename=deal&action=return">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ͬ�⡼<?=$r[realname];?>���黹��<?=$r[name];?>���������
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="ȷ��">
        <input type="reset" name="reset" value="ȡ��" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>
<?
break;
case 'delborrow':   
$query="select $table_borrow.*,$table_product.name,members.realname 
        from `$table_borrow`  
        left join $table_product on $table_borrow.pid=$table_product.id  
        left join `members` on  members.userid=$table_borrow.author 
        where $table_borrow.id='$id' 
        order by id DESC 
        limit 1";  
$r=$db->query_first($query);                                  
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <form name="form1" method="post" action="?filename=deal&action=delborrow">
	   <TR vAlign=middle align=middle>
      <TD align=middle height=28>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
       ͬ�⡼<?=$r[realname];?>��ȡ��
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	��<?=$r[name];?>��������ϵ�Ԥ��
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="ȷ��">
        <input type="reset" name="reset" value="ȡ��" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>
<?
break;
}
?>