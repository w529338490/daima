//*****************************�Զ�ѡ�����ѡ��*****************************
function checklistid() 
{ 
var strchoice=""; 
var j=0;
for(var i=0;i<document.form3.checkLine.length;i++) 
{ 
if (document.form3.checkLine[i].checked) 
{ 
strchoice=strchoice+document.form3.checkLine[i].value+","; 
j++;
} 
} 
var selectnum=j;
if (!document.form3.checkLine.length) 
{ 
if (document.form3.checkLine.checked) 
{ 
strchoice=document.form3.checkLine.value+","; 
var selectnum=1;
} 
}
strchoice=strchoice.substring(0,strchoice.length-1);
document.form3.checkLines.value=strchoice;
return selectnum;
} 

//*****************************��ʼ��ajax*****************************
function InitAjax()
{
��var ajax=false; 
��try { 
����ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
��} catch (e) { 
����try { 
������ajax = new ActiveXObject("Microsoft.XMLHTTP"); 
����} catch (E) { 
������ajax = false; 
����} 
��}
��if (!ajax && typeof XMLHttpRequest!='undefined') { 
����ajax = new XMLHttpRequest(); 
��} 
��return ajax;
} 
//*****************************��ȡ��ǩֵ*****************************
function $(a) 
{ 
    return document.getElementById(a); 
}  
//*****************************����cookies����*****************************
function setcookie(name,value)
{ 
    var cookiestr=name+"="+value+";"; 
    var expires = ""; 
    var cookieexp=60*60*1000; 
    var d = new Date(); 
    d.setTime( d.getTime() + cookieexp); 
    expires = "expires=" + d.toGMTString()+";"; 
    document.cookie = cookiestr+ expires; 
} 
//*****************************ȡcookies����*****************************  
function getCookie(name)      
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
//*****************************ɾ��cookie*****************************
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
//*****************************��ȡϵͳʱ��*****************************
function gettime()
{
 //��ȡ����ʱ��
  var addtime=new Date().getYear()+"-"; 
      addtime+=new Date().getMonth()+1+"-"; 
      addtime+=new Date().getDate()+"-"; 

      addtime+=new Date().getHours()+":"; 
      addtime+=new Date().getMinutes()+":"; 
      addtime+=new Date().getSeconds(); 
      return addtime;
}
//*****************************�������ļ���*****************************
function creatfolder()
{
	//����cookie���ݵ�deal.php��
	setcookie("foldername",$('foldername').value); 
��//��ȡ���ܷ�����Ϣ��
��var msg = document.getElementById("msg");
��//��ȡ��������û���Ϣֵ
��var f = document.form1;
��var foldername = f.foldername.value;
��var id = f.id.value;
  var layerid = f.layerid.value;

��//���ձ���URL��ַ
��var url = "?";
��//��ҪPOST��ֵ����ÿ��������ͨ��&������
��var postStr ="filename=deal&action=creatfolder&uid="+id+"&layerid="+layerid;

��//ʵ����Ajax
��var ajax = InitAjax();
��//ͨ��Post��ʽ������
��ajax.open("POST", url, true); 
��//���崫����ļ�HTTPͷ��Ϣ
��ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
��//����POST����
��ajax.send(postStr);
  
��//��ȡִ��״̬
��ajax.onreadystatechange = function() { 
����//���ִ��״̬�ɹ�����ô�Ͱѷ�����Ϣд��ָ���Ĳ���
����if (ajax.readyState == 4 && ajax.status == 200) { 
      //��ȡcidֵ
      cid=getCookie("tempid");
      delCookie("tempid");
      //����addfolder����
      if (cid!=0) addfolder(cid);
      //��ʾ��Ϣ
������msg.innerHTML = ajax.responseText;  
      ShowTabs1(0);
      setTimeout("document.getElementById('msg').style.display = 'none'",4000);
����} 
��} 
} 
//��ҳ��ȥճ����Ӧ���´������ļ��л򱻼��е��ļ��е�html����
function addfolder(cid)
{
  //��ȡ����ʱ��
  var addtime=gettime(); 

 //��ȡ��������û���Ϣֵ
 var id=cid;
 var f = document.form1;
 var foldername=f.foldername.value;
 var uid=f.id.value;
 var nowTable=document.all.ftable;
 var col = nowTable.cells.length/nowTable.rows.length;
 var row = nowTable.rows.length;
  
 var newTr=tbody1.insertRow();
     newTr.id="folder"+row;
 var newTd=newTr.insertCell(0);
 var newTd1=newTr.insertCell(1);
 var newTd2=newTr.insertCell(2);
 var newTd3=newTr.insertCell(3);
 var newTd4=newTr.insertCell(4);

newTd.innerHTML="<input type=checkbox name=checkfolder id=checkfolder value="+id+" disabled>";
newTd1.innerHTML="<img src=./images/folder.gif border=0 alt=�ļ��� align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+cid+">"+foldername+"</a>";
newTd2.innerHTML="-";
newTd3.innerHTML=addtime;
newTd4.innerHTML="<a href=# onClick=del('ftable','folder"+row+"','folder',"+cid+")><img src=./images/del.gif border=0 alt=ɾ�� align=absmiddle></a> <a href=# onClick=cut('folder',"+id+")><img src=./images/cut.gif border=0 alt=���� align=absmiddle> </a>";	
}
//*****************************�ļ�����**********************************
function cut(type,id)
{��   
	//��ȡ���ܷ�����Ϣ�� 
  var msg = document.getElementById("msg");
  setTimeout("document.getElementById('msg').style.display = 'block'",0);
	if (id>0){    
		  //���ڵ����ļ����ƶ�
      pasteid=type+"|"+id+"|cut|1"; 
      msg.innerHTML = id+"�뵽Ŀ���ļ���ճ����";
��    setcookie("pasteid",pasteid); ��
	    }else{   
	    	   //���ڶ�ѡ���ļ����ƶ�
	    	   //��ȡ�����е���Ϣ��
	         selectnum=checklistid(); 
           //��ȡ��������û���Ϣֵ
��         var f = document.form3;
��         var id = f.checkLines.value; 
           pasteid=type+"|"+id+"|cut|"+selectnum;
           setcookie("pasteid",pasteid); 
           msg.innerHTML = id+"�뵽Ŀ���ļ���ճ����";
           ShowTabs1(0);
           setTimeout("document.getElementById('msg').style.display = 'none'",4000);
      }
}
//*****************************ճ������*****************************
function paste(uid,layerid)
{
   
��//��ȡ���ܷ�����Ϣ��
��var msg = document.getElementById("msg");
��//���ձ���URL��ַ
��var url = "?";
��//��ҪPOST��ֵ����ÿ��������ͨ��&������
��var postStr ="filename=deal&action=paste&uid="+uid+"&layerid="+layerid;
��//ʵ����Ajax
��var ajax = InitAjax();��
��//ͨ��Post��ʽ������
��ajax.open("POST", url, true); 
��//���崫����ļ�HTTPͷ��Ϣ
��ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
��//����POST����
��ajax.send(postStr);  
��//��ȡִ��״̬
��ajax.onreadystatechange = function() { 
��//���ִ��״̬�ɹ�����ô�Ͱѷ�����Ϣд��ָ���Ĳ���
��if (ajax.readyState == 4 && ajax.status == 200) { 
	var filename=ajax.responseText; 
  //��ȡ��������û���Ϣֵ
  var f = document.form1;
  var uid=f.id.value;
  pasteid=getCookie("pasteid");
  delCookie("pasteid");
  pasteids=pasteid.split("|");
 if (pasteids[0]=="fileall"){ 
 	  //���ļ�ճ��
 	  selectnum=pasteids[3];
 	  size=pasteids[5];
 	  extend=pasteids[4];
 	  if (selectnum==1){
 	  	//ֻ��һ����ѡ��
 	  	ext=extend;
 	    filen=ajax.responseText;
 	    listids=pasteids[1].split(",");
 	    nsize=size;
 	  	showfile(ext,nsize,uid,listids,filen);
 	  	msg.innerHTML=pasteids[1]+"�����ļ�ճ���ɹ�";
 	  	ShowTabs1(0);
      setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }else if (selectnum==0){ 
    	  //û�б�ѡ��
        msg.innerHTML="û���ļ���ѡ�л��ļ�����ͬ����ѡ��";
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }else {  
    	  //ѡ�ж��
        listids=pasteids[1].split(",");
        filenames=ajax.responseText;
        filename=filenames.split(",");
        extend=extend.split(",");
        size=size.split(",");
        for (i=0;i<listids.length;i++){
        filen=filename[i];
        ext=extend[i];
        nsize=size[i];
        showfile(ext,nsize,uid,listids[i],filen);
        }
        msg.innerHTML="����ļ���ճ���ɹ�";
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }
 }
 else {//�����ļ������ļ���ճ��
    if (pasteids[0]=="folder"){
            //�����ļ���
            id=pasteids[1];
            showfolder(uid,id,filename);
            msg.innerHTML="�ļ���ճ���ɹ�"; 
            ShowTabs1(0);
            setTimeout("document.getElementById('msg').style.display = 'none'",4000); 
        }else {
        	  if (pasteids[1]!="0"){
        	   //�����ļ�
        	   id=pasteids[1];
        	   extend=pasteids[2];
             size=pasteids[3];
             showfile(extend,size,uid,id,filename);
             msg.innerHTML="�ļ�ճ���ɹ�";
             ShowTabs1(0);
             setTimeout("document.getElementById('msg').style.display = 'none'",4000);
             }else if(pasteids[2]==1){
             	      msg.innerHTML="����ͬ���ļ�����Ŀ¼��,ճ��ʧ��";
             	      ShowTabs1(0);
                    setTimeout("document.getElementById('msg').style.display = 'none'",4000);
             	     } else {
             	     	       msg.innerHTML="��ѡ���ļ�,ճ��ʧ��";
             	     	       ShowTabs1(0);
                           setTimeout("document.getElementById('msg').style.display = 'none'",4000);
                          }
             }
} 
} 
}
}
//*****************************��ʾ�ļ�*****************************
function showfile(extend,size,uid,id,filename)
{
	//��ȡ����ʱ��
 var addtime=gettime();
  
 var nowTable=document.all.ftable;
 var col = nowTable.cells.length/nowTable.rows.length;
 var row = nowTable.rows.length;
  
 var newTr=nowTable.insertRow();
 newTr.id="file"+row;
 var newTd=newTr.insertCell(0);
 var newTd1=newTr.insertCell(1);
 var newTd2=newTr.insertCell(2);
 var newTd3=newTr.insertCell(3);
 var newTd4=newTr.insertCell(4);

 newTd.innerHTML="<input type=checkbox name=checkLine id=checkLine value="+id+">";
 newTd1.innerHTML="<img src=./images/"+extend+".gif border=0 alt=�ļ� align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+id+">"+filename+"</a>";
 newTd2.innerHTML=size;
 newTd3.innerHTML=addtime;
 newTd4.innerHTML="<a href=# onClick=del('ftable','file"+row+"','file',"+id+")><img src=./images/del.gif border=0 alt=ɾ�� align=absmiddle></a> <a href=# onClick=cut('file',"+id+")><img src=./images/cut.gif border=0 alt=���� align=absmiddle></a> ";	
}
//*****************************��ʾ�ļ���*****************************
function showfolder(uid,id,filename)
{
  //��ȡ����ʱ��
  var addtime=gettime();
  
  var nowTable=document.all.ftable;
  var col = nowTable.cells.length/nowTable.rows.length;
  var row = nowTable.rows.length;
  
  var newTr=tbody1.insertRow();
      newTr.id="folder"+row;
  var newTd=newTr.insertCell(0);
  var newTd1=newTr.insertCell(1);
  var newTd2=newTr.insertCell(2);
  var newTd3=newTr.insertCell(3);
  var newTd4=newTr.insertCell(4);

      newTd.innerHTML="<input type=checkbox  name=checkfolder id=checkfolder  value="+id+" disabled>";
      newTd1.innerHTML="<img src=./images/folder.gif border=0 alt=�ļ��� align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+id+">"+filename+"</a>";
      newTd2.innerHTML="-";
      newTd3.innerHTML=addtime;
      newTd4.innerHTML="<a href=# onClick=del('ftable','folder"+row+"','file',"+id+")><img src=./images/del.gif border=0 alt=ɾ�� align=absmiddle></a> <a href=# onClick=cut('folder',"+id+")><img src=./images/cut.gif border=0 alt=���� align=absmiddle></a>";
}

