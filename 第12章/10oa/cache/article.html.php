<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<SCRIPT language=JavaScript>
function ruselinkurl(){
  if(document.form1.uselinkurl.checked==true){
    document.form1.linkurl.disabled=false;
     article.style.display='none';
  }else{
    document.form1.linkurl.disabled=true;
    article.style.display='';
  }
}

function checktype() 
{ 
	//document.form1.content.value = frames.message.document.body.innerHTML;
} 

function check(theform)
{
	

   if(theform.title.value == "")
   {
   		alert("请填写文章标题!");
		theform.title.focus();
		return false ;
   }
   if (theform.teacherlist.value!="")
   {
   	if (theform.outtime.value=="")
   	{
   		alert("请选择事件发生的具体日期!");
		theform.outtime.focus();
		return false ;
   	}
  }
if(theform.typeid.value ==0)
   {
   		alert("请选择版块!");
		theform.typeid.focus();
		return false ;
   }
 if(theform.manageid.value ==0)
   {
   		alert("请选择部门!");
		theform.manageid.focus();
		return false ;
   }
/*if (theform.viewhtml.checked == true)
   {
	  alert("对不起，请取消“查看HTML源代码”后再添加！");
	  theform.viewhtml.focus()
	  return false
   }*/
   return true;     
 }

function selDel( list )
{
    var len = list.options.length;
    var idx = 0;

    while ( idx< len ){

        if ( list.options[idx].selected ){
        	  valuew=list.options[idx].value;
            list.options.remove(idx);
            len = list.options.length;
            rmsoft(valuew);
        }
        else{
            idx ++;
        }
    }
  
}
function getHTTPObject()           //获取Http请求对象，这个对象用于客户端向服务端发送异步的http请求
{                                   
    var http;
    
    var browser = navigator.appName;

    if(browser == "Microsoft Internet Explorer")
    {
        http = new ActiveXObject("Microsoft.XMLHTTP");  //如果用户使用IE，就返回XMLHTTP的ActiveX对象
    }
    else
    {
        http = new XMLHttpRequest();  //否则返回一个XMLHttpRequest对象
    }

    return http;
}

var http = getHTTPObject(); //获取全局的HTTP请求对象

