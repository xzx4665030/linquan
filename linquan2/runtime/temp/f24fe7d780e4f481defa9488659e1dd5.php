<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\phpStudy\WWW\linquan2\addons\thirdlogin\view/home/index/login.html";i:1488332808;}*/ ?>
<?php if(isset($thirdLogins['thirdTypes'])){ ?>
<div style="padding-left:46px;">
	 <span class="wst-login-three">您还可以使用以下方式登录：</span>
		<?php if(in_array("qq",$thirdLogins['thirdTypes']) ){ ?>
			<a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=<?php echo $thirdLogins['appId_qq']; ?>&redirect_uri=<?php echo $thirdLogins['backUrl_qq']; ?>" class="qq">
				<img src="__ROOT__<?php echo $thirdLogins['img_qq']; ?>" alt="QQ登录" border="0" style="width:40px;">&nbsp;&nbsp;
			</a>
		<?php } if(in_array("weixin",$thirdLogins['thirdTypes'])){ ?>
			<a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?php echo $thirdLogins['appId_weixin']; ?>&redirect_uri=<?php echo $thirdLogins['backUrl_weixin']; ?>&response_type=code&scope=snsapi_login&state=<?php echo time();?>#wechat_redirect" class="qq">
				<img src="__ROOT__<?php echo $thirdLogins['img_weixin']; ?>" alt="微信登录" border="0" style="width:40px;">&nbsp;&nbsp;
			</a>
		<?php } if(in_array("weibo",$thirdLogins['thirdTypes'])){ ?>
			<a href="https://api.weibo.com/oauth2/authorize?client_id=<?php echo $thirdLogins['appId_weibo']; ?>&response_type=code&redirect_uri=<?php echo $thirdLogins['backUrl_weibo']; ?>" class="qq">
				<img src="__ROOT__<?php echo $thirdLogins['img_weibo']; ?>" alt="微博登录" border="0" style="width:40px;">&nbsp;&nbsp;
			</a>
		<?php } ?>
</div>
<?php } ?>
		 