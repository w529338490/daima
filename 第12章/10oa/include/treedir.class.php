<?php
/*
凤鸣山中小学网络办公室
*/
//*****************************************************************************/
//输出树形目录
//参数一为分类id ，参数二为分类所在的层id+1;
//例如：show_type_table(0,1);
//* @param array[uid]    $type         相关同一子级的栏目放在父级
//* @param array[id][]   $totaltype    具体分类的信息
//* @return string       $type_select  最后输出的内容
function show_tree_table($uid,$slayerid)//参数一为分类id ，参数二为分类所在的层id+1
{
	global $type,$totaltype,$show_type_table,$style;
	if (isset($type[$uid])){
		foreach($type[$uid] as $key=>$tid)
		{  				
			$temp=$type[$tid][0];//变量判断是否到了树尾；
			$layerid=$totaltype[$tid][4];//读取层数
			if (empty($totaltype[$tid][11]))$totaltype[$tid][11]="blank.gif";
			for ($i=1;$i<=$layerid-$slayerid;$i++) $addtd.="<td width=19 align=center><img align=absmiddle border=0 src=./templates/$style/images/menu/tree_line.gif ></td>";
			if  ($temp!=""){ //如果此栏还有子层
				if (next($type[$uid])>0) $tree="tree_plus.gif";
				else $tree="tree_plusl.gif";
				$show_type_table.="
                     <table cellPadding=0 cellSpacing=0  width=100%  style=\"display:\">
                        <tr>
                         $addtd
                          <td width=19 height=20 align=center><img align=absmiddle border=0 class=outline src=./templates/$style/images/menu/$tree id=menu_$tid style=\"cursor:hand\" onclick=show(this)></td>
                          <td align=left colspan=2>
                          <img align=absmiddle border=0 WIDTH=15 HEIGHT=15 src=./templates/$style/images/menu/".$totaltype[$tid][11]." >
                          <a href=javascript:show(menu_$tid) class=b>".$totaltype[$tid][5]."</a></td>
                        </tr>
                      </table>
                      <table cellPadding=0 cellSpacing=0  width=100% id=menu_".$tid."d style=\"display:none;\">
                        <tr>
                        <td>";   
			}else{
				if ($type[$uid][$key+1]>0) $tree="tree_blank.gif";
				else $tree="tree_blankl.gif";
				if ($totaltype[$tid][10]){
					$url=$totaltype[$tid][10];
					if (ereg("\?",$url)) $url.="&typeid=$tid";
				}else $url="index.php?filename=main";
				$show_type_table.="
                     <table cellPadding=0 cellSpacing=0  width=100%>
                        <tr>
                          $addtd
                          <td width=19 height=20 align=center><img align=absmiddle border=0 src=./templates/$style/images/menu/$tree></td>
                          <td align=left colspan=2>
                          <img align=absmiddle border=0 WIDTH=15 HEIGHT=15 src=./templates/$style/images/menu/".$totaltype[$tid][11].">
                          <a href=\"javascript:openurl('$url');\" class=b>".$totaltype[$tid][5]."</a></td>
                        </tr>
                      </table>
                      "; 
			};
			$addtd="";

			//如果到了树尾则结束递归
			if ($temp!="")show_tree_table($tid,$slayerid);
		}
	}
	if (isset($type[$uid])){
		if (next($type[$uid])=="")$show_type_table.="</td></tr></table>";
	}
}
?>