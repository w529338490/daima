<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
<title><?php echo $this->ftpl_var['sitetitle'];?></title>
<LINK href="./templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" rel=stylesheet type=text/css>
<SCRIPT language=JavaScript>
function check(theform)
{
   if(theform.gradeid.value == "")
   {
   		alert("请选择班级!");
		theform.gradeid.focus();
		return false ;
   }
   return true ;
  }
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin:0px;background:#F8F8F0;overflow:auto;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="100%"  height="24" valign="top"> <TABLE width="100%" border=0 align=center cellPadding=2 cellSpacing=1 class=tableborder>
        <!--DWLayoutTable-->
        <TBODY>
          <TR> 
      <TD class=tablerow><!--DWLayoutEmptyCell--><B>管理选项：</B> <A 
      href="?filename=classtable&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=public">课表查询</A> | <A 
      href="?filename=classtable&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=private">我的课表</A> | <A 
      href="?filename=classtable&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=list">管理课表</A> | <A 
      href="?filename=classtable&typeid=<?php echo $this->ftpl_var['typeid'];?>&action=add">添加课程表</A> </td>
          </TR>
        </TBODY>
      </TABLE></td>
  </tr>
 <?php
if($this->ftpl_var['action']=="add"){
?> 
  <tr> 
 <td  height="24"><strong>当前位置 >> 课程表 >> 添加课程表 </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
<SCRIPT language=JavaScript>
var input_id = "";//光标所在文本框的id
function input(obj){
  iid = input_id;
  if (iid!="") {
  	if (obj!="#"){
      var inp= document.getElementById(iid)   ;
      inp.value = obj;
	    CurTabIndex=inp.tabIndex+1;//将当前tabindex的值加1
	    var  newinfo_form=document.form1;
      for (n=0;n<newinfo_form.elements.length;n++) 
          {
           if (newinfo_form.elements[n].tabIndex==CurTabIndex) //找到下一个表单元素
               {
               newinfo_form.elements[n].focus(); //移动焦点
               return true;
               } 
           }
	   }
    }
}
function selectone(n,m){
	bname="one_"+n;
	inp= document.getElementById(bname);  
	inp.value=m;
	}
</script>	
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=addclasstable&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
        <TBODY>
  <tr>
    <td width="83" height="32" align="center" valign="middle" class=tr_head>星期</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期一</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期二</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期三</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期四</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期五</td>
  </tr>
    <tr>
      <td height="28" align="center" valign="middle" class=tr_head2>节次</td> 
      <td width="80" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="79" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="75" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="74" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="79" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="69" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="80" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="85" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="73" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="75" align="center" valign="middle" class=tr_head2>教师</td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第一节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][1]" type="text" tabindex="1" size="8"  id=11 style="border:1px solid #666666;" onfocus="input_id=this.id;"  />    </td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][1]" type="text" tabindex="2" size="8" id=t11 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][1]" type="text" tabindex="17" size="8" id=21 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][1]" type="text" tabindex="18" size="8" id=t21 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][1]" type="text" tabindex="33" size="8" id=31 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][1]" type="text" tabindex="34" size="8" id=t31 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][1]" type="text" tabindex="49" size="8" id=41 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][1]" type="text" tabindex="50" size="8" id=t41 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][1]" type="text" tabindex="65" size="8" id=51 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][1]" type="text" tabindex="66" size="8" id=t51 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第二节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][2]" type="text" tabindex="3" size="8" id=12 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][2]" type="text" tabindex="4" size="8" id=t12 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][2]" type="text" tabindex="19" size="8" id=22 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][2]" type="text" tabindex="20" size="8" id=t22 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][2]" type="text" tabindex="35" size="8" id=32 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][2]" type="text" tabindex="36" size="8" id=t32 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][2]" type="text" tabindex="51" size="8" id=42 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][2]" type="text" tabindex="52" size="8" id=t42 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][2]" type="text" tabindex="67" size="8" id=52 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][2]" type="text" tabindex="68" size="8" id=t52 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第三节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][3]" type="text" tabindex="5" size="8" id=13 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][3]" type="text" tabindex="6" size="8" id=t13 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][3]" type="text" tabindex="21" size="8" id=23 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][3]" type="text" tabindex="22" size="8" id=t23 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][3]" type="text" tabindex="37" size="8" id=33 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][3]" type="text" tabindex="38" size="8" id=t33 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][3]" type="text" tabindex="53" size="8" id=43 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][3]" type="text" tabindex="54" size="8" id=t43 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][3]" type="text" tabindex="69" size="8" id=53 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][3]" type="text" tabindex="70" size="8" id=t53 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第四节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][4]" type="text" tabindex="7" size="8" id=14 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][4]" type="text" tabindex="8" size="8" id=t14 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][4]" type="text" tabindex="23" size="8" id=24 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][4]" type="text" tabindex="24" size="8" id=t24 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][4]" type="text" tabindex="39" size="8" id=34 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][4]" type="text" tabindex="40" size="8" id=t34 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][4]" type="text" tabindex="55" size="8" id=44 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][4]" type="text" tabindex="56" size="8" id=t44 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][4]" type="text" tabindex="71" size="8" id=54 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][4]" type="text" tabindex="72" size="8" id=t54 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第五节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][5]" type="text" tabindex="9" size="8" id=15 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][5]" type="text" tabindex="10" size="8" id=t15 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][5]" type="text" tabindex="25" size="8" id=25 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][5]" type="text" tabindex="26" size="8" id=t25 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][5]" type="text" tabindex="41" size="8" id=35 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][5]" type="text" tabindex="42" size="8" id=t35 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][5]" type="text" tabindex="57" size="8" id=45 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][5]" type="text" tabindex="58" size="8" id=t45 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][5]" type="text" tabindex="73" size="8" id=55 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][5]" type="text" tabindex="74" size="8" id=t55 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第六节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][6]" type="text" tabindex="11" size="8" id=16 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][6]" type="text" tabindex="12" size="8" id=t16 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][6]" type="text" tabindex="27" size="8" id=26 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][6]" type="text" tabindex="28" size="8" id=t26 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][6]" type="text" tabindex="43" size="8" id=36 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][6]" type="text" tabindex="44" size="8" id=t36 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][6]" type="text" tabindex="59" size="8" id=46 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][6]" type="text" tabindex="60" size="8" id=t46 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][6]" type="text" tabindex="75" size="8" id=56 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][6]" type="text" tabindex="76" size="8" id=t56 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
  <tr>
    <td height="24" align="center" valign="middle" class=td2>第七节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][7]" type="text" tabindex="13" size="8" id=17 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][7]" type="text" tabindex="14" size="8" id=t17 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][7]" type="text" tabindex="29" size="8" id=27 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][7]" type="text" tabindex="30" size="8" id=t27 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][7]" type="text" tabindex="45" size="8" id=37 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][7]" type="text" tabindex="46" size="8" id=t37 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][7]" type="text" tabindex="61" size="8" id=47 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][7]" type="text" tabindex="62" size="8" id=t47 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][7]" type="text" tabindex="77" size="8" id=57 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][7]" type="text" tabindex="78" size="8" id=t57 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>第八节</td>
    <td align="center" valign="middle" class=td2><input name="name[1][8]" type="text" tabindex="15" size="8" id=18 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[1][8]" type="text" tabindex="16" size="8" id=t18 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[2][8]" type="text" tabindex="31" size="8" id=28 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[2][8]" type="text" tabindex="32" size="8" id=t28 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[3][8]" type="text" tabindex="47" size="8" id=38 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[3][8]" type="text" tabindex="48" size="8" id=t38 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[4][8]" type="text" tabindex="63" size="8" id=48 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[4][8]" type="text" tabindex="64" size="8" id=t48 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="name[5][8]" type="text" tabindex="79" size="8" id=58 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <td align="center" valign="middle" class=td2><input name="teacher[5][8]" type="text" tabindex="80" size="8" id=t58 style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
  </tr>
    <tr> 
    <td align="center" valign="middle" bgcolor=green height=1 colspan=11></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>课名</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['classlist'];?></td> 
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>快捷</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['teacheronelist'];?></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>教师</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['teacherlist'];?></td>
    </tr>
        <tr>
    <td align="center" valign="middle" bgcolor=green height=1 colspan=11></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>班级</td>
    <td align="left" valign="middle" class=td2 colspan=2><?php echo $this->ftpl_var['gradelist'];?></td>
    <td height="24" align="center" valign="middle" class=td2><b>当前学期:</td>
    <td align="left" valign="middle" class=td2 colspan=7><font color=red><b><?php echo $this->ftpl_var['yearlist'];?></font></td>
    </tr>
    <tr>
    <td align="center" valign="bottom" class=td2 colspan=11 height=40>
    	 <input type=submit name=submit value=" 保 存 到 数 据 库 中 "></td> 
    </tr>
      </form>

          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
    	<SCRIPT language=JavaScript>
 document.getElementById('11').focus();
  </script>
  <?php
}
elseif($this->ftpl_var['action']=="edit"){
?>
   <tr> 
 <td  height="24"><strong>当前位置 >> 课程表 >> 编辑课程表 </strong> </td>
  </tr>
 <tr> 
    <td  height="309" valign="top"> 
    	<SCRIPT language=JavaScript>
var input_id = "";//光标所在文本框的id
function input(obj){
  iid = input_id;
  if (iid!="") {
  	if (obj!="#"){
      var inp= document.getElementById(iid)   ;
      inp.value = obj;
	    
	   }
    }
}
function selectone(n,m){
	bname="one_"+n;
	inp= document.getElementById(bname);  
	inp.value=m;
	}
</script>	
    	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
          <form id=form1 name="form1" method="post" action="?filename=deal&action=editclasstable&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
        <TBODY>
  <tr>
    <td width="83" height="32" align="center" valign="middle" class=tr_head>星期</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期一</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期二</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期三</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期四</td>
    <td colspan="2" align="center" valign="middle" class=tr_head>星期五</td>
  </tr>
    <tr>
      <td height="28" align="center" valign="middle" class=tr_head2>节次</td>
      <td width="80" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="79" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="75" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="74" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="79" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="69" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="80" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="85" align="center" valign="middle" class=tr_head2>教师</td>
    <td width="73" align="center" valign="middle" class=tr_head2>课名</td>
    <td width="75" align="center" valign="middle" class=tr_head2>教师</td>
  </tr>
  <?php 
$_from = $this->ftpl_var['classnum_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
  <tr>
    <td height="24" align="center" valign="middle" class=td2><?php echo $this->ftpl_var['cont'];?></td> 
    <?php 
$_from = $this->ftpl_var['week_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid2'] => $this->ftpl_var['c']){
?>
    <td align="center" valign="middle" class=td2><input name="name[<?php echo $this->ftpl_var['keyid2'];?>][<?php echo $this->ftpl_var['keyid'];?>]" type="text"  value="<?php echo $this->ftpl_var['name'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?>" tabindex="1" size="8"  id=<?php echo $this->ftpl_var['keyid2'];?><?php echo $this->ftpl_var['keyid'];?> style="border:1px solid #666666;" onfocus="input_id=this.id;"  />    </td>
    <td align="center" valign="middle" class=td2><input name="teacher[<?php echo $this->ftpl_var['keyid2'];?>][<?php echo $this->ftpl_var['keyid'];?>]" type="text" value="<?php echo $this->ftpl_var['teacher'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?>" tabindex="2" size="8" id=t<?php echo $this->ftpl_var['keyid2'];?><?php echo $this->ftpl_var['keyid'];?> style="border:1px solid #666666;" onfocus="input_id=this.id;" /></td>
    <?php
}
		unset($_form);
		
} ?>
  </tr>
