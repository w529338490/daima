<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.您好
 */
 ?>
 <link href="<?=$SETUPFOLDER?>/modules/product_category/css/style.css" rel="stylesheet" type="text/css">
<div class="left_product_category_container">
<?
 $sql="select  a.*,2 as page_level from  ".$TableEb_product_category." as a where   a.is_show=1 and a.pid=0 order by a.sortid" ;
$result_nav=$db->getAll($sql);
$nav_count=count($result_nav);
 $dispatch_page="product.php";
 $menuid="201";
if($nav_count>0)
{
?>
	<div id="leftproduct_menu_ddsidemenubar" class="markermenu">
        <ul>
			<? //   您好
			$nav_nodepath="";
            for($k=0;$k<$nav_count;$k++)
            {
               
                $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$result_nav[$k]['id']."&level=".$result_nav[$k]['page_level'];
				$nav_nodepath.=$result_nav[$k]['id'].",";
				// check if leaf node
				$rel="";
				if($result_nav[$k]['is_leaf']==2) $rel="rel='ddsubmenuside".$result_nav[$k]['id']."'";
			?>
					<li <?=$rel?>><a target="<?=$T_Link_method[$result_nav[$k]['link_method']]?>" href="<?=$link_url?>"><?=$result_nav[$k]['name']?></a></li>
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
	ddlevelsmenu.setup("leftproduct_menu_ddsidemenubar", "sidebar") 
	</script>
    <?
	//sub menu nest
	if(!empty($nav_nodepath))
	{
		$nav_nodepath_array=explode(',',$nav_nodepath);
		$where="  a.is_show=1 and a.pid<>0 and ";
		$nav_nodepath_count=count($nav_nodepath_array);
		//reomve current category
		for($k=0;$k<$nav_nodepath_count;$k++)
		{
			$where.=" a.id<>".$nav_nodepath_array[$k]." and ";
		}
		$where.=" (";
		for($k=0;$k<$nav_nodepath_count-1;$k++)
		{
			$where.=" FIND_IN_SET('".$nav_nodepath_array[$k]."',a.nodepath)>0 or ";
		}
		$where.=" FIND_IN_SET('".$nav_nodepath_array[$nav_nodepath_count-1]."',a.nodepath)>0)";
		$sql="select  a.*,2 as page_level   from  ".$TableEb_product_category." as a where  ".$where." order by a.sortid" ;
		$resultCategroy=$db->getAll($sql);
		
		
		for($k=0;$k<$nav_nodepath_count;$k++)
		{
			$level_num=1;
			subNavLeftProductCategory($resultCategroy,$nav_nodepath_array[$k],$k);
		}
		
		
	}
	?>
 <?
}

	function subNavLeftProductCategory($resultCategroy,$kd,$kndex)
	{
		global $level_num,$dispatch_page,$T_Link_method,$menuid,$level_num_flag,$flag,$nav_nodepath_array,$SETUPFOLDER;
		if($level_num!=1&&$level_num_flag==$level_num)
		{
			echo "<ul>";
		}
		$level_num++;
		if($level_num==2)
		{
			echo "<ul id='ddsubmenuside".$nav_nodepath_array[$kndex]."' class='ddsubmenustyle blackwhite'>";
		}
		
		$level_num_flag=$level_num;
		for($k=0;$k<count($resultCategroy);$k++)
		{
			 $link_url=$SETUPFOLDER."/".$dispatch_page."?menuid=".$menuid."&pcatid=".$resultCategroy[$k]['id']."&level=".$resultCategroy[$k]['page_level'];
			 
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
				subNavLeftProductCategory($resultCategroy,$resultCategroy[$k][id],$kndex);
			}

		}
		$level_num--;
		echo "</ul>";
		
		
	}
?>
</div>
