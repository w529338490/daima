//����XMLHttpRrequest����
var xmlHttp=createXmlHttpRequestObject();

//��ȡXMLHttpRrequest����
function createXmlHttpRequestObject(){
	//�����洢��Ҫʹ�õ�XMLHttpRrequest����
	var xmlHttp;
	//�����internet Explorer������
	if(window.ActiveXObject){
		try{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}catch(e){
			xmlHttp=false;
		}

	}else{
	//�����Mozilla�������������������
		try{
			xmlHttp=new XMLHttpRequest();
		}catch(e){
			xmlHttp=false;
		}
	}
	 //���ش����Ķ������ʾ������Ϣ
	if(!xmlHttp)
		alert("���ش����Ķ������ʾ������Ϣ");
		else
		return xmlHttp;
}
//ʹ��XMLHttpRequest���󴴽��첽HTTP����
function process(){
	
	if(form1.username.value==""){
		alert("������������");
   		    form1.username.select();
			return(false);
		}
	if(form1.tel.value==""){
		alert("������绰���룡");
		form1.tel.select();
		return(false);
		}
	if(checkphone(form1.tel.value)!=true){
		alert("������ĵ绰����ĸ�ʽ����ȷ��");
		form1.tel.select();
		return(false);
		}	

	if(form1.address.value==""){
		alert("��������ϵ��ַ��");
		form1.address.select();
		return(false);
		}
	
	//��xmlHttp����æʱ���д���
	if(xmlHttp.readyState==4 || xmlHttp.readyState==0){
	//��ȡ�û����߱������������	
	names = document.getElementById("username").value;
	tels = document.getElementById("tel").value;
	addresss =document.getElementById("address").value;
	//�ڷ�������ִ��quickstart.php
	
	xmlHttp.open("GET","zhuce_ok.php?online_user="+names+"& online_tel="+tels+"& online_address="+addresss,true);
	//�����ȡ����������Ӧ�ķ���
	xmlHttp.onreadystatechange=handleServerResponse;
	//���������������
	xmlHttp.send(null);
	}else
	//���������æ,1�������
	setTimeout('process()',1000);
}
//���յ��������˵���Ϣʱ�Զ�ִ��
function handleServerResponse(){
	//�ڴ������ʱ������һ��
	if(xmlHttp.readystate==4){
		//״̬Ϊ200��ʾ����ɹ�����
		if(xmlHttp.status==200){
			//��ȡ�������˷�����XML��Ϣ
			xmlResponse=xmlHttp.responseXML;
			//��ȡXML�е��ĵ�����(������)
			xmlDocumentElement=xmlResponse.documentElement;
			//��ȡ��һ���ĵ���Ԫ�ص��ı���Ϣ
			helloMessage=xmlDocumentElement.firstChild.data;
			//ʹ�ôӷ������˷�������Ϣ���¿ͻ�����ʾ������
			document.getElementById("divMessage").innerHTML='<i>'+helloMessage+'</i>';
			//���¿�ʼ
			setTimeout('process()',1000);

		}else{
			//���HTTP��״̬����200��ʾ��������
        	alert("There was a problem accessing the server:"+xmlHttp.statusText);
		}
	}
}

//��֤�绰����ĸ�ʽ�Ƿ���ȷ
function checkphone(tel){
	var str=tel;
	var Expression=/^(\d{3}-)(\d{8})$|^(\d{4}-)(\d{7})$|^(\d{4}-)(\d{8})$|^(\d{11})$/;  
	var objExp=new RegExp(Expression);
	if(objExp.test(str)==true){
		return true;
	}else{
		return false;
	}
}	
