<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../css/style.css" rel="stylesheet">
<script language="javascript">
function checkform(form){
	for(i=0;i<form.length;i++){
		if(form.elements[i].value==""){
			alert("�뽫������Ϣ��д������");
			form.elements[i].focus();
			return false;
		}
	}
}
</script>
<table width="776" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="32" background="images/right_line.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�����ڵ�λ�ã��Ĺ���������&nbsp;&gt;&nbsp;��̨����ϵͳ</td>
  </tr>
  <tr>
    <td height="32" background="images/right_top.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="488" align="center" valign="top" background="images/right_middle.gif">
        <p>&nbsp;</p>
        <table width="563" height="407" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="563" height="407" valign="top" bgcolor="#FFFFFF">
              <form name="form1" method="post" action="release_ok.php">
                <table width="563" border="0" cellspacing="0" cellpadding="0">
                  <tr background="Images/mianfei.gif">
                    <td height="27" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="130" height="30" align="right">��Ϣ���</td>
                    <td width="433" height="30"><select name="type">
                        <option value="��Ƹ��Ϣ">-��Ƹ��Ϣ-</option>
                        <option value="��ְ��Ϣ" selected>-��ְ��Ϣ-</option>
                        <option value="��ѵ��Ϣ">-��ѵ��Ϣ-</option>
                        <option value="�ҽ���Ϣ">-�ҽ���Ϣ-</option>
                        <option value="������Ϣ">-������Ϣ-</option>
                        <option value="������Ϣ">-������Ϣ-</option>
                        <option value="����Ϣ">-����Ϣ-</option>
                        <option value="������Ϣ">-������Ϣ-</option>
                        <option value="��������">-��������-</option>
                        <option value="��Ԣ��Ϣ">-��Ԣ��Ϣ-</option>
                        <option value="Ѱ��/����ʾ">-Ѱ��/����ʾ-</option>
                      </select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="flag" type="checkbox" class="input1" id="flag" value="1" checked>
              �Ƿ񸶷�</td>
                  </tr>
                  <tr>
                    <td height="30" align="right">��Ϣ���⣺</td>
                    <td height="30"><input name="title" type="text" id="title" size="50"></td>
                  </tr>
                  <tr>
                    <td height="30" align="right">��Ϣ���ݣ�</td>
                    <td height="30">
                      <textarea name="content" cols="55" rows="8" id="textarea"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td height="30" align="right">��&nbsp;ϵ&nbsp;�ˣ�</td>
                    <td height="30"><input name="linkman" type="text" id="linkman" size="30"></td>
                  </tr>
                  <tr>
                    <td height="30" align="right">��ϵ�绰��</td>
                    <td height="30"><input name="tel" type="text" id="tel" size="30"></td>
                  </tr>
                  <tr>
                    <td height="30" align="right">��Ч������</td>
                    <td height="30"><input name="days" type="text" id="day"> 
                      &nbsp;��</td>
                  </tr>
                  <tr align="center">
                    <td height="80" colspan="2">
                      <input name="imageField" type="image" class="input1" src="images/fa.jpg" width="145" height="46" border="0" onClick="return checkform(form);">
                    </td>
                  </tr>
                </table>
            </form></td>
          </tr>
        </table>
        <br>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td height="32" background="images/right_bottom.gif">&nbsp;</td>
  </tr>
</table>
