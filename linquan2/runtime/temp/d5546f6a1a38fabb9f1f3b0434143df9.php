<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\express\list.html";i:1495706720;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
<?php if(WSTGrant('KDGL_01')): ?>
<div class="wst-toolbar">
   <button class="btn btn-green f-right" onclick='javascript:toEdit(0)'>新增</button>
   <div style="clear:both"></div>
<?php endif; ?>
</div>
<div id="maingrid"></div>

<div id='expressBox' style='display:none'>
    <form id='expressForm' autocomplete="off">
    <table class='wst-form wst-box-top'>
       <tr>
          <th width='100'>快递名称<font color='red'>*</font>：</th>
          <td><input type='text' id='expressName' name="expressName"  class='ipt' maxLength='20'/></td>
       </tr>
       <tr>
          <th width='100'>快递代码：</th>
          <td><input type='text' id='expressCode' name="expressCode"  class='ipt' maxLength='20'/></td>
       </tr>
       <tr>
          <th width='100'>官网电话：</th>
          <td><input type='text' id='expressTel' name="expressTel"  class='ipt' maxLength='20'/></td>
       </tr>
       <tr>
          <td colspan="2" style="padding-left: 35px;">快递代码是用于物流查询，请查询所启用插件的快递代码</td>
       </tr>
    </table>
    </form>
 </div>
<script>
  $(function(){initGrid()});
</script>


<script src="__ADMIN__/express/express.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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