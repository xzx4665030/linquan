<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:65:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shop_home.html";i:1494579064;s:60:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\base.html";i:1490282008;s:66:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\header_top.html";i:1493889699;s:66:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shop_apply.html";i:1491364219;s:66:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\right_cart.html";i:1494381492;s:62:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\footer.html";i:1493952747;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $data['shop']['shopName']; ?> - <?php echo WSTConf('CONF.mallName'); ?><?php echo WSTConf('CONF.mallTitle'); ?></title>
<meta name="auther" content="WSTMart,www.wstmart.net" />
<meta name="copyright" content="Copyright©2016-2066 Powered By WSTMart" />

<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__STATIC__/plugins/lazyload/skin/laypage.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STATIC__/plugins/slide/css/slide.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/style.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shophome.css?v=<?php echo $v; ?>" rel="stylesheet">

<script type="text/javascript" src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STATIC__/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>


<?php if(((int)session('WST_USER.userId')<=0)): ?>
<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet">
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/login.js?v=<?php echo $v; ?>'></script>
<?php endif; ?>
<script>
window.conf = {"ROOT":"__ROOT__","APP":"__APP__","STATIC":"__STATIC__","SUFFIX":"<?php echo config('url_html_suffix'); ?>","SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","SMS_OPEN":"<?php echo WSTConf('CONF.smsOpen'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","ROUTES":'<?php echo WSTRoute(); ?>'}
$(function() {
	WST.initVisitor();
});
</script>
</head>

<body>

	<div class="wst-header">
    <div class="wst-nav">
		<ul class="headlf">
		<?php if(session('WST_USER.userId') >0): ?>
		   <li class="drop-info">
			  <div class="drop-infos">
			  <a href="<?php echo Url('home/users/index'); ?>">欢迎您，<?php echo session('WST_USER.userName')?session('WST_USER.userName'):session('WST_USER.loginName'); ?></a>
			  </div>
			  <div class="wst-tag dorpdown-user">
			  	<div class="wst-tagt">
			  	   <div class="userImg" >
				  	<img class='usersImg' data-original="<?php echo WSTUserPhoto(session('WST_USER.userPhoto')); ?>"/>
				   </div>	
				  <div class="wst-tagt-n">
				    <div>
					  	<span class="wst-tagt-na"><?php echo session('WST_USER.userName')?session('WST_USER.userName'):session('WST_USER.loginName'); ?></span>
					  	<?php if((int)session('WST_USER.rankId') > 0): ?>
					  		<img src="__ROOT__/<?php echo session('WST_USER.userrankImg'); ?>" title="<?php echo session('WST_USER.rankName'); ?>"/>
					  	<?php endif; ?>
				  	</div>
				  	<div class='wst-tags'>
			  	     <span class="w-lfloat"><a onclick='WST.position(15,0)' href='<?php echo Url("home/users/edit"); ?>'>用户资料</a></span>
			  	     <span class="w-lfloat" style="margin-left:10px;"><a onclick='WST.position(16,0)' href='<?php echo Url("home/users/security"); ?>'>安全设置</a></span>
			  	    </div>
				  </div>
			  	  <div class="wst-tagb" >
			  		<a onclick='WST.position(5,0)' href='<?php echo Url("home/orders/waitReceive"); ?>'>待收货订单</a>
			  		<a onclick='WST.position(60,0)' href='<?php echo Url("home/logmoneys/usermoneys"); ?>'>我的余额</a>
			  		<a onclick='WST.position(49,0)' href='<?php echo Url("home/messages/index"); ?>'>我的消息</a>
			  		<a onclick='WST.position(13,0)' href='<?php echo Url("home/userscores/index"); ?>'>我的积分</a>
			  		<a onclick='WST.position(41,0)' href='<?php echo Url("home/favorites/goods"); ?>'>我的关注</a>
			  		<a style='display:none'>咨询回复</a>
			  	  </div>
			  	<div class="wst-clear"></div>
			  	</div>
			  </div>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			<a href='<?php echo Url("home/messages/index"); ?>' target='_blank' onclick='WST.position(49,0)'>消息（<span id='wst-user-messages'>0</span>）</a>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			  <div><a href="javascript:WST.logout();">退出</a></div>
			</li>
			<?php else: ?>
			<li class="drop-info">
			  <div>欢迎来到<?php echo WSTMSubstr(WSTConf('CONF.mallName'),0,13); ?><a href="<?php echo Url('home/users/login'); ?>">&nbsp;&nbsp;请&nbsp;登录</a></div>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			  <div><a href="<?php echo Url('home/users/regist'); ?>">免费注册</a></div>
			</li>
			<?php endif; ?>
		</ul>
		<ul class="headrf" style='float:right;'>
		    <li class="j-dorpdown" style="width: 86px;">
				<div class="drop-down" style="padding-left:0px;">
					<a href="<?php echo Url('home/users/index'); ?>" target="_blank">我的订单<i class="di-right"><s>◇</s></i></a>
				</div>
				<div class='j-dorpdown-layer order-list'>
				   <div><a href='<?php echo Url("home/orders/waitPay"); ?>' onclick='WST.position(3,0)'>待付款订单</a></div>
				   <div><a href='<?php echo Url("home/orders/waitReceive"); ?>' onclick='WST.position(5,0)'>待发货订单</a></div>
				   <div><a href='<?php echo Url("home/orders/waitAppraise"); ?>' onclick='WST.position(6,0)'>待评价订单</a></div>
				</div>
			</li>	
			
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down drop-down2 pdr5"><i class="di-left"></i><a href="#" target="_blank">手机商城</a></div>
				<!-- <div class='j-dorpdown-layer sweep-list'>
				   <div class="qrcodea">
					   <div id='qrcodea' class="qrcodeal"></div>
					   <div class="qrcodear">
					   	<p>扫描二维码</p><span>下载手机客户端</span>
					   	<br/>
					   	<a >Android</a>
					   	<br/>
					   	<a>iPhone</a>
					   </div>
				   </div>
				</div> -->
			</li>
			<li class="spacer">|</li>
			<li class="j-dorpdown" style="width:78px;">
				<div class="drop-down" style="padding:0 5px;"><a href="#" target="_blank">关注我们</a></div>
				<div class='j-dorpdown-layer des-list' style="width:120px;">
					<!-- <div style="height:114px;"><img src="__STYLE__/img/lqsj_qr_code.jpg" style="height:114px;"></div> -->
					<!-- <div>关注我们</div> -->
				</div>
			</li>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down drop-down4 pdr5"><a href="#" target="_blank">我的收藏</a></div>
				<div class='j-dorpdown-layer foucs-list'>
				   <div><a href="<?php echo Url('home/favorites/goods'); ?>" onclick='WST.position(41,0)'>商品收藏</a></div>
				   <div><a href="<?php echo Url('home/favorites/shops'); ?>" onclick='WST.position(46,0)'>店铺收藏</a></div>
				</div>
			</li>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down drop-down5 pdr5" ><a href="#" target="_blank">客户服务</a></div>
				<div class='j-dorpdown-layer des-list'>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=1"); ?>' target='_blank'>帮助中心</a></div>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=8"); ?>' target='_blank'>售后服务</a></div>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=3"); ?>' target='_blank'>常见问题</a></div>
				</div>
			</li>
			<li class="spacer">|</li>
			<?php if(session('WST_USER.userId') > 0): if(session('WST_USER.userType') == 0): ?>
				<li class="j-dorpdown">
				<div class="drop-down pdl5" ><a href="#" target="_blank">商家管理<i class="di-right"><s>◇</s></i></a></div>
				<div class='j-dorpdown-layer foucs-list'>
				   <div><a href="<?php echo url('home/shops/login'); ?>">商家登录</a></div>
				   <div><a href="javascript:shopApply();" rel="nofollow">我要开店</a></div>
				</div>
				</li>
				
				<?php else: ?>
				<li class="j-dorpdown">
				    <div class="drop-down pdl5" >
				       <a href="<?php echo Url('home/shops/index'); ?>" rel="nofollow" target="_blank">卖家中心<i class="di-right"><s>◇</s></i></a>
				    </div>
				    <div class='j-dorpdown-layer product-list last-menu'>
					   <div><a href='<?php echo Url("home/orders/waitdelivery"); ?>' onclick='WST.position(24,1)'>待发货订单</a></div>
					   <div><a href='<?php echo Url("home/orders/waitdelivery"); ?>' onclick='WST.position(25,1)'>投诉订单</a></div>
					   <div><a href='<?php echo Url("home/home/goods/sale"); ?>' onclick='WST.position(32,1)'>商品管理</a></div>
					   <div><a href='<?php echo Url("home/shopcats/index"); ?>' onclick='WST.position(30,1)'>商品分类</a></div>
					</div>
				</li>
				<?php endif; else: ?>
				<li class="j-dorpdown">
				<div class="drop-down pdl5" ><a href="#" target="_blank">商家管理<i class="di-right"><s>◇</s></i></a></div>
				<div class='j-dorpdown-layer foucs-list'>
				   <div><a href="<?php echo url('home/shops/login'); ?>">商家登录</a></div>
				   <div><a href="javascript:shopApply();" rel="nofollow">我要开店</a></div>
				</div>
				</li>
				
			<?php endif; ?>
			</li>
		</ul>
		<div class="wst-clear"></div>
  </div>
