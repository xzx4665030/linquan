<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shops\stockwarn\list.html";i:1494923930;s:66:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shops\base.html";i:1490282234;s:66:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\header_top.html";i:1493889699;s:62:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\footer.html";i:1493952747;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>库存预警 - 卖家中心<?php echo WSTConf('CONF.mallTitle'); ?></title>
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shop.css?v=<?php echo $v; ?>" rel="stylesheet">


<script type="text/javascript" src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>"></script>
	  
<script type='text/javascript' src='__STATIC__/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__ROOT__/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>'></script>
<script>
window.conf = {"ROOT":"__ROOT__","APP":"__APP__","STATIC":"__STATIC__","SUFFIX":"<?php echo config('url_html_suffix'); ?>", "SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","PHONE_VERFY":"<?php echo WSTConf('CONF.phoneVerfy'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","MESSAGE_BOX":"<?php echo WSTShopMessageBox(); ?>","ROUTES":'<?php echo WSTRoute(); ?>'}
	<?php echo WSTLoginTarget(1); ?>
$(function() {
	WST.initShopCenter();
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



	
<div class='wst-lite-bac'>
<div class='wst-lite-container'>
   <div class='wst-logo'><a href='<?php echo \think\Request::instance()->root(true); ?>'><img src="__ROOT__/<?php echo WSTConf('CONF.mallLogo'); ?>" height="80" width='160'></a></div>
   <div class="wst-lite-tit"><span>卖家中心</span><a class="wst-lite-in" href='<?php echo \think\Request::instance()->root(true); ?>'>返回商城首页</a></div>
   <div class="wst-lite-sea">
      <div class='search'>
      	  <input type="hidden" id="search-type" value="<?php echo isset($keytype)?1:0; ?>"/>

      	  <ul class="j-search-box">
            <li class="j-search-type">
              搜<span><?php if(isset($keytype)): ?>店铺<?php else: ?>商品<?php endif; ?></span>&nbsp;<i class="arrow"> </i>
            </li>
            <li class="j-type-list">
              <?php if(isset($keytype)): ?>
              <div data="0">商品</div>
              <?php else: ?>
              <div data="1">店铺</div>
              <?php endif; ?>
            </li>
          </ul>
          
	      <input type="text" id='search-ipt' class='search-ipt' value='<?php echo isset($keyword)?$keyword:""; ?>'/>
	      <div id='search-btn' class="search-btn" onclick='javascript:WST.search(this.value)'></div>
      </div>
   </div>
   <div class="wst-clear"></div>
</div>
<div class="wst-clear"></div>
</div>

<div class="wst-wrap">
          <div class='wst-header'>
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
				    <?php $homeMenus = WSTHomeMenus(1); if(is_array($homeMenus['menus']) || $homeMenus['menus'] instanceof \think\Collection): $i = 0; $__LIST__ = $homeMenus['menus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<a href="__ROOT__/<?php echo $vo['menuUrl']; ?>?homeMenuId=<?php echo $vo['menuId']; ?>"><li class="liselect wst-lfloat <?php if(($vo['menuId'] == $homeMenus['menuId1'])): ?>wst-nav-boxa<?php endif; ?>"><?php echo $vo['menuName']; ?></li></a>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="wst-clear"></div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
              <?php if(isset($homeMenus['menus'][$homeMenus['menuId1']]['list'])): if(is_array($homeMenus['menus'][$homeMenus['menuId1']]['list']) || $homeMenus['menus'][$homeMenus['menuId1']]['list'] instanceof \think\Collection): $i = 0; $__LIST__ = $homeMenus['menus'][$homeMenus['menuId1']]['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menus): $mod = ($i % 2 );++$i;?>
              	<span class='wst-menu-title'><?php echo $menus['menuName']; ?><img src="__STYLE__/img/user_icon_sider_zhankai.png"></span>
              	<ul>
                <?php if(isset($menus['list'])): if(is_array($menus['list']) || $menus['list'] instanceof \think\Collection): $k = 0; $__LIST__ = $menus['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($k % 2 );++$k;?>
                  	<li class="<?php if(($homeMenus['menuId3']==$menu['menuId'])): ?>wst-menua<?php endif; ?> wst-menuas" onclick="getMenus('<?php echo $menu['menuId']; ?>','<?php echo $menu['menuUrl']; ?>')">
                  	<?php echo $menu['menuName']; ?>
                  	<span id="mId_<?php echo $menu['menuId']; ?>"></span>
                  	</li>
                	<?php endforeach; endif; else: echo "" ;endif; endif; ?>
              	</ul>
              	<?php endforeach; endif; else: echo "" ;endif; endif; ?>
              
             
             
            </div>
            <div class='wst-content'>
            
<div class="wst-shop-head"><span>库存预警</span></div>
<div class="wst-shop-tbar">
  <label>
    商品分类：
    <select name="cat1" id="cat1" onchange="getCat(this.value)" class="s-query">
        <option value="">-请选择-</option>
      <?php $_result=WSTShopCats(0);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['catId']; ?>" ><?php echo $vo['catName']; ?></option>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
    <select name="cat2" id="cat2" class="s-query"><option value="">-请选择-</option></select>
    <a class="s-btn" onclick="stockByPage()" style='margin-top:5px;'>查询</a>
  </label>
</div>
<div class="wst-shop-content">
   <table class='wst-list'>
   <thead>
   <tr>
     <th width="220">商品名称</th>
     <th>货号</th>
     <th>规格</th>
     <th width="130">库存<font color='red'>(红色双击编辑)</font></th>
     <th width="130">预警<font color='red'>(红色双击编辑)</font></th>
     <th width="120">操作</th>
   </tr>
   </thead>
   <tbody id='list'></tbody>
   <tfoot>
     <tr align="center"><td colspan='10' id='pager' align="center" style='padding:5px 0px 5px 0px'></td></tr>
   </tfoot>
   <script id="tblist" type="text/html">
   {{# for(var i = 0; i < d.length; i++){ }}
   <tr>
      {{# if(d[i]['isSpec']==1) { }}
      <td>
          <div class="goods-img">
          <a href="{{WST.U("home/goods/detail","id="+d[i]['goodsId']+"&key="+d[i]['verfiycode'])}}">
            <img class='j-goodsImg'  data-original='__ROOT__/{{d[i].goodsImg}}'/>
          </a>
        </div>
        <p class="goodsName">
          {{WST.cutStr(d[i]['goodsName'],43)}}
        </p>
      </td>
        <td>{{d[i]['productNo']}}</td>
		<td>
		<span class="spec">
		{{# for(var s = 0; s < d[i].spec.length; s++){ }}
			{{d[i].spec[s]['catName']}}：{{d[i].spec[s]['itemName']}};
		{{# } }}
		</span>
		</td>
		<td width="40" ondblclick="javascript:toEditGoodsStock({{d[i]['id']}},1)">
        <input id="ipt_1_{{d[i]['id']}}" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)" onblur="javascript:editGoodsStock({{d[i]['id']}},1,{{d[i]['goodsId']}})" class="stockin" maxlength="6"/>
        <span id="span_1_{{d[i]['id']}}" style="display: inline;cursor:pointer;color:#f30505;">{{d[i]['goodsStock']}}</span>
        </td>
		<td width="40" ondblclick="javascript:toEditGoodsStock({{d[i]['id']}},2)">
        <input id="ipt_2_{{d[i]['id']}}" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)" onblur="javascript:editGoodsStock({{d[i]['id']}},2,{{d[i]['goodsId']}})" class="stockin" maxlength="6"/>
        <span id="span_2_{{d[i]['id']}}" style="display: inline;cursor:pointer;color:#f30505;">{{d[i]['warnStock']}}</span>
        </td>
      <td>
      	<a class="g-handle" href='javascript:toEdit({{d[i]['goodsId']}},"sale")'>编辑</a>
      	{{#if(d[i]['is_transfer']==1){}}
        <a class="g-handle" href='javascript:buhuo({{d[i]['goodsId']}},"1")'>补货</a>
        <a class="g-handle" href='javascript:buhuo({{d[i]['goodsId']}},"2")'>退货</a>
        {{#}else{}}
        {{#}}}
      	
      </td>
      {{# }else{ }}
      <td>
          <div class="goods-img">
          <a href="{{WST.U("home/goods/detail","id="+d[i]['goodsId']+"&key="+d[i]['verfiycode'])}}">
            <img class='j-goodsImg'  data-original='__ROOT__/{{d[i].goodsImg}}'/>
          </a>
        </div>
        <p class="goodsName">
          {{WST.cutStr(d[i]['goodsName'],43)}}
        </p>
      </td>
		<td>{{d[i]['productNo']}}</td>
		<td>无</td>
      {{# if(d[i]['goodsType']==0){ }}
		  <td width="40" ondblclick="javascript:toEditGoodsStock({{d[i]['goodsId']}},3)">
        <input id="ipt_3_{{d[i]['goodsId']}}" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)" onblur="javascript:editGoodsStock({{d[i]['goodsId']}},3)" class="stockin" maxlength="6"/>
        <span id="span_3_{{d[i]['goodsId']}}" style="display: inline;cursor:pointer;color:#f30505;">{{d[i]['goodsStock']}}</span>
        </td>
		  <td width="40" ondblclick="javascript:toEditGoodsStock({{d[i]['goodsId']}},4)">
        <input id="ipt_4_{{d[i]['goodsId']}}" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)" onblur="javascript:editGoodsStock({{d[i]['goodsId']}},4)" class="stockin" maxlength="6"/>
        <span id="span_4_{{d[i]['goodsId']}}" style="display: inline;cursor:pointer;color:#f30505;">{{d[i]['warnStock']}}</span>
        </td>
        {{# }else{ }}
        <td width="40">{{d[i]['goodsStock']}}</td>
        <td width="40">{{d[i]['warnStock']}}</td>
        {{#}}}
        <td>
        {{#if(d[i]['goodsType']==1){}}
        <a class="g-handle" href='javascript:toStock({{d[i]['goodsId']}},"stockWarnByPage")'>[进入卡券编辑]</a>
        {{#}else{}}
        <a class="g-handle" href='javascript:toEdit({{d[i]['goodsId']}},"sale")'>[进入商品编辑]</a>
        {{#}}}
        </td>
      
      {{# } }}
   </tr>
   {{# } }}
   </script>
  </table> 
</div>
<style type="text/css">
	.ylf_yc{position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;display: none;color: #858585;}
	.ylf_yc_b{width: 100%;height: 100%;background-color: rgba(190,190,190,0.6);}
	.ylf_yc_t{position: fixed;width: 700px;left: 50%;top: 50%;margin-top:-250px ;margin-left: -350px;background: #fff; border-radius:12px ; -moz-border-radius:12px;-webkit-border-radius:12px;overflow: hidden;}
	.ylf_bt{text-indent: 20px;height: 56px;line-height: 56px;background-color: #f8f8f8;border-bottom:1px solid #858585 ;font-size: 16px;}
	.ylf_div{margin: 20px 40px 25px 15px;font-size: 14px;}
	.ylf_div p{height: 40px;line-height: 40px;margin: 10px 0px;}
	.ylf_yc a{cursor: pointer;}
	.ylf_div .ylf_span{display: inline-block;width: 60px;vertical-align: top;text-align: right;margin-right: 10px;height: 40px;line-height: 40px;}
	.ylf_div textarea{resize:none;width: 560px;height: 75px;}
	#ylf_pe{margin-right: 30px;}
	#ylf_ge span{margin-right: 15px;}
	.ylf_an{margin: 25px;text-align: right;}
	.ylf_an a{display: inline-block;padding: 5px 15px;border-radius:5px ; -moz-border-radius:5px;-webkit-border-radius:5px;margin-right: 20px;}
	.ylf_an .ylf_queren{color: #fff;background: #e92e25;}
	.ylf_an .ylf_quxiao{color: #7e7e7e;background: #f0f0f0;}
</style>
<div class="ylf_yc">
	<div class="ylf_yc_b"></div>
	<div class="ylf_yc_t ddd">
		<p  class="ylf_bt sss"><span  class="ylf_bt_x">退货权限</span><a></a></p>
		<div class="ylf_div">
			<form>
				<p class="ylf_p">
					<span class="ylf_span">网点:</span>
					<span id="ylf_wd">123店铺</span>
				</p>
				<p>
					<span class="ylf_span">申请人:</span><span id="ylf_pe"></span>
					<span class="ylf_span ylf_sl_x">退货数量:</span><input id="ylf_sl" type="text" />
				</p>
				<p>
					<span class="ylf_span">退货商品:</span><span id="ylf_sp"></span>
				</p>
				<p>
					<span class="ylf_span">规格:</span><span id="ylf_ge"></span>
				</p>
				<div>
					<span class="ylf_span">备注:</span><textarea id="beizhu"></textarea>
				</div>
			</form>
		</div>
		<div class="ylf_an">
			<a class="ylf_queren">确认</a>
			<a class="ylf_quxiao">取消</a>
		</div>
	</div>
</div>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
        </div>

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


<script type='text/javascript' src='__STYLE__/shops/stockwarn/stockwarn.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__STYLE__/shops/stockwarn/tuozhuai.js?v=<?php echo $v; ?>'></script>

<script>
function getMenus(menuId,menuUrl){
    $.post(WST.U('home/index/getMenuSession'), {menuId:menuId}, function(data){
    	location.href=WST.U(menuUrl);
    });
}
</script>
</body>
</html>