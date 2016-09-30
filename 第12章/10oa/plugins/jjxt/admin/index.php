<?php
/*凤鸣山中小学网络办公室*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){          
	    if ($group_id==1){
          	  $adminrepair=1; 
          	  $product=" | <a href=\"?filename=admin\">管 理</a>";
          }
	        //获取管理人员信息
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if(($db->num_rows($result)==1) or ($group_id==1)){$admining=1;
          	                            $product=" | <a href=\"?filename=product\" >物品入库</a> | <a href=\"?filename=admin\">管 理</a>";
          	                          } else {$admining=0;}

	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          当前用户：[$real_name]  <a href=\"?filename=index\" >首 页</a> | <a href=\"?filename=inform\" >物品信息库</a>  | <a href=\"?filename=list\">借记管理</a> | <a href=\"?filename=list&action=my\">我的借记</a>  $product 
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"100%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" /><a href=\"?filename=index\" >首 页</a> | 
                                    帐号：<input type=\"text\" name=\"username\" size=\"10\"/>
                                    密码：<input type=\"password\" name=\"password\" size=\"10\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"点击登入\" /> 
                                     | <a href=\"?filename=inform\" >物品信息库</a>  | <a href=\"?filename=list\">借记管理</a>
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };
$pretime=time()-604800;                 
//对于预借超出7天则取消
$sql="select pid from `$table_borrow` WHERE `state`=0 and `bortime`<='$pretime';";
$result=$db->query($sql);
while ($r=$db->fetch_array($result)) {
	$query="UPDATE `$table_product` SET `innumber`=`innumber`+1,`prenumber`=`prenumber`-1 WHERE `id` = '$r[pid]' LIMIT 1 ;";
    $db->query($query);
}
$query="DELETE from `$table_borrow` WHERE `state`=0 and `bortime`<='$pretime';";  
$db->query($query);               
//电教资料总数                  
$sql = "SELECT count(*) AS total FROM $table_product";
$r = $db->query_first($sql); 
$sumnumber=$r[total]; 
//电教资料预借总数                  
$sql = "SELECT count(*) AS total FROM $table_borrow where `state`='0'";
$r = $db->query_first($sql); 
$sumprenumber=$r[total]; 
//电教资料出借总数                  
$sql = "SELECT count(*) AS total FROM $table_borrow where `state`='1'";
$r = $db->query_first($sql); 
$sumoutnumber=$r[total]; 
//电教资料借记总次数                  
$sql = "SELECT SUM(bornumber) AS total FROM $table_product ";
$r = $db->query_first($sql); 
$sumbornumber=$r[total];                 
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
      <?=$login;?>
      <?=$logout;?>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
      <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=left>
						   	  <td  height=24 class=tr_head>&nbsp;</td>
					  		  <td  class=tr_head> 数 据 统 计</td>
						  	  <td  class=tr_head>&nbsp;</td>
					       </tr>
				    		 <tr  align=left>
						   	  <td width='10%' height=24 class=td1>&nbsp;</td>
					  		  <td width='80%' class=td1> 1、当前的电教资料总数为:<?=$sumnumber;?></td>
						  	  <td width='10%' class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 2、出借的电教资料为:<?=$sumoutnumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1>3、预借的电教资料为:<?=$sumprenumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 4、总共借记次数为:<?=$sumbornumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					      </tbody>
                <tbody>
                <tr  align=left>
                  <td width='10%' height=24 class=tr_head>&nbsp;</td>
					  		  <td width='80%' class=tr_head> 使 用 说 明</td>
						  	  <td width='10%' class=tr_head>&nbsp;</td>
					       </tr>
					        <tr  align=left>
						   	  <td width='10%' height=24 class=td1>&nbsp;</td>
					  		  <td width='80%' class=td1> 1、此系统由【开发笔记 技术支持】独立开发，为自由软件可以自由传播；</td>
						  	  <td width='10%' class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 2、只有注册为本校网站系统的用户才能使用此系统（必须通过审核）；</td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1>3、在物品信息库中查找电教资料并预借，然后到电教管理员处完成借记；</td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 4、一般预借天数为7天，超过了本系统将自动删除此信息，请重新预借。</td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					      </tbody>
             </TABLE>	
             </td>
            </tr>

  </table>
     
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
            

		 </td>
	 </tr>
  </table> 
 
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=5></td>
     </tr>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center class=foottable>
	   <TR vAlign=bottom align=middle>
      <TD align=middle height=10></td>
     </tr>
  </table> 
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center bgcolor=#ffffff>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24></td>
     </tr>
	   <TR vAlign=middle align=middle>
      <TD align=middle height=24>开发笔记 技术支持</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>

