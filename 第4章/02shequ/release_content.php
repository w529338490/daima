<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<link href="css/style.css" rel="stylesheet">
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
<table width="563" height="407" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="563" height="407" valign="top" bgcolor="#FFFFFF">
      <form name="form1" method="post" action="release_ok.php" >
        <table width="563" border="0" cellspacing="0" cellpadding="0">
          <tr background="Images/mianfei.gif">
            <td height="27" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="24" colspan="2">&nbsp;</td>
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
&nbsp;<span class="style1">*&nbsp;����ȷѡ����Ҫ��������Ϣ���</span></td>
          </tr>
          <tr>
            <td height="30" align="right">��Ϣ���⣺</td>
            <td height="30"><input name="title" type="text" id="title" size="50"></td>
          </tr>
          <tr>
            <td height="30" align="right">��Ϣ���ݣ�</td>
            <td height="30">
              <textarea name="content" cols="50" rows="8" id="content"></textarea>
            </td>
          </tr>
          <tr>
            <td height="30" align="right">��&nbsp;ϵ&nbsp;�ˣ�</td>
            <td height="30"><input name="linkman" type="text" id="linkman"></td>
          </tr>
          <tr>
            <td height="30" align="right">��ϵ�绰��</td>
            <td height="30"><input name="tel" type="text" id="tel"></td>
          </tr>
          <tr align="center">
            <td height="80" colspan="2">
              <input name="imageField" type="image" class="input1" src="Images/fa.jpg" width="145" height="46" border="0" onClick="return checkform(form);">
            </td>
          </tr>
        </table>
      </form>
   </td>
  </tr>
</table>
