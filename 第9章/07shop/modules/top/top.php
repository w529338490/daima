<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		.您好
 */
 ?>
  <link href="<?=$SETUPFOLDER?>/modules/top/css/style.css" rel="stylesheet" type="text/css">
<div class="top_container">
	<div id="ddtopmenubar" class="mattblackmenu">
        <ul>
			<? //   您好
            $sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id  and CONCAT(',',a.menu_ids,',') like '%,1,%' and a.is_show=1 order by a.sortid" ;
            $result_top=$db->getAll($sql);
            $top_count=count($result_top);
			$top_nodepath="";
            for($i=0;$i<$top_count;$i++)
            {
                $dispatch_page=$T_Dispach_Page[$result_top[$i]['dispach_page']];
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_top[$i]['id']."&level=".$result_top[$i]['page_level'];
				if($result_top[$i]['url_type']==2) $link_url=$result_top[$i]['url'];

				$top_nodepath.=$result_top[$i]['id'].",";
				// check if leaf node
				$rel="";
				if($result_top[$i]['is_leaf']==2) $rel="rel='ddsubmenu".$result_top[$i]['id']."'";
			?>
					<li <?=$rel?>><a target="<?=$T_Link_method[$result_top[$i]['link_method']]?>" href="<?=$link_url?>"><?=$result_top[$i]['name']?></a></li>
			 <?
			}
			if(!empty($top_nodepath))
			{
				$top_nodepath=substr($top_nodepath,0,strlen($top_nodepath)-1);
			}
			?>
        </ul>
    </div>
    
    
   <script type="text/javascript">
	ddlevelsmenu.setup("ddtopmenubar", "topbar") 
	</script>
    <?
	//sub menu nest
	if(!empty($top_nodepath))
	{
		$top_nodepath_array=explode(',',$top_nodepath);
		$where="  a.module_id=b.id  and a.is_show=1 and ";
		$top_nodepath_count=count($top_nodepath_array);
		//reomve current category
		for($i=0;$i<$top_nodepath_count;$i++)
		{
			$where.=" a.id<>".$top_nodepath_array[$i]." and ";
		}
		$where.=" (";
		for($i=0;$i<$top_nodepath_count-1;$i++)
		{
			$where.=" FIND_IN_SET('".$top_nodepath_array[$i]."',a.nodepath)>0 or ";
		}
		$where.=" FIND_IN_SET('".$top_nodepath_array[$top_nodepath_count-1]."',a.nodepath)>0)";
		$sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  ".$where." order by a.sortid" ;
		$resultCategroy=$db->getAll($sql);
		
		
		for($i=0;$i<$top_nodepath_count;$i++)
		{
			$level_num=1;
			subTopCategory($resultCategroy,$top_nodepath_array[$i],$i);
		}
		
		
	}
	
	function subTopCategory($resultCategroy,$id,$index)
	{
		global $level_num,$T_Dispach_Page,$T_Link_method,$level_num_flag,$flag,$top_nodepath_array,$SETUPFOLDER;
		if($level_num!=1&&$level_num_flag==$level_num)
		{
			echo "<ul>";
		}
		$level_num++;
		if($level_num==2)
		{
			echo "<ul id='ddsubmenu".$top_nodepath_array[$index]."' class='ddsubmenustyle'>";
		}
		
		$level_num_flag=$level_num;
		for($i=0;$i<count($resultCategroy);$i++)
		{
			$dispatch_page=$T_Dispach_Page[$resultCategroy[$i]['dispach_page']];
			 $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$resultCategroy[$i]['id']."&level=".$resultCategroy[$i]['page_level'];
			 if($resultCategroy[$i]['url_type']==2) $link_url=$resultCategroy[$i]['url'];
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
				subTopCategory($resultCategroy,$resultCategroy[$i][id],$index);
			}

		}
		$level_num--;
		echo "</ul>";
		
		
	}
	?>


</div>