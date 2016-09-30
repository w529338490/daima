<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="6" class="box_top_left"><img src="<?=$SETUPFOLDER?>/images/box_top_left.gif" /></td>
    <td    class="box_top_bg">&nbsp;</td>
    <td width="5"  class="box_top_right"></td>
  </tr>
  <tr>
    <td  class="box_left">&nbsp;</td>
    <td  style=" text-align:left;">
    	<link href="<?=$SETUPFOLDER?>/modules/gallery/css/style.css" rel="stylesheet" type="text/css">
        <div class="gallery_com_PictureRightListings_TextDecription">
        <?
		$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$category_id."&level=".$category_level;
		?>
        	<div class="gallery_com_PictureRightListings_TextDecription_category">
                <a  href="<?=$link_url?>"><?=$infos_category_name?></a>
            </div>
            <div class="gallery_com_PictureRightListings_TextDecription_line"></div>
            <div  class="gallery_com_PictureRightListings_TextDecription_list">
                <? //   您好
                    $sql="select  a.id,b.dispach_page,b.page_level,c.info_title,c.description,c.id as info_id,c.picture from  ".$TableInfo_category." as a,".$TableModules." as b,".$TableInfos." as c where  a.module_id=b.id  and a.id=c.infos_category_id and  a.id=".$category_id."  and a.is_show=1 order by c.upload_datetime desc limit ".$config_row['module_limit_num'] ;
                    $result_mod=$db->getAll($sql);
                    $mod_count=count($result_mod);
                    for($k=0;$k<$mod_count;$k++)
                    {
                        $dispatch_page=$T_Dispach_Page[$result_mod[$k]['dispach_page']];
                         $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_mod[$k]['id']."&id=".$result_mod[$k]['info_id']."&level=3";
                ?>
                   	<div  class="gallery_com_PictureRightListings_TextDecription_picture"><a  href="<?=$link_url?>"><img  class="gallery_com_PictureRightListings_TextDecription_img"  src="<?=$SETUPFOLDER?>/upload/infos/thumbnail_<?=$result_mod[$k]['picture']?>" border="0" /></a> <a  href="<?=$link_url?>"><?=cut(filterTag($result_mod[$k]['description']),200)?></a></div>
                	
				<?
                }
                ?>
             
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