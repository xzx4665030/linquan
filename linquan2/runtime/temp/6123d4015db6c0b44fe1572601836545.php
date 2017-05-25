<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\images\view.html";i:1488332784;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490282400;}*/ ?>
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

<style type="text/css"> 
*{ margin:0; padding:0; list-style:none;} 
img{ border:none;} 
.imgbox{ width:400px; height:400px; margin:0px auto;text-align:center;vertical-align:middle;display:block;position:relative;padding:5px;} 
.imgbox a{display:table-cell;vertical-align:middle;width:400px; height:400px; } 
.imgbox a img{max-width:400px;max-height:400px; }
.imgthumbbox{ width:100px; height:100px;text-align:center;vertical-align:middle;display:block;position:relative;border:1px solid #ddd;margin-bottom:10px;} 
.imgthumbbox a{display:table-cell;vertical-align:middle;width:100px; height:100px; } 
.imgthumbbox a img{max-width:100px;max-height:100px; }
.mimgbox{ width:100px; height:100px; text-align:center;vertical-align:middle;display:block;position:relative;border:1px solid #ddd;margin-bottom:10px;} 
.mimgbox a{display:table-cell;vertical-align:middle;width:100px; height:100px; } 
.mimgbox a img{max-width:100px;max-height:100px; }
.mimgthumbbox{ width:100px; height:100px; text-align:center;vertical-align:middle;display:block;position:relative;border:1px solid #ddd} 
.mimgthumbbox a{display:table-cell;vertical-align:middle;width:100px; height:100px; } 
.mimgthumbbox a img{max-width:100px;max-height:100px; }
.head{line-height:25px;height:25px;}    
</style> 
</head> 
<body> 
<table width='100%'>
  <tr>
    <td>
	  <div class='imgbox'>
	    <?php if($img): ?>
	    <a href='__ROOT__/<?php echo $imgpath; ?>' target="_blank">
	    <img id='img' src='__ROOT__/<?php echo $imgpath; ?>'/>
	    </a>
	    <?php else: ?>
	     图片不存在!
	    <?php endif; ?>
	  </div>
	</td>
    <td width='150'>
    <?php if($thumb): ?>
    <div><div class='head'>缩略图：</div>
	    <div class='imgthumbbox'>
	      <a href='__ROOT__/<?php echo $thumbpath; ?>' target="_blank">
		    <img src='__ROOT__/<?php echo $thumbpath; ?>'/>
		  </a>
	    </div>
    </div>
    <?php endif; if($mimgpath !=''): ?>
    <div><div class='head'>移动端图片：</div>
	    <div class='mimgbox'>
	      <a href='__ROOT__/<?php echo $mimgpath; ?>' target="_blank">
		    <img src='__ROOT__/<?php echo $mimgpath; ?>'/>
		  </a>
	    </div>
    </div>
    <?php endif; if($mthumbpath !=''): ?>
    <div><div class='head'>移动端缩略图：</div>
	    <div class='mimgthumbbox'>
	      <a href='__ROOT__/<?php echo $mthumbpath; ?>' target="_blank">
		    <img src='__ROOT__/<?php echo $mthumbpath; ?>'/>
		  </a>
	    </div>
    </div>
    <?php endif; ?>
  </td>
  </tr>
</table>


<script src="__ADMIN__/images/images.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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