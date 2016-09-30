<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoBlog
 * @.
 * @Website		.
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/register/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td  class="register_container">
    	   <script language="javascript">
			function send_request_get_reg(url) {
				create_request();
				http_request.onreadystatechange = processCheckUsername;
				http_request.open("GET", url, true);
				http_request.send(null);
			}
			
			function send_request_post_reg(url,querystring,func) {
				create_request();
				if(func=='reg') http_request.onreadystatechange = processReg;
				http_request.open("POST", url, true);
				http_request.setRequestHeader("Content-Type"," application/x-www-form-urlencoded"); 
				http_request.send(querystring);
			}
			
		
			function processReg() {
					var form=document.getElementById("form1");
					if (http_request.readyState == 4) { 
						if (http_request.status == 200) { 
							if(http_request.responseText==1)
							{
								
								location='<?=$SETUPFOLDER?>/index.php?menuid=12&level=2&flag=reg';
								
							}
							if(http_request.responseText==2)
							{
								alert('Username exsit please change it! ');
							}
							if(http_request.responseText==3)
							{
								alert('Enter Validate code error! ');
							}
							
						   
						} else { //页面不正常
							alert("error");
						}
					}
				}
			
			function checkReg() {
				var form=document.getElementById("form1");
				if(form.validate_code.value.length!=4)
				{
					alert("验证码必须是4位 !");
					form.validate_code.focus();
					return;
				}
			  if(!isCharVar(form.reg_username.value)||form.reg_username.value.length<3||form.reg_username.value.length>15)
				{
					alert("用户名 3 - 15 字符 !");
					form.reg_username.focus();
					return;
				}
				if(form.reg_psw.value.length<6||form.reg_psw.value.length>15)
				{
					alert("密码 6 - 15 字符和数字 !");
					form.reg_psw.focus();
					return;
				}
				if(form.reg_psw.value!=form.reg_psw1.value)
				{
					alert("两次输入密码不一致 !");
					form.reg_psw1.focus();
					return;
				}
				if(!isEmail(form.EmailName.value))
				{
					alert("请输入有效的邮箱地址!");
					form.EmailName.focus();
					return;
				}
				
				var sex=1;
				if(form.sex[1].checked) sex=2;
				querystring="username="+form.reg_username.value+"&psw="+form.reg_psw.value+"&EmailName="+form.EmailName.value+"&sex="+sex+"&validate_code="+form.validate_code.value;
				 send_request_post_reg('<?=$SETUPFOLDER?>/ajax/reg.php',querystring,"reg");
			}
			
			function checkUsername() {
				var form=document.getElementById("form1");
			   if(form.reg_username.value=="")
				{
					alert("请输入用户名!");
					form.reg_username.focus();
					return;
				}
				send_request_get_reg('<?=$SETUPFOLDER?>/ajax/checkusername.php?username='+form.reg_username.value);
			}
			
			 function processCheckUsername() {
					if (http_request.readyState == 4) { 
						if (http_request.status == 200) { 
						   if(http_request.responseText==2)
							{
								alert("用户名已经存在! ");
							}
							if(http_request.responseText==1)
							{
								alert('用户名可用 !');
							}
						   
						} else {
							alert("page error!");
						}
					}
				}
		
			
		</script>
    	  <table border="0" class="register_table" cellpadding="0" cellspacing="0" width="100%">
            <tr class="register_tr">
              <td class="register_td_title">验证码<span class="star">*</span>:</td>
              <td class="register_td_box"><input class="register_box"  style="float:left;" name="validate_code" type="text" id="validate_code" size="4" maxlength="4" />
                     <img src='<?=$SETUPFOLDER?>/include/validateCode.php'> 
              </td>
            </tr>
    	    <tr class="register_tr">
    	      <td  class="register_td_title">用户名<span class="star">*</span>:</td>
    	      <td class="register_td_box"><input name="reg_username"  class="register_box"  type="text" id="reg_username" style="WIDTH: 185px" />
                  <input type="button" class="register_button"  onclick="checkUsername()" value="check"/></td>
  	      </tr>
            <tr class="register_tr">
              <td class="register_td_title">密码<span class="star">*</span>:</td>
              <td class="register_td_box"><input  class="register_box"  name="reg_psw" type="password" id="reg_psw" style="WIDTH: 185px" /></td>
            </tr>
            <tr class="register_tr">
              <td class="register_td_title">重新输入密码<span class="star">*</span>:</td>
              <td class="register_td_box"><input  class="register_box" name="reg_psw1" type="password" id="reg_psw1" style="WIDTH: 185px" /></td>
            </tr>
            <tr class="register_tr">
              <td class="register_td_title">邮箱地址<span class="star">*</span>:</td>
              <td class="register_td_box"><input  class="register_box"  name="EmailName" type="text" id="EmailName" style="WIDTH: 185px" /></td>
            </tr>

            <tr class="register_tr">
              <td class="register_td_title">性别:</td>
              <td class="register_td_box"><?
					for($i=1;$i<=count($T_Gender);$i++)
					{
						if((int)$sex==$i||(empty($sex)&&$i==1))
							echo "<input name='sex' type='radio' checked  value='".$i."'>".$T_Gender[$i];
						else
							echo "<input name='sex' type='radio'   value='".$i."'>".$T_Gender[$i];
					}
				?></td>
            </tr>

            <tr  class="register_tr">
              <td colspan="2" align="center">
                <input type="button" class="register_button" value="提交" onclick="checkReg()" />
              </td>
            </tr>
            
  	    </table>
        </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>