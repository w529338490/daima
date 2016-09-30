<? include "../Configuration.php" ?>
<? include "../include/isAdmin.php" ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @copyright	Copyright (C) HonoWeb. All rights reserved.
 * @Website		www.honoweb.com.
 */
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$TitleName?></title>
<link rel="StyleSheet" href="tree/dtree.css" type="text/css">
<script type="text/javascript" src="tree/dtree.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
</head>

<body >
<div class="dtree">
	<script type='text/javascript'>
	<!--
		var target='center';
	    d = new dTree('d');
	    d.add(0,-1,'Panel','center.php','',target);
		<? 
			for($i=0;$i<count($_SESSION['SessionMenu']);$i++)
			{
				echo "d.add(".$_SESSION['SessionMenu'][$i]['id'].",".$_SESSION['SessionMenu'][$i]['pid'].",'".$_SESSION['SessionMenu'][$i]['name']."','".$_SESSION['SessionMenu'][$i]['url']."?menuid=".$_SESSION['SessionMenu'][$i]['id']."','',target);";
			}
		?>
        document.write(d);
	 //-->
	</script>
</div>
</body>
</html>