<?php
/*
����ɽ��Сѧ����칫��
*/

		$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
		$serverinfo .= @ini_get('safe_mode') ? ' ��ȫģʽ' : NULL;
		$dbversions=$db->query_first("SELECT VERSION()");
		$dbversion=$dbversions[0];

		if(@ini_get("file_uploads")) {
			$fileupload = "���� - �ļ� ".ini_get("upload_max_filesize")." - ����".ini_get("post_max_size");
		} else {
			$fileupload = "<font color=\"red\">��ֹ</font>";
		}

		$dbsize = 0;
		$query = $db->query("SHOW TABLE STATUS LIKE '$tablepre%'", 1);
		while($table = $db->fetch_array($query)) {
			$dbsize += $table[Data_length] + $table[Index_length];
		}
		$dbsize = $dbsize ? sizecount($dbsize) : "δ֪";

		$attachsize = dirsize("./upfiles");
		$attachsize = $attachsize ? sizecount($attachsize) : "δ֪";
		
 	 $attachpicsize = dirsize("./uppics");
		$attachpicsize = $attachpicsize ? sizecount($attachpicsize) : "δ֪";

?>
<LINK href="admin/style/default/admin.css" rel=stylesheet type=text/css>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td  height="42" valign="top">
    <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
            <TD valign=middle align=center bgcolor="#4466cc" class=submenu><b>��ӭ���� <a href="http://www.nbcjzx.com" target="_blank">slcms 1.3</a> ϵͳ�������</b></TD>
          </TR>
          <TR> 
            <TD class=tablerow align=center valign=middle>��Ȩ����&copy;����У԰��www.nbcjzx.com��, 2006. 
      </TD>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
      <td  height="24"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr> 
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable-->  
        <TBODY>
            <TR> 
            <TH colSpan=2>ϵ ͳ �� Ϣ</TH>
          </TR>
<tr bgcolor="#F8F8F8"><td width="50%">����������</td><td><?=$serverinfo?></td></tr>
<tr bgcolor="#F8F8F8"><td>MySQL �汾</td><td><?=$dbversion?></td></tr>
<tr bgcolor="#F8F8F8"><td>�����ϴ����</td><td><?=$fileupload?></td></tr>
<tr bgcolor="#F8F8F8"><td>���ݿ�ռ��</td><td><?=$dbsize?></td></tr>
<tr bgcolor="#F8F8F8"><td>�����ļ�ռ��</td><td><?=$attachsize?></td></tr>
<tr bgcolor="#F8F8F8"><td>ͼƬ�ļ�ռ��</td><td><?=$attachpicsize?></td></tr>
        </tbody>
     </table>
    </td> 
    </tr>  
	  <tr> 
      <td  height="24"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr> 
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable-->  
        <TBODY>
            <TR> 
            <TH colSpan=2>�� �� �� ��</TH>
          </TR>

<tr bgcolor="#F8F8F8"><td>��Ŀ����</td><td>����</td></tr>
<tr bgcolor="#F8F8F8"><td>�����Ŷ�</td><td>����</td></tr>
<tr bgcolor="#F8F8F8"><td>�������</td><td>����</td></tr>
<tr bgcolor="#F8F8F8"><td>�������</td><td>����</td></tr>
<tr bgcolor="#F8F8F8"><td>����֧��</td><td>����</td></tr>
        </tbody>
     </table>
    </td> 
    </tr> 
</table>
</body>