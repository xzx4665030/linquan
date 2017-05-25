<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\index.html";i:1493956229;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
body{padding:0px;background:#EAEEF5;overflow:hidden;}
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

<div id="topmenu" class="wst-topmenu">
    <!--<div class="wst-topmenu-logo"><img height='90' src="__ADMIN__/img/logo.png"/></div>-->
    <div class="wst-topmenu-welcome">
        <a href="<?php echo url('home/index/index'); ?>" target='_blank' class="wst-top-link">
          <!--<span class='website'></span>-->商城首页</a>
        <?php if(WSTGrant('ZYDP_00')): ?>
       <!-- <span class="wst-space">|</span>-->
        <a href="<?php echo url('admin/shops/inself'); ?>" target='_blank' class="wst-top-link">
          <!--<span class='selfshop'></span>-->自营店铺管理</a>
        <?php endif; ?>
      <!--  <span class="wst-space">|</span>-->
        <a href="http://www.ahxiaodian.com" class="wst-top-link" target="_blank">
          <!--<span class='support'></span>-->服务支持</a> 
        <?php if(WSTGrant('HHQL_04')): ?>
      <!--  <span class="wst-space">|</span>-->
        <a href="#none" onclick='clearCache()' class="wst-top-link">
          <!--<span class='clear'></span>-->清除缓存</a>
        <?php endif; ?>
        <!--<span class="wst-space">|</span>-->
        <a href="#none" onclick='editPassBox()' class="wst-top-link">
         <!-- <span class='password'></span>-->修改密码</a>
       <!-- <span class="wst-space">|</span>-->
        <a href="javascript:logout()" class="wst-top-link">
          <span class='logout'></span>admin</a> 
    </div> 
</div>
<div id="wst-tabs" style="width:100%; height:100%;overflow: hidden;background-color: #f5f5f5;" class="liger-tab">
   <?php if(is_array($menus) || $menus instanceof \think\Collection): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
   <div id="wst-tab-<?php echo $vo['menuId']; ?>" tabId="wst-tab-<?php echo $vo['menuId']; ?>" v="<?php echo $vo['menuId']; ?>" title="<?php echo $vo['menuName']; ?>" class='wst-tab' <?php if($k ==0): ?>lselected="true"<?php endif; ?> style="height: 300px"> 
   </div>
   <?php endforeach; endif; else: echo "" ;endif; ?>
   <!-- 
   <div id="wst-tab-market" tabId="wst-tab-market" v="market" title="WSTMart广场" class='wst-tab' style="height: 300px;display:none">
   <iframe id='wst-market' frameborder="0" src="" width='100%' height='100%'></iframe> 
   </div>
   -->
</div>
<div id='editPassBox' style='display:none;padding-top:5px;'>
  <form id='editPassFrom' autocomplete="off">
   <table class='wst-form'>
      <tr>
         <th style='width:100px'>原密码：</th>
         <td><input type='password' id='srcPass' name='srcPass' class='ipt' data-rule="原密码: required;" maxLength='16'/></td>
      </tr>
      <tr>
         <th>新密码：</th>
         <td><input type='password' id='newPass' name='newPass' class='ipt' data-rule="新密码: required;length[6~]" maxLength='16'/></td>
      </tr>
      <tr>
         <th>确认密码：</th>
         <td><input type='password' id='newPass2' name='newPass2' class='ipt' data-rule="确认密码: required;match(newPass);" maxLength='16'/></td>
      </tr>
   </table>
  </form>
</div>


<script src="__ADMIN__/js/index.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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