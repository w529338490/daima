<? include "../Configuration.php"?>
<? include "../include/isAdmin.php" ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCMS
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<HTML>
<HEAD>
<title><?=$TitleName?></title>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<STYLE>.yToolbar {
	BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid; LEFT: 1px; BACKGROUND-IMAGE:   VISIBILITY: visible; BORDER-LEFT: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid; POSITION: relative; TOP: 0px; BACKGROUND-COLOR: #efefef
}
.TBHandle {
	BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid; FONT-SIZE: 1px; BORDER-LEFT: buttonhighlight 1px solid; WIDTH: 3px; POSITION: absolute; TOP: 1px; HEIGHT: 22px; BACKGROUND-COLOR: buttonface
}
.TBHandle2 {
	BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid; FONT-SIZE: 1px; BORDER-LEFT: buttonhighlight 1px solid; WIDTH: 3px; POSITION: absolute; TOP: 1px; HEIGHT: 50px; BACKGROUND-COLOR: buttonface
}
.TBSep {
	BORDER-RIGHT: buttonhighlight 1px solid; FONT-SIZE: 0px; BORDER-LEFT: buttonshadow 1px solid; WIDTH: 1px; POSITION: absolute; TOP: 1px; HEIGHT: 22px
}
.flyoutLink A {
	COLOR: black; TEXT-DECORATION: none
	font-size:12px;
}
.flyoutLink A:hover {
	COLOR: black; TEXT-DECORATION: none
	font-size:12px;
}
.flyoutLink A:visited {
	COLOR: black; TEXT-DECORATION: none
	font-size:12px;
}
.flyoutLink A:active {
	COLOR: black; TEXT-DECORATION: none
	font-size:12px;
}
A {
	COLOR: #111111; TEXT-DECORATION: none
	font-size:12px;
}

.flyoutMenu {
	BACKGROUND-COLOR: #efefef

}
.flyoutMenu TD.flyoutLink {
	BORDER-RIGHT: #efefef 1px solid; BORDER-TOP: #efefef 1px solid; BORDER-LEFT: #efefef 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #efefef 1px solid
}
.flyoutMenu1 {
	BACKGROUND-COLOR: #fbf9f9
}
.flyoutMenu1 TD.flyoutLink1 {
	BORDER-RIGHT: #fbf9f9 1px solid; BORDER-TOP: #fbf9f9 1px solid; BORDER-LEFT: #fbf9f9 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #fbf9f9 1px solid
}
.top_font1 {
	font-size:12px;
}
</STYLE>
<SCRIPT>
function switchSysBar(){
if (document.all("switchPoint").innerText=='&nbsp;'){
document.all("switchPoint").innerText=4
document.all("frmTitle").style.display="none"
}else{
document.all("switchPoint").innerText='&nbsp;'
document.all("frmTitle").style.display=""
}}
function switchSysBarInfo(){
document.all("switchPoint").innerText='&nbsp;'
document.all("frmTitle").style.display=""
}

function about()
{
window.showModalDialog("adminstyle/2/help/about.htm","ABOUT","dialogwidth:300px;dialogheight:150px;center:yes;status:no;scroll:no;help:no");
}

function over(){
	if(obj=event.srcElement)
		if(obj.className=="flyoutLink"){
			obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'
		}else if(obj.className=="flyoutLink1"){
		    obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'				
			}
}
function out(){
	if(obj=event.srcElement)
		if(obj.className=="flyoutLink"){
			obj.style.backgroundColor='EFEFEF'
			obj.style.borderColor = 'EFEFEF'
		}else if(obj.className=="flyoutLink1"){
		    obj.style.backgroundColor='#FBF9F9'
			obj.style.borderColor = '#FBF9F9'				
			}
}
function show(d){
	if(obj=document.all(d))	obj.style.visibility="visible";

}
function hide(d){
	if(obj=document.all(d))	obj.style.visibility="hidden";
}

document.onmouseover=over
document.onmouseout=out
</SCRIPT>
<SCRIPT language=javascript>       
<!--       
var displaymode=0       
//var iframecode='<iframe id="jshtml" style="width:85%;height:200px" src="http://www.phome.net"></iframe>'
//if (displaymode==0)       
//document.write(iframecode)       
       
function jumpto(inputurl){       
if (document.getElementById&&displaymode==0)       
document.getElementById("main").src=inputurl       
else if (document.all&&displaymode==0)       
document.all.external.src=inputurl       
else{       
if (!window.win2||win2.closed)       
win2=window.open(inputurl)       
//else if win2 already exists       
else{       
}       
}       
}       
//-->       
</SCRIPT>
<SCRIPT>

<!--

function winopen(){

var targeturl=""
//closetime=1
//oldwin=window
newwin=window.open("","","")


if (document.all){

newwin.moveTo(0,0)

newwin.resizeTo(screen.width,screen.height)
newwin.focus();
//self.close();
//window.setTimeout("window.close();",5000);
//if (closetime) setTimeout("oldwin.close();", closetime*1000);
}

newwin.location=targeturl

}

