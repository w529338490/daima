<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
 <div style="width:100%; padding-bottom:5px;">
 	  <? include "com/mod_search.php"?>
 </div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
             
		
             $is_verify="1";
             $fvalue=$is_verify;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" is_verify = ".$fvalue." ";
                 $b=true;
             }
		
             $fvalue=$keyword;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" (".$TableInfos.".info_title like '%".$fvalue."%' or ".$TableInfos.".description like '%".$fvalue."%' or  ".$TableInfos.".keyword like '%".$fvalue."%')  ";
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
			$sql="select  ".$TableInfos.".id ,".$TableInfos.".infos_category_id ,".$TableInfos.".info_title ,".$TableInfos.".upload_datetime ,".$TableInfo_category.".name as  infos_category_name  from    ".$TableInfos." ,".$TableInfo_category."  ";
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
		?>
                <tr>
                  <td class="article_listings_listings_text"><img src="<?=$SETUPFOLDER?>/images/icon-menu.gif" />&nbsp;&nbsp;<a href="<?=$SETUPFOLDER."/".$dispatch_page?>?menuid=<?=$result[$i]['infos_category_id']?>&id=<?=$result[$i]['id']?>&level=3">
                    <?=$result[$i]['info_title']?>
                  </a></td>
                  <td width="200" align="center"><?=FormatDate($result[$i]['upload_datetime'])?></td>
                </tr>
           
         <?
		}
		?>
	</table>
  <? include $BASEPATH."/modules/pageturning/pageturning.php"?>