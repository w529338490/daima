<?php

/**************Login-AND-Logout*****************/
if (isset($user_id)){
	        //��ȡ������Ա��Ϣ
	        $query="select userid,username,realname,groupid from members where userid=$user_id";
          $r=$db->query_first($query);
          $username=$r[username];
          $query="select * from $table_manage where admin=$user_id limit 1";
          $result=$db->query($query);
          if($db->num_rows($result)==1){$adminrepair=1;}
	        $login="<table width=\"99%\" height=40 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td valign=bottom height=40 width=260 align=center>
                          <span class=b_title>{ ����ʵ��Ǽ�ϵͳ }</span></td>
                       <td align=right valign=bottom> ��ǰ�û���[$real_name] <a href=\"?filename=index\" >�� ҳ</a> | <a href=\"#\" onclick=popUp('repair','0')>����ʵ��</a>  | <a href=\"?filename=list\" >�ҵ�����</a> | <a href=\"?filename=admin\">�� ��</a> </td>
                       <td width=20></td>
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
$class_style="td2";  
switch($school_type){
	case '1':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��");
		break;
	case '2':
		$gradearr=array("1"=>"��һ","2"=>"����","3"=>"����");
		break;
	case '3':
		$gradearr=array("1"=>"��һ","2"=>"�߶�","3"=>"����");
		break;
	case '12':
		$gradearr=array("1"=>"Сһ","2"=>"С��","3"=>"С��","4"=>"С��","5"=>"С��","6"=>"С��","7"=>"��һ","8"=>"����","9"=>"����");
		break;
}
$gradecarr=array("ȫ�꼶","(1)��","(2)��","(3)��","(4)��","(5)��","(6)��","(7)��","(8)��","(9)��","(10)��","(11)��","(12)��");
$state=array("������","׼����","ʹ����","�ѹ黹");
if (isset($stateid)){ 
	   $t_where="and `state`='$stateid'";
	   $t_where_2="and $table_content.state='$stateid'";
	   $t_url="&stateid=$stateid";
	   }
//ҳ�����ÿ�ʼ
$sql = "SELECT count(*) FROM $table_content where userid=$user_id $t_where";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=list$t_url");      
 //ҳ�����ý���
//��¼���ݵĶ�ȡ
$query="select $table_content.*,members.realname from $table_content 
            LEFT JOIN members ON $table_content.userid=members.userid
            where $table_content.userid=$user_id  $t_where_2
            order by id DESC limit $curpage,$perpage";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	          $intime=date("Y/m/d",$r[intime]);
	         	$t_l=strlen($r[nonum].$r[title]);
	         	$r[content]=cnSubStr($r[content],60-$t_l);
	         	$table_show.="
	         	              <tr id=list$r[id]>
           	               <td align=\"center\" valign=\"middle\" height=24 class=$class_style>".$gradearr[$r[grade]]."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$r[realname]."</td>
           	               <td align=\"left\" valign=\"middle\" class=$class_style><a href=# onclick=popUp('showcontent','$r[id]')>".$r[nonum]." ".$r[title]."{".$r[content]."}</a></td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>".$state[$r[state]]."</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style>$intime</td>
           	               <td align=\"center\" valign=\"middle\" class=$class_style><a href=# onclick=popUp('editrepair','$r[id]') title='ֻ�������߲����޸�'>�༭</a>|<a href=# onclick=popUp('delrepair','$r[id]') title='ֻ�������߲���Ȩ��'>ɾ��</a></td>
         	               </tr>";           
       }        
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=repair&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=0, width=300, height=170, left=250, top=210');
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
	                 	 <TD align=left width=150> &nbsp;&nbsp;<b>��ǰλ��:�ҵ�����</td>
                      <TD align=right height=20><a href="?filename=list">ȫ��</a> | <a href="?filename=list&stateid=0">����</a> | <a href="?filename=list&stateid=1">׼��</a> | <a href="?filename=list&stateid=2">ʹ��</a> | <a href="?filename=list&stateid=3">�黹</a> </td>
                      <TD align=right width=30> </td>
                   </tr>
                 </table>
              <TABLE cellSpacing=2 cellPadding=1 width="98%" align=center border=0 class=table1>
				    		<tbody id=repairlist>
				    		 <tr  align=center>
						   	  <td width='7%' height=24 class=tr_head>�꼶</td>
					  		  <td width='8%' class=tr_head>������</td>
						  	  <td width='57%' class=tr_head>�½� ʵ������{����}</td>
						  	  <td width='8%' class=tr_head>״̬</td>
						    	<td width='10%' class=tr_head>����ʱ��</td>
						    	<td width='12%' class=tr_head>�� ��</td>
					       </tr>
					      </tbody>
                <?=$table_show;?>
             </TABLE>	
             </td>
            </tr>
    <TR vAlign=bottom align=middle>
      <TD align=left height=24 colSpan=<?=$colid+1;?>>
      	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center >
	         <TR vAlign=middle>
	         	<TD align=center height=24  > <font color=blue ><b><?=$pagenav;?>&nbsp;</td>
	         	
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

