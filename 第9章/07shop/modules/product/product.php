<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		. 您好
 */
 ?>
         <link href="<?=$SETUPFOLDER?>/modules/product/css/style.css" rel="stylesheet" type="text/css">

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
             $fvalue=$pcatid;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.="  CONCAT(',',".$TableEb_product_category.".nodepath,',') like '%,".$fvalue.",%' ";
                 $b=true;
             }
		
             $is_verify="1";
             $fvalue=$is_verify;
             if(!empty($fvalue))
             {
                 if($b)
                     $filter.=" and";
                 $filter.=" ".$TableEb_product.".is_verify = ".$fvalue." ";
                 $b=true;
             }
             
             
             $fvalue="has_link_table";
             if(!empty($fvalue))
             {
             	if($b)
             		$filter.=" and";
             	$filter.=" ".$TableEb_product.".eb_product_category_id = ".$TableEb_product_category.".id   ";
             	$b=true;
             }
			$sql="select  ".$TableEb_product.".price ,".$TableEb_product.".market_price ,".$TableEb_product.".id ,".$TableEb_product.".eb_product_category_id ,".$TableEb_product.".product_name ,".$TableEb_product.".picture   from    ".$TableEb_product." ,".$TableEb_product_category."  ";
			$sql1="select count(*) as num from    ".$TableEb_product." ,".$TableEb_product_category."  ";
			if($b)
			{
				$sql.=" where ".$filter."  order by ".$TableEb_product.".publish_time desc  limit ".(($page-1)*$pagenum).",$pagenum";
				$sql1.=" where ".$filter."  order by ".$TableEb_product.".publish_time desc  ";
			}
			else
			{
				$sql.="  order by ".$TableEb_product.".publish_time desc  limit ".(($page-1)*$pagenum).",$pagenum";
				$sql1.="   order by ".$TableEb_product.".publish_time desc  ";
			}
			
			$result=$db->getAll($sql);
			$row=$db->getRow($sql1);
			$totalnum=$row['num'];
			$page_num=ceil($totalnum/$pagenum);
			for($i=0;$i<count($result);$i++)
			{
				$link_url=$SETUPFOLDER."/product.php?menuid=".$menuid."&pcatid=".$result[$i]['eb_product_category_id']."&id=".$result[$i]['id']."&level=3";

		?>
                
                  <td class="product_listings">
                      <div class="product_listings_picture">
                      <a href="<?=$link_url?>">
                      <img  class="product_listings_img"      src="<?=$SETUPFOLDER?>/upload/eb_product/s<?=$result[$i]['picture']?>" border="0" >
                      
                      </a>
                      </div>
                      <div class="product_listings_text">
                      <a href="<?=$link_url?>">
                        <?=$result[$i]['product_name']?>
                      </a>
                      </div>
                      <div class="product_listings_price">
                        <del><?=$result[$i]['market_price']?> <?=$T_Price_type[$config_row['price_type']]?></del>
                      </div>
                      <div class="product_listings_price">
                        <?=$result[$i]['price']?> <?=$T_Price_type[$config_row['price_type']]?>
                      </div>
                  </td>
              
           
         <?
		 if(($i+1)%4==0) echo "</tr><tr>";
		}
		?>
          </tr>
	</table>
  <? include $BASEPATH."/modules/pageturning/pageturning.php"?>