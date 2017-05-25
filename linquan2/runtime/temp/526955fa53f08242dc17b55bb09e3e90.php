<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\mobile\item_4.html";i:1494580850;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
		min-height: 100%;
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
	.waike{border-top:1px solid #016AaE;border-bottom:1px solid #016AaE;background: #EFFAFE;margin: 0px 20px 20px 10px;min-width: 950px;}
	.tiaoxuan{background: #f0f0f0;width: 600px;padding-bottom: 20px;}
	.ggk{width: 220px;border: 1px #222 dotted;position: relative;margin-top: 15px;display: inline-block;padding: 5px;}
	.ggk:hover{border: 1px solid #19AEDE;}
	.shanchua{position: absolute;right: 5px;top: 5px;cursor:pointer;font-size:15px;display: none;background: #19AEDE;color: #fff;padding: 3px 5px;}
	.ggk:hover .shanchua{display: block;}
	.img_x{width: 222px;height: 222px;}
	.img_x img{max-width: 222px;max-height: 222px;}
	.sp_id,.id_b{display: none;}
	.mingzi{height: 28px;line-height: 14px;font-size: 12px;overflow: hidden;}
	.jiage {height: 16px;line-height: 16px;font-size: 16px;color: #f30;}
	.shuaixuan{padding-left: 20px;}
	.xuanze{width: 300px;margin-bottom: 10px;border: 1px solid #eed;}
	.img_b{width: 60px;height: 60px;float: left;margin-right: 5px;}
	.img_b img{max-height: 60px;max-width: 60px;}
	.mingzi_b{height: 28px;line-height: 14px;font-size: 12px;overflow: hidden;float: left;width: 230px;}
	.jiage_b{height: 20px;line-height: 20px;font-size: 16px;color: #f30;overflow: hidden;float: left;width: 230px;}
	.tianjia_b{height: 16px;line-height: 16px;font-size: 16px;color: #fff;padding: 2px 5px;background: #ccc;float: right;margin-right: 20px;margin-top: -20px;}
	table{width: 100%;border: none;}
	td{vertical-align: top;}
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
<div class="waike">
	<table border="" cellspacing="" cellpadding="">
		<tr>
			<td  class="tiaoxuan">
				<p style="height: 20px;line-height: 20px;font-size: 16px;margin-bottom: 15px;">广告条板块</p>
				<p style="color: #333;">标题:</p>
				<input  class="dabt" type="text" id="" value="" />
				<p style="color: #333;">更多:</p>
				<input class="dagd" type="text" id="" value="" />
				<p style="color: #333;">内容:</p>
				<div style="margin: 12px 0px;width: 600px;" id="tupian">
				</div>
			</td>
			<td class="shuaixuan">
				<div style="margin-bottom: 10px;">
					<input type="text" name="content" id="content" >
					<button id="serch" >搜索</button>
				</div>
				<div id="xuanze">
				</div>
			</td>
		</tr>
	</table>
	<!--<div class="tiaoxuan">
		<p style="height: 20px;line-height: 20px;font-size: 16px;margin-bottom: 15px;">广告条板块</p>
		<p style="color: #333;">标题:</p>
		<input  class="dabt" type="text" id="" value="" />
		<p style="color: #333;">更多:</p>
		<input class="dagd" type="text" id="" value="" />
		<p style="color: #333;">内容:</p>
		<div style="margin: 12px 0px;width: 600px;" id="tupian">
		</div>
	</div>
	<div class="shuaixuan">
		<div style="margin-bottom: 10px;">
			<input type="text" name="content" id="content" >
			<button id="serch" >搜索</button>
		</div>
		<div id="xuanze">
		</div>
	</div>-->
	<div style="clear: both;"></div>
</div>
<div>
	<a class="tijiao" style="display: inline-block;margin: 10px 20px;border: 1px solid #333;border-radius: 3px;padding: 5px 15px;font-size: 14px;">保存编辑</a>
	<!--<a href="javascript:history.go(-1)">返回上一级</a>-->
</div>
<script type="text/javascript">
$(function(){
	var ids=$("#cashId").val();
	$.ajax({
         type: "post",
          url: WST.U('admin/mobile/get_item'),
          data: {id:ids},
          dataType: "json",
          success: function(data){
       	console.log(data);
		       	if (data.item_data.biaoti) {
		       		$(".dabt").val(data.item_data.biaoti);
		       	}
		       	if(data.item_data.gengduo){
		       		$(".dagd").val(data.item_data.gengduo);
		       	}
             	if(data.item_data.item){
	          		
	           	var jj="";
	           	for(var h=0;h<data.item_data.item.length;h++){
		               var jj=jj+'<div class="ggk"><span class="sp_id">'+data.item_data.item[h].goodsId+'</span><span class="shanchua">删除</span><div class="img_x"><img src="'+data.item_data.item[h].goodsImg+'"/></div>';
    									jj=jj+'<div class="mingzi">'+data.item_data.item[h].goodsName+'</div><div class="jiage ">￥：'+data.item_data.item[h].shopPrice+'</div></div>';
	          		
	           	}
	
		      		 $("#tupian").html(jj);
		      		 xx();
          	}
         }
     });
})
$(document).ready(function() {
	
  $('#serch').click(function(){
    var content=$('#content').val();
		$.ajax({
            type: "post",
             url: WST.U('admin/mobile/get_good'),
             data: {content:content},
             dataType: "json",
             success: function(data){
               if(data!=""){
               	var jj=""
               	for(var m=0;m<data.length;m++){
               		jj=jj+'<div class="xuanze"><span class="id_b">'+data[m].goodsId+'</span><div class="img_b"><img src="'+data[m].goodsImg+'" /></div>';
               		jj=jj+'<div class="mingzi_b">'+data[m].goodsName+'</div><div class="jiage_b">￥：'+data[m].shopPrice+'</div><a class="tianjia_b">添加</a><div style="clear: both;"></div></div>'
               	}
               	$("#xuanze").html(jj);
               }
            }
        });
    });
    $("#xuanze").on("click",".tianjia_b",function(){
    	var hh='<div class="ggk"><span class="sp_id">'+$(this).siblings(".id_b").html()+'</span><span class="shanchua">删除</span><div class="img_x"><img src="'+$(this).siblings(".img_b").find("img").attr("src")+'"/></div>';
    	hh=hh+'<div class="mingzi">'+$(this).siblings(".mingzi_b").html()+'</div><div class="jiage ">'+$(this).siblings(".jiage_b").html()+'</div></div>';
    	$("#tupian").append(hh);
    })
    $("#tupian").on("click",".shanchua",function(){
    	$(this).parents('.ggk').remove();
    })
    $('.tijiao').click(function(){
    	var ids=$("#cashId").val();
      		var dabt=$(".dabt").val();
      		var dagd=$(".dagd").val();
      		var ss='{"biaoti":"'+dabt+'","gengduo":"'+dagd+'"'
      		if($('.ggk').length>0){
      			ss=ss+',"item":[{"image":"'+$('.ggk').eq(0).find("img").attr('src')+'","goodsId":"'+$('.ggk').eq(0).find(".sp_id").html()+'"}';
      			for(var i=1;i<$('.ggk').length;i++){
      				ss=ss+',{"image":"'+$('.ggk').eq(i).find("img").attr('src')+'","goodsId":"'+$('.ggk').eq(i).find(".sp_id").html()+'"}';
      			}
      			ss=ss+"]";
      			
      			
      		}else{
      			ss=ss+',"item":""';
      		}
      		ss=ss+"}"
      		var obj = eval ("(" + ss + ")");
      		console.log(ss);
      		console.log(obj);
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