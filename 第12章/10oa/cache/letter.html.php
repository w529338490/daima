<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.username.value == "")
   {
   		alert("请输入名字!");
		theform.username.focus();
		return false ;
   }
   return true ;
  }
function show(c_Str){
if(document.all(c_Str).style.display=='none'){
document.all(c_Str).style.display='block'
}else{
document.all(c_Str).style.display='none'
}
}  
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> 
      	<A href="?filename=letter&action=person&typeid=<?php echo $this->ftpl_var['typeid'];?>">个人通讯录</A> | 
      	<A href="?filename=letter&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>">单位通讯录</A> | 
      	<A href="?filename=letter&action=new&typeid=<?php echo $this->ftpl_var['typeid'];?>">添加新通讯</A> |
      	<a href="?filename=user&action=infoedit"><font color=red>(点这里修改个人资料)</font></a>
      	</td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
  <tr> 
 <td  height="24"><strong>当前位置 >> <?php echo $this->ftpl_var['now_typename'];?> >> 新建通讯 </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<?php
if($this->ftpl_var['action']=="new"){
?>
<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addletter" OnSubmit="return check(this)">
        <TBODY>
          <TR> 
            <Td colSpan=2 class=tr_head height=28 align=center>新建通讯</Td>
          </TR>   
          <TR> 
            <TD class=tablerow>名 字</TD>
            <TD class=tablerow>
            	 <input type=text name="username" size=20> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>    
          <TR> 
            <TD class=tablerow>家庭地址</TD>
            <TD class=tablerow>
            	 <input type=text name="address" size=40> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>工作单位</TD>
            <TD class=tablerow>
            	 <input type=text name="work" size=40> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>手机号码</TD>
            <TD class=tablerow>
            	 <input type=text name="tel1" size=20> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>小灵通</TD>
            <TD class=tablerow>
            	 <input type=text name="tel2" size=20> 
            	</TD>
          </TR> 
          <TR> 
            <TD class=tablerow>家庭电话</TD>
            <TD class=tablerow>
            	 <input type=text name="tel3" size=20> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>QQ号码</TD>
            <TD class=tablerow>
            	 <input type=text name="qq" size=20> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>email</TD>
            <TD class=tablerow>
            	 <input type=text name="email" size=20> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>msn</TD>
            <TD class=tablerow>
            	 <input type=text name="msn" size=20> 
            	</TD>
          </TR>                                
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
                <input type="submit" name="Submit" value=" 发 送 " > 
                &nbsp; <input type="reset" name="Submit1" value=" 清 除 "> </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE>
      <?php
}
elseif($this->ftpl_var['action']=="edit"){
?>
      <TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=editletter" OnSubmit="return check(this)">
        <TBODY>
          <TR> 
            <Td colSpan=2 class=tr_head height=28 align=center>新建通讯</Td>
          </TR>   
          <TR> 
            <TD class=tablerow>名 字</TD>
            <TD class=tablerow>
            	 <input type=text name="username" size=20 value=<?php echo $this->ftpl_var['username'];?>> <FONT color=#ff0000>*</FONT>
            	</TD>
          </TR>    
          <TR> 
            <TD class=tablerow>家庭地址</TD>
            <TD class=tablerow>
            	 <input type=text name="address" size=40 value=<?php echo $this->ftpl_var['address'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>工作单位</TD>
            <TD class=tablerow>
            	 <input type=text name="work" size=40 value=<?php echo $this->ftpl_var['work'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>手机号码</TD>
            <TD class=tablerow>
            	 <input type=text name="tel1" size=20 value=<?php echo $this->ftpl_var['tel1'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>小灵通</TD>
            <TD class=tablerow>
            	 <input type=text name="tel2" size=20 value=<?php echo $this->ftpl_var['tel2'];?>> 
            	</TD>
          </TR> 
          <TR> 
            <TD class=tablerow>家庭电话</TD>
            <TD class=tablerow>
            	 <input type=text name="tel3" size=20 value=<?php echo $this->ftpl_var['tel3'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>QQ号码</TD>
            <TD class=tablerow>
            	 <input type=text name="qq" size=20 value=<?php echo $this->ftpl_var['qq'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>email</TD>
            <TD class=tablerow>
            	 <input type=text name="email" size=20 value=<?php echo $this->ftpl_var['email'];?>> 
            	</TD>
          </TR> 
                    <TR> 
            <TD class=tablerow>msn</TD>
            <TD class=tablerow>
            	 <input type=text name="msn" size=20 value=<?php echo $this->ftpl_var['msn'];?>> 
            	</TD>
          </TR>                                
          <TBODY>
            <TR> 
              <TD class=tablerow>&nbsp; </TD>
              <TD class=tablerow>
              	<input type=hidden name=type value=<?php echo $this->ftpl_var['typeid'];?>>
              	<input type=hidden name=id value=<?php echo $this->ftpl_var['id'];?>>
                <input type="submit" name="Submit" value=" 编 辑 " > 
                </TD>
            </TR>
          </TBODY>
        </FORM>
      </TABLE>
      <?php
}
elseif($this->ftpl_var['action']=="person"){
?>
      <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="15%"  valign="middle" align=center height=32 class=tr_head>姓名</td>
        <td width="20%"  valign="middle" align=center class=tr_head>手机号码</td>
        <td width="15%"  valign="middle" align=center class=tr_head>小灵通</td>
        <td width="12%"  valign="middle" align=center class=tr_head>QQ号码</td>
        <td width="20%"  valign="middle" align=center class=tr_head>email</td>
        <td width="18%"  valign="middle" align=center class=tr_head>操 作</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
      			      <tr valign=middle>
			              <td align=center height=24 class=td2><b><?php echo $this->ftpl_var['cont']['username'];?></b></td>
			              <td align=center class=td2><?php echo $this->ftpl_var['cont']['tel1'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['tel2'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['qq'];?></td>	
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['email'];?></td>	
					          <td align=center class=td2><a href=# onclick=show('list<?php echo $this->ftpl_var['cont']['id'];?>')>详情</a> <a href=?filename=letter&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=edit&id=<?php echo $this->ftpl_var['cont']['id'];?>>编辑</a> <a href=index.php?filename=letter&action=del&id=<?php echo $this->ftpl_var['cont']['id'];?>>删除</a></td>			
				           </tr>  
				           <tbody id=list<?php echo $this->ftpl_var['cont']['id'];?> style=display:none>
				           <tr  valign=middle >
			              <td align=center height=24 class=td2><b>家庭住址</b></td>
			              <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['address'];?></td>
					          <td align=center class=td2><b>家庭电话</b></td>	
					          <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['tel3'];?></td>	
				           </tr>   
				           <tr valign=middle>
			              <td align=center height=24 class=td2><b>单位地址</b></td>
			              <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['work'];?></td>
					          <td align=center class=td2><b>msn</b></td>	
					          <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['msn'];?></td>	
				           </tr>  
				           </tbody>
      <?php
}
		unset($_form);
		
} ?>	
     </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
      <?php
}
elseif($this->ftpl_var['action']=="public"){
?>
     <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="15%"  valign="middle" align=center height=32 class=tr_head>姓名</td>
        <td width="20%"  valign="middle" align=center class=tr_head>手机号码</td>
        <td width="15%"  valign="middle" align=center class=tr_head>小灵通</td>
        <td width="12%"  valign="middle" align=center class=tr_head>QQ号码</td>
        <td width="20%"  valign="middle" align=center class=tr_head>email</td>
        <td width="18%"  valign="middle" align=center class=tr_head>操 作</td>
      </tr>
            <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
      			      <tr valign=middle>
			              <td align=center height=24 class=td2><b><?php echo $this->ftpl_var['cont']['realname'];?></b></td>
			              <td align=center class=td2><?php echo $this->ftpl_var['cont']['tel1'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['tel2'];?></td>
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['qq'];?></td>	
					          <td align=center class=td2><?php echo $this->ftpl_var['cont']['email'];?></td>	
					          <td align=center class=td2><a href=# onclick=show('list<?php echo $this->ftpl_var['cont']['id'];?>')>详情</a> </td>			
				           </tr>  
				           <tbody id=list<?php echo $this->ftpl_var['cont']['id'];?> style=display:none>
				           <tr  valign=middle >
			              <td align=center height=24 class=td2><b>家庭住址</b></td>
			              <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['address'];?></td>
					          <td align=center class=td2><b>家庭电话</b></td>	
					          <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['tel3'];?></td>	
				           </tr>   
				           <tr valign=middle>
			              <td align=center height=24 class=td2><b>单位地址</b></td>
			              <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['work'];?></td>
					          <td align=center class=td2><b>msn</b></td>	
					          <td align=left class=td2 colspan=2><?php echo $this->ftpl_var['cont']['msn'];?></td>	
				           </tr>  
				           </tbody>
      <?php
}
		unset($_form);
		
} ?>	
     </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
      <?php
}
?>
      </td>
  </tr>
</table>
</body>
</html>