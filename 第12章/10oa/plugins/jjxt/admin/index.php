<?php
/*����ɽ��Сѧ����칫��*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){          
	    if ($group_id==1){
          	  $adminrepair=1; 
          	  $product=" | <a href=\"?filename=admin\">�� ��</a>";
          }
	        //��ȡ������Ա��Ϣ
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if(($db->num_rows($result)==1) or ($group_id==1)){$admining=1;
          	                            $product=" | <a href=\"?filename=product\" >��Ʒ���</a> | <a href=\"?filename=admin\">�� ��</a>";
          	                          } else {$admining=0;}

	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          ��ǰ�û���[$real_name]  <a href=\"?filename=index\" >�� ҳ</a> | <a href=\"?filename=inform\" >��Ʒ��Ϣ��</a>  | <a href=\"?filename=list\">��ǹ���</a> | <a href=\"?filename=list&action=my\">�ҵĽ��</a>  $product 
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"100%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" /><a href=\"?filename=index\" >�� ҳ</a> | 
                                    �ʺţ�<input type=\"text\" name=\"username\" size=\"10\"/>
                                    ���룺<input type=\"password\" name=\"password\" size=\"10\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"�������\" /> 
                                     | <a href=\"?filename=inform\" >��Ʒ��Ϣ��</a>  | <a href=\"?filename=list\">��ǹ���</a>
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };
$pretime=time()-604800;                 
//����Ԥ�賬��7����ȡ��
$sql="select pid from `$table_borrow` WHERE `state`=0 and `bortime`<='$pretime';";
$result=$db->query($sql);
while ($r=$db->fetch_array($result)) {
	$query="UPDATE `$table_product` SET `innumber`=`innumber`+1,`prenumber`=`prenumber`-1 WHERE `id` = '$r[pid]' LIMIT 1 ;";
    $db->query($query);
}
$query="DELETE from `$table_borrow` WHERE `state`=0 and `bortime`<='$pretime';";  
$db->query($query);               
//�����������                  
$sql = "SELECT count(*) AS total FROM $table_product";
$r = $db->query_first($sql); 
$sumnumber=$r[total]; 
//�������Ԥ������                  
$sql = "SELECT count(*) AS total FROM $table_borrow where `state`='0'";
$r = $db->query_first($sql); 
$sumprenumber=$r[total]; 
//������ϳ�������                  
$sql = "SELECT count(*) AS total FROM $table_borrow where `state`='1'";
$r = $db->query_first($sql); 
$sumoutnumber=$r[total]; 
//������Ͻ���ܴ���                  
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
					  		  <td  class=tr_head> �� �� ͳ ��</td>
						  	  <td  class=tr_head>&nbsp;</td>
					       </tr>
				    		 <tr  align=left>
						   	  <td width='10%' height=24 class=td1>&nbsp;</td>
					  		  <td width='80%' class=td1> 1����ǰ�ĵ����������Ϊ:<?=$sumnumber;?></td>
						  	  <td width='10%' class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 2������ĵ������Ϊ:<?=$sumoutnumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1>3��Ԥ��ĵ������Ϊ:<?=$sumprenumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 4���ܹ���Ǵ���Ϊ:<?=$sumbornumber;?></td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					      </tbody>
                <tbody>
                <tr  align=left>
                  <td width='10%' height=24 class=tr_head>&nbsp;</td>
					  		  <td width='80%' class=tr_head> ʹ �� ˵ ��</td>
						  	  <td width='10%' class=tr_head>&nbsp;</td>
					       </tr>
					        <tr  align=left>
						   	  <td width='10%' height=24 class=td1>&nbsp;</td>
					  		  <td width='80%' class=td1> 1����ϵͳ�ɡ������ʼ� ����֧�֡�����������Ϊ��������������ɴ�����</td>
						  	  <td width='10%' class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 2��ֻ��ע��Ϊ��У��վϵͳ���û�����ʹ�ô�ϵͳ������ͨ����ˣ���</td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1>3������Ʒ��Ϣ���в��ҵ�����ϲ�Ԥ�裬Ȼ�󵽵�̹���Ա����ɽ�ǣ�</td>
						  	  <td  class=td1>&nbsp;</td>
					       </tr>
					       <tr  align=left>
						   	  <td  height=24 class=td1>&nbsp;</td>
					  		  <td  class=td1> 4��һ��Ԥ������Ϊ7�죬�����˱�ϵͳ���Զ�ɾ������Ϣ��������Ԥ�衣</td>
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
      <TD align=middle height=24>�����ʼ� ����֧��</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>

