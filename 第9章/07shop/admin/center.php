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
<link href="style/admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="padding-top:20px;">
	 <table width="700" border="0" cellpadding="0" cellspacing="0" class="tubiao" bordercolor="#efefef">
		<tr>
				<? 
					if(empty($menuid))
						$menuid="0";
					$j=0;
				    for($i=0;$i<count($_SESSION['SessionMenu']);$i++)
					{
					  if($menuid==$_SESSION['SessionMenu'][$i]['pid'])
					  {
					  		$j++;
							$pic="default.jpg";
							if(!empty($_SESSION['SessionMenu'][$i]['picture']))
								$pic=$_SESSION['SessionMenu'][$i]['id'].$_SESSION['SessionMenu'][$i]['picture'];
							echo "<td align='center' style='line-height:32px;'><a href='".$_SESSION['SessionMenu'][$i]['url']."?menuid=".$_SESSION['SessionMenu'][$i]['id']."'><img width=65 height=39 border='0' src='../upload/manager_menu/".$pic."'><br>".$_SESSION['SessionMenu'][$i]['name']."</a></td>";
							if($j%3==0)
								echo "</tr><tr>";
						}
					 }
				 ?>
		</tr>
	 </table>
	 
	 <table width="700" border="0" cellpadding="0" cellspacing="0" class="tubiao" bordercolor="#efefef">
	   <tr>	      </tr>
	   </table></td>
  </tr>
</table>
</body>
</html> 