</div>
<script>
$(function(){
	//二维码
	//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
	var a = qrcode(8, 'M');
	var url = window.location.host+window.conf.APP;
	a.addData(url);
	a.make();
	$('#qrcodea').html(a.createImgTag());
});
function goShop(id){
  location.href=WST.U('home/shops/home','shopId='+id);
}
</script>
<script type='text/javascript' src='__STYLE__/js/qrcode.js?v=<?php echo $v; ?>'></script>



<?php if(session('WST_USER.userId') > 0): if(session('WST_USER.userType') == 0): ?>
		<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shopapply.css?v=<?php echo $v; ?>" rel="stylesheet">
<div id="wst-shopapp" class="wst-shopapp" style="display:none;">
	<div class="wst-shopapp-fo">
	<a href="javascript:void(0)" onclick="javascript:getClose()" class="wst-shopapp-close"></a>
	<form id="apply_form"  method="post" autocomplete="off">
	<table class="wst-table" style="margin:15px;margin-left:35px;">
	    <tr>
	    	<td class="wst-shopapp-td">联系人</td>
	    	<td><input id="linkman" name="linkman" class="lqsj_ipt2 wst-shopapp-input" tabindex="1" maxlength="30" autocomplete="off" onpaste="return false;" style="ime-mode:disabled;" placeholder="联系人"  type="text" data-rule="联系人 required;" data-msg-mobile="请输入联系人" data-msg-required="请输入联系人" data-tip="请输入联系人"/></td>
	    </tr>
		<tr>
			<td class="wst-shopapp-td">手机号</td>
			<td><input id="userPhone2" name="userPhone" class="lqsj_ipt2 wst-shopapp-input" tabindex="1" maxlength="30" autocomplete="off" onpaste="return false;" style="ime-mode:disabled;" placeholder="手机号"  type="text"data-rule="手机号 required;mobile;remote(post:<?php echo url('home/shopapplys/checkShopPhone'); ?>)" data-msg-mobile="请输入有效的手机号" data-msg-required="请输入手机号" data-tip="请输入手机号" data-target="#userPhone2"/></td>
		</tr>
		<?php if((WSTConf('CONF.smsOpen')==1)): ?>
		<tr>
			<td class="wst-shopapp-td">短信验证码</td>
			<td>
				<input maxlength="6" autocomplete="off" tabindex="6" class="lqsj_ipt2 wst-shopapp-input2" name="mobileCode" style="ime-mode:disabled" id="mobileCode" type="text" placeholder="短信验证码" />
				<button type="button"  onclick="javascript:getShopCode();" class="wst-shopapp-obtain">获取短信验证码</button>
				<span id="mobileCodeTips"></span>
			</td>
		</tr>
		<?php else: ?>
		<tr>
			<td class="wst-shopapp-td">验证码</td>
			<td>
				<div class="wst-apply-code">
				<input id="verifyCodea" style="ime-mode:disabled" name="verifyCodea"  class="lqsj_ipt2 wst-apply-codein" tabindex="6" autocomplete="off" maxlength="6" type="text" placeholder="验证码"/>
				<img id='verifyImga' class="wst-apply-codeim" src="" onclick='javascript:WST.getVerify("#verifyImga")' style="width:101px;border-top-right-radius:2px;border-bottom-right-radius:2px;"><span id="verifya"></span>    	
			   	</div>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="wst-shopapp-td">备注</td>
			<td>
				<textarea id="remark" name="remark" class="lqsj_ipt2 wst-remark" id="rejectionRemarks" autocomplete="off" style="width: 350px;height:170px;"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:80px;">
				<label>
					<input id="protocol" name="protocol" type="checkbox" class="lqsj_ipt2" value="1"/>我已阅读并同意
	           	</label>
	           	<a href="javascript:;" style="color:#69b7b5;" id="protocolInfo" onclick="showProtocol();">《商家注册协议》</a>
			</td>
		</tr>
		<tr style="height:45px;">
			<td colspan="2" style="padding-left:165px;">
				<input id="reg_butt" class="wst-shopapp-but" type="submit" value="注册" style="width: 100px;height:30px;"/>
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
     <form method="post" id="shopVerifys" autocomplete="off" style="display:none;">
      <input type='hidden' id='VerifyId' value='' autocomplete="off"/>
      <table class='wst-table' style="width:400x;margin:15px;margin-left:35px;">
      	<tr>
			<td class="wst-shopapp-td">验证码</td>
			<td>
				<input id="smsVerfy"  name="smsVerfy"  class="lqsj_ipt2 wst-shopapp-input2" tabindex="6" autocomplete="off" maxlength="6" type="text" data-target="#smsVerfyTips" placeholder="验证码" data-rule="验证码: required;" data-msg-required="请输入验证码" data-tip="请输入验证码"/>
				<span id="smsVerfyTips" style="float:right;"></span>      	
			   	<label style="float:right;margin-top:5px;"><a href="javascript:WST.getVerify('#verifyImg3')">&nbsp;换一张</a></label>
				<label style="float:right;">
					<img id='verifyImg3' src="" onclick='javascript:WST.getVerify("#verifyImg3")' style="width:100px;"> 
				</label>
			</td>
		</tr>
         <tr>
           <td colspan='2' style='padding-left:170px;height:50px;'>
               <button class="wst-shopapp-but" type="submit" style="width:100px;height: 30px;">确认</button>
           </td>
         </tr>
        </table>
      </form>
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/shop_applys.js?v=<?php echo $v; ?>'></script>	
	<?php endif; else: ?>
	<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shopapply.css?v=<?php echo $v; ?>" rel="stylesheet">
