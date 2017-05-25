<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\attributes\list.html";i:1488332792;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
	<div class="f-left">
		<div id="pcat_0_box" class="f-left">
		 所属分类：<select id="cat_0" class='ipt pgoodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat_0',val:this.value,isRequire:false,className:'pgoodsCats'});">
	      	<option value="">-请选择-</option>
	      	<?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	        <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
	     </select>
	     </div>
	     <input type="text" id="keyName" placeholder="请输入属性名称"/>
	     <button class="btn btn-green" onclick="loadGrid(0)">查询</button>
     </div>
    
   <?php if(WSTGrant('SPSX_01')): ?>
   <button class="btn btn-green f-right" onclick="javascript:toEdit(0);">新增</button>
   <?php endif; ?>
   <div style="clear:both"></div>
</div>
<div id="maingrid"></div>
<div id='attrBox' style='display:none'>
	<form id="attrForm">
		<table class='wst-form wst-box-top'>
		  <tr>
		      <th width='150'>
		      	<input type="hidden" id="attrId" value="" class="ipt" />
		    	 所属商品分类<font color='red'>*</font>：</th>
		     	<td id="bcat_0_box">
		            <select id="bcat_0" class='ipt goodsCats' level="0" onchange="WST.ITGoodsCats({id:'bcat_0',val:this.value,isRequire:false,className:'goodsCats'});" data-rule='所属商品分类:required;' data-target="#msg_bcat_0">
		                <option value="">-请选择-</option>
		                <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				        <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
				        <?php endforeach; endif; else: echo "" ;endif; ?>
		           	</select>
		           	<span class='msg-box' id='msg_bcat_0' style='color:red;'>(至少选择一个商品分类)</span>
		          </td>
		       </tr>
		       <tr>
		          <th>属性名称<font color='red'>*</font>：</th>
		          <td>
		              <input type="text" id="attrName" name="attrName" class="ipt" maxLength='20'/>
		          </td>
		       </tr>
		       <tr>
		          <th>属性类型<font color='red'>*</font>：</th>
		          <td>
		              <select id='attrType' class='ipt' onchange='changeArrType(this.value)'>
		                 <option value='0'>输入框</option>
		                 <option value='1'>多选项</option>
		                 <option value='2'>下拉项</option>
		              </select>
		          </td>
		       </tr>
		       <tr id='attrValTr' style='display:none'>
		          <th>属性选项<font color='red'>*</font>：</th>
		          <td>
		              <input type="text" id="attrVal" name="attrVal" class="ipt" style='width:70%' placeholder="每个属性选项以,号分隔" data-msg='请输入属性选项'/>
		          </td>
		       </tr>
		       <tr>
		          <th>是否显示<font color='red'>  </font>：</th>
		          <td>
		            <label>
		              <input type="radio" name="isShow" value="1" class="ipt" />显示
		            </label>
		            <label>
		              <input type="radio" name="isShow" value="0" class="ipt" />隐藏
		            </label>
		          </td>
		       </tr>
		       <tr>
		          <th>排序号<font color='red'>*</font>：</th>
		          <td>
		              <input type="text" id="attrSort" name="attrSort" class="ipt" maxLength='20'/>
		          </td>
		       </tr>
		</table>
	</form>
</div>


<script src="__ADMIN__/attributes/attributes.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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