<?php
}
		unset($_form);
		
} ?>
    <tr> 
    <td align="center" valign="middle" bgcolor=green height=1 colspan=11></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>课名</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['classlist'];?></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>快捷</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['teacheronelist'];?></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>教师</td>
    <td align="left" valign="middle" class=td2 colspan=10><?php echo $this->ftpl_var['teacherlist'];?></td>
    </tr>
        <tr>
    <td align="center" valign="middle" bgcolor=green height=1 colspan=11></td>
    </tr>
    <tr>
    <td height="24" align="center" valign="middle" class=td2>班级</td>
    <td align="left" valign="middle" class=td2 colspan=2><?php echo $this->ftpl_var['gradelist'];?>
    	    <SCRIPT LANGUAGE="JavaScript1.2">
    	    var Obj=document.form1.gradeid;
    	    Obj.value="<?php echo $this->ftpl_var['class'];?>"; 
         </SCRIPT>
    	</td>
    <td height="24" align="center" valign="middle" class=td2><b>当前学期:</td>
    <td align="left" valign="middle" class=td2 colspan=7><font color=red><b><?php echo $this->ftpl_var['yearlist'];?></font></td>
    </tr>
    <tr>
    <td align="center" valign="bottom" class=td2 colspan=11 height=40>
    	<?php echo $this->ftpl_var['hideid'];?>
    	<input type=hidden name=upid value=<?php echo $this->ftpl_var['upid'];?>>
    	 <input type=submit name=submit value=" 保 存 到 数 据 库 中 "></td>
    </tr>
      </form>

          </TBODY>
        </FORM>
      </TABLE></td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=="list"){
?>
   <tr> 
 <td  height="24" ><strong>当前位置 >> <?php echo $this->ftpl_var['now_typename'];?> >> 管理课表</strong> </td>
  </tr>
  <tr>
    <td  height="85" valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" >
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="8%"  valign="middle" align=center height=32 class=tr_head>班级</td>
        <td width="20%"  valign="middle" align=center class=tr_head>课程表</td>
        <td width="30%"  valign="middle" align=center class=tr_head>操作</td>
      </tr>
      <?php 
$_from = $this->ftpl_var['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
         <tr>
   <td height=24 align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['classname'];?></td>
   <td  align=center valign=middle class=td1><?php echo $this->ftpl_var['cont']['title'];?></td>
   <td  align=center valign=middle class=td1> 
   	   <a href='?filename=classtable&class=<?php echo $this->ftpl_var['cont']['class'];?>&inyear=<?php echo $this->ftpl_var['cont']['inyear'];?>&upid=<?php echo $this->ftpl_var['cont']['id'];?>&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&action=edit'>编辑</a> | <a href='?filename=classtable&id=<?php echo $this->ftpl_var['cont']['id'];?>&typeid=<?php echo $this->ftpl_var['cont']['typeid'];?>&action=del'>删除</a> </td>
   </tr>
      <?php
    }
}
else{
 unset($_form);?>
         <tr>
   <td height=24 align=center valign=middle class=td1 colspan=3>还没有班级课表</td>
   </tr>
      <?php  
}
?>
     </table>
    </td>
    </tr>
    <tr align="center" valign="middle">
    <td  class=tablerowhighlight><?php echo $this->ftpl_var['pagenav'];?></td>
    </tr>
    </TABLE>
    </td>
  </tr>
