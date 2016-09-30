<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.
 */
 ?>
<table class='login_container' width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td class="login_td">
<script language="javascript">
		function send_request_post_checkuser(url,querystring,func) {
			create_request();
			if(func=='login') http_request.onreadystatechange = processLogin;
			if(func=='forgetPassword') http_request.onreadystatechange = processForgetPassword;
			
			http_request.open("POST", url, true);
			http_request.setRequestHeader("Content-Type"," application/x-www-form-urlencoded"); 
			http_request.send(querystring);
		}
		
	
		function processForgetPassword() {
				var form=document.getElementById("form1");
				if (http_request.readyState == 4) { 
					if (http_request.status == 200) { 
						if(http_request.responseText==1)
						{
							
							alert('您的密码已经送入您的注册邮箱! ');
							
						}
						if(http_request.responseText==2)
						{
							alert('用户名错误,请重新输入! ');
						}
						if(http_request.responseText==3)
						{
							alert('您的注册邮箱无效请联系管理员! ');
						}
						
					   
					} else { //页面不正常
						alert("error");
					}
				}
			}
			
			function checkForgetPassword() {
				var form=document.getElementById("form1");

				if(form.psw_username.value=="")
				{
					alert("请输入用户名!");
					form.psw_username.focus();
					return;
				}
				
				querystring="psw_username="+form.psw_username.value;
				 send_request_post_checkuser('<?=$SETUPFOLDER?>/ajax/forgetpass.php',querystring,"forgetPassword");
			}

	
		
	</script>
    <span >您的密码将会送到您的邮箱!</span>
    <p>
               用户名: <input class="login_input_box" type="text"  name='psw_username' id="psw_username" />
                 <br />
                 <span class="main-box-bg">
                 <input type="button" class="button" value="发送" onclick="checkForgetPassword()" />
                 </span><br />
    </p>
 <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>