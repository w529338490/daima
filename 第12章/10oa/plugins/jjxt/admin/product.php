<?php
/*
����ɽ��Сѧ����칫��
*/

/**************Login-AND-Logout*****************/
if (isset($user_id)){
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
if ($admining!=1) exit;                  
switch($action) {
case 'inproduct':
//������Ʒ�������
$query="select * from $table_type where type='t' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $type.="<option value=$r[id]>$r[name]</option>";
      }
//������Ʒ�����꼶
$query="select * from $table_type where type='g' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $grade.="<option value=$r[id]>$r[name]</option>";
      }
//������Ʒ����ѧ��
$query="select * from $table_type where type='s' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $subject.="<option value=$r[id]>$r[name]</option>";
      }            
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=addproduct">
  <tr>
    <td width="300" height="28" valign="middle">
          <strong>  ���ࣺ</strong>        
          <select name="type">
		  <?=$type;?>
        </select>
                <strong>�꼶��
      <label>
      <select name="grade">
	  <?=$grade;?>
      </select>
      </label>
    </strong>
      </td>
   </tr>      
   <tr>
    <td width="300" height="28" valign="middle">    
    <strong>
      <label>      </label>
      ѧ�ƣ�
      <label>
      <select name="subject">
	  <?=$subject;?>
      </select>
      </label>
    </strong>
          <strong>������</strong>
      <label>
      <select name="sumnumber">
	    <option value=1>1</option>
	    <option value=2>2</option>
	    <option value=3>3</option>
	    <option value=4>4</option>
	    <option value=5>5</option>
	    <option value=6>6</option>
	    <option value=7>7</option>
	    <option value=8>8</option>
	    <option value=9>9</option>   
      </select>
      </label>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���ƣ�</strong>
      <label>
      <input type="text" name="name" size=26 >
      </label>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>������</strong>
      <label>
      <textarea name=content cols="24" rows="4"></textarea>
      </label><input type="submit" name="submit" value="ȷ��"></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
case 'editproduct':
//��ȡ��Ӧ���ݵ�ֵ
$query="select * from $table_product where id=$id limit 1";
$r=$db->query_first($query);
$type_id=$r[type];
$subject_id=$r[subject];
$grade_id=$r[grade];
$content=$r[content];
$sumnumber_id=$r[sumnumber];
$name=$r[name];
//������Ʒ�������
$query="select * from $table_type where type='t' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $type.="<option value=$r[id]>$r[name]</option>";
      }
//������Ʒ�����꼶
$query="select * from $table_type where type='g' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $grade.="<option value=$r[id]>$r[name]</option>";
      }
//������Ʒ����ѧ��
$query="select * from $table_type where type='s' order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $subject.="<option value=$r[id]>$r[name]</option>";
      }            
?>
<script language='JavaScript'>   
function ret(){
   window.close();
  }
</script>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <form name="form1" method="post" action="?filename=deal&action=editproduct">
  <tr>
    <td width="300" height="28" valign="middle">
          <strong>  ���ࣺ</strong>        
          <select name="type">
		  <?=$type;?>
        </select>
      <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.type;
            Obj.value="<?=$type_id;?>";
      </SCRIPT>
                <strong>�꼶��
      <label>
      <select name="grade">
	  <?=$grade;?>
      </select>
     <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.grade;
            Obj.value="<?=$grade_id;?>";
      </SCRIPT>      
      </label>
    </strong>
      </td>
   </tr>      
   <tr>
    <td width="300" height="28" valign="middle">    
    <strong>
      <label>      </label>
      ѧ�ƣ�
      <label>
      <select name="subject">
	  <?=$subject;?>
      </select>
     <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.subject;
            Obj.value="<?=$subject_id;?>";
      </SCRIPT>      
      </label>
    </strong>
          <strong>������</strong>
      <label>
      <select name="sumnumber">
	    <option value=1>1</option>
	    <option value=2>2</option>
	    <option value=3>3</option>
	    <option value=4>4</option>
	    <option value=5>5</option>
	    <option value=6>6</option>
	    <option value=7>7</option>
	    <option value=8>8</option>
	    <option value=9>9</option>   
      </select>
     <SCRIPT LANGUAGE="JavaScript1.2">
            var Obj=document.form1.sumnumber;
            Obj.value="<?=$sumnumber_id;?>";
      </SCRIPT>       
      </label>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>���ƣ�</strong>
      <label>
      <input type="text" name="name" size=26 value="<?=$name;?>">
      </label>
    </td>
  </tr>
  <tr>
    <td height="28" valign="middle"><strong>������</strong>
      <label>
      <textarea name=content cols="24" rows="4"><?=$content;?></textarea>
      </label>
      <input type=hidden name=id value=<?=$id;?>>
      <input type="submit" name="submit" value="ȷ��"></td>
  </tr>
  <tr>
    <td height="28" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  </form>