</table>
  <?php
}
elseif($this->ftpl_var['action']=="private"){
?>
  <tr> 
     <td  height="24" ><strong>当前位置 >> 课程表 >> 我的课程表</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top"> 
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=tr_head>我 的 课 程 表</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" > 
        		<form id=form1 name="form1" method="post" action="?filename=classtable&action=private&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
            <tr>
            	<td width=10% align=center valign=middle height=24><font color=blue><b>查询:</font></td>
            	<td width=90% align=left valign=middle  >
            	  <input type="text" name=selectyear size=10> 年(格式：2009)
            	  <input type=hidden name=do value=1>
            	  <input type=submit name=sub value="显示我的课程表">
            		</td>
            </tr>
          </form>
            <tr>
            	<td width=100% height=1 colspan=2 bgcolor=green> </td>
            </tr>
                        <tr>
            	<td width=100% height=32 colspan=2><font color=red> <b>『<?php echo $this->ftpl_var['showtablename'];?>课程表』</font><a href=?filename=classtable&action=savetoword&inyear=<?php echo $this->ftpl_var['select'];?>>【保存为word】</a></td>
            </tr>
            <tr>
              <td width="100%"  valign="middle" align=center colspan=2>
        	          	<TABLE cellPadding=2 cellSpacing=1 class=tableborder width="100%" >
        <!--DWLayoutTable--> 
        <TBODY>
  <tr>
    <td width="10%" height="32" align="center" valign="middle" class=tr_head>星期</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期一</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期二</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期三</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期四</td>
    <td  width=18% align="center" valign="middle" class=tr_head>星期五</td>
  </tr>
    <tr>
      <td height="28" align="center" valign="middle" class=tr_head2>节次</td>
      <td  align="center" valign="middle" class=tr_head2>课名/班级</td>
    
    <td align="center" valign="middle" class=tr_head2>课名/班级</td>

    <td  align="center" valign="middle" class=tr_head2>课名/班级</td>
    
    <td align="center" valign="middle" class=tr_head2>课名/班级</td>

    <td  align="center" valign="middle" class=tr_head2>课名/班级</td>
    
  </tr>
  <?php 
$_from = $this->ftpl_var['classnum_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid'] => $this->ftpl_var['cont']){
?>
  <tr>
    <td height="24" align="center" valign="middle" class=td2><?php echo $this->ftpl_var['cont'];?></td>
    <?php 
$_from = $this->ftpl_var['week_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from)){
    foreach ($_from as $this->ftpl_var['keyid2'] => $this->ftpl_var['c']){
?>
    <td align="center" valign="middle" class=td2><?php echo $this->ftpl_var['name'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?>/<?php echo $this->ftpl_var['classnum'][$this->ftpl_var['keyid2']][$this->ftpl_var['keyid']];?></td>
    <?php
}
		unset($_form);
		
} ?>
  </tr>
 <?php
}
		unset($_form);
		
} ?> 
          </TBODY>

      </TABLE>
              </td>
             </tr>
          </table>
        </td>
      </tr>
     </table>
    </td>
   </tr>
    </TABLE>
    </td>
  </tr>
  <?php
}
elseif($this->ftpl_var['action']=='public'){
?>
    <tr> 
     <td  height="24" ><strong>当前位置 >> 课程表 >> 课表查询</strong> </td>
  </tr>
  <tr>
    <td  valign="top"> 
    	<script>
function openurl(selectclass,selectyear,usertype){
	window.open("index.php?filename=classtable&action=selectshow&do=1&usertype="+usertype+"&selectclass="+selectclass+"&selectyear="+selectyear,"newu","height=310, width=600, top=200, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}
function toword(selectyear,tok){
//location.href="index.php?filename=classtable&action=savealltoword&selectyear="+selectyear+"&selectm="+selectm;
window.open("index.php?filename=classtable&action=savealltowordone&selectyear="+selectyear+"&tok="+tok,"newu","height=100, width=200, top=300, left=300, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
}
function check(theform)
{
}
</script>
    <TABLE cellPadding=2 cellSpacing=1  width="100%" >
        <!--DWLayoutTable-->
    <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class=tableborder>
       <!--DWLayoutTable-->
       <tr>
        <td width="100%"  valign="middle" align=center height=32 class=tr_head>课表查询</td>
      </tr>
      <tr>
        <td width="100%"  valign="middle" align=center>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
                		<form id=form1 name="form1" method="post" action="?filename=classtable&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
            <tr>
            	<td width=20% align=center valign=middle height=24><font color=blue><b>查询班级课表:</font></td>
            	<td width=80% align=left valign=middle>
            		<?php echo $this->ftpl_var['gradelist'];?>
            	  <input type="text" name=selectyear size=10> 年 
            	  <input type=hidden name=do value=1>
            	  <input type=submit name=sub value="显示课程表" onclick=openurl(form1.gradeid.value,form1.selectyear.value,"c")>
            		</td>
            </tr>
          </form>
            <tr>
            	<td width=100% height=1 colspan=4 bgcolor=green> </td>
            </tr>
            <form id=form2 name="form2" method="post" action="?filename=classtable&action=public&typeid=<?php echo $this->ftpl_var['typeid'];?>" OnSubmit="return check(this)"  >
            <tr>
            	<td width=5% align=center valign=middle height=24><font color=blue><b>查询教师课表:</font></td>
            	<td width=45% align=left valign=middle colspan=3>
            		<input type="text" name=teacher value="" size=10 readonly>
            		[<A href="#dd" onclick="window.open('index.php?filename=userlist&action=useradd_3','new','height=180, width=200, top=200, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><FONT 
                  color=green>选择教师</FONT></A>] </FONT>
            		  <input type="text" name=selectyear size=10> 年 
            	  <input type=hidden name=do value=1>
            	  <input type=submit name=sub value="显示课程表" onclick=openurl(form2.teacher.value,form2.selectyear.value,"t")>
            </td>
          </tr></form>
                        <tr>
            	<td width=100% height=1 colspan=4 bgcolor=blue> </td>
            </tr>
            <tr><form name=form3>
            <tr>
            	<td width=5% align=center valign=middle height=24><font color=red><b>生成全部课表:</font></td>
            	<td width=45% align=left valign=middle colspan=3 ><input type="text" name=selectyear size=10> 年
            		<a href="#" onclick=toword(form3.selectyear.value,"t")>所有教师课表保存为word</a> | 
            		<a href="#" onclick=toword(form3.selectyear.value,"c")>所有班级课表保存为word</a>
            </td>
          </tr></form>
           <tr>
            	<td width=100% height=20 colspan=4 bgcolor=#eeeeee align=center><font color=red><b>说明：年份输入格式为 2008 或 2009 这种格式 不允许为 08 或 09 简单格式</font><font color=blue><b>----不输入为默认当年</font></td>
            </tr>
          </table>
        </td>
      </tr> 
     </table>
    </td>
   </tr>
  <?php
}
?>
</table>
</body>
</html>