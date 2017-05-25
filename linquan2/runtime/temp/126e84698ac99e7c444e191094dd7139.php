<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\replenishment\tuihuo.html";i:1495104498;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<style type="text/css">
	body {
		overflow: hidden
	}
	.wst-toolbar{
		border-top: 1px solid #f4f4f4;
	}
	.quanxuan label{display:block;width: 100%;height: 100%;background: #88b547;color: #fff;cursor: pointer;}
	#wst-tabs .l-tab-links,.wst-toolbar{
		background-color: #fff;
		margin-top: 0px;
		text-indent: 6px;
	}
	#wst-tabs .l-tab-links ul{
		margin-top: 12px;
	}
	#wst-tabs .l-tab-links{
		height: 50px ;
	}
	#layui-layer2{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}
	select,option{height: 38px;line-height: 38px;width: 80px;}
	form select,form option{height: 30px;line-height: 30px;}
	input[type="text"]{padding: 0px;height: 28px;}
	td{line-height: 28px}
	input[type="checkbox"]{vertical-align: top;}
	.bianji,.kucun,.shanchux{color: #069add;margin-left: 20px;cursor:pointer;}
	.biaoge_p{margin: 0px ;padding: 0px;line-height: 28px;margin-top: 8px;}
	.biaoge_p .biaoti{display: inline-block;width: 90px;text-align: right;vertical-align: top;}
	.biaoge_p .changdu1{width: 100px;}
	.biaoge_p .changdu2{width: 150px;}
	.biaoge_p .changdu3{width: 210px;}
	.biaoge_p .changdu4{width:498px;height: 60px;}
	.layui-layer-btn {padding-right: 26px;}
	.l-text-wrapper{display: inline-block;}
	
	#tj_tan,#tj_tanb{margin: auto;width: 92%}
	#tj_tan td{padding: 2px 5px;text-align: center;}
</style>
<div class="l-loading" style='display:block' id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:100%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第一个页面
    -->
	<div id="users" tabId="users" title="补货管理" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<!--<button class="tianjia" onclick="javascript:toEditA(0,0)">添加</button>-->
			<button class="shanchu" onclick="javascript:toBatchDel()">删除</button>
			
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDate" name="startDate" maxLength="20"  />
			<span style="margin: 0px 3px 0px 8px;">-</span>
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDate" name="endDate" maxLength="20"  />
			<input style="margin-left: 20px;" type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='userGrid'></div>
	</div>
</div>

<div id='expressBox' style='display:none'>
    <form id='expressForm' autocomplete="off">
    <input id="spec_list" name="spec_list" class="ipt" type="hidden" />
    <p class="biaoge_p">
    	<span class="biaoti">网点<font color='red'>*</font>：</span>
    	<input type='text' id='shopName' name="shopName" disabled="disabled" class='ipt changdu3' maxLength='20'/>
    	<span class="biaoti">申请人<font color='red'>*</font>：</span>
    	<input type='text' id='shopkeeper' name="shopkeeper"  disabled="disabled" class='ipt changdu1' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	
    	<span class="biaoti">补货商品<font color='red'>*</font>：</span>
    	<input type='text' id='goodsName' name="goodsName" disabled="disabled"  class='ipt changdu1' maxLength='20'/>
    	<span class="biaoti">商品规格<font color='red'>*</font>：</span>
    	<input type='text' id='spec' name="spec" disabled="disabled"  class='ipt changdu1' maxLength='20'/>
    	<span class="biaoti">补货数量<font color='red'>*</font>：</span>
    	<input type='text' id='tuihuo_do_num' name="tuihuo_do_num" disabled="disabled"  class='ipt changdu1' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">备注<font color='red'>*</font>：</span>
    	<textarea id="beizhu" name="beizhu" class="changdu4 ipt" style="height: 80px;resize: none;"></textarea>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">补货<font color='red'>*</font>：</span>
    	<select id="wangdian" name="wangdian" class="ipt">
    		<option value="">请选择</option>
    		<option value="1">网店</option>
    		<option value="2">仓库</option>
    	</select>
    	<select style="display:none;width: initial;" id="wangdian2" name="call_obj_id" class="ipt">
	    		
	    </select>
    	<span style="float: right;margin-right: 30px;"><span class="biaoti" >经办人<font color='red'>*</font>：</span>
    	<input type='text' id='expressName' name="expressName"  class='ipt changdu2' maxLength='20'/></span>
    </p>
    </form>
    <table id="tj_tan">

    </table>
 </div>



<script src="__ADMIN__/replenishment/logmoneyss.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script src="http://api.map.baidu.com/api?v=1.4" type="text/javascript"></script>

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