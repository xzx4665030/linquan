<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\mobile\list.html";i:1493876837;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta name="Keywords" content=""/>
<meta name="Description" content=""/> 
<link href="__ADMIN__/js/ligerui/skins/Aqua/css/ligerui-all.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" /> 
<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__ADMIN__/css/style.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />   
<script src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>  
<script src="__ADMIN__/js/ligerui/js/ligerui.all.js?v=<?php echo $v; ?>" type="text/javascript"></script> 
<script type='text/javascript' src='__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>'></script> 
<script src="__STATIC__/js/common.js?v=<?php echo $v; ?>"></script>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',\think\Request::instance()->root(true)); ?>","ROOT":"__ROOT__","APP":"__APP__","STATIC":"__STATIC__","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"ROUTES":'<?php echo WSTRoute(); ?>'}
</script>
<script src="__ADMIN__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
</head>
<body>

<style>
	.kongge{
		display: inline-block;
		width: 20px;
	}
	.lis{
		padding-left: 40px;
		list-style-type: disc;
		color: #323232;
	}
	.lis li{
		list-style-type: disc;
		padding: 3px 0px;
	}
	#expressFormA{
		padding: 20px 0px;
	}
	#expressFormA p{
		text-indent: 40px;
		padding: 5px 0px;
	}
	#expressFormA p input{
		width: 300px;
		margin-right: 15px;
	}
	.layui-layer{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}
</style>
<div class="l-loading" style="display: block" id="wst-loading"></div>
<div class="wst-toolbar" style="background: #fff;">
	<div style="color: #5867d1;font-size: 16px;padding: 8px 0px;text-indent: 20px;border-bottom: 1px solid #dfdfdf;">操作提示：</div>
	<div>
		<button class="tianjia" style="position: absolute;right: 20px;margin-top: 5px;" onclick="javascript:toEditA(0)">添加</button>
		<ul class="lis">
			<li>点击添加专题按钮可以添加新的专题</li>
			<li>点击修改按钮可以修改对应专题</li>
			<li>点击编辑按钮对专题内容进行修改</li>
			<li>点击删除按钮可以删除整个专题</li>
		</ul>
	</div>
<div style='clear:both'></div>
</div>
<div id="maingrid"></div>
<div id='expressBoxA' style='display:none'>
	<form id='expressFormA' autocomplete="off" >
	<p>专题描述</p>
	<p><input id="special_desc"  class="ipt" name="special_desc"  type="text"/>专题描述，最多20个字</p>
	</form>
</div>
<script>
$(function(){
	initGrid();
})
</script>


<script src="__ADMIN__/mobile/cashdraws.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<script>
function showImg(opt){
	layer.photos(opt);
}
function showBox(opts){
	return WST.open(opts);
}
</script>
<?php echo hook('initCronHook'); ?>
</body>
</html>