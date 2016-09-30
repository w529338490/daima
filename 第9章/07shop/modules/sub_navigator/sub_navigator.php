<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/sub_navigator/css/style.css" rel="stylesheet" type="text/css">
<div class="sub_navigator_container">
<a href='<?=$config_row['host_url']?>'><span class="sub_navigator_font">首页</span></a>
	<? // 您好
		$nav_flag=false;
        if(!empty($menuid))
        {
            $sql="select  nodepath from  ".$TableInfo_category." as a  where a.id=".$menuid ;
            $row_nav=$db->getRow($sql);
            $nav_nodepath=$row_nav['nodepath'];
			$nav_flag=true;
        }
		if($nav_flag==true)
		{
			 $sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id and a.id in(".$nav_nodepath.") and  a.is_show=1 order by a.pid" ;
			 $result_nag=$db->getAll($sql);
			 $nav_count=count($result_nag);
			 for($i=0;$i<$nav_count;$i++)
			{
				$dispatch_page=$T_Dispach_Page[$result_nag[$i]['dispach_page']];
				$link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_nag[$i]['id']."&level=".$result_nag[$i]['page_level'];
				if($result_nag[$i]['url_type']==2) $link_url=$result_nag[$i]['url'];
				echo " -<a target='".$T_Link_method[$result_nag[$i]['link_method']]."' href=".$link_url."><span  class='sub_navigator_font'>".$result_nag[$i]['name']."</span></a> ";
			}
		}
    ?>
</div>