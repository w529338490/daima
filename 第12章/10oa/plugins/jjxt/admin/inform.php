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
//������Ʒ���
$query="select * from $table_type  order by id ASC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$types[$r[id]]=$r[name];
	$types_t[$r[type]][]=array("$r[id]","$r[name]");
}
//������Ʒ�������
$ok="";
if (is_array($types_t[t])){
	foreach($types_t[t] AS $value){
		$type_show.="$ok <a href=?filename=inform&select=type&tid=$value[0] >$value[1]</a> ";
		$type_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//������Ʒ�����꼶
$ok="";
if (is_array($types_t[g])){
	foreach($types_t[g] AS $value){
		$grade_show.="$ok <a href=?filename=inform&select=grade&tid=$value[0]>$value[1]</a> ";
		$grade_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//������Ʒ����ѧ��
$ok="";
if (is_array($types_t[s])){
	foreach($types_t[s] AS $value){
		$subject_show.="$ok <a href=?filename=inform&select=subject&tid=$value[0] >$value[1]</a> ";
		$subject_option.="<option value=$value[0]>$value[1]</option>";
		$ok="|";
	}
}
//���÷������
switch($select){
	case 'type':
		$addaction="&select=type&tid=$tid";
		$select_type=" where type='$tid' ";
		$show_nav=$types[$tid];
		break;
	case 'grade':
		$addaction="&select=grade&tid=$tid";
		$select_type=" where grade='$tid' ";
		$show_nav=$types[$tid];
		break;
	case 'subject':
		$select_type=" where subject='$tid' ";
		$addaction="&select=subject&tid=$tid";
		$show_nav=$types[$tid];
		break;
	case 'all':
		$s=0;
		//�ؼ���
		if (empty($keyword)){ $select_type="";
		}
		else  {$select_type=" where name  REGEXP  '$keyword'";
		$addaction="&select=all&keyword=$keyword";
		$s=1;
		}
		//����
		if ($s_type!=0) {
			if ($s==0) { $select_type=" where type=$s_type";
			$addaction="&select=all&s_type=$s_type";
			$s=1;
			}
			else { $select_type.=" AND type=$s_type";
			$addaction.="&s_type=$s_type";
			}
		}
		//�꼶
		if ($s_grade!=0) {
			if ($s==0) { $select_type=" where grade=$s_grade";
			$addaction="&select=all&s_grade=$s_grade";
			$s=1;
			}
			else { $select_type.=" AND grade=$s_grade";
			$addaction.="&s_grade=$s_grade";
			}
		}
		//ѧ��
		if ($s_subject!=0) {
			if ($s==0) { $select_type=" where subject=$s_subject";
			$addaction="&select=all&s_subject=$s_subject";
			$s=1;
			}
			else { $select_type.=" AND subject=$s_subject";
			$addaction.="&s_subject=$s_subject";
			}
		}
		break;
	default:
		$select_type="";
		$addaction="";
		break;
}
//ҳ�����ÿ�ʼ
$sql = "SELECT count(*) FROM $table_product $select_type";
$result = $db->query_first($sql);
$totalnum=$result[0];
$pagenumber = intval($pagenumber);
if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
$curpage=($pagenumber-1)*$perpage;
$pagenav=getpagenav($totalnum,"?filename=inform$addaction");
//ҳ�����ý���
$kg_list="
         <TABLE cellSpacing=0 cellPadding=0 width=100% border=0 align=center >
	        <TR vAlign=bottom align=middle>
          <TD align=middle height=5></td>
          </tr>
         </table>
         ";    
//��Ʒ��Ϣ�Ķ�ȡ
$query="select * from $table_product $select_type order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$intime=date("Y/m/d",$r[intime]);
	$type=$types[$r[type]];
	$grade=$types[$r[grade]];
	$subject=$types[$r[subject]];
	$edit="<font color=red>���</font>|<a href=# onclick=popUp('editproduct','$r[id]')>�༭</a>|ɾ��";
	$product_list.="
	                <TABLE id=table$r[id] cellSpacing=1 cellPadding=1 width=\"98%\" align=center border=0 class=table1>
				    		<tbody>
				    		 <tr  align=center id='list$r[id]1'>
						   	  <td width='5%' height=24 class=tr_head>����</td>
					  		  <td width='45%' class=tr_head>����</td>
						  	  <td width='10%' class=tr_head>����</td>
						  	  <td width='10%' class=tr_head>�꼶</td>
						  	  <td width='10%' class=tr_head>ѧ��</td>
						  	  <td width='5%' class=tr_head>���</td>
						  	  <td width='5%' class=tr_head>�ѽ�</td>
						  	  <td width='5%' class=tr_head>Ԥ��</td>	
						  	  <td width='5%' class=tr_head>����</td>					  	  
					       </tr>
					       <tr  align=center id='list$r[id]2'>
						   	  <td  height=24 class=td2>$r[id]</td>
					  		  <td class=td2>$r[name]</td>
						  	  <td class=td2>$type</td>
						  	  <td class=td2>$grade</td>
						  	  <td class=td2>$subject</td>
						  	  <td class=td2>$r[innumber]</td>
						  	  <td class=td2>$r[outnumber]</td>
						  	  <td class=td2>$r[prenumber]</td>
						  	  <td class=td2>$r[bornumber]</td>
					       </tr>
					       <tr  id='list$r[id]3'>
						   	  <td align=center height=24 class=tr_head>����</td>
					  		  <td class=td2 colspan=6>$r[content]</td>
						  	  <td align=center class=tr_head2 colspan=2><a href=# class=b onclick=popUp('preborrow','$r[id]') >Ԥ ��</a></td>
					       </tr>
					      </tbody>
					    </table>
	             $kg_list      
	             ";
}
?>
<SCRIPT LANGUAGE="JavaScript">
function popUp(action,id) {
	props=window.open('?filename=borrow&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=1, menubars=1, resizable=0, width=300, height=170, left = 250, top = 210');
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
	                 <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	�� �ࣺ<?=$type_show;?>
                      </td>
                   </tr>
                   <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	ѧ �ƣ�<?=$subject_show;?>
                      </td>
                   </tr>
                   <TR vAlign=middle align=middle>
                      <TD align=left height=24>
                      	�� ����<?=$grade_show;?>
                      </td>
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
      <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0 align=center class=tableborder_2>        
            <tr>
              <td width="100%" valign="top">
                <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                <form name="form1" method="post" action="?filename=inform"> 
	                	<TR vAlign=bottom align=middle>
                      <TD align=left height=28 width=30%>
                      &nbsp; &nbsp;��ǰλ�ã�<a href="?filename=inform" >ȫ ��</a> >> <?=$show_nav;?> 	
                      </td>
                      <TD align=right height=28>
                      
                        �ؼ��ʣ�<input type=text name=keyword size=12>	                      
	                       <select name="s_type">
	                       	<option value=0>����</option>
		                      <?=$type_option;?>
                         </select>
                         <select name="s_grade">
                         	<option value=0>�꼶</option>
		                       <?=$grade_option;?>
                         </select>
                         <select name="s_subject">
                         	<option value=0>ѧ��</option>
		                       <?=$subject_option;?>
                         </select>
                         <input type=hidden name=select value=all>
                         <input type=submit value="�� ��">
                         &nbsp;&nbsp;
                      </td>
                   </tr> </form>
                 </table>
              	  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	                 <TR vAlign=bottom align=middle>
                      <TD align=middle height=5></td>
                   </tr>
                 </table>  
                 <table cellSpacing=1 cellPadding=1 width=98% border=0 align=center>
                 <tbody id=newlist>
                </tbody>
              </table>
                </td>
               </tr>
               <tr>
              <td width="100%" valign="top">
                 <?=$product_list?>
             </td>
            </tr>
    <TR vAlign=bottom align=middle>
      <TD align=left height=24 >
      	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	         <TR vAlign=middle>
	         	<TD align=center height=24  >
	         		 <font color=blue ><b>&nbsp;<?=$pagenav;?></td>
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
      	�����ʼ� ����֧�֡�</td>
     </tr> 
	   <TR vAlign=middle align=middle>
      <TD align=middle height=12>
     </tr>          
  </table> 
</td>
</tr>
</table>           
</body>