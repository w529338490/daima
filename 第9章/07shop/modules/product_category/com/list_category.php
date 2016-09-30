<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/product_category/css/style.css" rel="stylesheet" type="text/css">
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td >

<?
 $sql="select  a.*,2 as page_level from  ".$TableEb_product_category." as a where   a.is_show=1 and a.pid=0 order by a.sortid" ;
$result_nav=$db->getAll($sql);

 $sql="select  a.*,2 as page_level from  ".$TableEb_product_category." as a where   a.is_show=1 and a.pid<>0 order by a.sortid" ;
$result_nav_sub=$db->getAll($sql);

$nav_count=count($result_nav);
 $dispatch_page="product.php";
 $menuid="201";
if($nav_count>0)
{
?>
	
			<? 
            for($k=0;$k<$nav_count;$k++)
            {
               
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$result_nav[$k]['id']."&level=".$result_nav[$k]['page_level'];
			?>
            <div class="list_category">
					<img src="<?=$SETUPFOLDER?>/images/icon-menu.gif" />&nbsp;<a target="<?=$T_Link_method[$result_nav[$k]['link_method']]?>" href="<?=$link_url?>"><?=$result_nav[$k]['name']?></a>
                    <div class="list_sub_category">
					<? 
					for($j=0;$j<count($result_nav_sub);$j++)
					{
					    if($result_nav_sub[$j]['pid']==$result_nav[$k]['id'])
						{
							$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$result_nav_sub[$k]['id']."&level=".$result_nav_sub[$k]['page_level'];
					?>
                    		<img src="<?=$SETUPFOLDER?>/images/icon-menu.gif" />&nbsp;<a target="<?=$T_Link_method[$result_nav_sub[$k]['link_method']]?>" href="<?=$link_url?>"><?=$result_nav_sub[$k]['name']?></a>
                            <br />
                     <?
					 	}
					}
					?>
                    </div>
               </div>
			 <?
			}
			?>
            
   
<?
}
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