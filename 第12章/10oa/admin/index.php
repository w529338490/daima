<?php
/*
����ɽ��Сѧ����칫��
*/

if (!$_SESSION["user_system_id"]){
	$referer="?filname=login";
	showmessage("��û�е��룡",$referer);
}
//�û���Ϣ��ȡ
$sql="select management.managename from `members`
            LEFT JOIN management ON members.manageid=management.manageid 
            where  members.userid='$user_id'
            limit 1";
$r=$db->query_first($sql);
$managename=$r[managename];
$tpl->assign(array('real_name'=>$real_name,'manage_name'=>$managename));
//��Ŀ���ݶ�ȡ
$query="select * from $table_type order by `path`,`tid`";
$result=$db->query($query);
while($r=$db->fetch_array($result)){
	$type[$r[uid]][]=$r[id];
	$totaltype[$r[id]]=array($r[id],$r[uid],$r[cid],$r[path],$r[layerid],$r[typename],$r[tid],$r[isshow],$r[enablecontribute],$r[templatetitle],$r[actionurl],$r[typepic]);
	if ($r[layerid]==1) $toolbar[]=$r[id];
};
$dd="";
foreach($toolbar as $tbarid){
	$show_toolbar.="{text:\"".$totaltype[$tbarid][5]."\",cls:'x-btn-text-icon',icon:\"./templates/".$style."/images/menu/".$totaltype[$tbarid][11]."\",cls:'x-btn-text-icon',menu:menu$tbarid},\"-\",";
	//$show_left_menu.="$dd{title:\"".$totaltype[$tbarid][5]."\",autoHeight:true,items:[tree$tbarid]}";
	$dd=",";
	new_menu($tbarid);
}
reset($type);
creat_tree(1);
/*****************************************************************************/
//�����˵�---�ݹ�
function creat_menu($fid)
{
	global $type,$totaltype,$return_menu,$style;
	if (is_array($type[$fid])){
		foreach($type[$fid] as $key=>$tid)
		{
			$tree_child=$type[$tid][0];//�ж��Ƿ�������
			$tree_end=$type[$fid][$key+1];//�ж��Ƿ��˴˲����β
			if ($tree_child==""){
				//		echo strchr($totaltype[$tid][10],"?");
				//if (stripos($totaltype[$tid][10],"?")) echo "ok";else echo "f";

				if (stripos($totaltype[$tid][10],"?"))
				$return_menu.="{id:'tab$tid',text:'".$totaltype[$tid][5]."',icon:'./templates/$style/images/menu/".$totaltype[$tid][11]."',URL:'".$totaltype[$tid][10]."&typeid=$tid',handler:clickMenu}";
				else
				$return_menu.="{id:'tab$tid',text:'".$totaltype[$tid][5]."',icon:'./templates/$style/images/menu/".$totaltype[$tid][11]."',URL:'".$totaltype[$tid][10]."?typeid=$tid',handler:clickMenu}";
				if ($tree_end){$return_menu.=",";}
			}else{
				$return_menu.="{id:'tab$tid',text:'".$totaltype[$tid][5]."',icon:'./templates/$style/images/menu/".$totaltype[$tid][11]."',menu:{items:[";
			}
			if ($tree_child!=""){
				creat_menu($tid);
				$return_menu.="]}}";
				if ($tree_end){$return_menu.=",";}
			}
		}
	}
}
//��������������˵�----�ݹ�
function creat_tree($fid)
{
	global $type,$totaltype,$return_tree,$style;
	if (is_array($type[$fid])){
		foreach($type[$fid] as $key=>$tid)
		{
			$tree_child=$type[$tid][0];//�ж��Ƿ�������
			$tree_end=$type[$fid][$key+1];//�ж��Ƿ��˴˲����β
			if ($tree_child==""){
				$return_tree.="{id:'tab$tid',text: '".$totaltype[$tid][5]."',icon:'./templates/$style/images/menu/".$totaltype[$tid][11]."',leaf: true,URL:'".$totaltype[$tid][10]."&typeid=$tid'}";
				if ($tree_end){$return_tree.=",";}
			}else{
				$return_tree.="{id:'tab$tid',text: '".$totaltype[$tid][5]."',icon:'./templates/$style/images/menu/".$totaltype[$tid][11]."',children: [";
			}
			if ($tree_child!=""){
				creat_tree($tid);
				$return_tree.="]}";
				if ($tree_end){$return_tree.=",";}
			}
		}
	}
}
//���������˵�
function new_menu($fid){
	global $return_menu,$type;
	$return_menu.="var menu$fid = new Ext.menu.Menu({
		          id: 'basicMenu$fid',   
		          items: [";
	creat_menu($fid);
	$return_menu.="]});";
}
//�����������˵�
function new_left_menu($fid){
	global $return_left_menu,$return_tree;
	$tree_json="[$return_tree]";
	$left_menu="
	var tree_json=$tree_json;
	var root=new Ext.tree.AsyncTreeNode({
	text:'�˵���Ŀ¼', 
	expanded:true,
	children: tree_json
});
var tree=new Ext.tree.TreePanel({
	width:180,
	border:false,
	autoHeight:true,
	root:root,
	selModel: new Ext.tree.MultiSelectionModel(),
	loader: new Ext.tree.TreeLoader(),
	rootVisible:false,
	listeners:
	{
	\"click\": function(node,e) {
		if(node.isLeaf()){
			e.stopEvent();
			var n = maintab.getComponent(node.id);
			if (!n) {
			 var link=node.attributes.URL;
				var n = maintab.add({
				'id' : node.id,
				'title' : node.text,
				'link'  :link,
				closable:true,
				html:'<iframe  id=i_'+node.id+' scrolling=auto frameborder=0  src='+link+' width=100% onload=javascript:SetWinHeight(this);></iframe>'
				});
			}
			maintab.setActiveTab(n);
		}
	}
	}
});
";
	return $left_menu;
}
//ϵͳ�˵���
if ($group_id==1){
	$system_tree="
	var system_json=[
      {id:'s_tab_1',text: 'ϵͳ����',children: [
           {id:'s_tab_1_1',text: 'ϵͳ��Ϣ',leaf: true,URL:'index.php?filename=setvar&action=setvar'},
           {id:'s_tab_1_2',text: '��ҳ����',leaf: true,URL:'index.php?filename=setvar&action=setindex'}
           ]},
      {id:'s_tab_2',text: '��Ŀ����',children: [
           {id:'s_tab_2_1',text: '��Ŀ���',leaf: true,URL:'index.php?filename=type&action=addtype'},
           {id:'s_tab_2_2',text: '��Ŀ����',leaf: true,URL:'index.php?filename=type&action=listtype'}
           ]},
      {id:'s_tab_3',text: '�û�����',children: [
           {id:'s_tab_3_1',text: '����û�',leaf: true,URL:'index.php?filename=user&action=useradd'},
           {id:'s_tab_3_2',text: '�༭�û�',leaf: true,URL:'index.php?filename=user&action=useredit'},
           {id:'s_tab_3_3',text: '�û���Ϣ',leaf: true,URL:'index.php?filename=user&action=infoedit'},
           {id:'s_tab_3_4',text: '�޸�����',leaf: true,URL:'index.php?filename=user&action=modifypassword'}
           ]},      
      {id:'s_tab_9',text: '�������',children: [
           {id:'s_tab_9_1',text: '������',leaf: true,URL:'index.php?filename=setting&action=group&do=add'},
           {id:'s_tab_9_2',text: '���༭',leaf: true,URL:'index.php?filename=setting&action=group&do=list'}
           ]},   
      {id:'s_tab_4',text: '��������',children: [
           {id:'s_tab_4_1',text: '�������',leaf: true,URL:'index.php?filename=setting&action=manage&do=add'},
           {id:'s_tab_4_2',text: '���ű༭',leaf: true,URL:'index.php?filename=setting&action=manage&do=list'}
           ]}, 
      {id:'s_tab_5',text: 'ѧ������',children: [
           {id:'s_tab_5_1',text: 'ѧ�����',leaf: true,URL:'index.php?filename=setting&action=subject&do=add'},
           {id:'s_tab_5_2',text: 'ѧ�Ʊ༭',leaf: true,URL:'index.php?filename=setting&action=subject&do=list'}
           ]},   
       {id:'s_tab_6',text: '�༶����',children: [
           {id:'s_tab_6_1',text: '�༶���',leaf: true,URL:'index.php?filename=setting&action=classset&do=add'},
           {id:'s_tab_6_2',text: '�༶�༭',leaf: true,URL:'index.php?filename=setting&action=classset&do=list'}
           ]},     
       {id:'s_tab_7',text: '��������',children: [
           {id:'s_tab_7_1',text: '��վ����',leaf: true,URL:'index.php?filename=announcement'},
           {id:'s_tab_7_2',text: '��������',leaf: true,URL:'index.php?filename=friendlink'}
           ]},            
       {id:'s_tab_8',text: '��־����',children: [
           {id:'s_tab_8_1',text: '������¼',leaf: true,URL:'index.php?filename=log&action=admin'},
           {id:'s_tab_8_2',text: '��½��¼',leaf: true,URL:'index.php?filename=log&action=login'}
           ]}
       ];  ";            


}else{
	$system_tree="
	var system_json=[
      {id:'s_tab_1',text: '�û�����',children: [
           {id:'s_tab_2',text: '�û��༭',leaf:true,URL:'index.php?filename=user&action=infoedit'},
           {id:'s_tab_3',text: '�޸�����',leaf:true,URL:'index.php?filename=user&action=modifypassword'}
           ]}
        ]; 
	";

}
$system_tree.="
	var system_root=new Ext.tree.AsyncTreeNode({
	text:'�˵���Ŀ¼', 
	expanded:true,
	
	children: system_json
});
var system_tree=new Ext.tree.TreePanel({
	width:180,singleClickExpend:true,
	border:false,
	autoHeight:true,
	root:system_root,
	selModel: new Ext.tree.MultiSelectionModel(),
	loader: new Ext.tree.TreeLoader(),
	rootVisible:false,
	listeners:
	{
	\"click\": function(node,e) {
		if(node.isLeaf()){
			e.stopEvent();
			var n = maintab.getComponent(node.id);
			if (!n) {
			 var link=node.attributes.URL;
				var n = maintab.add({
				'id' : node.id,
				'title' : node.text,
				'link' :node.attributes.URL,
				closable:true,
				html:'<iframe id=i_'+node.id+' scrolling=auto frameborder=0  src='+link+' width=100% onload=javascript:SetWinHeight(this);></iframe>'
				});
			}
			maintab.setActiveTab(n);
		}
	}
	}
});
";
$tpl->assign("school_name",$school_name);
$tpl->assign("system_tree",$system_tree);
$dd=new_left_menu($fid);
$tpl->assign("left_menu",$dd);
$tpl->assign("add_toolbar",$show_toolbar);
$tpl->assign("menu",$return_menu);
$tpl->assign(array("keywords"=>$sitekeywords,"description"=>$sitedescription));
$tpl->to_html('index.html',$group_id);
//$tpl->to_display('index.html');
?>
