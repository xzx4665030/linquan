<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\datas\list.html";i:1495697066;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<link href="__ADMIN__/js/ztree/css/zTreeStyle/zTreeStyle.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />
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
	.layui-layer{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}
	select,option{height: 38px;line-height: 38px;width: 80px;}
	input[type="text"]{padding: 0px;height: 28px;}
	td{line-height: 28px}
	input[type="checkbox"]{vertical-align: top;}
	.bianji,.kucun,.shanchux{color: #069add;margin-left: 20px;cursor:pointer;}
	.biaoge_p{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 380px;display: block;}
	.biaoge_p .biaoti{display: inline-block;width: 70px;text-align: right;vertical-align: top;}
	.biaoge_p .changdu1{width: 120px;}
	.biaoge_p .changdu2{width: 200px;}
	.biaoge_p .changdu3{width: 290px;}
	.biaoge_p .changdu4{width:370px;background: #f00;display: inline-block;}
	.layui-layer-btn {padding-right: 26px;}
	.l-text-wrapper{display: inline-block;}
	
	
	
	#sdsdsd,.l-layout-header,.l-layout-header{display: none;}
	.l-layout-content{overflow: initial;}
	
	#sanjiA span,#sanjiB span{display: inline-block;width: 20px;height: 20px;background: url(__ADMIN__/datas/zhank.png) no-repeat 50% 50%;background-size: 16px 16px;vertical-align: middle;}
	#sanjiA a:hover,#sanjiB a:hover{color:#016A7E ;}
	#sanjiA .highlight,#sanjiB .highlight{background-image: url(__ADMIN__/datas/suox.png);}
	#sanjiA ul,#sanjiB ul{padding-left: 20px;}
	#sanjiA li,#sanjiB li{line-height: 20px;font-size: 16px;cursor: pointer;}
</style>
<!--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>-->
<div class="l-loading" style='display:block' id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:100%;overflow:hidden ; border: 1px solid #D3D3d3;" class="liger-tab">
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第一个页面
    -->
	<div id="shopsA" tabId="shopsA" title="库存查询" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			仓库：<select id="changkuA" name="changkuA">
				
			</select>
			供货商：<select id="gonghuosA" name="gonghuosA">
				
			</select>
			<input id="zhuanghA" name="zhuanghA" type='text' id='key1' placeholder='账号' />
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateA" name="startDateA" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateA" name="endDateA" class="ipt" maxLength="20"  />
			<button class="btn btn-blue" onclick="javascript:loadUserGridA()">查询</button>
		</div>
		<div id='shopGridA'>
			<div id="menuTreeA" style="width: 220px;float: left;overflow: scroll;">
				<ul id="sanjiA">
					
				</ul>
			</div>
			<div id="maingridA" style="float:right;"></div>
			<div class="clear"></div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$.ajax({
				url:WST.U('admin/datas/get_stock_list'),
				type:"post",
				dataType:'json',
				success:function(data){
					var ops="<option value=''>请选择</option>";
					for(var o=0;o<data.length;o++){
						ops=ops+"<option value='"+data[o].roleId+"'>"+data[o].roleName+"</option>";
					}
					$("#changkuA").html(ops);
				}
			})
			$.ajax({
				url:WST.U('admin/datas/get_supper_list'),
				type:"post",
				dataType:'json',
				success:function(data){
					console.log(data);
					var opsS="<option value=''>请选择</option>";
					for(var o=0;o<data.length;o++){
						opsS=opsS+"<option value='"+data[o].id+"'>"+data[o].company+"</option>";
					}
					$("#gonghuosA").html(opsS);
				}
			})
		})
	</script>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第二个页面
    -->
	<div id="shopsB" tabId="shopsB" title="库存变动" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<!--<button class="tianjia" onclick="javascript:getForEditB(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelB(0,0)" >删除</button>-->
			仓库：
			<select id="cangkuB" name="cangkuB">
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateB" name="startDateB" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateB" name="endDateB" class="ipt" maxLength="20"  />
			<input type='text' id='zhuanghB' name="zhuanghB" placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadUserGridB()">查询</button>
		</div>
		<div id='shopGridB'>
			<div id="menuTreeB" style="width: 220px;float: left;overflow: scroll;">
				<ul id="sanjiB">
					
				</ul>
			</div>
			<div id="maingridB" style="float:right;"></div>
			<div class="clear"></div>
		</div>
	</div>
	
</div>

 


<script src="__ADMIN__/js/ztree/jquery.ztree.all-3.5.js?v=<?php echo $v; ?>"></script>
<script src="__ADMIN__/datas/logmoneys.js?v=<?php echo $v; ?>" type="text/javascript"></script>


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