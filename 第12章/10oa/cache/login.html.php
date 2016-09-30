<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?></title>
<meta name="keywords" content="<?php echo $this->ftpl_var['keywords'];?>">
<meta name="description" content="<?php echo $this->ftpl_var['description'];?>">
<link rel="stylesheet" type="text/css" href="./ext/resources/css/ext-all.css" />
<style type="text/css">
	.user{ background:url(./templates/test/images/user.gif) no-repeat 1px 2px; }
	.key{ background:url(./templates/test/images/key.gif) no-repeat 1px 2px;  }
	.key,.user{
		background-color:#FFFFFF;
		padding-left:20px;
		font-weight:bold;
		color:#000033;
	}
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
function reload()
{
	window.location.reload();
}
Ext.BLANK_IMAGE_URL = './ext/resources/images/default/s.gif';
Ext.QuickTips.init();
//验证注册密码是否一致
Ext.apply(Ext.form.VTypes,{
	password:function(val,field){
		if(field.confirmTo){
			var pwd=Ext.get(field.confirmTo);
			return (val==pwd.getValue());
		}
		return true;
	}
});
Ext.onReady(function(){
	Ext.form.Field.prototype.msgTarget = 'side';
	var store_l = new Ext.data.SimpleStore({
	fields:['title','value'],
	data:[['浏览器进程','0'],['保留一天','1'],['保留一周','7']]
});
	var staffForm = new Ext.FormPanel({
		el:'hello-tabs',
		id:'staffForm',
		name:'staffForm',
		autoTabs:true,
		activeTab:0,
		deferredRender:false,
		border:false,
		items:{
			xtype:'tabpanel',
			activeTab: 0,
			defaults:{autoHeight:true, bodyStyle:'padding:10px'},
			items:[{
				title:'用户登录',
				contentEl: 'loginInfo',
				layout:'form',
				defaults: {width: 230},
				defaultType: 'textfield',
				items: [{
					cls : 'user',
					//width:100,
					fieldLabel: '帐号',
					name: 'username',
					style: 'font-size: 15px',
					allowBlank:false
				},{
					cls : 'key',
					//width:100,
					fieldLabel: '密码',
					name: 'password',
					style: 'font-size: 15px',
					inputType: 'password',
					allowBlank:false
				},{
					fieldLabel: '验证码',
					name: 'chknumber',
					maxLength: 4,
					width: 100,
					style: 'font-size:14px;font-weight:bold;letter-spacing: 1px;background:url(chknumber.php);background-repeat: no-repeat;background-position: 50px 0px;center right no-repeat;',
					allowBlank:false
				},new Ext.form.ComboBox({
					hiddenName:'cookietime',
					fieldLabel: '有效期',
					store:store_l,
					mode:'local',
					displayField:'title',
					valueField:'value',
					triggerAction:"all",
					editable:false,
					value:0,
					allowBlank:false,
					blankText:'请选择一个有效期',
					msgTarget:'qtip'
				})]
			},{
				title:'关于本系统',
				layout:'',
				
				html: '<?php echo $this->ftpl_var['sitetitle'];?><br> 开发笔记 技术支持',
				defaults: {border:false,width: 230}
			}]
		}
	});
	var win = new Ext.Window({
		el:'hello-win',
		layout:'fit',
		width:490,
		height:300,
		//autoHeight:true,
		closeAction:'hide',
		plain: true,
		modal:true,
		collapsible: true,
		draggable: true,
		closable: true,
		items:
		staffForm,
		buttons: [{
			text:'登陆',
			handler: function(){
				if(win.getComponent('staffForm').form.isValid()){
					win.getComponent('staffForm').form.submit({
						url:'index.php?filename=login&action=login',
						waitTitle:'提示',
						method: 'POST',
						waitMsg:'正在登录验证,请稍候...',
						success:function(form,action){
							var loginResult = action.result.success;
							if(loginResult == false){
								alert(action.result.message);
							} else if(loginResult == true){
								window.location.href='./index.php';
							}
						} ,
						failure: function(form,action) {
							//alert('登录系统失败,请与管理员联系.');
							Ext.MessageBox.alert('提示', action.result.msg);
							win.getComponent('staffForm').form.reset();
							//alert(action.result.result);
						}
					})
				}
			}
		}]
	}
	);
	//Ext.get('center-zone')
	win.show();
	setTimeout(function() {
	Ext.get('loading-mask').fadeOut( {
		remove : true
	});
}, 250);
});
</script>
<div id="hello-win" class="x-hidden">
    <div class="x-window-header"><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?></div>
    <div id="hello-tabs">
        	<img src="./templates/<?php echo $this->ftpl_var['style'];?>/images/systemBanner.jpg"/>
    </div>
<div id='loginInfo' style='color:red;padding-left:120px;'>
	<br>
<!-- 预设信息,位入登录面板下面一行 -->
请输入已经通过审核的用户名与密码进行登陆！---[<a href="./register.php" class=a><font color=blue><b>点击注册</font></a>]
</div>
</div>
<div id="swin" class="x-hidden">
    <input id=dd type=text>
</div>
</body>
</html>
