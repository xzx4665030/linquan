<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\mobile\item_5.html";i:1494313328;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
	body{
		height: initial;
		background: #f0f0f0;
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
	.ggk{width: 480px;height: 180px;border: 1px #222 dotted;position: relative;margin-top: 30px;margin-left: 15px;}
	.ggk:hover{border: 1px solid #19AEDE;}
	.shanchu{cursor:pointer;display: block;width: 60px;height: 20px;line-height: 20px;display: none;text-indent: 25px;position:absolute;right: 10px;top: 6px;background: #19AEDE;color: #fff ;font-size: 14px}
	.ggk:hover .shanchu{display: block;}
	.shangchuan{width: 500px;border: 4px solid rgba(128,128,128,0.3);position: fixed;top: 50px;left: 50%;margin-left: -250px;background: #fff;display: none;border-radius: 7px;overflow: hidden;}
	.guanbi{float: right;margin-right: 20px;}
	.tp_sc{display: block;margin: auto;}
	.ggk img{display: block;margin: auto;}
	.hun{margin: 10px 0px 0px 20px;}
	#neir p{padding: 5px 0px;}
</style>
<input type='hidden' id='cashId' class='ipt' value="<?php echo $id; ?>"/>
<div style="background: #fff;" class="toubu">
	<div style="color: #5867d1;font-size: 16px;padding: 8px 0px;text-indent: 20px;border-bottom: 1px solid #dfdfdf;">操作提示：
		<input style="float: right;margin-right: 20px;" type='button' value='返回' class='btn' onclick='javascript:history.go(-1)'>
	</div>
	<div>
		<ul class="lis">
			<li>点击添加新的广告条按钮可以添加新的广告条</li>
			<li>鼠标移动到已有的广告条上点击出现的删除按钮可以删除对应的广告条</li>
			<li>操作完成后点击保存编辑按钮进行保存</li>
		</ul>
	</div>
</div>
<div style="margin: 10px 20px;padding-bottom: 30px;border-bottom: 1px solid #666;">
	<p style="height: 20px;line-height: 20px;font-size: 16px;margin-bottom: 15px;">广告条板块</p>
	<p style="color: #333;">标题:</p>
	<input  class="dabt" type="text" id="" value="" />
	<p style="color: #333;">更多:</p>
	<input class="dagd" type="text" id="" value="" />
	<p style="color: #333;">内容:</p>
	<div style="margin: 12px 0px;" id="tupian">
		
	</div>
	<a style="display: inline-block;text-indent: 20px;color: rgb(13, 147, 191);" class="tianjia_x">添加新的广告条</a>
</div>
<div>
	<a class="tijiao" style="display: inline-block;margin: 10px 20px;border: 1px solid #333;border-radius: 3px;padding: 5px 15px;font-size: 14px;">保存编辑</a>
	<!--<a href="javascript:history.go(-1)">返回上一级</a>-->
</div>
<div class="shangchuan">
	<div style="border-bottom:1px solid #666;height: 30px;line-height: 30px;text-indent: 20px;">添加 
		<a class="guanbi">X</a></div>
	<div id="shangchuan">
		<form id="neir" style="margin: 10px 20px;">
			
		</form>
		<p style="margin:10px ;border-top:1px solid #666">
				<a class="baocun">保存</a>
		</p>
	</div>
</div>
<script type="text/javascript">
	function xx(){
		
	$(".ggk img").each(function(){
			if(($(this).width()/$(this).height()) > (280/182)){
				$(this).width(280);
			}else{
				$(this).height(180);
			}
			
		})
	}
	$(function(){
		var ids=$("#cashId").val();
		$.ajax({
            type: "post",
             url: WST.U('admin/mobile/get_item'),
             data: {id:ids},
             dataType: "json",
             success: function(data){
             	var jj="";
             	if(data.item_data.item){
             		
	             	for(var h=0;h<data.item_data.item.length;h++){
		               jj=jj+'<div class="ggk"><input class="ming" name="" value="'+data.item_data.item[h].tname+'" type="hidden"><input class="leix" name="" value="'+data.item_data.item[h].type+'" type="hidden">';
			      		jj=jj+'<input class="leix_x" name="" value="'+data.item_data.item[h].data+'" type="hidden"><span class="shanchu">删除</span><img src="'+data.item_data.item[h].image+'"></div>'
	             		
	             	}
             	}
	      		$("#tupian").append(jj);
	      		xx();
            }
        });
	})
	$(function(){
		$(".tianjia_x").click(function(){
			var k='<p>选择要上传的图片：</p><div><img class="tp_sc" src=""></div><input id="inputfile" type="file"  /><p>填写标题：</p><input type="text" id="biaoti_x"><p>操作类型：</p><select id="leix_x" ><option value="">请选择</option><option value="special">专题编号</option><option value="goods">商品编号</option><option value="url">链接</option></select><input type="text" id="guanjianz_x">';
			$("#neir").html(k);
			
			$(".shangchuan").show();
			
		})
		$(".guanbi").click(function(){
			$(".shangchuan").hide();
			$("#neir").html("");
		})
	})
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#neir").on('change','#inputfile',function(){
    	alert(1);
        var data = new FormData();
        $.each($('#inputfile')[0].files, function(i, file) {
            data.append('upload_file', file);
        });
        $.ajax({
            type: "post",
             url: WST.U('admin/mobile/add_img'),
             data: data,
             dataType: "json",
             cache: false,
             contentType: false,    //不可缺
             processData: false,    //不可缺
             success: function(data){
                if(data.res==1){
                   alert(data.msg);
                }else{
                	
                  $('#img').val(data.msg);
                  var img_url = WST.conf.ROOT+'/'+data.msg;
                  $(".tp_sc").attr("src",img_url); 
                  $(".tp_sc").each(function(){
						if(($(this).width()/$(this).height()) > (480/180)){
						$(this).width(450);
					}else{
						$(this).height(170);
					}
					})
                  
                }
            }
        });
      });
      $(".baocun").click(function(){
//    	var imgs=$("#shangchuan .tp_sc").attr("src");
      	if($("#shangchuan .tp_sc").attr("src")==""){
      		alert("请选择图片")
      	}else if($("#shangchuan #biaoti_x").val()==""){
      		alert("请填写标题")
      	}else if($("#shangchuan #leix_x").val()==""){
      		alert("请选择操作类型")
      	}else if($("#shangchuan #guanjianz_x").val()==""){
      		alert("请输出关键字")
      	}else{
      		var jj='<div class="ggk"><input class="ming" name="" value="'+$("#shangchuan #biaoti_x").val()+'" type="hidden"><input class="leix" name="" value="'+$("#shangchuan #leix_x").val()+'" type="hidden">';
      		jj=jj+'<input class="leix_x" name="" value="'+$("#shangchuan #guanjianz_x").val()+'" type="hidden"><span class="shanchu">删除</span><img src="'+$("#shangchuan .tp_sc").attr("src")+'"></div>'
      		$("#tupian").append(jj);
      		$(".shangchuan").hide();
			$("#neir").html("");
			xx();
      	}
      })
      $("#tupian").on("click",'.shanchu',function(){
      		$(this).parents('.ggk').remove();
      })
      $(".tijiao").click(function(){
      		var ids=$("#cashId").val();
      		var dabt=$(".dabt").val();
      		var dagd=$(".dagd").val();
      		var ss='{"biaoti":"'+dabt+'","gengduo":"'+dagd+'"'
      		if($('.ggk').length>0){
      			ss=ss+',"item":[{"image":"'+$('.ggk').eq(0).find("img").attr('src')+'","type":"'+$('.ggk').eq(0).find(".leix").val()+'","data":"'+$('.ggk').eq(0).find(".leix_x").val()+'","tname":"'+$('.ggk').eq(0).find(".ming").val()+'"}';
      			for(var i=1;i<$('.ggk').length;i++){
      				ss=ss+',{"image":"'+$('.ggk').eq(i).find("img").attr('src')+'","type":"'+$('.ggk').eq(i).find(".leix").val()+'","data":"'+$('.ggk').eq(i).find(".leix_x").val()+'","tname":"'+$('.ggk').eq(i).find(".ming").val()+'"}'
      			}
      			ss=ss+"]";
      		}else{
      			ss=ss+',"item":""';
      		}
      		ss=ss+"}"
      		var obj = eval ("(" + ss + ")");
      		$.ajax({
            type: "post",
             url: WST.U('admin/mobile/edit_item'),
             data: {id:ids,data:obj},
             dataType: "json",
             success: function(data){
                if(data==1){
                	alert("编辑成功");
                  history.go(-1);
                }else{
                  alert("编辑失败");
                }
            }
        });
      })
  });
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