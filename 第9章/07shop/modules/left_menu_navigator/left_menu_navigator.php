<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/left_menu_navigator/css/style.css" rel="stylesheet" type="text/css">
<div class="left_menu_navigator_container">
<?
 $sql="select  a.*,b.dispach_page,b.page_level  from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id  and a.pid=".$menuid." and a.is_show=1 order by a.sortid" ;
$result_nav=$db->getAll($sql);
$nav_count=count($result_nav);
if($nav_count>0)
{
?>
	<div id="left_menu_ddsidemenubar" class="markermenu">
        <ul>
			<? //   您好
			$nav_nodepath="";
            for($i=0;$i<$nav_count;$i++)
            {
                $dispatch_page=$T_Dispach_Page[$result_nav[$i]['dispach_page']];
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_nav[$i]['id']."&level=".$result_nav[$i]['page_level'];
				if($result_nav[$i]['url_type']==2) $link_url=$result_nav[$i]['url'];
				$nav_nodepath.=$result_nav[$i]['id'].",";
				// check if leaf node
				$rel="";
				if($result_nav[$i]['is_leaf']==2) $rel="rel='ddsubmenuside".$result_nav[$i]['id']."'";
			?>
					<li <?=$rel?>><a target="<?=$T_Link_method[$result_nav[$i]['link_method']]?>" href="<?=$link_url?>"><?=$result_nav[$i]['name']?></a></li>
			 <?
			}
			if(!empty($nav_nodepath))
			{
				$nav_nodepath=substr($nav_nodepath,0,strlen($nav_nodepath)-1);
			}
			?>
        </ul>
    </div>
    
    
   <script type="text/javascript">
	ddlevelsmenu.setup("left_menu_ddsidemenubar", "sidebar") 
	</script>
    <?
	//sub menu nest
	if(!empty($nav_nodepath))
	{
		$nav_nodepath_array=explode(',',$nav_nodepath);
		$where="  a.module_id=b.id  and a.is_show=1 and ";
		$nav_nodepath_count=count($nav_nodepath_array);
		//reomve current category
		for($i=0;$i<$nav_nodepath_count;$i++)
		{
			$where.=" a.id<>".$nav_nodepath_array[$i]." and ";
		}
		$where.=" (";
		for($i=0;$i<$nav_nodepath_count-1;$i++)
		{
			$where.=" FIND_IN_SET('".$nav_nodepath_array[$i]."',a.nodepath)>0 or ";
		}
		$where.=" FIND_IN_SET('".$nav_nodepath_array[$nav_nodepath_count-1]."',a.nodepath)>0)";
		$sql="select  a.*,b.dispach_page,b.page_level  from  ".$TableInfo_category." as a,".$TableModules." as b where  ".$where." order by a.sortid" ;
		$resultCategroy=$db->getAll($sql);
		
		
		for($i=0;$i<$nav_nodepath_count;$i++)
		{
			$level_num=1;
			subNavLeftCategory($resultCategroy,$nav_nodepath_array[$i],$i);
		}
		
		
	}
	?>
 <?
}

	function subNavLeftCategory($resultCategroy,$id,$index)
	{
		global $level_num,$T_Dispach_Page,$T_Link_method,$level_num_flag,$flag,$nav_nodepath_array,$SETUPFOLDER;
		if($level_num!=1&&$level_num_flag==$level_num)
		{
			echo "<ul>";
		}
		$level_num++;
		if($level_num==2)
		{
			echo "<ul id='ddsubmenuside".$nav_nodepath_array[$index]."' class='ddsubmenustyle blackwhite'>";
		}
		
		$level_num_flag=$level_num;
		for($i=0;$i<count($resultCategroy);$i++)
		{
			$dispatch_page=$T_Dispach_Page[$resultCategroy[$i]['dispach_page']];
			 $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$resultCategroy[$i]['id']."&level=".$resultCategroy[$i]['page_level'];
			 
			if($id==$resultCategroy[$i][pid])
			{
				if($resultCategroy[$i]['is_leaf']==2)
				{
					echo "<li><a target='".$T_Link_method[$resultCategroy[$i]['link_method']]."' href='".$link_url."'>".$resultCategroy[$i]['name']."</a>";
				}
				else
				{
					echo "<li><a target='".$T_Link_method[$resultCategroy[$i]['link_method']]."' href='".$link_url."'>".$resultCategroy[$i]['name']."</a></li>";
				}
				if($resultCategroy[$i]['is_leaf']==1) continue;
				subNavLeftCategory($resultCategroy,$resultCategroy[$i][id],$index);
			}

		}
		$level_num--;
		echo "</ul>";
		
		
	}
?>
</div>
