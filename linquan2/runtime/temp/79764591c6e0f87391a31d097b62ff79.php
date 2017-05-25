<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\main.html";i:1493960250;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<div class="wstmart-login-tips">
    <p>您好，<?php echo session('WST_STAFF.staffName'); ?>，欢迎使用临泉商城。 您上次登录的时间是 <?php echo session('WST_STAFF.lastTime'); ?> ，IP 是 <?php echo session('WST_STAFF.lastIP'); ?></p>
</div>
<!-- <div id='wstmart-version-tips' class='wstmart-version-tips'>您有新的版本(<span id='wstmart_version'>0.0.0</span>)可以下载啦~，<a id='wstmart_down' href='' target='_blank'>点击</a>下载</div>
<div id='wstmart-accredit-tips' class='wstmart-accredit-tips'>系统检测到您未获取授权，点此<a target='_blank' href='http://www.wstmart.net/index.php?c=License&a=index'>获取系统授权码</a></div>          -->       
<table width='100%' border='0' style="margin-top: 10px;">
   <tr>
     <td>
		<table class="wst-form wst-summary">
		  <tr>
		     <td class='wst-summary-head' colspan='4'>今日统计</td>
		  </tr>
		  <tr>
			 <td width="25%" align='right'><span>新增会员：</span></td>
			 <td width="25%"><span style="color: #e97758;"><?php echo $object['tody']['userType0']; ?></span></span></td>
			 <td width="25%" align='right'><span>新增商家：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['tody']['userType1']; ?></span></td>
		  </tr>
		  <tr>
		     <td align='right'><span>开店申请：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['tody']['shopApplys']; ?></span></td>
			 <td align='right'><span>新增投诉：</span></td>
		     <td><span style="color: #e97758;"><?php echo $object['tody']['compalins']; ?></span></td>
		  </tr>
		  <tr>
		     <td align='right'><span>上架商品：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['tody']['saleGoods']; ?></span><span style='margin-left:25px;'>（待审核：<span style="color: #e97758;"><?php echo $object['tody']['auditGoods']; ?></span>）</span></td>
			 <td align='right'><span>新增订单：</span></td>
		     <td><span style="color: #e97758;"><?php echo $object['tody']['order']; ?></span></td>
		  </tr>
		</table>
		<table class="wst-form wst-summary">
		  <tr>
		     <td class='wst-summary-head' colspan='4'>商城统计</td>
		  </tr>
		  <tr>
			 <td width="25%" align='right'><span>会员总数：</span></td>
			 <td width="25%"><span style="color: #e97758;"><?php echo $object['mall']['userType0']; ?></span></td>
			 <td width="25%" align='right'><span>商家总数：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['mall']['userType1']; ?></span></td>
		  </tr>
		  <tr>
		     <td align='right'><span>上架商品总数：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['mall']['saleGoods']; ?></span><span style='margin-left:25px;'>（待审核：<span style="color: #e97758;"><?php echo $object['mall']['auditGoods']; ?></span>）</span></td>
			 <td align='right'><span>订单总数：</span></td>
		     <td><span style="color: #e97758;"><?php echo $object['mall']['order']; ?></span></td>
		  </tr>
		  <tr>
		     <td align='right'><span>品牌总数：</span></td>
			 <td><span style="color: #e97758;"><?php echo $object['mall']['brands']; ?></span></td>
			 <td align='right'><span>评价总数：</span></td>
		     <td><span style="color: #e97758;"><?php echo $object['mall']['appraise']; ?></span></td>
		  </tr>
		</table>
		<table class="wst-form wst-summary">
		  <tr>
		     <td class='wst-summary-head' colspan='4'>系统信息</td>
		  </tr>
		<!--   <tr>
			 <td width="25%" align='right'><span>软件版本号：</span></td>
			 <td width="25%">【授权版】<?php echo WSTConf("CONF.wstVersion"); ?></td>
			 <td width="25%" align='right'><span>授权类型：</span></td>
			 <td><div id='licenseStatus'></div></td>
		  </tr>
		  <tr>
		     <td align='right'><span>问题反馈：</span></td>
			 <td id='webUrl'><a href="http://bbs.shangtaosoft.com" target='_blank'>点击反馈</a></td>
			 <td align='right'><span>授权码：</span></td>
		     <td><?php echo WSTConf("CONF.mallLicense"); ?></td>
		  </tr> -->
		  <tr>
		     <td align='right'><span>服务器操作系统：</span></td>
			 <td><?php echo PHP_OS; ?></td>
			 <td align='right'><span>WEB服务器：</span></td>
		     <td ><?php echo \think\Request::instance()->server('SERVER_SOFTWARE'); ?></td>
		  </tr>
		  <tr>
		     <td align='right'><span>PHP版本：</span></td>
		     <td ><?php echo PHP_VERSION; ?></td>
			 <td align='right'><span>MYSQL版本：</span></td>
		     <td ><?php echo $object['MySQL_Version']; ?></td>
		  </tr>
		</table>
	</td>
	<!-- <td width='260' valign='top' bgcolor="#fff" style="display: inline-block;margin-right: 8px;height: 100%;border-radius: 3px;">  
		<div class='wst-desc-head'>走进我们</div>
		<div class='wst-desc-body'>官网：<a href='http://www.wstmart.net' target='_blank'>http://www.wstmart.net</a></div>
		<div class='wst-desc-head' style='margin-top:20px;'>开发团队：</div>
		<div class='wst-desc-body'>广州商淘信息科技有限公司</div>
		<div class='wst-desc-head' style='margin-top:20px;'>我们的理念</div>
		<div class='wst-desc-body'>我们愿与更多中小企业一起努力，一起成功!</div>
		<div class='wst-desc-body'>We Success together!</div>
		<div class='wst-desc-head' style='margin-top:20px;'>使用交流</div>
		<div class='wst-desc-body'>交流社区：<a href='http://bbs.shangtaosoft.com' target='_blank'>http://bbs.shangtaosoft.com</a></div>
		<div class='wst-desc-body'>用户QQ群：590755485</div>
		<div class='wst-desc-head' style='margin-top:20px;'>商城定制</div>
		<div class='wst-desc-body'>电话：020-85289921</div>
		<div class='wst-desc-body'>QQ：153289970</div>  
	</td> -->
	</tr>
</table>


<script src="__ADMIN__/js/main.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
function enterLicense(){
	location.href='<?php echo Url("admin/index/enterLicense"); ?>';
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