//*****************************ɾ���ļ��л��ļ�*****************************
function del(tableId,typeid,type,id)
{
	//��ȡ���ܷ�����Ϣ��
  var msg = document.getElementById("msg");
	if(!confirm("��ɾ�������ļ����ļ���,ȷ��Ҫɾ����?")){
		//��ʾ��Ϣ
��  msg.innerHTML = "ȡ��ɾ��"; 
    ShowTabs1(0);
    setTimeout("document.getElementById('msg').style.display = 'none'",4000);
		return;
		};
  //����Ƿ�ɾ����ͷ	
  var objTable = document.getElementById(tableId);
  if(objTable.rows.length==1){
     alert("�Բ����㲻��ɾ�����ͷ!!!");
     return;
  }
��//���ձ���URL��ַ
��var url = "?";
��//��ҪPOST��ֵ����ÿ��������ͨ��&������
��var postStr ="filename=deal&action=delrow&type="+type+"&id="+id;
��//ʵ����Ajax
��var ajax = InitAjax();��
��//ͨ��Post��ʽ������
��ajax.open("POST", url, true); 
��//���崫����ļ�HTTPͷ��Ϣ
��ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
��//����POST����
��ajax.send(postStr);  
��//��ȡִ��״̬
��ajax.onreadystatechange = function() { 
����//���ִ��״̬�ɹ�����ô�Ͱѷ�����Ϣд��ָ���Ĳ���
����if (ajax.readyState == 4 && ajax.status == 200) { 
	      //��ȡ��Ҫɾ���е���Ϣ,��ɾ������
        var objTR = document.getElementById(typeid);
        currRowIndex = objTR.rowIndex;
        objTable.deleteRow(currRowIndex);
        //��ʾ��Ϣ
������  msg.innerHTML = ajax.responseText; 
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
����} 
��} 
}

//*****************************ѡ�񱻴�����ļ�*****************************
function bzip()
{
	var num=checklistid(); 
	if (num>0){
  //��ȡ��������û���Ϣֵ
��var f = document.form3;
��var downlistid = f.checkLines.value;
  window.open("?filename=deal&action=downlist&downlistid="+downlistid, "win"); 
} else {
	msg.innerHTML="��ѡ���ļ�����!";
	}
}
//*****************************ɾ����ѡ�е���*****************************
function deleteLine()
{
for (var i=tbody1.children.length-1; i>0 ; i-- )
	if (tbody1.children[i].firstChild.firstChild.checked )
		tbody1.deleteRow(i);
}