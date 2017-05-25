<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\linquan2\addons\groupon\view\admin/list.html";i:1488332810;s:82:"D:\phpStudy\WWW\linquan2\addons\groupon\view\..\..\..\wstmart\admin\view\base.html";i:1490867328;}*/ ?>
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

<style>
	.time{line-height:15px;margin-top:10px;}
	.valign-m{vertical-align:middle;line-height:65px;}
</style>
<div class="l-loading" style="display: block" id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:99%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
   <div title="团购商品" class='wst-tab'  style="height: 99%">
		<div class="wst-toolbar">
		商家所在地：
		<select id="areaId1" class='j-ipt j-areas' level="0" onchange="WST.ITAreas({id:'areaId1',val:this.value,className:'j-areas'});">
		  <option value="">-请选择-</option>
		  <?php if(is_array($areaList) || $areaList instanceof \think\Collection): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		  <option value="<?php echo $vo['areaId']; ?>"><?php echo $vo['areaName']; ?></option>
		  <?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		店铺：<input type="text" name="shopName1"  placeholder='店铺名称/店铺编号' id="shopName1" class='j-ipt'/>
		<br/>
		所属分类：
		<select id="cat1_0" class='ipt pgoodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat1_0',val:this.value,isRequire:false,className:'pgoodsCats'});">
		   <option value="">-请选择-</option>
		   <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		商品：<input type="text" name="goodsName1"  placeholder='商品名称/商品编号' id="goodsName1" class='j-ipt'/>
		<button class="btn btn-blue" onclick='javascript:loadGrid1(0)'>查询</button>
		<div style='clear:both'></div>
		</div>
		<div id="maingrid1"></div>
   </div>
   <div title="待审核商品" class='wst-tab'  style="height: 99%">
        <div class="wst-toolbar">
		商家所在地：
		<select id="areaId2" class='j-ipt j-areas' level="0" onchange="WST.ITAreas({id:'areaId2',val:this.value,className:'j-areas'});">
		  <option value="">-请选择-</option>
		  <?php if(is_array($areaList) || $areaList instanceof \think\Collection): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		  <option value="<?php echo $vo['areaId']; ?>"><?php echo $vo['areaName']; ?></option>
		  <?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		店铺：<input type="text" name="shopName2"  placeholder='店铺名称/店铺编号' id="shopName2" class='j-ipt'/>
		<br/>
		所属分类：
		<select id="cat2_0" class='ipt pgoodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat2_0',val:this.value,isRequire:false,className:'pgoodsCats'});">
		   <option value="">-请选择-</option>
		   <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		商品：<input type="text" name="goodsName2"  placeholder='商品名称/商品编号' id="goodsName2" class='j-ipt'/>
		<button class="btn btn-blue" onclick='javascript:loadGrid2(0)'>查询</button>
		<div style='clear:both'></div>
		</div>
		<div id="maingrid2"></div>
   </div>


<script src="__ROOT__/addons/groupon/view/admin/list.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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