<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\brands\edit.html";i:1490061544;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__STATIC__/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />
<style>
.goodsCat{display:inline-block;width:150px}
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

<input type='hidden' id='brandId' value='<?php echo $object["brandId"]; ?>'/>
<div class="l-loading" style="display: block" id="wst-loading"></div>
<form id="brandForm" autocomplete="off">
<table class='wst-form wst-box-top'>
  <tr>
     <th width='150'>品牌名称<font color='red'>*</font>：</th>
     <td><input type="text" id='brandName' name='brandName' maxLength='20' style='width:300px;' class='ipt'/></td>
  </tr>
   <tr>
     <th width='150' align='right'>所属分类<font color='red'>*</font>：</th>
     <td>
     <?php if(is_array($gcatList) || $gcatList instanceof \think\Collection): $i = 0; $__LIST__ = $gcatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	     <label class='goodsCat'>
	     <input type='checkbox' id='catId' name='catId' class="ipt" value='<?php echo $vo["catId"]; ?>'
       <?php if($object['brandId'] !=0): if(in_array($vo["catId"],$object['catIds'])==1): ?>checked<?php endif; endif; ?>
       >&nbsp;<?php echo $vo["catName"]; ?>&nbsp;
	     </label>
	 <?php endforeach; endif; else: echo "" ;endif; ?>
     </td>
   </tr>
   <tr width='150'>
     <th align='right'>品牌图标<font color='red'>*</font>：</th>
     <td>
     	<div>
    	<div id="filePicker" style='margin-left:0px;float:left; width: 100px'>上传图片</div>
     	    <div style='margin-left:5px;float:left'>图片大小:400 x 200 (px)，格式为 gif, jpg, jpeg,bmp, png</div>
     	    <input id="brandImg" name="brandImg" class="text ipt" autocomplete="off" type="hidden" value="<?php echo $object['brandImg']; ?>"/>
     	    <div style="clear:both;"></div>
     	</div>
     </td>
   </tr>
   <tr >
     <th align='right' height='152'>预览图：</th>
     <td >
     	<div id="preview" >
     	<?php if($object['brandId']!=0): ?>
       	<img src="__ROOT__/<?php echo $object['brandImg']; ?>" class="ipt" height='152'/>
       	<?php endif; ?>
       	</div>
     </td>
   </tr>
   <tr>
       <th width='150'>品牌介绍<font color='red'>*</font>：</th>
       <td>
       	<textarea id='brandDesc' name='brandDesc' class="form-control ipt" style='width:80%;height:400px'></textarea>
       </td>
    </tr>
     <tr>
       <td colspan='2' align='center'>
           <button type="submit" class="btn btn-blue">保&nbsp;存</button>
           <button type="button" class="btn" onclick="javascript:history.go(-1)">返&nbsp;回</button>
       </td>
     </tr>
</table>
 </form>
 <script>
$(function(){
  //文件上传
	WST.upload({
  	  pick:'#filePicker',
  	  formData: {dir:'brands',mWidth:500,mHeight:250},
  	  accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
  	  callback:function(f){
  		  var json = WST.toAdminJson(f);
  		  if(json.status==1){
        	$('#preview').html('<img src="'+WST.conf.ROOT+"/"+json.savePath+json.thumb+'" height="200" />');
        	$('#brandImg').val(json.savePath+json.thumb);
  		  }
	  }
    });
  //编辑器
    KindEditor.ready(function(K) {
		editor1 = K.create('textarea[name="brandDesc"]', {
			height:'350px',
			uploadJson : WST.conf.ROOT+'/admin/brands/editorUpload',
			allowFileManager : false,
			allowImageUpload : true,
			items:[
			        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
			        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
			        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
			        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
			        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
			        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
			        'anchor', 'link', 'unlink', '|', 'about'
			],
			afterBlur: function(){ this.sync(); }
		});
	});
});
</script>


<script src="__STATIC__/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>" type="text/javascript" ></script>
<script src="__STATIC__/plugins//kindeditor/kindeditor.js?v=<?php echo $v; ?>" type="text/javascript" ></script>
<script src="__ADMIN__/brands/brands.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
$(function () {
	   <?php if($object['brandId'] !=0): ?>
		WST.setValues(<?php echo $object; ?>);
	   <?php endif; ?>
		$('#brandForm').validator({
		    fields: {
		    	brandName: {
		    		tip: "请输入品牌名称",
		    		rule: '品牌名称:required;length[~16];'
		    	},
		    	catId: {
		    		tip: "请选择分类",
		    		rule: 'checked(1~);length[~16];'
		    	},
		    	brandDesc: {
		    		tip: "请输入品牌介绍",
		    		rule: '品牌介绍:required;'
		    	}
		    },
		    valid: function(form){
		    	var brandId = $('#brandId').val();
		    	toEdits(brandId);
		    }
		})
});
</script>

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