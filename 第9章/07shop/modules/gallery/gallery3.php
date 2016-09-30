<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
          <link href="<?=$SETUPFOLDER?>/modules/gallery/css/style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?
		$sql="update      ".$TableInfos." set views_count=views_count+1   where id=".$id;
		$db->query($sql);
		$sql="select  ".$TableInfos.".* ,".$TableInfo_category.".name as  infos_category_name  from    ".$TableInfos." ,".$TableInfo_category."   where ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id  and  ".$TableInfos.".id=".$id;
		$row=$db->getRow($sql);
	?>
      <tr>
        <td align="center">
            <br>
            <span class="gallery_details_title">
            	<?=$row['info_title']?>
            </span>
            <br>
            <br>
            <?=$row['upload_datetime']?> 点击率 <?=$row['views_count']?>
         </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">
        
         
				<?
                if(!empty($row['picture']))
                {
                ?>
               		<a target="_blank" href="<?=$SETUPFOLDER?>/upload/infos/<?=$row['picture']?>" ><img width="<?=$config_row['picture_width']?>" height="<?=$config_row['picture_height']?>"  src="<?=$SETUPFOLDER?>/upload/infos/<?=$row['picture']?>" border="0" ></a>
                <?
                }
                ?>
                <br>
                
           					
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          <?=$row['description']?>
        </td>
      </tr>
      <tr>
        <td align="center">
          </td>
      </tr>
    </table>