<?php
/*
����ɽ��Сѧ����칫��
*/
//*****************************************************************************/
//�������Ŀ¼
//����һΪ����id ��������Ϊ�������ڵĲ�id+1;
//���磺show_type_table(0,1);
//* @param array[uid]    $type         ���ͬһ�Ӽ�����Ŀ���ڸ���
//* @param array[id][]   $totaltype    ����������Ϣ
//* @return string       $type_select  ������������
function show_tree_table($uid,$slayerid)//����һΪ����id ��������Ϊ�������ڵĲ�id+1
{
	global $type,$totaltype,$show_type_table,$style;
	if (isset($type[$uid])){
		foreach($type[$uid] as $key=>$tid)
		{  				
			$temp=$type[$tid][0];//�����ж��Ƿ�����β��
			$layerid=$totaltype[$tid][4];//��ȡ����
			if (empty($totaltype[$tid][11]))$totaltype[$tid][11]="blank.gif";
			for ($i=1;$i<=$layerid-$slayerid;$i++) $addtd.="<td width=19 align=center><img align=absmiddle border=0 src=./templates/$style/images/menu/tree_line.gif ></td>";
			if  ($temp!=""){ //������������Ӳ�
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

			//���������β������ݹ�
			if ($temp!="")show_tree_table($tid,$slayerid);
		}
	}
	if (isset($type[$uid])){
		if (next($type[$uid])=="")$show_type_table.="</td></tr></table>";
	}
}
?>