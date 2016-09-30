//*****************************对多选框进行选择*****************************
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

//*****************************初始化ajax*****************************
function InitAjax()
{
　var ajax=false; 
　try { 
　　ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
　} catch (e) { 
　　try { 
　　　ajax = new ActiveXObject("Microsoft.XMLHTTP"); 
　　} catch (E) { 
　　　ajax = false; 
　　} 
　}
　if (!ajax && typeof XMLHttpRequest!='undefined') { 
　　ajax = new XMLHttpRequest(); 
　} 
　return ajax;
} 
//*****************************获取标签值*****************************
function $(a) 
{ 
    return document.getElementById(a); 
}  
//*****************************设置cookies函数*****************************
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
//*****************************取cookies函数*****************************  
function getCookie(name)      
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
//*****************************删除cookie*****************************
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
//*****************************获取系统时间*****************************
function gettime()
{
 //获取更新时间
  var addtime=new Date().getYear()+"-"; 
      addtime+=new Date().getMonth()+1+"-"; 
      addtime+=new Date().getDate()+"-"; 

      addtime+=new Date().getHours()+":"; 
      addtime+=new Date().getMinutes()+":"; 
      addtime+=new Date().getSeconds(); 
      return addtime;
}
//*****************************创建新文件夹*****************************
function creatfolder()
{
	//设置cookie传递到deal.php中
	setcookie("foldername",$('foldername').value); 
　//获取接受返回信息层
　var msg = document.getElementById("msg");
　//获取表单对象和用户信息值
　var f = document.form1;
　var foldername = f.foldername.value;
　var id = f.id.value;
  var layerid = f.layerid.value;

　//接收表单的URL地址
　var url = "?";
　//需要POST的值，把每个变量都通过&来联接
　var postStr ="filename=deal&action=creatfolder&uid="+id+"&layerid="+layerid;

　//实例化Ajax
　var ajax = InitAjax();
　//通过Post方式打开连接
　ajax.open("POST", url, true); 
　//定义传输的文件HTTP头信息
　ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
　//发送POST数据
　ajax.send(postStr);
  
　//获取执行状态
　ajax.onreadystatechange = function() { 
　　//如果执行状态成功，那么就把返回信息写到指定的层里
　　if (ajax.readyState == 4 && ajax.status == 200) { 
      //获取cid值
      cid=getCookie("tempid");
      delCookie("tempid");
      //调用addfolder函数
      if (cid!=0) addfolder(cid);
      //显示信息
　　　msg.innerHTML = ajax.responseText;  
      ShowTabs1(0);
      setTimeout("document.getElementById('msg').style.display = 'none'",4000);
　　} 
　} 
} 
//到页面去粘贴相应的新创建的文件夹或被剪切的文件夹的html代码
function addfolder(cid)
{
  //获取更新时间
  var addtime=gettime(); 

 //获取表单对象和用户信息值
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
newTd1.innerHTML="<img src=./images/folder.gif border=0 alt=文件夹 align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+cid+">"+foldername+"</a>";
newTd2.innerHTML="-";
newTd3.innerHTML=addtime;
newTd4.innerHTML="<a href=# onClick=del('ftable','folder"+row+"','folder',"+cid+")><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('folder',"+id+")><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle> </a>";	
}
//*****************************文件剪切**********************************
function cut(type,id)
{　   
	//获取接受返回信息层 
  var msg = document.getElementById("msg");
  setTimeout("document.getElementById('msg').style.display = 'block'",0);
	if (id>0){    
		  //用于单条文件的移动
      pasteid=type+"|"+id+"|cut|1"; 
      msg.innerHTML = id+"请到目标文件夹粘贴！";
　    setcookie("pasteid",pasteid); 　
	    }else{   
	    	   //用于多选框文件的移动
	    	   //获取被剪切的信息数
	         selectnum=checklistid(); 
           //获取表单对象和用户信息值
　         var f = document.form3;
　         var id = f.checkLines.value; 
           pasteid=type+"|"+id+"|cut|"+selectnum;
           setcookie("pasteid",pasteid); 
           msg.innerHTML = id+"请到目标文件夹粘贴！";
           ShowTabs1(0);
           setTimeout("document.getElementById('msg').style.display = 'none'",4000);
      }
}
//*****************************粘贴函数*****************************
function paste(uid,layerid)
{
   
　//获取接受返回信息层
　var msg = document.getElementById("msg");
　//接收表单的URL地址
　var url = "?";
　//需要POST的值，把每个变量都通过&来联接
　var postStr ="filename=deal&action=paste&uid="+uid+"&layerid="+layerid;
　//实例化Ajax
　var ajax = InitAjax();　
　//通过Post方式打开连接
　ajax.open("POST", url, true); 
　//定义传输的文件HTTP头信息
　ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
　//发送POST数据
　ajax.send(postStr);  
　//获取执行状态
　ajax.onreadystatechange = function() { 
　//如果执行状态成功，那么就把返回信息写到指定的层里
　if (ajax.readyState == 4 && ajax.status == 200) { 
	var filename=ajax.responseText; 
  //获取表单对象和用户信息值
  var f = document.form1;
  var uid=f.id.value;
  pasteid=getCookie("pasteid");
  delCookie("pasteid");
  pasteids=pasteid.split("|");
 if (pasteids[0]=="fileall"){ 
 	  //多文件粘贴
 	  selectnum=pasteids[3];
 	  size=pasteids[5];
 	  extend=pasteids[4];
 	  if (selectnum==1){
 	  	//只有一个被选中
 	  	ext=extend;
 	    filen=ajax.responseText;
 	    listids=pasteids[1].split(",");
 	    nsize=size;
 	  	showfile(ext,nsize,uid,listids,filen);
 	  	msg.innerHTML=pasteids[1]+"单个文件粘贴成功";
 	  	ShowTabs1(0);
      setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }else if (selectnum==0){ 
    	  //没有被选中
        msg.innerHTML="没有文件被选中或文件名相同，请选择！";
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }else {  
    	  //选中多个
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
        msg.innerHTML="多个文件被粘贴成功";
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
    }
 }
 else {//单个文件或者文件夹粘贴
    if (pasteids[0]=="folder"){
            //单个文件夹
            id=pasteids[1];
            showfolder(uid,id,filename);
            msg.innerHTML="文件夹粘贴成功"; 
            ShowTabs1(0);
            setTimeout("document.getElementById('msg').style.display = 'none'",4000); 
        }else {
        	  if (pasteids[1]!="0"){
        	   //单个文件
        	   id=pasteids[1];
        	   extend=pasteids[2];
             size=pasteids[3];
             showfile(extend,size,uid,id,filename);
             msg.innerHTML="文件粘贴成功";
             ShowTabs1(0);
             setTimeout("document.getElementById('msg').style.display = 'none'",4000);
             }else if(pasteids[2]==1){
             	      msg.innerHTML="有相同的文件存在目录中,粘贴失败";
             	      ShowTabs1(0);
                    setTimeout("document.getElementById('msg').style.display = 'none'",4000);
             	     } else {
             	     	       msg.innerHTML="请选中文件,粘贴失败";
             	     	       ShowTabs1(0);
                           setTimeout("document.getElementById('msg').style.display = 'none'",4000);
                          }
             }
} 
} 
}
}
//*****************************显示文件*****************************
function showfile(extend,size,uid,id,filename)
{
	//获取更新时间
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
 newTd1.innerHTML="<img src=./images/"+extend+".gif border=0 alt=文件 align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+id+">"+filename+"</a>";
 newTd2.innerHTML=size;
 newTd3.innerHTML=addtime;
 newTd4.innerHTML="<a href=# onClick=del('ftable','file"+row+"','file',"+id+")><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('file',"+id+")><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a> ";	
}
//*****************************显示文件夹*****************************
function showfolder(uid,id,filename)
{
  //获取更新时间
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
      newTd1.innerHTML="<img src=./images/folder.gif border=0 alt=文件夹 align=absmiddle> <a href=?filename=main&uid="+uid+"&id="+id+">"+filename+"</a>";
      newTd2.innerHTML="-";
      newTd3.innerHTML=addtime;
      newTd4.innerHTML="<a href=# onClick=del('ftable','folder"+row+"','file',"+id+")><img src=./images/del.gif border=0 alt=删除 align=absmiddle></a> <a href=# onClick=cut('folder',"+id+")><img src=./images/cut.gif border=0 alt=剪切 align=absmiddle></a>";
}

