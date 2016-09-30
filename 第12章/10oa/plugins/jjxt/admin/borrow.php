<?php
/*
凤鸣山中小学网络办公室
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
       你没有权限对此进行操作，请你在注册后才能操作
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	如果有问题请与电教管理员联系
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      <input type="reset" name="reset" value="关闭此窗口" onClick="ret();">
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
       你预借了【<?=$r[name];?>】这份资料
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	请你在7日之内到电教管理员处完成借记登记
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	      <input type="submit" name="submit" value="确定">
      <input type="reset" name="reset" value="取消" onClick="ret();">
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
       你预借了【<?=$r[name];?>】这份资料已经借完
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	如果有问题请与电教管理员联系
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      <input type="reset" name="reset" value="关闭此窗口" onClick="ret();">
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
       同意〖<?=$r[realname];?>〗借【<?=$r[name];?>】这份资料
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="确定">
        <input type="reset" name="reset" value="取消" onClick="ret();">
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
       同意〖<?=$r[realname];?>〗归还【<?=$r[name];?>】这份资料
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="确定">
        <input type="reset" name="reset" value="取消" onClick="ret();">
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
       同意〖<?=$r[realname];?>〗取消
      </td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	【<?=$r[name];?>】这份资料的预借
      	</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>
      	<input type="hidden" name=id value=<?=$id;?>>
      	<input type="submit" name="submit" value="确定">
        <input type="reset" name="reset" value="取消" onClick="ret();">
    </td>
     </tr>          
  </table>           
</body>
<?
break;
}
?>