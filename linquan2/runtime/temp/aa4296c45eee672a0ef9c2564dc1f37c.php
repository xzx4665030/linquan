<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\logmoneys\list_log.html";i:1489829412;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<style>
.l-text-wrapper{width:168px;float:left;}
.tbr-h{height:30px;line-height:30px;}
body{overflow: hidden;}
</style>

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

<div class="l-loading" style='display:block' id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:100%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
   <div id="users" tabId="users"  title="<?php echo $object['userName']; ?>(<?php echo $object['loginName']; ?>)资金流水" class='wst-tab'  style="height: 99%">
   <div class="wst-toolbar">
  <div class='f-left tbr-h'>操作日期：</div>
  <input type="text" style="margin:0px;vertical-align:baseline;" id="startDate" name="startDate" class="ipt" maxLength="20"  />
  <div class='f-left tbr-m'>至</div>
  <input type="text" style="margin:0px;vertical-align:baseline;" id="endDate" name="endDate" class="ipt" maxLength="20"  />
  <button class="btn btn-blue" style='margin-top: 3px;margin-left: 5px' onclick='javascript:loadMoneyGrid(<?php echo $object['userType']; ?>,<?php echo $object['userId']; ?>)'>查询</button> 
  <button class="btn btn-gray f-right" style='margin-top: 3px'onclick="javascript:history.go(-1)">返回</button> 
  <div style='clear: both'></div>
  </div>
   <div id='moneyGrid'></div>
   </div>
</div>
<script>
  $(function(){moneyGridInit(<?php echo $object['userType']; ?>,<?php echo $object['userId']; ?>);})
</script>


<script src="__ADMIN__/logmoneys/logmoneys.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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