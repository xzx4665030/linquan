<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\users\list.html";i:1489830484;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
            会员类型：<select name="userType" id="userType" class="query">
          <option value="">全部</option>
          <option value="0">普通会员</option>
          <option value="1">商家</option>
        </select>
	   		会员账号:<input type="text" name="loginName1"  placeholder='账号' id="loginName1" class="query" />
	   		手机号码:<input type="text" name="loginPhone" placeholder='手机号码' id="loginPhone" class="query" />
	   		电子邮箱:<input type="text" name="loginEmail" placeholder='电子邮箱' id="loginEmail" class="query" />
	   		
	   		<input type="button" class="btn btn-blue" onclick="javascript:userQuery()" value="查询">
	</div>

   <?php if(WSTGrant('HYGL_01')): ?>
   <button class="btn btn-green f-right" onclick="javascript:location.href='<?=url("users/toEdit")?>'">新增</button>
   <?php endif; ?>
   <div style="clear:both"></div>
</div>
<div id="maingrid"></div>
<script>
  $(function(){initGrid()});
</script>


<script src="__ADMIN__/users/users.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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