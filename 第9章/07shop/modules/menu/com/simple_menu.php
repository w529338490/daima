<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/menu/css/style.css" rel="stylesheet" type="text/css">
<div class="menu_com_simple_menu_container">
	<ul>
		<? // 您好
                $sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id  and CONCAT(',',a.menu_ids,',') like '%,2,%' and a.is_show=1 order by a.sortid" ;
                $result_left=$db->getAll($sql);
                $left_count=count($result_left);
                for($k=0;$k<$left_count;$k++)
                {
					$dispatch_page=$T_Dispach_Page[$result_left[$k]['dispach_page']];
                     $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_left[$k]['id']."&level=".$result_left[$k]['page_level'];
					 if($result_left[$i]['url_type']==2) $link_url=$result_left[$i]['url'];

        ?>
                    <li   class="menu_com_simple_menu_li"><a target="<?=$T_Link_method[$result_left[$k]['link_method']]?>" href="<?=$link_url?>"><?=$result_left[$k]['name']?></a></li> 
        <?
                }
        ?>
   	</ul>
</div>