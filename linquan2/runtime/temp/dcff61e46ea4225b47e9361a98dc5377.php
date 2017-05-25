<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"D:\phpStudy\WWW\linquan2\addons\distribut\view\admin/money_list.html";i:1490320092;s:84:"D:\phpStudy\WWW\linquan2\addons\distribut\view\..\..\..\wstmart\admin\view\base.html";i:1490282400;}*/ ?>
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

<div class="l-loading" style="display: block" id="wst-loading"></div>
<div class="wst-toolbar">
	订单号:<input type="text" name="orderNo" placeholder='订单号' id="orderNo" class="query" />
	用户名称:<input type="text" name="userName" placeholder='用户名称' id="userName" class="query" />
<button class="btn btn-blue" onclick='javascript:moneyQuery()'>查询</button>
<div style='clear:both'></div>
</div>
<div id="maingrid"></div>
<script>
$(function(){
	  initGrid();
	  var grid;
	  function initGrid(){
		  grid = $("#maingrid").ligerGrid({
				url:WST.U('addon/distribut-distribut-queryadmindistributmoneys'),
				pageSize:WST.pageSize,
				pageSizeOptions:WST.pageSizeOptions,
				height:'99%',
		        width:'100%',
		        minColToggle:6,
		        rownumbers:true,
		        columns: [
		            { display: '订单编号', name: 'orderNo',isSort: false},
			        { display: '获佣用户', name: 'userName',isSort: false},
			        { display: '佣金描述', name: 'remark',isSort: false},
			        { display: '佣金金额', name: 'distributMoney',isSort: false},
			        { display: '记录时间', name: 'createTime',isSort: false}
		        ]
		    });

	  }
	  
	  function moneyQuery(){
			var query = WST.getParams('.query');
			grid.set('url',WST.U('addon/distribut-distribut-queryadmindistributmoneys',query));
	  }
})
</script>


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