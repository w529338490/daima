<?php
/*
����ɽ��СѧУ����칫��
*/
/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //��ȡ������Ա��Ϣ
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$adminrepair=1;}
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          ��ǰ�û��� [$real_name] <a href=\"?filename=index\" >�� ҳ</a> | <a href=\"#\" onclick=popUp('repair','0')>���뱨��</a>  | <a href=\"?filename=list\" >�ҵı���</a>
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
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };
//��������                  
//��������  
$class_style="td1";  
$type=array("","����","����");
$state=array("δά��","ά����","����ά��","ά�����");
if (isset($stateid)){ 
	   $t_where="and `state`='$stateid'";
	   $t_where_2="and $table_content.state='$stateid'";
	   $t_url="&stateid=$stateid";
	   }
//ҳ�����ÿ�ʼ
 $sql = "SELECT count(*) FROM $table_content where user=$user_id $t_where";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=list$t_url");      
 //ҳ�����ý���
//��¼���ݵĶ�ȡ
$query="select * from $table_content where user=$user_id $t_where_2 order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	          $intime=date("Y/m/d",$r[intime]);
	          if ($r[retime]==0) $retime="&nbsp;" ; else $retime=date("Y/m/d",$r[retime]);
	          if ($adminrepair==1) $adminpop="onclick=popUp('adminrepair','$r[id]')"; else $adminpop="";
	         	$table_show.="
	         	              <tr id=list$r[id]>
           	               <td align=\"left\" valign=\"middle\" height=24 class=$class_style>$r[address]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$real_name."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$type[$r[type]]."</td>
           	               <td align=\"left\" valign=\"middle\" class=$class_style>$r[content]</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$intime</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$state[$r[state]]."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$retime</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style><a href=# onclick=popUp('editrepair','$r[id]') title='ֻ�б����߲����޸�'>�༭</a></td>
         	               </tr>";
         	  if ($class_style=="td1") $class_style="td2";else $class_style="td1";                
       }        
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
                                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
	                 	 <TD align=left width=150> &nbsp;&nbsp;<b>��ǰλ��:��ҳ</td>
                      <TD align=right height=20>
                      	    <a href="?filename=index">ȫ��</a> | 
                      	    <a href="?filename=index&stateid=0">δά��</a> | 
                      	    <a href="?filename=index&stateid=1">ά����</a> | 
                      	    <a href="?filename=index&stateid=2">����ά��</a> | 
                      	    <a href="?filename=index&stateid=3">ά�����</a> </td>
                      <TD align=right width=30> </td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
						   	  <td width='10%' height=24 class=tr_head>ά�޵ص�</td>
						   	  <td width='10%' class=tr_head>������</td>
						  	  <td width='5%' class=tr_head>����</td>
						  	  <td width='35%' class=tr_head>����ԭ��</td>
						  	  <td width='10%' class=tr_head>����ʱ��</td>
						  	  <td width='10%' class=tr_head>ά�����</td>
						    	<td width='10%' class=tr_head>�޸�ʱ��</td>
						    	<td width='10%' class=tr_head>�� ��</td>
					       </tr>
					      </tbody>
                <?=$table_show;?>
                <tr  align=center>
						   	  <td width='10%' height=24 class=tr_head>ά�޵ص�</td>
						   	  <td width='10%' class=tr_head>������</td>
						  	  <td width='5%' class=tr_head>����</td>
						  	  <td width='35%' class=tr_head>����ԭ��</td>
						  	  <td width='10%' class=tr_head>����ʱ��</td>
						  	  <td width='10%' class=tr_head>ά�����</td>
						    	<td width='10%' class=tr_head>�޸�ʱ��</td>
						    	<td width='10%' class=tr_head>�� ��</td>
					       </tr>
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
      <TD align=middle height=24>
      	�����ʼ� ����֧��
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>