</table>
</body>
<?
break;
default: 
//������Ʒ�������
$query="select * from $table_type  order by id DESC";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	    $types[$r[id]]=$r[name];
      } 
//ҳ�����ÿ�ʼ
 $sql = "SELECT count(*) FROM $table_product";
 $result = $db->query_first($sql);
 $totalnum=$result[0];
 $pagenumber = intval($pagenumber);
 if (!isset($pagenumber) or $pagenumber==0) {$pagenumber=1;}
 $curpage=($pagenumber-1)*$perpage;
 $pagenav=getpagenav($totalnum,"?filename=product");      
 //ҳ�����ý���   
$kg_list="
         <TABLE cellSpacing=0 cellPadding=0 width=100% border=0 align=center >
	        <TR vAlign=bottom align=middle>
          <TD align=middle height=5></td>
          </tr>
         </table>
         ";    
//��Ʒ��Ϣ�Ķ�ȡ
$query="select * from $table_product  order by id DESC limit $curpage,$perpage";
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
					  		  <td width='50%' class=tr_head>����</td>
						  	  <td width='10%' class=tr_head>����</td>
						  	  <td width='10%' class=tr_head>�꼶</td>
						  	  <td width='10%' class=tr_head>ѧ��</td>
						  	  <td width='5%' class=tr_head>����</td>
						  	  <td width='10%' class=tr_head>���ʱ��</td>						  	  
					       </tr>
					       <tr  align=center id='list$r[id]2'>
						   	  <td  height=24 class=td1>$r[id]</td>
					  		  <td class=td1>$r[name]</td>
						  	  <td class=td1>$type</td>
						  	  <td class=td1>$grade</td>
						  	  <td class=td1>$subject</td>
						  	  <td class=td1>$r[sumnumber]</td>
						  	  <td class=td1>$intime</td>
					       </tr>
					       <tr  id='list$r[id]3'>
						   	  <td align=center height=24 class=tr_head>����</td>
					  		  <td class=td2 colspan=3>$r[content]</td>
						  	  <td align=center class=tr_head2>����</td>
						  	  <td align=center class=td2  colspan=2>$edit</td>
					       </tr>
					      </tbody>
					    </table>
	             $kg_list      
	             ";
      }                             
?>
<SCRIPT LANGUAGE="JavaScript">
  function popUp(action,id) {
     props=window.open('?filename=product&action='+action+'&id='+id, 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=1, menubars=1, resizable=0, width=300, height=170, left = 250, top = 210');
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
                      <TD align=left height=28>
                      &nbsp; &nbsp;��ǰλ�ã�<a href="?filename=product" >��Ʒ��</a> { <a href=# onclick=popUp('inproduct','0')>��Ʒ�Ǽ�</a> }	
                      </td>
                   </tr>
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
	         	<TD align=left height=24  > <font color=blue ><b>&nbsp;ע�����ֻ�е���Ʒ�������Ժ���ܱ����</td>
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
<?
break;
}
?>