//*****************************删除文件夹或文件*****************************
function del(tableId,typeid,type,id)
{
	//获取接受返回信息层
  var msg = document.getElementById("msg");
	if(!confirm("将删除里面文件和文件夹,确定要删除吗?")){
		//显示信息
　  msg.innerHTML = "取消删除"; 
    ShowTabs1(0);
    setTimeout("document.getElementById('msg').style.display = 'none'",4000);
		return;
		};
  //检测是否删除表头	
  var objTable = document.getElementById(tableId);
  if(objTable.rows.length==1){
     alert("对不起，你不能删除表格头!!!");
     return;
  }
　//接收表单的URL地址
　var url = "?";
　//需要POST的值，把每个变量都通过&来联接
　var postStr ="filename=deal&action=delrow&type="+type+"&id="+id;
　//实例化Ajax
　var ajax = InitAjax();　
　//通过Post方式打开连接
　ajax.open("POST", url, true); 
　//定义传输的文件HTTP头信息
　ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
　//发送POST数据
　ajax.send(postStr);  
　//获取执行状态
　ajax.onreadystatechange = function() { 
　　//如果执行状态成功，那么就把返回信息写到指定的层里
　　if (ajax.readyState == 4 && ajax.status == 200) { 
	      //获取当要删除行的信息,并删除此行
        var objTR = document.getElementById(typeid);
        currRowIndex = objTR.rowIndex;
        objTable.deleteRow(currRowIndex);
        //显示信息
　　　  msg.innerHTML = ajax.responseText; 
        ShowTabs1(0);
        setTimeout("document.getElementById('msg').style.display = 'none'",4000);
　　} 
　} 
}

//*****************************选择被打包的文件*****************************
function bzip()
{
	var num=checklistid(); 
	if (num>0){
  //获取表单对象和用户信息值
　var f = document.form3;
　var downlistid = f.checkLines.value;
  window.open("?filename=deal&action=downlist&downlistid="+downlistid, "win"); 
} else {
	msg.innerHTML="请选中文件下载!";
	}
}
//*****************************删除被选中的行*****************************
function deleteLine()
{
for (var i=tbody1.children.length-1; i>0 ; i-- )
	if (tbody1.children[i].firstChild.firstChild.checked )
		tbody1.deleteRow(i);
}