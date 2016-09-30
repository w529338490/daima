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
    <td >
        <link href="<?=$SETUPFOLDER?>/modules/article_details/css/style.css" rel="stylesheet" type="text/css">
        <div class="article_details_com_picturetop_text">
			<?
                $id=$category_id;
                $sql="select  ".$TableInfos.".* ,".$TableInfo_category.".name as  infos_category_name  from    ".$TableInfos." ,".$TableInfo_category."   where ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id  and  ".$TableInfos.".infos_category_id=".$id;
                $row=$db->getRow($sql);
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$row['infos_category_id']."&id=".$row['id']."&level=3";
            ?>
            <div class="article_details_com_picturetop_text_category">
                <a href="<?=$link_url?>"><?=$row['infos_category_name']?></a>
            </div>
            <div class="article_details_com_picturetop_text_line"></div>
            <div  class="article_details_com_picturetop_text_picture" style="padding-bottom:5px;">
           
            <a href="<?=$link_url?>"><img  class="article_details_com_picturetop_text_img"   width="<?=$config_row['picture_thumbnail_width']?>" height="<?=$config_row['picture_thumbnail_height']?>"   src="<?=$SETUPFOLDER?>/upload/infos/thumbnail_<?=$row['picture']?>" border="0" ></a>
            </div>
            <div class='article_details_com_picturetop_text_text' style="text-align:left;">
            <a href="<?=$link_url?>"><?=cut(filterTag($row['description']),300)?></a>
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