<? include "../db/Connect.php" ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCMS
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<?
	if($status=="login")//用户登陆
	{
		
			 $sql="select a.*,b.itemid as bitemid from ".$TableAdmin." as a,".$TableRole." as b where a.UserGrade=b.id and a.username='$username' and a.psw='$psw'";
			
			 $row=$db->getRow($sql);
			 if(!empty($row['username']))
			 {
					$user=array(
								'username'=>"",
								'truename'=>"",
								'UserGrade'=>"",
								'itemid'=>"",
								'site_id'=>"",
					);
					$user['username']=$row[username];
					$user['truename']=$row[truename];
					$user['UserGrade']=$row[UserGrade];
					
					if(!empty($row[bitemid])&&!empty($row[itemid]))
						$user['itemid']=$row[itemid].",".$row[bitemid];
					if(!empty($row[bitemid])&&empty($row[itemid]))
						$user['itemid']=$row[bitemid];
					if(empty($row[bitemid])&&!empty($row[itemid]))
						$user['itemid']=$row[itemid];
					if(empty($row[bitemid])&&empty($row[itemid]))
						$user['itemid']="0";
					$user['site_id']=$row[site_id];
						
		    		$_SESSION['SessionAdminUser']=$user;
					
					$sql="select d.*,c.authorize from ".$TableAdmin." as a,".$TableRole." as b,".$TableMenu_role." as c,".$TableMenu." as d where  b.id =a.UserGrade and b.id=c.roleid and  d.id=c.menuid and  a.username='".$row[username]."'  and d.is_user=1  order by  pid, sortid  ";
					$resultMenu=$db->getAll($sql);
					$_SESSION['SessionMenu']=$resultMenu;
						header("location: index.php ");
			
					return;
			}
			else
			{
				$message=1;
			}
	
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="MSHTML 6.00.2900.3395" name=GENERATOR>
<link href="../admin/style/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/check.js"></script>
<script language="javascript">
	

	document.onkeydown = keyDown;
	
	function keyDown(e) 
	{  
		if(!e) // IE
	 	{
			e = window.event
	 		keynum = e.keyCode;
	  	}
		else if(e.which) // Netscape/Firefox/Opera
	  	{
	 		keynum = e.which;
	  	}
		
		if(keynum==13) Check();
	}
	
	function Check()
   {
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
		
		 form.status.value="login";
		 form.submit();
  	}
</script>


</head>

<body  >
<form name="form1" id="form1"  method="post" action="">
<center>

	<div style="padding:150px; " align="center">
	  <table class='login_container' width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5" height="6" class="box_top_left"><img src="image/box_top_left.gif" /></td>
            <td    class="box_top_bg">&nbsp;</td>
            <td width="5"  class="box_top_right"></td>
          </tr>
          <tr>
            <td  class="box_left">&nbsp;</td>
            <td align="center" class="login_td"><TABLE cellSpacing=0 cellPadding=0 width=400 align=center border=0>
              <TBODY>

                <TR>
                  <TD><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                      <TBODY>
                        <TR>
                          <TD
                height=32><TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
                  border=0>
                              <TBODY>
                               <TR>
                                  <TD  style="color:#FF0000;"><STRONG><?  if($message==1) echo "Username or Password error!"; ?></STRONG></TD>
                                </TR>
                                <TR>
                                  <TD class=text_black11  style="height:20px; line-height:20px;"><STRONG>                                    后台管理</STRONG></TD>
                                </TR>
                              </TBODY>
                          </TABLE></TD>
                        </TR>
                        <TR>
                          <TD height=1></TD>
                        </TR>
                        <TR>
                          <TD 
                style="BACKGROUND: url(image/edit_contentsbg.gif) repeat-x 50% top"><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                              <TBODY>
                                <TR>
                                  <TD style="PADDING-BOTTOM: 20px; PADDING-TOP: 20px"><TABLE cellSpacing=5 cellPadding=0 align=center 
border=0>
                                      <TBODY>
                                        <TR>
                                          <TD class=text_black11 width="25%"><P align=right>用户名:</P></TD>
                                          <TD><INPUT class=text_black12 id=username 
                              style="WIDTH: 200px" name=username></TD>
                                        </TR>
                                        <TR>
                                          <TD class=text_black11 width="25%"><DIV align=right>密码:</DIV></TD>
                                          <TD><INPUT class=text_black12 id=psw 
                              style="WIDTH: 200px" type=password 
                            name=psw></TD>
                                        </TR>
                                        <TR>
                                          <TD><DIV align=right></DIV></TD>
                                          <TD><a href="#"><img src="../admin/image/bt_login.gif" border="0"  onClick="javascript:Check()" ></a> </TD>
                                        </TR>
                                      </TBODY>
                                  </TABLE></TD>
                                </TR>
                              </TBODY>
                          </TABLE></TD>
                        </TR>
                      </TBODY>
                  </TABLE></TD>
                </TR>
                <TR>
                  <TD><TABLE cellSpacing=0 cellPadding=0>
                      <TBODY>
                        <TR>
                          <TD class=text_black11 
                style="BACKGROUND: url(image/topmenu_bg1.gif) repeat-x 50% top" 
                align=middle><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                              <TBODY>
                                <TR>
                                  <TD 
                      style="PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 20px; PADDING-TOP: 10px"><DIV class=text_black11 align=center>©  
                                    HonoWeb. All rights reserved. <BR>
                                    This computer program is 
                                    protected by copyright law and international treaties. 
                                    Unauthorized reproduction or distribution of this 
                                    program, or any portion of it, may result in severe 
                                    civil and criminal penalties. </DIV></TD>
                                </TR>
                              </TBODY>
                          </TABLE></TD>
                        </TR>
                      </TBODY>
                  </TABLE></TD>
                </TR>
              </TBODY>
            </TABLE></td>
            <td  class="box_right">&nbsp;</td>
          </tr>
          <tr>
            <td height="6" class="box_bottom_left"></td>
            <td  class="box_bottom_bg">&nbsp;</td>
            <td class="box_bottom_right"></td>
          </tr>
        </table>
    <input type="hidden" name="status" > 
		<input name="md5" id="md5" type="hidden" value="<?php echo md5($_SESSION['identify']); ?>">
	</div>


</center>
</form>
</body>
</html>
<? $db->close_db();?>