function winopen1(){

var targeturl="../../index.htm"
//closetime=1
//oldwin=window
newwin=window.open("","","")


if (document.all){

newwin.moveTo(0,0)

newwin.resizeTo(screen.width,screen.height)
newwin.focus();
//self.close();
//window.setTimeout("window.close();",5000);
//if (closetime) setTimeout("oldwin.close();", closetime*1000);
}
newwin.location=targeturl
}
//-->
</SCRIPT>
<SCRIPT language=JavaScript type=text/JavaScript>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</SCRIPT>
<noscript><iframe src=*.htm></iframe></noscript>
</HEAD>
<BODY bgColor=#efefef leftMargin=0 topMargin=0>
<DIV class=yToolbar id=FormatToolbar> 
  <TABLE width="100%" border=0>
    <TBODY>
      <TR> 
        <TD class=flyoutMenu width="1%"> <DIV class=TBHandle></DIV></TD>
        <TD width="99%"> <TABLE class=flyoutMenu width=879 border=0>
            <TBODY>
              <TR align=middle> 
			  <? 
				for($i=0;$i<count($_SESSION['SessionMenu']);$i++)
				{
				  if((int)$_SESSION['SessionMenu'][$i]['pid']==0)
				  {
			  ?>
                <TD class='top_font1'
          onclick="show('menu<?=$_SESSION['SessionMenu'][$i]['id']?>');"><a target="center" href="center.php?menuid=<?=$_SESSION['SessionMenu'][$i]['id']?>"><?=$_SESSION['SessionMenu'][$i]['name']?></a>
		  		
		  		</TD>
				<?
					}
				}
				?>
              </TR>
            </TBODY>
          </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>
</DIV>
<script Language=JavaScript>

var OA_TIME = new Date();

function timeview()
{
  timestr=OA_TIME.toLocaleString();
  timestr=timestr.substr(timestr.indexOf(" "));
  time_area.innerHTML = timestr;
  OA_TIME.setSeconds(OA_TIME.getSeconds()+1);
  window.setTimeout( "timeview()", 1000 );
}
</script>
<DIV class=yToolbar id=FormatToolbar> 
  <TABLE width="100%" border=0>
    <TBODY>
      <TR> 
        <TD class=flyoutMenu width="1%"> <DIV class=TBHandle2></DIV></TD>
        <TD width="99%" height=50> 
          <TABLE width=100% border=0 cellSpacing=0 class="top_font1">
            <TBODY>
              <TR align=middle> 
			    <?
				if(isAdmin())
				{
				?>
				<?
				}
				?>
				<TD width=75 align="center"><font color="#000000"><img src="../icon/i_home.gif" width="16" height="18" border="0"></font></TD>
				<TD width=75 align="center"><font color="#000000"><img src="../icon/trash.gif" width="18" height="18" border="0"></font></TD>
				<TD rowspan="2" align="right" >				  </TD>
				<TD rowspan="2" align="right">
				<font color="#000000">
				
				用户：
				<?=$_SESSION['SessionAdminUser']['username']?>  
                  </font>				  </TD>
			    <TD rowspan="2" align="right" width="50"></strong></TD>
              </TR>
              <TR align=middle> 
			  	<?
				if(isAdmin())
				{
				?>
				<?
				}
				?>
				<TD width="75" align="center"><a href="../index.php" target="_blank">首页</a></TD>
				<TD width="75" align="center"><a href="logout.php">登出</a></TD>
			  </TR>
            </TBODY>
          </TABLE>
        </TD>
      </TR>
    </TBODY>
  </TABLE>
</DIV>
<TABLE borderColor=#ff0000 height="85.5%" cellSpacing=0 width="100%" border=0>
  <TBODY>
    <TR> 
      <TD width="123" valign="top" bgcolor="#ffffff"><IFRAME frameBorder=0 id=dorepage name=dorepage scrolling=no src=DoTimeRepage.php style=HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1></IFRAME></TD>
      <TD noWrap id=frmTitle  bgcolor="#ffffff"> <IFRAME frameBorder=0 name=left scrolling=auto src="left.php" style=HEIGHT:100%;VISIBILITY:inherit;WIDTH:160px;Z-INDEX:2></IFRAME></TD>
      <TD> <TABLE border=0 cellPadding=0 cellSpacing=0 height=100% bgcolor="#efefef">
          <TBODY>
            <tr> 
              <TD onclick=switchSysBar() style=HEIGHT:100%;> <font style=COLOR:#efefef;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:9pt;> 
                <SPAN id="switchPoint" title=Open/Close>&nbsp;</SPAN></font> 
          </TBODY>
        </TABLE></TD>
      <TD width="100%" height="400"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" align=right 
      border=0>
          <TBODY>
            <TR> 
              <TD align=right height=493   bgcolor="#FFFFFF"> <IFRAME id="center" name=center 
            style="WIDTH: 100%; HEIGHT: 100%" src="center.php"
            frameBorder=0>
                </IFRAME></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
    </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML> 

