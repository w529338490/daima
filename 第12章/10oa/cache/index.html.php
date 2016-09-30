<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?></title>
<meta name="keywords" content="<?php echo $this->ftpl_var['keywords'];?>">
<meta name="description" content="<?php echo $this->ftpl_var['description'];?>">
<link rel="stylesheet" type="text/css" href="./ext/resources/css/ext-all.css" />
<style type="text/css">
<!--
A {
	TEXT-DECORATION: none;
}
A:link {
	COLOR: #000000;
}
A:visited {
	COLOR: #333333;
}
A:hover {
	COLOR: #ae0927;
}
A:active {
	COLOR: #0000ff;
}
-->
</style>

</head>
<body>
	<div id="loading-mask" style="">
<div id="loading">
  <div style="text-align:center;padding-top:26%"><img src="./templates/test/images/extanim32.gif" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>Loading...</div>
</div>
</div>
<script type="text/javascript" src="./ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="./ext/ext-all.js"></script>
<script type="text/javascript" src="./ext/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
/**
* 让iframe充满整个tabpanel
*/
function SetWinHeight(obj)
{
	var win=obj;
	if(document.all){
		if (document.getElementById)
		{
			if (win && !window.opera)
			{
				if (win.contentDocument && win.contentDocument.body.offsetHeight)
				win.height = win.contentDocument.body.offsetHeight;
				else if(win.Document && win.Document.body.scrollHeight)
				win.height = win.Document.body.scrollHeight;
			}
		}
	}else{
		var frm = obj;
		var subWeb = document.frames ? document.frames[obj.id].document : frm.contentDocument;
		if(frm != null && subWeb != null)
		{
			frm.style.height="0px";//初始化一下,否则会保留大页面高度
			frm.style.height = subWeb.documentElement.scrollHeight+"px";
			frm.style.width = subWeb.documentElement.scrollWidth+"px";
			subWeb.body.style.overflowX="auto";
			subWeb.body.style.overflowY="auto";
		}
	}
}

Ext.BLANK_IMAGE_URL = './ext/resources/images/default/s.gif';
Ext.QuickTips.init();

