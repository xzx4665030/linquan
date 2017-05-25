<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\templatemsgs\edit_email.html";i:1488332790;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490282400;}*/ ?>
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
<form autocomplete='off'>
<input type='hidden' id='id' class='ipt' value="<?php echo $object['id']; ?>"/>
<input type='hidden' id='tplCode' class='ipt' value="<?php echo $object['tplCode']; ?>"/>
<table class='wst-form wst-box-top'>
  <tr>
     <th width='120'>发送时机：</th>
     <td>
         <?php $_result=WSTDatas(7);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['dataVal']==$object['tplCode']): ?><?php echo $vo['dataName']; endif; endforeach; endif; else: echo "" ;endif; ?>
     </td>
  </tr>
  <tr>
     <th>内容：</th>
     <td>
     <textarea id='tplContent' name='tplContent' style='width:70%;height:100px;' class='ipt' maxLength='150'><?php echo $object['tplContent']; ?></textarea>
     </td>
  </tr>
  <tr>
     <th valign="top">说明：</th>
     <td id='tplDesc'><?php echo $object['tplDesc']; ?></td>
  </tr>
  <tr>
     <td colspan='2' align='center'>
       <input type='button' value='保存' class='btn btn-blue' onclick='javascript:save(1)'>
       <input type='button' value='返回' class='btn' onclick='javascript:history.go(-1)'>
     </td>
  </tr>
</table>
</form>
<script>
$(function(){
   initEditor();
});
</script>


<script src="__STATIC__/plugins/kindeditor/kindeditor.js?v=<?php echo $v; ?>" type="text/javascript" ></script>
<script src="__ADMIN__/templatemsgs/templatemsgs.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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