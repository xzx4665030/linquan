<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\configure\list_log.html";i:1492751508;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
input[type="text"]{padding: 0px;height: 28px;}
	td{line-height: 28px}
	input[type="checkbox"]{vertical-align: top;}
	.quanxuan label{display:block;width: 100%;height: 100%;background: #88b547;color: #fff;cursor: pointer;}
	.bianji,.kucun,.shanchux{color: #069add;margin:0px 10px;cursor:pointer;}
	.biaoge_p{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 385px;display: block;}
	.biaoge_p1{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 660px;display: block;}
	.biaoge_p .biaoti{display: inline-block;width: 75px;text-align: right;vertical-align: top;}
	.biaoge_p .changdu1{width: 120px;}
	.biaoge_p .changdu2{width: 200px;}
	.biaoge_p1 .changdu2{width: 200px;margin-right: 30px;}
	.biaoge_p .changdu3{width: 290px;}
	.biaoge_p .changdu4{width:370px;display: inline-block;}
	.layui-layer-btn {padding-right: 26px;}
	.l-text-wrapper{display: inline-block;}
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

   <div class="wst-toolbar" style="height: 30px;font-size: 20px;line-height: 20px;">
   	<button class="tianjia" onclick="javascript:toEditC1(0,0)">添加</button>
   	<button class="shanchu" onclick="javascript:toBatchDelC1(0,0)" >删除</button>
  <span style="color: #333;vertical-align: middle;">当前供应商：<?php echo $supplier['company']; ?></span>
  <button class="btn btn-gray f-right" style='margin-top: 3px'onclick="javascript:history.go(-1)">返回</button> 
  <div style='clear: both'></div>
  </div>
   <div id='moneyGrid'></div>
 <div id='expressBoxC1' style='display:none'>
    <form id='expressFormC1' autocomplete="off" enctype="multipart/form-data" method="post" >
    <input type="hidden" />
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">商品名称<font color='red'>*</font>：</span>
    	<input type='text' id='goodsName' name="goodsName"  class='ipts changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">商品编号<font color='red'>*</font>：</span>
    	<input type='text' id='goodsSn' name="goodsSn"  class='ipts changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">商品货号<font color='red'>*</font>：</span>
    	<input type='text' id='productNo' name="productNo"  class='ipts changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">商品图片<font color='red'>*</font>：</span>
    	<input type='text' style="display:none;" id='goodsImg' name="goodsImg"  class='ipts changdu2' maxLength='20'/>
      <div >
          <img style="width:50px;height:50px;display:none;" id="dsb"  src="">
      </div>
      <div>
            <input type="file" name="image"  id="inputfile"/>
      </div>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">进价<font color='red'>*</font>：</span>
    	<input type='text' id='marketPrice' name="marketPrice"  class='ipts changdu3' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
      <span class="biaoti">市场价<font color='red'>*</font>：</span>
      <input type='text' id='shopPrice' name="shopPrice"  class='ipts changdu3' maxLength='20'/>
    </p>
    <!--<p class="biaoge_p biaoge_p1">
      <span class="biaoti">预警库存<font color='red'>*</font>：</span>
      <input type='text' id='warnStock' name="warnStock"  class='ipts changdu3' maxLength='20'/>
    </p>-->
    <p class="biaoge_p biaoge_p1">
      <span class="biaoti">商品总库存<font color='red'>*</font>：</span>
      <input type='text' id='goodsStock' name="goodsStock"  class='ipts changdu3' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
      <span class="biaoti">单位<font color='red'>*</font>：</span>
      <input type='text' id='goodsUnit' name="goodsUnit"  class='ipts changdu3' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
      <span class="biaoti">商品分类<font color='red'>*</font>：</span>
      <select id="cat_0" class='ipts j-goodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat_0',val:this.value,isRequire:true,className:'j-goodsCats ipts',afterFunc:'lastGoodsCatCallback'});getBrands('brandId',this.value)">
        <option value="0" >请选择</option>
        <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
    </p>
    <p class="biaoge_p biaoge_p1">
      <span class="biaoti">商品描述<font color='red'>*</font>：</span>
      <input type='text' id='goodsDesc' name="goodsDesc"  class='ipts changdu3' maxLength='20'/>
    </p>
	
    <input type='text' style="display:none;" value="<?php echo $supplier['id']; ?>"  id='supplierid' name="supplierid"  class='ipts changdu2' maxLength='20'/>
    </form>
 </div>
<script>
  $(function(){
  	$(function(){moneyGridInitC(<?php echo $supplier['id']; ?>);})
  	})
</script>
<script type="text/javascript">
  $(document).ready(function(){
  //获取商品规格
  function aa(){
	$("#expressFormC1 .j-goodsCats").bind("blur",function(){
		$("#expressFormC1 .j-goodsCats").unbind("blur");
		var class_id=$("#expressFormC1 .j-goodsCats").eq(2).val();
		if(class_id>0){
			data = {'class_id':class_id};
			$.ajax({
				url:WST.U('admin/supplier/get'),
				type:'post',
				data:data,
				dataType:'json',
				success:function(json){
					
				}
			})
		}
		aa();
	})
  }	
	aa();
    $("#inputfile").change(function(){
        var data = new FormData();
        $.each($('#inputfile')[0].files, function(i, file) {
            data.append('upload_file', file);
        });
        $.ajax({
            type: "post",
             url: WST.U('admin/supplier/add_img'),
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
                  $("#dsb").attr("src",img_url); 
                  $("#goodsImg").val(data.msg);
                  $("#dsb").show();
                  
                }
            }
        });
      });
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