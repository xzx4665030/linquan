<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\configure\list_log2.html";i:1493955820;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
#wst-tabs .l-tab-links li.l-selected a{
	color: #333 !important;
}
.l-tab-links li.l-selected{background: none !important;width: initial;}
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
   <div class="wst-toolbar" style="height: 60px;font-size: 20px;line-height: 20px;">
   	<button class="shanchu" onclick="javascript:toBatchDelB1(0,0)" >删除</button>
  <span style="color: #333;vertical-align: middle;">当前仓库：<?php echo $roles['roleName']; ?></span>
  <button class="btn btn-gray f-right" style='margin-top: 3px'onclick="javascript:history.go(-1)">返回</button> 
  <div>
    <select id="supplier"  style="font-size: 14px; width: 80px;">
      <option value="0" >请选择</option>
      <?php if(is_array($supplier) || $supplier instanceof \think\Collection): $i = 0; $__LIST__ = $supplier;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
       <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['company']; ?></option>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
  </div>
  <div style='clear: both'></div>
  </div>
   <div id='moneyGrid'></div>
 
<script>
	
  $(function(){
  	$(function(){moneyGridInitB(<?php echo $roles['roleId']; ?>,'');})
  	})
</script>
<script type="text/javascript">
  $("#supplier").change(function(){
      var id=$('#supplier').val();
      moneyGridInitB(<?php echo $roles['roleId']; ?>,id);
      });
</script>


<script src="__ADMIN__/configure/logmoneys.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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