<div id="wst-shopapp" class="wst-shopapp" style="display:none;">
	<div class="wst-shopapp-fo">
	<a href="javascript:void(0)" onclick="javascript:getClose()" class="wst-shopapp-close"></a>
	<form id="apply_form"  method="post" autocomplete="off">
	<table class="wst-table" style="margin:15px;margin-left:35px;">
	    <tr>
	    	<td class="wst-shopapp-td">联系人</td>
	    	<td><input id="linkman" name="linkman" class="lqsj_ipt2 wst-shopapp-input" tabindex="1" maxlength="30" autocomplete="off" onpaste="return false;" style="ime-mode:disabled;" placeholder="联系人"  type="text" data-rule="联系人 required;" data-msg-mobile="请输入联系人" data-msg-required="请输入联系人" data-tip="请输入联系人"/></td>
	    </tr>
		<tr>
			<td class="wst-shopapp-td">手机号</td>
			<td><input id="userPhone2" name="userPhone" class="lqsj_ipt2 wst-shopapp-input" tabindex="1" maxlength="30" autocomplete="off" onpaste="return false;" style="ime-mode:disabled;" placeholder="手机号"  type="text"data-rule="手机号 required;mobile;remote(post:<?php echo url('home/shopapplys/checkShopPhone'); ?>)" data-msg-mobile="请输入有效的手机号" data-msg-required="请输入手机号" data-tip="请输入手机号" data-target="#userPhone2"/></td>
		</tr>
		<?php if((WSTConf('CONF.smsOpen')==1)): ?>
		<tr>
			<td class="wst-shopapp-td">短信验证码</td>
			<td>
				<input maxlength="6" autocomplete="off" tabindex="6" class="lqsj_ipt2 wst-shopapp-input2" name="mobileCode" style="ime-mode:disabled" id="mobileCode" type="text" placeholder="短信验证码" />
				<button type="button"  onclick="javascript:getShopCode();" class="wst-shopapp-obtain">获取短信验证码</button>
				<span id="mobileCodeTips"></span>
			</td>
		</tr>
		<?php else: ?>
		<tr>
			<td class="wst-shopapp-td">验证码</td>
			<td>
				<div class="wst-apply-code">
				<input id="verifyCodea" style="ime-mode:disabled" name="verifyCodea"  class="lqsj_ipt2 wst-apply-codein" tabindex="6" autocomplete="off" maxlength="6" type="text" placeholder="验证码"/>
				<img id='verifyImga' class="wst-apply-codeim" src="" onclick='javascript:WST.getVerify("#verifyImga")' style="width:101px;border-top-right-radius:2px;border-bottom-right-radius:2px;"><span id="verifya"></span>    	
			   	</div>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="wst-shopapp-td">备注</td>
			<td>
				<textarea id="remark" name="remark" class="lqsj_ipt2 wst-remark" id="rejectionRemarks" autocomplete="off" style="width: 350px;height:170px;"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:80px;">
				<label>
					<input id="protocol" name="protocol" type="checkbox" class="lqsj_ipt2" value="1"/>我已阅读并同意
	           	</label>
	           	<a href="javascript:;" style="color:#69b7b5;" id="protocolInfo" onclick="showProtocol();">《商家注册协议》</a>
			</td>
		</tr>
		<tr style="height:45px;">
			<td colspan="2" style="padding-left:165px;">
				<input id="reg_butt" class="wst-shopapp-but" type="submit" value="注册" style="width: 100px;height:30px;"/>
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
     <form method="post" id="shopVerifys" autocomplete="off" style="display:none;">
      <input type='hidden' id='VerifyId' value='' autocomplete="off"/>
      <table class='wst-table' style="width:400x;margin:15px;margin-left:35px;">
      	<tr>
			<td class="wst-shopapp-td">验证码</td>
			<td>
				<input id="smsVerfy"  name="smsVerfy"  class="lqsj_ipt2 wst-shopapp-input2" tabindex="6" autocomplete="off" maxlength="6" type="text" data-target="#smsVerfyTips" placeholder="验证码" data-rule="验证码: required;" data-msg-required="请输入验证码" data-tip="请输入验证码"/>
				<span id="smsVerfyTips" style="float:right;"></span>      	
			   	<label style="float:right;margin-top:5px;"><a href="javascript:WST.getVerify('#verifyImg3')">&nbsp;换一张</a></label>
				<label style="float:right;">
					<img id='verifyImg3' src="" onclick='javascript:WST.getVerify("#verifyImg3")' style="width:100px;"> 
				</label>
			</td>
		</tr>
         <tr>
           <td colspan='2' style='padding-left:170px;height:50px;'>
               <button class="wst-shopapp-but" type="submit" style="width:100px;height: 30px;">确认</button>
           </td>
         </tr>
        </table>
      </form>
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/shop_applys.js?v=<?php echo $v; ?>'></script>	
<?php endif; ?>



	<style type="text/css">
	.yhq{position: fixed;width: 600px;height: auto;background: #fff;display: none;}
</style>
<script type="text/javascript">
	
		function youhuiquan(){
			var id=$("#shopId").val();
			data = {'shopId':id};
			$.ajax({
				url:WST.U('home/shops/shop_promotion_list'),
				data:data,
				type:'post',
				dataType:'json',
				success:function(data){
					if(data.length>0){
						var jj='';
						for(var o=0;o<data.length;o++){
							jj=jj+'<tr><td class="discount_type">'+data[o].discount_type+'</td><td class="discount_name">'+data[o].discount_name+'</td><td><img class="discount_img" src="'+data[o].discount_img+'"/></td><td class="discount_value">￥：'+data[o].discount_value+'</td>';
							jj=jj+'<td class="discount_consume">'+data[o].discount_consume+'</td><td class="discount_startDate">'+data[o].discount_startDate+'</td><td class="discount_endDate">'+data[o].discount_endDate+'</td>';
							jj=jj+'<td><span class="lingqu">领取</span></td><td style="display:none;" class="discount_flag">'+data[o].discount_flag+'</td><td style="display:none;" class="discount_id">'+data[o].discount_id+'</td></tr>';
						}
						$("#yhq_jz table").append(jj);
						$('.yhq').show();
					}
				}
			})
			
			$("#yhq_jz").on("click",".lingqu",function(){   //领取
				var ijd=$("#yhq_jz .lingqu").index($(this));
				var  discount_flag=$("#yhq_jz .discount_flag").eq(ijd).html();
				var  discount_id=$("#yhq_jz .discount_id").eq(ijd).html();
				var ds = {"discount_flag":discount_flag,"discount_id":discount_id,"id":id}
				$.ajax({
					url:WST.U('home/shops/receive_promotion'),
					data:ds,
					type:'post',
					dataType:'json',
					success:function(e){
						if(e.flag > 0){
							alert(e.msg);
							window.location.reload();
						}else{
							alert(e.msg);
							window.location.reload();
						}
					}
				})
			})
			
			
			$('.yhq').show();
			$(".yhq .guanbi").click(function(){
				$("#yhq_jz").html("");
				$(".yhq").hide();
			})
		}
	
</script>
	<div class="wst-container">
		<div class="wst-shop-h">
		<div class="wst-shop-img"><a href="<?php echo url('home/shops/home',array('shopId'=>$data['shop']['shopId'])); ?>"><img class="shopsImg" data-original="__ROOT__/<?php echo $data['shop']['shopImg']; ?>" title="<?php echo $data['shop']['shopName']; ?>"></a></div>
		<div class="wst-shop-info">
			<p><?php echo $data['shop']['shopName']; ?></p>
			<div class="wst-shop-info2">
			<?php if(is_array($data['shop']['accreds']) || $data['shop']['accreds'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['shop']['accreds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ac): $mod = ($i % 2 );++$i;?>
			<img src="__ROOT__/<?php echo $ac['accredImg']; ?>"><span><?php echo $ac['accredName']; ?></span>
			<?php endforeach; endif; else: echo "" ;endif; if(($data['shop']['shopQQ'])): ?>
			<a href="tencent://message/?uin=<?php echo $data['shop']['shopQQ']; ?>&Site=QQ交谈&Menu=yes">
		        <img border="0" style="width:65px;height:24px;" src="http://wpa.qq.com/pa?p=1:<?php echo $data['shop']['shopQQ']; ?>:7">
		    </a>
			<?php endif; ?>
			 <a href="javascript:youhuiquan()">
		      	<span>领取优惠卷</span>
		      </a>
		      <div class="yhq">
	<div>店铺优惠卷</div>
	<div id="yhq_jz"></div>
	<div class="guanbi">关闭</div>
</div>
			<?php if(($data['shop']['shopWangWang'])): ?>
			<a href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $data['shop']['shopWangWang']; ?>&siteid=cntaobao&status=1&charset=utf-8" target="_blank">
			<img border="0" src="http://amos.alicdn.com/realonline.aw?v=2&uid=<?php echo $data['shop']['shopWangWang']; ?>&site=cntaobao&s=1&charset=utf-8" alt="和我联系" class='wangwang'/>
			</a>
			<?php endif; ?>
			</div>
			<div class="wst-shop-info3">
				<span class="wst-shop-eva">商品评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['goodsScore']; ?></span></span>
				<span class="wst-shop-eva">时效评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['timeScore']; ?></span></span>
				<span class="wst-shop-eva">服务评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['serviceScore']; ?></span></span>
				<?php if(($data['shop']['favShop']>0)): ?>
				<a href='javascript:void(0);' onclick='WST.cancelFavorite(this,1,<?php echo $data['shop']['shopId']; ?>,<?php echo $data['shop']['favShop']; ?>)' class="wst-shop-evaa j-fav">已关注</a>
				<?php else: ?>
				<a href='javascript:void(0);' onclick='WST.addFavorite(this,1,<?php echo $data['shop']['shopId']; ?>,<?php echo $data['shop']['favShop']; ?>)' class="wst-shop-evaa j-fav2">关注店铺</a>
				<?php endif; ?>
				<span class="wst-shop-eva">用手机逛本店  &nbsp;&nbsp;|</span>
				<a class="wst-shop-code"><span class="wst-shop-codes hide"><div id='qrcode' style='width:142px;height:142px;'></div></span></a>
			</div>
		</div>
		<div class="wst-shop-sea">
			<input type="text" id="goodsName" value="<?php echo $goodsName; ?>" placeholder="输入商品名称">
			<a class="search" href="javascript:void(0);" onclick="javascript:WST.goodsSearch($('#goodsName').val());">搜全站</a>
			<a class="search" href="javascript:void(0);" onclick="javascript:searchShopsGoods(0);">搜本店</a>
			<div class="wst-shop-word">
			<?php if(is_array($data['shop']['shopHotWords']) || $data['shop']['shopHotWords'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['shop']['shopHotWords'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shw): $mod = ($i % 2 );++$i;?>
			<a href='<?php echo Url("home/shops/home",array('shopId'=>$data['shop']['shopId'],'goodsName'=>$shw)); ?>'><?php echo $shw; ?></a><?php if($i< count($data['shop']['shopHotWords'])): ?>&nbsp;|&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
			
			
			<?php echo hook('homeDocumentShopHomeHeader',['shop'=>$data['shop'],'getParams'=>input()]); ?>
			<div class="jiathis_style_24x24 wst-shop-share">
				<a class="jiathis_button_qzone"></a>
				<a class="jiathis_button_tsina"></a>
				<a class="jiathis_button_tqq"></a>
				<a class="jiathis_button_weixin"></a>
				<a class="jiathis_button_cqq"></a>
				<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>					
			</div>
			<div style="clear: both;"></div>
			
			<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
			
		</div>
		<div class="wst-clear"></div>
		</div>
	</div>
	<?php if(($data['shop']['shopBanner'])): ?><div class="wst-shop-tu" style="background: url(__ROOT__/<?php echo $data['shop']['shopBanner']; ?>) no-repeat  scroll center top;background-size:cover;"></div><?php endif; ?>
	 <div class='wst-header'>
		<div class="wst-shop-nav">
			<div class="wst-nav-box">
				<a href="<?php echo url('home/shops/home',array('shopId'=>$data['shop']['shopId'])); ?>"><li class="liselect wst-lfloat <?php if($ct1 == 0): ?>wst-nav-boxa<?php endif; ?>">本店全部商品</li></a>
				<?php if(is_array($data['shopcats']) || $data['shopcats'] instanceof \think\Collection): $i = 0;$__LIST__ = is_array($data['shopcats']) ? array_slice($data['shopcats'],0,8, true) : $data['shopcats']->slice(0,8, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sc): $mod = ($i % 2 );++$i;?>
					<a href="<?php echo url('home/shops/cat',array('shopId'=>$sc['shopId'],'ct1'=>$sc['catId'])); ?>"><li class="liselect wst-lfloat <?php if($ct1 == $sc['catId']): ?>wst-nav-boxa<?php endif; ?>"><?php echo $sc['catName']; ?></li></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<a class="homepage" href='<?php echo \think\Request::instance()->root(true); ?>'>返回商城首页</a>
				<div class="wst-clear"></div>
			</div>
		</div>
		<div class="wst-clear"></div>
	</div>
	<?php if(($data['shop']['shopAds'])): ?>
	<div class="ck-slide">
		<ul class="ck-slide-wrapper">
			<?php if(is_array($data['shop']['shopAds']) || $data['shop']['shopAds'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['shop']['shopAds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ads): $mod = ($i % 2 );++$i;?>
			<li>
				<a <?php if(($ads['isOpen'])): ?>target='_blank'<?php endif; ?>  href="<?php echo $ads['adUrl']; ?>" ><img class='goodsImg' data-original="__ROOT__/<?php echo $ads['adImg']; ?>" width="100%" height="400"/></a>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<!-- <a href="javascript:;" class="ctrl-slide ck-prev" ></a> 
		<a href="javascript:;" class="ctrl-slide ck-next" ></a> -->
		<div class="ck-slidebox">
			<div class="slideWrap">
				<ul class="dot-wrap">
				<?php if(is_array($data['shop']['shopAds']) || $data['shop']['shopAds'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['shop']['shopAds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ads): $mod = ($i % 2 );++$i;if($i == 1): ?>
						<li class="current"><em><?php echo $i; ?></em></li>
					<?php else: ?>
						<li><em><?php echo $i; ?></em></li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<?php endif; ?>


<input type="hidden" id="msort" value="<?php echo $msort; ?>" autocomplete="off"/>
<input type="hidden" id="mdesc" value="<?php echo $mdesc; ?>" autocomplete="off"/>
<input type="hidden" id="shopId" value="<?php echo $data['shop']['shopId']; ?>" autocomplete="off"/>
<input type="hidden" id="ct1" value="<?php echo $ct1; ?>" autocomplete="off"/>
<input type="hidden" id="ct2" value="<?php echo $ct2; ?>" autocomplete="off"/>
<div class="wst-container">
	<div class="wst-shop-contl">
		<div class="wst-shop-cat">
			<p class="wst-shop-conlp">店铺分类</p>
			<div class="wst-shop-catt">
			<?php if(is_array($data['shopcats']) || $data['shopcats'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['shopcats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sc1): $mod = ($i % 2 );++$i;?>
				<li onclick="javascript:dropDown(this,<?php echo $sc1['catId']; ?>);" class="js-shop-plus"><?php echo WSTMSubstr($sc1['catName'],0,15); ?></li>
				<?php if(($sc1['children'])): ?>
				<div class="wst-shop-catts tree_<?php echo $sc1['catId']; ?>">
				<?php if(is_array($sc1['children']) || $sc1['children'] instanceof \think\Collection): $i = 0; $__LIST__ = $sc1['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sc2): $mod = ($i % 2 );++$i;?>
					<a href="<?php echo url('home/shops/cat',array('shopId'=>$sc1['shopId'],'ct1'=>$sc1['catId'],'ct2'=>$sc2['catId'])); ?>"><li><?php echo WSTMSubstr($sc2['catName'],0,15); ?></li></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="wst-shop-best">
			<p class="wst-shop-conlp">热卖商品</p>
			<?php $wstTagShopGoods =  model("common/Tags")->listShopGoods("hot",$data['shop']['shopId'],5,0); foreach($wstTagShopGoods as $key=>$ho){?>
			<a href="<?php echo url('home/goods/detail',array('id'=>$ho['goodsId'])); ?>" target="_blank">
			<div class="wst-shop-bestg">
				<div class="wst-shop-besti"><img class="goodsImg" data-original="__ROOT__/<?php echo $ho['goodsImg']; ?>" title="<?php echo $ho['goodsName']; ?>" alt="<?php echo $ho['goodsName']; ?>"></div>
				<a href="<?php echo url('home/goods/detail',array('id'=>$ho['goodsId'])); ?>"><p class="wst-shop-bestgp1"><?php echo WSTMSubstr($ho['goodsName'],0,20); ?></p></a>
				<p class="wst-shop-bestgp2">已售出<span class="wst-shop-bestpi"><?php echo $ho['saleNum']; ?></span>件</p>
				<p class="wst-shop-bestgp2"><span class="wst-shop-bestpr">￥<?php echo $ho['shopPrice']; ?></span><span class="wst-shop-bestpr2">￥<?php echo $ho['marketPrice']; ?></span></p>
			</div>
			</a>
			<?php } ?>
			<div class="wst-clear"></div>
		</div>
		<?php if(cookie("history_goods")!=''): ?>
		<div class="wst-shop-lat">
			<p class="wst-shop-conlp">最近浏览</p>
			<?php $wstTagGoods =  model("common/Tags")->listGoods("history",0,4,0); foreach($wstTagGoods as $key=>$vo){?>
			<div class="wst-shop-bestg">
				<div class="wst-shop-besti"><a target='_blank' href="<?php echo Url('home/goods/detail','id='.$vo['goodsId']); ?>"><img class="goodsImg" data-original="__ROOT__/<?php echo WSTImg($vo['goodsImg']); ?>" title="<?php echo $vo['goodsName']; ?>" alt="<?php echo $vo['goodsName']; ?>" ></div>
				<a href="<?php echo url('home/goods/detail','id='.$vo['goodsId']); ?>" target='_blank'><p class="wst-shop-bestgp1"><?php echo $vo['goodsName']; ?></p></a>
				<p class="wst-shop-bestgp2">已售出<span class="wst-shop-bestpi"><?php echo $vo['saleNum']; ?></span>件</p>
				<p class="wst-shop-bestgp2"><span class="wst-shop-bestpr">￥<?php echo $vo['shopPrice']; ?></span><span class="wst-shop-bestpr2">￥<?php echo $vo['marketPrice']; ?></span></p>
			</div>
			<?php } ?>
			<div class="wst-clear"></div>
		</div>
		<?php endif; ?>
	</div>
	<div class="wst-shop-contr">
		<div class="wst-shop-rec">
			<p class="wst-shop-conrp">店长推荐</p>
			<div class="wst-shop-recb">
			    <?php $wstTagShopGoods =  model("common/Tags")->listShopGoods("recom",$data['shop']['shopId'],4,0); foreach($wstTagShopGoods as $key=>$re){?>
				<div class="wst-shop-rgoods">
					<div class="wst-shop-goimg"><a href="<?php echo url('home/goods/detail',array('id'=>$re['goodsId'])); ?>" target="_blank"><img class="goodsImg" data-original="__ROOT__/<?php echo $re['goodsImg']; ?>" title="<?php echo $re['goodsName']; ?>"></a></div>
					<p class="wst-shop-gonam"><a href="<?php echo url('home/goods/detail',array('id'=>$re['goodsId'])); ?>" target="_blank"><?php echo WSTMSubstr($re['goodsName'],0,28); ?></a></p>
					<div class="wst-shop-rect">
					<span>￥<?php echo $re['shopPrice']; ?></span>
					<?php if(($re['goodsStock'])): ?>
					<a class="wst-shop-recta" href="javascript:WST.addCart(<?php echo $re['goodsId']; ?>)">加入购物车</a>
					<?php else: ?>
					<a class="wst-shop-recta2" href="javascript:void(0);">暂无商品</a>
					<?php endif; ?>
					</div>
				</div>
			    <?php } ?>
				<div class="wst-clear"></div>
			</div>
		</div>
		<div class="wst-shop-list">
			<div class="wst-shop-listh">
				<a href="javascript:void(0);" class="<?php if($msort == 0): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(0);">综合排序</a>
				<a href="javascript:void(0);" class="<?php if($msort == 1): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(1);">人气<span class="<?php if($msort != 1): ?>wst-shop-store<?php endif; if($msort == 1 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 1 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 2): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(2);">销量<span class="<?php if($msort != 2): ?>wst-shop-store<?php endif; if($msort == 2 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 2 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 3): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(3);">价格<span class="<?php if($msort != 3): ?>wst-shop-store<?php endif; if($msort == 3 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 3 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 4): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(4);">好评度<span class="<?php if($msort != 4): ?>wst-shop-store<?php endif; if($msort == 4 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 4 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 5): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(5);">上架时间<span class="<?php if($msort != 5): ?>wst-shop-store<?php endif; if($msort == 5 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 5 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<div class="wst-price-ipts">
				<span class="wst-price-ipt1">￥</span><span class="wst-price-ipt2">￥</span>
				<input type="text" class="wst-price-ipt" id="sprice" value="<?php echo $sprice; ?>" style="margin-left:8px;" onkeypress='return WST.isNumberdoteKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
				- <input type="text" class="wst-price-ipt" id="eprice" value="<?php echo $eprice; ?>" onkeypress='return WST.isNumberKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
				</div>
				<button class="wst-shop-but" type="submit" style="width:60px;height: 33px;" onclick="searchShopsGoods(0);">确定</button>
			</div>
			<div class="wst-clear"></div>
			<div class="wst-shop-listg">
				<?php if(is_array($data['list']['Rows']) || $data['list']['Rows'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['list']['Rows'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?>
				<div class="wst-shop-goods">
					<div class="wst-shop-goimg"><a href="<?php echo url('home/goods/detail',array('id'=>$li['goodsId'])); ?>" target="_blank"><img class="goodsImg" data-original="__ROOT__/<?php echo $li['goodsImg']; ?>" title="<?php echo $li['goodsName']; ?>"></a><a href="javascript:WST.addCart(<?php echo $li['goodsId']; ?>);"><span class="js-cart">加入购物车</span></a></div>
					<p class="wst-shop-gonam"><a href="<?php echo url('home/goods/detail',array('id'=>$li['goodsId'])); ?>" target="_blank"><?php echo WSTMSubstr($li['goodsName'],0,15); ?></a></p>
					<p class="wst-shop-goodp1"><span class="wst-shop-goodpr">￥<?php echo $li['shopPrice']; ?></span><span class="wst-rfloat">成交数：<span class="wst-shop-goodpr2"><?php echo $li['saleNum']; ?></span></span></p>
					<p class="wst-shop-goodp2"><span class="wst-shop-goodpr3">市场价:￥<?php echo $li['marketPrice']; ?></span><span class="wst-rfloat">已有<span class="wst-shop-goodpr4"><?php echo $li['appraiseNum']; ?></span>人评价</span></p>
				</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
			<div class="wst-shop-pa">
				<div id="shopPage"></div>
			</div>
		</div>
	</div>
	<div class="wst-clear"></div>
</div>
<link href="__STYLE__/css/right_cart.css?v=<?php echo $v; ?>" rel="stylesheet">
<div class="j-global-toolbar">
	<div class="toolbar-wrap j-wrap">
		<div class="toolbar">
			<div class="toolbar-panels j-panel">
				<div style="visibility: hidden;" class="j-content toolbar-panel tbar-panel-cart toolbar-animate-out">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="" class="title"><i></i><em class="title">购物车</em></a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main">
						<div class="tbar-panel-content j-panel-content">
						    <?php if(session('WST_USER.userId') == 0): ?>
							<div id="j-cart-tips" class="tbar-tipbox hide">
								<div class="tip-inner">
									<span class="tip-text">还没有登录，登录后商品将被保存</span>
									<a href="#none" onclick='WST.loginWindow()' class="tip-btn j-login">登录</a>
								</div>
							</div>
							<?php endif; ?>
							<div id="j-cart-render">
								<div id='cart-panel' class="tbar-cart-list"></div>
								  <script id="list-rightcart" type="text/html">
								  {{#
                                    var shop,goods,specs;
                                    for(var key in d){
                                        shop = d[key];
					                    for(var i=0;i<shop.list.length;i++){
                                           goods = shop.list[i];
						                   goods.goodsImg = WST.conf.ROOT+"/"+goods.goodsImg;
						                   specs = '';
						                   if(goods.specNames && goods.specNames.length>0){
							                  for(var j=0;j<goods.specNames.length;j++){
								                 specs += goods.specNames[j].itemName+ " ";
							                  }
						                   }
                                   }}
								   <div class="tbar-cart-item" id="shop-cart-{{shop.shopId}}">
							          <div class="jtc-item-promo">
							            <div class="promo-text">{{shop.shopName}}</div>
							          </div>
								      <div class="jtc-item-goods j-goods-item-{{goods.cartId}}" dataval="{{goods.cartId}}">
								          <div class='wst-lfloat'>
			                                 <input type='checkbox' id='rcart_{{goods.cartId}}' class='rchk' onclick='javascript:checkRightChks({{goods.cartId}},this);' {{# if(goods.isCheck==1){}}checked{{# } }}/></div>
									      <span class="p-img"><a target="_blank" href="{{WST.U('home/goods/detail','id='+goods.goodsId)}}" target="_blank"><img src="{{goods.goodsImg}}" title="{{goods.goodsName}}" height="50" width="50"></a></span>
									      <div class="p-name">
									          <a target="_blank" title="{{(goods.goodsName+((specs!='')?"【"+specs+"】":""))}}" href="{{WST.U('home/goods/detail','id='+goods.goodsId)}}">{{WST.cutStr(goods.goodsName,22)}}<br/>{{specs}}</a>
									      </div>
									      <div class="p-price">
									          <strong>¥<span id='gprice_{{goods.cartId}}'>{{goods.shopPrice}}</span></strong> 
									          <div class="wst-rfloat">
									             <a href="#none" class="buy-btn" id="buy-reduce_{{goods.cartId}}" onclick="javascript:WST.changeIptNum(-1,'#buyNum','#buy-reduce,#buy-add','{{goods.cartId}}','statRightCartMoney')">-</a>
									             <input type="text" id="buyNum_{{goods.cartId}}" class="right-cart-buy-num" value="{{goods.cartNum}}" data-max="{{goods.goodsStock}}" data-min="1" onkeyup="WST.changeIptNum(0,'#buyNum','#buy-reduce,#buy-add',{{goods.cartId}},'statRightCartMoney')" autocomplete="off"  onkeypress="return WST.isNumberKey(event);" maxlength="6"/>
									             <a href="#none" class="buy-btn" id="buy-add_{{goods.cartId}}" onclick="javascript:WST.changeIptNum(1,'#buyNum','#buy-reduce,#buy-add','{{goods.cartId}}','statRightCartMoney')">+</a>
									          </div>
									     </div>
									      <span onclick="javascript:delRightCart(this,{{goods.cartId}});" dataid="{{shop.shopId}}|{{goods.cartId}}" class="goods-remove" title="删除"></span>
									 </div>
								 </div>    
								 {{# } } }} 
                                 </script>   	
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer">
						<div class="tbar-checkout">
							<div class="jtc-number">已选<strong id="j-goods-count">0</strong>件商品 </div>
							<div class="jtc-sum"> 共计：¥<strong id="j-goods-total-money">0</strong> </div>
							<a class="jtc-btn j-btn" href="#none" onclick='javascript:jumpSettlement()'>去结算</a>
						</div>
					</div>
				</div>

				<div style="visibility: hidden;" data-name="follow" class="j-content toolbar-panel tbar-panel-follow">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="#" target="_blank" class="title"> <i></i> <em class="title">我的关注</em> </a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main">
						<div class="tbar-panel-content j-panel-content">
							<div class="tbar-tipbox2">
								<div class="tip-inner"> <i class="i-loading"></i> </div>
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer"></div>
				</div>
				
				<div style="visibility: hidden;" class="j-content toolbar-panel tbar-panel-history toolbar-animate-in">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="#none" class="title"> <i></i> <em class="title">我的足迹</em> </a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main">
						<div class="tbar-panel-content j-panel-content">
							<div class="jt-history-wrap">
								<ul id='history-goods-panel'></ul>
								<script id="list-history-goods" type="text/html">
								{{# 
                                 for(var i = 0; i < d.length; i++){ 
                                  d[i].goodsImg = WST.conf.ROOT+"/"+d[i].goodsImg;
                                 }}
								   <li class="jth-item">
										<a target='_blank' href="{{WST.U('home/goods/detail','id='+d[i].goodsId)}}" class="img-wrap"><img src="{{d[i].goodsImg}}" height="100" width="100"> </a>
										<a class="add-cart-button" href="javascript:WST.addCart({{d[i].goodsId}});">加入购物车</a>
										<a href="#none" class="price">￥{{d[i].shopPrice}}</a>
									</li>
								{{# } }}
                                </script>
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer"></div>
				</div>
			</div>
			
			<div class="toolbar-header"></div>
			
			<div class="toolbar-tabs j-tab">
				<div class="toolbar-tab tbar-tab-cart">
					<i class="tab-ico"></i>
					<em class="tab-text">购物车</em>
					<span class="tab-sub j-cart-count hide"></span>
				</div>
				<div class="toolbar-tab tbar-tab-follow" style='display:none'>
					<i class="tab-ico"></i>
					<em class="tab-text">我的关注</em>
					<span class="tab-sub j-count hide">0</span> 
				</div>
				<div class=" toolbar-tab tbar-tab-history ">
					<i class="tab-ico"></i>
					<em class="tab-text">我的足迹</em>
					<span class="tab-sub j-count hide"></span>
				</div>
				<div class="toolbar-tab tbar-tab-message">
				  <a target='_blank' href='<?php echo Url("home/messages/index"); ?>' onclick='WST.position(49,0)'>
					<i class="tab-ico"></i>
					<em class="tab-text">我的消息</em>
					<span class="tab-sub j-message-count hide"></span> 
				  </a>
				</div>
			</div>
			
			<div class="toolbar-footer">
				<div class="toolbar-tab tbar-tab-top"> <a href="#"> <i class="tab-ico  "></i> <em class="footer-tab-text">顶部</em> </a> </div>
				<div class=" toolbar-tab tbar-tab-feedback"  style='display:none'> <a href="#" target="_blank"> <i class="tab-ico"></i> <em class="footer-tab-text ">反馈</em> </a> </div>
			</div>
			<div class="toolbar-mini"></div>
		</div>
		<div id="j-toolbar-load-hook"></div>		
	</div>
</div>
<script type='text/javascript' src='__STYLE__/js/right_cart.js?v=<?php echo $v; ?>'></script>


	<div style="border-top: 1px solid #df2003;padding-bottom:25px;margin-top:35px;min-width:1200px;"></div>
<div class="wst-footer-flink">
	<div class="wst-footer" >

		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl" style="text-align: left;padding-left:10px;">友情链接</div>

			<div style="padding-left:40px;">
				<?php $wstTagFriendlink =  model("common/Tags")->listFriendlink(99,86400); foreach($wstTagFriendlink as $key=>$vo){?>
				<div style="float:left;"><a class="flink-hover" href="<?php echo $vo['friendlinkUrl']; ?>"  target="_blank"><?php echo $vo["friendlinkName"]; ?></a>&nbsp;&nbsp;</div> 
				<?php } ?>
				<div class="wst-clear"></div>
			</div>
		</div>

	</div>
</div>
<ul class="wst-footer-info">
	<li><div class="wst-footer-info-img"><img src="__STYLE__/img/icon_play.png"></div>
		<div class="wst-footer-info-text">
			<h1>支付宝支付</h1>
			<p>支付宝签约商家</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img"><img src="__STYLE__/img/icon_zhengpin.png"></div>
		<div class="wst-footer-info-text">
			<h1>正品保证</h1>
			<p>100%原产地</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img"><img src="__STYLE__/img/icon_thwy.png"></div>
		<div class="wst-footer-info-text">
			<h1>退货无忧</h1>
			<p>前天退货保障</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img"><img src="__STYLE__/img/icon_mfps.png"></div>
		<div class="wst-footer-info-text">
			<h1>免费配送</h1>
			<p>满98元包邮</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img"><img src="__STYLE__/img/icon_hdfk.png"></div>
		<div class="wst-footer-info-text">
			<h1>货到付款</h1>
			<p>400城市送货上门</p>
		</div>
	</li>
</ul>
<div class="wst-footer-help">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php $_result=WSTHelps(5,6);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
			<div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
					<span class="wst-footer-wz-pn"><?php echo $vo1["catName"]; ?></span>
					<ul style='margin-left:25px;'>
						<?php if(is_array($vo1['articlecats']) || $vo1['articlecats'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
						<li style='list-style:disc;color:#999;font-size:9px;'>
						<a href="<?php echo Url('Home/Helpcenter/view',array('id'=>$vo2['articleId'])); ?>"><?php echo WSTMSubstr($vo2['articleTitle'],0,8); ?></a>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<div class="wst-contact">
				<ul>
					<li style="height:30px;">
						<div class="icon-phone"></div><p class="call-wst">服务热线：</p>
					</li>
					<li style="height:38px;">
						<?php if((WSTConf('CONF.serviceTel')!='')): ?><p class="email-wst"><?php echo WSTConf('CONF.serviceTel'); ?></p><?php endif; ?>
					</li>
					<li style="height:85px;">
						<div class="qr-code" style="position:relative;">
							<img src="__STYLE__/img/lqsj_qr_code.jpg" style="height:110px;">
							<div class="focus-wst">
							    <?php if((WSTConf('CONF.serviceQQ')!='')): ?>
								<p class="focus-wst-qr">在线客服：</p>
								<p class="focus-wst-qra">
						          <a href="tencent://message/?uin=<?php echo WSTConf('CONF.serviceQQ'); ?>&Site=QQ交谈&Menu=yes">
									  <img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo WSTConf('CONF.serviceQQ'); ?>:7" alt="QQ交谈" width="71" height="24" />
								  </a>
								</p>
          						<?php endif; if((WSTConf('CONF.serviceEmail')!='')): ?>
								<p class="focus-wst-qr">商城邮箱：</p>
								<p class="focus-wst-qre"><?php echo WSTConf('CONF.serviceEmail'); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</li>
				</ul>
			</div>


			<div class="wst-clear"></div>
		</div>

	    <div class="wst-footer-hp-ck3">
	        <div class="links">
	           <?php $navs = WSTNavigations(1); if(is_array($navs) || $navs instanceof \think\Collection): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
               <a href="<?php echo $vo['navUrl']; ?>" <?php if($vo['isOpen']==1): ?>target="_blank"<?php endif; ?>><?php echo $vo['navTitle']; ?></a>
               <?php if($i< count($navs)): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	        </div>
	        <div class="copyright">
	        <?php 
	        	if(WSTConf('CONF.mallFooter')!=''){
	         		echo htmlspecialchars_decode(WSTConf('CONF.mallFooter'));
	        	}
	         
				if(WSTConf('CONF.visitStatistics')!=''){
					echo htmlspecialchars_decode(WSTConf('CONF.visitStatistics'))."<br/>";
			    }
			 if(WSTConf('CONF.mallLicense') == ''): ?>
	        <div>
				
			</div>
			<?php else: ?>
				<div id="wst-mallLicense" data='1' style="display:none;"></div>
	        <?php endif; ?>
	        </div>
	    </div>
	</div>
</div>
<?php echo hook('initCronHook'); ?>



<script type="text/javascript" src="__STATIC__/plugins/slide/js/slide.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/shophome.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__STYLE__/js/qrcode.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
	if(<?php echo $data['list']['TotalPage']; ?>>1){
	laypage({
	    cont: 'shopPage',
	    pages: <?php echo $data['list']['TotalPage']; ?>, //总页数
	    curr: <?php echo $data['list']['CurrentPage']; ?>,
	    skip: true, //是否开启跳页
	    skin: '#fd6148',
	    groups: 3, //连续显示分页数
	   	prev: '<<',
		next: '>>',
	    jump: function(e, first){ //触发分页后的回调
	        if(!first){ //一定要加此判断，否则初始时会无限刷新
	        	var nuewurl = WST.splitURL("page");
	        	var ulist = nuewurl.split("?");
	        	if(ulist.length>1){
	        		location.href = nuewurl+'&page='+e.curr;
	        	}else{
	        		location.href = '?page='+e.curr;
	        	}
	            
	        }
	    }
	});
	}
	var qr = qrcode(10, 'M');
	var url = window.location.href;
	qr.addData(url);
	qr.make();
	$('#qrcode').html(qr.createImgTag());
});
</script>

</body>
</html>