Ext.onReady(function(){
	//创建默认的tabpanel首页---table
	var maintab=new Ext.TabPanel({
		region:'center',//部署的区域，参考上图，center是中间显示页面区域
		autoScroll:true,
		animScroll:true,
		resizTabs:true,
		enableTabScroll:true,
		activeTab:0,
		deferredRender:false,
		autoScroll:true,
		margins:'0 4 4 0',
		defaults: {
			autoScroll:false,
			autoHeight:true
		},
		tabMargin:0,
		items:[{
			//创建一个默认的TAB，用于显示欢迎信息
			id:'mainFrame',
			title:'我的网络办公桌面',
			iconCls: 'tabs',
			link:'index.php?filename=table',
			//iconCls:'icon-root-s',
			//autoLoad:{URL:'http://www.nbcjzx.com', scripts:true}
			html:'<iframe name=tag id=i_mainFrame scrolling=auto frameborder=0  src=index.php?filename=table width=100% onload=javascript:SetWinHeight(this);></iframe>'
		}]
	});
	<?php echo $this->ftpl_var['left_menu'];?>
	<?php echo $this->ftpl_var['system_tree'];?>
	////////////////////////////
	new Ext.Viewport({
		layout:"border",
		items:[{
			border:false,
			region:"north",
			height:80,
			split:false,
			collapsible:true,
			titleCollapse:true,
			html:"<div id=tdiv style='height:54'><span style=float:left;><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/left_banner.gif width=450 height=54 /></span><span style=float:left;><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/right_banner.gif width=450 height=54 /></span></div><div id=oa-i></div>"
		},{
			region:"west",
			//border:false,
			id:"leftmenu",
			title:"我的菜单",
			width:180,
			margins:'0 0 0 0',
			split:true,
			mixSize:180,
			maxSize:180,
			collapsible:true,
			titleCollapse:true,
			tbar:[{id:'tab16',text:"网络硬盘",link:'plugins/u/index.php?filename=main&typeid=16',handler:clickBtn},
			{id:'tab2',text:"短信箱",link:'index.php?filename=message&typeid=2',handler:clickBtn},
			{text:"我的网络办公桌面",handler:clickIndex}],
			bbar:[{id:'tab11',text:"<font color=red><b>请  假</font>",link:'index.php?filename=leave&typeid=11&action=add',handler:clickBtn},
			{id:'tab12',text:"收藏夹",link:'index.php?filename=favorite&typeid=12',handler:clickBtn},
			{id:'tab26',text:"发表文章",link:'index.php?filename=article&action=add&typeid=26',handler:clickBtn}],
			layout:"accordion",
			margins:'0 0 0 0',
			layoutConfig:{
				activeOnTop:false,
				animate:true,
				collapsible :true,
				autoWidth:true,
				//autoHeight:true,

				collapseFirst:false,
				fill:true,
				// border:false,
				hideCollapseTool:false,
				titleCollapse:true
			},
			//renderTo:'left_menu',
			items:[{title:'我的网络办公桌面',border:false,items:[tree]},
			{title:"系统管理", border:false,items:[system_tree]}]
		},
		maintab,
		{
			region:"south",
			height:30,
			split:false,
			collapsible:true,
			titleCollapse:true,
			html:"<div id=userinfo style=width:100%;height:40;background-image:url('./templates/<?php echo $this->ftpl_var['style'];?>/images/bg2.gif');><span style='margin-top:8;margin-left:5;float:left;FONT-SIZE:9pt;LINE-HEIGHT:120%;text-align:left;font-weight:bold'><img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/comm.gif align=absmiddle height=18 width=18> 当前用户:<?php echo $this->ftpl_var['real_name'];?> <img src=./templates/<?php echo $this->ftpl_var['style'];?>/images/training.gif align=absmiddle height=16 width=16> 部门：<?php echo $this->ftpl_var['manage_name'];?></span><span style='float:right;text-align:right;FONT-SIZE:9pt;LINE-HEIGHT:120%;margin-top:8;margin-right:5'>开发笔记 技术支持</span></div>"
		}]
	});
	<?php echo $this->ftpl_var['menu'];?>
	var tb = new Ext.Toolbar([
	"<font color=red><b><?php echo $this->ftpl_var['school_name'];?>欢迎您</font>",
	"->",
	{text:"我的网络办公桌面",icon:"./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/chatroom.gif",cls:'x-btn-text-icon',handler:clickIndex},"-",  //分配menu到按钮
	<?php echo $this->ftpl_var['add_toolbar'];?>
	{text:"注销" ,icon:"./templates/<?php echo $this->ftpl_var['style'];?>/images/menu/workflow.gif",cls:'x-btn-text-icon',handler:clickOut}
	]);
	tb.render("oa-i");
	function clickOut(){
		Ext.MessageBox.confirm('退出系统','你是否退出本系统！',function(btn){
			if (btn=='yes')
			window.location.href='index.php?filename=login&action=out';
		});
	}
	function clickMenu(item) {
		var n = maintab.getComponent(item.id);
		if (!n) {
			var link=item.URL;
			var n = maintab.add({
			'id' : item.id,
			'title' : item.text,
			'link':item.URL,
			closable:true,
			html:'<iframe id=i_'+item.id+' scrolling=auto frameborder=0  src='+link+' width=100% onload=javascript:SetWinHeight(this);></iframe>'
			});
		}
		maintab.setActiveTab(n);
	};
	function clickBtn(node) {
		var n = maintab.getComponent(node.id);
		if (!n) {
			var link=node.link;
			var n = maintab.add({
			'id' : node.id,
			'title' : node.text,
			'link' :node.link,
			closable:true,
			html:'<iframe id=i_'+node.id+' scrolling=auto frameborder=0  src='+link+' width=100% onload=javascript:SetWinHeight(this);></iframe>'
			});
		}
		maintab.setActiveTab(n);
	}
	maintab.on('contextmenu', onContextMenu);
	function onContextMenu(ts, item, e)
	{
		var nodemenu=new Ext.menu.Menu
		({
			items:[
			{text:'刷新',iconCls:'reflash',handler:function() {
				//var tiframe = document.getElementById('i_'+item.id);
				//tiframe.src=item.link;
				//tiframe.location.reload();
				window.frames['i_'+item.id].location.reload(); 
				maintab.setActiveTab(item.id);
			}
			}
			]
		});
		nodemenu.showAt(e.getPoint());
	};

	function clickIndex(item) {
		maintab.setActiveTab('mainFrame')
	} ;

		//树节点都展开
		tree.expandAll();
		//system_tree.expandAll();
});
setTimeout(function() {
	Ext.get('loading-mask').fadeOut( {
		remove : true
	});
}, 250);
</script>
</body> 
</html>
