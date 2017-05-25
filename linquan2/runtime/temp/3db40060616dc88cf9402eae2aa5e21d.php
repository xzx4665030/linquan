<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\phpStudy\WWW\linquan2\addons\distribut\view\admin/shop_list.html";i:1490320102;s:84:"D:\phpStudy\WWW\linquan2\addons\distribut\view\..\..\..\wstmart\admin\view\base.html";i:1490282400;}*/ ?>
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
	
   <div id="query" style="float:left;">
	   		店铺编号:<input type="text" name="shopSn"  placeholder='账号' id="shopSn" class="query" />
	   		店铺名称:<input type="text" name="shopName" placeholder='手机号码' id="shopName" class="query" />
	   		店主姓名:<input type="text" name="shopkeeper" placeholder='电子邮箱' id="shopkeeper" class="query" />
	   		<input type="button" class="btn btn-blue" onclick="javascript:userQuery()" value="查询">
	</div>

   <div style="clear:both"></div>
</div>
<div class="wst-toolbar">
   
   <div style='clear:both'></div>
</div>
<div id="maingrid"></div>
<script>
$(function(){initGrid();})
  var grid;
  function initGrid(){
	  grid = $("#maingrid").ligerGrid({
			url:WST.U('addon/distribut-distribut-queryadmindistributshops'),
			pageSize:WST.pageSize,
			pageSizeOptions:WST.pageSizeOptions,
			height:'99%',
	        width:'100%',
	        minColToggle:6,
	        rowHeight:65,
	        rownumbers:true,
	        columns: [
	            { display: '店铺编号', name: 'shopSn',isSort: false},
		        { display: '店铺名称', name: 'shopName',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+rowdata['shopName']+"</div>";
	            }},
		        { display: '店主姓名', name: 'shopkeeper',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+rowdata['shopkeeper']+"</div>";
	            }},
		        { display: '店主联系电话', name: 'telephone',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+rowdata['telephone']+"</div>";
	            }},
		        { display: '店主店铺地址', name: 'shopAddress',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+rowdata['shopAddress']+"</div>";
	            }},
		        { display: '所属公司', name: 'distributType',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+rowdata['shopCompany']+"</div>";
	            }},
		        { display: '分销模式', name: 'shopCompany',isSort: false,render: function (rowdata, rowindex, value){
		        	return "<div class='goods-valign-m'>"+(rowdata['distributType']==1?"按商品设置提取佣金":"按订单比例提取佣金")+"</div>";
	            }},
		        { display: '购买者分成', name: 'buyerRate',isSort: false},
		        { display: '第二级分成', name: 'secondRate',isSort: false},
		        { display: '第三级分成', name: 'thirdRate',isSort: false},
		        { display: '营业状态', name: 'shopAtive',isSort: false,render: function (rowdata, rowindex, value){
		        	return (rowdata['shopAtive']==1)?"营业中":"休息中";
		        }}
	        ]
	    });

  }
  function userQuery(){
		var query = WST.getParams('.query');
		grid.set('url',WST.U('addon/distribut-distribut-queryadmindistributshops',query));
  }
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