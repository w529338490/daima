<?php
/*
����ɽ��Сѧ����칫��
*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //��ȡ������Ա��Ϣ
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$admining=1;
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
if ($action=="my"){                  
if (isset($state)) {$select_type="where $table_borrow.state='$state' and $table_borrow.author='$user_id' ";
	                 $select_type_1="where `state`='$state' and `author`='$user_id'";
	                 $addaction="&action=my&state=$state";
	                 } else {
	                 	$select_type="where  $table_borrow.author='$user_id' ";
	                 $select_type_1="where  `author`='$user_id'";
	                 $addaction="&action=my&";
	                	      } 
	                	$show_nav="�ҵĽ�Ǽ�¼��";
	                	$manage="<b><a href=\"?filename=list&action=my\">ȫ����¼</a> | <a href=\"?filename=list&action=my&state=2\">�ѻ�</a> | <a href=\"?filename=list&action=my&state=1\">δ��</a> | <a href=\"?filename=list&action=my&state=0\">Ԥ��</a> &nbsp;&nbsp;</b>";      
	                } else {
	                	if (isset($state)) {$select_type="where $table_borrow.state='$state'";
	                 $select_type_1="where `state`='$state'";
	                 $addaction="&state=$state";
	                 } 
	                 	$show_nav="��Ǽ�¼��";
	                	$manage="<b><a href=\"?filename=list\">ȫ����¼</a> | <a href=\"?filename=list&state=2\">�ѻ�</a> | <a href=\"?filename=list&state=1\">δ��</a> | <a href=\"?filename=list&state=0\">Ԥ��</a> &nbsp;&nbsp;</b>";  
	                }               
//ҳ�����ÿ�ʼ
 $sql = "SELECT count(*) FROM $table_borrow $select_type_1";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=list$addaction");      
 //ҳ�����ý���   
                  
//��Ʒ��Ϣ�Ķ�ȡ
$states=array("Ԥ��","�ѽ�","�ѻ�");
$query="select $table_borrow.*,$table_product.name,members.realname 
        from `$table_borrow`  
        left join $table_product on $table_borrow.pid=$table_product.id 
        left join `members` on  members.userid=$table_borrow.author 
        $select_type 
        order by id DESC 
        limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $bortime=date("Y/m/d",$r[bortime]);
	    if ($r[retime]!=0) $retime=date("Y/m/d",$r[retime]); else $retime="/" ;  
      if ($admining==1){
       switch($r[state]){
       	case '0':
       	$edit="<a href=# onclick=popUp('borrow','$r[id]')><font color=red>���</font></a>|<a href=# onclick=popUp('delborrow','$r[id]')>ɾ��</a>";
       	break;
       	case '1':
       	$edit="<a href=# onclick=popUp('return','$r[id]')><font color=red>�黹</font></a> ";
       	break;
       	case '2':
       	$edit="�ѻ�";
       	break;
       }
      } else {
      	   $edit="��Ȩ��";
      	    }
	    $borrow_list.="
				    		<tbody>
					       <tr  align=center id='list$r[id]'>
						   	  <td  height=24 class=td2>$r[id]</td>
					  		  <td class=td2>$r[realname]</td>
						  	  <td class=td2>$r[name]</td>
						  	  <td class=td2>$bortime</td>
						  	  <td class=td2>$retime</td>
						  	  <td class=td2>$r[bornumber]</td>
						  	  <td class=td2>".$states[$r[state]]."</td>
						  	  <td class=td2>$edit</td>
					       </tr>
					      </tbody>     
	             ";
      }                
?>
<SCRIPT language=JavaScript> 
  function popUp(action,id) {
           props=window.open('?filename=borrow&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left = 250, top = 210');
           }
</SCRIPT>
<body topmargin="0" leftmargin="0" rightMargin="0">
<TABLE cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
	<TR vAlign=bottom align=middle>
      <TD align=middle>
	   <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>
     <?=$login;?>
     <?=$logout;?>
     	   <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=5></td>
       </tr>
     </table>

    <table width='99%' border='0' cellspacing='0' cellpadding='0' height=146 align=center  class=tableborder_2>
	      <tr>
		      <td valign=top align=center>  
		      	<table width='100%'  cellspacing='0' cellpadding='0' align=center  >
	            <tr height=24 >
	       			 <td width=30%>
			         <b>&nbsp;&nbsp;��ǰλ�ã�<?=$show_nav;?> </b>
					    </td>
		       <td align=right>
			       <?=$manage;?>
					</td>
	       </tr>
       </table> 
       <table width='98%' border='0' cellspacing='0' cellpadding='0' height=146 align=center  class=table1>
	      <tr>
		      <td valign=top align=center>
					<table border='0' cellspacing='1' cellpadding='1' width='100%' id="todayorder" align=center>
						<tr align=center valign=middle>
							<td width='5%' height=24 class=tr_head>����</td>
							<td width='10%' class=tr_head>�� ��</td>
							<td width='40%' class=tr_head>��Ʒ����</td>
							<td width='10%' class=tr_head>���ʱ��</td>
							<td width='10%' class=tr_head>�黹ʱ��</td>
							<td width='5%' class=tr_head>����</td>
							<td width='10%' class=tr_head>״̬</td>
							<td width='10%' class=tr_head>����</td>
					  </tr>
					  <?=$borrow_list;?>
					</table>
				</td>
					  </tr>
					</table>	
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
	     <TR vAlign=bottom align=middle>
        <TD align=middle height=24><?=$pagenav;?></td>
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
      	�����ʼ� ����֧��</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>            
</body>

