function FrontPage_Form1_Validator(theForm)
{
  if (theForm.username.value == "")
  {
    alert("����д�ǳƣ�");
    theForm.username.focus();
    return (false);
  }
  if (theForm.username.value.length<3)
  {
    alert("�ǳ�����ӦΪ3���ַ���");
    theForm.username.focus();
    return (false);
  }
  if(theForm.email.value!=""){
              var email1 = theForm.email.value;
              var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/; 
              flag = pattern.test(email1); 
              if(!flag){
              alert("�ʼ���ַ��ʽ���ԣ�");
     theForm.email.focus();
           return false;}
  }

  if (theForm.content.value == "")
  {
    alert("�������ݲ��ܿգ�");
    theForm.content.focus();
    return (false);
  }
  if (theForm.content.value.length<5)
  {
    alert("������������5���ַ���");
    theForm.content.focus();
    return (false);
  }
  if (theForm.unum.value == "")
  {
    alert("��������֤�룡");
    theForm.unum.focus();
    return (false);
  }
   return (true);
}