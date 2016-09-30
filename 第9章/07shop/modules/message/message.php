<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/message/css/style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td height="50" align="center" class="message_font">
    		 <?
			  if($flag=='reg')//register
			  {
			  	$message="您注册成功 ! <a href='".$SETUPFOLDER."/".$dispatch_page."?menuid=15&level=2'>请登陆</a> !";
			  }
			  if($flag=='nologin')//no login
			  {
			  	$message=" 请登陆 !";
			  }
			  if($flag=='illegal_operation')//illegal operation
			  {
			  	$message=" 非法访问 !";
			  }
			  if($flag=='logout')//no login
			  {
			  	$message="您已经退出 !";
			  }
			   if($flag=='logined')//register
			  {
			  	
			  	$message="您登陆成功 ! <a href='".$SETUPFOLDER."/profile.php?menuid=16&level=2'> 进人您的空间</a> !";
			  }
			  
			  echo $message;
			  ?>
          </td>
    <td  class="box_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="6" class="box_bottom_left"></td>
    <td  class="box_bottom_bg">&nbsp;</td>
    <td class="box_bottom_right"></td>
  </tr>
</table>