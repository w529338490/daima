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
<div class="menu_com_mutiples_menu_container">
	<div id="mutiple_ddsidemenubar" class="markermenu">
        <ul>
			<? //   您好
            $sql="select  a.*,b.dispach_page,b.page_level from  ".$TableInfo_category." as a,".$TableModules." as b where  a.module_id=b.id  and CONCAT(',',a.menu_ids,',') like '%,1,%' and a.is_show=1 order by a.sortid" ;
            $result_left=$db->getAll($sql);
            $left_count=count($result_left);
			$left_nodepath="";
            for($k=0;$k<$left_count;$k++)
            {
                $dispatch_page=$T_Dispach_Page[$result_left[$k]['dispach_page']];
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$result_left[$k]['id']."&level=".$result_left[$k]['page_level'];
				if($result_left[$k]['url_type']==2) $link_url=$result_left[$k]['url'];

				$left_nodepath.=$result_left[$k]['id'].",";
				// check if leaf node
				$rel="";
				if($result_left[$k]['is_leaf']==2) $rel="rel='ddsubmenuside".$result_left[$k]['id']."'";
			?>
					<li <?=$rel?>><a target="<?=$T_Link_method[$result_left[$k]['link_method']]?>" href="<?=$link_url?>"><?=$result_left[$k]['name']?></a></li>
			 <?
			}
			if(!empty($left_nodepath))
			{
				$left_nodepath=substr($left_nodepath,0,strlen($left_nodepath)-1);
			}
			?>
        </ul>
    </div>
    
    
   <script type="text/javascript">
	ddlevelsmenu.setup("mutiple_ddsidemenubar", "sidebar") 
	</script>
    <?
	//sub menu nest
	if(!empty($left_nodepath))
	{
		$left_nodepath_array=explode(',',$left_nodepath);
		$where="  a.module_id=b.id  and a.is_show=1 and ";
		$left_nodepath_count=count($left_nodepath_array);
		//reomve current category
		for($k=0;$k<$left_nodepath_count;$k++)
		{
			$where.=" a.id<>".$left_nodepath_array[$k]." and ";
		}
		$where.=" (";
		for($k=0;$k<$left_nodepath_count-1;$k++)
		{
			$where.=" FIND_IN_SET('".$left_nodepath_array[$k]."',a.nodepath)>0 or ";
		}
		$where.=" FIND_IN_SET('".$left_nodepath_array[$left_nodepath_count-1]."',a.nodepath)>0)";
		$sql="select  a.*,b.dispach_page,b.page_level  from  ".$TableInfo_category." as a,".$TableModules." as b where  ".$where." order by a.sortid" ;
		$resultCategroy=$db->getAll($sql);
		
		
		for($k=0;$k<$left_nodepath_count;$k++)
		{
			$level_num=1;
			mutipleNavLeftCategory($resultCategroy,$left_nodepath_array[$k],$k);
		}
		
		
	}
	
	function mutipleNavLeftCategory($resultCategroy,$kd,$kndex)
	{
		global $level_num,$T_Dispach_Page,$T_Link_method,$level_num_flag,$flag,$left_nodepath_array,$SETUPFOLDER;
		if($level_num!=1&&$level_num_flag==$level_num)
		{
			echo "<ul>";
		}
		$level_num++;
		if($level_num==2)
		{
			echo "<ul id='ddsubmenuside".$left_nodepath_array[$kndex]."' class='ddsubmenustyle blackwhite'>";
		}
		
		$level_num_flag=$level_num;
		for($k=0;$k<count($resultCategroy);$k++)
		{
			$dispatch_page=$T_Dispach_Page[$resultCategroy[$k]['dispach_page']];
			 $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$resultCategroy[$k]['id']."&level=".$resultCategroy[$k]['page_level'];
			 if($resultCategroy[$k]['url_type']==2) $link_url=$resultCategroy[$k]['url'];

			if($kd==$resultCategroy[$k][pid])
			{
				if($resultCategroy[$k]['is_leaf']==2)
				{
					echo "<li><a target='".$T_Link_method[$resultCategroy[$k]['link_method']]."' href='".$link_url."'>".$resultCategroy[$k]['name']."</a>";
				}
				else
				{
					echo "<li><a target='".$T_Link_method[$resultCategroy[$k]['link_method']]."' href='".$link_url."'>".$resultCategroy[$k]['name']."</a></li>";
				}
				if($resultCategroy[$k]['is_leaf']==1) continue;
				mutipleNavLeftCategory($resultCategroy,$resultCategroy[$k][id],$kndex);
			}

		}
		$level_num--;
		echo "</ul>";
		
		
	}
	?>


</div>