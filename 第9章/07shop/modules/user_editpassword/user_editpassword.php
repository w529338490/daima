<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/user_editpassword/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td class="user_editpassword_container" >
     <script language="javascript">
						
						
				function send_request_post_ChangePassword(url,querystring,func) {
					create_request();
					if(func=='change_psw') http_request.onreadystatechange = processChangePassword;
					
					http_request.open("POST", url, true);
					http_request.setRequestHeader("Content-Type"," application/x-www-form-urlencoded"); 
					http_request.send(querystring);
				}
				
			
				function processChangePassword() {
						var form=document.getElementById("form1");
						if (http_request.readyState == 4) { 
							if (http_request.status == 200) { 
						
								if(http_request.responseText==1)
								{
									
									alert('修改成功! ');
									form.reset();
									
								}
								if(http_request.responseText==2)
								{
									alert('旧密码不存在! ');
								}
								
							   
							} else { //页面不正常
								alert("error");
							}
						}
					}
				
				function checkChangePassword() {
					var form=document.getElementById("form1");
				   
					if(form.psw_old.value.length<6||form.psw_old.value.length>15)
					{
						alert("密码必须 6 - 15 字符或数字 !");
						form.psw_old.focus();
						return;
					}
					if(form.new_psw.value.length<6||form.new_psw.value.length>15)
					{
						alert("新密码必须 6 - 15 字符或数字 !");
						form.new_psw.focus();
						return;
					}
					if(form.new_psw.value!=form.new_psw1.value)
					{
						alert("两次输入密码错误!");
						form.new_psw.focus();
						return;
					}
					
					 querystring="psw_old="+form.psw_old.value+"&new_psw="+form.new_psw.value+"&c_username=<?=$_SESSION['SessionUser']['username']?>";
					 send_request_post_ChangePassword('<?=$SETUPFOLDER?>/ajax/change_psw.php',querystring,"change_psw");
				}

			
				
			</script>
    	  <table class="user_editpassword_table" border="0" cellpadding="0" cellspacing="0">
            
              <tr  class="user_editpassword_tr" >
                <td  class="user_editpassword_td_title">旧密码<span class="star">*</span>:</td>
                <td class="user_editpassword_td_box"><input class="user_editpassword_box" name="psw_old" type="password" id="psw_old" style="WIDTH: 185px" /></td>
              </tr>
              <tr  class="user_editpassword_tr" >
                <td  class="user_editpassword_td_title">新密码<span class="star">*</span>:</td>
                <td class="user_editpassword_td_box"><input class="user_editpassword_box"  name="new_psw" id="new_psw" style="WIDTH: 185px" value="" /></td>
              </tr>
              <tr class="user_editpassword_tr" >
                <td  class="user_editpassword_td_title">重新输入密码<span class="star">*</span>:</td>
                <td class="user_editpassword_td_box"><input  class="user_editpassword_box"  name="new_psw1" type="text" id="new_psw1" style="WIDTH: 185px" value="" /></td>
              </tr>
              <tr class="user_editpassword_tr" >
                <td   class="user_editpassword_td_title" colspan="2" align="center">
                  <input type="button" value="提交" class="user_editpassword_button" onclick="checkChangePassword()" />
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
<input type="hidden" name="status" value="">