<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\mobile\edit.html";i:1495162610;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
	body{
		background: #f0f0f0;
		height: initial;
	}
	.kongge{
		display: inline-block;
		width: 20px;
	}
	.lis{
		padding-left: 40px;
		list-style-type: disc;
		color: #323232;
	}
	.lis li{
		list-style-type: disc;
		padding: 3px 0px;
	}
	a{ cursor:pointer;}
	/*.layui-layer{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}*/
	
	#maingrid_A{overflow-y: auto;}
	.shouji{
		position:relative;background: url(__ADMIN__/mobile/imgs/shouji_yunlf.png) no-repeat;width: 396px;height: 718px;float: left;margin-left: 80px;
	}
	.yangshi{
		background: #ffffff;
	    width: 348px;
	    height: 562px;
	    position: absolute;
	    margin: 72px 0px 0px 21px;
	    overflow-y: scroll;
	}
	#yangshi{
		width: 330px;
	}
	.muban{padding-bottom: 20px;opacity: 0.5;}
	.muban:hover{opacity: 1;}
	.mubanA{background:url(__ADMIN__/mobile/imgs/yangshi_1.png) no-repeat;position: relative ;width: 320px;height: 100px;}
	.mubanB{background:url(__ADMIN__/mobile/imgs/yangshi_2.png) no-repeat;position: relative ;width: 320px;height: 100px;}
	.mubanC{background:url(__ADMIN__/mobile/imgs/yangshi_3.png) no-repeat;position: relative ;width: 320px;height: 100px;}
	.mubanD{background:url(__ADMIN__/mobile/imgs/yangshi_4.png) no-repeat;position: relative ;width: 320px;height: 210px;}
	.muban_m{
		position: absolute;color: #fff;width: 42px;top: 10px;left: 10px;
	}
	.muban_t{position: absolute;color: #fff;right: 9px;width: 16px;padding: 7px;cursor:pointer;}
	
	.kuangjia{border: 1px #222 dotted ;padding: 4px;margin: 5px;position: relative;min-height:50px ;}
	.kuangjia:hover{border: 1px solid #19AEDE;}
	.kuangjia .kuangjia_t{position: absolute;width: 310px;height: 20px;font-size: 12px;line-height: 20px;color: #181618;background: rgba(186,186,186,1);text-indent: 15px;}
	.kuangjia:hover .kuangjia_t{background:  rgba(25,174,222,0.85);color: #fff;}
	.kuangjia:hover .kuangjia_b{display: block;}
	.kuangjia .kuangjia_b{position: absolute;width: 310px;bottom: 5px;height: 20px;font-size: 12px;line-height: 20px;background:  rgba(25,174,222,0.85);text-align: right;display: none;}
	.kuangjia .kuangjia_b a{margin-right: 15px;text-indent: 20px;display: inline-block;color: #fff;background-size:15px 15px ;}
	.kuangjiaA{width: 310px;height: 115px;}
	.kuangjiaA .img_a{display: block;margin: auto;}
	
	/*.kuangjiaB{width: 310px;height: 120px;}*/
	.kuangjiaB{float: left;width: 152px;height: 120px;margin-right: 6px;}
	.kuangjiaC{float: left;width: 152px;height: 57px;margin-bottom: 6px;}
	.kuangjiaD{float: left;width: 152px;height: 57px;}
	.kuangjiaE{float: left;width: 74px;height: 74px;margin-bottom: 4px;margin-right: 4px;}
	.kuangjiaE:nth-of-type(4n+4){margin-right:0px}
	.kuangjiaF{float: left;width: 151px;margin-bottom: 4px;margin-right: 4px;border: 1px solid #eee;}
	.kuangjiaF_img{width: 151px;height: 151px;}
	.kuangjiaF_ming{width: 151px;height:28px;line-height: 14px;padding:3px 0px;overflow: hidden;}
	.kuangjiaF_jiag{width: 151px;height: 16px;line-height: 16px;color: #F30;}
	.kuangjiaF:nth-of-type(2n+2){margin-right:0px}
	.k_bianji{background:url(__ADMIN__/mobile/imgs/bianji.png) no-repeat 1px 50% ;}
	.k_shanchu{background:url(__ADMIN__/mobile/imgs/shanchu.png) no-repeat 1px 50% ;}
	.k_shangyi{background:url(__ADMIN__/mobile/imgs/shangyi.png) no-repeat 1px 50% ;}
	.k_xiayi{background:url(__ADMIN__/mobile/imgs/xiayi.png) no-repeat 1px 50% ;}
</style>
<div class="l-loading" style="display: block" id="wst-loading"></div>
<div id="maingrid_A">
	<div style="background: #fff;" class="toubu">
		<div style="color: #5867d1;font-size: 16px;padding: 8px 0px;text-indent: 20px;border-bottom: 1px solid #dfdfdf;">操作提示:
			<input style="float: right;margin-right: 20px;" type='button' value='返回' class='btn' onclick='javascript:history.go(-1)'>
		</div>
		<div>
			<ul class="lis">
				<li>点击右侧组件的“添加”按钮，增加对应类型版块到页面，其中“广告条版块”只能添加一个</li>
				<li>鼠标触及左侧页面对应版块，出现操作类链接，可以对该区域块进行“移动”、“编辑”、“删除”操作</li>
				<!--<li>新增加的版块内容默认为“禁用”状态，编辑内容并“启用”该块后将在手机端即时显></li>-->
			</ul>
		</div>
	</div>
	<div class="" style="padding: 30px 0px;">
		<div class="shouji" >
			<div class="yangshi">
				<div id="yangshi">
					
				</div>
			</div>
		</div>
		<div style="float: left;margin-left: 60px;">
			<div class="muban mubanA" style="">
				<span class="muban_m">广告条版块</span>
				<sapn class="muban_t" onclick="tianjian(1)">添加</sapn>
			</div>
			<div class="muban mubanB" style="">
				<span class="muban_m">模块1</span>
				<span class="muban_t" onclick="tianjian(3)">添加</span>
			</div>
			<div class="muban mubanC" style="">
				<span class="muban_m">导航</span>
				<span class="muban_t" onclick="tianjian(2)">添加</span>
			</div>
			<div class="muban mubanD" style="">
				<span class="muban_m">商品</span>
				<span class="muban_t" onclick="tianjian(4)">添加</span>
			</div>
			<div class="muban mubanA" style="">
				<span class="muban_m">活动</span>
				<sapn class="muban_t" onclick="tianjian(5)">添加</sapn>
			</div>
			<div class="muban mubanC" style="">
				<span class="muban_m">抢购</span>
				<span class="muban_t" onclick="tianjian(6)">添加</span>
			</div>
			<div class="muban mubanD" style="">
				<span class="muban_m">店铺</span>
				<span class="muban_t" onclick="tianjian(7)">添加</span>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<input type='hidden' id='cashId' class='ipt' value="<?php echo $id; ?>"/>
<script type="text/javascript">
	$(function(){
		var ids=$("#cashId").val();
		$.ajax({
            type: "post",
             url: WST.U('admin/mobile/item'),
             data: {id:ids},
             dataType: "json",
             success: function(data){
	           			var muban="";
	           			for (var i =0; i <data.length; i++) {
	           				if (data[i].item_type=="adv_list") {
	           					var kk="";
	           					if(data[i].item_data.item){
	           						kk=kk+'<img class="img_a" src="'+data[i].item_data.item[0].image+'" />';
	           					}else{
	           						kk=kk+'<img class="img_a" src="xxx" />'
	           					}
								muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'"><span class="lbt" style="display:none"></span><p class="kuangjia_t">广告条版块</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(1,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p><div class="kuangjiaA">'+kk+'</div></div>';
	           				}else if(data[i].item_type=="home2"){
	           					var imgx="xxx";var imgy="xxx";var imgz="xxx";
	           					
	           					if(data[i].item_data){
	           						if(data[i].item_data.rectangle1_image.image!=''){
	           							imgx=data[i].item_data.rectangle1_image.image;
	           						}
	           						if(data[i].item_data.rectangle2_image.image!=''){
	           							imgy=data[i].item_data.rectangle2_image.image;
	           						}
	           						if(data[i].item_data.square_image.image!=''){
	           							imgz=data[i].item_data.square_image.image;
	           						}
	           					}
	           					muban=muban+'<div class="kuangjia"  id="'+data[i].item_id+'"><p class="kuangjia_t">模块1</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(2,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p>';
	           					muban=muban+'<div class="kuangjiaB"><img class="img_b" src="'+imgx+'" /></div><div class="kuangjiaC"><img class="img_c" src="'+imgy+'"  /></div><div class="kuangjiaD"><img class="img_d" src="'+imgz+'"  /></div><div style="clear: both;"></div></div>'
	           				}else if(data[i].item_type=="home1"){
	           					var kk="";
	           					if (data[i].item_data) {
									for(var j=0;j<data[i].item_data.item.length;j++){
		           						kk=kk+'<div class="kuangjiaE"><img class="img_e" src="'+data[i].item_data.item[j].image+'"  /></div>';
		           					}
	           					}else{

	           					};
	           					

	           					muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'" ><p class="kuangjia_t">导航</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(3,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p>';
	           					muban=muban+kk+'<div style="clear: both;"></div></div>';
	           				}else if(data[i].item_type=="goods"){
	           					var kk="";
	           					if(data[i].item_data){
	           						for(var j=0;j<data[i].item_data.item.length;j++){
		           						kk=kk+'<div class="kuangjiaF"><div class="kuangjiaF_img"><img class="img_f" src="'+data[i].item_data.item[j].goodsImg+'" /></div>';
		           						kk=kk+'<div class="kuangjiaF_ming">'+data[i].item_data.item[j].goodsName+'</div><div class="kuangjiaF_jiag">￥：'+data[i].item_data.item[j].shopPrice+'</div></div>';
		           					}
	           					}else{

	           					}
		           					
	           					muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'" ><p class="kuangjia_t">商品</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(4,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p>';
	           					muban=muban+kk+'<div style="clear: both;"></div></div>'
	           				}else if(data[i].item_type=="home5"){
	           					var kk="";
	           					if(data[i].item_data){
	           						for(var j=0;j<data[i].item_data.item.length;j++){
		           						kk=kk+'<div class="kuangjiaF"><div class="kuangjiaF_img"><img class="img_f" src="'+data[i].item_data.item[j].shopImg+'" /></div>';
		           						kk=kk+'<div class="kuangjiaF_ming">'+data[i].item_data.item[j].shopName+'</div></div>';
		           					}
	           					}else{

	           					}
		           					
	           					muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'" ><p class="kuangjia_t">店铺</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(6,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p>';
	           					muban=muban+kk+'<div style="clear: both;"></div></div>'
	           				}else if (data[i].item_type=="home3") {
	           					var kk="";
	           					if(data[i].item_data.item){
	           						kk=kk+'<img class="img_a" src="'+data[i].item_data.item[0].image+'" />';
	           					}else{
	           						kk=kk+'<img class="img_a" src="xxx" />'
	           					}
								muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'"><p class="kuangjia_t">活动</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(1,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p><div class="kuangjiaA">'+kk+'</div></div>';
	           				}else if(data[i].item_type=="home4"){
	           					var kk="";
	           					if (data[i].item_data) {
									for(var j=0;j<data[i].item_data.item.length;j++){
		           						kk=kk+'<div class="kuangjiaE"><img class="img_e" src="'+data[i].item_data.item[j].image+'"  /></div>';
		           					}
	           					}else{

	           					};
	           					

	           					muban=muban+'<div class="kuangjia" id="'+data[i].item_id+'" ><p class="kuangjia_t">抢购</p><p class="kuangjia_b"><a class="k_shangyi">上移</a><a class="k_xiayi">下移</a><a class="k_bianji" href="javascript:toEditx(3,'+data[i].item_id+')">编辑</a><a class="k_shanchu" name="'+data[i].item_id+'" >删除</a></p>';
	           					muban=muban+kk+'<div style="clear: both;"></div></div>';
	           				};
	           			};
	           			$("#yangshi").html(muban);
	           			xx();
							}
	           		});
				
	})

	function tianjian(leibie){
		if(leibie==1 && $(".lbt").length>0){
			alert("轮播图只能有一个")
		}else{
			var ids=$("#cashId").val();
			$.post(WST.U('admin/mobile/item_add'),{id:ids,lb:leibie},function(data,textStatus){
				if(data==1){
					location.href=WST.U('admin/mobile/item_index','id='+ids);
				}
				
			})
		}
			
	}

	$(window).resize(function (){
		$("#maingrid_A").height($("body").height());
	})
	
	function xx(){
		$("#maingrid_A").height($("body").height());
		//添加模块
		
		//上移
		$("#yangshi").on('click','.k_shangyi',function(){
			var hj= $(".k_shangyi").index($(this));
			var le=$(".k_shangyi").length;
			var xulie="";
			if(hj>0&&le>1){
				$(".kuangjia").eq(hj).insertBefore($(".kuangjia").eq(hj-1));
				$(".kuangjia").each(function(){
					xulie=xulie+','+$(this).attr("id");
					
				})

				var ids=$("#cashId").val();
				$.post(WST.U('admin/mobile/item_sort'),{id:ids,xl:xulie},function(data,textStatus){
					location.href=WST.U('admin/mobile/item_index','id='+ids);
				})
			}
		})
		//下移
		$("#yangshi").on('click','.k_xiayi',function(){
			var hj= $(".k_xiayi").index($(this));
			var le=$(".k_shangyi").length;
			var xulie="";
			if(hj<(le-1)&&le>1){
				$(".kuangjia").eq(hj).insertAfter($(".kuangjia").eq(hj+1));
//				history.go(0);
				$(".kuangjia").each(function(){
					xulie=xulie+','+$(this).attr("id");
				})
				var ids=$("#cashId").val();
				$.post(WST.U('admin/mobile/item_sort'),{id:ids,xl:xulie},function(data,textStatus){
					location.href=WST.U('admin/mobile/item_index','id='+ids);
				})
			}

		})
		//删除
		$("#yangshi").on('click','.k_shanchu',function(){
			var id=$(this).attr("name");
			var ids=$("#cashId").val();

			$.post(WST.U('admin/mobile/item_del'),{id:id},function(data,textStatus){
				if(data!=1){
					alert("删除失败")
				}
				location.href=WST.U('admin/mobile/item_index','id='+ids);
			})
			

		})
		
		//图片大小限制
		var kk;
		$(".img_a").each(function(){
			kk=(($(this).width()/$(this).height()));
			if(kk>(640/240)){
				$(this).width(310);
			}else{
				$(this).height(115);
			}
		})
		$(".img_b").each(function(){
			kk=($(this).width()/$(this).height());
			if(kk>(152/120)){
				$(this).width(152);
			}else{
				$(this).height(120);
			}
		})
		$(".img_c").each(function(){
			kk=($(this).width()/$(this).height());
			if(kk>(152/57)){
				$(this).width(152);
			}else{
				$(this).height(57);
			}
		})
		$(".img_d").each(function(){
			kk=($(this).width()/$(this).height());
			if(kk>(152/57)){
				$(this).width(152);
			}else{
				$(this).height(57);
			}
		})
		$(".img_e").each(function(){
			kk=($(this).width()/$(this).height());
			if(kk>(74/74)){
				$(this).width(74);
			}else{
				$(this).height(74);
			}
		})
		$(".img_f").each(function(){
			kk=($(this).width()/$(this).height());
			if(kk>(151/151)){
				$(this).width(151);
			}else{
				$(this).height(151);
			}
		})
		
	}
</script>


<script src="__ADMIN__/mobile/cashdraws.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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