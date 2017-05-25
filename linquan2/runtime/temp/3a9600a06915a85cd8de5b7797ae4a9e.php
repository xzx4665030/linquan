<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\accreds\classes.html";i:1494492602;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
	.kongge{display:inline-block;width:20px;}
</style>
<div class="l-loading" style="display: block" id="wst-loading"></div>

<div class="wst-toolbar">
   <a class="btn btn-green f-right"  onclick="javascript:toEditA(0)">新增</a>
   <div style='clear:both'></div>
</div>

<!--<table>
 	<tr>
		<td>序号</td> 
		<td>行业分类名称</td>
		<td>操作</td>
	</tr>
	<?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
		<span>暂时还没有行业分类</span>
	<?php else: if(is_array($list) || $list instanceof \think\Collection): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($k % 2 );++$k;?>
			<tr>
				<td><?php echo $k; ?></td>
				<td><?php echo $li['class_name']; ?></td>
				<td>
					<a href="javascript:toEdits(<?php echo $li['class_id']; ?>);">修改</a>
					<a href="javascript:toDels(<?php echo $li['class_id']; ?>)">删除</a>
				</td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; endif; ?>

</table> -->

<div id="maingrid"></div>
<div id='expressBoxA' style='display:none'>
	<form id='expressFormA' autocomplete="off" >
		<table class='wst-form wst-box-top' style="width: 92%;margin: auto;">
	     <tr>
	        <th width='100'>行业分类名称<font color='red'>*</font>：</th>
	        <td><input type='text' id='class_name' name="class_name" class='ipt' maxLength='20' style='width:200px;'/></td>
	     </tr>
	
	     
	     <tr>
	        <th width='100'>是否显示<font color='red'>*</font>：</th>
	        <td><input  class="ipt" type="radio" name="show" value='1' checked="checked">显示<input  class="ipt" type="radio" name="show" value="0">隐藏</td>
	     </tr>
	     <tr>
	        <th style="vertical-align: top;">经营范围<font color='red'>*</font>：</th>
	        <td>
	            <?php if(is_array($cats) || $cats instanceof \think\Collection): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><span style="display: inline-block;width: 180px"><input class="asd ipt" type="checkbox" name="cats_id" value="<?php echo $val['catId']; ?>"><?php echo $val['catName']; ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
	        </td> 	
	     </tr> 
	  </table>
	</form>
</div>
<script>

//	$(function(){
//		$(".btn").click(function(){
//			$("#goodscatsBox").show();
//		})
//		
//		$("#tj").click(function(){
//			var name = $("#catName").val();
//			var show = $("#show").val();
//			var k="";
//			$('.asd').each(function(){
//				if($(this).is(':checked')){
//
//					k=k+$(this).val()+",";
//				}
//
//			})
//			
//			
//			data = {'data':name,'show':show,'cats_id':k};
//			$.ajax({
//				type:'post',
//				url:WST.U('admin/accreds/add_classes'),
//				data:data,
//				dataType:'json',
//				success:function(e){
//					if(e.flag == 1){
//						WST.msg('添加成功');
//						window.location.reload();
//					}else{
//						WST.msg('添加失败');
//						window.location.reload();
//					}
//				}
//				
//			})
//		})
//	})
</script>


<!--<script type="text/javascript">
	function toEdits(id){
	   location.href=WST.U('admin/Accreds/toEdits','id='+id);
    }

    function toDels(id){
       var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
       	   var params = {id:id};
		   $.post(WST.U('admin/Accreds/toDels'),params,function(data,textStatus){
		   	layer.close(box);
		      if(data == 1){
					WST.msg("删除成功",{icon:1}); 
					window.location.reload();   	    
				}else{
					WST.msg('删除失败');
					window.location.reload();
			   }
	    	});
	   }});
    }
</script>-->
<script>
  $(function(){initGrid()});
</script>


<script src="__ADMIN__/js/wstgridtree.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script src="__ADMIN__/accreds/accreds_lf.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<!--<script src="__ADMIN__/js/jquery-1.7.2.min.js" type="text/javascript"></script>-->


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