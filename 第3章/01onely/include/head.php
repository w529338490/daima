<div id="top">
<!--logo-->
<div id="logoarea"><a href="index.php"><img src="<?php echo $gb_logo?>" alt="<?php echo $gb_name?> - ���Ա�"></a></div>
<!--�˵�-->
<div id="menu">
<ul>
<li><a href="index.php"><img src="images/i2.gif"><br>�������</a></li>
<li><a href="add.php"><img src="images/i1.gif"><br>ǩд����</a></li>
<?php if(empty($_SESSION['admin_pass'])){?>
<li><a href="admin_login.php"><img src="images/i3.gif"><br>��������</a></li><?php }else{?><li><a href="javascript:if(confirm('��ȷ��Ҫ�˳���?'))location='admin_action.php?ac=logout'"><img src="images/i3.gif"><br>�˳�����</a></li><?php }?>
<?php if(!empty($_SESSION['admin_pass'])){?>
<li><a href="admin_set.php"><img src="images/admin_set.gif"><br>ϵͳ����</a></li><?php }?>
<li><a href="<?php echo $index_url?>"></a></li>
</ul>
</div>
</div>