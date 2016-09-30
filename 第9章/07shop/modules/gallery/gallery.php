<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		. 您好
 */
 ?>
         <link href="<?=$SETUPFOLDER?>/modules/gallery/css/style.css" rel="stylesheet" type="text/css">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
		<?
			$page=$_POST['page'];
			if(empty($page))
				{$page=1;}
			else
			{
				 if($page<1){ $page=1;}
			}
             $b=false;
             $filter="";
            
			$pagenum=$config_row['list_pageturn_num'];
             $fvalue=$menuid;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.="  CONCAT(',',".$TableInfo_category.".nodepath,',') like '%,".$fvalue.",%' ";
                 $b=true;
             }
		
             $is_verify="1";
             $fvalue=$is_verify;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_verify = ".$fvalue." ";
                 $b=true;
             }
             
             
             $fvalue="has_link_table";
             if(!empty($fvalue))
             {
             	if($b)
             		$filter.=" and";
             	$filter.=" ".$TableInfos.".infos_category_id = ".$TableInfo_category.".id   ";
             	$b=true;
             }
			$sql="select  ".$TableInfos.".id ,".$TableInfos.".infos_category_id ,".$TableInfos.".info_title ,".$TableInfos.".picture ,".$TableInfo_category.".name as  infos_category_name  from    ".$TableInfos." ,".$TableInfo_category."  ";
			$sql1="select count(*) as num from    ".$TableInfos." ,".$TableInfo_category."  ";
			if($b)
			{
				$sql.=" where ".$filter."  order by ".$TableInfos.".upload_datetime desc  limit ".(($page-1)*$pagenum).",$pagenum";
				$sql1.=" where ".$filter."  order by ".$TableInfos.".upload_datetime desc  ";
			}
			else
			{
				$sql.="  order by ".$TableInfos.".upload_datetime desc  limit ".(($page-1)*$pagenum).",$pagenum";
				$sql1.="   order by ".$TableInfos.".upload_datetime desc  ";
			}
			
			$result=$db->getAll($sql);
			$row=$db->getRow($sql1);
			$totalnum=$row['num'];
			$page_num=ceil($totalnum/$pagenum);
			for($i=0;$i<count($result);$i++)
			{
				$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result[$i]['infos_category_id']."&id=".$result[$i]['id']."&level=3";

		?>
                
                  <td class="gallery_listings">
                      <div class="gallery_listings_picture">
                      <a href="<?=$link_url?>">
                      <img  class="gallery_listings_img"      src="<?=$SETUPFOLDER?>/upload/infos/thumbnail_<?=$result[$i]['picture']?>" border="0" >
                      
                      </a>
                      </div>
                      <div class="gallery_listings_text">
                      <a href="<?=$link_url?>">
                        <?=$result[$i]['info_title']?>
                      </a>
                      </div>
                  </td>
              
           
         <?
		 if(($i+1)%4==0) echo "</tr><tr>";
		}
		?>
          </tr>
	</table>
  <? include $BASEPATH."/modules/pageturning/pageturning.php"?>