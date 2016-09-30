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
        <div  class="gallery_com_pictureright_text">
			<?
                $id=$category_id;
                $sql="select  ".$TableInfos.".* ,".$TableInfo_category.".name as  infos_category_name  from    ".$TableInfos." ,".$TableInfo_category."   where ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id  and  ".$TableInfos.".infos_category_id=".$id." and ".$TableInfos.".featured=1 order by ".$TableInfos.".upload_datetime desc  limit 1";
                $row=$db->getRow($sql);
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$row['infos_category_id']."&id=".$row['id']."&level=3";
				$link_list_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$row['infos_category_id']."&id=".$row['id']."&level=2";

            ?>
            <div class="gallery_com_pictureright_text_category">
                <a href="<?=$link_list_url?>"><?=$row['infos_category_name']?></a>
            </div>
            <div class="gallery_com_pictureright_text_line"></div>
            <div class="gallery_com_pictureright_text_text">
            <a href="<?=$link_url?>"><img   class="gallery_com_pictureright_text_img"  style="float:right; padding-left:5px;"  src="<?=$SETUPFOLDER?>/upload/infos/thumbnail_<?=$row['picture']?>" border="0" ></a>
             <a  href="<?=$link_url?>"><span class="gallery_com_pictureright_text_Title"><?=$row['info_title']?></span></a>
                   <br />
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