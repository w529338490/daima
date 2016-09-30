<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/login/css/style.css" rel="stylesheet" type="text/css">
 <?
if(!isLogin())
{
?>
<table class='login_container' width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td class="login_container">

    	  <script language="javascript">
                function send_request_post_checkuser(url,querystring,func) {
                    create_request();
                    if(func=='login') http_request.onreadystatechange = processLogin;
                    if(func=='forgetPassword') http_request.onreadystatechange = processForgetPassword;
                    
                    http_request.open("POST", url, true);
                    http_request.setRequestHeader("Content-Type"," application/x-www-form-urlencoded"); 
                    http_request.send(querystring);
                }
                
            
                function processLogin() {
                        var form=document.getElementById("form1");
                        if (http_request.readyState == 4) { 
                            if (http_request.status == 200) { 
                        
                                if(http_request.responseText==1)
                                {
                                    
                                    top.location='<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=12&level=2&flag=logined';
                                    
                                }
                                if(http_request.responseText==2)
                                {
                                    alert('用户名或密码错误! ');
                                }
                                
                               
                            } else { //页面不正常
                                alert("error");
                            }
                        }
                    }
                
                function checkLogin() {
                    var form=document.getElementById("form1");
                   if(form.username.value=="")
                    {
                        alert("请输入用户名!");
                        form.username.focus();
                        return;
                    }
                    if(form.psw.value=="")
                    {
                        alert("请输入密码!");
                        form.psw.focus();
                        return;
                    }
                    querystring="username="+form.username.value+"&psw="+form.psw.value;
                     send_request_post_checkuser('<?=$SETUPFOLDER?>/ajax/login.php',querystring,"login");
                }
                
            </script>
		<div class="login_com_mod_login">
             <div class="login_com_mod_login_Title">用户登陆</div>
              <div class="login_com_mod_login_line"></div>
             <div class="login_com_mod_login_Box">
             <p>
                 用户名: <input class="login_input_box" type="text"  name='username' id="username" />
                 <br />
                 <p>密码&nbsp;&nbsp;: <INPUT  class="login_input_box" type='password' name='psw' id="psw">
             </p>
             <span><input type="button"  class="login_button" value="登陆" onclick="checkLogin()" />
             </span>
             <br />
             </div>
             <div class="login_com_mod_login_Text">
             <span><A href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=10&level=2">忘记密码?</A>&nbsp;&nbsp;&nbsp;&nbsp;<A href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=11&level=2">注册!</A></span>
			 </div>
        </div>
    </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>
<?
}
?>