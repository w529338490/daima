<?php
/*
[F SCHOOL OA] F У԰����칫ϵͳ 2009   �๦�ܽ��ҵǼ�ϵͳ 2008
This is a freeware
Version: 2.2.1
Author: ���ӷ� (nbbufan@163.com)
Powered By:�����������ҡ� (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/

if (isset($user_name)){
	        $login="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                   <tr>
                       <td>
                          ��ǰ�û���$user_name  <a href=\"?filename=index\" >�� ҳ</a> | <a href=\"#\" onclick=popUp('order','0')>Ԥ ��</a> | <a href=\"#today\" >����ԤԼ</a> | <a href=\"?filename=list\" >�ҵ�ԤԼ</a> | <a href=\"?filename=admin\">�� ��</a> | <a href=\"?filename=login&action=logout\">�˳�ϵͳ</a>
                       </td>
                     </tr>  
                   </form>
                  </table>";
                  } else {
                  	$logout="<table width=\"99%\" height=32 border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=tableborder_2>
                             <form id=\"form1\" name=\"form1\" method=\"post\" action=\"?filename=login\">  
	                              <tr>
                                  <td>
                                    <input type=\"hidden\" name=\"action\" value=\"login\" />
                                    �ʺţ�<input type=\"text\" name=\"username\" size=\"15\"/>
                                    ���룺<input type=\"password\" name=\"password\" size=\"15\"/>
                                    <input type=\"submit\" name=\"submit\" value=\"�������\" />
                                   </td>
                                 </tr>  
                              </form>
                              </table>";
                  };
?>
<body topmargin="0" leftmargin="0" rightMargin="0">
<table cellSpacing=0 cellPadding=0 width="760" border=0 align=center bgcolor=#eeeeee>
<!--DWLayoutTable-->
 <tr>
  <td  valign="top">
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
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <!--DWLayoutTable-->
  <tr>
    <td width="25%" height="254" valign="top">
    	<table width="98%" border="0" cellpadding="0" cellspacing="0" class=tableborder_2 align=left>
      <!--DWLayoutTable-->
     <tr>
        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align=left>
          <!--DWLayoutTable-->
          <tr>
            <td width="100%" height="28" valign="middle"  class=bg_2 align=center>
            ��������	
            </td>
            </tr>
        </table>	
        </td>
        </tr>      
      <tr>
        <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align=left>
          <!--DWLayoutTable-->
          <tr>
            <td width="100%" height="32" valign="middle" align=center><a href="?filename=setvar">��������</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=type">�������</a></td>
            </tr>
          <tr> 
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=class">���ҹ���</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><a href="?filename=setting&action=grade">�༶����</a></td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell-->&nbsp;</td>
            </tr>
          <tr>
            <td height="24" valign="middle" align=center><!--DWLayoutEmptyCell-->&nbsp;</td>
            </tr>
        </table>	
        </td>
        </tr>
       </table>
      </td>
      <td valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder_2>
      <!--DWLayoutTable-->
        <tr>
          <td  height="254">
<table width="100%"  border="0" cellpadding="2" cellspacing="0" >
  <tr>
    <td height="28" class=bg><strong>����ǰλ�ã���������</strong></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
  <form name="form1" method="post" action="?filename=deal&action=setvar">
    <tr bgcolor="#F5F5F5"> 
      <td width="15%" align="right">��վ���ƣ�</td>
      <td width="85%"><input name="newsitename" type="text" size="30" value="<?=$sitename?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td  align="right">��վ��ַ��</td>
      <td ><input name="newsiteurl" type="text" size="30" value="<?=$siteurl?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">վ��������</td>
      <td ><input name="newsitemaster" type="text" size="15" value="<?=$sitemaster?>"></td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">��վ���⣺</td>
      <td><input name="newsitetitle" type="text" size="40" value="<?=$sitetitle?>"><br>������Ϊ��վ��������׺����ȷ���������������������Ͽ�ǰ��</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">��վ���ܣ�</td>
      <td><input name="newsitedescription" type="text" size="50" value="<?=$sitedescription?>"><br>������ʾ����ȷ���������������������Ͽ�ǰ��</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td align="right">��վ�ؼ��ʣ�</td>
      <td><input name="newsitekeywords" type="text" size="50" value="<?=$sitekeywords?>"><br>(����ؼ������ð�Ƕ��š�,�������������������������Ͽ�ǰ)</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td width="25%" align="right">��Ŀ¼��ַ��</td>
      <td width="75%"><input name="newrootpath" type="text" size="50" value="<?=$rootpath?>"><br>����ϵͳ��Ŀ¼������ַ�����治Ҫ�ӡ�/����</td>
    </tr>
    <tr bgcolor="#F5F5F5"> 
      <td width="25%" align="right">��վ���</td>
      <td width="75%">
<select name="newstyle">
<?php
$dir=opendir("./templates");
while($templatedir=readdir($dir)){
if(is_dir("./templates/".$templatedir) && $templatedir!='.' && $templatedir!='..'){
if($templatedir==$style)
echo "<option value='$templatedir' selected>$templatedir</option>";
else
echo "<option value='$templatedir'>$templatedir</option>";
}
}
?>
</select>
</td>
</tr>
<tr bgcolor="#F5F5F5"> 
    <td width="25%" align="right">�Ƿ�����Ͷ�壺</td>
      <td width="75%"><input type="radio" name="newcontribute" value="1" <?php if($contribute)echo 'checked';?>>�� <input type="radio" name="newcontribute" value="0" <?php if(!$contribute)echo 'checked';?>>��</td>
    </tr>
<tr bgcolor="#F5F5F5"> 
 <td width="25%" align="right">ÿҳ��������</td>
  <td width="75%"><input name="newperpage" type="text" size="10" value="<?=$perpage?>"></td>
</tr>
 <tr bgcolor="#F5F5F5"> 
      <td></td>
      <td height="30"> <input type="submit" name="Submit" value=" ȷ �� "> 
        &nbsp; <input type="reset" name="Submit1" value=" �� �� "> </td>
    </tr>
  </form>
</table>       	          	
          	</td>
        </tr>
      </table>
     </td>
    </tr>
  </table>
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align=center>
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
      <TD align=middle height=24>
ban      </td>
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