function getHello()         //处理请求状态变化
{ 
	if (http.readyState == 4)  //4表示请求已完成
	{
		var helloStr = http.responseText;  //获取服务段的响应文本

		//插入响应到ID为ajax-sample的DIV标签内
		//document.getElementById("ttt").innerHTML = valuew+"删除"+helloStr; 
	}
}
function rmsoft(valuew)
{
	var url = "?filename=rmsoft";
  var ttttt=document.form1.addfile.value;
  var df="softid="+valuew;
	http.open("POST", url, true);  //指定服务端的地址 
	//定义传输的文件HTTP头信息
　http.setRequestHeader("Content-Type","application/x-www-form-urlencoded");   
	http.send(df); //发送变量请求        
	http.onreadystatechange = getHello; //请求状态变化时的处理函数
}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
if($this->ftpl_var['action']=='add'){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
      <td  height="24"><strong>当前位置：文章管理 >> 文章添加</strong></td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addarticle" OnSubmit="return check(this)" onReset="return ResetForm();">
    
        <TBODY>
          <TR> 
            <TH colSpan=2 class=main_title>文章添加</TH>
          </TR>
               <TR> 
              <TD class=tdrow nowrap>所属版块</TD>
              <TD class=tdrow>
                <input type=text name=typename size=15  readonly style="background-color:#eeeeee;">
              	<select name="typeid" onclick="javasctipt:if (this.selectedIndex>0) document.form1.typename.value=this.options[this.selectedIndex].text;else document.form1.typename.value='';">
                 <option value="0">选择版块</option>
                  <?php echo $this->ftpl_var['typelist'];?>
                </select> <FONT color=#ff0000>*</FONT></TD>
            </TR>        
          <TR> 
            <TD class=tdrow>标题</TD>
            <TD class=tdrow> 
            	<TABLE border=0 cellPadding=0 cellSpacing=2 width="100%">
                <!--DWLayoutTable-->
                <TBODY>
                  <TR> 
                    <TD width=64 nowrap>简短标题</TD>
                    <TD class=tdrow><SELECT name=includepic>
                        <?php echo $this->ftpl_var['includepic_list'];?>
                      </SELECT> 
                      <INPUT id=title maxLength=100 name=title size=44> <FONT color=#ff0000>*</FONT> <SELECT 
            id=titlefontcolor name=titlefontcolor>
                        <OPTION selected 
              value="#000000">颜色</OPTION>
                        <OPTION value="#000000">默认</OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #000000" value=#000000></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #ffffff" value=#FFFFFF></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #008000" value=#008000></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #800000" value=#800000></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #808000" value=#808000></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #000080" value=#000080></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #800080" value=#800080></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #808080" value=#808080></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #ffff00" value=#FFFF00></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #00ff00" value=#00FF00></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #00ffff" value=#00FFFF></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #ff00ff" value=#FF00FF></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #ff0000" value=#FF0000></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #0000ff" value=#0000FF></OPTION>
                        <OPTION 
              style="BACKGROUND-COLOR: #008080" value=#008080></OPTION>
                      </SELECT> <SELECT id=titlefonttype name=titlefonttype>
                        <OPTION selected value=0>字形</OPTION>
                        <OPTION value=1>粗体</OPTION>
                        <OPTION value=2>斜体</OPTION>
                        <OPTION value=3>粗+斜</OPTION>
                        <OPTION value=0>规则</OPTION>
                      </SELECT> </TD>
                  </TR>
                  <TR> 
                    <TD width=64> 副 标 题</TD>
                    <TD class=tdrow><INPUT id=subheading maxLength=255 name=subheading size=80></TD>
                  </TR>
                </TBODY>
              </TABLE></TD>
          </TR>
            <TR> 
              <TD class=tdrow>所属部门</TD>
              <TD class=tdrow>
              	<input type=text name=managename size=15 value="<?php echo $this->ftpl_var['managename'];?>" readonly style="background-color:#eeeeee;">
              	<select name="manageid" onclick="javasctipt:if (this.selectedIndex>0) document.form1.managename.value=this.options[this.selectedIndex].text;else document.form1.managename.value='';">
              <option value="0">选择部门</option>
              <?php echo $this->ftpl_var['management'];?>
              </select> <FONT color=#ff0000>*</FONT></TD>
            </TR>  
           <TR> 
              <TD class=tdrow>相关人员</TD>
              <TD class=tdrow>
              	<input type=text name=teacherlist id=teacherlist size=70   readonly style="background-color:#ffffff;">
              	<input type="button" name=tcheradd value=添加 onclick="window.open('index.php?filename=userlist&action=useradd','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"> 
              	<input type="button" name=tcherdel value=删除 onclick="window.open('index.php?filename=userlist&action=userdel','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">
              	<input type=hidden name=delteacherlist id=delteacherlist value=''>
              	</TD>
            </TR>     
            <TR> 
              <TD class=tdrow>选择日期</TD>
              <TD class=tdrow>
              	 <input type=text name=outtime size=15 ><FONT color=blue>&lt;=[<A  href="#" onclick="document.form1.outtime.value='<?php echo $this->ftpl_var['o_day'];?>'"><FONT color=green>今日</FONT></A>]
      	[<A  href="#" onclick="document.form1.outtime.value='<?php echo $this->ftpl_var['t_day'];?>'"><FONT color=green>明日</FONT></A>]
              	<img onclick="window.open('index.php?filename=calendar&inputname=outtime','new','height=150, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')" style="cursor:hand" src="./templates/test/images/menu/calendar.gif" border=0>
              	(如果为空则表示今日)<FONT color=#ff0000>*</FONT></TD>
            </TR>                 
            <TR> 
              <TD class=tdrow>来源</TD>
              <TD class=tdrow> <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
                  <TBODY>
                    <TR> 
                      <TD width="40%">名称 
                        <INPUT id=copyfromname maxLength=50 
            name=copyfromname size=15> <FONT color=blue>&lt;=[<A 
            href="#dd" 
            onclick="document.form1.copyfromname.value='本站原创'"><FONT 
            color=green>本站原创</FONT></A>]</FONT><FONT color=blue> [<A 
            href="#dd" 
            onclick="document.form1.copyfromname.value='教委'"><FONT 
            color=green>教委</FONT></A>]</FONT> </TD>
                      <TD class=tdrow>地 址 
                        <INPUT id=copyfromurl maxLength=200 
            name=copyfromurl size=30> </TD>
                    </TR>
                  </TBODY>
                </TABLE></TD>
            </TR>
            <TBODY id=article>
            <TR> 
              <TD class=tdrow>文章内容 </TD>
              <td> 
                <?php echo $this->ftpl_var['editor'];?>        
              </td>
            </TR>
              <TR>  <TD class=tdrow>附加文件</TD>
              <TD class=tdrow>
                <select name="addfile" size="3" style="width:100">
                </select><br>
              <a href=# onclick="javascript:open('editor.php?action=upfile&do=0&postid=<?php echo $this->ftpl_var['temppostid'];?>','upload','toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=160')"><img src="./edit/images/editor/attach_over.gif" align="absmiddle" border="0" alt="上传文件" style="cursor: hand;" onMouseOver="window.status='使用系统自带的上传程序上传文件';return true;" onMouseOut="window.status='';return true;"></a>
               <input type=button name=btnTest onclick="selDel(form1.addfile)" value="删除">
                </TD>
            </TR>
          </TBODY>
          <TBODY>
            <TR> 
              <TD class=tdrow>立即发布</TD>
              <TD class=tdrow><INPUT CHECKED id=pass name=pass type=radio 
      value=1>
                是&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id=pass name=pass type=radio 
      value=0>
                否 </TD>
            </TR>
            <TR> 
              <TD class=tdrow>&nbsp; </TD>
              <TD class=tdrow>
              	<INPUT type=hidden id=author  name=author  value="<?php echo $this->ftpl_var['real_name'];?>"> 
                <input type=hidden name=owner value=<?php echo $this->ftpl_var['user_id'];?>>
                <input type=hidden name=no_repeat value=<?php echo $this->ftpl_var['no_repeat'];?>>
                <input type="hidden" name="postid" value="<?php echo $this->ftpl_var['temppostid'];?>">
              <input type="submit" name="Submit" value=" 发 表 " OnClick="checktype()"> 
                &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
</table>
<?php
}
elseif($this->ftpl_var['action']=='edit'){
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
       <td  height="24"><strong>当前位置：文章管理 >> 文章修改</strong></td>
  </tr>
  <tr> 
    <td  height="309" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=editarticle&articleid=<?php echo $this->ftpl_var['articleid'];?>&referer=<?php echo $this->ftpl_var['referer'];?>&addtime=<?php echo $this->ftpl_var['addtime'];?>" OnSubmit="return check(this)">
    
        <TBODY>
          <TR> 
            <TH colSpan=2 class=main_title>文章修改</TH>
          </TR>
              <TD class=tdrow nowrap>所属版块</TD>
              <TD class=tdrow>
                <input type=text name=typename size=15 value="<?php echo $this->ftpl_var['typename'];?>" readonly style="background-color:#eeeeee;">
              	<select name="classid" onclick="javasctipt:if (this.selectedIndex>0) document.form1.typename.value=this.options[this.selectedIndex].text;else document.form1.typename.value='';">
                 <option value="0">选择版块</option>
                  <?php echo $this->ftpl_var['typelist'];?>
                </select> <FONT color=#ff0000>*</FONT>
               <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.classid;
                     Obj.value=<?php echo $this->ftpl_var['classid'];?>;
               </SCRIPT>
                 </TD>
          </TR>
          <TR> 
            <TD class=tdrow>标题</TD>
            <TD class=tdrow> <TABLE border=0 cellPadding=0 cellSpacing=2 width="100%">
                <!--DWLayoutTable-->
                <TBODY>
                  <TR> 
                    <TD width=64 nowrap>简短标题</TD>
                    <TD class=tdrow ><SELECT name=includepic>
                        <?php echo $this->ftpl_var['includepic_list'];?>
                      </SELECT>
                      <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.includepic;
                     Obj.value=<?php echo $this->ftpl_var['includepic'];?>;
               </SCRIPT>
                       <INPUT id=title maxLength=100  name=title size=44 value='<?php echo $this->ftpl_var['title'];?>'> <FONT color=#ff0000>*</FONT> 
                      <SELECT   id=titlefontcolor name=titlefontcolor>
                        <OPTION  value="#000000">颜色</OPTION>
                        <OPTION  value="#000000">默认</OPTION>
                        <OPTION style="BACKGROUND-COLOR: #000000"  value=#000000></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #ffffff"  value=#FFFFFF></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #008000"  value=#008000></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #800000" value=#800000></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #808000"  value=#808000></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #000080"  value=#000080></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #800080"  value=#800080></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #808080"  value=#808080></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #ffff00" value=#FFFF00></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #00ff00"  value=#00FF00></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #00ffff" value=#00FFFF></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #ff00ff" value=#FF00FF></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #ff0000"  value=#FF0000></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #0000ff"  value=#0000FF></OPTION>
                        <OPTION style="BACKGROUND-COLOR: #008080"  value=#008080></OPTION>
                      </SELECT> 
                    <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.titlefontcolor;
                     Obj.value="<?php echo $this->ftpl_var['titlefontcolor'];?>";
                     </script>
                      <SELECT id=titlefonttype name=titlefonttype>
                        <OPTION  value=0>字形</OPTION>
                        <OPTION  value=1>粗体</OPTION>
                        <OPTION  value=2>斜体</OPTION>
                        <OPTION  value=3>粗+斜</OPTION>
                        <OPTION  value=0>规则</OPTION>
                      </SELECT>
                  <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.titlefonttype;
                     Obj.value=<?php echo $this->ftpl_var['titlefonttype'];?>;
                    </script>
                      </TD>
                  </TR>
                  <TR> 
                    <TD width=64> 副 标 题</TD>
                    <TD class=tdrow><INPUT id=subheading maxLength=255 name=subheading size=80 value=<?php echo $this->ftpl_var['subheading'];?>></TD>
                  </TR>
                </TBODY>
              </TABLE></TD>
          </TR>


            <TR> 
              <TD class=tdrow>作者</TD>
              <TD class=tdrow>
              	<INPUT id=author maxLength=30 name=author size=30 value=<?php echo $this->ftpl_var['author'];?>> 
                <FONT color=blue>&lt;=[<A 
      href="#" 
      onclick="document.form1.author.value='<?php echo $this->ftpl_var['real_name'];?>'"><FONT 
      color=green><?php echo $this->ftpl_var['real_name'];?></FONT></A>] [<A 
      href="#" 
      onclick="document.form1.author.value='佚名'"><FONT 
      color=green>佚名</FONT></A>] </TD>
            </TR>
                <TR> 
              <TD class=tdrow>所属部门</TD>
              <TD class=tdrow>
              	<input type=text name=managename size=15 value="<?php echo $this->ftpl_var['managename'];?>" readonly style="background-color:#eeeeee;">
              	<select name="manageid" onclick="javasctipt:if (this.selectedIndex>0) document.form1.managename.value=this.options[this.selectedIndex].text;else document.form1.managename.value='';">
              <option value="0">选择部门</option>
              <?php echo $this->ftpl_var['management'];?>
              </select> <FONT color=#ff0000>*</FONT>
              <SCRIPT LANGUAGE="JavaScript1.2">
                 var Obj=document.form1.manageid;
                     Obj.value=<?php echo $this->ftpl_var['manageid'];?>;
               </SCRIPT>
              	</TD>
            </TR>  
                       <TR> 
              <TD class=tdrow>相关人员</TD>
              <TD class=tdrow>
              	<input type=text name=teacherlist id=teacherlist size=70   readonly style="background-color:#ffffff;" value="<?php echo $this->ftpl_var['teacherlist'];?>">
              	<input type="button" name=tcheradd value=添加 onclick="window.open('index.php?filename=userlist&action=useradd','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"> 
              	<input type="button" name=tcherdel value=删除 onclick="window.open('index.php?filename=userlist&action=userdel','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">
              	<input type=hidden name=delteacherlist id=delteacherlist value="">
              	</TD>
            </TR> 
            <TR> 
              <TD class=tdrow>选择日期</TD>
              <TD class=tdrow>
              	 <input type=text name=outtime size=15 value=<?php echo $this->ftpl_var['outtime'];?>>
              	<img onclick="window.open('index.php?filename=calendar&inputname=outtime','new','height=150, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')" style="cursor:hand" src="./templates/test/images/menu/calendar.gif" border=0>
              	(如果为空则表示今日)<FONT color=#ff0000>*</FONT></TD>
            </TR>            
            <TR> 
              <TD class=tdrow>来源</TD>
              <TD class=tdrow > <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
                  <TBODY>
                    <TR> 
                      <TD width="40%" nowrap>名称 
                        <INPUT id=copyfromname maxLength=50 
            name=copyfromname size=15 value=<?php echo $this->ftpl_var['copyfromname'];?>> <FONT color=blue>&lt;=[<A 
            href="#" 
            onclick="document.form1.copyfromname.value='本站原创'"><FONT 
            color=green>本站原创</FONT></A>]</FONT> <FONT color=blue>&lt;=[<A 
            href="#" 
            onclick="document.form1.copyfromname.value='教委'"><FONT 
            color=green>教委</FONT></A>]</FONT></TD>
                      <TD class=tdrow nowrap>地 址 
                        <INPUT id=copyfromurl maxLength=200 
            name=copyfromurl size=30 value=<?php echo $this->ftpl_var['copyfromurl'];?>> </TD>
                    </TR>
                  </TBODY>
                </TABLE></TD>
            </TR>

          <TBODY id=article <?php echo $this->ftpl_var['isartshow'];?>>
            <TR> 
              <TD class=tdrow>文章内容 </TD>
              <td> 
                <?php echo $this->ftpl_var['editor'];?>         
              </td>
            </TR>
         <TR>  <TD class=tdrow>附加文件</TD>
              <TD class=tdrow>
                <select name="addfile" size="3" style="width:100">
                <?php echo $this->ftpl_var['softselect'];?>
                </select><br>
                <div id=ttt></div> 
              <a href=# onclick="javascript:window.open('editor.php?action=upfile&do=0&postid=<?php echo $this->ftpl_var['temppostid'];?>','upload','toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=160')"><img src="./edit/images/editor/attach_over.gif" align="absmiddle" border="0" alt="上传文件" style="cursor: hand;" onMouseOver="window.status='使用系统自带的上传程序上传文件';return true;" onMouseOut="window.status='';return true;"></a>
               <input type=button name=btnTest onclick="selDel(form1.addfile)" value="删除">
                </TD>
            </TR>
          </TBODY>
          <TBODY>
            <TR> 
              <TD class=tdrow>立即发布</TD>
              <TD class=tdrow><INPUT id=pass <?php echo $this->ftpl_var['pass1'];?> name=pass type=radio value=1>
                是&nbsp;&nbsp;&nbsp;&nbsp; <INPUT id=pass <?php echo $this->ftpl_var['pass0'];?> name=pass type=radio  value=0>
                否 </TD>
            </TR>
            <TR> 
              <TD class=tdrow>&nbsp; </TD>
              <TD class=tdrow>
              	<input type=hidden name=typeid value="<?php echo $this->ftpl_var['typeid'];?>">
              <input type=hidden name=articleid value="<?php echo $this->ftpl_var['articleid'];?>">
              <input type="submit" name="Submit" value=" 发 表 " OnClick="checktype()"> 
                &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
</table>
<?php
}
elseif($this->ftpl_var['action']=="list"){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
 <td  height="24"><strong>当前位置：文章管理 >> 文章列表 </strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable-->
        <TR> 
          <TH colSpan=6 class=main_title>文章管理</TH>
        </TR>
        <tr align="center" valign="middle"> 
    <td width="10%" class=tdrowhighlight>版块</td>        	
     <td width="45%"  height="28"  class=tdrowhighlight>标题</td>
    <td width="10%"  class=tdrowhighlight >作者</td>
    <td width="10%" class=tdrowhighlight>部门</td>
    <td width="10%"  class=tdrowhighlight >时间</td>
    <td width="25%"  class=tdrowhighlight >相关操作</td>
        </tr>
        <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
          <tr  valign=middle bgColor="#f1f3f5" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"> 
        <td nowrap align="center">【<a href=?filename=list&typeid=<?php echo $this->ftpl_var['typeid'];?>><?php echo $this->ftpl_var['cont']['typename'];?></a>】</td>
    <td nowrap height="24" ><a href='<?php echo $this->ftpl_var['cont']['articleurl'];?>' target='_blank'><?php echo $this->ftpl_var['cont']['title'];?></a></td>
    <td nowrap align="center"><?php echo $this->ftpl_var['realname'];?></td>
    <td nowrap align="center"><a href=?filename=article&typeid=<?php echo $this->ftpl_var['cont']['manageid'];?>><?php echo $this->ftpl_var['cont']['managename'];?></a></td>
    <td nowrap align="center"><?php echo $this->ftpl_var['cont']['adddate'];?></td>
    <td nowrap align="center"> <a href='?filename=article&action=edit&articleid=<?php echo $this->ftpl_var['cont']['articleid'];?>&typeid=<?php echo $this->ftpl_var['typeid'];?>'>修改</a> | <a href='?filename=deal&action=deletearticle&id=<?php echo $this->ftpl_var['cont']['articleid'];?>'>删除</a></td>
  </tr>
  <?php
}
		unset($_form);
		
} ?>
    <tr align="center" valign="middle">
    <td colSpan=5 class=tdrowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
</table>
<?php
}
?>
</body>
</html>