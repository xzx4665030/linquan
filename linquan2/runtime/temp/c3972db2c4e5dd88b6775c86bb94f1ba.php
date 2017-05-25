<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\addons\config.html";i:1489487246;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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


	<form action="<?php echo url('saveConfig'); ?>" method="post" style="line-height: 30px;margin:10px;" autocomplete="off">
			<div class="main-title cf">
				<h2>插件配置 [ <?php echo $data['title']; ?> ]</h2>
			</div>
			<?php if(is_array($data['config']) || $data['config'] instanceof \think\Collection): if( count($data['config'])==0 ) : echo "" ;else: foreach($data['config'] as $o_key=>$form): ?>
				<div class="form-item cf">
				<?php if(isset($form['title'])): ?>
					<label class="item-label">
						<span style="font-weight: bold;"><?php echo (isset($form['title']) && ($form['title'] !== '')?$form['title']:''); ?></span>
						
					</label>
					<?php endif; switch($form['type']): case "tips": ?>
							<div>
								<?php echo $form['value']; ?>
							</div>
							<?php break; case "text": ?>
							<div>
								<input type="text" name="config[<?php echo $o_key; ?>]" class="text input-large" value="<?php echo $form['value']; ?>"  style="width:400px;"><?php if(isset($form['tips'])){ ?><span><?php echo $form['tips']; ?></span><?php } ?>
							</div>
							<?php break; case "password": ?>
							<div>
								<input type="password" name="config[<?php echo $o_key; ?>]" class="text input-large" value="<?php echo $form['value']; ?>">
							</div>
							<?php break; case "hidden": ?>
								<input type="hidden" name="config[<?php echo $o_key; ?>]" value="<?php echo $form['value']; ?>">
							<?php break; case "radio": ?>
							<div>
								<?php if(is_array($form['options']) || $form['options'] instanceof \think\Collection): if( count($form['options'])==0 ) : echo "" ;else: foreach($form['options'] as $opt_k=>$opt): ?>
									<label class="radio">
										<input type="radio" name="config[<?php echo $o_key; ?>]" value="<?php echo $opt_k; ?>" <?php if($form['value'] == $opt_k): ?> checked<?php endif; ?>><?php echo $opt; ?>
									</label>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</div>
							<?php break; case "checkbox": ?>
							<div>
								<?php if(is_array($form['options']) || $form['options'] instanceof \think\Collection): if( count($form['options'])==0 ) : echo "" ;else: foreach($form['options'] as $opt_k=>$opt): ?>
									<label class="checkbox">
										<?php 
											is_null($form["value"]) && $form["value"] = array();
										 ?>
										<input type="checkbox" name="config[<?php echo $o_key; ?>][]" value="<?php echo $opt_k; ?>" <?php if(in_array(($opt_k), is_array($form['value'])?$form['value']:explode(',',$form['value']))): ?>checked<?php endif; ?>><?php echo $opt; ?>
									</label>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</div>
							<?php break; case "select": ?>
							<div>
								<select name="config[<?php echo $o_key; ?>]">
									<?php if(is_array($form['options']) || $form['options'] instanceof \think\Collection): if( count($form['options'])==0 ) : echo "" ;else: foreach($form['options'] as $opt_k=>$opt): ?>
										<option value="<?php echo $opt_k; ?>" <?php if($form['value'] == $opt_k): ?> selected<?php endif; ?>><?php echo $opt; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</div>
							<?php break; case "textarea": ?>
							<div>
								<label class="textarea input-large">
									<textarea name="config[<?php echo $o_key; ?>]" style="width:500px;height:200px;"><?php echo $form['value']; ?></textarea>
								</label>
							</div>
							<?php break; case "group": ?>
								<ul class="tab-nav nav">
									<?php if(is_array($form['options']) || $form['options'] instanceof \think\Collection): $i = 0; $__LIST__ = $form['options'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?>
										<li data-tab="tab<?php echo $i; ?>" <?php if($i == '1'): ?>class="current" <?php endif; ?> ><a href="javascript:void(0);"><?php echo $li['title']; ?></a></li>
									<?php endforeach; endif; else: echo "" ;endif; ?>
									<div style="clear: both;"></div>
								</ul>
								<div class="tab-content">
								<?php if(is_array($form['options']) || $form['options'] instanceof \think\Collection): $i = 0; $__LIST__ = $form['options'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?>
									<div id="tab<?php echo $i; ?>" class="tab-pane <?php if($i == '1'): ?>in<?php endif; ?> tab<?php echo $i; ?>">
										<?php if(is_array($tab['options']) || $tab['options'] instanceof \think\Collection): if( count($tab['options'])==0 ) : echo "" ;else: foreach($tab['options'] as $o_tab_key=>$tab_form): ?>
										<label class="item-label">
											<span style="font-weight: bold;"><?php echo (isset($tab_form['title']) && ($tab_form['title'] !== '')?$tab_form['title']:''); ?></span>
											<?php if(isset($tab_form['tip'])): ?>
												<span class="check-tips"><?php echo $tab_form['tip']; ?></span>
											<?php endif; ?>
										</label>
										<div>
											<?php switch($tab_form['type']): case "tips": ?>
												<div>
													<?php echo $form['value']; ?>
												</div>
												<?php break; case "text": ?>
													<input type="text" name="config[<?php echo $o_tab_key; ?>]" class="text input-large" value="<?php echo $tab_form['value']; ?>" style="width:400px;">
												<?php break; case "password": ?>
													<input type="password" name="config[<?php echo $o_tab_key; ?>]" class="text input-large" value="<?php echo $tab_form['value']; ?>">
												<?php break; case "hidden": ?>
													<input type="hidden" name="config[<?php echo $o_tab_key; ?>]" value="<?php echo $tab_form['value']; ?>">
												<?php break; case "radio": if(is_array($tab_form['options']) || $tab_form['options'] instanceof \think\Collection): if( count($tab_form['options'])==0 ) : echo "" ;else: foreach($tab_form['options'] as $opt_k=>$opt): ?>
														<label class="radio">
															<input type="radio" name="config[<?php echo $o_tab_key; ?>]" value="<?php echo $opt_k; ?>" <?php if($tab_form['value'] == $opt_k): ?> checked<?php endif; ?>><?php echo $opt; ?>
														</label>
													<?php endforeach; endif; else: echo "" ;endif; break; case "checkbox": if(is_array($tab_form['options']) || $tab_form['options'] instanceof \think\Collection): if( count($tab_form['options'])==0 ) : echo "" ;else: foreach($tab_form['options'] as $opt_k=>$opt): ?>
														<label class="checkbox">
															<?php  
															is_null($tab_form["value"]) && $tab_form["value"] = array();
															 ?>
															<input type="checkbox" name="config[<?php echo $o_tab_key; ?>][]" value="<?php echo $opt_k; ?>" <?php if(in_array(($opt_k), is_array($tab_form['value'])?$tab_form['value']:explode(',',$tab_form['value']))): ?> checked<?php endif; ?>><?php echo $opt; ?>
														</label>
													<?php endforeach; endif; else: echo "" ;endif; break; case "select": ?>
													<select name="config[<?php echo $o_tab_key; ?>]">
														<?php if(is_array($tab_form['options']) || $tab_form['options'] instanceof \think\Collection): if( count($tab_form['options'])==0 ) : echo "" ;else: foreach($tab_form['options'] as $opt_k=>$opt): ?>
															<option value="<?php echo $opt_k; ?>" <?php if($tab_form['value'] == $opt_k): ?> selected<?php endif; ?>><?php echo $opt; ?></option>
														<?php endforeach; endif; else: echo "" ;endif; ?>
													</select>
												<?php break; case "textarea": ?>
													<label>
														<textarea name="config[<?php echo $o_tab_key; ?>]"><?php echo $tab_form['value']; ?></textarea>
													</label>
												<?php break; endswitch; ?>
											</div>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
								<?php endforeach; endif; else: echo "" ;endif; ?>
								</div>
							<?php break; endswitch; ?>
					</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		
		<input type="hidden" name="id" value="<?php echo $addonId; ?>" readonly/>
		<button type="submit" class="btn submit-btn ajax-post btn-blue">确 定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" value="返回" class="btn" onclick="location.href='<?php echo url("admin/addons/index"); ?>'">
	</form>


<script type="text/javascript" charset="utf-8">

$(function(){
	 $(".tab-nav li").click(function(){
	        var self = $(this), target = self.data("tab");
	        self.addClass("current").siblings(".current").removeClass("current");
	        //window.location.hash = "#" + target.substr(3);
	        $(".tab-pane.in").removeClass("in");
	        $("." + target).addClass("in");
	}).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();
})
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