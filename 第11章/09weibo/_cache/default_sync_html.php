<?php
include_once "G:/AppServ/www/09weibo/class/templateExtensions/stripslashes.php";

?><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php
echo phpsay_stripslashes($_obj['blogConfig']['sitename']);
?>
 &rsaquo; 同步更新设置</title><link rel="stylesheet" type="text/css" href="_static/<?php
echo $_obj['blogConfig']['skin'];
?>
/style.css" /><script type="text/javascript" src="_static/js/jquery.js"></script><script type="text/javascript" src="_static/js/form.js"></script><script type="text/javascript" src="_static/js/sync.js"></script></head><body><div id="navbar"><?php
if ($_obj['loginStat'] == "1"){
?><a href="./friend.php">关注管理</a><a href="./friend.php?t=fans">粉丝管理</a><a href="./sync.php">同步更新</a><a href="./setting.php">微博设置</a><a href="./password.php">账户密码</a><a href="#" target="_blank">用户交流</a><a href="./login.php?do=logout">安全退出</a><?php
} else {
?><a href="./login.php">登录</a><?php
}
?></div><div class="wrapper"><div id="header"><h1><a href="./"><?php
echo phpsay_stripslashes($_obj['blogConfig']['sitename']);
?>
</a><span><a href="./"><?php
echo $_obj['blogConfig']['siteurl'];
?>
</a></span></h1><ul id="menu"><li><a href="./">微博</a></li><li><a href="./follow.php">关注</a></li><li><a href="./follow.php?t=fans">粉丝</a></li></ul></div><div id="description"><span class="left"><?php
echo phpsay_stripslashes($_obj['blogConfig']['siteintro']);
?>
</span><span class="right"><a href="./rss.php" title="RSS订阅" target="_blank"></a></span></div><div id="main" class="profile_edit"><form name="setForm" id="setForm" method="post"><h2 class="nav_title">同步更新到Twitter</h2><p class="s_e"><strong>用户名:</strong> （ 不同步请留空 ）<input type="text" class="input_narrow" name="twitter[username]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['twitter']['username']);
?>
" maxlength="50" /></p><p class="s_e"><strong>密码:</strong> （ 不同步请留空 ）<input type="password" class="input_narrow" name="twitter[password]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['twitter']['password']);
?>
" maxlength="25" /></p><h2 class="clear nav_title">同步更新到新浪微博</h2><p class="s_e"><strong>用户名:</strong> （ 不同步请留空 ）<input type="text" class="input_narrow" name="sina[username]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['sina']['username']);
?>
" maxlength="50" /></p><p class="s_e"><strong>密码:</strong> （ 不同步请留空 ）<input type="password" class="input_narrow" name="sina[password]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['sina']['password']);
?>
" maxlength="25" /></p><h2 class="clear nav_title">同步更新到嘀咕</h2><p class="s_e"><strong>用户名:</strong> （ 不同步请留空 ）<input type="text" class="input_narrow" name="digu[username]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['digu']['username']);
?>
" maxlength="50" /></p><p class="s_e"><strong>密码:</strong> （ 不同步请留空 ）<input type="password" class="input_narrow" name="digu[password]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig']['digu']['password']);
?>
" maxlength="25" /></p><h2 class="clear nav_title">同步更新到9911微博客</h2><p class="s_e"><strong>用户名:</strong> （ 不同步请留空 ）<input type="text" class="input_narrow" name="9911[username]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig'][9911]['username']);
?>
" maxlength="50" /></p><p class="s_e"><strong>密码:</strong> （ 不同步请留空 ）<input type="password" class="input_narrow" name="9911[password]" value="<?php
echo phpsay_stripslashes($_obj['syncConfig'][9911]['password']);
?>
" maxlength="25" /></p><p class="s_s"><input type="submit" name="save" value="保存更改" class="input_submit" /></p><p id="result" class="s_r"></p></form><div class="clear"></div></div></div><div id="footer"><script>$.get('./friend_server.php?do=update');</script><?php
echo phpsay_stripslashes($_obj['blogConfig']['tracking_code']);
?>
</div></body></html>