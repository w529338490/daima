<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
  <link href="<?=$SETUPFOLDER?>/modules/left_user_navigator/css/style.css" rel="stylesheet" type="text/css">
<div class="left_user_navigator_container">
	<ul>
    <? //   您好
        $sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id  and CONCAT(',',a.menu_ids,',') like '%,4,%' and a.is_show=1 order by a.sortid" ;
        $result_user=$db->getAll($sql);
        $user_count=count($result_user);
        for($i=0;$i<$user_count;$i++)
        {
			$dispatch_page=$T_Dispach_Page[$result_user[$i]['dispach_page']];
             $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_user[$i]['id']."&level=".$result_user[$i]['page_level'];
			 if($result_user[$i]['url_type']==2) $link_url=$result_user[$i]['url'];

    ?>
            <li class="left_user_navigator_container_li"><a target="<?=$T_Link_method[$result_user[$i]['link_method']]?>" href="<?=$link_url?>"><?=$result_user[$i]['name']?></a></li> 
    <?
    }
    ?>
    </ul>
</div>