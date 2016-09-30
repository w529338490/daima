<?php
include "./dbconnect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style>
body{
font-size:15px;
}
A:visited {
	COLOR: #FFFFFF; TEXT-DECORATION: none
}
A:hover {
	COLOR: #FFFFFF; TEXT-DECORATION: underline
}
A:active {
	COLOR: #FFFFFF; TEXT-DECORATION: none
}
A:link {
	COLOR: #FFFFFF; TEXT-DECORATION: none
}
.message_box{
	padding:2px 2px 2px 2px;
	border:3px solid #48648C;
	background:#2C3E57 no-repeat;	
	color:#000;
	FONT-SIZE: 15px
}
.moved{
background:url(moved.gif);
}
.over{
background:url(over.gif);
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="landlord onWeb" />
<meta name="author" content="mickie" />
<meta name="keyword" content="mickiedd" />
<meta name="description" content="qq155448883,CSUST" />
<script>
var http_request = false;
function send_request(url) {
	http_request = false;
	if (window.XMLHttpRequest) { 
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
		http_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) { 
		try {
		http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
			http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) {
	alert('不能创建 XMLHttpRequest 对象!');
	return false;
	}
	http_request.onreadystatechange = processRequest;
	http_request.open('GET', url, true);
	http_request.send(null);
}
//处理返回信息
var text = '';
function send_r(url,t){
type = t;
send_request(url);
}
function processRequest() {
	if (http_request.readyState == 1) {
	//alert('正在连接');
	//document.getELementById('network_status').innerHTML = '正在连接..';
	}
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			text = http_request.responseText;
		}
	}
}

</script>
<script> 
function open_menu(){ 
document.getElementById("menu").style.visibility = "visible"; 

document.getElementById("menu").style.top = event.clientY + 'px' ; 
document.getElementById("menu").style.left = event.clientX + 'px'; 
} 
function close_menu(){ 
document.getElementById("menu").style.visibility = "hidden"; 

document.getElementById("menu").style.top = event.clientY + 'px' ; 
document.getElementById("menu").style.left = event.clientX + 'px';
} 
</script> 
<title>开心斗地主——大厅</title>
</head>

<body bgcolor="#51719E" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr><td height=36 background="images/top_bar.gif" nowrap="nowrap" width=100%>&nbsp;<font color=white>现在位置：斗地主onWeb </font></td><td nowrap="nowrap" width="120" background="images/top_bar.gif" align="right"><a href="logout_d.php"><font color="white">注销</font></a>&nbsp;</td>
</tr>
<tr><td colspan="2" align="center"><div id="rooms"><font color=white>loading...</font></div></td></tr></table>
<script>
function get_rooms(){
	send_request("get_rooms.php?time="+Math.random());
	if(text)
	document.getElementById("rooms").innerHTML = text;
}
get_rooms();
setInterval("get_rooms()", 1000);
</script>

</body>
</html>
