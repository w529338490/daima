<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
  <link href="<?=$SETUPFOLDER?>/modules/logined_navigator/css/style.css" rel="stylesheet" type="text/css">
<div class="logined_navigator_container">
		<?
		  if(isLogin())
		  {
		  ?>
              <span class="logined_navigator_font">欢迎: <?=$_SESSION['SessionUser']['username']?></span> | <a href="<?=$SETUPFOLDER?>/profile.php?menuid=16&level=2"><span class="logined_navigator_font">用户空间</span></a> | <a href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=18&level=2"><span class="logined_navigator_font">退出</span></a>
		  <?
		  }
		  else
		  {
		  ?>
              <A href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=15&level=2"><span class="logined_navigator_font">登陆</span> | <A href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=11&level=2"><span class="logined_navigator_font">注册</span></a> 
		  <?
		  }
		  ?>
</div>
